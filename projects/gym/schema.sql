CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at TEXT DEFAULT (datetime('now'))
);

CREATE TABLE plans (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    duration_months INTEGER NOT NULL DEFAULT 1,
    price REAL NOT NULL DEFAULT 0,
    features TEXT,
    status TEXT DEFAULT 'Active'
);

CREATE TABLE trainers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    specialty TEXT,
    phone TEXT,
    status TEXT DEFAULT 'Active'
);

CREATE TABLE members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT,
    phone TEXT,
    plan_id INTEGER REFERENCES plans(id),
    trainer_id INTEGER REFERENCES trainers(id),
    join_date TEXT,
    status TEXT DEFAULT 'Active'
);

CREATE TABLE attendance (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    member_id INTEGER NOT NULL REFERENCES members(id),
    check_in TEXT NOT NULL,
    check_out TEXT
);

CREATE TABLE payments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    invoice_no TEXT,
    member_id INTEGER REFERENCES members(id),
    plan_id INTEGER REFERENCES plans(id),
    amount REAL NOT NULL DEFAULT 0,
    method TEXT DEFAULT 'Cash',
    status TEXT DEFAULT 'Paid',
    paid_at TEXT DEFAULT (date('now'))
);
