<?php
/*
Plugin Name: AI Content Assistant
Description: A WordPress plugin to generate AI-powered content using OpenAI's GPT API.
Version: 1.0
Author: Amanuel
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'inc/settings.php';
require_once plugin_dir_path(__FILE__) . 'inc/meta-box.php';
require_once plugin_dir_path(__FILE__) . 'inc/ajax-handler.php';

// Enqueue scripts and styles
function aica_enqueue_scripts()
{
    wp_enqueue_style('aica-style', plugins_url('assets/style.css', __FILE__));
    wp_enqueue_script('aica-script', plugins_url('assets/script.js', __FILE__), array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'aica_enqueue_scripts');
