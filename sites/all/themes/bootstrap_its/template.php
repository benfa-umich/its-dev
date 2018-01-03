<?php

/**
 * @file
 * template.php
 */

function bootstrap_its_bootstrap_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= '<div class="hidden"><a name="search"></a><label for="edit-search-block-form--2">Search</label></div>';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
  // We can be sure that the font icons exist in CDN.
  //if (theme_get_setting('bootstrap_cdn')) {
  $output .= "<span class='icon glyphicon glyphicon-search' aria-hidden='true'></span>";
  //}
  //else {
    //$output .= t('Search');
  //}
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}

//Trying to kill new user registrations
function bootstrap_its_theme($existing, $type, $theme, $path){
  $hooks['user_register_form']=array(
    'render element'=>'form',
    'template' =>'templates/user-register',
  );
return $hooks;
}

function bootstrap_its_preprocess_user_register(&$variables) {
  $variables['form'] = drupal_build_form('user_register_form', user_register_form(array()));
}


function bootstrap_its_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'iq_contact_form_node_form') {
	
	//https://drupal.org/node/154137
	$form['actions']['submit']['#value'] = t('Submit'); // Change the text on the label element
	//need to remove the Status field from student job applications only on the node/add form
	if (arg(0) == 'node' && arg(1) == '1') {
	//var_dump($form);
	$form['field_status']['#access'] = 0;
	}
  }

  if ($form_id == 'webform_client_form_4058') {
  	if (isset($form["submitted"]["your_email_address"]["#default_value"])) {
		$form["submitted"]["your_email_address"]["#default_value"] = $_SERVER["REMOTE_USER"]."@umich.edu";
		//echo "<!-- ".$_SERVER["REMOTE_USER"]."-----------";
		//var_dump($form["submitted"]["your_email_address"]["#default_value"]);
		//echo "-->";	
	
	}  
  }
}