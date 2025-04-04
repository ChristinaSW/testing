<?php

// Before Header

	add_action('genesis_before_header', 'do_genesis_before_header');
	function do_genesis_before_header() {}

// Header

	add_action('genesis_header', 'do_header'); 
	function do_header() {
		$logo_img = '';
		$logo_url = '';
		if( class_exists('ACF') ){
			$logo_img = get_field('logo', 'option');
			$logo_url = get_field('image_url');
		}
		
		$logo_img = get_field('logo', 'option');
		$logo_url = get_field('image_url');
		if( $logo_img != '' ){
			$logo = $logo_img;
		}elseif( $logo_url != '' ){
			$logo = $logo_url;
		}else{
			$logo = '';
		}

		$main_menu = wp_nav_menu(
				array(
					'theme_location'  	=> 'primary',
					'container' 		=> 'nav',
					'container_class' 	=> 'menu-container hide-tablet',
					'menu_class' 		=> 'menu genesis-nav-menu menu-primary hide-mobile hide-tablet',
					'menu_id' 			=> 'menu-main-menu',
					'echo' 				=> false
				)
			);

		$mobile_menu = wp_nav_menu(
				array(
					'theme_location'  	=> 'secondary',
					'container' 		=> 'nav',
					'container_class' 	=> 'hide',
					'menu_class' 		=> '',
					'menu_id' 			=> 'menu-mobile-menu',
					'echo' 				=> false
				)
			);
	}

// After Header

	add_action('genesis_after_header', 'do_genesis_after_header');
	function do_genesis_after_header() {}
	
// Meta
	
	// add_action('genesis_meta', 'do_genesis_meta');
	function do_genesis_meta(){
		echo("
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','TAG ID GOES HERE');</script>
			<!-- End Google Tag Manager -->
		");
	}

// Register Header Menus

	// register_nav_menus( array(
	// 	'main-menu' => 'Main Menu',
	// 	'mobile-menu' => 'Mobile Menu'
	// ));
?>