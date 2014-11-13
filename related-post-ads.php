<?php
/*
Plugin Name: Related Post Ads
Plugin URI: 
Description: Display Related Post under post by tags and category.
Version: 1.0
Author: paratheme
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

define('related_post_ads_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('related_post_ads_plugin_dir', plugin_dir_path( __FILE__ ) );
define('related_post_ads_wp_url', 'http://wordpress.org/plugins/related-post-ads/' );
define('related_post_ads_pro_url', '' );
define('related_post_ads_demo_url', '' );
define('related_post_ads_conatct_url', 'http://paratheme.com/contact' );
define('related_post_ads_qa_url', 'http://paratheme.com/qa' );
define('related_post_ads_plugin_name', 'Related Post Ads' );
define('related_post_ads_share_url', 'http://wordpress.org/plugins/related-post-ads/' );


require_once( plugin_dir_path( __FILE__ ) . 'includes/related-post-ads-functions.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/related-post-ads-shortcodes.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/related-post-ads-meta.php');

//Themes php files
require_once( plugin_dir_path( __FILE__ ) . 'themes/flat/index.php');



function related_post_ads_init_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('related_post_ads_js', plugins_url( '/js/related-post-ads-scripts.js' , __FILE__ ) , array( 'jquery' ));	
		
		wp_localize_script('related_post_ads_js', 'related_post_ads_ajax', array( 'related_post_ads_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('related-post-ads-style', related_post_ads_plugin_url.'css/style.css');
		
		//ParaAdmin framwork
		wp_enqueue_style('ParaAdmin', related_post_ads_plugin_url.'ParaAdmin/css/ParaAdmin.css');	
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));	
		
		// Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'related-post-ads-color-picker', plugins_url('/js/related-post-ads-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );

		
		// Style for themes

		wp_enqueue_style('related-post-ads-style-flat', related_post_ads_plugin_url.'themes/flat/style.css');


		
	}
add_action("init","related_post_ads_init_scripts");




register_activation_hook(__FILE__, 'related_post_ads_activation');


function related_post_ads_activation()
	{
		$related_post_ads_version= "1.0";
		update_option('related_post_ads_version', $related_post_ads_version); //update plugin version.
		
		$related_post_ads_customer_type= "free"; //customer_type "free"
		update_option('related_post_ads_customer_type', $related_post_ads_customer_type); //update plugin version.
	}





add_action('admin_menu', 'related_post_ads_menu_init');



function related_post_ads_menu_settings(){
	include('related-post-ads-settings.php');	
}

function related_post_ads_menu_init()
	{
		
	add_submenu_page('edit.php?post_type=related_post', __('Settings','menu-related-post'), __('Settings','menu-related-post'), 'manage_options', 'related_post_ads_menu_settings', 'related_post_ads_menu_settings');
	
	}





?>