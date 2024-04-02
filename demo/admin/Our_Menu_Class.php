<?php

class Our_Menu_Class{

    public static function createMenu(){
        add_menu_page(
            'Our page title',
            'Our Menu title',
            'administrator',
            'our_menu_slug',
            array('Our_Menu_Class','menuCallback'),
            'dashicons-heart'
        );
    
        add_submenu_page(
            'our_menu_slug',
            'Our SubMenu',
            'Our SubMenu Title',
            'administrator',
            'our_submenu_slug',         
            'our_menu_callback'
        ) ;  
    }

    public static function menuCallback(){
         ?>
    <h1>Our First Settings :D   </h1>
    <form action="options.php" method="post">
        <?php
            settings_fields('our-settings-group');
        ?>

        <input id="hide-admin" type="checkbox" name="our-first-option" value="yes"
        <?php checked(get_option("our-first-option"),'yes')
        ?>>
        <label for="hide-admin">Hide Admin Bar in FrontEnd?</label>

        <?php submit_button('Save') ?>

    </form>
    <?php

    }
        public static function hideAdminBar(){
            $option = get_option('our-first-option');
    if($option === "yes"){
        add_filter('show_admin_bar','__return_false');
    }
        }

        public static function registerSettings(){
            register_setting('our-settings-group','our-first-option'); 
        }
} 