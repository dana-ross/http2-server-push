# HTTP/2 Server Push for WordPress

HTTP/2 is the newest version of the HTTP protocol that powers the Web. Based on the SPDY protocol from Google, it uses multiple binary *streams* to transmit more than one file over one connection at the same time. *Server Push* is how an HTTP/2 server starts sending additional files, such as JavaScript and CSS, to the browser before the browser realizes it needs them.

This plugin enables server push for local JavaScript and CSS resources enqueued in the page. Plugins & themes that
output tags directly in the page markup won't be affected.

Tested with [nghttpx](https://nghttp2.org/documentation/nghttpx-howto.html) and [h2o](https://h2o.examp1e.net). LiteSpeed and OpenLiteSpeed do not currently support server push, but this plugin is expected to work seamlessly once they support this feature.

## WordPress 4.6 and above
WordPress 4.6 introduced [native support for resource hints](https://make.wordpress.org/core/2016/07/06/resource-hints-in-4-6/).
By default, this plugin defers to WordPress 4.6 and theme/plugin developers to responsibly prefetch the right assets. Sites running
on older versions of WordPress will continue to get the previous behavior where all JavaScript and stylesheets had resource hints
printed for them.

I've added a filter To restore the old behavior (hint everything) on WordPress 4.6 and above. To use it, add this line to
your theme's functions.php file or a custom plugin:

`add_filter('http2_render_resource_hints', '__return_true');`

## License
[MIT](http://daveross.mit-license.org/)

> Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:
  
>  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
  
>  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.

A copy of the license is included in the root of the plugin’s directory. The file is named LICENSE.

See [why I contribute to open source software](https://davidmichaelross.com/blog/contribute-open-source-software/).
