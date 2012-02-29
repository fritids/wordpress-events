=== WordPress Events ===
Contributors: jealousdesigns
Donate link: http://fishcantwhistle.com
Tags: events, event, calendar, gigs, gig, widget, shortcode, display, multiple, users, sharing, google, maps
Requires at least: 3.3.1
Tested up to: 3.3.1
Stable tag: 0.8.4

WordPress Events gives you a simple interface for adding events to your site and displays them in a beautiful calendar with pop up details.

== Description ==

WordPress Events gives you a simple interface for adding events to your site and displays them in a beautiful calendar with pop up details.

Simply add events in an interface you are already used to and display your calendar by adding the shortcode `[calendar]` to any page of post!

New in 0.2 !

Multiple user calendars! Allow individual users to have their own calendar and display different calendars by specifying a user id in the shortcode. For example [calendar user=2] will display the calendar for the user with an ID of 2.

Built in sharing generates tiny urls that when linked to opens the shared event in a pop up just as if the user had clicked on it.

Google maps integration allows you to add a map of the venue.

Download a pdf user guide from here http://fishcantwhistle.com/wp-content/uploads/2012/02/wordpress-events-user-guide.pdf

== Installation ==

1. Upload the folder `wordpress-events` to the `/wp-content/plugins/` directory keeping the file structure.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your first event by clicking on `Events` -> `Add New Event`.
4. Display your events in a page by adding the shortcode `[calendar]` to any page or post. This will display all events from all users.
5. Display your upcoming events with a widget from the widgets admin area.
6. Allow users to have their own calendar by assigning them the role of "Calendar User". They will then be able to log in and add events to their own calendar. 
7. To show a specific user's calendar specify the user ID in the shortcode. For example `[calendar user=2]` will show the calendar for the user with the ID 2.

== Frequently Asked Questions ==

= Is there a widget to quickly display my upcoming events? =

Sure is! Just go to your widgets admin page to use it! (It's called "Events"…). The widget will show all events from all users.



== Screenshots ==

1. See all your events
2. Add/Edit an event
3. Your calendar will display within your theme's style. Here with a custom theme
4. And here within 2011
5. The widget!
6. Integrated sharing
7. Upon clicking on an event in the calendar a pop up will display further info.
8. Add an image to the event.
9. The new user role of "Calendar User".

== Changelog ==

= 0.1 =
* First release

= 0.2 =
* Major feature upgrades

= 0.3 =
*Fixed date format functions for < php 5.3

= 0.4 =
*fixed bug causing user id's to not display

= 0.5 =
*Fixed bug that was showing blank map on pop up

= 0.6 =
*Minor css issues fixed

= 0.7 =
*Calendar users now able to view only their own events as well as delete their own events

= 0.8 =
*added settings page to display author of events

= 0.8.1 =
*Fix svn update error

= 0.8.2 =
*damn those fullstops!

= 0.8.3 =
*Added option to specify the phrase to prepend the author name

= 0.8.4 =
*date field is now populated with current date and time as leaving it blank causes an error

== Upgrade Notice ==

= 0.1 =

First release so no update

= 0.2 =

New support for multiple calendars, google maps and sharing.

= 0.3 =

New support for multiple calendars, google maps and sharing.
Fixed date format bug.

= 0.4 =

Fixed bug causing user id's to not display

= 0.5 =

Fixed bug that was showing blank map on pop up

= 0.6 =

CSS layout issues fixed

= 0.7 =

Calendar users now able to view only their own events as well as delete their own events

= 0.8 =

added settings page to display author of events

= 0.8.1 =

Fix css

= 0.8.2 =

damn those fullstops!

= 0.8.3 =

Added option to specify the phrase to prepend the author name

= 0.8.4 =

date field is now populated with current date and time as leaving it blank causes an error