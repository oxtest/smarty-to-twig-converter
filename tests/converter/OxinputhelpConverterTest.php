<?php

namespace sankar\ST\Tests\Converter;

use toTwig\Converter\OxinputhelpConverter;

/**
 * Class OxinputhelpConverterTest
 *
 * @author Tomasz Kowalewski (t.kowalewski@createit.pl)
 */
class OxinputhelpConverterTest extends AbstractConverterTest
{
    /** @var OxinputhelpConverter */
    protected $converter;

    public function setUp()
    {
        $this->converter = new OxinputhelpConverter();
    }

    /**
     * @covers \toTwig\Converter\OxinputhelpConverter::convert
     *
     * @dataProvider Provider
     *
     * @param $smarty
     * @param $twig
     */
    public function testThatAssignIsConverted($smarty, $twig)
    {
        // Test the above cases
        $this->assertSame($twig,
            $this->converter->convert($this->getFileMock(), $smarty)
        );
    }

    /**
     * @return array
     */
    public function Provider()
    {
        return [
            // Basic usage
            [
                "[{oxinputhelp ident=\"HELP_CATEGORY_MAIN_ACTIVE\"}]",
                "{{ oxinputhelp(\"HELP_CATEGORY_MAIN_ACTIVE\") }}"
            ],
            // Basic usage
            [
                "[{oxinputhelp ident=\"HELP_GENERAL_DATE\"}]",
                "{{ oxinputhelp(\"HELP_GENERAL_DATE\") }}"
            ],
            // With spaces
            [
                "[{ oxinputhelp ident=\"HELP_GENERAL_DATE\" }]",
                "{{ oxinputhelp(\"HELP_GENERAL_DATE\") }}"
            ],
        ];
    }

    /**
     * @covers \toTwig\Converter\OxinputhelpConverter::getName
     */
    public function testThatHaveExpectedName()
    {
        $this->assertEquals('oxinputhelp', $this->converter->getName());
    }

    /**
     * @covers \toTwig\Converter\OxinputhelpConverter::getDescription
     */
    public function testThatHaveDescription()
    {
        $this->assertNotEmpty($this->converter->getDescription());
    }
}