<?php

namespace CustomShipping\Tests\Unit\API;

use CustomShipping\API\RestController;
use WP_REST_Request;
use PHPUnit\Framework\TestCase;
use Mockery;

class RestControllerTest extends TestCase
{
    protected $controller;
    protected $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new RestController();
        $this->request = new WP_REST_Request();
    }

    public function testGetProductShipping()
    {
        $this->request->set_param('id', 1);
        
        $response = $this->controller->getProductShipping($this->request);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('shipping_cost', $response);
    }

    public function testUpdateProductShipping()
    {
        $this->request->set_param('id', 1);
        $this->request->set_param('shipping_cost', 10.50);
        
        $response = $this->controller->updateProductShipping($this->request);
        
        $this->assertIsArray($response);
        $this->assertArrayHasKey('message', $response);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

