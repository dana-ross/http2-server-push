<?php 
function untrailingslashit($src) { echo '***'.$src. '***';}
class URLParseTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        \WP_Mock::setUp();
    }

    public function tearDown() {
        \WP_Mock::tearDown();
    }
    
    function test_http2_link_url_to_relative_path() {

        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => '/1/2/3', 'return' => '/1/2/3' ) );
        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => '/1/2/3/', 'return' => '/1/2/3' ) );
        
        // Basic case
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('http://www.example.com/1/2/3'));

        // Trailing slash
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('http://www.example.com/1/2/3/'));

        // HTTPS
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('https://www.example.com/1/2/3'));

    }

}