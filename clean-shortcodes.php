<?php
/**
 * Plugin Name: Hide all Fusion Builder and Visual Composer Shortcodes (Cleaner)
 * Plugin URI: https://themightymo.com
 * Description: Removes specified shortcodes tags but keeps their inner content.
 * Version: 1.0.1
 * Author: The Mighty Mo! Design Co. LLC
 * Author URI: https://themightymo.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: shortcode-cleaner
 * Domain Path: /languages
 */

function remove_shortcode_tags_only($content) {
    // Shortcodes with closing tags
    $paired_shortcodes = [
        'vc_row',
        'vc_column',
        'vc_button',
        'fusion_builder_container',
        'fusion_builder_row',
        'fusion_builder_column',
        'fusion_text',
        'fsn_row',
        'fsn_column',
        'fsn_text'
    ];

    // Standalone shortcodes (no closing tag)
    $standalone_shortcodes = [
        // Add any shortcodes that don't have a closing tag here
        // e.g. 'fsn_something' if it never closes
    ];

    // First, remove standalone shortcodes (since we don't capture inner content)
    foreach ($standalone_shortcodes as $shortcode) {
        $shortcode_escaped = preg_quote($shortcode, '/');
        $pattern = '/\[' . $shortcode_escaped . '[^\]]*\]/'; // No closing tag needed
        $content = preg_replace($pattern, '', $content);
    }

    // Now handle paired shortcodes, preserving their inner content
    foreach ($paired_shortcodes as $shortcode) {
        $shortcode_escaped = preg_quote($shortcode, '/');
        $pattern = '/\[' . $shortcode_escaped . '[^\]]*\](.*?)\[\/' . $shortcode_escaped . '\]/s';
        $content = preg_replace($pattern, '$1', $content);
    }

    return $content;
}

add_filter('the_content', 'remove_shortcode_tags_only');
