# EV7L Events

Event model as wordpress plugin for ecovillage Sieben Linden homepage (siebenlinden.org).

Its functionality comes to live with the Sieben Linden hueman theme child (http://github.com/ecovillage/ev7l-hueman-child-theme).

Events can be pushed with ruby scripts included in [wp_event](https://github.com/ecovillage/wp_event).

By Freundeskreis Sieben Linden e.V.

## Content

Derived from https://github.com/devinsays/team-post-type .

Use `create-wp-plugin-archive.sh` to create an uploaded plugin archive for Wordpress.

## Usage

The plugin ships with a Widget to show events in a list, some query functions to access events in a loop and registers two query vars that can come handy when creating calendar like views (in a theme).

An examplary theme can be found at the [7L hueman child theme](https://github.com/ecovillage/hueman-7l-child) .

## Description

Events (`ev7l-event`), Event Categories (`ev7l-event-category`) and Referees (`ev7l-referee`) are modeled as Custom Post Types (CPT) with special Custom Fields (metadata).

Following relationships exist:
  1. Event <-> EventCategory (many-to-many)
  2. Event <-> Referee (many-to-many)

Spelled out:

  - an **Event** can have multiple **EventCategory**s
  - an **EventCategory** can have multiple **Event**s
  - an **Event** can have multiple **Referee**s (with a `qualification` for that event)
  - a **Referee** can have multiple **Event**s

Relationships are modeled with Custom Fields (post metadata), storing the `Post ID` in a one-way fashion (it sits at the **Event**).  The custom fields are named `event_category_id` and `referee_id`.

Common to all three CPTs is an `UUID` field to uniquely identify an entity (but, as mentioned above, the `Post ID` is used for cross-references!).

### CPT ev7l-event

Custom fields:

| Field                      | Multiple? | Semantic |
| -------------------------- | --------- | -------- |
| UUID                       | false     | Unique identifier |
| event_category_id          | true      | post id of an evl7-event-category |
| referee_id                 | true      | post id of an evl7-referee |
| referee_<id>_qualification | false     | post id of an evl7-referee |
| todate                     | false     | starting date/time (as unix timestamp) |
| fromdate                   | false     | ending date/time (as unix timestamp) |

The `referee_<id>_qualification` field deserves separate explanation.  Here, `<id>` is to be replaced with the `Post-ID` of a given referee.
That means, if your event has `'referee_id' => 412` and `'referee_id' => 821` there should be respective `referee_412_qualification` and `referee_821_qualification` fields describing the referees qualification specific for the given event.

### CPT ev7l-event-category

Custom fields:

| Field             | Multiple? | Semantic |
| ----------------- | --------- | -------- |
| UUID              | false     | Unique identifier |
| todate            | false     | starting date/time (as unix timestamp) |
| fromdate          | false     | ending date/time (as unix timestamp) |

## Development

### Releases

To release a new zip file to be used as uploadable wordpress plugin call `create-wp-plugin-archive.sh`.  The script will create a zip file which contains the last (git) *tag name* in its name.

To release a new version follow these steps:

  * modify ev7l-events/ev7l-events.php to to use the correct version numner.
  * e.g. `git tag -a "v0.2.0" -m "v0.2.0"`
  * `./create-wp-plugin-archive.sh`

## Lessons learned

PHP Class-Names cannot start with numerics (0..9).

