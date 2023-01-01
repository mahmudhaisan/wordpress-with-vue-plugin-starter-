<?php
namespace WPVUE\Api;

use WPVUE\Api\Admin\Settings_Route;
use WP_REST_Controller;

/**
 * Rest API Handler
 */
class Api extends WP_REST_Controller
{

    /**
     * Construct Function
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * Register API routes
     */
    public function register_routes()
    {
        (new Settings_Route())->register_routes();
    }

}