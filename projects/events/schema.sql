CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE events (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, category TEXT, venue TEXT, event_date TEXT, price REAL DEFAULT 0, capacity INTEGER DEFAULT 0, status TEXT DEFAULT 'Published');
CREATE TABLE tickets (id INTEGER PRIMARY KEY AUTOINCREMENT, event_id INTEGER REFERENCES events(id), name TEXT NOT NULL, price REAL DEFAULT 0, qty INTEGER DEFAULT 0);
CREATE TABLE bookings (id INTEGER PRIMARY KEY AUTOINCREMENT, booking_no TEXT, event_id INTEGER REFERENCES events(id), name TEXT, email TEXT, seats INTEGER DEFAULT 1, amount REAL DEFAULT 0, status TEXT DEFAULT 'Confirmed', booked_at TEXT DEFAULT (datetime('now')));
CREATE TABLE attendees (id INTEGER PRIMARY KEY AUTOINCREMENT, booking_id INTEGER REFERENCES bookings(id), name TEXT, checked_in INTEGER DEFAULT 0);
