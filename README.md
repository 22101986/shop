# Shop - E-Commerce Website

## Description
**Shop** is an e-commerce web application built with **Symfony** (PHP framework). This platform allows users to browse products, add them to their cart, and manage their cart items. The application also features a **back-office interface** for administrators to manage products, including adding new products, removing products, and setting prices.

## Features
### User Side
- User registration and authentication
- Browse products
- Add products to cart
- Remove products from cart
- View cart summary
- Checkout process (simulation)

### Admin Side
- Secure admin dashboard
- Add new products
- Update product information (name, price, description, stock...)
- Delete products
- View product list

## Installation
### Prerequisites
- PHP 8.1 or higher
- Composer
- Symfony CLI
- MySQL database

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/22101986/shop.git
   cd shop
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment variables:
   - Copy `.env` file:
     ```bash
     cp .env.example .env
     ```
   - Configure your database credentials in the `.env` file.

4. Database migration:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. Start the server:
   ```bash
   symfony serve
   ```

6. Access the application:
   - User Interface: http://localhost:8000
   - Admin Interface: http://localhost:8000/admin

## Technologies
- PHP (Symfony Framework)
- Twig Templating Engine
- Doctrine ORM
- Bootstrap
- MySQL




