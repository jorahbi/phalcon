<?php

namespace Core\Bin\Helper;

use Doctrine\DBAL\Schema\Schema;
use Core\Bin\Commands\SchemaCommand;
use Doctrine\DBAL\Schema\Comparator;
use Symfony\Component\Console\Input\InputInterface;

/**
 * 命令行数据库基本操作
 */
class SchemaActionHelper
{
	protected static $schema;
	protected static $platform;
	protected static $connection;

	/**
	 * 初始化
	 * @param Symfony\Component\Console\Input\InputInterface $input
	 */
	public static function init(InputInterface $input)
	{
		self::$connection = SchemaHelper::getDbalConnection(
			$input->getOption(SchemaCommand::OPTION_DB)
		);
		self::$schema = SchemaHelper::getSchema(
			$input->getOption(SchemaCommand::OPTION_TABLE), 
			$input->getOption(SchemaCommand::OPTION_MODULE)
		);
		self::$platform = self::$connection->getDatabasePlatform();
	}

	/**
	 * 删除操作
	 * @param Symfony\Component\Console\Input\InputInterface $input
	 * @return []
	 */
	public static function drop(InputInterface $input)
	{
		return self::$schema->toDropSql(self::$platform);
	}

	/**
	 * 迁移
	 * @param Symfony\Component\Console\Input\InputInterface $input
	 * @return []
	 */
	public static function migrate(InputInterface $input)
	{
    	$comparator = new Comparator();
        $schemaDiff = $comparator->compare(self::$connection->getSchemaManager()->createSchema(), self::$schema);
        return $schemaDiff->toSaveSql(self::$platform);
	}

	/**
	 * 创建
	 * @param Symfony\Component\Console\Input\InputInterface $input
	 * @return []
	 */
	public static function create(InputInterface $input)
	{
		return self::$schema->toSql(self::$platform);
	}

	/**
	 * 迁移到
	 * @param Symfony\Component\Console\Input\InputInterface $input
	 * @return []
	 */
	public static function migrateFrom()
	{
        $fromSchema = SchemaHelper::createSchemaFromDir($input->getArgument(SchemaCommand::TARGET));
        if (empty($fromSchema->getTables())) 
        {
            throw new \Exception('empty target schema');
        }
        $schemaDiff = (new Comparator())->compare($fromSchema, $schema);

        return $schemaDiff->toSaveSql(self::$platform);
	}
}