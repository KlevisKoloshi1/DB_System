# ERD Overview - Inventory & Sales Management

## Core Tables

- `users` (id, name, email, password, role)
- `categories` (id, name, slug)
- `suppliers` (id, profile columns)
- `customers` (id, profile columns)
- `products` (id, category_id, supplier_id, pricing, stock columns)
- `sales_orders` (id, customer_id, user_id, totals, status, date)
- `sales_order_items` (id, sales_order_id, product_id, qty, unit_price, line_total)
- `purchase_orders` (id, supplier_id, user_id, totals, status, date)
- `purchase_order_items` (id, purchase_order_id, product_id, qty, unit_cost, line_total)
- `payments` (id, sales_order_id, amount, method, paid_at)
- `stock_movements` (id, product_id, type, qty, reference_type, reference_id, created_by)

## Cardinality

- One `category` has many `products`
- One `supplier` has many `products` and many `purchase_orders`
- One `customer` has many `sales_orders`
- One `sales_order` has many `sales_order_items` and many `payments`
- One `purchase_order` has many `purchase_order_items`
- One `product` appears in many sales/purchase detail rows
- One `product` has many stock movements
- One `user` can create many sales/purchase/stock rows

## Business Integrity

- Foreign keys enforce referential integrity
- Composite unique constraints prevent duplicate product lines per order
- Trigger + function keep `products.current_stock` synchronized with movements
- Soft deletes preserve history for master data and transaction headers
