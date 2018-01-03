<?php

/**
 * Define this Export UI plugin.
 */
$plugin = array(
  'schema' => 'sharedblocks',  // As defined in hook_schema().
  'access' => 'subscribe to blocks',  // Define a permission users must have to access these pages.

  // Define the menu item.
  'menu' => array(
    'menu item' => 'subscribe',
    'menu prefix' => 'admin/structure/sharedblocks',
    'menu title' => 'Subscribed Blocks',
    'menu description' => 'Administer Shared Block subscriptions.',
  ),

  // Define user interface texts.
  'title singular' => t('block subscription'),
  'title plural' => t('block subscriptions'),
  'title singular proper' => t('Shared Block subscription'),
  'title plural proper' => t('Shared Block subscriptions'),

  // Define the names of the functions that provide the add/edit forms.
  'form' => array(
    'settings' => 'sharedblocks_ctools_export_ui_form',
    // 'submit' and 'validate' are also valid callbacks.
  ),
);

/**
 * Implements HOOK_ctools_export_ui_form().
 */
function sharedblocks_ctools_export_ui_form(&$form, &$form_state) {
  $form += sharedblocks_block_configure($form_state['item']->name);
  $form['info']['name'] = $form['name'];
  $form['info']['name']['#machine_name']['source'] = array('info', 'description');
  $form['info']['description'] = $form['description'];
  unset($form['name']);
  unset($form['description']);
}

/**
 * Handle submission of a new subscribed block
 */
function sharedblocks_ctools_export_ui_form_submit($form, &$form_state) {
  // Clear the cached data for the block, if an existing block is being edited.
  cache_clear_all('sharedblocks:' . $form_state['item']->name, 'cache_block');
}
