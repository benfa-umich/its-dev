<?php

/**
 * hook_default_sharedblocks_subscription() returns an array of subscribed
 * block objects.
 * @return array Array of objects
 */
function hook_default_sharedblocks_subscription() {
  $export = array();

  $subscription = new stdClass();
  $subscription->disabled = FALSE; /* Edit this to true to make a default subscription disabled initially */
  $subscription->api_version = 1;
  $subscription->name = 'lullabot_follow';
  $subscription->description = 'Follow Lullabot';
  $subscription->url = 'http://lullabot.dev/sharedblocks/follow/site';
  $subscription->update_interval = 3600;
  $subscription->id = '2';
  $export['lullabot_follow'] = $subscription;

  return $export;
}
