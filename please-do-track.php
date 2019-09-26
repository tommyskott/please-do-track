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
    Text Domain:  BS_PLS
    Domain Path:  /languages
  */

  defined('ABSPATH') or die('No script kiddies please!');
  define('BS_PLS_TXT_DOMAIN', 'BS_PLS');

  register_activation_hook(__FILE__, function(){
    if(is_admin()){
      // clear oembed caches
      global $wpdb;
      $wpdb->query( 'DELETE FROM `' . $wpdb->postmeta . '` WHERE `meta_key` LIKE "_oembed%"' );
    }

    BS_PLS_init();
    flush_rewrite_rules();
  });

  register_deactivation_hook(__FILE__, function(){
    flush_rewrite_rules();
  });

  add_action('init', function(){
    BS_PLS_init();
  });

  function BS_PLS_init(){
    load_plugin_textdomain(BS_PLS_TXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');
  }

  function BS_PLS_oembed($provider){
    if(strpos($provider, 'vimeo.com') !== false){
      $provider = remove_query_arg('dnt', $provider);
    }
    return $provider;
  }
  add_filter('oembed_fetch_url', 'BS_PLS_oembed');
?>
