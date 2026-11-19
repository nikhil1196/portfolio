CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE departments (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, head TEXT, status TEXT DEFAULT 'Active');
CREATE TABLE employees (id INTEGER PRIMARY KEY AUTOINCREMENT, emp_code TEXT, name TEXT NOT NULL, dept_id INTEGER REFERENCES departments(id), designation TEXT, email TEXT, phone TEXT, joining_date TEXT, salary REAL DEFAULT 0, status TEXT DEFAULT 'Active');
CREATE TABLE attendance (id INTEGER PRIMARY KEY AUTOINCREMENT, emp_id INTEGER REFERENCES employees(id), work_date TEXT, status TEXT DEFAULT 'Present', check_in TEXT);
CREATE TABLE leaves (id INTEGER PRIMARY KEY AUTOINCREMENT, emp_id INTEGER REFERENCES employees(id), type TEXT, from_date TEXT, to_date TEXT, reason TEXT, status TEXT DEFAULT 'Pending');
CREATE TABLE payroll (id INTEGER PRIMARY KEY AUTOINCREMENT, emp_id INTEGER REFERENCES employees(id), month TEXT, basic REAL DEFAULT 0, allowances REAL DEFAULT 0, deductions REAL DEFAULT 0, net REAL DEFAULT 0, status TEXT DEFAULT 'Processed');
