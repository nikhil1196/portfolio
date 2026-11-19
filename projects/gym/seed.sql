INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO plans (name, duration_months, price, features, status) VALUES
('Monthly',    1,  1500,  'Gym floor access', 'Active'),
('Quarterly',  3,  4000,  'Gym + group classes', 'Active'),
('Half-Yearly',6,  7500,  'Gym + classes + diet plan', 'Active'),
('Annual',     12, 12000, 'All access + personal session', 'Active');

INSERT INTO trainers (name, specialty, phone, status) VALUES
('Rahul Verma',  'Strength & Conditioning', '9876500011', 'Active'),
('Priya Nair',   'Yoga & Mobility',         '9876500012', 'Active'),
('Arjun Mehta',  'CrossFit / HIIT',         '9876500013', 'Active');

INSERT INTO members (name, email, phone, plan_id, trainer_id, join_date, status) VALUES
('Amit Sharma',   'amit@example.com',   '9876510001', 4, 1, '2026-01-10', 'Active'),
('Sneha Patel',   'sneha@example.com',  '9876510002', 2, 2, '2026-03-05', 'Active'),
('Vikram Singh',  'vikram@example.com', '9876510003', 1, 3, '2026-10-01', 'Active'),
('Pooja Desai',   'pooja@example.com',  '9876510004', 3, 1, '2026-07-15', 'Active'),
('Karan Joshi',   'karan@example.com',  '9876510005', 1, NULL, '2026-11-02','Active'),
('Meera Iyer',    'meera@example.com',  '9876510006', 4, 2, '2025-12-20', 'Active'),
('Rohit Kulkarni','rohit@example.com',  '9876510007', 2, 3, '2026-09-11', 'Inactive'),
('Divya Rao',     'divya@example.com',  '9876510008', 1, NULL, '2026-11-10','Active');

INSERT INTO attendance (member_id, check_in, check_out) VALUES
(1, datetime('now','-3 hours'), datetime('now','-1 hours')),
(2, datetime('now','-2 hours'), NULL),
(3, datetime('now','-1 days','-3 hours'), datetime('now','-1 days','-2 hours')),
(4, datetime('now','-1 days','-5 hours'), datetime('now','-1 days','-4 hours')),
(1, datetime('now','-2 days','-4 hours'), datetime('now','-2 days','-3 hours')),
(5, datetime('now','-2 days','-6 hours'), datetime('now','-2 days','-5 hours')),
(6, datetime('now','-3 days','-2 hours'), datetime('now','-3 days','-1 hours')),
(8, datetime('now','-30 minutes'), NULL);

INSERT INTO payments (invoice_no, member_id, plan_id, amount, method, status, paid_at) VALUES
('INV-1001', 1, 4, 12000, 'UPI',         'Paid', '2026-01-10'),
('INV-1002', 2, 2, 4000,  'Card',        'Paid', '2026-03-05'),
('INV-1003', 3, 1, 1500,  'Cash',        'Paid', '2026-10-01'),
('INV-1004', 4, 3, 7500,  'UPI',         'Paid', '2026-07-15'),
('INV-1005', 5, 1, 1500,  'UPI',         'Paid', '2026-11-02'),
('INV-1006', 6, 4, 12000, 'Bank Transfer','Paid', '2025-12-20'),
('INV-1007', 7, 2, 4000,  'Cash',        'Paid', '2026-09-11'),
('INV-1008', 8, 1, 1500,  'Card',        'Pending', '2026-11-10');
