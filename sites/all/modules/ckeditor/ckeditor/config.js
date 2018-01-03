/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.extraPlugins = 'lineutils';
	config.extraPlugins = 'widget';
	config.extraPlugins = 'bootstrapListGroup';
	config.contentsCss = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css';
	config.allowedContent = true;
	config.bootstrapListGroup_managePopupContent = true;
	config.toolbar = [{ name: 'insert', items: [ 'BootstrapListGroup', 'Source' ] }];
};
