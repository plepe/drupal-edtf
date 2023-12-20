<?php

namespace Drupal\edtf\Plugin\Field\FieldWidget;

use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

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
      '#required' => $element['#required'],
      '#attributes' => ['class' => ['edtf']],
    ];

    return $element;
  }
}
