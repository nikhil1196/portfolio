INSERT INTO users (name, email, password) VALUES ('Admin', 'admin@demo.local', '$2y$10$DUIMoymkgw1XZ.4un5yyvufBs0KmijORrVy2fDbXDMQGVbf6cY3r.');

INSERT INTO agents (name, email, role, status) VALUES
('Support Bot',   'bot@help.local',    'AI Assistant', 'Active'),
('Kunal Deshmukh','kunal@example.com', 'Agent',        'Active'),
('Farida Memon',  'farida@example.com','Team Lead',    'Active');

INSERT INTO tickets (ticket_no, customer, email, subject, channel, priority, status, agent_id, ai_summary) VALUES
('TCK-9001', 'Om Prakash',  'om@example.com',   'Payment failed but amount debited', 'Email',   'High',   'Open',        2, 'Customer charged twice for order; needs refund within 5-7 days.'),
('TCK-9002', 'Lisa D\'Souza','lisa@example.com','How to export invoices to PDF?',    'Chat',    'Low',    'Resolved',    1, 'How-to query; bot shared KB-12 export guide.'),
('TCK-9003', 'Harsh Vora',  'harsh@example.com','API returning 429 errors',          'API',     'High',   'In Progress', 3, 'Rate-limit hit on /orders; suggest upgrading plan.'),
('TCK-9004', 'Sara Ali',    'sara@example.com', 'Cannot reset password',             'WhatsApp','Medium', 'Open',        2, 'Reset link expired; resend with extended TTL.');

INSERT INTO replies (ticket_id, author, body, is_ai) VALUES
(1, 'Support Bot', 'I\'ve detected a duplicate charge. I\'ve flagged this for the billing team and a refund will be initiated within 5-7 business days.', 1),
(1, 'Kunal Deshmukh', 'Confirmed the duplicate charge on our end. Refund reference RF-2211 created.', 0),
(2, 'Support Bot', 'You can export invoices from Billing > Invoices > Export > PDF. Here is a step-by-step guide: KB-12.', 1),
(3, 'Farida Memon', 'Your current plan allows 100 req/min. The 429s suggest bursts — sharing our rate-limit doc.', 0);

INSERT INTO kb_articles (title, category, body, views, status) VALUES
('Exporting invoices to PDF',        'Billing',   'Go to Billing > Invoices, select date range, click Export > PDF.', 142, 'Published'),
('Understanding API rate limits',    'API',       'Free plan: 100 req/min. Pro: 1000 req/min. Headers X-RateLimit-* show status.', 89, 'Published'),
('Resetting your account password',  'Account',   'Use Forgot Password on login. Links expire in 15 min — request a new one if expired.', 230, 'Published'),
('Refund policy and timelines',      'Billing',   'Refunds process in 5-7 business days to the original payment method.', 175, 'Published');

INSERT INTO canned (title, body, category) VALUES
('Refund initiated',    'Your refund has been initiated and will reflect in 5-7 business days. Reference: {ref}.', 'Billing'),
('Welcome greeting',    'Hi {name}, thanks for reaching out! How can I help you today?', 'General'),
('Escalation note',     'I\'m escalating this to our senior team — you\'ll hear back within 24 hours.', 'General'),
('Rate limit help',     'You\'ve hit the plan rate limit. Consider upgrading or batching requests.', 'API');
