<?php

// Register Styles & Scripts 
    $name = __DIR__;
    $name = explode('/',$name);
    $name = $name[count($name)-1];
    if (!function_exists('version')) {
        function version(){ return 1; }
    }
    if ( !is_admin() ) {
        $path = get_stylesheet_directory_uri() . '/blocks/'.$name.'/';
        if(file_exists(__DIR__.'/'.$name.'.css')){
            wp_register_style( $name.'css',$path.'/'.$name.'.css',array(), version(), 'all' );
            wp_enqueue_style( $name.'css' );
        }
        if(file_exists(__DIR__.'/'.$name.'.js')){
            wp_register_script($name.'js',$path.'/'.$name.'.js', array( 'jquery' ), version(), true);
            wp_enqueue_script($name.'js');
        }
    }

// Block Fields

// Block Functions

function ($block){
    $custom_class = ( isset($block['className']))?' '.$block['className'].'':'';
}
?>