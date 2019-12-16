<?php
/**
 * Ecovillage 7 Linden Event System
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 *
 * @wordpress-plugin
 * Plugin Name: 7L Events
 * Plugin URI:  https://github.com/ecovillage/ev7l-events
 * Description: Enables post types 'Event', 'Event Category' and 'Referee',
 *              provides functionality like widgets to be used in views.
 * Version:     0.3.4
 * Author:      Felix Wolfsteller
 * Author URI:  https://econya.de
 * Text Domain: ev7l-events
 * License:     AGPL-3.0+
 * License URI: http://www.gnu.org/licenses/agpl-3.0.txt
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/ecovillage/ev7l-events
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

if(!defined('EV7L_EVENTS_PLUGIN_URL')) {
  define('EV7L_EVENTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}

/** Custom Post Types (CPT) */
// Required files for registering the event post type.
require EV7L_EVENTS_PLUGIN_DIR . 'includes/event/class-post-type.php';
require EV7L_EVENTS_PLUGIN_DIR . 'includes/event/class-post-type-registration.php';
require EV7L_EVENTS_PLUGIN_DIR . 'includes/event/queries.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registration = new EV7L_Event_Post_Type_Registration;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type = new EV7L_Event( $post_type_registration );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type, 'activate' ) );

// Initialize registration for post-activation requests.
$post_type_registration->init();


// Required files for registering the event category post type.
require EV7L_EVENTS_PLUGIN_DIR . 'includes/event-category/class-post-type.php';
require EV7L_EVENTS_PLUGIN_DIR . 'includes/event-category/class-post-type-registration.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registration_c = new EV7L_Event_Category_Post_Type_Registration;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type_c = new EV7L_Event_Category( $post_type_registration_c );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type_c, 'activate' ) );

// Initialize registration for post-activation requests.
$post_type_registration_c->init();


// Required files for registering the referee post type.
require EV7L_EVENTS_PLUGIN_DIR . 'includes/referee/class-post-type.php';
require EV7L_EVENTS_PLUGIN_DIR . 'includes/referee/class-post-type-registration.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registration_r = new EV7L_Referee_Post_Type_Registration;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type_r = new EV7L_Referee( $post_type_registration_r );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type_r, 'activate' ) );

// Initialize registration for post-activation requests.
$post_type_registration_r->init();


/** Widgets */
// Add some widgets, too.
require EV7L_EVENTS_PLUGIN_DIR . 'includes/widgets/event-list.php';
require EV7L_EVENTS_PLUGIN_DIR . 'includes/widgets/event-list-alx.php';
add_action('widgets_init',
  function(){
      register_widget( 'EventListWidget' );
      register_widget( 'EventListAlxWidget' );
  });

/** Query vars */
// Query vars used for calendar view.
function event_query_vars_filter($vars) {
  $vars[] = 'eventmonth';
  $vars[] .= 'eventyear';
  return $vars;
}
add_filter( 'query_vars', 'event_query_vars_filter' );

// Add metaboxes to pages, posts.
require EV7L_EVENTS_PLUGIN_DIR . 'includes/event-category/class-post-type-metaboxes.php';
// Initialize metaboxes
$post_type_metaboxes = new Event_Category_Post_Type_7L_Metaboxes;
$post_type_metaboxes->init();

function ev7l_load_textdomain() {
load_plugin_textdomain( 'ev7l-events', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('plugins_loaded', 'ev7l_load_textdomain');
