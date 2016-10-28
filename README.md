# EV7L Events

Event model as wordpress plugin for ecovillage Sieben Linden homepage (siebenlinden.org).

Its functionality comes to live with the Sieben Linden hueman theme child (http://github.com/ecovillage/ev7l-hueman-child-theme).

Events can be pushed with a ruby script (https://github.com/ecovillage/ tba ).

By Freundeskreis Sieben Linden e.V.

## Content

Derived from https://github.com/devinsays/team-post-type .

Use `create-wp-plugin-archive.sh` to create an uploaded plugin archive for Wordpress.

## Usage

The plugin ships with a Widget to show events in a list, some query functions to access events in a loop and registers two query vars that can come handy when creating calendar like views (in a theme).

## Description

Events, Event Categories and Referees are modeled as Custom Post Types (CPT) with special Custom Fields.

Following relationships exist:
  1. Event <-> EventCategory (many-to-many)
  2. Event <-> Referee (many-to-many)

Spelled out:

  - an **Event** can have multiple **EventCategory**s
  - an **EventCategory** can have multiple **Events**
  - an **Event** can have multiple **Referee**s
  - a **Referee** can have multiple **Event**s

Relationships are modeled with Custom Fields, storing the `Post ID` in a one-way fashion (it sits at the **Event**).  The custom fields are named `event_category_id` and `referee_id`.

Common to all three CPTs is an `UUID` field to uniquely identify an entity (but, as mentioned above, the `Post ID` is used for cross-references!).

## Development

### Releases

To release a new zip file to be used as uploadable wordpress plugin call `create-wp-plugin-archive.sh`.  The script will create a zip file which contains the last (git) *tag name* in its name.

To release a new version follow these steps:

  * modify ev7l-events/ev7l-events.php to to use the correct version numner.
  * e.g. `git tag -a "v0.2.0" -m "v0.2.0"`
  * `./create-wp-plugin-archive.sh`

## Lessons learned

PHP Class-Names cannot start with numerics (0..9).

