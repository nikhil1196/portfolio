# Product Demos — Implementation Tracker

Ten standalone **Laravel 13** applications under `projects/`, each with real
MVC structure: Eloquent models, migrations, controllers, Blade views, routes,
session auth, and SQLite seed data.

**Demo login (all apps):** `admin@demo.local` / `admin123`

## Architecture

Each `projects/<slug>/` is a complete Laravel project:

```
projects/<slug>/
├── app/Models/                  # Eloquent models + relationships
├── app/Http/Controllers/        # Resource + domain controllers
├── database/migrations/         # Table schemas (FKs, indexes)
├── database/seeders/            # Demo data + admin user
├── resources/views/             # Blade templates (layouts/app + modules)
├── routes/web.php               # Web routes (auth, dashboard, resources)
└── public/                      # Entry point + admin.css/admin.js
```

`projects/_gen.php` + `projects/_specs/*.php` contain the generator and specs
used to scaffold the nine generated apps (gym was built manually as the
reference). `projects/index.php` is a hub page linking to every app.

## Running an app

```bash
cd projects/<slug>
php artisan migrate:fresh --seed   # reset + reseed SQLite DB
php artisan serve                  # http://localhost:8000
```

Or serve `projects/<slug>/public/` via Apache/Laragon. Each app's `.env` is
gitignored and configured for `database/database.sqlite`.

## Status

| # | App | Modules | Status |
|---|-----|---------|--------|
| 1 | `gym` | Auth, dashboard, members, plans, trainers, attendance log, payments/invoices | ✅ verified |
| 2 | `clinic` | Auth, dashboard, patients, doctors, appointments, prescriptions, bills | ✅ verified |
| 3 | `school` | Auth, dashboard, students, teachers, classes, fee records, exam results | ✅ verified |
| 4 | `society` | Auth, dashboard, units, residents, maintenance bills, complaints, notices | ✅ verified |
| 5 | `restaurant` | Auth, dashboard, menu items, tables, POS order screen, kitchen display, order history | ✅ verified |
| 6 | `hrms` | Auth, dashboard, departments, employees, attendance, leaves, payroll | ✅ verified |
| 7 | `crm` | Auth, dashboard, contacts, leads pipeline, deals, follow-up tasks | ✅ verified |
| 8 | `property` | Auth, dashboard, properties, tenants, leases, rent payments, maintenance requests | ✅ verified |
| 9 | `events` | Auth, dashboard, events, ticket tiers, bookings, attendee check-in | ✅ verified |
| 10 | `ai-support` | Auth, dashboard, tickets, replies, KB articles, canned replies, agents | ✅ verified |

Verified = login, dashboard, all module pages return 200, and POST create
flow persists data.

## Deferred / roadmap

These were in the original scope but remain pending:

- **School**: attendance register, notices board
- **Society**: amenity bookings
- **Restaurant**: KDS auto-refresh/polling, split bills, print receipts
- **AI Support**: AI reply suggestion (KB keyword match or pluggable LLM call)
- **All apps**: edit/update forms per row (currently add + delete + status
  transitions), feature tests, role-based access beyond the single admin

## Notes

- Databases are SQLite files inside each app (`database/database.sqlite`),
  ignored by git. Re-seed anytime with `php artisan migrate:fresh --seed`.
- `vendor/` is gitignored per app — run `composer install` inside an app
  directory if dependencies are missing after cloning.
- The earlier plain-PHP demos were replaced by this Laravel rebuild; the old
  code remains in git history (commit `b22796f`).
