# HTTP/2 Server Push for WordPress
[![experimental](http://badges.github.io/stability-badges/dist/experimental.svg)](http://github.com/badges/stability-badges)

HTTP/2 is the newest version of the HTTP protocol that powers the Web. Based on the SPDY protocol from Google, it uses multiple binary *streams* to transmit more than one file over one connection at the same time. *Server Push* is how an HTTP/2 server starts sending additional files, such as JavaScript and CSS, to the browser before the browser realizes it needs them.

This plugin enables server push for local JavaScript and CSS resources enqueued in the page. Plugins & themes that
output tags directly in the page markup won't be affected.

Tested with [nghttpx](https://nghttp2.org/documentation/nghttpx-howto.html) and [h2o](https://h2o.examp1e.net).

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
