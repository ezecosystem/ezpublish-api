<?php

/**
 * File contains: eZ\Publish\API\Repository\Tests\FieldType\SelectionIntegrationTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 * @version //autogentag//
 */
namespace eZ\Publish\API\Repository\Tests\FieldType;

use eZ\Publish\Core\FieldType\Selection\Value as SelectionValue;
use eZ\Publish\API\Repository\Values\Content\Field;

/**
 * Integration test for use field type.
 *
 * @group integration
 * @group field-type
 */
class SelectionIntegrationTest extends SearchMultivaluedBaseIntegrationTest
{
    /**
     * Get name of tested field type.
     *
     * @return string
     */
    public function getTypeName()
    {
        return 'ezselection';
    }

    /**
     * Get expected settings schema.
     *
     * @return array
     */
    public function getSettingsSchema()
    {
        return array(
            'isMultiple' => array(
                'type' => 'bool',
                'default' => false,
            ),
            'options' => array(
                'type' => 'hash',
                'default' => array(),
            ),
        );
    }

    /**
     * Get a valid $fieldSettings value.
     *
     * @return mixed
     */
    public function getValidFieldSettings()
    {
        return array(
            'isMultiple' => true,
            'options' => array(
                0 => 'A first',
                1 => 'Bielefeld',
                2 => 'Sindelfingen',
                3 => 'Turtles',
                4 => 'Zombies',
            ),
        );
    }

    /**
     * Get $fieldSettings value not accepted by the field type.
     *
     * @return mixed
     */
    public function getInvalidFieldSettings()
    {
        return array(
            'somethingUnknown' => 0,
            'isMultiple' => array(),
            'options' => new \stdClass(),
        );
    }

    /**
     * Get expected validator schema.
     *
     * @return array
     */
    public function getValidatorSchema()
    {
        return array();
    }

    /**
     * Get a valid $validatorConfiguration.
     *
     * @return mixed
     */
    public function getValidValidatorConfiguration()
    {
        return array();
    }

    /**
     * Get $validatorConfiguration not accepted by the field type.
     *
     * @return mixed
     */
    public function getInvalidValidatorConfiguration()
    {
        return array(
            'unknown' => array('value' => 23),
        );
    }

    /**
     * Get initial field data for valid object creation.
     *
     * @return mixed
     */
    public function getValidCreationFieldData()
    {
        return new SelectionValue(array(0, 2));
    }

    /**
     * Asserts that the field data was loaded correctly.
     *
     * Asserts that the data provided by {@link getValidCreationFieldData()}
     * was stored and loaded correctly.
     *
     * @param Field $field
     */
    public function assertFieldDataLoadedCorrect(Field $field)
    {
        $this->assertInstanceOf(
            'eZ\\Publish\\Core\\FieldType\\Selection\\Value',
            $field->value
        );

        $expectedData = array(
            'selection' => array(0, 2),
        );
        $this->assertPropertiesCorrect(
            $expectedData,
            $field->value
        );
    }

    /**
     * Get field data which will result in errors during creation.
     *
     * This is a PHPUnit data provider.
     *
     * The returned records must contain of an error producing data value and
     * the expected exception class (from the API or SPI, not implementation
     * specific!) as the second element. For example:
     *
     * <code>
     * array(
     *      array(
     *          new DoomedValue( true ),
     *          'eZ\\Publish\\API\\Repository\\Exceptions\\ContentValidationException'
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array[]
     */
    public function provideInvalidCreationFieldData()
    {
        return array(
            array(
                new \stdClass(),
                'eZ\\Publish\\Core\\Base\\Exceptions\\InvalidArgumentType',
            ),
            array(
                new SelectionValue(array(7)),
                'eZ\\Publish\\Core\\Base\\Exceptions\\ContentFieldValidationException',
            ),
        );
    }

    /**
     * Get update field externals data.
     *
     * @return array
     */
    public function getValidUpdateFieldData()
    {
        return new SelectionValue(array(1));
    }

    /**
     * Get externals updated field data values.
     *
     * This is a PHPUnit data provider
     *
     * @return array
     */
    public function assertUpdatedFieldDataLoadedCorrect(Field $field)
    {
        $this->assertInstanceOf(
            'eZ\\Publish\\Core\\FieldType\\Selection\\Value',
            $field->value
        );

        $expectedData = array(
            'selection' => array(1),
        );
        $this->assertPropertiesCorrect(
            $expectedData,
            $field->value
        );
    }

    /**
     * Get field data which will result in errors during update.
     *
     * This is a PHPUnit data provider.
     *
     * The returned records must contain of an error producing data value and
     * the expected exception class (from the API or SPI, not implementation
     * specific!) as the second element. For example:
     *
     * <code>
     * array(
     *      array(
     *          new DoomedValue( true ),
     *          'eZ\\Publish\\API\\Repository\\Exceptions\\ContentValidationException'
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array[]
     */
    public function provideInvalidUpdateFieldData()
    {
        return $this->provideInvalidCreationFieldData();
    }

    /**
     * Asserts the the field data was loaded correctly.
     *
     * Asserts that the data provided by {@link getValidCreationFieldData()}
     * was copied and loaded correctly.
     *
     * @param Field $field
     */
    public function assertCopiedFieldDataLoadedCorrectly(Field $field)
    {
        $this->assertInstanceOf(
            'eZ\\Publish\\Core\\FieldType\\Selection\\Value',
            $field->value
        );

        $expectedData = array(
            'selection' => array(0, 2),
        );
        $this->assertPropertiesCorrect(
            $expectedData,
            $field->value
        );
    }

    /**
     * Get data to test to hash method.
     *
     * This is a PHPUnit data provider
     *
     * The returned records must have the the original value assigned to the
     * first index and the expected hash result to the second. For example:
     *
     * <code>
     * array(
     *      array(
     *          new MyValue( true ),
     *          array( 'myValue' => true ),
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array
     */
    public function provideToHashData()
    {
        return array(
            array(
                new SelectionValue(array(0, 2)),
                array(0, 2),
            ),
        );
    }

    /**
     * Get expectations for the fromHash call on our field value.
     *
     * This is a PHPUnit data provider
     *
     * @return array
     */
    public function provideFromHashData()
    {
        return array(
            array(
                array(0, 2),
                new SelectionValue(array(0, 2)),
            ),
        );
    }

    public function providerForTestIsEmptyValue()
    {
        return array(
            array(new SelectionValue()),
            array(new SelectionValue(array())),
        );
    }

    public function providerForTestIsNotEmptyValue()
    {
        return array(
            array(
                $this->getValidCreationFieldData(),
            ),
            array(
                new SelectionValue(array(0)),
            ),
        );
    }

    protected function getValidSearchValueOne()
    {
        return array(1);
    }

    protected function getValidSearchValueTwo()
    {
        return array(2);
    }

    protected function getSearchTargetValueOne()
    {
        return 1;
    }

    protected function getSearchTargetValueTwo()
    {
        return 2;
    }

    protected function getAdditionallyIndexedFieldData()
    {
        return array(
            array(
                'selected_option_value',
                'Bielefeld',
                'Sindelfingen',
            ),
            array(
                'sort_value',
                '1',
                '2',
            ),
        );
    }

    protected function getValidMultivaluedSearchValuesOne()
    {
        return array(0, 1);
    }

    protected function getValidMultivaluedSearchValuesTwo()
    {
        return array(2, 3, 4);
    }

    protected function getAdditionallyIndexedMultivaluedFieldData()
    {
        return array(
            array(
                'selected_option_value',
                array('A first', 'Bielefeld'),
                array('Sindelfingen', 'Turtles', 'Zombies'),
            ),
        );
    }

    protected function getFullTextIndexedFieldData()
    {
        return array(
            array('Bielefeld', 'Sindelfingen'),
        );
    }
}
