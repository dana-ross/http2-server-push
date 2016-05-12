<?php 
class URLParseTest extends PHPUnit_Framework_TestCase {

    public function setUp() {

        \WP_Mock::setUp();
        
        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => array('http://www.example.com/1/2/3'), 'return' => 'http://www.example.com/1/2/3' ) );
        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => array('http://www.example.com/1/2/3/'), 'return' => 'http://www.example.com/1/2/3' ) );
        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => array('https://www.example.com/1/2/3'), 'return' => 'http://www.example.com/1/2/3' ) );
        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => array('https://www.example.com/1/2/3/'), 'return' => 'http://www.example.com/1/2/3' ) );
        \WP_Mock::wpFunction( 'untrailingslashit', array( 'args' => array('//www.example.com/1/2/3/'), 'return' => '//www.example.com/1/2/3' ) );

    }

    public function tearDown() {
        \WP_Mock::tearDown();
    }
    
    /**
     * Basic case
     */
    function test_http2_link_url_to_relative_path() {        
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('http://www.example.com/1/2/3'));
    }
    
    /**
     * Trailing slash
     */
    function test_http2_link_url_to_relative_path_trailing_slash() {
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('http://www.example.com/1/2/3/'));
    }

    /**
     * HTTPS
     */
    function test_http2_link_url_to_relative_path_https() {
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('https://www.example.com/1/2/3'));

    }

    /**
     * Protocol relative
     */
    function test_http2_link_url_to_relative_path_protocol_relative() {
        $this->assertEquals('/1/2/3', http2_link_url_to_relative_path('//www.example.com/1/2/3/'));
    }

}