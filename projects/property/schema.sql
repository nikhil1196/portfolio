CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE properties (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, type TEXT, address TEXT, city TEXT, rent REAL DEFAULT 0, status TEXT DEFAULT 'Available');
CREATE TABLE tenants (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, phone TEXT, email TEXT, id_proof TEXT, status TEXT DEFAULT 'Active');
CREATE TABLE leases (id INTEGER PRIMARY KEY AUTOINCREMENT, property_id INTEGER REFERENCES properties(id), tenant_id INTEGER REFERENCES tenants(id), start_date TEXT, end_date TEXT, rent REAL DEFAULT 0, deposit REAL DEFAULT 0, status TEXT DEFAULT 'Active');
CREATE TABLE rents (id INTEGER PRIMARY KEY AUTOINCREMENT, lease_id INTEGER REFERENCES leases(id), month TEXT, amount REAL DEFAULT 0, status TEXT DEFAULT 'Due', paid_at TEXT);
CREATE TABLE requests (id INTEGER PRIMARY KEY AUTOINCREMENT, property_id INTEGER REFERENCES properties(id), tenant_id INTEGER REFERENCES tenants(id), category TEXT, subject TEXT, status TEXT DEFAULT 'Open', created_at TEXT DEFAULT (datetime('now')));
