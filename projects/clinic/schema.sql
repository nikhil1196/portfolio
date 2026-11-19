CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE doctors (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, specialty TEXT, phone TEXT, fee REAL DEFAULT 0, status TEXT DEFAULT 'Active');
CREATE TABLE patients (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, phone TEXT, dob TEXT, gender TEXT, blood TEXT, address TEXT, status TEXT DEFAULT 'Active');
CREATE TABLE appointments (id INTEGER PRIMARY KEY AUTOINCREMENT, patient_id INTEGER REFERENCES patients(id), doctor_id INTEGER REFERENCES doctors(id), appt_date TEXT, appt_time TEXT, reason TEXT, status TEXT DEFAULT 'Scheduled');
CREATE TABLE prescriptions (id INTEGER PRIMARY KEY AUTOINCREMENT, appt_id INTEGER REFERENCES appointments(id), patient_id INTEGER REFERENCES patients(id), doctor_id INTEGER REFERENCES doctors(id), notes TEXT, medicines TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE bills (id INTEGER PRIMARY KEY AUTOINCREMENT, invoice_no TEXT, patient_id INTEGER REFERENCES patients(id), description TEXT, amount REAL DEFAULT 0, status TEXT DEFAULT 'Paid', paid_at TEXT DEFAULT (date('now')));
