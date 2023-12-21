<?php

namespace Drupal\edtf\Plugin\Field\FieldWidget;

use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use EDTF\EdtfFactory;

/**
 * Plugin implementation of the 'edtf_widget' widget.
 *
 * @FieldWidget(
 *   id = "edtf_widget",
 *   label = @Translation("Default EDTF Widget"),
 *   field_types = {
 *    "edtf"
 *   },
 *   settings = {
 *   },
 * )
 */
class EDTFDefaultFieldWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $default_value = isset($items[$delta]->value) ? $items[$delta]->value : '';

    $element['value'] = $element + [
      '#type' => 'textfield',
      '#default_value' => $default_value,
      '#element_validate' => [[static::class, 'validateElement']],
      '#required' => $element['#required'],
      '#attributes' => ['class' => ['edtf']],
    ];

    return $element;
  }

  /**
   * Form element validation handler for an 'edtf' element.
   *
   * Disallows saving invalid EDTF values.
   */
  public static function validateElement($element, FormStateInterface $form_state, $form) {
    $parser = \EDTF\EdtfFactory::newParser();
    $parsingResult = $parser->parse($element['#value']);
    if (!$parsingResult->isValid()) {
      $form_state->setError($element, new TranslatableMarkup('Invalid EDTF date entered.'));
      return;
    }
  }
}
