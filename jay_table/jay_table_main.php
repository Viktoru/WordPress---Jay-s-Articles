<?php
/**
 * Created by PhpStorm.
 * User: victor.unda
 * Date: 7/9/19
 * Time: 1:36 PM
 */
/**
 * @package jay_table-plugin
 */

// If this file is called directly, die.
defined( 'ABSPATH' ) or die('Restricted Area');

function extra_post_info_menu(){    $page_title = 'Article Admin';   $menu_title = 'Article Admin';   $capability = 'manage_options';   $menu_slug = 'extra-post-info';   $function = 'extra_post_info_page';   $icon_url = 'dashicons-media-text';   $position = 4;
  add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url,$position );
  add_submenu_page($parent_slug = 'extra-post-info', $page_title = 'Add Articles', $menu_title = 'Submit Articles', $capability = 'manage_options', $menu_slug = 'submit_info_callback', $function = 'submit_info_callback');
}

add_action( 'admin_menu', 'extra_post_info_menu' );



function jay_table_stylesheet()
{
  wp_enqueue_style( 'wp_enqueue_scripts', plugins_url( '/assets/style.css', __FILE__ ) );
}
add_action('wp_enqueue_scripts', 'jay_table_stylesheet');

/**
 * Display callback for the submenu page.
 * @return string
 */
function submit_info_callback() {
?>

  <h2>Admin submit form</h2>

  <form method="post">
      <label for="Title">title</label>
      <input type="text" name="title" type="text" required style="margin: 8px auto auto; width: 50%; font-family: arial; text-align: left;"/><br>
      <label for="Author">Author</label>
      <input type="text" name="author" type="author" required style="margin: 8px auto auto; width: 50%; font-family: arial; text-align: left;"/><br>
      <label for="url">Website</label>
      <input type="text" name="url" placeholder="Website Source" style="margin: 8px auto auto; width: 50%; font-family: arial; text-align: left;"/><br>
      <label for="Information">Information</label>
      <textarea type="text" name="body" placeholder="Add the body of the Article" style="margin: 8px auto auto; width: 50%; font-family: arial; text-align: left;"></textarea><br>
      <input type="submit" name="submit_submit_form" value="SUBMIT">
  </form>

<?php
}

/**
 * Insert data
 */
function jay_table_insert_data() {

  global $post;
  global $wpdb;

  $submit_table = $wpdb->prefix . '_jay_table';
  
    $body = $_POST['body'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $url = $_POST['url'];

    if(isset($_POST['submit_submit_form'])) {
    $wpdb->insert($submit_table,
      array(
              'body' => $body,
                'title' => $title,
                'author' => $author,
                'url' => $url,
        'time'=> date("Y-m-d")
      ),
    array (
            '%s',
      '%s',
      '%s',
      '%s',
      '%s'
    )
      );

  }
}

add_action('admin_menu','jay_table_insert_data' );

function extra_post_info_page() {

  global $wpdb;
  $table_name = $wpdb->prefix . '_jay_table';
  $db_result = $wpdb->get_results("SELECT * FROM $table_name");
  if (count($db_result) == 0) {
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