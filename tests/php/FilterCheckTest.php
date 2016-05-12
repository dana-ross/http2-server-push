<?php 

class FilterCheckTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        \WP_Mock::setUp();
    }

    public function tearDown() {
        \WP_Mock::tearDown();
    }
    
    function test_http2_link_link_as_stylesheet() {
        $this->assertEquals('stylesheet', http2_link_link_as('style_loader_src'));
    }
    
    function test_http2_link_link_as_script() {
        $this->assertEquals('script', http2_link_link_as('script_loader_src'));
    }
    
    function test_http2_link_link_as_default() {
        $this->assertEquals('script', http2_link_link_as(''));
    }
    
}