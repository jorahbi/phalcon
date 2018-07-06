<?php

namespace Kernel\Bin\Helper;

use Doctrine\ORM\ORMException;
use Kernel\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Version;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\EntityGenerator;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

class Bootstrap extends ConsoleRunner
{
    /**
     * Creates a console application with the given helperset and
     * optional commands.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet
     * @param array $commands
     *
     * @return \Symfony\Component\Console\Application
     */
    public static function createApplication(HelperSet $helperSet, $commands = array())
    {
        $cli = new Application('Doctrine Command Line Interface', Version::VERSION);
        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);
        self::addCommands($cli);
        $cli->addCommands($commands);

        return $cli;
    }

    /**
     * @param Application $cli
     *
     * @return void
     */
    public static function addCommands(Application $cli)
    {
        $cli->addCommands([
            // DBAL Commands
            new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
            new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

            // ORM Commands
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
            new \Kernel\Bin\Commands\SchemaCommand(),
            new \Kernel\Bin\Commands\ConvertMappingCommand(),
            new \Kernel\Bin\Commands\GenerateRepositoriesCommand(),
            new \Kernel\Bin\Commands\GenerateEntitiesCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
            new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
            new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
        ]);
    }

    public static function getEntityManager()
    {
        //$isDevMode = true;
        //$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
        // or if you prefer yaml or annotations
        //$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
        //$config = Setup::createYAMLMetadataConfiguration([YML_DIRECTORY], IS_DEBUG);
        $dbConf = Container::getService('config')->getConfig()->database;
        $modules = Container::getService('config')->getConfig()->modules;
        $schemaPath = [];
        foreach ($modules as $key => $module) {
            $schemaPath[] = APP_PATH . '/' . $key . '/schema';
        }
        try{
            return \Doctrine\ORM\EntityManager::create([
                    'driver' => 'pdo_mysql,',//$dbConf->adapter,
                    'user' => $dbConf->username,
                    'password' => $dbConf->password,
                    'host' => $dbConf->host,
                    'dbname' => $dbConf->dbname
                ],
                Setup::createYAMLMetadataConfiguration($schemaPath, true)
            );
        }catch(ORMException $e){
            die($e->getMessage());
        }
    }

    /**
     * Runs console with the given helperset.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet  $helperSet
     * @param \Symfony\Component\Console\Command\Command[] $commands
     *
     * @return void
     */
    static public function run(HelperSet $helperSet, $commands = array())
    {
        try {
            $cli = self::createApplication($helperSet, $commands);
            $cli->run();
        }catch (\Exception $e) {

        }
    }

    public static function start()
    {
        $helperSet = parent::createHelperSet(self::getEntityManager());
        self::run($helperSet);
    }
}