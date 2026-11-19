CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE contacts (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, company TEXT, email TEXT, phone TEXT, source TEXT, status TEXT DEFAULT 'Active');
CREATE TABLE leads (id INTEGER PRIMARY KEY AUTOINCREMENT, contact_id INTEGER REFERENCES contacts(id), title TEXT NOT NULL, value REAL DEFAULT 0, stage TEXT DEFAULT 'New', owner TEXT, notes TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE deals (id INTEGER PRIMARY KEY AUTOINCREMENT, contact_id INTEGER REFERENCES contacts(id), title TEXT NOT NULL, value REAL DEFAULT 0, stage TEXT DEFAULT 'Qualification', close_date TEXT, status TEXT DEFAULT 'Open');
CREATE TABLE tasks (id INTEGER PRIMARY KEY AUTOINCREMENT, contact_id INTEGER REFERENCES contacts(id), title TEXT NOT NULL, due_date TEXT, priority TEXT DEFAULT 'Medium', status TEXT DEFAULT 'Open');
