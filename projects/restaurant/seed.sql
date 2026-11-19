INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO menu_items (name, category, price, available) VALUES
('Paneer Tikka',    'Starters',   240, 1),
('Veg Manchurian',  'Starters',   180, 1),
('Butter Naan',     'Breads',      50, 1),
('Paneer Butter Masala','Mains',  280, 1),
('Dal Tadka',       'Mains',      190, 1),
('Veg Biryani',     'Mains',      220, 1),
('Masala Dosa',     'South Indian',160, 1),
('Cold Coffee',     'Beverages',  120, 1),
('Gulab Jamun',     'Desserts',    90, 1);

INSERT INTO tables (name, seats, status) VALUES
('T1', 2, 'Occupied'), ('T2', 4, 'Occupied'), ('T3', 4, 'Free'),
('T4', 6, 'Free'), ('T5', 2, 'Free'), ('T6', 8, 'Reserved');

INSERT INTO orders (order_no, table_id, status, total, payment, created_at) VALUES
('ORD-1001', 1, 'Preparing', 710, 'Unpaid', datetime('now','-20 minutes')),
('ORD-1002', 2, 'Pending',   430, 'Unpaid', datetime('now','-5 minutes')),
('ORD-1003', 3, 'Served',    520, 'Paid',   datetime('now','-2 hours')),
('ORD-1004', 4, 'Served',    300, 'Paid',   datetime('now','-1 days'));

INSERT INTO order_items (order_id, item_name, qty, price) VALUES
(1, 'Paneer Tikka',          1, 240),
(1, 'Butter Naan',           4, 50),
(1, 'Dal Tadka',             1, 190),
(1, 'Cold Coffee',           1, 120),
(2, 'Veg Manchurian',        1, 180),
(2, 'Paneer Butter Masala',  1, 280),
(3, 'Masala Dosa',           2, 160),
(3, 'Cold Coffee',           2, 120),
(4, 'Veg Biryani',           1, 220),
(4, 'Gulab Jamun',           1, 90);
