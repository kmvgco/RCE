<?php
/*
Plugin Name: Responsive CSS Editor
Description: A CSS editor for Desktop, Tablet, and Mobile views.
Version: 1.0
Author: Tyler Thomas
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Hook to add an admin menu
add_action('admin_menu', 'responsive_css_editor_menu');

function responsive_css_editor_menu() {
    add_menu_page(
        'Responsive CSS Editor',
        'CSS Editor',
        'manage_options',
        'responsive-css-editor',
        'responsive_css_editor_page',
        'dashicons-admin-customizer',
        100
    );
}

function responsive_css_editor_page() {
    ?>
    <div class="wrap">
        <h1>Responsive CSS Editor</h1>
        <div id="responsive-css-editor-tabs">
            <ul>
                <li><a href="#desktop-css">Desktop</a></li>
                <li><a href="#tablet-css">Tablet</a></li>
                <li><a href="#mobile-css">Mobile</a></li>
            </ul>
            <div id="desktop-css">
                <textarea id="desktop-css-code" rows="10" cols="50"><?php echo esc_textarea(get_option('desktop_css')); ?></textarea>
            </div>
            <div id="tablet-css">
                <textarea id="tablet-css-code" rows="10" cols="50"><?php echo esc_textarea(get_option('tablet_css')); ?></textarea>
            </div>
            <div id="mobile-css">
                <textarea id="mobile-css-code" rows="10" cols="50"><?php echo esc_textarea(get_option('mobile_css')); ?></textarea>
            </div>
        </div>
        <button id="save-css-button" class="button-primary">Save CSS</button>
    </div>
    <?php
}

// Enqueue scripts and styles
add_action('admin_enqueue_scripts', 'responsive_css_editor_scripts');

function responsive_css_editor_scripts($hook) {
    if ($hook != 'toplevel_page_responsive-css-editor') {
        return;
    }

    // jQuery UI for tabs
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_style('jquery-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
    
    // Custom JS and CSS
    wp_enqueue_script('responsive-css-editor-js', plugin_dir_url(__FILE__) . 'responsive-css-editor.js', array('jquery'), null, true);
    wp_enqueue_style('responsive-css-editor-css', plugin_dir_url(__FILE__) . 'responsive-css-editor.css');
}

add_action('wp_ajax_save_responsive_css', 'save_responsive_css');

function save_responsive_css() {
    if (isset($_POST['desktop_css'])) {
        update_option('desktop_css', sanitize_text_field($_POST['desktop_css']));
    }
    if (isset($_POST['tablet_css'])) {
        update_option('tablet_css', sanitize_text_field($_POST['tablet_css']));
    }
    if (isset($_POST['mobile_css'])) {
        update_option('mobile_css', sanitize_text_field($_POST['mobile_css']));
    }

    wp_die(); // This is required to terminate immediately and return a response.
}

add_action('wp_head', 'apply_responsive_css');

function apply_responsive_css() {
    $desktop_css = get_option('desktop_css');
    $tablet_css = get_option('tablet_css');
    $mobile_css = get_option('mobile_css');

    echo '<style type="text/css">';
    if ($desktop_css) {
        echo esc_html($desktop_css);
    }
    if ($tablet_css) {
        echo '@media (max-width: 768px) {' . esc_html($tablet_css) . '}';
    }
    if ($mobile_css) {
        echo '@media (max-width: 480px) {' . esc_html($mobile_css) . '}';
    }
    echo '</style>';
}
