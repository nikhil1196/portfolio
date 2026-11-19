INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO contacts (name, company, email, phone, source, status) VALUES
('Rajat Malhotra', 'Zenith Textiles',   'rajat@zenith.com',   '9820100001', 'Referral', 'Active'),
('Komal Jain',     'FreshMart Retail',  'komal@freshmart.in', '9820100002', 'Website',  'Active'),
('Sahil Bhatia',   'Bhatia Logistics',  'sahil@bhatia.co',    '9820100003', 'Cold Call','Active'),
('Tanvi Kulkarni', 'Nimbus IT Park',    'tanvi@nimbus.com',   '9820100004', 'LinkedIn', 'Active'),
('Arif Qureshi',   'Qureshi Traders',   'arif@qureshi.in',    '9820100005', 'Expo',     'Active');

INSERT INTO leads (contact_id, title, value, stage, owner, notes) VALUES
(1, 'ERP for textile unit',      450000, 'Qualified',   'Nikhil', 'Wants GST + inventory module'),
(2, 'POS for 12 stores',         800000, 'Proposal',    'Nikhil', 'Sent pricing deck'),
(3, 'Fleet tracking portal',     250000, 'Contacted',   'Amit',   'Demo scheduled'),
(4, 'Visitor mgmt system',       120000, 'New',         'Amit',   'Inbound enquiry'),
(5, 'WhatsApp ordering',          90000, 'Negotiation', 'Nikhil', 'Awaiting PO');

INSERT INTO deals (contact_id, title, value, stage, close_date, status) VALUES
(1, 'Zenith ERP Phase 1',   300000, 'Negotiation',  '2026-12-15', 'Open'),
(2, 'FreshMart POS rollout',800000, 'Proposal',     '2027-01-31', 'Open'),
(3, 'Fleet portal MVP',     250000, 'Won',          '2026-11-01', 'Closed'),
(5, 'WA ordering bot',       90000, 'Won',          '2026-10-20', 'Closed');

INSERT INTO tasks (contact_id, title, due_date, priority, status) VALUES
(1, 'Send revised ERP quote',    date('now','+1 day'), 'High',   'Open'),
(2, 'POS hardware checklist',    date('now','+3 day'), 'Medium', 'Open'),
(3, 'Kick-off call with Bhatia', date('now','+2 day'), 'High',   'Open'),
(4, 'Share visitor-mgmt demo',   date('now','-1 day'), 'Low',    'Done');
