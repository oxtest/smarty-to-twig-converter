<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace toTwig\Converter;

/**
 * Class IdenticalComparisonConverter
 *
 * @package toTwig\Converter
 */
class IdenticalComparisonConverter extends ConverterAbstract
{
    protected string $name = 'identical_comparison_converter';
    protected string $description = 'Convert php "===" to twig "is same as()"';
    protected int $priority = 49;

    public function convert(string $content): string
    {
        /**
         * for {% if "foo"==="foo bar" %}
         *  $match[0] should contain left side of comparison with '===' sign i.e '=== "foo bar"'
         *  $match[1] should only contain value, without twig closing bracket or following spaces i.e. "foo bar"
         *
         * regex is designed to capture string between:
         *  comparison '===',
         *  twig logic operators (and, or, not)
         *  and twig closing tag '%}'
         */
        $pattern = '/\s*\=\=\=+\s*((?:(?!\%\}|\s\%\}|\sand|\sor|\snot).)+)?/';

        return preg_replace_callback(
            $pattern,
            function ($matches) {
                return str_replace($matches[0], ' is same as(' . $matches[1] . ')', $matches[0]);
            },
            $content
        );
    }
}
