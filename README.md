# e-PeakPerformanceStore256

A PHP and MySQL e-commerce website for Peak Performance sports products. The site includes a product catalog, customer accounts, shopping cart and checkout pages, wish lists, order history, product and category administration, and repair booking.
Website: http://peakperformance.free.nf/login.php

## Technology

- PHP 8.0+
- MySQL or MariaDB
- Apache (for example, XAMPP)
- HTML, CSS, JavaScript, Bootstrap-based theme assets, and the bundled libraries in `vendor/`

No frontend build step is required.

## Run locally with XAMPP

1. Place the project folder in XAMPP's `htdocs` directory and start Apache and MySQL.
2. Create a MySQL database named `e-peakperformance`.
3. Import the database schema and any seed data. A database export is not included in this repository.
4. If your local setup differs, update the database connection and `BASE_URL` in `files/functions.php`. The default database connection uses `localhost`, user `root`, and an empty password; the default URL assumes the folder is `http://localhost/e-PeakPerformanceStore/`.
5. Copy `files/payfast-code.example.php` to `files/payfast-code.php` and configure your PayFast sandbox merchant credentials and callback URLs. `files/payfast-code.php` is intentionally excluded from Git.
6. Open `http://localhost/e-PeakPerformanceStore256/` in your browser.

The database schema is required for catalog, account, cart, order, and booking features to work.

## PayFast

The example configuration uses PayFast's sandbox endpoints and placeholder credentials. Replace the placeholders with your sandbox values and configure the base and notification URLs for your local testing setup. Do not commit real merchant credentials or use the sandbox configuration for live payments.

## Project layout

- `files/` — shared PHP components and configuration templates
- `css/`, `js/`, `vendor/` — styling, scripts, and bundled frontend libraries
- `img/` — static site and product images
- `uploads/` — uploaded product images included in this repository
- Root-level PHP files — storefront, account, administration, cart, checkout, payment, and booking pages
