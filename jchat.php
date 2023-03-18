<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jezweb.com.au
 * @since             1.0.0
 * @package           Jchat
 *
 * @wordpress-plugin
 * Plugin Name:       JChat
 * Plugin URI:        https://jezweb.com.au
 * Description:       This is a plugin to integrate GPT's chat to create a human like response system for customers to ask questions about a site's products.
 * Version:           1.0.0
 * Author:            Jezweb
 * Author URI:        https://jezweb.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jchat
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JCHAT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jchat-activator.php
 */
function activate_jchat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jchat-activator.php';
	Jchat_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jchat-deactivator.php
 */
function deactivate_jchat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jchat-deactivator.php';
	Jchat_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jchat' );
register_deactivation_hook( __FILE__, 'deactivate_jchat' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jchat.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jchat() {

	$plugin = new Jchat();
	$plugin->run();

}
run_jchat();

// Load the GPT API library and required files
require_once plugin_dir_path( __FILE__ ) . 'includes/gpt-api-client.php';

// Add your GPT API Key here
define( 'JCHAT_GPT_API_KEY', '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' );

// Enqueue scripts for the front-end chat interface
function jchat_enqueue_scripts() {
    wp_enqueue_style( 'jchat-style', plugin_dir_url( __FILE__ ) . 'public/css/jchat-public.css' );
    wp_enqueue_script( 'jchat-script', plugin_dir_url( __FILE__ ) . 'public/js/jchat-public.js', array( 'jquery' ), JCHAT_VERSION, true );
    wp_localize_script( 'jchat-script', 'jchat_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'jchat_enqueue_scripts' );

// Add AJAX function to handle user input and GPT response
function jchat_ajax_handle_request() {
    if ( isset( $_POST['user_input'] ) ) {
        $user_input = sanitize_text_field( $_POST['user_input'] );

        // Initialize GPT API client
        $gpt_client = new GPT_API_Client( JCHAT_GPT_API_KEY );

        // Call GPT API to get a response
        $gpt_response = $gpt_client->get_response( $user_input );

        // Return the response to the front-end
        wp_send_json_success( array( 'response' => $gpt_response ) );
    }
    wp_send_json_error();
}
add_action( 'wp_ajax_jchat_handle_request', 'jchat_ajax_handle_request' );
add_action( 'wp_ajax_nopriv_jchat_handle_request', 'jchat_ajax_handle_request' );

// Add a shortcode to display the chat interface on the front-end
function jchat_shortcode() {
    ob_start();
    require plugin_dir_path( __FILE__ ) . 'public/partials/jchat-public-display.php';
    return ob_get_clean();
}
add_shortcode( 'jchat', 'jchat_shortcode' );
?>





