<?php
namespace CustomShipping\Tests\Unit\Admin;

use CustomShipping\Admin\Settings;
use PHPUnit\Framework\TestCase;
use Mockery;

class SettingsTest extends TestCase
{
    protected $settings;

    protected function setUp(): void
    {
        parent::setUp();
        $this->settings = new Settings();
    }

    public function testSanitizeSettings()
    {
        $input = [
            'default_shipping' => '10.50',
            'free_shipping_threshold' => '100.00'
        ];
        
        $sanitized = $this->settings->sanitizeSettings($input);
        
        $this->assertEquals(10.50, $sanitized['default_shipping']);
        $this->assertEquals(100.00, $sanitized['free_shipping_threshold']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}


