<?php
 

class ninethemeShortcodes {

    function __construct() 
    {	
    	define('ninetheme_TINYMCE_URI', get_template_directory_uri() .'/includes/TinyMCE-editor-shortcode');
		define('ninetheme_TINYMCE_DIR', get_template_directory_uri() .'/includes/TinyMCE-editor-shortcode');
		
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
		$plugin_array['ninethemeShortcodes'] = ninetheme_TINYMCE_URI . '/plugin.js';
		return $plugin_array;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'ninetheme_button' );
		return $buttons;
	}


	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{	
		wp_localize_script( 'jquery', 'ninethemeShortcodes', array('plugin_folder' => ninetheme_TINYMCE_URI ) );
	}


    
}
$rnr_shortcodes = new ninethemeShortcodes();

?>