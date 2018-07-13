<?php


namespace Kernel\bin\helper;


use Kernel\Container;
use Phalcon\Db\Column;
use Phalcon\Db\ReferenceInterface;
use Phalcon\Text;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;

class ModelHelper
{
    const EXTENDS = 'AbstractEntity';

    private static $snippet;
    private static $db;
    private static $schema;
    private static $table;
    private static $utils;

    public static function build(string $moduleName, string $table)
    {
        self::$schema = self::getSchema();
        self::$table = $table;
        self::$snippet = new SnippetHelper();
        self::$db = Container::getService('db');
        self::$utils = Container::getService('utils');

        $className = self::$utils->lowerCamelizeWithDelimiter($table, '_-');

        $namespace = self::getNamespace($moduleName);
        $path = APP_PATH . '/' . $moduleName . '/entity/' . $className . '.php';

        $alreadyInitialized = false;
        $alreadyValidations = false;
        $alreadyFind = false;
        $alreadyFindFirst = false;
        $alreadyGetSourced = false;

        $fields = self::$db->describeColumns($table, self::$schema);

        $validations = self::validations($fields);
        $initialize = self::initFunc($namespace);
        list($attributes, $getters, $setters) = self::fields($fields);
        $validationsCode = '';
        if ($alreadyValidations == false && count($validations) > 0) {
            $validationsCode = self::$snippet->getValidationsMethod($validations);
            $uses[] = self::$snippet->getUse(Validation::class);
        }

        $initCode = '';
        if ($alreadyInitialized == false && count($initialize) > 0) {
            $initCode = self::$snippet->getInitialize($initialize);
        }

        $license = '';
        if (file_exists('license.txt')) {
            $license = trim(file_get_contents('license.txt')) . PHP_EOL . PHP_EOL;
        }
        $methodRawCode = [];
        if (false == $alreadyGetSourced) {
            $methodRawCode[] = self::$snippet->getModelSource($table);
        }

        if (false == $alreadyFind) {
            $methodRawCode[] = self::$snippet->getModelFind($className);
        }

        if (false == $alreadyFindFirst) {
            $methodRawCode[] = self::$snippet->getModelFindFirst($className);
        }

        $content = join('', $attributes);
        $content .= join('', $setters) . join('', $getters);


        $content .= $validationsCode . $initCode;
        foreach ($methodRawCode as $methodCode) {
            $content .= $methodCode;
        }

        $classDoc = self::$snippet->getClassDoc($className, $namespace);

        $useDefinition = '';
        if (!empty($uses)) {
            usort($uses, function ($a, $b) {
                return strlen($a) - strlen($b);
            });

            $useDefinition = join("\n", $uses) . PHP_EOL . PHP_EOL;
        }

        $abstract = 'abstract ';

        $code = self::$snippet->getClass($namespace, $useDefinition, $classDoc, $abstract, $className, self::EXTENDS, $content, $license);

        return self::generate($code, $path);

    }

    public static function getSchema()
    {
        $config = Container::getService('config')->getConfig()->database->dbname;
        return $config;
    }

    protected static function modelExists(string $modelPath)
    {
        $result = [];
        return $result;
    }


    protected static function generate(string $code, string $modelPath)
    {
        if (file_exists($modelPath) && !is_writable($modelPath)) {
            throw new RuntimeException(sprintf('Unable to write to %s. Check write-access of a file.', $modelPath));
        }

        if (!file_put_contents($modelPath, $code)) {
            throw new RuntimeException(sprintf('Unable to write to %s', $modelPath));
        }
        return true;
    }

    protected static function fields(Array $fields)
    {
        $attributes = [];
        $setters = [];
        $getters = [];
        $exclude = self::exclude();
        $_typeMap = [];
        foreach ($fields as $field) {
            if (array_key_exists(strtolower($field->getName()), $exclude)) {
                continue;
            }
            $type = self::getPHPType($field->getType());
            $fieldName = self::$utils->lowerCamelizeWithDelimiter($field->getName(), '_-', true);

            $attributes[] = self::$snippet->getAttributes($type, 'protected', $field, true, $fieldName);

            $methodName = self::$utils->camelize($field->getName(), '_-');
            $setters[] = self::$snippet->getSetter($fieldName, $type, $methodName);

            if (isset($_typeMap[$type])) {
                $getters[] = self::$snippet->getGetterMap($fieldName, $type, $methodName, $_typeMap[$type]);
            } else {
                $getters[] = self::$snippet->getGetter($fieldName, $type, $methodName);
            }

        }
        return [$attributes, $getters, $setters];
    }

    protected static function getNamespace(string $moduleName)
    {
        $modules = Container::getService('config')->getConfig()->modules->toArray();

        if (!array_key_exists($moduleName, $modules)) {
            throw new InvalidArgumentException(sprintf('%s parameter is invalid', $moduleName));
        }
        $moduleName = ucfirst($moduleName);
        return "namespace {$moduleName}\Entity;" . PHP_EOL . PHP_EOL;
    }

    protected static function getEntityClassName(ReferenceInterface $reference, $namespace)
    {
        $referencedTable = self::$utils->camelize($reference->getReferencedTable());
        return "{$namespace}\\{$referencedTable}";

    }

    protected static function validations(Array $fields)
    {
        $validations = [];
        foreach ($fields as $field) {
            if ($field->getType() === Column::TYPE_CHAR) {
                $fieldName = self::$utils->lowerCamelize(self::$utils->camelize($field->getName(), '_-'));

                $domain = [];
                if (preg_match('/\((.*)\)/', $field->getType(), $matches)) {
                    foreach (explode(',', $matches[1]) as $item) {
                        $domain[] = $item;
                    }
                }
                if (count($domain)) {
                    $varItems = join(', ', $domain);
                    $validations[] = self::$snippet->getValidateInclusion($fieldName, $varItems);
                }
            }
            if ($field->getName() == 'email') {
                $fieldName = self::$utils->lowerCamelize(self::$utils->camelize($field->getName(), '_-'));

                $validations[] = self::$snippet->getValidateEmail($fieldName);
                $uses[] = self::$snippet->getUseAs(EmailValidator::class, 'EmailValidator');
            }
        }
        if (count($validations)) {
            $validations[] = self::$snippet->getValidationEnd();
        }
        return $validations;
    }

    protected static function initFunc(string $namespace)
    {
        $initialize = [];
        $initialize['schema'] = self::$snippet->getThisMethod('setSchema', self::$schema);
        $initialize['source'] = self::$snippet->getThisMethod('setSource', self::$table);
        $referenceList = [];
        foreach (self::$db->listTables(self::$schema) as $name) {
            $referenceList[$name] = self::$db->describeReferences($name, self::$schema);;
        }

        foreach ($referenceList as $tableName => $references) {
            foreach ($references as $reference) {
                if ($reference->getReferencedTable() != self::$table) {
                    continue;
                }

                $refColumns = $reference->getReferencedColumns();
                $columns = $reference->getColumns();
                $initialize[] = self::$snippet->getRelation(
                    'hasMany',
                    $refColumns[0],
                    $namespace . Text::camelize($tableName, '_-'),
                    $columns[0],
                    "['alias' => '" . Text::camelize($tableName, '_-') . "']"
                );
            }
        }

        foreach (self::$db->describeReferences(self::$table, self::$schema) as $reference) {

            $refColumns = $reference->getReferencedColumns();
            $columns = $reference->getColumns();
            $initialize[] = self::$snippet->getRelation(
                'belongsTo',
                $columns[0],
                self::getEntityClassName($reference, $namespace),
                $refColumns[0],
                "['alias' => '" . Text::camelize($reference->getReferencedTable(), '_-') . "']"
            );
        }
        return $initialize;
    }

    protected static function exclude()
    {
        return [];
    }

    /**
     * Returns the associated PHP type
     *
     * @param  string $type
     * @return string
     */
    protected static function getPHPType($type)
    {
        switch ($type) {
            case Column::TYPE_INTEGER:
            case Column::TYPE_BIGINTEGER:
                return 'integer';
                break;
            case Column::TYPE_DECIMAL:
            case Column::TYPE_FLOAT:
                return 'double';
                break;
            case Column::TYPE_DATE:
            case Column::TYPE_VARCHAR:
            case Column::TYPE_DATETIME:
            case Column::TYPE_CHAR:
            case Column::TYPE_TEXT:
                return 'string';
                break;
            default:
                return 'string';
                break;
        }
    }
}