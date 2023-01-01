<?php
/**
 * @link            https://wpagain.com
 * @since           1.0.0
 * @package         Wordpress_Vue_Starter
 *
 * Plugin Name: Wordpress With Vue Broilerplate
 * Plugin URI: https://wpagain.com
 * Description: A Wordpress Vue Starter Broilerplate for plugin development.
 * Version: 1.0.0
 * Author: Mahmud Haisan
 * Author URI: https://mahmud-haisan.com
 * License: GPL v3
 * Text-Domain: textdomain
 */

// forbiden dirrect access
if (!defined('ABSPATH')) {
    exit();
}

/**
 * Require Autoloader
 */
require_once 'vendor/autoload.php';

use WPVUE\Api\Api;
use WPVUE\Includes\Admin;
use WPVUE\Includes\Frontend;

final class Wordpress_Vue_Starter
{

    /**
     * Define Plugin Version
     */
    const VERSION = '1.0.0';

    /**
     * Construct Function
     */
    public function __construct()
    {
        $this->plugin_constants();
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Plugin Constants
     * @since 1.0.0
     */
    public function plugin_constants()
    {
        define('WPVUE_VERSION', self::VERSION);
        define('WPVUE_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
        define('WPVUE_PLUGIN_URL', trailingslashit(plugins_url('', __FILE__)));
        define('WPVUE_NONCE', 'b?le*;K7.T2jk_*(+3&[G[xAc8O~Fv)2T/Zk9N:GKBkn$piN0.N%N~X91VbCn@.4');
    }

    /**
     * Singletone Instance
     * @since 1.0.0
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * On Plugin Activation
     * @since 1.0.0
     */
    public function activate()
    {
        $is_installed = get_option('wpvue_is_installed');

        if (!$is_installed) {
            update_option('wpvue_is_installed', time());
        }

        update_option('wpvue_is_installed', WPVUE_VERSION);
    }

    /**
     * On Plugin De-actiavtion
     * @since 1.0.0
     */
    public function deactivate()
    {
        // On plugin deactivation
    }

    /**
     * Init Plugin
     * @since 1.0.0
     */
    public function init_plugin()
    {
        // init
        new Admin();
        new Frontend();
        new Api();
    }

}

/**
 * Initialize Main Plugin
 * @since 1.0.0
 */
function wordpress_vue_starter()
{
    return Wordpress_Vue_Starter::init();
}

// Run the Plugin
wordpress_vue_starter();