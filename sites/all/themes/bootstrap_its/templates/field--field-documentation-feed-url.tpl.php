<?php

/**
 * @file field.tpl.php
 * Default template implementation to display the value of a field.
 *
 * This file is not used and is here as a starting point for customization only.
 * @see theme_field()
 *
 * Available variables:
 * - $items: An array of field values. Use render() to output them.
 * - $label: The item label.
 * - $label_hidden: Whether the label display is set to 'hidden'.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - field: The current template type, i.e., "theming hook".
 *   - field-name-[field_name]: The current field name. For example, if the
 *     field name is "field_description" it would result in
 *     "field-name-field-description".
 *   - field-type-[field_type]: The current field type. For example, if the
 *     field type is "text" it would result in "field-type-text".
 *   - field-label-[label_display]: The current label position. For example, if
 *     the label position is "above" it would result in "field-label-above".
 *
 * Other variables:
 * - $element['#object']: The entity to which the field is attached.
 * - $element['#view_mode']: View mode, e.g. 'full', 'teaser'...
 * - $element['#field_name']: The field name.
 * - $element['#field_type']: The field type.
 * - $element['#field_language']: The field language.
 * - $element['#field_translatable']: Whether the field is translatable or not.
 * - $element['#label_display']: Position of label display, inline, above, or
 *   hidden.
 * - $field_name_css: The css-compatible field name.
 * - $field_type_css: The css-compatible field type.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_field()
 * @see theme_field()
 *
 * @ingroup themeable
 */
?>
<!--

-->
<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <div class="field-items"<?php print $content_attributes; ?>>
    <?php foreach ($items as $delta => $item): ?>
      <div class="field-item <?php print $delta % 2 ? 'odd' : 'even'; ?>"<?php print $item_attributes[$delta]; ?>>


      <h2><nobr>U-M</nobr> Documentation</h2>

<?php

 
//error_reporting(-1);
//ini_set('display_errors', 'On');
$error = "Data feed error - please contact <a href='mailto:itswebteam@umich.edu'>itswebteam@umich.edu</a>";

//if intval() gets a string or a non-number, it returns 0 (FALSE) and there are no Taxonomy terms with tid=0, so 0 == error
if (intval($item["#markup"]) == 0){echo $error;}

else {

$taxonomyid = intval($item["#markup"]);

$listingurl = "http://documentation.its.umich.edu/sub-tags-json/".$taxonomyid; 
//$kidsurl = "http://mobileapps-dev.its.umich.edu/test/2/taxonomy-term-lister/".$taxonomyid; 

		$raw = file_get_contents($listingurl);
		//here's something strange and interesting that happened to this data feed:
		//http://stackoverflow.com/questions/689185/json-decode-returns-null-after-webservice-call
		if (json_decode($raw, true) == NULL) {
			$raw = substr($raw, 3);
		}
		$data = json_decode($raw, true);
		
		if ($data == NULL) {echo "<li>$error</li>";}
		else {
			//var_dump($data['nodes']);
		$biglist = array();

			if (isset($data['nodes'])) {
				foreach ($data['nodes'] as $node) {
					$weight = $node['node']['Weight'];
					$tags = $node['node']['ITS.umich page'];
					$title = $node['node']['title'];
					$title = str_replace("Digital Signage: ","",$title);
					$title = str_replace("MiVideo: ","",$title);
					$title = str_replace("Box: ","",$title);
					$title = str_replace("Google: ","",$title);
					//some mo' 3/2/2017
					$title = str_replace("VPN: ","",$title);
					$title = str_replace("Voicemail: ","",$title);
					$title = str_replace("MiDatabase: ","",$title);
					$title = str_replace("MiServer: ","",$title);
					$title = str_replace("Television: ","",$title);					
					
					if (isset($node['node']['title'])) {

						//$weight is the tag weight of the child tag, or, if there is no child tag, $tags is empty and $weight is that of the parent
						//so, we'll add one to the child weights and set $weight = 0, if there's no tag text
						$weight = intval($weight)+1;
						if ($tags == "") {
							$weight = 0;
						}
						//this is bad - need to fix this at the View level, probably.
						if ($node['node']['ITS.umich page'] == "Google Support" || $node['node']['ITS.umich page'] == "Box Support") {
							$weight = 0;	
						}

						$thisstring = "<!-- $title --><li><a href='http://documentation.its.umich.edu/?q=node/".$node['node']['Nid']."'>".$title."</a></li>";
						//title as key also helps remove duplicates in the feed, so watch out for that here
						$biglist[$thisstring] = array('weight' => $weight, 'tags' => $tags, 'html' => $thisstring);
					}
				}	
			}
//very sorry, i couldn't get the Drupal View to not send a million dupes...
$cleaner = array();
foreach ($biglist as $key => $val) {
	$cleaner[] = $val;
}

$oldweight = 1000;

//sory by header weight, then by title
$sort = array();
foreach($cleaner as $k=>$v) {
    $sort['weight'][$k] = $v['weight'];
    $sort['html'][$k] = $v['html'];
}
//sort by header weight, then sort alphbetically by title
array_multisort($sort['weight'], SORT_NUMERIC, SORT_ASC, $sort['html'], SORT_ASC, $cleaner);


foreach ($cleaner as $key => $val) {
	$thisweight = $val['weight'];
	if ($thisweight != $oldweight) {echo "</ul><h3>".$val['tags']."</h3><ul>";}
	echo $val['html'];
	//var_dump($val);
	//echo "<hr />";
	$oldweight = $val['weight'];
}
}
}
?>
	  
	  
	  <?php //print render($item); ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
