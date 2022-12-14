<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace toTwig\Converter;

/**
 * Class AbstractSingleTagConverter
 */
abstract class AbstractSingleTagConverter extends ConverterAbstract
{
    protected array $mandatoryFields = [];
    protected ?string $convertedName = null;

    /**
     * AbstractSingleTagConverter constructor.
     */
    public function __construct()
    {
        if (!$this->convertedName) {
            $this->convertedName = $this->name;
        }
    }

    /**
     * @param string $content
     *
     * @return null|string|string[]
     */
    public function convert(string $content): string
    {
        $pattern = $this->getOpeningTagPattern($this->name);

        return preg_replace_callback(
            $pattern,
            function ($matches) {
                $match = $matches[1] ?? '';
                $attributes = $this->extractAttributes($match);

                $arguments = [];
                foreach ($this->mandatoryFields as $mandatoryField) {
                    $arguments[] = $this->sanitizeValue($attributes[$mandatoryField]);
                }

                if ($this->convertArrayToAssocTwigArray($attributes, $this->mandatoryFields)) {
                    $arguments[] = $this->convertArrayToAssocTwigArray($attributes, $this->mandatoryFields);
                }

                return sprintf("{{ %s(%s) }}", $this->convertedName, implode(", ", $arguments));
            },
            $content
        );
    }
}
