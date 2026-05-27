# Inventory & Sales Management System

Production-style Laravel + PostgreSQL university database project focused on inventory, procurement, customer sales, stock tracking, and analytics.

## Stack
- Laravel 13 (architecture aligned with Laravel 12 requirements)
- PHP 8.3+
- PostgreSQL
- Blade + TailwindCSS
- Eloquent ORM
- Chart.js

## Domain and ERD Explanation
Main entities:
1. `users` (roles: `admin`, `user`)
2. `categories`
3. `suppliers`
4. `customers`
5. `products`
6. `sales_orders`
7. `sales_order_items` (pivot with quantity, price, line total)
8. `purchase_orders`
9. `purchase_order_items` (pivot with quantity, cost, line total)
10. `payments`
11. `stock_movements`

Relationship coverage:
- One-to-many: category-products, supplier-products, customer-sales orders, order-payments
- Many-to-many with attributes: sales orders-products, purchase orders-products
- Role-based auth relation: user-created purchase/sales/stock entries

Normalization:
- Master entities are separated (`products`, `customers`, `suppliers`, `categories`)
- Transactions split into header/detail tables
- No repeating groups, no derived aggregates persisted unnecessarily

## Advanced PostgreSQL Features
- View: `monthly_sales_summary`
- Stored function: `refresh_product_stock(product_id)`
- Trigger: `trg_stock_movement_insert`
- Composite indexes and report-friendly indexes
- Transactional seeding

## Installation and Environment Setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Edit `.env` with PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventory_erp
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

Run database and seed:
```bash
php artisan migrate:fresh --seed
```

Run app:
```bash
php artisan serve
npm run dev
```

## Authentication and Authorization
- Register, Login, Logout
- Role field on users (`admin` / `user`)
- `admin` middleware for restricted modules
- Policy example: `ProductPolicy`

## Main Functional Modules
- Dashboard with KPIs and Chart.js trend
- CRUD: Products, Customers, Suppliers, Categories
- Product search/filter + pagination
- Reports and analytics (joins, aggregates, group by, having)

## Seeder Accounts
- `admin@inventory.local` / `password`
- `test@example.com` / `password`

## Sample SQL Queries
```sql
SELECT c.name, COUNT(so.id) AS total_orders, SUM(so.total_amount) AS total_spent
FROM sales_orders so
JOIN customers c ON c.id = so.customer_id
WHERE so.status = 'completed'
GROUP BY c.id, c.name
HAVING SUM(so.total_amount) > 1000
ORDER BY total_spent DESC
LIMIT 10;
```

```sql
SELECT p.name, SUM(soi.quantity) AS units_sold, SUM(soi.line_total) AS revenue
FROM sales_order_items soi
JOIN products p ON p.id = soi.product_id
GROUP BY p.id, p.name
ORDER BY units_sold DESC
LIMIT 10;
```

```sql
SELECT month_start, orders_count, gross_sales, collected_amount
FROM monthly_sales_summary
ORDER BY month_start DESC
LIMIT 12;
```

## Final Testing Steps
```bash
php artisan migrate:fresh --seed
php artisan test
```
- Verify login/register/logout
- Verify admin-only routes (`/categories`, `/reports`)
- Verify product CRUD + search/filter
- Verify dashboard chart and report tables
