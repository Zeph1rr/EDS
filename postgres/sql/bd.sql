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
INSERT INTO positions (name) VALUES ('Директор');
INSERT INTO positions (name) VALUES ('Начальник');
INSERT INTO positions (name) VALUES ('Сотрудник');

INSERT INTO departments (name) VALUES ('Бухгалтерия');
INSERT INTO departments (name) VALUES ('IT-отдел');
INSERT INTO departments (name) VALUES ('Администрация');

INSERT INTO statuses (status) VALUES ('На согласовании'), ('Согласовано'), ('Отказано');


INSERT INTO users (last_name, first_name, age) VALUES ('Григорьев', 'Антон', 21);
INSERT INTO users (last_name, first_name, age) VALUES ('Ясенев', 'Олег', 26);
INSERT INTO users (last_name, first_name, age) VALUES ('Кулаков', 'Виктор', 23);
INSERT INTO users (last_name, first_name, age) VALUES ('Алибабаев', 'Алибаба', 44);
INSERT INTO users (last_name, first_name, age) VALUES ('Никонова', 'Анастасия', 20);
INSERT INTO users (last_name, first_name, age) VALUES ('Иванов', 'Иван', 54);

INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('agrigoryev', '$2y$08$ftiOsKbAtTUTWsJhuWN9Xu/RHpjNZiiNKIq.8vgKDYDMaXZN78XxO', 1, 2, NULL);
INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('yoleg', '$2y$08$HmeN0epFlG4DUmNGyrGmjOetDtKdARJiloUmHLPBvp33kVWF2BB8q', 3, 2, NULL);
INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('vkulakov', '$2y$08$xKacTHSk0YRGAtFxhlGlMeFbJl.gWmHCEmsKiasQPvsyu5KoR6Y/W', 4, 2, NULL);
INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('aalibabaev', '$2y$08$Gfo1fW98Zf3pi5knjj5A5ucOqu5KgDfa2gaaoHY.bmiTogopGuEgm', 4, 1, NULL);
INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('anikonova', '$2y$08$RPFmMrRF1IwlQe9zvS063.aevTVs9PjrwSb3gFWMo5WPISzYFMqDO', 3, 1, NULL);
INSERT INTO login_data (login, password, pos_id, department_id, session_id) VALUES ('iivanov', '$2y$08$ftiOsKbAtTUTWsJhuWN9Xu/RHpjNZiiNKIq.8vgKDYDMaXZN78XxO', 2, 3, NULL)


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
LANGUAGE SQL