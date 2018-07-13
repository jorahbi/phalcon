<?php

namespace Kernel\Bin\Helper;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Comparator;
use Kernel\Bin\Commands\SchemaCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 命令行数据库基本操作
 */
class SchemaActionHelper
{
    protected static $schema;
    protected static $platform;
    protected static $connection;
    protected static $output;

    /**
     * 初始化
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public static function init(InputInterface $input, OutputInterface $output)
    {
        SchemaHelper::init($input, $output);
        self::$output = $output;

        try {
            self::$connection = SchemaHelper::getDbalConnection(
                $input->getArgument(SchemaCommand::DB)
            );
            self::$schema = SchemaHelper::getSchema(
                $input->getOption(SchemaCommand::OPTION_TABLE),
                $input->getArgument(SchemaCommand::MODULE)
            );
            self::$platform = self::$connection->getDatabasePlatform();
        }catch (DBALException $e) {
            self::$output->writeln(sprintf(' <error>%s</error>', $e->getMessage()));
            die(1);
        }
    }

    /**
     * 删除操作
     * @param InputInterface $input
     * @return []
     */
    public static function drop(InputInterface $input)
    {
        return self::$schema->toDropSql(self::$platform);
    }

    /**
     * 迁移
     * @param InputInterface $input
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
     * @param InputInterface $input
     * @return []
     */
    public static function create(InputInterface $input)
    {
        return self::$schema->toSql(self::$platform);
    }

    /**
     * 迁移到
     * @param InputInterface $input
     * @return []
     */
    public static function migrateFrom(InputInterface $input)
    {
        $fromSchema = SchemaHelper::createSchemaFromDir($input->getArgument(SchemaCommand::TARGET));
        if (empty($fromSchema->getTables())) {
            self::$output->writeln(sprintf('  > <error>%s</error>', 'empty target schema'));
            die(1);
        }
        $schemaDiff = (new Comparator())->compare($fromSchema, self::$schema);

        return $schemaDiff->toSaveSql(self::$platform);
    }
}
