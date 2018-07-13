<?php

use Phalcon\Cli\Task;

class TestTask extends Task
{
    public function mainAction($params)
    {
        print_r($params);
        die('main');
    }
}