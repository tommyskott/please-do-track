<?php
  /*
    Plugin Name:  w00p
    Plugin URI:   https://github.com/tommyskott/w00p
    Description:  WordPress Hooks
    Version:      1.0.0
    Author:       tommyskott
    Author URI:   https://tommyskott.se
    License:      MIT
    License URI:  https://github.com/tommyskott/w00p/blob/master/LICENSE
    Text Domain:  BS_CPT
    Domain Path:  /languages
  */

  defined('ABSPATH') or die('No script kiddies please!');
  define('BS_CPT_TXT_DOMAIN', 'BS_CPT');

  register_activation_hook(__FILE__, function(){
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

    //if(is_admin()) require_once(dirname(__FILE__) . '/includes/BS_CPT_admin.php');

    // Include CPTs
    //require_once(dirname(__FILE__) . '/includes/BS_CPT_event.php');
  }

?>
