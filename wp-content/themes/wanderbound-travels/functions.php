<?php

// Exit if accessed directly
	if ( !defined('ABSPATH')) exit;

// version control for css and JS
	function version(){
		return strtotime('NOW');
	}

// Genesis theme support

	require_once( get_template_directory() . '/lib/init.php' );
	add_theme_support( 'genesis-responsive-viewport' );
	add_filter('widget_text', 'do_shortcode');
	add_theme_support('align-wide');
	add_theme_support( 'custom-spacing' );

	// Move and rename menus

		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );
		add_theme_support( 'genesis-menus' , array( 'primary' => __( 'Main Menu', 'genesis' ), 'secondary' => __( 'Mobile Menu', 'genesis-sample' ) ));

	// Remove theme SEO settings

		remove_theme_support( 'genesis-seo-settings-menu' );
		remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

	// Remove layout & script settings

		remove_theme_support( 'genesis-inpost-layouts' );
		remove_action( 'admin_menu', 'genesis_add_inpost_scripts_box' );

	// Remove Genesis fields from user profile

		remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );
		remove_action( 'show_user_profile', 'genesis_user_options_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
		add_filter( 'wp_is_application_passwords_available', '__return_false' );

	// Remove Genesis fields from post type taxonomy

		remove_action( 'admin_init', 'genesis_add_taxonomy_seo_options' );
		remove_theme_support( 'genesis-archive-layouts' );
		remove_action( 'admin_init', 'genesis_add_taxonomy_archive_options' );

	// Remove Genesis fields from archive settings for post types

		add_action( 'genesis_cpt_archives_settings_metaboxes', 'aic_remove_genesis_cpt_metabozes' );
		function aic_remove_genesis_cpt_metabozes( $_genesis_cpt_settings_pagehook ) {
			remove_meta_box( 'genesis-cpt-archives-seo-settings', $_genesis_cpt_settings_pagehook, 'main' );
			remove_meta_box( 'genesis-cpt-archives-layout-settings', $_genesis_cpt_settings_pagehook, 'main' );
		}

// Loading JavaScript

	add_action('init', 'do_script_add');
	function do_script_add() {
		if ( !is_admin() ) {
			$file_array = array();
			$dir = get_stylesheet_directory().'/js/auto/';
			if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) {
						if($file != '.' && $file != '..' && strpos($file,'.js') > 0){
							$path =get_stylesheet_directory_uri() . '/js/auto/'.$file;
							$file_array[$file]=$path;
						}
					}
					closedir($dh);
					foreach($file_array as $file=>$path){
						if($path != ''){
							wp_register_script( $file, $path, array( 'jquery' ), version(), true);
							wp_enqueue_script( $file );
						}
					}
				}
			}
		}
	}

// Load CSS files from css auto folder

	add_action('init', 'additional_css');
	function additional_css(){
		if ( !is_admin() ) {
			$production = false;
			wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
			wp_enqueue_style( 'google-fonts', '', '', null );

			if($production == true){
				wp_register_style( 'one-css.php',get_stylesheet_directory_uri() . '/css/auto/one-css.php', array(), '', 'all' );
				wp_enqueue_style( 'one-css.php' );
			}else{
				$file_array = array();
				$file_array['base-style.css'] = '';
				$file_array['menu.css'] = ''; 
				$file_array['font-style.css'] = ''; 
				$file_array['tablet.css'] = ''; 
				$file_array['mobile.css'] = '';

				$dir = get_stylesheet_directory().'/css/auto/';
				if (is_dir($dir)) {
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {
							if($file != '.' && $file != '..' && strpos($file,'.css') > 0){
								$path =get_stylesheet_directory_uri() . '/css/auto/'.$file;
								$file_array[$file]=$path;

							}
						}
						closedir($dh);
						foreach($file_array as $file=>$path){
							if($path != ''){
								wp_register_style( $file, $path, array(), version(), 'all' );
								wp_enqueue_style( $file );
							}
						}
					}
				}
			}
		}
	}

// Load CSS files for admin area

	add_action( 'admin_enqueue_scripts', 'load_admin_styles' );
	function load_admin_styles(){
		wp_enqueue_style( 'admin', get_stylesheet_directory_uri() . '/css/admin.css.php');
	}

// Fix conflict for admin stylesheet & SG Security

	add_filter( 'sgs_whitelist_wp_content' , 'whitelist_file_in_wp_content' );
	function whitelist_file_in_wp_content( $whitelist ) {
		$whitelist[] = 'admin.css.php';

		return $whitelist;
	}

// Fix conflict with Gravity Forms icon

	add_filter( 'gform_noconflict_styles', 'aic_admin_styles' );
	function aic_admin_styles($styles){
		$styles[] = 'admin';
		return $styles;
	}

// Add structure folder

	$dir = get_stylesheet_directory().'/structure/';
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			$file_array = array();
			while (($file = readdir($dh)) !== false) {
				if($file != '.' && $file != '..' && strpos($file,'.php') > 0){
					$path =get_stylesheet_directory() . '/structure/'.$file;
					$file_array[$file]=$path;
				}
			}
			closedir($dh);
			foreach($file_array as $file=>$path){

				if($path != ''){
					include_once($path);
				}
			}
		}
	}

// SMTP authentication so email can be sent FROM site

	// add_action( 'phpmailer_init', 'send_smtp_email' );
	function send_smtp_email( $phpmailer ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = SMTP_HOST;
		$phpmailer->SMTPAuth   = SMTP_AUTH;
		$phpmailer->Port       = SMTP_PORT;
		$phpmailer->Username   = SMTP_USER;
		$phpmailer->Password   = SMTP_PASS;
		$phpmailer->SMTPSecure = SMTP_SECURE;
		$phpmailer->From       = SMTP_FROM;
		$phpmailer->FromName   = SMTP_NAME;
	}

// Replace login logo and link

	add_filter( 'login_headerurl', 'loginlogo_url');
	function loginlogo_url($url){
		return site_url('/');
	}

	add_action( 'login_enqueue_scripts', 'login_logo' );
		function login_logo() {
			$logo_img = get_field('logo', 'option');
			$logo_url = get_field('image_url');
			$logo = '';
			if( $logo_img != '' ){
				$logo = $logo_img;
			}elseif( $logo_url != '' ){
				$logo = $logo_url;
			}else{
				$logo = '';
			}

			echo('
				<style type="text/css">
					body.login div#login h1 a {
						background-image: url('.$logo.');
						background-size: auto 84px;
						margin: 0 auto;
						max-width: 320px;
						width: 100%;
					} 
				</style>
			');
		}

// Set image meta defaults

	add_action( 'add_attachment', 'default_image_meta' );
	function default_image_meta( $post_ID ) {

		// Get and sanitize the title

			$my_image_title = get_post( $post_ID )->post_title;
			$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ', $my_image_title );
			$my_image_title = ucwords( strtolower( $my_image_title ) );

		// Create an array with image meta

			$my_image_meta = array(
				'ID'				=> $post_ID,
				'post_title'		=> $my_image_title
			);

		// Set the image Alt-Text

			update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );

		// Save the new meta

		wp_update_post( $my_image_meta );
	}

// Allow SVG uploads

	add_filter( 'wp_check_filetype_and_ext', 'allow_svg', 10, 4 );
	function allow_svg($data, $file, $filename, $mimes){
		global $wp_version;
		if ( $wp_version !== '4.7.1' ) {
			return $data;
		}

		$filetype = wp_check_filetype( $filename, $mimes );

		return [
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename']
		];
	}
	
	add_filter( 'upload_mimes', 'cc_mime_types' );
	function cc_mime_types( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	add_action( 'admin_head', 'fix_svg' );
	function fix_svg() {
		echo '
		<style type="text/css">
			.attachment-266x266, .thumbnail img {
				width: 100% !important;
				height: auto !important;
			}
		</style>';
	}

// Customizing Available Blocks

	add_filter( 'allowed_block_types_all', 'aic_allowed_block_types' );
	function aic_allowed_block_types( $allowed_blocks ) {
		
		$blocks = array(
			'core/block',
            'core/image',
            'core/paragraph',
            'core/heading',
            'core/list',
			'core/list-item',
            'core/buttons',
            'core/button',
            'core/separator',
            'core/html',
            'core/cover',
            'core/columns',
            'core/column',
            'core/media-text',
            'core/group',
            'core/file',
			'core/shortcode',
			'core/spacer',
			'core/gallery',
            'gravityforms/form'
		);

		//Set blocks for specific posts

		// if( get_post_field( 'post_name', get_post() ) == 'home' ){
		// 	array_push( $blocks, 'acf/hero' );
		// }

		return $blocks;
	}

// Reorder the admin dashboard

	remove_action('welcome_panel', 'wp_welcome_panel');
	add_action( 'admin_menu', 'aic_remove_meta_boxes' );
	function aic_remove_meta_boxes() {
        remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
    }

	//Reposition metaboxes

	add_action( 'admin_init', 'set_dashboard_meta_order' );
	function set_dashboard_meta_order() {
		$id = get_current_user_id(); //we need to know who we're updating
		$meta_value = array(
			'normal'  => 'dashboard_site_health', 
			'side'    => 'dashboard_activity', 
			'column3' => 'rg_forms_dashboard', 
			'column4' => '', 
		);
		update_user_meta( $id, 'meta-box-order_dashboard', $meta_value );
	}

// Adds full width option to theme

	function aic_fullwidth(){
		add_theme_support( 'align-wide' );
	}
	add_action( 'after_setup_theme', 'aic_fullwidth' );

// Load blocks

	add_action( 'init', 'register_acf_blocks' );
	function register_acf_blocks() {
		$scan = scandir(__DIR__. '/blocks');
		foreach( $scan as $folder ){
			if( !str_starts_with( $folder, '.' ) ){
				$json_file = __DIR__.'/blocks/'.$folder;
				$php_file = __DIR__.'/blocks/'.$folder.'/'.$folder.'.php';
				
				if(file_exists($json_file.'/block.json')){
					register_block_type($json_file);
				}
				if(file_exists($php_file)){
					include_once($php_file);
				}
			}	
		}
	}

// Add custom block categories

	add_filter( 'block_categories_all', 'custom_block_category', 10, 2);
	function custom_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'aic',
					'title' => __( 'An Ion Creative Custom Blocks', 'aic' ),
				)
			)
		);
	}

// Remove Yoast Social Profiles from User Page

	add_filter('user_contactmethods', 'remove_contact_methods', 99);
	function remove_contact_methods($methods){
		foreach( $methods as $k=>$v ){
			unset($methods[$k]);
		}

		return $methods;
	}

?>