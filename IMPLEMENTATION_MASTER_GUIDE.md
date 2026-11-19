# Implementation Master Guide

Governing document for the portfolio product suite, derived from
`Portfolio_SaaS_Detailed_Implementation_Blueprint.docx`.

**Demo login (all apps):** `admin@demo.local` / `admin123`
**Stack:** Laravel 13 + SQLite per app under `projects/<slug>/` — each is a
standalone app (`php artisan serve` inside its folder).

## Execution workflow

> **One project at a time.** A project is only "done" when every module in its
> `IMPLEMENTATION.md` is ✅ Completed per the blueprint — not when CRUD renders.
> Only then move to the next project in the order below.

| # | Project | Folder | Tracker | Status |
|---|---------|--------|---------|--------|
| 1 | Gym Management SaaS | `projects/gym` | [IMPLEMENTATION.md](projects/gym/IMPLEMENTATION.md) | ✅ Completed |
| 2 | Clinic Management | `projects/clinic` | [IMPLEMENTATION.md](projects/clinic/IMPLEMENTATION.md) | ✅ Completed |
| 3 | School ERP | `projects/school` | [IMPLEMENTATION.md](projects/school/IMPLEMENTATION.md) | ✅ Completed |
| 4 | Society Management | `projects/society` | [IMPLEMENTATION.md](projects/society/IMPLEMENTATION.md) | ✅ Completed |
| 5 | Restaurant POS + KDS | `projects/restaurant` | [IMPLEMENTATION.md](projects/restaurant/IMPLEMENTATION.md) | ✅ Completed |
| 6 | HRMS | `projects/hrms` | [IMPLEMENTATION.md](projects/hrms/IMPLEMENTATION.md) | ✅ Completed |
| 7 | CRM | `projects/crm` | [IMPLEMENTATION.md](projects/crm/IMPLEMENTATION.md) | ⬜ Pending |
| 8 | Property Management | `projects/property` | [IMPLEMENTATION.md](projects/property/IMPLEMENTATION.md) | ⬜ Pending |
| 9 | Event Booking | `projects/events` | [IMPLEMENTATION.md](projects/events/IMPLEMENTATION.md) | ⬜ Pending |
| 10 | AI Customer Support | `projects/ai-support` | [IMPLEMENTATION.md](projects/ai-support/IMPLEMENTATION.md) | ⬜ Pending |

## Global module implementation rules (applies to every module)

| Rule | Requirement |
|------|-------------|
| Full CRUD | List, **Create, View (show), Edit, Delete** screens for every entity |
| List quality | Validation on all forms; **pagination, search, sorting, filters** on lists |
| Backend structure | Migration + model + relationships + controller; **service layer** where business logic exists; **policies/permissions** per module |
| Audit | **Audit log** records important actions (create/update/delete, status changes, payments) |
| Data | Demo seed data for every module |
| Reporting | Reports + **exports (CSV)** wherever business value exists |
| UI | Responsive layout; SVG icons (no unicode glyphs); flash + error alerts |

## Per-project feature matrix (blueprint)

### 1. Gym Management SaaS
Members (profile, membership assignment, emergency contact, documents/photo,
attendance + payment history, notes timeline) · Membership Plans (duration,
pricing, discounts) · Trainers (specialization, availability, assigned members,
performance) · Attendance (check-in/out, date filters, reports) · Payments &
Invoices (collection, invoice generation, receipt download) · Exercise Library
(category, instructions, video URL, difficulty) · Workout Plans (templates,
assign exercises, sets/reps, duration) · Body Measurements (weight/BMI/chest/
waist, progress charts)

### 2. Clinic Management
Patients (registration, profile, medical history, documents) · Doctors
(profile, specialization, availability, assigned appointments) · Appointments
(booking, status workflow, doctor schedule validation) · Prescriptions
(medicine, dosage, instructions, PDF generation) · Billing (consultation
billing, payment tracking, receipts)

### 3. School ERP
Students (admission, parent details, documents, class assignment) · Teachers
(profile, subject assignment, schedule) · Fees (structure, invoices, collection,
outstanding reports) · Attendance (daily, reports, parent notifications) ·
Exams & Results (scheduling, marks entry, grade calculation, reports)

### 4. Society Management
Units (building, flat details, ownership) · Residents (profiles, family
members, documents) · Maintenance Billing (monthly bills, payment status,
receipts) · Complaints (creation, assignment, status workflow, resolution
tracking) · Visitors (entry, approval, history)

### 5. Restaurant POS + KDS
Menu (items, categories, pricing, availability) · Orders (create, status,
kitchen workflow, billing) · Inventory (stock items, stock movement, low-stock
alerts) · Reservations (table booking, customer details, status)

### 6. HRMS
Employees (profile, department, documents, employment history) · Attendance
(daily, late tracking, reports) · Leave (request, approval workflow, balance
tracking) · Payroll (salary structure, payslip generation, payment history)

### 7. CRM
Contacts (customer info, communication history) · Leads (capture, status,
assignment) · Deals (pipeline, value, probability) · Activities (calls, emails,
meetings, notes) · Quotes (product selection, pricing, PDF quotation)

### 8. Property Management
Properties (details, images, location, documents) · Tenants (profile,
documents, history) · Leases (agreement, start/end, renewal tracking) · Rent
(monthly, payment status, receipts) · Expenses (categories, reports)

### 9. Event Booking
Events (details, date/time, organizer) · Venues (details, capacity,
availability) · Tickets (types, pricing, availability) · Bookings (customer,
payment tracking, ticket generation) · Check-in (QR check-in, attendance
tracking)

### 10. AI Customer Support
Customers (profile, conversation history, tickets) · Tickets (creation,
assignment, priority, status workflow) · Knowledge Base (articles, categories,
search) · Canned Responses (reusable replies, agent templates) · AI Reply
Suggestions (context, agent approval workflow) · Ratings (feedback, reports)

## Tracking format

`⬜ Pending` · `🟨 In Progress` · `✅ Completed` · `🔄 Needs Review`

Each project's `IMPLEMENTATION.md` tracks every blueprint feature individually.
Update it in the same commit that ships the feature — the tracker is the
contract, code is the proof.
