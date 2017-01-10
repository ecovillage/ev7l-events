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
 * Version:     0.0.2
 * Author:      Felix Wolfsteller
 * Author URI:  https://econya.de
 * Text Domain: 7l-event-post-type
 * License:     AGPL-3.0+
 * License URI: http://www.gnu.org/licenses/agpl-3.0.txt
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/ecovillage/ev7l-events
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


// Required files for registering the referee post type.
require plugin_dir_path( __FILE__ ) . 'includes/referee/class-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/referee/class-post-type-registration.php';

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


# Provided by other plugins, too ...
function prefix_add_metabox_menu_posttype_archive(){
    add_meta_box( 'prefix_metabox_menu_posttype_archive', __( 'Archives' ), 'prefix_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default' );
}
add_action( 'admin_head-nav-menus.php', 'prefix_add_metabox_menu_posttype_archive' );

function prefix_metabox_menu_posttype_archive(){
    $post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );

      if( $post_types ){

            foreach( $post_types as $post_type ){

                    $post_type->classes = array( $post_type->name );
                          $post_type->type = $post_type->name;
                          $post_type->object_id = $post_type->name;
                                $post_type->title = $post_type->labels->name;
                                $post_type->object = 'cpt_archive';

                                    }

                $walker = new Walker_Nav_Menu_Checklist( array() );?>
    <div id="cpt-archive" class="posttypediv">
      <div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
        <ul id="ctp-archive-checklist" class="categorychecklist form-no-clear"><?php
        echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $post_types ), 0, (object) array( 'walker' => $walker ) );?>
        </ul>
      </div>
    </div>
    <p class="button-controls">
      <span class="add-to-menu">
        <input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
      </span>
    </p><?php

      }

}

function prefix_cpt_archive_menu_filter( $items, $menu, $args ){

    foreach( $items as &$item ){
          if( $item->object != 'cpt_archive' ) continue;
              $item->url = get_post_type_archive_link( $item->type );
              if( get_query_var( 'post_type' ) == $item->type ){
                      $item->classes []= 'current-menu-item';
                            $item->current = true;
                          }
                }
      return $items;

}
add_filter( 'wp_get_nav_menu_items', 'prefix_cpt_archive_menu_filter', 10, 3 );


// TODO Only need this in admin section
// Add metaboxes to pages, posts.
require plugin_dir_path( __FILE__ ) . 'includes/event-category/class-post-type-metaboxes.php';
// Initialize metaboxes
$post_type_metaboxes = new Event_Category_Post_Type_7L_Metaboxes;
$post_type_metaboxes->init();

