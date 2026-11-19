INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO events (title, category, venue, event_date, price, capacity, status) VALUES
('Laravel Meetup Vadodara',  'Tech',     'Sayaji Convention Center', '2026-12-14 10:00', 0,    150, 'Published'),
('Indie Music Night',        'Concert',  'Open Air Amphitheatre',    '2026-12-21 19:00', 499,  500, 'Published'),
('Startup Founders Summit',  'Business', 'Grand Meridian Hotel',     '2027-01-10 09:00', 1999, 200, 'Published'),
('Kids Art Workshop',        'Workshop', 'Creative Studio Space',    '2026-12-07 11:00', 350,   40, 'Published');

INSERT INTO tickets (event_id, name, price, qty) VALUES
(2, 'General Admission', 499, 400), (2, 'VIP', 1499, 100),
(3, 'Early Bird', 1499, 50), (3, 'Regular', 1999, 150),
(4, 'Single Seat', 350, 40);

INSERT INTO bookings (booking_no, event_id, name, email, seats, amount, status, booked_at) VALUES
('BKG-5001', 2, 'Aditya Verma',  'aditya@example.com', 2, 998,  'Confirmed', '2026-11-15 18:20'),
('BKG-5002', 3, 'Nidhi Saxena',  'nidhi@example.com',  1, 1499, 'Confirmed', '2026-11-16 09:10'),
('BKG-5003', 2, 'Rahul Dube',    'rahul@example.com',  4, 1996, 'Confirmed', '2026-11-17 21:45'),
('BKG-5004', 4, 'Megha Kapoor',  'megha@example.com',  1, 350,  'Confirmed', '2026-11-18 12:00'),
('BKG-5005', 1, 'Jay Raval',     'jay@example.com',    1, 0,    'Confirmed', '2026-11-19 08:30');

INSERT INTO attendees (booking_id, name, checked_in) VALUES
(1, 'Aditya Verma', 0), (1, 'Guest of Aditya', 0), (2, 'Nidhi Saxena', 0),
(3, 'Rahul Dube', 0), (4, 'Megha Kapoor', 0), (5, 'Jay Raval', 0);
