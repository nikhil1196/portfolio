CREATE TABLE _meta (k TEXT PRIMARY KEY, v TEXT);
INSERT INTO _meta (k, v) VALUES ('version', '1');

CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT UNIQUE, password TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE agents (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT, role TEXT DEFAULT 'Agent', status TEXT DEFAULT 'Active');
CREATE TABLE tickets (id INTEGER PRIMARY KEY AUTOINCREMENT, ticket_no TEXT, customer TEXT NOT NULL, email TEXT, subject TEXT NOT NULL, channel TEXT DEFAULT 'Email', priority TEXT DEFAULT 'Medium', status TEXT DEFAULT 'Open', agent_id INTEGER REFERENCES agents(id), ai_summary TEXT, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE replies (id INTEGER PRIMARY KEY AUTOINCREMENT, ticket_id INTEGER REFERENCES tickets(id), author TEXT, body TEXT, is_ai INTEGER DEFAULT 0, created_at TEXT DEFAULT (datetime('now')));
CREATE TABLE kb_articles (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, category TEXT, body TEXT, views INTEGER DEFAULT 0, status TEXT DEFAULT 'Published');
CREATE TABLE canned (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, body TEXT, category TEXT);
