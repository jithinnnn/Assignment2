<?php

/*
Plugin Name:    Demo Plugin Course
Plugin URI:     http://yourdomain.com
Description:    This is the most awesome demo plugin on planet Earth!
Version:        1.0.0
Author:         Jithin
Author URI:    http://yourdomain.com 

*/

if(!class_exists(   'LearnWPDev')):
    final class LearnWPDev {

        private static $instance = null;
        private function __construct() {  
                $this->initializeHooks();   
        }

        public static function getInstance(){
            if(is_null(self::$instance))
                self::$instance = new self();

                return self::$instance;
        }

        private function initializeHooks(){
            if(is_admin()){
                require_once('admin/admin.php');
            }


            // require_once('our_menu.php');
        }

    }
        endif;

LearnWPDegetInstance();






function my_custom_footer_text($text){

    $text = '<p style="color:red"> Its time for your first plugin </p>';    
    return $text;
}

add_filter('admin_footer_text','my_custom_footer_text');

function add_my_own_menu(){
    global $wp_admin_bar;

    $custom_menu = array(
        'id' => 'demo_menu',
        'title' => 'This is made from our first WP plugin',
        'parent' =>'top-secondary',
        'href' => site_url()
    );

    $wp_admin_bar  -> add_node($custom_menu);
}

add_action('admin_bar_menu','add_my_own_menu');

function execute_our_first_shortcode($attr){

    wp_enqueue_script('my-js-id', plugins_url() . '/demo/my_js.js');
    wp_enqueue_style('my-css-id'   , plugins_url() . '/demo/my_css.css');

    $output_text = 'Hi Everybody!';

    if(isset($attr['attribute']))
    $output_text = $attr['attribute'];
    return '<p class="our_demo_class" onclick="changeColor()" id="our_demo">You gave me     '. $output_text . '</p>';           
}

add_shortcode('our_first_shortcode','execute_our_first_shortcode');

require_once ('our_menu.php');


