<?php

namespace Drupal\edtf\Plugin\Field\FieldWidget;

use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

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
    $reg_year = "[0-9]{4}";
    $reg_month = "-(0[1-9]|1[012])";
    $reg_day = "-(0[1-9]|[12][0-9]|3[01])";
    $reg_time = "T([01][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9]|:60)?";
    $reg_shift = "(|Z|[-+][0-9]{2}(:[0-5][0-9])?)";

    $reg_datetime = "{$reg_year}({$reg_month}({$reg_day}({$reg_time}($reg_shift)?)?)?)?";
    $reg_date = "{$reg_year}({$reg_month}({$reg_day})?)?";

    if (!preg_match("/^({$reg_datetime}|{$reg_date}\/{$reg_date})$/", $element['#value'])) {
      $form_state->setError($element, new TranslatableMarkup('Invalid EDTF date entered.'));
      return;
    }
  }
}
