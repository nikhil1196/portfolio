INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO departments (name, head, status) VALUES
('Engineering', 'Nikhil Agrawal', 'Active'),
('HR',          'Priya Sharma',   'Active'),
('Sales',       'Amit Deshmukh',  'Active'),
('Finance',     'Ritu Kapoor',    'Active');

INSERT INTO employees (emp_code, name, dept_id, designation, email, phone, joining_date, salary, status) VALUES
('EMP-001', 'Nikhil Agrawal', 1, 'Technical Lead',    'nikhil@example.com',  '9830001001', '2023-01-02', 120000, 'Active'),
('EMP-002', 'Priya Sharma',   2, 'HR Manager',        'priya@example.com',   '9830001002', '2021-06-15', 75000,  'Active'),
('EMP-003', 'Amit Deshmukh',  3, 'Sales Executive',   'amit.d@example.com',  '9830001003', '2022-03-10', 55000,  'Active'),
('EMP-004', 'Ritu Kapoor',    4, 'Accountant',        'ritu@example.com',    '9830001004', '2020-11-01', 60000,  'Active'),
('EMP-005', 'Vikas Yadav',    1, 'Backend Developer', 'vikas@example.com',   '9830001005', '2024-02-19', 65000,  'Active');

INSERT INTO attendance (emp_id, work_date, status, check_in) VALUES
(1, date('now'), 'Present', '09:15'), (2, date('now'), 'Present', '09:30'),
(3, date('now'), 'Leave',   NULL),    (4, date('now'), 'Present', '09:05'),
(5, date('now'), 'Present', '09:45');

INSERT INTO leaves (emp_id, type, from_date, to_date, reason, status) VALUES
(3, 'Casual',  date('now'),           date('now','+1 day'), 'Family function', 'Approved'),
(5, 'Sick',    date('now','+5 day'),  date('now','+6 day'), 'Doctor advised rest', 'Pending'),
(2, 'Earned',  date('now','-10 day'), date('now','-8 day'), 'Vacation', 'Approved');

INSERT INTO payroll (emp_id, month, basic, allowances, deductions, net, status) VALUES
(1, '2026-10', 120000, 18000, 5000, 133000, 'Paid'),
(2, '2026-10', 75000,  10000, 3000, 82000,  'Paid'),
(3, '2026-10', 55000,  8000,  2500, 60500,  'Paid'),
(4, '2026-10', 60000,  9000,  2800, 66200,  'Paid'),
(5, '2026-10', 65000,  9000,  3000, 71000,  'Processed');
