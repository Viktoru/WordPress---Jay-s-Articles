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

defined( 'ABSPATH') or die('Hello, you are not allow to work here');

global $jal_db_version;
$jay_db_version = '1.0';

function jay_table_install() {
  global $wpdb;
  global $jay_db_version;

  $table_name = $wpdb->prefix . '__jay_table';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		body longtext NOT NULL,
		title mediumtext NOT NULL,
		url varchar(55) DEFAULT '' NOT NULL,
		author VARCHAR(1000) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'jay_db_version', $jay_db_version );
}

function jay_table_install_data() {
  global $wpdb;

  $welcome_body = 'Gasic, K., Jung, S., Cheng, C.H., Lee, T., Zheng, P., Yu, J., Humann, J., Evans, K., Peace, C., DeVetter, L., Mcferson, J., Coe, M.I. and Main, D. Resources in the Genome Database for Rosaceae for Peach Research. Acta Horticulturae (in press).';
  $welcome_title = 'AgBioData consortium recommendations for sustainable genomics and genetics databases for agriculture ';
  $welcome_url = 'http://www.intillajta.org';
  $welcome_author = 'Lisa Harper  Jacqueline Campbell  Ethalinda K S Cannon  Sook Jung Monica Poelchau  Ramona Walls  Carson Andorf  Elizabeth Arnaud  Tanya Z Berardini Clayton Birkett  Steve Cannon  James Carson  Bradford Condon  Laurel Cooper Nathan Dunn  Christine G Elsik  Andrew Farmer  Stephen P Ficklin  David Grant Emily Grau  Nic Herndon  Zhi-Liang Hu  Jodi Humann  Pankaj Jaiswal  Clement Jonquet Marie-Angélique Laporte  Pierre Larmande  Gerard Lazo  Fiona McCarthy  Naama Menda Christopher J Mungall  Monica C Munoz-Torres  Sushma Naithani  Rex Nelson Daureen Nesdill  Carissa Park  James Reecy  Leonore Reiser  Lacey-Anne Sanderson Taner Z Sen  Margaret Staton  Sabarinath Subramaniam  Marcela Karey Tello-Ruiz Victor Unda  Deepak Unni  Liya Wang  Doreen Ware  Jill Wegrzyn  Jason Williams Margaret Woodhouse  Jing Yu  Doreen Main';

  $table_name = $wpdb->prefix . '__jay_table';

  $wpdb->insert(
    $table_name,
    array(
      'time' => current_time( 'mysql' ),
      'body' => $welcome_body,
      'title' => $welcome_title,
      'url' => $welcome_url,
      'author' => $welcome_author,
    )
  );
}

function delete_plugin_database_table() {
  global $wpdb;
  $table_name = $wpdb->prefix . '__jay_table';

  $sql = "DROP TABLE IF EXISTS $table_name";
  $wpdb->query($sql);
}

register_uninstall_hook(__FILE__, 'delete_plugin_database_table');
register_activation_hook( __FILE__, 'jay_table_install' );
register_activation_hook( __FILE__, 'jay_table_install_data' );