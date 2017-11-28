<?php

namespace Service\Swoole\Server;

use Phalcon\Mvc\Application;
use Common\Service;
use Common\Routers;
use Common\Loader;

class Httpd
{
    public static $instance;
    private $http;
    private $application;
    public static $container;
    /**
     * 初始化
     */
    public function __construct()
    {
        define('BASE_PATH', dirname(dirname(dirname(dirname(__DIR__)))));
        define('APP_PATH', BASE_PATH . '/app');
        define('MODULES_PATH', APP_PATH . '/modules');

        // 创建swoole_http_server对象
        $this->http = new \Swoole\Http\Server('127.0.0.1', 9502);
        // 设置参数
        $this->http->set(
            array(
                'worker_num'    => 16,
                'deamonize'     => false,
                'max_request'   => 10000,
                //'task_worker_num' => 2, //设置task worker数量
                'dispatch_mode'   => 3,
                'log_file'        => BASE_PATH . '/cache/log/HttpServer.log',
            )
        );


        $loader = new \Phalcon\Loader();
        $loader->registerFiles([
            APP_PATH . '/common/Loader.php',
            BASE_PATH . '/vendor/autoload.php'
        ]);
        $loader->register();
        
        Loader::initialize($loader);
        Routers::initialize();
        self::$container = Service::getContainer();
        $this->application = new Application(self::$container);
        
        /**
         * Register application modules
         */
        $this->application->registerModules(Loader::getModules());


        // 绑定WorkerStart
        $this->http->on('WorkerStart', array($this, 'onWorkStart'));
        // 绑定request
        $this->http->on('request', array($this, 'onRequest'));
        // 绑定task
        $this->http->on('task', array($this, 'onTask'));
        // 绑定finish
        $this->http->on('finish', array($this, 'onFinish'));
        // 开启服务器
        $this->http->start();
    }
    /**
     * WorkStart 回调
     */
    public function onWorkStart(\Swoole\Server $server, int $worker_id) 
    {
        
        
    }
    /**
     * 处理http请求
     */
    public function onRequest($request, $response)
    {
        //注册捕获错误函数
        register_shutdown_function(array($this, 'handleFatal'));
        $_SERVER = $request->server;
        //构造url请求路径,phalcon获取到$_GET['_url']时会定向到对应的路径，否则请求路径为'/'
        $_SERVER['REQUEST_URI'] = $request->server['request_uri'];
        if ($request->server['request_method'] == 'GET' && isset($request->get)) {
            foreach ($request->get as $key => $value) {
                $_GET[$key] = $value;
                $_REQUEST[$key] = $value;
            }
        }
        if ($request->server['request_method'] == 'POST' && isset($request->post) ) {
            foreach ($request->post as $key => $value) {
                $_POST[$key] = $value;
                $_REQUEST[$key] = $value;
            }
        }
        //处理请求
        //print_r($request);
        $body = '';
        try {
            $body = $this->application->handle()->getContent();
        } catch (Exception $e) {
            $body = $e->getMessage();
        }
        $response->end($body);
    }
    /**
     * 处理task任务
     */
    public function onTask($serv, $task_id, $from_id, $data)
    {
        echo "[" . microtime(true) . "]This Task {$task_id} from Worker {$from_id}\n";
        echo "[".date('Y-m-d H:i:s')."] This Task {$task_id} from Worker {$from_id}\n";
        echo "This data {$data} from Worker {$from_id}\n";
    }
    /**
     * task 完成回调
     */
    public function onFinish($serv,$taskId, $data)
    {
        echo "Task {$taskId} finish\n";
        echo "Result: {$data}\n";
    }
    /**
     * 获取实例对象
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Httpd();
        }
        return self::$instance;
    }
    /**
     * 捕获Server运行期致命错误
     */
    public function handleFatal()
    {
        $error = error_get_last();
        if (isset($error['type'])) {
            switch ($error['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                    $message = $error['message'];
                    $file    = $error['file'];
                    $line    = $error['line'];
                    $log     = "$message ($file:$line)\nStack trace:\n";
                    $trace   = debug_backtrace();
                    foreach ($trace as $i => $t) {
                        if (!isset($t['file'])) {
                            $t['file'] = 'unknown';
                        }
                        if (!isset($t['line'])) {
                            $t['line'] = 0;
                        }
                        if (!isset($t['function'])) {
                            $t['function'] = 'unknown';
                        }
                        $log .= "#$i {$t['file']}({$t['line']}): ";
                        if (isset($t['object']) and is_object($t['object'])) {
                            $log .= get_class($t['object']) . '->';
                        }
                        $log .= "{$t['function']}()\n";
                    }
                    if (isset($_SERVER['REQUEST_URI'])) {
                        $log .= '[QUERY] ' . $_SERVER['REQUEST_URI'];
                    }
                    //error_log($log);
                    //$serv->send($this->currentFd, $log);
                    //$this->application->logger->info('error log: ' . $log);
                    //$this->response->end($this->currentFd . '_' . $log);
                default:
                    break;
            }
        }
    }
}

\Service\Swoole\Server\Httpd::getInstance();