# Analyse des Migrations de la Base de Données

Ce document liste les migrations à partir du **03 janvier 2026**, avec le détail complet des tables et colonnes.

---

## 1. Profiles Table
**Fichier :** `2026_01_03_111110_create_profiles_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `user_id` | ForeignID | Unique, Constrained, Cascade On Delete |
| `company` | String | Nullable |
| `country` | String | Nullable |
| `bio` | Text | Nullable |
| `specialization` | String | Nullable (web, mobile, fullstack...) |
| `years_experience` | Integer | Default: 0 |
| `hourly_rate` | Decimal | 10,2 - Nullable |
| `availability` | String | Default: 'available' |
| `github_url` | String | Nullable |
| `linkedin_url` | String | Nullable |
| `cv_path` | String | Nullable |
| `is_verified` | Boolean | Default: false |
| `verification_level` | String | Default: 'unverified' |
| `verified_at` | Timestamp | Nullable |
| `verified_by` | ForeignID | Constrained('users'), Null on Delete |
| `total_earned` | Decimal | 15,2 - Default: 0 |
| `completed_projects_count` | Integer | Default: 0 |
| `average_rating` | Decimal | 3,2 - Default: 0 |
| `total_reviews_count` | Integer | Default: 0 |
| `skills` | JSON | Nullable |
| `certifications` | JSON | Nullable |
| `experiences` | JSON | Nullable |
| `social_links` | JSON | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

---

## 2. Projects Table
**Fichier :** `2026_01_03_111122_create_projects_table.php` (et `2026_01_03_232336_add_developer_id_to_projects_table.php`)

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `code` | String | Unique |
| `title` | String | |
| `description` | Text | |
| `slug` | String | Unique |
| `client_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `developer_id` | ForeignID | Constrained('users'), Set Null On Delete (Ajouté plus tard) |
| `type` | String | Default: 'web' |
| `status` | String | Default: 'pending' |
| `priority` | String | Default: 'medium' |
| `budget` | Decimal | 12,2 - Nullable |
| `final_cost` | Decimal | 12,2 - Nullable |
| `currency` | String | 3 chars, Default: 'XAF' |
| `deadline` | Date | Nullable |
| `started_at` | Date | Nullable |
| `completed_at` | Date | Nullable |
| `progress_percentage` | Integer | Default: 0 |
| `technologies` | JSON | Nullable |
| `attachments` | JSON | Nullable |
| `milestones` | JSON | Nullable |
| `tasks` | JSON | Nullable |
| `collaborators` | JSON | Nullable |
| `is_published` | Boolean | Default: false |
| `is_featured` | Boolean | Default: false |
| `likes_count` | Integer | Default: 0 |
| `views_count` | Integer | Default: 0 |
| `reviews_count` | Integer | Default: 0 |
| `average_rating` | Decimal | 3,2 - Default: 0 |
| `admin_notes` | Text | Nullable |
| `cancellation_reason` | Text | Nullable |
| `featured_image` | String | Nullable |
| `gallery_images` | JSON | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |
| `deleted_at` | Timestamp | Soft Deletes |

---

## 3. Reviews Table
**Fichier :** `2026_01_03_114929_create_reviews_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `project_id` | ForeignID | Constrained, Cascade On Delete |
| `client_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `developer_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `rating` | Integer | Default: 5 |
| `comment` | Text | Nullable |
| `status` | String | Default: 'approved' |
| `criteria` | JSON | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

---

## 4. Commissions Table
**Fichier :** `2026_01_03_115334_create_commissions_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `project_id` | ForeignID | Constrained, Cascade On Delete |
| `developer_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `amount` | Decimal | 10,2 |
| `currency` | String | 3 chars, Default: 'XAF' |
| `percentage` | Decimal | 5,2 - Nullable |
| `status` | String | Default: 'pending' |
| `type` | String | Default: 'project_completion' |
| `description` | Text | Nullable |
| `breakdown` | JSON | Nullable |
| `approved_at` | Timestamp | Nullable |
| `paid_at` | Timestamp | Nullable |
| `approved_by` | ForeignID | Constrained('users'), Null on Delete |
| `payment_details` | JSON | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

---

## 5. Permissions System (Spatie)
**Fichier :** `2026_01_04_174520_create_permission_tables.php`

### Table: `permissions`
| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigIncrements | Primary Key |
| `name` | String | |
| `guard_name` | String | |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

### Table: `roles`
| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigIncrements | Primary Key |
| `name` | String | |
| `guard_name` | String | |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

### Tables Pivots :
- `model_has_permissions` : `permission_id`, `model_type`, `model_id`
- `model_has_roles` : `role_id`, `model_type`, `model_id`
- `role_has_permissions` : `permission_id`, `role_id`

---

## 6. Articles Table
**Fichier :** `2026_01_09_172701_create_articles_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `author_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `title` | String | |
| `slug` | String | Unique |
| `excerpt` | Text | Nullable |
| `content` | LongText | |
| `featured_image` | String | Nullable |
| `status` | String | Default: 'draft' |
| `tags` | JSON | Nullable |
| `category` | String | Nullable |
| `seo` | JSON | Nullable |
| `published_at` | Timestamp | Nullable |
| `scheduled_at` | Timestamp | Nullable |
| `views_count` | Integer | Default: 0 |
| `likes_count` | Integer | Default: 0 |
| `comments_count` | Integer | Default: 0 |
| `comments` | JSON | Nullable (Structure v1) |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |
| `deleted_at` | Timestamp | Soft Deletes |

---

## 7. Workload Management Table
**Fichier :** `2026_01_10_160000_create_workload_management_table.php` (et ajustements timestamps)

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `developer_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `current_projects_count` | Integer | Default: 0 |
| `max_projects_capacity` | Integer | Default: 3 |
| `availability_status` | Enum | [available, busy, overloaded] |
| `workload_percentage` | Decimal | 5,2 - Default: 0.00 |
| `last_updated_at` | Timestamp | |
| `updated_at` | Timestamp | Ajouté dans migration suivante |
| `created_at` | Timestamp | Ajouté dans migration suivante |

---

## 8. External Developer Commissions Table
**Fichier :** `2026_01_10_160100_create_external_developer_commissions_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `project_id` | ForeignID | Constrained('projects'), Cascade On Delete |
| `external_developer_id` | ForeignID | Constrained('users'), Cascade On Delete |
| `amount` | Decimal | 12,2 |
| `currency` | Char(3) | Default: 'XAF' |
| `commission_rate` | Decimal | 5,2 - Default: 10.00 |
| `status` | Enum | [pending, approved, paid, cancelled] |
| `payment_method` | Enum | [bank_transfer, mobile_money, crypto, wallet] |
| `payment_details` | JSON | Nullable |
| `work_delivered_at` | Timestamp | Nullable |
| `approved_at` | Timestamp | Nullable |
| `paid_at` | Timestamp | Nullable |
| `approved_by` | ForeignID | Constrained('users') |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

---

## 9. Support Tickets Table
**Fichier :** `2026_01_14_000001_create_support_tickets_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `user_id` | ForeignID | Constrained, Cascade On Delete |
| `assigned_to` | ForeignID | Constrained('users'), Null On Delete |
| `project_id` | ForeignID | Constrained, Null On Delete |
| `title` | String | |
| `description` | Text | |
| `status` | String | Default: 'open' |
| `priority` | String | Default: 'medium' |
| `category` | String | Default: 'general' |
| `severity` | String | Default: 'minor' |
| `messages` | JSON | Nullable |
| `attachments` | JSON | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |
| `resolved_at` | Timestamp | Nullable |

---

## 10. Settings Table
**Fichier :** `2026_01_14_000002_create_settings_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `key` | String | Unique |
| `value` | Text | |
| `type` | String | Default: 'string' (boolean, json, decimal...) |
| `description` | Text | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

---

## 11. Audit Logs Table
**Fichier :** `2026_01_14_000003_create_audit_logs_table.php`

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key |
| `user_id` | ForeignID | Constrained, Null On Delete |
| `action` | String | (created, updated, deleted) |
| `model_type` | String | |
| `model_id` | UnsignedBigInteger | |
| `old_values` | JSON | Nullable |
| `new_values` | JSON | Nullable |
| `ip_address` | String | Nullable |
| `user_agent` | String | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

---

## 12. Notifications Table (v2)
**Fichier :** `2026_01_14_000004_update_notifications_table.php` (Structure actuelle)

| Colonne | Type | Détails |
| :--- | :--- | :--- |
| `id` | UUID | Primary Key |
| `user_id` | ForeignID | Constrained, Cascade On Delete |
| `type` | String | |
| `title` | String | |
| `message` | Text | |
| `data` | JSON | Nullable |
| `channel` | String | Default: 'in_app' |
| `read_at` | Timestamp | Nullable |
| `sent_at` | Timestamp | Nullable |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |
