CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE classes (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, section TEXT, teacher_id INTEGER, room TEXT);
CREATE TABLE teachers (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, subject TEXT, phone TEXT, qualification TEXT, status TEXT DEFAULT 'Active');
CREATE TABLE students (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, roll_no TEXT, class_id INTEGER REFERENCES classes(id), guardian TEXT, phone TEXT, dob TEXT, status TEXT DEFAULT 'Active');
CREATE TABLE fees (id INTEGER PRIMARY KEY AUTOINCREMENT, receipt_no TEXT, student_id INTEGER REFERENCES students(id), term TEXT, amount REAL DEFAULT 0, status TEXT DEFAULT 'Paid', paid_at TEXT DEFAULT (date('now')));
CREATE TABLE results (id INTEGER PRIMARY KEY AUTOINCREMENT, student_id INTEGER REFERENCES students(id), exam TEXT, subject TEXT, marks REAL DEFAULT 0, max_marks REAL DEFAULT 100, grade TEXT);
