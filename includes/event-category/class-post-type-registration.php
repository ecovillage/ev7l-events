<?php
/**
 * Event Category Post Type
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

/**
 * Register post type.
 *
 * @package EV7L_Events
 */
class EV7L_Event_Category_Post_Type_Registration {

	public $post_type = 'ev7l-event-category';

	public function init() {
		// Add the event-category  post type.
		add_action( 'init', array( $this, 'register' ) );
    add_action ( 'pre_get_posts', array ($this, 'set_no_pagination'), 1, 1);
  }

	/**
	 * Use pre_get_posts hook to disable pagination by setting a huge per_page limit. Also set order.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/pre_get_posts
	 */
  public function set_no_pagination($query) {
    if ( ! is_admin() && is_post_type_archive($this->post_type) && $query->is_main_query() )
      {
        $query->set( 'posts_per_page', 60000 );
        $query->set( 'orderby',  'title');
        $query->set( 'order',    'ASC');
      }
  }

	/**
	 * Initiate registrations of post type.
	 *
	 * @uses EV7L_Event_Category_Post_Type_Registrations::register_post_type()
	 */
	public function register() {
		$this->register_post_type();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Event Categories', 'ev7l-events' ),
			'singular_name'      => __( 'Event Category',   'ev7l-events' ),
			'add_new'            => __( 'Add Event Category',  'ev7l-events' ),
			'add_new_item'       => __( 'Add Event Category',  'ev7l-events' ),
			'edit_item'          => __( 'Edit Event Category', 'ev7l-events' ),
			'new_item'           => __( 'New Event Category',  'ev7l-events' ),
			'view_item'          => __( 'View Category', 'ev7l-events' ),
			'search_items'       => __( 'Search Event Category', 'ev7l-events' ),
			'not_found'          => __( 'No Event Category found', 'ev7l-events' ),
			'not_found_in_trash' => __( 'No Event Category in the trash', 'ev7l-events' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'has_archive'     => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => __('event-category', 'ev7l-events'), ), // Permalinks format
			'taxonomies'      => array( 'language' ), // language/polylang support
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-id',
		);

		$args = apply_filters( 'ev7l_event_category_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

}
