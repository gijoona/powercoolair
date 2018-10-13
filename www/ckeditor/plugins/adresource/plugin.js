/**
 * Basic sample plugin inserting current date and time into CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_intro
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'adresource', {

	// Register the icons. They must match command names.
	icons: 'adresource',

	// The plugin initialization logic goes inside this method.
	init: function( editor ) {

		// Define an editor command that inserts a timestamp.
		editor.addCommand( 'insertResource', {

			// Define the function that will be fired when the command is executed.
			exec: function( editor ) {

				// Insert the timestamp into the document.
				//editor.insertHtml( 'The current date and time is: <em>' + now.toString() + '</em>.' );
				showResourceFinder();
			}
		});

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'AdResource', {
			label: '이미지',
			command: 'insertResource',
			toolbar: 'insert'
		});
	}
});