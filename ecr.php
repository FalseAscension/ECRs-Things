<?php
/**
 * Plugin Name:     Emil Carr-Ross' Things
 * Description:     Custom blocks and fun things I use in my themes
 * Author:          Emil Carr-Ross
 * Version:         1.03
 * Author URI:      http://emilcarr.scot/
 */
define("ECR_PLUGIN_URL", plugin_dir_url(__FILE__));
define("ECR_PLUGIN_DIR", plugin_dir_path(__FILE__));

// Environment variables
require(ECR_PLUGIN_DIR . 'config.php');

// Includes
require(ECR_PLUGIN_DIR . 'includes/db.php'); // ecr_DB Class

require(ECR_PLUGIN_DIR . 'includes/functions.php'); // Functions (for use in templating)
require(ECR_PLUGIN_DIR . 'includes/blocks.php'); // Blocks added by this plugin
require(ECR_PLUGIN_DIR . 'includes/custom-post-types.php'); // Custom post types
require(ECR_PLUGIN_DIR . 'includes/ajax.php'); // Ajax endpoints
require(ECR_PLUGIN_DIR . 'includes/admin.php'); // Admin pages
