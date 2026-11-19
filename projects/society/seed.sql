INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO units (block, flat_no, floor, type, area_sqft, status) VALUES
('A', 'A-101', 1, '2 BHK', 1050, 'Occupied'),
('A', 'A-102', 1, '2 BHK', 1050, 'Occupied'),
('A', 'A-201', 2, '3 BHK', 1400, 'Occupied'),
('B', 'B-101', 1, '1 BHK', 720,  'Occupied'),
('B', 'B-301', 3, '3 BHK', 1450, 'Vacant');

INSERT INTO residents (unit_id, name, phone, email, role, status) VALUES
(1, 'Mahesh Thakkar',  '9840001111', 'mahesh@example.com',  'Owner',  'Active'),
(2, 'Lata Krishnan',   '9840001112', 'lata@example.com',    'Owner',  'Active'),
(3, 'Nilesh Bhavsar',  '9840001113', 'nilesh@example.com',  'Tenant', 'Active'),
(4, 'Seema Choudhary', '9840001114', 'seema@example.com',   'Owner',  'Active');

INSERT INTO maintenance (unit_id, month, amount, status, paid_at) VALUES
(1, '2026-11', 2500, 'Paid', '2026-11-05'),
(2, '2026-11', 2500, 'Paid', '2026-11-07'),
(3, '2026-11', 3200, 'Due',  NULL),
(4, '2026-11', 1800, 'Due',  NULL),
(1, '2026-10', 2500, 'Paid', '2026-10-04');

INSERT INTO complaints (resident_id, category, subject, description, status) VALUES
(1, 'Plumbing',   'Leakage in bathroom', 'Water seeping from ceiling since last week.', 'In Progress'),
(2, 'Electrical', 'Lift not working',    'Block A lift stops on odd floors.', 'Open'),
(3, 'Security',   'Gate left open',      'Main gate unattended at night.',    'Resolved'),
(4, 'Cleaning',   'Garbage pickup late', 'Daily pickup missed twice this week.', 'Open');

INSERT INTO notices (title, body, audience, published_at) VALUES
('Diwali Celebration', 'Society gathering on Nov 1st at 7 PM in clubhouse.', 'All', '2026-10-28'),
('Water Tank Cleaning','Water supply off on Sunday 10 AM - 1 PM.', 'All', '2026-11-08'),
('AGM Notice',         'Annual General Meeting on Nov 30th.', 'Owners', '2026-11-15');
