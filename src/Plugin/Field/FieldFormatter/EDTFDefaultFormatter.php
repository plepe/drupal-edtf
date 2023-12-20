<?php

namespace Drupal\edtf\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'edtf_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "edtf_formatter",
 *   label = @Translation("Extended Date/Time Format"),
 *   field_types = {
 *     "edtf"
 *   }
 * )
 */
class EDTFDefaultFormatter extends FormatterBase {

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
