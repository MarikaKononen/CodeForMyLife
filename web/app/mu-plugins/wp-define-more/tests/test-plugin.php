<?php

class PluginTest extends WP_UnitTestCase {

  // Check that that activation doesn't break
  function test_plugin_activated() {
    $this->assertTrue( is_plugin_active( PLUGIN_PATH ) );
  }

  // Test that all our variables really affect the functions we want them to affect
  function test_should_have_custom_upload_max_size() {
    $this->assertEquals( wp_max_upload_size(), wp_convert_hr_to_bytes( WP_UPLOADS_MAX_SIZE ) );
  }

  function test_should_have_custom_upload_dir() {
    $this->assertEquals( wp_upload_dir()['basedir'], WP_UPLOADS_DIR );
  }

  function test_should_have_custom_upload_url() {
    $this->assertEquals( wp_upload_dir()['baseurl'], WP_UPLOADS_URL );
  }
}
