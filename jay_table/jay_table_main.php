<?php
/**
 * Created by PhpStorm.
 * User: victor.unda
 * Date: 6/21/19
 * Time: 3:12 PM
 */


// If this file is called directly, die.
defined( 'ABSPATH' ) or die('Restricted Area');

function article_my_menu() {
  register_nav_menu('new-menu',__( 'New Menu' ));
}

global $wpdb;
$table_name = $wpdb->prefix . '_jay_table';

$db_result = $wpdb->get_results("SELECT * FROM $table_name");

foreach ($db_result as $result) {
  $id = $result->id;
  $time = $result->time;
  $body = $result->body;
  $title = $result->title;
  $author = $result->author;
  $url = $result->url;
}

echo $id;

add_action( 'init', 'article_my_menu' );
