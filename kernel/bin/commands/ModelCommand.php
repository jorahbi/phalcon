<?php

namespace Kernel\Bin\Commands;

use Kernel\bin\helper\ModelHelper;
use Phalcon\Text;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelCommand extends Command
{
    const MODULE = 'module-name';
    const TABLE = 'table';

    protected function configure()
    {
        parent::configure();
        $this->setName('orm:model')
            ->setDescription('generate model')
            ->addArgument(self::MODULE, InputArgument::REQUIRED, 'module name')
            ->addArgument(self::TABLE, InputArgument::REQUIRED, 'table');
        //->addOption(self::OPTION_MODULE, null, InputOption::VALUE_REQUIRED, '模块名');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $module = $input->getArgument(self::MODULE);
        $table = $input->getArgument(self::TABLE);
        ModelHelper::build($module, $table);
        $msg = 'abstract Model "%s" was successfully created.';
        $output->writeln(sprintf($msg, Text::camelize($table, '_-')));
    }

}
