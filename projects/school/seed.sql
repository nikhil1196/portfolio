INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO teachers (name, subject, phone, qualification, status) VALUES
('Sunita Rao',    'Mathematics', '9852001001', 'M.Sc, B.Ed', 'Active'),
('Prakash Mehta', 'Science',     '9852001002', 'M.Sc, B.Ed', 'Active'),
('Rekha Pillai',  'English',     '9852001003', 'M.A, B.Ed',  'Active'),
('Imran Ansari',  'Social Studies','9852001004','M.A, B.Ed', 'Active');

INSERT INTO classes (name, section, teacher_id, room) VALUES
('Class 8',  'A', 1, 'R-201'),
('Class 9',  'B', 2, 'R-305'),
('Class 10', 'A', 3, 'R-104'),
('Class 10', 'B', 4, 'R-105');

INSERT INTO students (name, roll_no, class_id, guardian, phone, dob, status) VALUES
('Aarav Shah',   '10A-01', 3, 'Nilesh Shah',   '9862000011', '2010-03-14', 'Active'),
('Ishita Patel', '10A-02', 3, 'Kiran Patel',   '9862000012', '2010-07-22', 'Active'),
('Rohan Gupta',  '9B-05',  2, 'Sanjay Gupta',  '9862000013', '2011-01-09', 'Active'),
('Zara Khan',    '8A-03',  1, 'Salim Khan',    '9862000014', '2012-11-30', 'Active'),
('Kabir Singh',  '10B-07', 4, 'Harjeet Singh', '9862000015', '2010-05-18', 'Active');

INSERT INTO fees (receipt_no, student_id, term, amount, status, paid_at) VALUES
('RCP-2001', 1, 'Term 1', 18000, 'Paid',    '2026-06-15'),
('RCP-2002', 2, 'Term 1', 18000, 'Paid',    '2026-06-18'),
('RCP-2003', 3, 'Term 1', 18000, 'Paid',    '2026-06-20'),
('RCP-2004', 4, 'Term 1', 18000, 'Pending', '2026-06-25'),
('RCP-2005', 5, 'Term 2', 18000, 'Pending', '2026-11-01');

INSERT INTO results (student_id, exam, subject, marks, max_marks, grade) VALUES
(1, 'Mid-Term', 'Mathematics', 88, 100, 'A'),
(1, 'Mid-Term', 'Science',     76, 100, 'B+'),
(2, 'Mid-Term', 'Mathematics', 92, 100, 'A+'),
(3, 'Mid-Term', 'Science',     65, 100, 'B'),
(4, 'Mid-Term', 'English',     81, 100, 'A'),
(5, 'Mid-Term', 'Mathematics', 70, 100, 'B+');
