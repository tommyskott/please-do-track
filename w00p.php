<?php
  /*
    Plugin Name:  Please Do Track!
    Plugin URI:   https://github.com/tommyskott/please-do-track
    Description:  A simple WordPress plugin for clearing WordPress oembed cache and disabling "Do Not Track" (dnt), on Vimeo embeds.
    Version:      1.1.0
    Author:       Borgenfalk &amp; Skott
    Author URI:   https://borgenfalk.se
    License:      MIT
    License URI:  https://github.com/tommyskott/please-do-track/blob/master/LICENSE
    Text Domain:  BS_CPT
    Domain Path:  /languages
  */

  defined('ABSPATH') or die('No script kiddies please!');
  define('BS_CPT_TXT_DOMAIN', 'BS_CPT');

  register_activation_hook(__FILE__, function(){
    // clear oembed caches
    global $wpdb;
    $wpdb->query( 'DELETE FROM `' . $wpdb->postmeta . '` WHERE `meta_key` LIKE "_oembed%"' );

    BS_CPT_init();
    flush_rewrite_rules();
  });

  register_deactivation_hook(__FILE__, function(){
    flush_rewrite_rules();
  });

  add_action('init', function(){
    BS_CPT_init();
  });

  function BS_CPT_init(){
    load_plugin_textdomain(BS_CPT_TXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');
  }

  function BS_CPT_oembed($provider){
    if(strpos($provider, 'vimeo.com') !== false){
      $provider = remove_query_arg('dnt', $provider);
    }
    return $provider;
  }
  add_filter('oembed_fetch_url', 'BS_CPT_oembed');

?>
