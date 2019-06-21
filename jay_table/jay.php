<?php
/**
 * Created by PhpStorm.
 * User: victor.unda
 * Date: 6/17/19
 * Time: 9:37 AM
 */

/**
 * Plugin Name: Jay's Articles - MySQL Database.
 * Plugin URI: http://wordpress.dataprogram.info
 * Description: Adding Articles.
 * Version: 1.0
 * Author: Victor P. Unda
 * Author URI: http://www.intillajta.org
 **/

// If this file is called directly, die.
defined( 'ABSPATH' ) or die('Restricted Area');

global $jal_db_version;
$jay_db_version = '1.0';
function jay_table_install() {
  global $wpdb;
  global $jay_db_version;
  $table_name = $wpdb->prefix . '_jay_table';
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		body longtext NOT NULL,
		title longtext NOT NULL,
		author longtext NOT NULL,
		url varchar(500) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  add_option( 'jay_db_version', $jay_db_version );
}
function jay_table_install_data() {
  global $wpdb;
  $field_body = "Gasic, K., Jung, S., Cheng, C.H., Lee, T., Zheng, P., Yu, J., Humann, J., Evans, K., Peace, C., DeVetter, L., Mcferson, J., Coe, M.I. and Main, D. Resources in the Genome Database for Rosaceae for Peach Research. Acta Horticulturae (in press).";
  $field_title = "AgBioData consortium recommendations for sustainable genomics and genetics databases for agriculture ";
  $field_url = "https://academic.oup.com/database/article/doi/10.1093/database/bay088/5096675";
  $field_author = 'Marcela Karey Tello-Ruiz Victor Unda  Deepak Unni  Liya Wang  Doreen Ware  Jill Wegrzyn  Jason Williams Margaret Woodhouse  Jing Yu  Doreen Main.';
  $table_name = $wpdb->prefix . '_jay_table';
  $wpdb->insert(
    $table_name,
    array(
      'time' => current_time( 'mysql' ),
      'body' => $field_body,
      'title' => $field_title,
      'url' => $field_url,
      'author' => $field_author,
    )
  );
}
function delete_plugin_database_table() {
  global $wpdb;
  $table_name = $wpdb->prefix . '_jay_table';
  $sql = "DROP TABLE IF EXISTS $table_name";
  $wpdb->query($sql);
}

register_activation_hook( __FILE__, 'jay_table_install' );
register_activation_hook( __FILE__, 'jay_table_install_data' );
register_uninstall_hook(__FILE__, 'delete_plugin_database_table');