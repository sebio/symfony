<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Tests\Component\Form;

use Symfony\Component\Form\LanguageField;
use Symfony\Component\Form\FormContext;

class LanguageFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testCountriesAreSelectable()
    {
        FormContext::setLocale('de_AT');

        $field = new LanguageField('language');
        $choices = $field->getOtherChoices();

        $this->assertArrayHasKey('en', $choices);
        $this->assertEquals('Englisch', $choices['en']);
        $this->assertArrayHasKey('en_GB', $choices);
        $this->assertEquals('Britisches Englisch', $choices['en_GB']);
        $this->assertArrayHasKey('en_US', $choices);
        $this->assertEquals('Amerikanisches Englisch', $choices['en_US']);
        $this->assertArrayHasKey('fr', $choices);
        $this->assertEquals('Französisch', $choices['fr']);
        $this->assertArrayHasKey('my', $choices);
        $this->assertEquals('Birmanisch', $choices['my']);
    }

    public function testMultipleLanguagesIsNotIncluded()
    {
        $field = new LanguageField('language');
        $choices = $field->getOtherChoices();

        $this->assertArrayNotHasKey('mul', $choices);
    }

    public function testEmptyValueOption()
    {
        // empty_value false
        $field = new LanguageField('language', array('empty_value' => false));
        $choices = $field->getOtherChoices();
        $this->assertArrayNotHasKey('', $choices);

        // empty_value as a blank string
        $field = new LanguageField('language', array('empty_value' => ''));
        $choices = $field->getOtherChoices();
        $this->assertArrayHasKey('', $choices);
        $this->assertEquals('', $choices['']);

        // empty_value as a normal string
        $field = new LanguageField('language', array('empty_value' => 'Choose a language'));
        $choices = $field->getOtherChoices();
        $this->assertArrayHasKey('', $choices);
        $this->assertEquals('Choose a language', $choices['']);
    }
}