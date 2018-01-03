/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*
 * This file is used/requested by the 'Styles' button.
 * The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
 */
if(typeof(CKEDITOR) !== 'undefined') {
    CKEDITOR.stylesSet.add( 'drupal',
    [
			{ name: 'No-Wrap Text', element: 'nobr', attributes: {'class': 'nobreak'} }
            //{ name : 'No-Wrap Text', element : 'nobr', styles : { 'white-space' : 'nowrap' } }

    ]);
}