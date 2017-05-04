<?php
/**
 * Queries upcoming events
 *
 * @since 0.0.1
 */
function upcoming_events($limit = 20) {
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
    'posts_per_page' => $limit
    ) );
  return $events;
}

/**
 * Queries upcoming events in current year
 *
 * @since 0.2.1
 */
function upcoming_events_this_year() {
  # "of december this year" might work, too
  $end_of_year = strtotime("last day of december ".date('Y'));
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'fromdate',
        'value' => strtotime('today'),
        'compare' => '>='
      ),
      array(
        'key' => 'fromdate',
        'value' => $end_of_year,
        'compare' => '<='
      )
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'nopaging' => true,
  ) );
  return $events;
}

/**
 * Queries past events in current year
 *
 * @since 0.2.1
 */
function past_events_this_year() {
  $beginning_of_year = strtotime("first day of january". date('Y'));
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'fromdate',
        'value' => strtotime('today'),
        'compare' => '<='
      ),
      array(
        'key' => 'fromdate',
        'value' => $beginning_of_year,
        'compare' => '>='
      )
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'nopaging' => true,
  ) );
  return $events;
}

/**
 * Queries upcoming events in one or more categories.
 *
 * @since 0.0.3
 */
function upcoming_events_in_categories($category_id_array, $limit = 20) {
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => 'fromdate',
        'value' => strtotime('today'),
        'compare' => '>='
      ),
      array(
        'key'     => 'event_category_id',
        'value'   => $category_id_array,
        'compare' => 'IN'
      ),
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'posts_per_page' => $limit
    ) );
  return $events;
}

/**
 * Queries past events
 *
 * @since 0.0.1
 */
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

/**
 * Queries events happening in a given year
 *
 * @since 0.0.1
 */
function events_in_year($eventyear) {
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      array(
        'key' => 'fromdate',
        'value' => strtotime($eventyear . '-1-1'),
        'compare' => '>='
      ),
      array(
        'key' => 'fromdate',
        'value' => strtotime($eventyear . '1231'),
        'compare' => '<='
      )
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'nopaging' => true) );
  return $events;
}

/**
 * Queries events happening in the given month of a given year
 *
 * @since 0.0.1
 */
function events_in_year_month($eventyear, $eventmonth) {
  $month = str_pad($eventmonth, 2, '0', STR_PAD_LEFT);
  $events = new WP_Query( array(
    'post_type' => 'ev7l-event',
    'meta_query' => array(
      array(
        'key' => 'fromdate',
        'value' => strtotime($eventyear . $month . '01'),
        'compare' => '>='
      ),
      array(
        'key' => 'fromdate',
        'value' => strtotime($eventyear . $month . '31'),
        'compare' => '<='
      )
    ),
    'order' => 'ASC',
    'orderby' => 'meta_value',
    'nopaging' => true) );
  return $events;
}

/**
 * Queries events of a category, either before or after NOW.
 *
 * timecomp is either "<=" (before NOW) or ">=" (after NOW).
 *
 * Use the friendlier upcoming_events_in_category and past_events_in_category to avoid setting timecomp yourself (and make your code more readable).
 * @since 0.0.1
 */
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

/**
 * Queries upcoming events of a category
 *
 * @since 0.0.1
 */
function upcoming_events_in_category($category_post_id) {
  return events_in_category_op($category_post_id, '>=');
}

/**
 * Queries past events of a category
 *
 * @since 0.0.1
 */
function past_events_in_category($category_post_id) {
  return events_in_category_op($category_post_id, '<=');
}

/**
 * Queries events of a referee, either before or after NOW.
 *
 * timecomp is either "<=" (before NOW) or ">=" (after NOW).
 *
 * Use the friendlier upcoming_events_by_referee and past_events_by_referee to avoid setting timecomp yourself (and make your code more readable).
 * @since 0.0.1
 */
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

/**
 * Queries upcoming events of a referee
 *
 * @since 0.0.1
 */
function upcoming_events_by_referee($referee_post_id) {
  return events_by_referee_op($referee_post_id, '>=');
}

/**
 * Queries past events of a referee
 *
 * @since 0.0.1
 */
function past_events_by_referee($referee_post_id) {
  return events_by_referee_op($referee_post_id, '<=');
}

/**
 * Queries referees of a given event
 *
 * @since 0.0.1
 */
function referees_by_event($event_post_id) {
  $referee_post_ids = get_post_meta($event_post_id, 'referee_id', false);
  // Needs to be guarded (when nil return for post__in get_post_meta)
  if (empty($referee_post_ids)) { $referee_post_ids = array(0); }

  $referees = new WP_Query( array(
    'post_type' => 'ev7l-referee',
    'post__in'  => $referee_post_ids,
    'nopaging'  => true) );
  return $referees;
}

/**
 * Returns true iff fromdate metadata of post is after the given timestamp.
 *
 * @since 0.1.2
 */
function ev7l_is_after($event_post_id, $date) {
  $start_date = get_post_meta($event_post_id, 'fromdate', true);
  $is_after = ($start_date > $date);
  return $is_after;
}
