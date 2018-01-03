<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>

<?php
if($output) { ?><span class="views-label views-label-field-maintenance-pinnacle-code">Cost:</span> <?php
//include_once("/afs/umich.edu/group/i/itsdrupl/Public/html/sites/default/ociloader.php");
//ociquery("doRate",$row->field_field_item_pinnacle_code[0]["rendered"]["#markup"]);
ociquery("doRate",$row->field_field_tp_its_item_number[0]["rendered"]["#markup"]);
}
?>

<?PHP 
//field_tp_its_item_number
//ociquery("doRate","Z-010508"); 
?>


<?php 
//only one line in the original template:
//print $output; 
?>
