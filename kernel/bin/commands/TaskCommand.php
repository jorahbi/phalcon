<?php

namespace Kernel\Bin\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kernel\Container;
use Phalcon\Cli\Console as ConsoleApp;

class TaskCommand extends Command
{
    const CONTROLLER = 'task';
    const ACTION = 'action';
    const PARAMS = 'params';

    protected function configure()
    {
        parent::configure();
        $this->setName('task')
            ->setDescription('run task')
            ->addArgument(self::CONTROLLER, InputArgument::OPTIONAL, 'task name')
            ->addArgument(self::ACTION, InputArgument::OPTIONAL, 'handle action', 'main')
            ->addOption(self::PARAMS, null, null, 'params');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $console = new ConsoleApp();
        $test = Container::getContainer();
        $console->setDI($test);
        $params = [
            'task' => $input->getArgument('task'),
            'action' => $input->getArgument('action'),
            'params' => []
        ];
        try {
            $console->handle($params);
        } catch (\Phalcon\Exception $e) {
            print_r($e->getMessage());
        }

    }
}
