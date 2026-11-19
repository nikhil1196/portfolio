CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE units (id INTEGER PRIMARY KEY AUTOINCREMENT, block TEXT, flat_no TEXT NOT NULL, floor INTEGER, type TEXT, area_sqft INTEGER, status TEXT DEFAULT 'Occupied');
CREATE TABLE residents (id INTEGER PRIMARY KEY AUTOINCREMENT, unit_id INTEGER REFERENCES units(id), name TEXT NOT NULL, phone TEXT, email TEXT, role TEXT DEFAULT 'Owner', status TEXT DEFAULT 'Active');
CREATE TABLE maintenance (id INTEGER PRIMARY KEY AUTOINCREMENT, unit_id INTEGER REFERENCES units(id), month TEXT, amount REAL DEFAULT 0, status TEXT DEFAULT 'Due', paid_at TEXT);
CREATE TABLE complaints (id INTEGER PRIMARY KEY AUTOINCREMENT, resident_id INTEGER REFERENCES residents(id), category TEXT, subject TEXT, description TEXT, status TEXT DEFAULT 'Open', created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE notices (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, body TEXT, audience TEXT DEFAULT 'All', published_at TEXT DEFAULT (date('now')));
