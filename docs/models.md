# Laravel Models Documentation

Generated on: 2025-10-29 20:31:12

## Order

**Table:** `orders`

**Primary Key:** `id`

### Database Columns
| Column | Type | Nullable | Default | Attributes | Description |
|--------|------|----------|---------|------------|-------------|
| `id` | bigint | NO | NULL | AUTO_INCREMENT, UNSIGNED | [Description] |
| `user_id` | bigint | NO | NULL | UNSIGNED | [Description] |
| `product_id` | bigint | NO | NULL | UNSIGNED | [Description] |
| `total_price` | decimal | NO | 0.00 |  | [Description] |
| `status` | string | NO | pending |  | [Description] |
| `created_at` | datetime | YES | NULL |  | [Description] |
| `updated_at` | datetime | YES | NULL |  | [Description] |

### Indexes & Constraints
- **INDEX** (`product_id`)
- **PRIMARY KEY** (`id`)
- **INDEX** (`user_id`)

### Eloquent Relationships

### Model Properties
**Fillable Attributes:**
- `user_id`
- `product_id`
- `total_price`
- `status`

**Attribute Casts:**
- `id` => `int`


---

## Payment

**Table:** `payments`

**Primary Key:** `id`

### Database Columns
| Column | Type | Nullable | Default | Attributes | Description |
|--------|------|----------|---------|------------|-------------|
| `id` | bigint | NO | NULL | AUTO_INCREMENT, UNSIGNED | [Description] |
| `order_id` | bigint | NO | NULL | UNSIGNED | [Description] |
| `user_id` | bigint | NO | NULL | UNSIGNED | [Description] |
| `receipt` | string | YES | NULL |  | [Description] |
| `amount` | decimal | NO | 0.00 |  | [Description] |
| `status` | string | NO | pending |  | [Description] |
| `created_at` | datetime | YES | NULL |  | [Description] |
| `updated_at` | datetime | YES | NULL |  | [Description] |

### Indexes & Constraints
- **INDEX** (`user_id`)
- **PRIMARY KEY** (`id`)
- **INDEX** (`order_id`)

### Eloquent Relationships

### Model Properties
**Fillable Attributes:**
- `order_id`
- `user_id`
- `receipt`
- `amount`
- `status`

**Attribute Casts:**
- `id` => `int`


---

## Product

**Table:** `products`

**Primary Key:** `id`

### Database Columns
| Column | Type | Nullable | Default | Attributes | Description |
|--------|------|----------|---------|------------|-------------|
| `id` | bigint | NO | NULL | AUTO_INCREMENT, UNSIGNED | [Description] |
| `user_id` | bigint | NO | NULL | UNSIGNED | [Description] |
| `name` | string | NO | NULL |  | [Description] |
| `description` | text | YES | NULL |  | [Description] |
| `price` | decimal | NO | NULL |  | [Description] |
| `category` | string | YES | NULL |  | [Description] |
| `image` | string | YES | NULL |  | [Description] |
| `created_at` | datetime | YES | NULL |  | [Description] |
| `updated_at` | datetime | YES | NULL |  | [Description] |

### Indexes & Constraints
- **PRIMARY KEY** (`id`)
- **INDEX** (`user_id`)

### Eloquent Relationships

### Model Properties
**Fillable Attributes:**
- `user_id`
- `name`
- `description`
- `price`
- `category`
- `image`

**Attribute Casts:**
- `id` => `int`


---

## User

**Table:** `users`

**Primary Key:** `id`

### Database Columns
| Column | Type | Nullable | Default | Attributes | Description |
|--------|------|----------|---------|------------|-------------|
| `id` | bigint | NO | NULL | AUTO_INCREMENT, UNSIGNED | [Description] |
| `name` | string | NO | NULL |  | [Description] |
| `email` | string | NO | NULL |  | [Description] |
| `email_verified_at` | datetime | YES | NULL |  | [Description] |
| `password` | string | NO | NULL |  | [Description] |
| `remember_token` | string | YES | NULL |  | [Description] |
| `created_at` | datetime | YES | NULL |  | [Description] |
| `updated_at` | datetime | YES | NULL |  | [Description] |
| `role` | string | NO | NULL |  | [Description] |

### Indexes & Constraints
- **PRIMARY KEY** (`id`)
- **UNIQUE** (`email`)

### Eloquent Relationships

### Model Properties
**Fillable Attributes:**
- `name`
- `email`
- `password`
- `role`

**Attribute Casts:**
- `id` => `int`
- `email_verified_at` => `datetime`
- `password` => `hashed`


---

