<?php
namespace WPVUE\Includes;

class Assets
{

    public function __construct()
    {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'register'], 5);
        } else {
            add_action('wp_enqueue_scripts', [$this, 'register'], 5);
        }
    }

    /**
     * Regsiter Scripts & Styles
     * @since 1.0.0
     */
    public function register()
    {
        $this->register_scripts($this->get_scripts());
        $this->register_styles($this->get_styles());
    }

    /**
     * Register Scritps
     * @since 1.0.0
     */
    public function register_scripts($scripts)
    {
        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;
            $in_footer = isset($script['in_footer']) ? $script['in_footer'] : false;
            $version = isset($script['version']) ? $script['version'] : WPVUE_VERSION;

            wp_register_script($handle, $script['src'], $deps, $version, $in_footer);
        }
    }

    /**
     * Regsiter Styles
     * @since 1.0.0
     */
    public function register_styles($styles)
    {
        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;

            wp_register_style($handle, $style['src'], $deps, WPVUE_VERSION);
        }
    }

    /**
     * Get All Registered Scripts
     * @since 1.0.0
     */
    public function get_scripts()
    {
        $prefix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '.min' : '';

        $scripts = [
            'wpvue-manifest' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/js/manifest.js',
                'deps' => [],
                'version' => \filemtime(WPVUE_PLUGIN_PATH . '/assets/js/manifest.js'),
                'in_footer' => true,
            ],
            'wpvue-vendor' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/js/vendor.js',
                'deps' => ['wpvue-manifest'],
                'version' => \filemtime(WPVUE_PLUGIN_PATH . '/assets/js/vendor.js'),
                'in_footer' => true,
            ],
            'wpvue-admin' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/js/admin.js',
                'deps' => ['wpvue-vender'],
                'version' => \filemtime(WPVUE_PLUGIN_PATH . '/assets/js/admin.js'),
                'in_footer' => true,
            ],
            'wpvue-frontend' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/js/frontend.js',
                'deps' => ['jquery', 'wpvue-vender'],
                'version' => \filemtime(WPVUE_PLUGIN_PATH . '/assets/js/frontend.js'),
                'in_footer' => true,
            ],
        ];

        return $scripts;
    }

    /**
     * Get All Register Styles
     * @since 1.0.0
     */
    public function get_styles()
    {
        $styles = [
            'wpvue-style' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/css/style.css',
            ],
            'wpvue-admin' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/css/admin.css',
            ],
            'wpvue-frontend' => [
                'src' => WPVUE_PLUGIN_URL . '/assets/css/frontend.css',
            ],
        ];

        return $styles;
    }

}