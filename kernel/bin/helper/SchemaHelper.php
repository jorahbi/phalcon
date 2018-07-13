<?php

namespace Kernel\Bin\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;
use Kernel\Container;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * 数据库命令行操作帮助类
 */
class SchemaHelper
{

    protected static $output;
    protected static $input;
    /**
     * 初始化
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public static function init(InputInterface $input, OutputInterface $output)
    {
        self::$output = $output;
        self::$input = $input;
    }

    public static function dbConfig(string $db)
    {
        $config = Container::getService('config')->getConfig();
        if (property_exists($config, $db)) {
            return $config->{$db};
        }
        throw new InvalidArgumentException(sprintf('%s parameter is invalid', $db));
    }

    /**
     * @param array $config
     * @return \PDO
     */
    protected static function getConnect(Array $config)
    {
        return new \PDO(
            "mysql:dbname={$config['dbname']};host={$config['host']}",
            $config['username'],
            $config['password']
        );
    }

    /**
     * 获取数据需要操作的数据表
     * @param String $tableName
     * @param String $moduleName
     * @return Schema
     */
    public static function getSchema($tableName, $moduleName)
    {

        $dir = APP_PATH . '/' . $moduleName . '/schema';
        if (!is_dir($dir)) {
            self::$output->writeln(sprintf('  > writing <error>lncorrect "%s" file path.</error>', $moduleName));
            die(1);
        }
        if (!empty($tableName)) {
            return self::createTableFromFile($dir . '/' . $tableName . '.yml');
        }
        return self::createSchemaFromDir($dir);

    }

    /**
     * 获取文件夹下所有需要操作的数据表
     * @param String $dir
     * @return Schema
     */
    public static function createSchemaFromDir($dir): Schema
    {

        $schema = new Schema();

        foreach (glob($dir . '/*.yml') as $file) {
            self::createTableFromFile($file, $schema);
        }

        return $schema;
    }

    /**
     * 获取单个需要操作的数据表
     * @param String $dir
     * @return Schema
     */
    public static function createTableFromFile($file, Schema $schema = null)
    {

        try {
            $yml = file_get_contents($file);
            $r = Yaml::parse($yml);
            if (!isset($r['name']) || !isset($r['columns'])) {
                throw new \Exception(sprintf('bad yaml file "%s": %s', basename($file), json_encode($r)));
            }
        } catch (\Exception $e) {
            self::$output->writeln(sprintf('  > writing <error>%s</error>', $e->getMessage()));
            die(1);
        }

        return self::addTable($r, $schema);
    }

    /**
     * yml文件转换成 Doctrine\DBAL\Schema\Schema
     * @param $r
     * @param Schema $schema
     * @return Schema
     */
    public static function addTable($r, Schema $schema = null)
    {
        if (!$schema) {
            $schema = new Schema();
        }

        $table = $schema->createTable($r['name']);
        foreach ($r['columns'] as $col) {
            $option = isset($col['option']) ? $col['option'] : [];

            if (isset($col['comment'])) {
                $option['comment'] = $col['comment'];
            }

            $table->addColumn($col['name'], $col['type'], $option);
        }

        if (isset($r['indexes'])) {
            foreach ($r['indexes'] as $idx) {
                $name = isset($idx['name']) ?
                    $idx['name'] :
                    self::getIndexName($r['name'], $idx['columns']);
                $flags = isset($idx['flags']) ? $idx['flags'] : [];
                $option = isset($idx['option']) ? $idx['option'] : [];

                if (isset($idx['comment'])) {
                    $option['comment'] = $idx['comment'];
                }

                if (isset($idx['unique']) && $idx['unique']) {
                    $table->addUniqueIndex($idx['columns'], $name, $option);
                } else {
                    $table->addIndex($idx['columns'], $name, $flags, $option);
                }
            }
        }
        if (isset($r['pk'])) {
            $table->setPrimaryKey($r['pk']);
        }

        if (isset($r['charset'])) {
            $table->addOption('charset', $r['charset']);
        }
        if (isset($r['collate'])) {
            $table->addOption('collate', $r['collate']);
        }

        return $schema;
    }

    /**
     * 获取数据连接 PDO
     * @param $db
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getDbalConnection(string $db)
    {
        $dbConfig = SchemaHelper::dbConfig($db)->toArray();
        $connection = DriverManager::getConnection([
            'pdo' => self::getConnect($dbConfig),
            'dbname' => $dbConfig['dbname'],
        ]);
        /**
         * @link http://doctrine-orm.readthedocs.org/en/latest/cookbook/mysql-enums.html
         */
        $connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        return $connection;
    }

    /**
     * 创建索引名称
     * @param string $tableName
     * @param string $cols
     * @return string
     */
    protected static function getIndexName($tableName, $cols)
    {
        return 'idx_' . base_convert(crc32(json_encode([$tableName, $cols])), 10, 36);
    }
}
