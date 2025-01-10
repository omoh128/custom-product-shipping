<?php
namespace CustomShipping\Tests\Unit;

use CustomShipping\Frontend\ShippingCalculator;
use PHPUnit\Framework\TestCase;
use Mockery;

class ShippingCalculatorTest extends TestCase
{
    protected $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new ShippingCalculator();
    }

    public function testCalculateTotalShipping()
    {
        $cart = Mockery::mock('WC_Cart');
        $cart->shouldReceive('get_cart')->andReturn([
            [
                'product_id' => 1,
                'quantity' => 2
            ]
        ]);

        // Test shipping calculation logic
        $result = $this->calculator->calculateShipping($cart);
        $this->assertIsFloat($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
