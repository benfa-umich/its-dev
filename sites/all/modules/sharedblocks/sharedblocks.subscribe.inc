<?php

/**
 * @file
 * Subscribe block page callbacks for the sharedblocks module.
 */

/**
 * Get the cached content for a block.
 *
 * @param string $block_name  Machine name of the block
 *
 * @return mixed
 *   Array of block configuration data, if it was available in the cache.
 *   Otherwise, NULL is returned.
 */
function sharedblocks_cache_get($block_name) {
  $cache_id = 'sharedblocks:' . $block_name;
  $block_cache = cache_get($cache_id, 'cache_block');
  if (is_object($block_cache)) {
    // Only return the cached data if it has not yet expired.
    if ($block_cache->expire > REQUEST_TIME) {
      return $block_cache->data;
    }
  }
  // Either no cached data was found, or it was expired, so return NULL.
  return NULL;
}

/**
 * Refresh the cached content for the given shared block. The updated data is
 * returned.
 * @param  string $block_name Machine name for block
 * @return mixed             Array of block data, NULL on error
 */
function sharedblocks_cache_refresh($block_name) {
  $block_data = NULL;
  $block = sharedblocks_subscription_load($block_name);
  $cache_id = 'sharedblocks:' . $block_name;

  $response = _sharedblocks_fetch_url($block->url);
  if ($response) {
    // Block exists: pull its information into an object.
    $block_data = $response;

    // Determine when the store content should expire
    if ($block->update_interval > 0) {
      $block_expiry = time() + $block->update_interval;
    }
    // Unknown expiration length: set to expire on next cache clear
    else {
      $block_expiry = CACHE_TEMPORARY;
    }

    // Cache the block contents and set it to expire later
    cache_set($cache_id, $block_data, 'cache_block', $block_expiry);
  }
  return $block_data;
}


/**
 * Actually retrieve the block info from a URL. Used when refreshing a cached
 * block, and when the block is first subscribed, to validate the URL.
 * @param  string $url Shared Blocks URL on the remote site
 * @return mixed      Array of data if successful, FALSE otherwise.
 */
function _sharedblocks_fetch_url($url) {
  $data = FALSE;
  $response = drupal_http_request($url);
  if (isset($response->error)) {
    watchdog('sharedblocks', 'Error @code @error when attempting to fetch @url.', array('@code' => $response->code, '@error' => $response->error, '@url' => $url));
  }
  else {
    $data = drupal_json_decode($response->data);
    if (!is_array($data)) {
      watchdog('sharedblocks', 'Unable to parse block data from @url.', array('@url' => $url));
      $data = FALSE;
    }
  }
  return $data;
}
