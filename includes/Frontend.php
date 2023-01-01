<?php
namespace WPVUE\Includes;

class Frontend
{

    public function __construct()
    {
        add_shortcode('wpvue-app', [$this, 'render_frontend']);
        add_action('wp_enqueue_scripts', [$this, 'register_frontend_scripts_styles']);
    }

    public function register_frontend_scripts_styles()
    {
        $this->load_scripts();
        $this->load_styles();
    }

    public function load_scripts()
    {
        wp_register_script('wpvue-manifest', WPVUE_PLUGIN_URL . 'assets/js/manifest.js', [], 1, true);
        wp_register_script('wpvue-vendor', WPVUE_PLUGIN_URL . 'assets/js/vendor.js', ['wpvue-manifest'], 1, true);
        wp_register_script('wpvue-frontend', WPVUE_PLUGIN_URL . 'assets/js/frontend.js', ['wpvue-vendor'], 1, true);

        wp_enqueue_script('wpvue-manifest');
        wp_enqueue_script('wpvue-vendor');
        wp_enqueue_script('wpvue-frontend');

    }

    public function load_styles()
    {
        wp_register_style('wpvue-admin', WPVUE_PLUGIN_URL . 'assets/css/admin.css');

        wp_enqueue_style('wpvue-admin');
    }

    /**
     * Render Frontend
     * @since 1.0.0
     */
    public function render_frontend($atts, $content = '')
    {
        wp_enqueue_style('wpvue-frontend');
        wp_enqueue_script('wpvue-frontend');

        $content .= '<div id="wpvue-frontend-app"></div>';

        return $content;
    }

}