<?php
// Add a menu item for the plugin in the WordPress admin
function aica_add_menu()
{
    add_menu_page(
        'AI Content Assistant', // Page title
        'AI Content Assistant', // Menu title
        'manage_options',       // Capability
        'ai-content-assistant', // Menu slug
        'aica_settings_page',   // Callback function
        'dashicons-edit'        // Icon
    );
}
add_action('admin_menu', 'aica_add_menu');

// Settings page content
function aica_settings_page()
{
?>
    <div class="wrap">
        <h1>AI Content Assistant Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('aica_options_group');
            do_settings_sections('ai-content-assistant');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// Register settings
function aica_register_settings()
{
    register_setting('aica_options_group', 'aica_api_key', 'sanitize_text_field');
    add_settings_section('aica_main_section', 'API Settings', null, 'ai-content-assistant');
    add_settings_field('aica_api_key', 'API Key', 'aica_api_key_callback', 'ai-content-assistant', 'aica_main_section');
}
add_action('admin_init', 'aica_register_settings');

// API Key field callback
function aica_api_key_callback()
{
    $api_key = get_option('aica_api_key');
    echo '<input type="text" name="aica_api_key" value="' . esc_attr($api_key) . '" class="regular-text">';
}
