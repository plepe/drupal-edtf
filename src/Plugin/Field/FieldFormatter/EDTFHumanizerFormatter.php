<?php

namespace Drupal\edtf\Plugin\Field\FieldFormatter;

use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use EDTF\EdtfFactory;

/**
 * Plugin implementation of the 'Humanizer' formatter for 'edtf' fields.
 *
 * @FieldFormatter(
 *   id = "edtf_humanizer",
 *   label = @Translation("EDTF Humanizer"),
 *   field_types = {
 *     "edtf"
 *   }
 * )
 */
class EDTFHumanizerFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $parser = \EDTF\EdtfFactory::newParser();
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $humanizer = \EDTF\EdtfFactory::newHumanizerForLanguage($language);
    $element = [];

    foreach ($items as $delta => $item) {
      $value = $parser->parse($item->value);
      $edtfValue = $value->getEdtfValue();

      $element[$delta] = ['#markup' => $humanizer->humanize($edtfValue)];
    }

    return $element;
  }

}
