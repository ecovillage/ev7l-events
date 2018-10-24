<?php
/**
 * Event Post Type
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

/**
 * Register post type.
 *
 * @package EV7L_Events
 */
class EV7L_Event_Post_Type_Registration {

	public $post_type = 'ev7l-event';

	public function init() {
		// Add the event post type.
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type.
	 *
	 * @uses EV7L_Event_Post_Type_Registration::register_post_type()
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
			'name'               => __( 'Events', 'ev7l-events' ),
			'singular_name'      => __( 'Event',  'ev7l-events' ),
			'add_new'            => __( 'Add Event',  'ev7l-events' ),
			'add_new_item'       => __( 'Add Event',  'ev7l-events' ),
			'edit_item'          => __( 'Edit Event', 'ev7l-events' ),
			'new_item'           => __( 'New Event',  'ev7l-events' ),
			'view_item'          => __( 'View Event', 'ev7l-events' ),
			'search_items'       => __( 'Search Event', 'ev7l-events' ),
			'not_found'          => __( 'No Events found', 'ev7l-events' ),
			'not_found_in_trash' => __( 'No Events in the trash', 'ev7l-events' ),
		);

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'custom-fields',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			//'rewrite'         => array( 'slug' => __('event-category', 'ev7l-events'), ), // Permalinks format, i18n problems (routes)
			'rewrite'         => array( 'slug' => 'event'), // Permalinks format
			'taxonomies'      => array( 'language' ), // polylang/ language support
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-id',
		);

		$args = apply_filters( 'ev7l_event_args', $args );

		register_post_type( $this->post_type, $args );
  }

}
