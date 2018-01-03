<?php

/**
 * @file
 * Configuration file for Drupal's multi-site directory aliasing feature.
 *
 * Drupal searches for an appropriate configuration directory based on the
 * website's hostname and pathname. A detailed description of the rules for
 * discovering the configuration directory can be found in the comment
 * documentation in 'sites/default/default.settings.php'.
 *
 * This file allows you to define a set of aliases that map hostnames and
 * pathnames to configuration directories. These aliases are loaded prior to
 * scanning for directories, and they are exempt from the normal discovery
 * rules. The aliases are defined in an associative array named $sites, which
 * should look similar to the following:
 *
 * $sites = array(
 *   'devexample.com' => 'example.com',
 *   'localhost.example' => 'example.com',
 * );
 *
 * The above array will cause Drupal to look for a directory named
 * "example.com" in the sites directory whenever a request comes from
 * "example.com", "devexample.com", or "localhost/example". That is useful
 * on development servers, where the domain name may not be the same as the
 * domain of the live server. Since Drupal stores file paths into the database
 * (files, system table, etc.) this will ensure the paths are correct while
 * accessed on development servers.
 *
 * To use this file, copy and rename it such that its path plus filename is
 * 'sites/sites.php'. If you don't need to use multi-site directory aliasing,
 * then you can safely ignore this file, and Drupal will ignore it too.
 */

/**
 * Multi-site directory aliasing:
 *
 * Edit the lines below to define directory aliases. Remove the leading hash
 * signs to enable.
 */
# $sites['devexample.com'] = 'example.com';
# $sites['localhost.example'] = 'example.com';
$sites['www.safecomputing.umich.edu'] = 'safecomputing.umich.edu.dataguide';
$sites['safecomputing.umich.edu'] = 'safecomputing.umich.edu.dataguide';
$sites['safecomputing.umich.edu/dataguide'] = 'safecomputing.umich.edu.dataguide';
$sites['www.safecomputing.umich.edu/dataguide'] = 'safecomputing.umich.edu.dataguide';

$sites['www.its.umich.edu/projects/site-template'] = 'its-dev.dsc.umich.edu.projects';
$sites['www.its.umich.edu/projects/servicelink'] = 'it.umich.edu.projects.servicelink';
$sites['www.its.umich.edu/projects/sitemaker'] = 'it.umich.edu.projects.sitemaker';
$sites['www.its.umich.edu/projects/canvas'] = 'it.umich.edu.projects.canvas';
$sites['its-dev.dsc.umich.edu/projects/canvas'] = 'its-dev.dsc.umich.edu.projects.canvas';
$sites['www.its.umich.edu/projects/iiam'] = 'it.umich.edu.projects.iiam';
$sites['www.its.umich.edu/projects/learning-analytics'] = 'its.umich.edu.projects.learning-analytics';
$sites['www.its.umich.edu/projects/wifi-upgrade'] = 'its.umich.edu.projects.wifi-upgrade';
//$sites['www.it.umich.edu/initiatives/cloud'] = 'it.umich.edu.initiatives.cloud';
//$sites['www.it.umich.edu/initiatives/test'] = 'it.umich.edu.initiatives.test';
//$sites['www.it.umich.edu/projects/site-template'] = 'it.umich.edu.projects.site-template';
