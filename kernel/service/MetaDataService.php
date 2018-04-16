<?php
/**
 * Created by IntelliJ IDEA.
 * User: Apollo
 * Date: 2018/4/15
 * Time: 下午9:08
 */

namespace Kernel\service;

use Phalcon\Mvc\Model\Metadata\Memory;


class MetaDataService extends Memory implements ServiceInterface
{
    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}