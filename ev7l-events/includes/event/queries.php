<?php
	/**
	 * Queries upcoming events
	 *
	 * @since 0.0.1
	 */
function upcoming_events() {
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      array(
        'key' => 'fromdate',
        'value' => strtotime('today'),
        'compare' => '>='
      )
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'nopaging' => true) );
  return $events;
}

function past_events() {
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      array(
        'key' => 'fromdate',
        'value' => strtotime('today'),
        'compare' => '<='
      )
    ),
    'order' => 'DESC',
    'orderby' => 'meta_value',
    'nopaging' => true) );
  return $events;
}

function events_in_year($eventyear) {
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      array(
        'key' => 'fromdate',
        'value' => strtotime($eventyear . '-1-1'),
        'compare' => '>='
      )
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'nopaging' => true) );
  return $events;
}

