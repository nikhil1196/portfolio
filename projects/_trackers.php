<?php
// Writes IMPLEMENTATION.md into each project folder (blueprint-mapped tracker).
$apps = [
"gym" => ["title"=>"Gym Management SaaS","sections"=>[
 "Global rules (all modules)"=>[
  ["List/Create/Edit/Delete screens","✅"],["View (show) page per entity","⬜"],["Validation","✅"],
  ["Search on list pages","⬜"],["Pagination","⬜"],["Sorting/filters","⬜"],["Audit log of actions","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"],["Responsive UI","✅"]],
 "Members CRUD"=>[
  ["Member registration & profile","✅"],["Membership plan assignment","✅"],["Emergency contact details","⬜"],["Documents & profile image upload","⬜"],["Attendance history per member","⬜"],["Payment history per member","⬜"],["Notes & activity timeline","⬜"]],
 "Membership Plans CRUD"=>[
  ["Create membership packages","✅"],["Duration management","✅"],["Pricing","✅"],["Discount configuration","⬜"],["Active/inactive status","✅"]],
 "Trainers CRUD"=>[
  ["Trainer profile","✅"],["Specialization","✅"],["Availability","⬜"],["Assigned members","✅"],["Performance reports","⬜"]],
 "Attendance Management"=>[
  ["Check-in/check-out","✅"],["Attendance history","✅"],["Date filters","⬜"],["Attendance reports","⬜"]],
 "Payments & Invoices"=>[
  ["Payment collection","✅"],["Invoice generation (invoice_no)","🔄"],["Receipt download/print","⬜"],["Payment status tracking","✅"]],
 "Exercise Library"=>[
  ["Exercise name","✅"],["Category (muscle group)","✅"],["Instructions","🔄"],["Video URL","✅"],["Difficulty level","✅"],["Equipment","✅"]],
 "Workout Plans"=>[
  ["Workout templates","✅"],["Assign exercises to plan","✅"],["Sets & repetitions","✅"],["Duration tracking","✅"],["Assign plan to member","✅"]],
 "Body Measurements"=>[
  ["Weight","✅"],["BMI (computed)","🔄"],["Chest","✅"],["Waist","✅"],["Progress tracking charts","⬜"]],
 "Extra (beyond blueprint)"=>[
  ["PT sessions + coach booking","✅"],["Gym classes + class bookings","✅"],["Membership expiry/renewal","⬜"]],
]],
"clinic" => ["title"=>"Clinic Management System","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Validation","✅"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Patients CRUD"=>[["Registration & profile","✅"],["Medical history","⬜"],["Documents upload","⬜"],["Email for receipts","✅"]],
 "Doctors CRUD"=>[["Profile","✅"],["Specialization","✅"],["Availability/schedules","✅"],["Assigned appointments","✅"]],
 "Appointments"=>[["Booking","✅"],["Status workflow","✅"],["Doctor schedule validation","✅"],["Clinic selection","✅"],["Slot conflict check","✅"]],
 "Prescriptions"=>[["Medicine/dosage/instructions","🔄"],["PDF prescription generation","⬜"]],
 "Billing"=>[["Consultation billing","✅"],["Payment tracking","✅"],["Receipt generation + email","✅"],["Stripe advance payment","🔄"]],
 "Extra"=>[["Multi-clinic branches","✅"],["Visit notes/medical history","⬜"],["Real Stripe keys + payment intent flow","⬜"]],
]],
"school" => ["title"=>"School ERP","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Students"=>[["Admission details","✅"],["Parent details","🔄"],["Documents","⬜"],["Class assignment","✅"]],
 "Teachers"=>[["Profile","✅"],["Subject assignment","✅"],["Schedule management","✅ (timetable)"]],
 "Fees"=>[["Fee structure","🔄"],["Invoice generation","⬜"],["Payment collection","✅"],["Outstanding reports","⬜"]],
 "Attendance"=>[["Daily attendance","✅"],["Reports","⬜"],["Parent notifications","⬜"]],
 "Exams & Results"=>[["Exam scheduling","✅"],["Marks entry","✅"],["Grade calculation","🔄"],["Result reports","⬜"]],
 "Extra"=>[["Subjects, staff, materials, assignments+submissions","✅"],["Notices","✅"]],
]],
"society" => ["title"=>"Society Management","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Units"=>[["Building management","✅"],["Flat details","✅"],["Ownership information","🔄"]],
 "Residents"=>[["Resident profiles","✅"],["Family members","✅"],["Documents","⬜"]],
 "Maintenance Billing"=>[["Monthly bills","✅"],["Payment status","✅"],["Receipts + online payment","✅"]],
 "Complaints"=>[["Creation","✅"],["Assignment","⬜"],["Status workflow","✅"],["Resolution tracking","🔄"]],
 "Visitors"=>[["Visitor entry","✅"],["Approval","⬜"],["Visit history","✅"]],
 "Extra"=>[["Notices","✅"],["Amenity bookings","✅"],["Staff/vendors","✅"],["Parking","✅"]],
]],
"restaurant" => ["title"=>"Restaurant POS + KDS","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Menu"=>[["Items","✅"],["Categories","✅"],["Pricing","✅"],["Availability","🔄"]],
 "Orders"=>[["Create order (POS)","✅"],["Order status","✅"],["Kitchen workflow (KDS live)","✅"],["Billing","✅"]],
 "Inventory"=>[["Stock items","✅"],["Stock movement","⬜"],["Low stock alerts","⬜"]],
 "Reservations"=>[["Table booking","✅"],["Customer details","✅"],["Reservation status","✅"]],
]],
"hrms" => ["title"=>"HRMS","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Employees"=>[["Profile","✅"],["Department","✅"],["Documents","✅"],["Employment history","⬜"]],
 "Attendance"=>[["Daily attendance","✅"],["Late tracking","⬜"],["Reports","⬜"]],
 "Leave"=>[["Leave request","✅"],["Approval workflow","✅"],["Balance tracking","⬜"]],
 "Payroll"=>[["Salary structure","🔄"],["Payslip generation","⬜"],["Payment history","🔄"]],
 "Extra"=>[["Holidays","✅"],["Announcements","✅"]],
]],
"crm" => ["title"=>"CRM","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Contacts"=>[["Customer information","✅"],["Communication history","⬜"]],
 "Leads"=>[["Lead capture","✅"],["Lead status","✅"],["Assignment","🔄"]],
 "Deals"=>[["Sales pipeline (kanban)","✅"],["Deal value","✅"],["Probability tracking","⬜"]],
 "Activities"=>[["Calls/emails/meetings/notes","✅ (timeline module)"]],
 "Quotes"=>[["Product selection","✅"],["Pricing","✅"],["PDF quotation","⬜"]],
]],
"property" => ["title"=>"Property Management","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Properties"=>[["Details","✅"],["Images","⬜"],["Location","🔄"],["Documents","✅"]],
 "Tenants"=>[["Profile","✅"],["Documents","🔄"],["History","⬜"]],
 "Leases"=>[["Agreement details","✅"],["Start/end dates","✅"],["Renewal tracking","⬜"]],
 "Rent"=>[["Monthly rent","✅"],["Payment status","✅"],["Receipts","⬜"]],
 "Expenses"=>[["Property expenses","✅"],["Categories","✅"],["Reports","⬜"]],
]],
"events" => ["title"=>"Event Booking","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Events"=>[["Details","✅"],["Date/time","✅"],["Organizer information","⬜"]],
 "Venues"=>[["Details","✅"],["Capacity","✅"],["Availability","⬜"]],
 "Tickets"=>[["Ticket types/tiers","✅"],["Pricing","✅"],["Availability","🔄"]],
 "Bookings"=>[["Customer booking","✅"],["Payment tracking","⬜"],["Ticket generation","⬜"]],
 "Check-in"=>[["QR check-in","⬜"],["Attendance tracking","✅"]],
 "Extra"=>[["Categories","✅"],["Sessions/speakers","✅"]],
]],
"ai-support" => ["title"=>"AI Customer Support Platform","sections"=>[
 "Global rules"=>[["Full CRUD incl. View page","🔄"],["Search/pagination/filters","⬜"],["Audit log","⬜"],["CSV export","⬜"],["Roles/permissions + team + reports","✅"]],
 "Customers"=>[["Profile","✅"],["Conversation history","⬜"],["Tickets link","🔄"]],
 "Tickets"=>[["Creation","✅"],["Assignment","✅"],["Priority","✅"],["Status workflow","✅"]],
 "Knowledge Base"=>[["Articles","✅"],["Categories","🔄"],["Search","🔄"]],
 "Canned Responses"=>[["Reusable replies","✅"],["Agent templates","✅"]],
 "AI Suggestions"=>[["AI-generated responses","✅"],["Conversation context","✅"],["Agent approval workflow","⬜"]],
 "Ratings"=>[["Customer feedback","✅"],["Ratings","✅"],["Reports","⬜"]],
]],
];
foreach ($apps as $slug => $a) {
  $md = "# {$a["title"]} — Implementation Tracker\n\nBlueprint: `Portfolio_SaaS_Detailed_Implementation_Blueprint.docx` · Master: [`IMPLEMENTATION_MASTER_GUIDE.md`](../../IMPLEMENTATION_MASTER_GUIDE.md)\nLogin: `admin@demo.local` / `admin123` · Serve: `php artisan serve`\n\nLegend: ⬜ Pending · 🟨 In Progress · ✅ Completed · 🔄 Needs Review\n\n";
  foreach ($a["sections"] as $sec => $items) {
    $md .= "## $sec\n\n| Feature | Status |\n|---------|--------|\n";
    foreach ($items as [$f,$s]) $md .= "| $f | $s |\n";
    $md .= "\n";
  }
  file_put_contents(__DIR__ . "/$slug/IMPLEMENTATION.md", $md);
  echo "$slug written\n";
}
