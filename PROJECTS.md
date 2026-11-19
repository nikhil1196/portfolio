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
| Roles & permissions (roles CRUD, per-module grants, middleware) | ⬜ pending |
| Team users (admin users w/ role assignment) | ⬜ pending |
| Reports (per-module counts, status breakdowns, trends) | ⬜ pending |

## 1. `gym` — Gym Management SaaS

| Module | Status |
|--------|--------|
| Members, plans, trainers | ✅ done |
| Check-in / check-out attendance | ✅ done |
| Payments + invoices + mark-paid | ✅ done |
| Personal trainer assignment (member ↔ coach) | ✅ done (trainer_id on member) |
| Exercise library (with demo video URL) | ⬜ pending |
| Workout plans (plan → exercises, sets/reps) | ⬜ pending |
| Assign workout plan to member | ⬜ pending |
| Member measurements (weight, BMI, chest, waist…) | ⬜ pending |
| PT sessions (book coach session) | ⬜ pending |
| Class/session bookings | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 2. `clinic` — Clinic Management

| Module | Status |
|--------|--------|
| Patients, doctors, appointments, prescriptions, bills | ✅ done |
| Multi-clinic branches + clinic selection | ⬜ pending |
| Doctor availability / schedule slots | ⬜ pending |
| Slot-aware appointment booking | ⬜ pending |
| Advance booking payment (Stripe-ready record) | ⬜ pending |
| Email receipt → patient + doctor | ⬜ pending |
| Visit notes / medical history | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 3. `school` — School ERP

| Module | Status |
|--------|--------|
| Students, teachers, classes, fees + mark-paid, results, attendance, notices | ✅ done |
| Subjects | ⬜ pending |
| Staff (non-teaching) | ⬜ pending |
| Timetable (class × day × period → subject/teacher) | ⬜ pending |
| Study materials | ⬜ pending |
| Assignments + submissions | ⬜ pending |
| Exams (schedule, separate from results) | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 4. `society` — Society Management

| Module | Status |
|--------|--------|
| Units (houses) + flat numbers | ✅ done |
| Residents incl. family members per unit | ✅ done |
| Maintenance bills + mark-paid | ✅ done |
| Complaint status flow | ✅ done |
| Notices, amenity bookings | ✅ done |
| Online payment record + receipt for maintenance | ⬜ pending |
| Visitors log | ⬜ pending |
| Staff / vendors | ⬜ pending |
| Parking slots | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 5. `restaurant` — Restaurant POS + KDS

| Module | Status |
|--------|--------|
| Menu items, tables, POS orders, live KDS, order history | ✅ done |
| Menu categories | ⬜ pending |
| Table reservations | ⬜ pending |
| Inventory / stock | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 6. `hrms` — HRMS

| Module | Status |
|--------|--------|
| Departments, employees, attendance, leave approve/reject, payroll | ✅ done |
| Holidays calendar | ⬜ pending |
| Announcements | ⬜ pending |
| Employee documents | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 7. `crm` — CRM

| Module | Status |
|--------|--------|
| Contacts, leads, deals, kanban pipeline, tasks | ✅ done |
| Activities / timeline per lead | ⬜ pending |
| Products & quotes | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 8. `property` — Property Management

| Module | Status |
|--------|--------|
| Properties, tenants, leases, rent, request flow | ✅ done |
| Expenses | ⬜ pending |
| Documents | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 9. `events` — Event Booking

| Module | Status |
|--------|--------|
| Events, ticket tiers, bookings, attendee check-in | ✅ done |
| Categories, venues | ⬜ pending |
| Sessions / speakers | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |

## 10. `ai-support` — AI Customer Support

| Module | Status |
|--------|--------|
| Tickets, AI reply suggestion, replies, KB, canned, agents | ✅ done |
| Customers | ⬜ pending |
| Satisfaction ratings | ⬜ pending |
| Roles & permissions, team users, reports | ⬜ pending |
