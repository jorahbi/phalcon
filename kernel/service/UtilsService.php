<?php


namespace Kernel\service;


class UtilsService implements ServiceInterface
{
    /**
     * Convert string foo_bar to FooBar or fooBar
     * @param string $string
     * @param string $delimiter
     * @param boolean $useLow
     * @return string
     */
    public function lowerCamelizeWithDelimiter($string, $delimiter = '', $useLow = false)
    {
        if (empty($string)) {
            throw new \InvalidArgumentException('Please, specify the string');
        }

        if (!empty($delimiter)) {
            $delimiterArray = str_split($delimiter);

            foreach ($delimiterArray as $delimiter) {
                $stringParts = explode($delimiter, $string);
                $stringParts = array_map('ucfirst', $stringParts);

                $string = implode('', $stringParts);
            }
        }

        if ($useLow) {
            $string = lcfirst($string);
        }

        return $string;
    }

    /**
     * Converts the underscore_notation to the lowerCamelCase
     *
     * @param string $string
     * @return string
     */
    public function lowerCamelize($string)
    {
        return lcfirst($this->camelize($string));
    }

    /**
     * Converts the underscore_notation to the UpperCamelCase
     *
     * @param string $string
     * @param string $delimiter
     * @return string
     */
    public function camelize($string, $delimiter = '_')
    {
        if (empty($delimiter)) {
            throw new \InvalidArgumentException('Please, specify the delimiter');
        }

        $delimiterArray = str_split($delimiter);

        foreach ($delimiterArray as $delimiter) {
            $stringParts = explode($delimiter, $string);
            $stringParts = array_map('ucfirst', $stringParts);

            $string = implode('', $stringParts);
        }

        return $string;

    }
}