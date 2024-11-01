<?php
/**
 * Plugin Name: Ship 200 OneByone
 * Plugin URI: http://ship200.com/
 * Description: used for onebyone order processing.
 * Version: 2.4
 * Author: Ship 200
 * Author URI: http://ship200.com/
 * License: GPL2
 */

/** Register custom post type for the plugin use. */

add_action('init', 'ship200onebyone_create_post_type');

function ship200onebyone_create_post_type()
{
    register_post_type('ship200onebyone',
        array(
            'labels' => array(
                'name' => __('Ship200onebyone'),
                'singular_name' => __('Ship200onebyone')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'ship200onebyone'),
            'show_in_menu' => false
        )
    );
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'shiponebyone_add_plugin_action_links');

function shiponebyone_add_plugin_action_links($links)
{
    return array_merge(
        array('settings' => '<a href="options-general.php?page=Ship200-OneByone">Settings</a>'
        ),
        $links
    );
}

/** Step 2 (from text above). */
add_action('admin_menu', 'ship200onebyone_menu');

/** Step 1. */
function ship200onebyone_menu()
{
    add_options_page('Ship200 OneByone', 'Ship200 OneByone', 'manage_options', 'Ship200-OneByone', 'ship200onebyone_options');
}

/** Step 3. */
function ship200onebyone_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    ?>
    <h1>Ship200 OneByone Order</h1>
    <?php

    if (is_plugin_active('woocommerce/woocommerce.php')) {

        ?>
        <?php global $wpdb;
        $settings = $wpdb->get_row($wpdb->prepare( "SELECT * FROM ". $wpdb->prefix . "ship200onebyone WHERE shipid = %d", 1));
        ?>
        <h2 style="color:#393;"> <?php if (isset($_SESSION["success"])) {
                echo $_SESSION["success"];
                unset($_SESSION["success"]);
            }
            ?></h2>
        <form method="post" action="<?php echo esc_attr($_SERVER['PHP_SELF']) . "?page=Ship200-OneByone"; ?>">
            <fieldset style="width: 650px;" class="width2">
                <label style="text-align: left;" for="ship200_key_onebyone">Ship200 Key:</label>
                <input type="text" value="<?php echo esc_attr($settings->ship200key); ?>" name="ship200_key_onebyone" id="ship200_key_onebyone">
                <br>
                <span>
                <br>1. Login in into your Ship200.com account. <br>
                2. On top menu go to "Settings" -> "OneByOne Plugin" <br>
                3. Click "Generate Key for OneByOne Plugin", then insert your key into "Ship200 Key" field on this page.
                 </span>

                <div class="clear">&nbsp;</div>

                <?php
                $shipArray = array(

                    array('value' => "USPS-01", 'label' => 'USPS First-Class Mail'),

                    array('value' => "USPS-02", 'label' => 'USPS Media Mail'),

                    array('value' => "USPS-03", 'label' => 'USPS Parcel Post'),

                    array('value' => "USPS-04", 'label' => 'USPS Priority Mail'),

                    array('value' => "USPS-05", 'label' => 'USPS Express Mail'),

                    array('value' => "USPS-06", 'label' => 'USPS Express Mail International'),

                    array('value' => "USPS-07", 'label' => 'USPS Priority Mail International'),

                    array('value' => "USPS-08", 'label' => 'USPS First Class Mail International'),

                    array('value' => "UPS-01", 'label' => 'UPS Next Day Air'),

                    array('value' => "UPS-01-S", 'label' => 'UPS Next Day Air Signature Required'),

                    array('value' => "UPS-02", 'label' => 'UPS Second Day Air'),

                    array('value' => "UPS-02-S", 'label' => 'UPS Second Day Air Signature Required'),

                    array('value' => "UPS-03", 'label' => 'UPS Ground'),

                    array('value' => "UPS-03-S", 'label' => 'UPS Ground Signature Required'),

                    array('value' => "UPS-04", 'label' => 'UPS Worldwide ExpressSM'),

                    array('value' => "UPS-05", 'label' => 'UPS Worldwide ExpeditedSM'),

                    array('value' => "UPS-06", 'label' => 'UPS Standard'),

                    array('value' => "UPS-07", 'label' => 'UPS Three-Day Select'),

                    array('value' => "UPS-07-S", 'label' => 'UPS Three-Day Select Signature Required'),

                    array('value' => "UPS-08", 'label' => 'UPS Next Day Air Saver'),

                    array('value' => "UPS-08-S", 'label' => 'UPS Next Day Air Saver Signature Required'),

                    array('value' => "UPS-09", 'label' => 'UPS Next Day Air Early A.M. SM'),

                    array('value' => "UPS-09-S", 'label' => 'UPS Next Day Air Early A.M. SM Signature Required'),

                    array('value' => "UPS-10", 'label' => 'UPS Worldwide Express PlusSM'),

                    array('value' => "UPS-11", 'label' => 'UPS Second Day Air A.M.'),

                    array('value' => "UPS-11-S", 'label' => 'UPS Second Day Air A.M. Signature Required'),

                    array('value' => "UPS-12", 'label' => 'UPS Worldwide Saver (Express)'),

                    array('value' => "Fedex-01", 'label' => 'FedEx Ground'),

                    array('value' => "Fedex-01-S", 'label' => 'FedEx Ground Signature Required'),

                    array('value' => "Fedex-04", 'label' => 'FedEx Express Saver'),

                    array('value' => "Fedex-04-S", 'label' => 'FedEx Express Saver Signature Required'),

                    array('value' => "Fedex-05", 'label' => 'FedEx 2Day'),

                    array('value' => "Fedex-05-S", 'label' => 'FedEx 2Day Signature Required'),

                    array('value' => "Fedex-06", 'label' => 'FedEx 2Day AM'),

                    array('value' => "Fedex-06-S", 'label' => 'FedEx 2Day AM Signature Required'),

                    array('value' => "Fedex-07", 'label' => 'FedEx Standard Overnight'),

                    array('value' => "Fedex-07-S", 'label' => 'FedEx Standard Overnight Signature Required'),

                    array('value' => "Fedex-08", 'label' => 'FedEx Priority Overnight'),

                    array('value' => "Fedex-08-S", 'label' => 'FedEx Priority Overnight Signature Required'),

                    array('value' => "Fedex-09-S", 'label' => 'FedEx First Overnight Signature Required'),

                    array('value' => "Fedex-09", 'label' => 'FedEx First Overnight'),

                    array('value' => "Fedex-02", 'label' => 'INTERNATIONAL PRIORITY'),

                    array('value' => "Fedex-03", 'label' => 'INTERNATIONAL ECONOMY'),

                );
                ?>
                <label style="text-align: left;" for="shippingmethod_onebyone">Default Shipping Method:</label>

                <select id="shippingmethod_onebyone" name="shippingmethod_onebyone" class="chosen_select">
                    <?php
                    foreach ($shipArray as $shipping) { ?>
                        <?php
                        switch ($shipping["value"]) {
                            case 'USPS-01':
                                echo '<option disabled="">---- USPS / Stamps.com ----</option>';
                                break;
                            case 'UPS-01':
                                echo '<option disabled="">---- UPS ----</option>';
                                break;
                            case 'Fedex-01':
                                echo '<option disabled="">---- Fedex ----</option>';
                                break;
                        }
                        ?>
                        <option
                            value="<?php echo esc_attr($shipping["value"]); ?>" <?php if ($shipping["value"] == $settings->shippingmethod) { ?> selected="selected" <?php } ?>><?php echo esc_attr($shipping["label"]); ?></option>
                    <?php }
                    ?>
                </select>

                <div class="clear">&nbsp;</div>

                <label style="text-align: left;" for="orderstatustracking_onebyone">Order Status For Update With
                    Tracking:</label>

                <select id="orderstatustracking_onebyone" name="orderstatustracking_onebyone" class="chosen_select">
                    <?php
                    $order_statuses = wc_get_order_statuses();
                    foreach ($order_statuses as $key => $value) {
                        if ($key == $settings->orderstatustracking) echo '<option selected="selected" value="' . esc_attr($key) . '">'; else echo '<option value="' . esc_attr($key) . '">';
                        echo esc_attr($value) . '</option>';
                    } ?>
                </select>

                <div class="clear">&nbsp;</div>

                <label style="text-align: left;" for="tracking_one">Post Back the tracking#?:</label>

                <select id="tracking_one" name="tracking_one" class="chosen_select">
                    <option <?php if ($settings->tracking == "yes") { ?> selected="selected" <?php } ?> value="yes">
                        Yes
                    </option>
                    <option <?php if ($settings->tracking == "no") { ?> selected="selected" <?php } ?> value="no">No
                    </option>
                </select>


                <div class="clear">&nbsp;</div>
                <br>
                <center><input type="submit" class="button" value="Update settings" name="submitModule"></center>

            </fieldset>
        </form>
    <?php } else {
        ?>
        <div><span>Please Activate Woocommerce Plugin First.</span></div>
    <?php }
}

register_activation_hook(__FILE__, 'ship200onebyone_activate');

global $ship_200_onebyone;
$ship_200_onebyone = "2.4";

function ship200onebyone_activate()
{
    global $wpdb;
    global $ship_200_onebyone;

    $table_name = $wpdb->prefix . "ship200onebyone";

    applyWooCommercePatch();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
  shipid int NOT NULL AUTO_INCREMENT,
  ship200key text NOT NULL,
  shippingmethod VARCHAR(55) NOT NULL,
  orderstatustracking VARCHAR(55) NOT NULL,
  tracking VARCHAR(55) NOT NULL,
  PRIMARY KEY ( shipid )
  );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option("ship_200_onebyone", $ship_200_onebyone);

    $args = array(
        'name' => 'ship200-onebyone',
        'post_type' => 'ship200onebyone'
    );
    $my_posts = get_posts($args);
    if (count($my_posts) > 0) {

    } else {
        ship200onebyone_createpage();
    }
}

register_deactivation_hook(__FILE__, 'ship200onebyone_deactivate');

function ship200onebyone_deactivate()
{
    global $wpdb;
    global $ship_200_onebyone;

    applyWooCommercePatch(true);
}

function ship200onebyone_createpage()
{
    // Create post object
    $postInfo = array(
        'post_title' => 'Ship200 OneByone',
        'post_type' => 'ship200onebyone',
        'post_name' => 'ship200-onebyone',
        'post_content' => '[ship200onebyoneget]',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_category' => '',
        'post_template' => 'Ship200onebyone'
    );

// Insert the post into the database
    $post_id = wp_insert_post($postInfo);
}

//for insert data into database

if (isset($_POST["ship200_key_onebyone"]) && isset($_POST["shippingmethod_onebyone"]) && isset($_POST["orderstatustracking_onebyone"]) && isset($_POST["tracking_one"])) {

    global $wpdb;
    $table_name = $wpdb->prefix . "ship200onebyone";
    $ship_data = $wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "ship200onebyone");
    if ($ship_data == 1) {
        $wpdb->query($wpdb->prepare("UPDATE `" . $wpdb->prefix . "ship200onebyone` SET ship200key = '%s' , shippingmethod = '%s', orderstatustracking = '%s', tracking = '%s' where shipid=1", sanitize_text_field($_POST["ship200_key_onebyone"]) ,sanitize_text_field($_POST["shippingmethod_onebyone"]), sanitize_text_field($_POST["orderstatustracking_onebyone"]), sanitize_text_field($_POST["tracking_one"]) ));

        $_SESSION["success"] = "Your Data Saved Successfully";
    } else {
        $wpdb->query($wpdb->prepare("INSERT INTO `" . $wpdb->prefix . "ship200onebyone` SET ship200key = '%s' , shippingmethod = '%s', orderstatustracking = '%s', tracking = '%s'", sanitize_text_field($_POST["ship200_key_onebyone"]) ,sanitize_text_field($_POST["shippingmethod_onebyone"]), sanitize_text_field($_POST["orderstatustracking_onebyone"]), sanitize_text_field($_POST["tracking_one"]) ));
        $_SESSION["success"] = "Your Data Saved Successfully";
    }
}

add_shortcode('ship200onebyoneget', 'getshiponebyonedata');

function getshiponebyonedata()
{
    require_once('ship200onebyone_getData.php');
}

add_filter('template_include', 'include_onebyone_template_function', 1);

function include_onebyone_template_function($template_path)
{
    if (get_post_type() == 'ship200onebyone') {
        if (is_single()) {
            if ($theme_file = locate_template(array('single-ship200onebyone.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/single-ship200onebyone.php';
            }
        }
    }
    return $template_path;
}

function applyWooCommercePatch($remove = false)
{
    $path_to_file = WP_PLUGIN_DIR  . '/woocommerce/includes/admin/meta-boxes/class-wc-meta-box-order-data.php';

    if ($remove) {
        if (is_writable($path_to_file)) {
            $string_find = file_get_contents(plugin_dir_path(__FILE__) . '/ship200woocommerce_patch.php');
            $string_replace = '<div class="panel-wrap woocommerce">';

            $file_contents = file_get_contents($path_to_file);
            $file_contents = str_replace($string_find, $string_replace, $file_contents);
            file_put_contents($path_to_file, $file_contents);
        }
    } else {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            echo 'Please Install and Activate Woocommerce Plugin First.';
            exit();
        }
        if (!is_writable($path_to_file)) {
            echo 'Unable to apply patch on \'' . $path_to_file . '\' file';
            echo '<br/>Set 777 permissions on that file or chown it to apache running user and try again...';
            exit();
        }

        $string_find = '<div class="panel-wrap woocommerce">';
        $string_replace = file_get_contents(plugin_dir_path(__FILE__) . '/ship200woocommerce_patch.php');

        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace($string_find, $string_replace, $file_contents);
        file_put_contents($path_to_file, $file_contents);
    }
}

function ship200_onebyone_enqueue($hook) {
    if ( 'post.php' != $hook )
        return;

    wp_enqueue_style( 'ship200_onebyone_styles', plugin_dir_url( __FILE__ ) . 'style.css' );
}
add_action( 'admin_enqueue_scripts', 'ship200_onebyone_enqueue' );