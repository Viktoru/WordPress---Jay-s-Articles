<?php
/**
 * Created by PhpStorm.
 * User: victor.unda
 * Date: 7/9/19
 * Time: 1:36 PM
 */

/**
 * Plugin Name: VU ADMIN.
 * Plugin URI: http://wordpress.dataprogram.info/wp-admin/plugins.php
 * Description: A lis of Articles.
 * Version: 1.0
 * Author: Victor P. Unda
 * Author URI: http://www.intillajta.org
 * License: GPLv2 or later
 * Text Domain: vu_admin-plugin
 **/

define('WP_DEBUG', TRUE);

// If this file is called directly, die.
defined( 'ABSPATH' ) or die('Restricted Area');

add_action( 'admin_menu', 'extra_post_info_menu' );

function extra_post_info_menu(){    $page_title = 'Article Admin';   $menu_title = 'Article Admin';   $capability = 'manage_options';   $menu_slug  = 'extra-post-info';   $function   = 'extra_post_info_page';   $icon_url   = 'dashicons-media-code';   $position   = 4;
  add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url,$position );
}

function extra_post_info_page(){

  global $wpdb;

  $table_name = $wpdb->prefix . '_jay_table';
  $db_result = $wpdb->get_results("SELECT * FROM $table_name");
  if(count($db_result) == 0)
  {
    echo "No data. This means that you need to install a plugin called jay_table.";
  }
  else {

    ?>

    <div class="container">
      <h1>Article Information</h1>
      <p><sub>Publications</sub></p>

      <div class="container">
        <?php foreach ($db_result as $result) { ?>
          <h2><?php $result->id; ?> - <?php echo $result->title; ?></h2>
          <div class="row">
            <div class="col"><?php echo $result->author; ?>
              - <?php echo $result->body; ?></div>
          </div>
        <?php } ?>
      </div>
    </div>

    <?php
  }
}
