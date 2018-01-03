<?php

/**
 * @file
 * Administration page callbacks for the sharedblocks module.
 */

/**
 * From constructor for the add new block subscription form.
 *
 * @see sharedblocks_add_block_form_submit()
 *
 * @ingroup forms
 */
function sharedblocks_add_block_form($form, &$form_state) {
  module_load_include('inc', 'block', 'block.admin');
  $form = block_admin_configure($form, $form_state, 'sharedblocks', NULL);

  // Other modules should be able to use hook_form_block_add_block_form_alter()
  // to modify this form, so add a base form ID.
  $form_state['build_info']['base_form_id'] = 'block_add_block_form';

  // Prevent block_add_block_form_validate/submit() from being automatically
  // added because of the base form ID by providing these handlers manually.
  $form['#validate'] = array();
  $form['#submit'] = array('sharedblocks_add_block_form_submit');

  return $form;
}

/**
 * Form validation handler for sharedblocks_add_block_form().
 *
 * @see sharedblocks_add_block_form()
 * @see block_add_block_form_submit()
 */
function sharedblocks_add_block_form_submit($form, &$form_state) {
  form_state_values_clean($form_state);

  // Set the delta of the block.
  $delta = $form_state['values']['delta'] = $form_state['values']['name'];

  $transaction = db_transaction();
  try {
    // Run the normal new block submission (borrowed from block_add_block_form_submit).
    $query = db_insert('block')->fields(array('visibility', 'pages', 'custom', 'title', 'module', 'theme', 'region', 'status', 'weight', 'delta', 'cache'));
    foreach (list_themes() as $key => $theme) {
      if ($theme->status) {
        $region = !empty($form_state['values']['regions'][$theme->name]) ? $form_state['values']['regions'][$theme->name] : BLOCK_REGION_NONE;
        $query->values(array(
          'visibility' => (int) $form_state['values']['visibility'],
          'pages' => trim($form_state['values']['pages']),
          'custom' => (int) $form_state['values']['custom'],
          'title' => $form_state['values']['title'],
          'module' => $form_state['values']['module'],
          'theme' => $theme->name,
          'region' => ($region == BLOCK_REGION_NONE ? '' : $region),
          'status' => 0,
          'status' => (int) ($region != BLOCK_REGION_NONE),
          'weight' => 0,
          'delta' => $delta,
          'cache' => DRUPAL_NO_CACHE,
        ));
      }
    }
    $query->execute();

    $query = db_insert('block_role')->fields(array('rid', 'module', 'delta'));
    foreach (array_filter($form_state['values']['roles']) as $rid) {
      $query->values(array(
        'rid' => $rid,
        'module' => $form_state['values']['module'],
        'delta' => $delta,
      ));
    }
    $query->execute();

    // Run hook_block_save().
    module_invoke($form_state['values']['module'], 'block_save', $form_state['values']['delta'], $form_state['values']);
  }
  catch (Exception $e) {
    $transaction->rollback();
    watchdog_exception('block', $e);
    throw $e;
  }

  drupal_set_message(t('The block has been created.'));
  cache_clear_all();
  $form_state['redirect'] = 'admin/structure/block';
}

/**
 * From constructor for the publish blocks form.
 *
 * @see sharedblocks_publish_form_submit()
 *
 * @ingroup forms
 */
function sharedblocks_publish_form($form, &$form_state) {
  module_load_include('inc', 'sharedblocks', 'sharedblocks.publish');
  $form = array();

  $form['sharedblocks_publish'] = array(
    '#tree' => TRUE,
    '#title' => t('Published Blocks'),
  );

  // Get a list of all the available blocks in the system.
  foreach (module_implements('block_info') as $module) {
    if ($module_blocks = module_invoke($module, 'block_info')) {
      // Loop through the list.
      foreach ($module_blocks as $delta => $block_info) {
        if (!sharedblocks_is_block_publishable($module, $delta, $block_info)) {
          continue;
        }
        // This block is published if it's set to 1 in the array.
        $is_published = sharedblocks_is_block_published($module, $delta);
        // Make checkboxes for each one.
        $form['sharedblocks_publish'][$module][$delta] = array(
          '#type' => 'checkbox',
          '#title' => check_plain($block_info['info']),
          '#default_value' => $is_published,
        );
        if ($is_published && $uri = sharedblocks_get_publish_uri($module, $delta)) {
          $form['sharedblocks_publish'][$module][$delta]['#description'] = url($uri['path'], $uri['options']);
        }
      }
    }
  }

  $form['settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Settings'),
  );
  $form['settings']['sharedblocks_require_token'] = array(
    '#type' => 'checkbox',
    '#title' => t('Require a unique security token in the URL for sites to fetch published these blocks.'),
    '#default_value' => variable_get('sharedblocks_require_token', 1),
  );
  if (empty($form['settings']['sharedblocks_require_token']['#default_value'])) {
    $form['settings']['sharedblocks_require_token']['#description'] = t('Enabling this option may break sites that are currently subscribed to your blocks. Make sure to update all sites subscribed to these blocks.');
  }

  $form['actions']['#type'] = 'actions';
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save configuration'),
  );

  return $form;
}

/**
 * Form validation handler for sharedblocks_publish_form().
 *
 * @see sharedblocks_publish_form()
 */
function sharedblocks_publish_form_submit($form, &$form_state) {
  $blocks = $form_state['values']['sharedblocks_publish'];
  foreach ($blocks as $module => $deltas) {
    $blocks[$module] = array_filter($deltas);
  }
  $blocks = array_filter($blocks);
  variable_set('sharedblocks_publish', $blocks);

  variable_set('sharedblocks_require_token', $form_state['values']['sharedblocks_require_token']);

  drupal_set_message(t('The configuration options have been saved.'));
}
