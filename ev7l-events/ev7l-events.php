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
 * Version:     0.0.1
 * Author:      Felix Wolfsteller
 * Author URI:  https://econya.de
 * Text Domain: 7l-event-post-type
 * License:     AGPL-3.0+
 * License URI: http://www.gnu.org/licenses/agpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/** Custom Post Types (CPT) */
// Required files for registering the event post type.
require plugin_dir_path( __FILE__ ) . 'includes/event/class-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/event/class-post-type-registration.php';
require plugin_dir_path( __FILE__ ) . 'includes/event/queries.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registration = new EV7L_Event_Post_Type_Registration;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type = new EV7L_Event( $post_type_registration );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type, 'activate' ) );

// Initialize registration for post-activation requests.
$post_type_registration->init();


// Required files for registering the event category post type.
require plugin_dir_path( __FILE__ ) . 'includes/event-category/class-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/event-category/class-post-type-registration.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registration_c = new EV7L_Event_Category_Post_Type_Registration;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type_c = new EV7L_Event_Category( $post_type_registration_c );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type_c, 'activate' ) );

// Initialize registration for post-activation requests.
$post_type_registration_c->init();


/** Widgets */
// Add some widgets, too.
require plugin_dir_path( __FILE__ ) . 'includes/widgets/event-list.php';
add_action('widgets_init',
  function(){
      register_widget( 'EventListWidget' );
  });

/** Query vars */
// Query vars used for calendar view.
function event_query_vars_filter($vars) {
  $vars[] = 'eventmonth';
  $vars[] .= 'eventyear';
  return $vars;
}
add_filter( 'query_vars', 'event_query_vars_filter' );

