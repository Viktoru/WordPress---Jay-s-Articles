<?php
/**
 * Created by PhpStorm.
 * User: victor.unda
 * Date: 7/9/19
 * Time: 1:14 PM
 */

function jay_table_admin_plugin_setup_menu(){
  add_menu_page( 'Article Admin', 'Article Plugin', 'manage_option', 'jay_table_admin-plugin',
    'jay_table_admin_init');
}

add_action('admin_menu', 'jay_table_admin_plugin_setup_menu');


function jay_table_admin_init(){

  $content = '';
  $content .= 'Hello test';

  return $content;
}