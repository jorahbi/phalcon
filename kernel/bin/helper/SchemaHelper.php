<?php

namespace Kernel\Bin\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Exception\RuntimeException;

/**
 * 数据库命令行操作帮助类
 */
class SchemaHelper
{
    /**
     * 获取数据需要操作的数据表
     * @param String $tableName
     * @param String $moduleName
     * @return Doctrine\DBAL\Schema\Schema
     */
    public static function getSchema($tableName, $moduleName)
    {
        $config = \CommandContainer::getInstance()->getService('config');
        $dir    = $config->application->appDir . $moduleName . '/schema';
        if(!is_dir($dir)){
            throw new RuntimeException(sprintf('lncorrect "%s" file path.', $moduleName));
        }
        if ($tableName) {
            return self::createTableFromFile($dir . '/' . $tableName . '.yml');
        }
        return self::createSchemaFromDir($dir);
    }

    /**
     * 获取文件夹下所有需要操作的数据表
     * @param String $dir
     * @return Doctrine\DBAL\Schema\Schema
     */
    public static function createSchemaFromDir($dir)
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
     * @return Doctrine\DBAL\Schema\Schema
     */
    public static function createTableFromFile($file, Schema $schema = null)
    {

        $yml = file_get_contents($file);
        try {
            $r = Yaml::parse($yml);
        } catch (ParseException $e) {
            throw new \Exception(sprintf('yaml parse error at "%s": %s', basename($file), $e->getMessage()));
        }

        if (!isset($r['name']) || !isset($r['columns'])) {
            throw new \Exception(sprintf('bad yaml file "%s": %s', basename($file), json_encode($r)));
        }

        return self::addTable($r, $schema);
    }

    /**
     * yml文件转换成 Doctrine\DBAL\Schema\Schema
     * @param $r
     * @param Doctrine\DBAL\Schema\Schema $schema
     * @return Doctrine\DBAL\Schema\Schema
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
                $flags  = isset($idx['flags']) ? $idx['flags'] : [];
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
     * @param $dbname
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getDbalConnection($dbname)
    {
        $connection = DriverManager::getConnection([
            'pdo'    => \CommandContainer::getInstance()->getService('commandDb'),
            'dbname' => $dbname,
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
