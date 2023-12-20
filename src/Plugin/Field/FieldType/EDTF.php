<?php

namespace Drupal\edtf\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'edtf' field type.
 *
 * @FieldType(
 *   id = "edtf",
 *   label = @Translation("Extended Date/Time Format"),
 *   description = {
 *     @Translation("Stores date/time in Extended Date/Time Format (EDTF)"),
 *     @Translation("Allows for varying precision, uncertain and approximate date/time specification"),
 *   },
 *   category = "date_time",
 *   default_widget = "edtf_widget",
 *   default_formatter = "edtf_formatter"
 * )
 */
class EDTF extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    return [
      'columns' => [
        'value' => [
          'type' => 'char',
          'length' => 255,
          'not null' => TRUE,
          'description' => 'To store the date in EDTF format.',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('EDTF'));
    return $properties;
  }

}
