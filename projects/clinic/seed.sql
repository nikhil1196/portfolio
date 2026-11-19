INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO doctors (name, specialty, phone, fee, status) VALUES
('Dr. Anita Shah',   'General Medicine', '9865001101', 500, 'Active'),
('Dr. Rajesh Patel', 'Orthopedics',      '9865001102', 800, 'Active'),
('Dr. Kavita Desai', 'Pediatrics',       '9865001103', 600, 'Active'),
('Dr. Manoj Trivedi','Dermatology',      '9865001104', 700, 'Active');

INSERT INTO patients (name, phone, dob, gender, blood, address, status) VALUES
('Suresh Kumar', '9876100001', '1985-04-12', 'Male',   'B+',  'Vadodara', 'Active'),
('Nisha Gandhi', '9876100002', '1992-08-23', 'Female', 'O+',  'Ahmedabad','Active'),
('Farhan Sheikh','9876100003', '1978-01-30', 'Male',   'AB+', 'Vadodara', 'Active'),
('Ritu Malhotra','9876100004', '2000-11-05', 'Female', 'A+',  'Surat',    'Active'),
('Devang Bhatt', '9876100005', '2016-06-15', 'Male',   'O-',  'Vadodara', 'Active');

INSERT INTO appointments (patient_id, doctor_id, appt_date, appt_time, reason, status) VALUES
(1, 1, date('now'),          '10:30', 'Fever & cold',       'Scheduled'),
(2, 4, date('now'),          '11:15', 'Skin rash',          'Scheduled'),
(3, 2, date('now','+1 day'), '09:45', 'Knee pain follow-up','Scheduled'),
(4, 3, date('now','-2 day'), '17:00', 'Child vaccination',  'Completed'),
(5, 3, date('now','-5 day'), '12:00', 'Routine checkup',    'Completed');

INSERT INTO prescriptions (appt_id, patient_id, doctor_id, notes, medicines) VALUES
(4, 4, 3, 'Mild viral fever. Rest advised.', 'Paracetamol 500mg 1-0-1 x 3 days'),
(5, 5, 3, 'All vitals normal.', 'Multivitamin syrup 5ml OD x 30 days');

INSERT INTO bills (invoice_no, patient_id, description, amount, status, paid_at) VALUES
('BILL-1001', 4, 'Consultation + Vaccine', 1500, 'Paid',    date('now','-2 day')),
('BILL-1002', 5, 'Consultation',            600, 'Paid',    date('now','-5 day')),
('BILL-1003', 1, 'Consultation',            500, 'Pending', date('now'));
