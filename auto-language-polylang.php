<?php
/**
 * Plugin Name: Auto Language Polylang
 * Description: Détecte automatiquement la langue du contenu et la définit dans Polylang
 * Version: 1.0
 * Author: Martin SCAURI
 * Requires PHP: 7.2
 */

if (!defined('ABSPATH')) {
    exit;
}

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (!is_plugin_active('polylang/polylang.php')) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p>Le plugin Auto Language Polylang nécessite que Polylang soit installé et activé.</p></div>';
    });
    return;
}

require_once plugin_dir_path(__FILE__) . 'includes/class-auto-language-polylang.php';

function init_auto_language_polylang() {
    $plugin = new Auto_Language_Polylang();
    $plugin->init();
}
add_action('plugins_loaded', 'init_auto_language_polylang');