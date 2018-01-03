<?php
/**
 * @file
 * ul_meeting_content_type.features.inc
 */

/**
 * Implements hook_node_info().
 */
function ul_meeting_content_type_node_info() {
  $items = array(
    'ul_meeting' => array(
      'name' => t('UL Meeting'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
