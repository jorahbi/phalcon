<?php

namespace Kernel\Bin\Commands;

use Kernel\bin\helper\ModelHelper;
use Kernel\Container;
use Phalcon\Text;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelAllCommand extends Command
{
    const OPTION_DB = 'db';
    const MODULE = 'module-name';

    protected function configure()
    {
        parent::configure();
        $this->setName('orm:model-all')
            ->setDescription('generate all model')
            ->addArgument(self::MODULE, InputArgument::REQUIRED, 'module name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $module = $input->getArgument(self::MODULE);
        $tableList = Container::getService('db')->listTables(ModelHelper::getSchema());

        foreach ($tableList as $table) {
            ModelHelper::build($module, $table);
            $msg = 'abstract Model "%s" was successfully created.';
            $output->writeln(sprintf($msg, Text::camelize($table, '_-')));
        }

    }

}
