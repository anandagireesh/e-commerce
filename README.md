# E-commerce API

A robust e-commerce REST API built with Laravel, featuring comprehensive order management, inventory tracking, and role-based authentication.

## Features

-   **Authentication & Authorization**

    -   JWT-based authentication
    -   Role-based access control (Admin, Customer)
    -   Secure password management

-   **Order Management**

    -   Create and manage orders
    -   Automatic inventory tracking
    -   Order status management
    -   Order history

-   **Product Management**
    -   Product CRUD operations
    -   Stock management
    -   Product categorization

## Requirements

-   PHP 8.1 or higher
-   Composer
-   MySQL 5.7 or higher
-   Laravel 12.x

## Installation

1. Clone the repository

```bash
git clone [repository-url]
cd [project-directory]
```

2. Install dependencies

```bash
composer install
```

3. Create environment file

```bash
cp .env.example .env
```

4. Generate application key

```bash
php artisan key:generate
```

5. Run migrations

```bash
php artisan migrate
```

6. Seed data

```bash
php artisan db:seed
```

7. Configure S3 Storage

Add the following variables to your `.env` file:

```bash
AWS_ACCESS_KEY_ID=your_access_key_id
AWS_SECRET_ACCESS_KEY=your_secret_access_key
AWS_DEFAULT_REGION=your_region
AWS_BUCKET=your_bucket_name
```

8. Run tests

```bash
php artisan test
```

9. Run server

```bash
php artisan serve
```

## Security

For any security vulnerabilities, please email [your-email@example.com]

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
