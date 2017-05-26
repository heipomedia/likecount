<?php
/**
 * Plugin Name: LikeCount
 * Plugin URI: https://heipomedia.de
 * Description: A simple plugin for fetching likes from Facebook, Twitter and Instagram
 * Version: 1.0.0
 * Author: Marc Heiduk
 * Author URI: https://heipomedia.de
 * License: MIT
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin path
define( 'LIKECOUNT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Require Facebook
require_once LIKECOUNT_PLUGIN_PATH . 'inc/facebook.php';

// Require Twitter
require_once LIKECOUNT_PLUGIN_PATH . 'inc/twitter.php';

// Require Instagram
require_once LIKECOUNT_PLUGIN_PATH . 'inc/instagram.php';

// Require optionspage
require_once LIKECOUNT_PLUGIN_PATH . 'optionspage.php';
new LikeCountOptionsPage();
