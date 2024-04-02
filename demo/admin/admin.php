<?php 
require_once('Our_Menu_Class.php');
add_action('admin_init',array('Our_Menu_Class','registerSettings'));
add_action('init',array('Our_Menu_Class','hideAdminBar'));
add_action('admin_menu',array('Our_Menu_Class','createMenu'));    