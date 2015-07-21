=== Plugin Name ===
Contributors: csixty4
Donate link: http://www.giffordcatshelter.org/
Tags: http2, performance
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 1.0
License: MIT
License URI: http://daveross.mit-license.org/

HTTP/2 is the newest version of the HTTP protocol that powers the Web. Based on the SPDY protocol from Google, it uses multiple binary streams to transmit more than one file over one connection at the same time. Server Push is how an HTTP/2 server starts sending additional files, such as JavaScript and CSS, to the browser before the browser realizes it needs them.

This plugin enables server push for local JavaScript and CSS resources enqueued in the page. Plugins & themes that output tags directly in the page markup won't be affected.

Tested with nghttpx and h2o. LiteSpeed and OpenLiteSpeed do not currently support server push, but this plugin is expected to work seamlessly once they support this feature.

== Description ==

== Installation ==

Install HTTP/2 Server Push automatically from your admin account by selecting "Plugins", then "Add new" from the sidebar menu. Search for HTTP/2 Server Push, then choose "Install Now".

or

Download the latest HTTP/2 Server Push plugin archive from wordpress.org. Unzip the archive and upload the http2_server_push directory to the /wp-content/plugins/ directory on your WordPress site. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==
