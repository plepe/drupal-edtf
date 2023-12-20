<?php

namespace Drupal\edtf\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Plain' formatter for 'edtf' fields.
 *
 * @FieldFormatter(
 *   id = "edtf_plain",
 *   label = @Translation("Plain"),
 *   field_types = {
 *     "edtf"
 *   }
 * )
 */
class EDTFPlainFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = ['#markup' => $item->value];
    }

    return $element;
  }

}
