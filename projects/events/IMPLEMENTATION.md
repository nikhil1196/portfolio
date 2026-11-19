# Event Booking — Implementation Tracker

Blueprint: `Portfolio_SaaS_Detailed_Implementation_Blueprint.docx` · Master: [`IMPLEMENTATION_MASTER_GUIDE.md`](../../IMPLEMENTATION_MASTER_GUIDE.md)
Login: `admin@demo.local` / `admin123` · Serve: `php artisan serve --port=8120`

Legend: ⬜ Pending · 🟨 In Progress · ✅ Completed · 🔄 Needs Review

## Global rules

| Feature | Status |
|---------|--------|
| Full CRUD incl. View page (`/v/{module}/{id}`) | ✅ |
| Search (`?q=`) + pagination (15/page) + status filters | ✅ |
| Audit log (observer + `/audit`) | ✅ |
| CSV export (`/export/{module}`) | ✅ |
| Roles/permissions + team + reports | ✅ |

## Events

| Feature | Status |
|---------|--------|
| Details | ✅ |
| Date/time | ✅ |
| Organizer information (name + contact) | ✅ |
| Venue double-booking guard (same venue + date → rejected) | ✅ |

## Venues

| Feature | Status |
|---------|--------|
| Details | ✅ |
| Capacity | ✅ |
| Availability (status + events-at-venue on record page) | ✅ |

## Tickets

| Feature | Status |
|---------|--------|
| Ticket types/tiers | ✅ |
| Pricing | ✅ |
| Availability (sold counter, remaining shown; over-booking rejected on booking) | ✅ |

## Bookings

| Feature | Status |
|---------|--------|
| Customer booking | ✅ |
| Payment tracking (Unpaid/Paid/Refunded, txn ref, Mark Paid action) | ✅ |
| Ticket generation (printable e-ticket `/bookings/{id}/ticket` with per-attendee QR) | ✅ |

## Check-in

| Feature | Status |
|---------|--------|
| QR check-in (unique check-in code per attendee, QR on e-ticket, `/checkin` scan page) | ✅ |
| Attendance tracking (`checked_in` flag, toggle on attendees list) | ✅ |

## Extra

| Feature | Status |
|---------|--------|
| Categories | ✅ |
| Sessions/speakers | ✅ |

## Verified

- 18 routes → all 200 (incl. `/checkin`, `/bookings/{id}/ticket`, `/v/*`, `/export/events`)
- Tier booking → `sold` incremented (5/400); over-book attempt (396 > 395 left) → rejected
- Venue conflict (same venue + date) → rejected; organizer/contact persisted
- Check-in scan: valid code → `checked_in=1`; invalid code → "not found" error
- Mark Paid → status Paid + `txn_*` ref generated
- Audit rows logged on creates/actions
