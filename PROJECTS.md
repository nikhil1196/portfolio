# Product Demos — Implementation Tracker

Ten standalone **Laravel 13** applications under `projects/`, each with real
MVC structure: Eloquent models, migrations, controllers, Blade views, routes,
session auth, and SQLite seed data.

**Demo login (all apps):** `admin@demo.local` / `admin123`

## Architecture

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

## Running an app

```bash
cd projects/<slug>
php artisan migrate:fresh --seed   # reset + reseed SQLite DB
php artisan serve                  # http://localhost:8000
```

## Cross-cutting modules (all 10 apps)

| Module | Status |
|--------|--------|
| Auth + session login | ✅ done |
| Dashboard stats | ✅ done |
| Roles & permissions (roles CRUD, per-module grants, `perm:` middleware) | ✅ done |
| Team users (admin users w/ role assignment) | ✅ done |
| Reports (per-module counts, status breakdowns) | ✅ done |

## 1. `gym` — Gym Management SaaS

| Module | Status |
|--------|--------|
| Members, plans, trainers | ✅ done |
| Check-in / check-out attendance | ✅ done |
| Payments + invoices + mark-paid | ✅ done |
| Personal trainer assignment (member ↔ coach) | ✅ done (trainer_id on member) |
| Exercise library (with demo video URL) | ✅ done |
| Workout plans (plan → exercises, sets/reps) | ✅ done |
| Assign workout plan to member | ✅ done |
| Member measurements (weight, BMI, chest, waist…) | ✅ done |
| PT sessions (book coach session) | ✅ done |
| Class/session bookings | ✅ done |
| Roles & permissions, team users, reports | ✅ done |
| Exercise categories/muscle groups, progress charts | ⬜ pending |
| Membership expiry/renewal workflow | ⬜ pending |

## 2. `clinic` — Clinic Management

| Module | Status |
|--------|--------|
| Patients, doctors, appointments, prescriptions, bills | ✅ done |
| Multi-clinic branches + clinic selection | ✅ done |
| Doctor availability / schedule slots | ✅ done |
| Slot-aware appointment booking | ✅ done |
| Advance booking payment (Stripe-ready record) | ✅ done |
| Email receipt → patient + doctor | ✅ done |
| Visit notes / medical history | ⬜ pending |
| Real Stripe keys + payment intent flow | ⬜ pending |
| Roles & permissions, team users, reports | ✅ done |

## 3. `school` — School ERP

| Module | Status |
|--------|--------|
| Students, teachers, classes, fees + mark-paid, results, attendance, notices | ✅ done |
| Subjects | ✅ done |
| Staff (non-teaching) | ✅ done |
| Timetable (class × day × period → subject/teacher) | ✅ done |
| Study materials | ✅ done |
| Assignments + submissions | ✅ done |
| Exams (schedule, separate from results) | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 4. `society` — Society Management

| Module | Status |
|--------|--------|
| Units (houses) + flat numbers | ✅ done |
| Residents incl. family members per unit | ✅ done |
| Maintenance bills + mark-paid | ✅ done |
| Complaint status flow | ✅ done |
| Notices, amenity bookings | ✅ done |
| Online payment record + receipt for maintenance | ✅ done |
| Visitors log | ✅ done |
| Staff / vendors | ✅ done |
| Parking slots | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 5. `restaurant` — Restaurant POS + KDS

| Module | Status |
|--------|--------|
| Menu items, tables, POS orders, live KDS, order history | ✅ done |
| Menu categories | ✅ done |
| Table reservations | ✅ done |
| Inventory / stock | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 6. `hrms` — HRMS

| Module | Status |
|--------|--------|
| Departments, employees, attendance, leave approve/reject, payroll | ✅ done |
| Holidays calendar | ✅ done |
| Announcements | ✅ done |
| Employee documents | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 7. `crm` — CRM

| Module | Status |
|--------|--------|
| Contacts, leads, deals, kanban pipeline, tasks | ✅ done |
| Activities / timeline per lead | ✅ done |
| Products & quotes | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 8. `property` — Property Management

| Module | Status |
|--------|--------|
| Properties, tenants, leases, rent, request flow | ✅ done |
| Expenses | ✅ done |
| Documents | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 9. `events` — Event Booking

| Module | Status |
|--------|--------|
| Events, ticket tiers, bookings, attendee check-in | ✅ done |
| Categories, venues | ✅ done |
| Sessions / speakers | ✅ done |
| Roles & permissions, team users, reports | ✅ done |

## 10. `ai-support` — AI Customer Support

| Module | Status |
|--------|--------|
| Tickets, AI reply suggestion, replies, KB, canned, agents | ✅ done |
| Customers | ✅ done |
| Satisfaction ratings | ✅ done |
| Roles & permissions, team users, reports | ✅ done |
