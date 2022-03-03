-- TABLE CREATION SECTION


CREATE TABLE positions(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE users(
    id SERIAL PRIMARY KEY,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    age int
);

CREATE TABLE documents(
    id SERIAL PRIMARY KEY,
    title TEXT,
    file TEXT,
    stage INT,
    status_id INT,
    owner INT
); 

CREATE TABLE departments(
    id SERIAL PRIMARY KEY,
    name TEXT
);

CREATE TABLE login_data(
    id SERIAL PRIMARY KEY,
    login TEXT,
    password TEXT,
    pos_id INT,
    department_id INT,
    session_id TEXT
); 

CREATE TABLE mailbox(
    id SERIAL PRIMARY KEY,
    document_id INT,
    reciever_id INT,
    status bool
);

CREATE TABLE signatures(
    id SERIAL PRIMARY KEY,
    document_id INT,
    signature TEXT
);

CREATE TABLE statuses(
    id SERIAL PRIMARY KEY,
    status TEXT
);


ALTER TABLE ONLY login_data
    ADD CONSTRAINT pos_id FOREIGN KEY (pos_id) REFERENCES positions(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY documents
    ADD CONSTRAINT owner FOREIGN KEY (owner) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY login_data
    ADD CONSTRAINT id FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY mailbox
    ADD CONSTRAINT document_id FOREIGN KEY (document_id) REFERENCES documents(id) ON UPDATE CASCADE ON DELETE CASCADE; 

ALTER TABLE ONLY mailbox
    ADD CONSTRAINT reciever_id FOREIGN KEY (reciever_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE; 

ALTER TABLE ONLY signatures
    ADD CONSTRAINT document_id FOREIGN KEY (document_id) REFERENCES documents(id) ON UPDATE CASCADE ON DELETE CASCADE;     

ALTER TABLE ONLY login_data
    ADD CONSTRAINT department_id FOREIGN KEY (department_id) REFERENCES departments(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY documents
    ADD CONSTRAINT status_id FOREIGN KEY (status_id) REFERENCES statuses(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- INSERT SECTION

INSERT INTO positions (name) VALUES ('Администратор');
INSERT INTO positions (name) VALUES ('Генеральный Секретарь');
INSERT INTO positions (name) VALUES ('Начальник Отдела');
INSERT INTO positions (name) VALUES ('Сотрудник');

INSERT INTO departments (name) VALUES ('Администрация');
INSERT INTO departments (name) VALUES ('Бухгалтерия');
INSERT INTO departments (name) VALUES ('Разработка');
INSERT INTO departments (name) VALUES ('Дизайн');
INSERT INTO departments (name) VALUES ('Тестирование');


INSERT INTO statuses (status) VALUES ('На согласовании'), ('Согласовано'), ('Отказано');


INSERT INTO users (last_name, first_name, age) VALUES ('Администратор', 'СКО "Коммунизм"', 21);

INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('kommunism', '$2y$08$ftiOsKbAtTUTWsJhuWN9Xu/RHpjNZiiNKIq.8vgKDYDMaXZN78XxO', 1, 1, NULL);


-- FUNCTIONS SECTION

CREATE OR REPLACE FUNCTION report(empl INT)
RETURNS TABLE (count INT, onsign INT, signed INT, canceled INT)
AS $$
    SELECT count(*)  as count,
    (select count(*) from documents where status_id = 1 AND owner = empl) as onsign, 
    (select count(*) from documents where status_id = 2 AND owner = empl) as signed, 
    (select count(*) from documents where status_id = 3 AND owner = empl) as canceled
    from documents
    inner join users on users.id = documents.owner
    where owner = empl
$$
LANGUAGE SQL;

CREATE OR REPLACE FUNCTION department(number INT)
RETURNS TABLE (name TEXT, count INT, head TEXT)
AS $$
SELECT name,
    (select count(*) from login_data where department_id = number) as count, 
    (select last_name || ' ' || first_name from users 
     inner join login_data on login_data.id = users.id
     inner join departments on login_data.department_id = departments.id 
     where department_id = number AND pos_id = 3) as head
    from departments
    where id = number
$$
LANGUAGE SQL;