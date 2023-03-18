<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jezweb.com.au
 * @since      1.0.0
 *
 * @package    Jchat
 * @subpackage Jchat/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jchat
 * @subpackage Jchat/public
 * @author     Jezweb <narelle@jezweb.net>
 */
class Jchat_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jchat-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jchat-public.js', array( 'jquery' ), $this->version, false );

    }

    /**
     * Define the chatbot logic.
     *
     * @since    1.0.0
     */
    public function process_chat_request() {
        if (isset($_POST['chat_request']) && !empty($_POST['chat_request'])) {
                       $input = sanitize_text_field($_POST['chat_request']);

            // Process the chat request here
            // This is just an example response. Replace this with your chatbot logic.
            $response = 'You said: ' . $input;

            // Send the response as a JSON object
            wp_send_json_success($response);
        }
        wp_send_json_error('Invalid chat request');
    }

}

// This action hook is for handling AJAX requests in WordPress.
add_action('wp_ajax_process_chat_request', array(Jchat_Public::class, 'process_chat_request'));
add_action('wp_ajax_nopriv_process_chat_request', array(Jchat_Public::class, 'process_chat_request'));
