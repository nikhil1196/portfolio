INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO properties (title, type, address, city, rent, status) VALUES
('Sunrise Residency 2BHK', 'Apartment', 'Alkapuri',      'Vadodara', 18000, 'Occupied'),
('Green Villa 3BHK',       'Villa',     'Gotri',         'Vadodara', 35000, 'Occupied'),
('Lakeview Studio',        'Studio',    'Fatehgunj',     'Vadodara', 12000, 'Available'),
('Skyline Office 800sqft', 'Commercial','Sayajigunj',    'Vadodara', 45000, 'Occupied'),
('Pearl Plaza Shop 12',    'Shop',      'Manjalpur',     'Vadodara', 25000, 'Available');

INSERT INTO tenants (name, phone, email, id_proof, status) VALUES
('Deepak Rana',    '9811100001', 'deepak@example.com', 'Aadhaar XXXX1234', 'Active'),
('Shreya Nambiar', '9811100002', 'shreya@example.com', 'PAN XXXX5678',     'Active'),
('Wasim Pathan',   '9811100003', 'wasim@example.com',  'Aadhaar XXXX9012', 'Active');

INSERT INTO leases (property_id, tenant_id, start_date, end_date, rent, deposit, status) VALUES
(1, 1, '2026-01-01', '2026-12-31', 18000, 54000, 'Active'),
(2, 2, '2026-04-01', '2027-03-31', 35000, 105000,'Active'),
(4, 3, '2026-06-01', '2029-05-31', 45000, 135000,'Active');

INSERT INTO rents (lease_id, month, amount, status, paid_at) VALUES
(1, '2026-11', 18000, 'Paid', '2026-11-03'),
(2, '2026-11', 35000, 'Due',  NULL),
(3, '2026-11', 45000, 'Paid', '2026-11-08'),
(1, '2026-10', 18000, 'Paid', '2026-10-02');

INSERT INTO requests (property_id, tenant_id, category, subject, status) VALUES
(1, 1, 'Plumbing',   'Kitchen tap leaking',        'In Progress'),
(2, 2, 'Electrical', 'Bedroom fan not working',    'Open'),
(4, 3, 'General',    'AC servicing due',           'Resolved'),
(1, 1, 'General',    'Paint touch-up balcony wall','Open');
