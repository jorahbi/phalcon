<?php

namespace Common\Bin\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SchemaCommand extends Command
{
    const MODE              = 'mode';
    const TARGET            = 'target';
    const MODE_CREATE       = 'create';
    const MODE_MIGRATE      = 'migrate';
    const MODE_DROP         = 'drop';
    const MODE_MIGRATE_FROM = 'migrate-from';
    const OPTION_EXEC       = 'exec';
    const OPTION_TABLE      = 'table';
    const OPTION_DB         = 'db';
    const OPTION_MODULE     = 'module-name';

    protected function configure()
    {
        parent::configure();
        $this->setName('schema')
            ->setDescription('generate/run schema sql')
            ->addArgument(self::MODE, InputArgument::OPTIONAL, 'drop|create|migrate|migrate-from', self::MODE_MIGRATE)
            ->addArgument(self::TARGET, InputArgument::OPTIONAL, '<target>', '')
            ->addOption(self::OPTION_EXEC, null, null, '直接执行')
            ->addOption(self::OPTION_MODULE, null, InputOption::VALUE_REQUIRED, '模块名')
            ->addOption(self::OPTION_TABLE, null, InputOption::VALUE_REQUIRED, '表名')
            ->addOption(self::OPTION_DB, null, InputOption::VALUE_REQUIRED, '库名');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $actionTmp = explode('-', $input->getArgument(self::MODE));
        $action    = '';
        foreach ($actionTmp as $key => $value) {
            $action .= ucfirst(trim($value));
        }
        $action = lcfirst($action);

        if (!method_exists('\\Common\\Bin\\Helper\\SchemaActionHelper', $action)) {
            throw new \Exception('unimplemented');
        }

        \Common\Bin\Helper\SchemaActionHelper::init($input);
        $sqls = call_user_func_array('\\Common\\Bin\\Helper\\SchemaActionHelper::' . $action, [$input]);

        if (!$input->getOption(self::OPTION_EXEC)) {
            exit(implode(";\n----\n", $sqls) . PHP_EOL);
        }
        $pdo = \CommandHelper::getService('commandDb');
        foreach ($sqls as $sql) {
            echo "> running sql:", PHP_EOL, $sql, PHP_EOL;
            $pdo->query($sql);
        }
        exit('> done' . PHP_EOL);
    }
}
