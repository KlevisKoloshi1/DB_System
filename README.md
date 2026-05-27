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

## Prerequisites

- PHP 8.3+ with extensions: `pdo_pgsql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Composer 2.x
- Node.js 18+ and npm
- PostgreSQL 14+ (required for views, functions, and triggers)

## Installation and Environment Setup

### 1. Clone and install dependencies

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Configure PostgreSQL

Create an empty database in PostgreSQL (example name: `DB_System`):

```sql
CREATE DATABASE "DB_System";
```

Edit `.env` and set the database connection:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=DB_System
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 3. Run migrations

This creates all tables, indexes, the `monthly_sales_summary` view, and PostgreSQL stock triggers. The default `DatabaseSeeder` is intentionally empty.

```bash
php artisan migrate
```

To reset the database during development:

```bash
php artisan migrate:fresh
```

### 4. (Optional) Load Albanian sample data

To populate the app with demo records in Albanian (categories, suppliers, customers, products, orders, stock movements, and payments), run:

```bash
php artisan db:seed --class=KlevisAlbanianSampleSeeder
```

Re-running this seeder updates the demo user password and role; it skips business data if categories already exist.

**Demo admin account (after running the seeder above):**

| Field    | Value                         |
|----------|-------------------------------|
| Email    | `kleviskoloshi8@gmail.com`    |
| Password | `Klevis2008`                  |
| Role     | `admin`                       |

Without the sample seeder, register the first user at `/register` — that account becomes `admin`; later registrations are `user`.

### 5. Start the application

In one terminal:

```bash
php artisan serve
```

In another terminal (frontend assets):

```bash
npm run dev
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) and sign in at `/login`.

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

## Initial Data Policy

- `php artisan migrate` leaves the database empty (no users or business records).
- `DatabaseSeeder` is intentionally blank so production-style installs stay clean.
- Use `KlevisAlbanianSampleSeeder` when you need Albanian demo data for development, demos, or grading.
- Otherwise, create accounts and records through the UI (`/register`, CRUD modules).

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
php artisan migrate:fresh
php artisan db:seed --class=KlevisAlbanianSampleSeeder
php artisan test
```

Manual checks:

- Log in with the demo account (`kleviskoloshi8@gmail.com` / `Klevis2008`) or register a new user
- Verify login, register, and logout
- Verify admin-only routes (`/categories`, `/reports`) as an `admin` user
- Verify product CRUD, search, and pagination
- Verify dashboard KPIs, monthly sales chart, and recent orders (sample seeder provides completed sales)
- Verify report tables on `/reports`
