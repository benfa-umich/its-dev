<?php 
/**
* This replaces the webform date selectors with a single text box & date popup.
*/
$idKey = str_replace('_', '-', $component['form_key']);
?>
<input type="text" id="edit-submitted-<?php print $idKey ?>" class="form-text
<?php print implode(' ',$calendar_classes); ?>" alt="<?php print t('Open popup calendar'); ?>" title="<?php print t('Open popup calendar'); ?>" value="<?php echo date("Y-m-d"); ?>" />