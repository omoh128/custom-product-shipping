# Custom Product Shipping for WooCommerce

A WordPress plugin that allows setting custom shipping costs for individual products in WooCommerce.

## Features

- Set individual shipping costs per product
- Global shipping settings and rules
- REST API endpoints for programmatic access
- Automatic shipping cost calculation during checkout
- Clear shipping cost breakdown for customers
- Database migrations for version control
- Comprehensive test coverage

## Installation

1. Clone the repository:
```bash
git clone https://github.com/omoh128/custom-product-shipping.git
```

2. Install dependencies:
```bash
composer install
```

3. Activate the plugin through WordPress admin panel.

## Usage

### Admin Settings

1. Navigate to WooCommerce → Custom Shipping
2. Configure global settings:
   - Default shipping cost
   - Free shipping threshold
   - Shipping rules

### Product Settings

1. Edit any product in WooCommerce
2. Find the "Custom Shipping" tab
3. Set the specific shipping cost for that product

### API Endpoints

Base endpoint: `/wp-json/custom-shipping/v1`

#### Get Product Shipping Cost
```
GET /shipping/product/{id}
```

#### Update Product Shipping Cost
```
POST /shipping/product/{id}
{
    "shipping_cost": 10.50
}
```

#### Get Shipping Rules
```
GET /shipping/rules
```

## Development

### Running Tests

```bash
# Run all tests
./vendor/bin/phpunit

# Run specific test suite
./vendor/bin/phpunit --testsuite unit

# Generate coverage report
./vendor/bin/phpunit --coverage-html coverage
```

### Building Assets

```bash
# Install npm dependencies
npm install

# Build for development
npm run dev

# Build for production
npm run build
```

### Database Migrations

Migrations run automatically when the plugin version changes. To manually trigger:

```php
$migrations = new CustomShipping\Database\Migrations();
$migrations->runMigrations();
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

Distributed under the GPL v2 or later. See `LICENSE` for more information.

