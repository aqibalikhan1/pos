# Customer Seeder Usage Guide

This guide explains how to use the customer seeder and factory that has been created for your Laravel POS system.

## Files Created

1. **CustomerFactory** (`database/factories/CustomerFactory.php`)
   - Generates realistic customer data using Laravel Faker
   - Includes various states for different customer types
   - Handles unique email generation automatically

2. **CustomerSeeder** (`database/seeders/CustomerSeeder.php`)
   - Seeds 50 random customers using the factory
   - Includes 3 specific test customers for development
   - Called automatically from DatabaseSeeder

## Usage

### Run All Seeders
To seed all data including customers:
```bash
php artisan db:seed
```

### Run Only Customer Seeder
To seed only customers:
```bash
php artisan db:seed --class=CustomerSeeder
```

### Fresh Migration with Seeding
To refresh database and re-seed:
```bash
php artisan migrate:fresh --seed
```

## Factory Usage Examples

### Create Single Customer
```php
$customer = Customer::factory()->create();
```

### Create Multiple Customers
```php
$customers = Customer::factory()->count(10)->create();
```

### Create Active Customer
```php
$activeCustomer = Customer::factory()->active()->create();
```

### Create Tax Filer
```php
$filerCustomer = Customer::factory()->filer()->create();
```

### Create Pakistani Customer
```php
$pakistaniCustomer = Customer::factory()->pakistani()->create();
```

### Create Customer with Complete Address
```php
$completeCustomer = Customer::factory()->withCompleteAddress()->create();
```

### Chain Multiple States
```php
$specialCustomer = Customer::factory()
    ->active()
    ->filer()
    ->pakistani()
    ->create();
```

## Customer Data Structure

Each customer includes:
- **Basic Info**: first_name, last_name, email
- **Contact**: phone, address, city, state, zip_code, country
- **Status**: is_active (boolean), is_filer (boolean)
- **Tax Info**: cnic (13 digits), tax_number (11 digits)
- **Notes**: optional text field

## Test Customers Created

1. **John Doe** - US customer, active filer
2. **Jane Smith** - US customer, active non-filer
3. **Muhammad Ahmed** - Pakistani customer, active filer

These can be used for testing and development purposes.

## Customization

To modify the number of seeded customers, edit the `count()` parameter in CustomerSeeder:
```php
Customer::factory()->count(100)->create(); // Change 50 to desired number
