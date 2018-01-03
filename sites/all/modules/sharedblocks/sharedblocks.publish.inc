<?php

/**
 * @file
 * Publish block page callbacks for the sharedblocks module.
 */

/**
 * Check if a block is set to be published.
 */
function sharedblocks_is_block_published($module, $delta) {
  $shared_blocks = variable_get('sharedblocks_publish', array());
  return !empty($shared_blocks[$module][$delta]);
}

/**
 * Check if a block is publishable.
 */
function sharedblocks_is_block_publishable($module, $delta, array $info) {
  return empty($info['no publish']);
}

/**
 * Given a module and delta, return the security token for this block.
 *
 * Cannot use drupal_get_token() because it adds session_id() to the
 * token information. Which means a subscribe URL with a token copied
 * while a user is logged in, will not work when fetched by another
 * user or server (anonymous user).
 *
 * @see sharedblocks_is_valid_token()
 */
function sharedblocks_get_token($module, $delta) {
  return drupal_hmac_base64("$module:$delta", drupal_get_private_key() . drupal_get_hash_salt());
}

/**
 * Validates a shared block security token.
 *
 * @see sharedblocks_get_token().
 */
function sharedblocks_is_valid_token($token, $module, $delta) {
  return $token === sharedblocks_get_token($module, $delta);
}

/**
 * Returns the URI of a shared block.
 */
function sharedblocks_get_publish_uri($module, $delta) {
  return array(
    'path' => 'sharedblocks/' . $module . '/' . $delta,
    'options' => array(
      'absolute' => TRUE,
      'query' => array(
        'token' => sharedblocks_get_token($module, $delta),
      ),
    )
  );
}

/**
 * Page callback for block publish callback.
 */
function sharedblocks_publish_block($module, $delta) {
  if ($block = sharedblocks_get_block($module, $delta)) {
    $output = array(
      'subject' => $block->subject,
      'content' => $block->rendered,
    );
    drupal_json_output($output);
  }
  else {
    return MENU_NOT_FOUND;
  }
}

/**
 * Fetch a block in the same manner as _block_render_blocks().
 *
 * @todo Investigate if this should maybe use ctools_block_content_type_render()?
 */
function sharedblocks_get_block($module, $delta) {
  $block = new stdClass();
  $block->module = $module;
  $block->delta = $delta;

  // Reset globals like current path and user during block rendering.
  _sharedblocks_set_globals();

  $array = module_invoke($block->module, 'block_view', $block->delta);

  // Valid PHP function names cannot contain hyphens.
  $delta = str_replace('-', '_', $block->delta);
  // Allow modules to modify the block before it is viewed, via either
  // hook_block_view_alter() or hook_block_view_MODULE_DELTA_alter().
  drupal_alter(array('block_view', "block_view_{$block->module}_{$delta}"), $array, $block);

  if (isset($array) && is_array($array)) {
    foreach ($array as $k => $v) {
      $block->$k = $v;
    }
  }
  if (isset($block->content) && $block->content) {
    // Normalize to the drupal_render() structure.
    if (is_string($block->content)) {
      $block->content = array('#markup' => $block->content);
    }

    // Provide an empty subject if the block hook did not return one.
    if (!isset($block->subject)) {
      $block->subject = '';
    }

    // Customize the output of the block (i.e. running a text filter).
    $block->content['#post_render'][] = 'sharedblocks_post_render_block';

    // Render the content into the final HTML.
    // @todo Figure out how to support #attached information.
    $block->rendered = render($block->content);
  }

  // Only reset globals back once the block is done possibly rendering.
  _sharedblocks_revert_globals();

  return !empty($block->rendered) ? $block : FALSE;
}

function _sharedblocks_set_globals() {
  $values = &drupal_static('sharedblocks_globals');

  if (isset($values)) {
    return;
  }
  else {
    // Set the static to a non-NULL variable so we know that this function was
    // called at least once.
    $values = array();
  }

  // Set the current path to the homepage.
  if ($_GET['q'] != variable_get('site_frontpage', 'node')) {
    $values['q'] = $_GET['q'];
    $_GET['q'] = variable_get('site_frontpage', 'node');
    drupal_static_reset('drupal_is_front_page');
  }

  // Set the current user to anonymous and reset the session.
  if ($GLOBALS['user']->uid > 0) {
    $values['user'] = $GLOBALS['user'];
    $values['session'] = drupal_save_session();
    drupal_save_session(FALSE);
    $GLOBALS['user'] = drupal_anonymous_user();
  }
}

function _sharedblocks_revert_globals() {
  $values = &drupal_static('sharedblocks_globals');

  if (!isset($values)) {
    return;
  }

  // Revert the current path.
  if (isset($values['q'])) {
    $_GET['q'] = $values['q'];
    drupal_static_reset('drupal_is_front_page');
  }

  // Revert the current user and session.
  if (isset($values['user'])) {
    $GLOBALS['user'] = $values['user'];
    drupal_save_session($values['session']);
  }

  // Clear out the original globals since they have been reset.
  drupal_static_reset('sharedblocks_globals');
}

/**
 * Render API callback; Apply a text format to the content.
 *
 * This function is assigned as an #post_render callback in
 * sharedblocks_get_block().
 */
function sharedblocks_post_render_block($text, $elements) {
  if (filter_format_exists('sharedblocks_output')) {
    return check_markup($text, 'sharedblocks_output');
  }
  else {
    return $text;
  }
}
