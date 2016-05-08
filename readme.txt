=== Plugin Name ===
Contributors: csixty4
Donate link: http://www.giffordcatshelter.org/
Tags: http2, performance, prefetch
Requires at least: 3.0
Tested up to: 4.5.1
Stable tag: 1.1
License: MIT
License URI: http://daveross.mit-license.org/

Enables HTTP/2 server push for local JavaScript and CSS resources.

== Description ==

HTTP/2 is the new generation of the venerable HTTP protocol that powers the web. Among its most powerful features is *server push*, a way for web servers to send resources to the browser before it even realizes it needs them. This avoids the usual HTTP request/response cycle which happened for every script or stylesheet on a page.

This plugin enables WordPress to send a ```Link:<...> rel="prefetch"``` header for every enqueued script and style as WordPress outputs them into the page source. Unfortunately, it can't help plugins and themes that output their scripts directly into the page itself, but these will continue to work as they always have.

Requires a web server that supports HTTP/2.

== Installation ==

Install HTTP/2 Server Push automatically from your admin account by selecting "Plugins", then "Add new" from the sidebar menu. Search for HTTP/2 Server Push, then choose "Install Now".

or

Download the latest HTTP/2 Server Push plugin archive from wordpress.org. Unzip the archive and upload the http2_server_push directory to the /wp-content/plugins/ directory on your WordPress site. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What if my web server doesn't support HTTP/2 or "server push"? =

Server push is triggered by the same mechanism as *link prefetching*, which almost all major modern browsers support over HTTP 1.x. So even if you can't take advantage of HTTP/2's features, people visiting your site may still get a better experience from prefetching.

= Does this work with LiteSpeed? =

LiteSpeed doesn't currently support server push. But I've been in touch with the LiteSpeed team, and they've confirmed this plugin should just work with their server when support is added.

= How do I know if this is working? =

There are a couple ways:

1. [nghttp](https://www.nghttp2.org/documentation/nghttp.1.html) is an HTTP/2 client that ships with the nghttp2 suite. ```nghttp -v http://example.com``` will show all the HTTP/2 signalling packets, HTTP headers, content, and resources sent from the server in a single request. You can see ```PUSH PROMISE``` signals from the server and the pushed resources after the main page is sent.
2. In Google Chrome, [chrome://net-internals/#spdy](chrome://net-internals/#spdy) will show a history of server connections from the browser. Clicking on a connection will show the discussion between the browser and the server. Within that text, you can see ```PUSH PROMISE``` packets and the pushed resources.

= How can I help with development and testing? =

The source code is available at [https://github.com/daveross/http2-server-push](https://github.com/daveross/http2-server-push). Issues and pull requests are welcome and encouraged!

== Screenshots ==

== Changelog ==

= 1.0 =
* Initial release

= 1.1 =
* Fix errors starting the output buffer through the template_redirect action

== Upgrade Notice ==
