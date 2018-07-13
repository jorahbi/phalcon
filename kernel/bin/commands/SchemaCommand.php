<?php

namespace Kernel\Bin\Commands;

use Kernel\Bin\Helper\SchemaActionHelper;
use Kernel\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SchemaCommand extends Command
{
    const MODE = 'mode';
    const TARGET = 'target';
    const MODE_CREATE = 'create';
    const MODE_MIGRATE = 'migrate';
    const MODE_DROP = 'drop';
    const MODE_MIGRATE_FROM = 'migrate-from';
    const OPTION_EXEC = 'exec';
    const OPTION_TABLE = 'table';
    const DB = 'db-config';
    const MODULE = 'module-name';
    const DEFAULT_DB = 'database';

    protected function configure()
    {
        parent::configure();
        $this->setName('orm:schema')
            ->setDescription('generate/run schema sql')
            ->addArgument(self::MODE, InputArgument::REQUIRED, 'drop|create|migrate|migrate-from')
            ->addArgument(self::MODULE, InputArgument::REQUIRED, 'module name')
            ->addArgument(self::DB, InputArgument::OPTIONAL, 'db config', self::DEFAULT_DB)
            ->addOption(self::TARGET, null, InputOption::VALUE_REQUIRED, '<target>')
            ->addOption(self::OPTION_EXEC, null, null, '直接执行')
            ->addOption(self::OPTION_TABLE, null, InputOption::VALUE_REQUIRED, '表名');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $actionTmp = explode('-', $input->getArgument(self::MODE));
        $action = '';
        foreach ($actionTmp as $key => $value) {
            $action .= ucfirst(trim($value));
        }
        $action = lcfirst($action);
        if (!method_exists('\\Kernel\\Bin\\Helper\\SchemaActionHelper', $action)) {
            $output->writeln(sprintf('  > <error>%s</error>', 'command not found'));
            return 1;
        }

        SchemaActionHelper::init($input, $output);
        $sqls = call_user_func_array('\\Kernel\\Bin\\Helper\\SchemaActionHelper::' . $action, [$input]);

        if (!$input->getOption(self::OPTION_EXEC)) {
            exit(implode(";\n----\n", $sqls) . PHP_EOL);
        }
        $pdo = Container::getService('db');
        foreach ($sqls as $sql) {
            echo "> running sql:", PHP_EOL, $sql, PHP_EOL;
            $pdo->query($sql);
        }
        exit('> done' . PHP_EOL);
    }
}
