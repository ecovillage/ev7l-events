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

function events_in_category_op($category_post_id, $timecomp) {
  $events = new WP_Query( array(
    'post_type'  => 'ev7l-event',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key'     => 'event_category_id',
        'value'   => $category_post_id,
        'compare' => '='
      ),
      array(
        'key'     => 'fromdate',
        'value'   => strtotime('today'),
        'compare' => $timecomp
      )
    ),
    'order'    => 'ASC',
    'meta_key' => 'fromdate',
    'orderby'  => 'meta_value',
    'nopaging' => true) );
  return $events;
}

function upcoming_events_in_category($category_post_id) {
  return events_in_category_op($category_post_id, '>=');
}

function past_events_in_category($category_post_id) {
  return events_in_category_op($category_post_id, '<=');
}

function events_by_referee_op($referee_post_id, $timecomp) {
  $events = new WP_Query( array(
    'post_type'  => 'ev7l-event',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key'     => 'referee_id',
        'value'   => $referee_post_id,
        'compare' => '='
      ),
      array(
        'key'     => 'fromdate',
        'value'   => strtotime('today'),
        'compare' => $timecomp
      )
    ),
    'order'    => 'ASC',
    'meta_key' => 'fromdate',
    'orderby'  => 'meta_value',
    'nopaging' => true) );
  return $events;
}

function upcoming_events_by_referee($referee_post_id) {
  return events_by_referee_op($referee_post_id, '>=');
}

function past_events_by_referee($referee_post_id) {
  return events_by_referee_op($referee_post_id, '<=');
}

function referees_by_event($event_post_id) {
  $referees = new WP_Query( array(
    'post_type' => 'ev7l-referee',
    'post__in'  => get_post_meta( $event_post_id, 'referee_id', false),
    'nopaging'  => true) );
  return $referees;
}
