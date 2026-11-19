# Portfolio Projects — Implementation Tracker

Shared mini-framework lives in `projects/_core/` (plain PHP + PDO, no Composer).
Each project: `config.php`, `schema.sql`, `seed.sql`, page files.
DB: SQLite auto-created + seeded in each project's `data/app.sqlite` on first request.
Demo login on every app: **admin@demo.local / admin123**
Hub page listing all apps: `projects/index.php`

| # | Project | Folder | Status |
|---|---------|--------|--------|
| 1 | Gym Management SaaS | `projects/gym` | ✅ Done |
| 2 | Clinic Management System | `projects/clinic` | ✅ Done |
| 3 | School ERP | `projects/school` | ✅ Done |
| 4 | Society Management | `projects/society` | ✅ Done |
| 5 | Restaurant POS + Kitchen Display | `projects/restaurant` | ✅ Done |
| 6 | HRMS | `projects/hrms` | ✅ Done |
| 7 | CRM | `projects/crm` | ✅ Done |
| 8 | Property Management | `projects/property` | ✅ Done |
| 9 | Event Booking | `projects/events` | ✅ Done |
| 10 | AI Customer Support Platform | `projects/ai-support` | ✅ Done |

## Module Checklist

### 1. Gym Management SaaS — `projects/gym`
- [x] Auth (login/logout)
- [x] Dashboard (members, revenue, check-ins today, in-gym-now)
- [x] Members CRUD (plan + trainer assignment)
- [x] Membership plans CRUD
- [x] Trainers CRUD
- [x] Attendance check-in / check-out log
- [x] Payments / invoices (auto invoice numbers)

### 2. Clinic Management System — `projects/clinic`
- [x] Auth
- [x] Dashboard (today's appointments, monthly revenue)
- [x] Patients CRUD
- [x] Doctors CRUD (fee, specialty)
- [x] Appointments (schedule/status flow)
- [x] Prescriptions (diagnosis + medicines)
- [x] Bills / invoices

### 3. School ERP — `projects/school`
- [x] Auth
- [x] Dashboard (admissions, fees collected)
- [x] Students CRUD (roll no, guardian, class)
- [x] Teachers CRUD
- [x] Classes & sections (class teacher mapping)
- [x] Fee records (receipt numbers, terms)
- [x] Exams & marks (results w/ grades)
- [ ] Student attendance register — deferred
- [ ] School notices — deferred

### 4. Society Management — `projects/society`
- [x] Auth
- [x] Dashboard (dues, open complaints)
- [x] Units / flats
- [x] Residents (owner/tenant roles)
- [x] Maintenance bills (monthly, paid/due)
- [x] Complaints (open → in-progress → resolved)
- [x] Notices (audience targeting)
- [ ] Amenity bookings — deferred

### 5. Restaurant POS + Kitchen Display — `projects/restaurant`
- [x] Auth
- [x] Dashboard (today's orders, live orders, revenue)
- [x] Menu categories & items
- [x] Tables (free/occupied/reserved)
- [x] POS order screen (qty grid → sends to kitchen, auto-frees table on serve)
- [x] Kitchen Display (3-column board: Pending → Preparing → Ready → Served)
- [x] Bill settlement (mark paid)
- [ ] KDS auto-refresh polling — manual refresh for now

### 6. HRMS — `projects/hrms`
- [x] Auth
- [x] Dashboard (present today, pending leaves)
- [x] Departments
- [x] Employees CRUD (emp code, designation, salary)
- [x] Attendance (present/absent/leave/WFH)
- [x] Leave requests (pending → approve/reject)
- [x] Payroll (basic + allowances − deductions = auto net)

### 7. CRM — `projects/crm`
- [x] Auth
- [x] Dashboard (pipeline by stage, upcoming tasks)
- [x] Contacts / customers
- [x] Leads (7-stage pipeline: New → … → Won/Lost)
- [x] Deals (value, expected close, open/closed)
- [x] Tasks / follow-ups (priority, due date)

### 8. Property Management — `projects/property`
- [x] Auth
- [x] Dashboard (occupancy, rent due)
- [x] Properties (apt/villa/shop/commercial)
- [x] Tenants (ID proof tracking)
- [x] Leases (period, rent, deposit)
- [x] Rent payments (monthly, paid/due/overdue)
- [x] Maintenance requests (category + status flow)

### 9. Event Booking — `projects/events`
- [x] Auth
- [x] Dashboard (seats sold, revenue, upcoming)
- [x] Events CRUD (category, venue, capacity)
- [x] Ticket tiers (price + qty per event)
- [x] Bookings (auto booking numbers)
- [x] Attendees + check-in action

### 10. AI Customer Support Platform — `projects/ai-support`
- [x] Auth
- [x] Dashboard (queue, AI reply count)
- [x] Tickets (channel, priority, assignee, AI summary field)
- [x] Replies (agent vs AI-authored flag)
- [x] Knowledge base articles (categories, view counts)
- [x] Canned replies
- [x] Agents (incl. AI Assistant role)
- [ ] AI auto-reply suggest (KB keyword match / pluggable LLM API) — deferred

## Notes / Next Steps
- Each app is self-contained: open `projects/<slug>/login.php` — DB seeds on first hit.
- To reset a demo: delete `projects/<slug>/data/app.sqlite` and reload.
- Deferred modules listed above can be added per-project on demand.
- The `crud_page()` helper in `_core/crud.php` renders a full add/edit/list module
  from a field+column definition — used by most module pages.
