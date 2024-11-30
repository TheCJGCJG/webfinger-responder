<?php
class Webfinger_Admin
{
    public function init()
    {
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'add_menu_page'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    function register_settings()
    {
        register_setting('webfinger_options', 'webfinger_path');
        register_setting('webfinger_options', 'webfinger_resource_patterns');
    }

    public function add_menu_page()
    {
        add_options_page(
            'Webfinger Settings',
            'Webfinger',
            'manage_options',
            'webfinger-settings',
            array($this, 'render_options_page')
        );
    }

    public function sanitize_regexps($input)
    {
        if (!is_array($input)) {
            return array();
        }
        return array_filter(array_map('sanitize_text_field', $input));
    }

    public function enqueue_scripts($hook)
    {
        if ('settings_page_webfinger-settings' !== $hook) {
            return;
        }
        wp_enqueue_script(
            'webfinger-admin',
            WEBFINGER_PLUGIN_URL . 'admin/js/webfinger-admin.js',
            array('jquery'),
            '1.2.0',
            true
        );
    }

    public function render_options_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $webfinger_path = get_option('webfinger_path', '/.well-known/webfinger');
        $issuer_url = get_option('issuer_url', '');
        $resource_regexps = get_option('resource_regexps', array('/./'));

        if (!is_array($resource_regexps)) {
            $resource_regexps = array();
        }

        include WEBFINGER_PLUGIN_DIR . 'admin/views/settings-page.php';
    }
}
