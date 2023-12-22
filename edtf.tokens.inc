<?php

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\Core\Field\FieldItemList;

// based on smart_date.tokens.inc

/**
 * @file
 * Builds placeholder replacement tokens for edtf data.
 */

/**
 * Implements node_token_info().
 */
function edtf_token_info() {
  if (!\Drupal::hasService('token.entity_mapper')) {
    return;
  }

  $types = [];
  $tokens = [];
  foreach (\Drupal::entityTypeManager()->getDefinitions() as $entity_type_id => $entity_type) {
    if (!$entity_type->entityClassImplements(ContentEntityInterface::class)) {
      continue;
    }
    $token_type = \Drupal::service('token.entity_mapper')->getTokenTypeForEntityType($entity_type_id);
    if (empty($token_type)) {
      continue;
    }

    // Build property tokens for all edtf fields.
    $fields = \Drupal::service('entity_field.manager')->getFieldStorageDefinitions($entity_type_id);
    foreach ($fields as $field_name => $field) {
      if ($field->getType() != 'edtf') {
        continue;
      }

      $tokens[$token_type . '-' . $field_name]['year'] = [
        'name' => t('Return the year of the value'),
        'description' => NULL,
        'module' => 'edtf',
      ];
    }
  }

  return [
    'types' => $types,
    'tokens' => $tokens,
  ];
}

/**
 * Implements hook_tokens().
 */
function edtf_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
  $replacements = [];

  if (empty($data['field_property'])) {
    return $replacements;
  }

  foreach ($tokens as $token => $original) {
    $list = $data[$data['field_name']];

    $parts = explode(':', $token, 2);
    // Test for a delta as the first part.
    if (is_numeric($parts[0])) {
      if (count($parts) > 1) {
        $parts = explode(':', $parts[1], 2);
        $approach = $parts[0];
      }
      else {
        continue;
      }
    }
    else {
      $approach = $parts[0];
    }
    // Now parse out the pieces of the token name.
    $field = $list->first();
    if ($approach == 'year') {
      // Get the requested property and apply the provided format.
      $element = $field->getValue();
      $replacements[$original] = substr($element['value'], 0, 4);
    }
  }

  return $replacements;
}
