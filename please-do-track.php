<?php
  /*
    Plugin Name:  Please Do Track!
    Plugin URI:   https://github.com/tommyskott/please-do-track
    Description:  A simple WordPress plugin for clearing WordPress oembed cache and disabling "Do Not Track" (dnt), on Vimeo embeds.
    Version:      1.2.0
    Author:       Borgenfalk &amp; Skott
    Author URI:   https://borgenfalk.se
    License:      MIT
    License URI:  https://github.com/tommyskott/please-do-track/blob/master/LICENSE
    Text Domain:  bs_pls
    Domain Path:  /languages
  */

  defined('ABSPATH') or die('No script kiddies please!');
  define('BS_PLS_TXT_DOMAIN', 'bs_pls');

  register_activation_hook(__FILE__, function(){
    if(is_admin()){
      // clear oembed caches
      global $wpdb;
      $wpdb->query( 'DELETE FROM `' . $wpdb->postmeta . '` WHERE `meta_key` LIKE "_oembed%"' );
    }

    bs_pls_init();
  });

  add_action('init', function(){
    bs_pls_init();
  });

  function bs_pls_init(){
    load_plugin_textdomain(BS_PLS_TXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages');
  }

  add_filter('oembed_fetch_url', function($provider){
    if(strpos($provider, 'vimeo.com') !== false){
      $provider = remove_query_arg('dnt', $provider);
    }
    return $provider;
  });
?>
