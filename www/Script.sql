DROP SEQUENCE IF EXISTS {prefix}_role_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_role CASCADE;
DROP TABLE IF EXISTS {prefix}_status CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_user_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_user CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_media_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_media CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_page_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_page CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_project_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_project CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_tag_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_tag CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_comment_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_comment CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_setting_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_setting CASCADE;
DROP SEQUENCE IF EXISTS {prefix}_project_tags_id_seq CASCADE;
DROP TABLE IF EXISTS {prefix}_project_tags CASCADE;

CREATE TABLE {prefix}_status (
	id SERIAL PRIMARY KEY,
  	status VARCHAR(255) NOT NULL
);

INSERT INTO {prefix}_status (status) VALUES
  ('Publié'),
  ('Supprimé'),
  ('Brouillon');


CREATE SEQUENCE {prefix}_role_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_role (
	id                       INTEGER DEFAULT nextval('{prefix}_role_id_seq') NOT NULL,
	role                	 VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO {prefix}_role (role) VALUES
  ('Administrateur'),
  ('Utilisateur'),
  ('Editeur');

CREATE SEQUENCE {prefix}_user_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_user (
	id                        INTEGER DEFAULT nextval('{prefix}_user_id_seq') NOT NULL,
	firstname                 VARCHAR(50) NOT NULL,
	lastname                  VARCHAR(50) NOT NULL,
	email                     VARCHAR(320),
	password                  VARCHAR(255),
	slug 						VARCHAR(255),
	creation_date       	  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status                    INTEGER DEFAULT 0,
	photo                     VARCHAR(155),
	id_role                   INTEGER NOT NULL,
    reset_token               VARCHAR(255),
    reset_expires             TIMESTAMP,
    activation_token          VARCHAR(255),
	occupation					TEXT,
	birthday					TIMESTAMP,
	country						VARCHAR(255),
	city 						VARCHAR(255),
	website						VARCHAR(255),
	link						VARCHAR(255),
	description					TEXT,
	experience					TEXT,
	study					TEXT,
	competence					TEXT,
	interest					TEXT,
	PRIMARY KEY (id),
	CONSTRAINT fk_user_role FOREIGN KEY (id_role) REFERENCES {prefix}_role(id)
);

CREATE SEQUENCE {prefix}_tag_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_tag (
	id INTEGER DEFAULT nextval('{prefix}_tag_id_seq') NOT NULL,
	name VARCHAR(50) NOT NULL,
	slug VARCHAR(255),
	description VARCHAR(500),
	user_id INTEGER,
	creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	CONSTRAINT fk_tag_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE SEQUENCE {prefix}_media_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_media (
	id       		INTEGER DEFAULT nextval('{prefix}_media_id_seq') NOT NULL,
	title           VARCHAR(255),
	description 	VARCHAR(255),
	name           VARCHAR(255),
	type 	VARCHAR(255),
	size           INTEGER,
	url VARCHAR(255) NOT NULL,
	user_id 		INTEGER,
	creation_date 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	CONSTRAINT fk_media_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE SEQUENCE {prefix}_project_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_project (
	id    					INTEGER DEFAULT nextval('{prefix}_project_id_seq') NOT NULL,
	title          			VARCHAR(64) NOT NULL,
	content        			TEXT,
	slug 					VARCHAR(255) NOT NULL,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	publication_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status_id				INTEGER NOT NULL,
	user_id 				INTEGER,
	tag_id 					INTEGER,
	featured_image 			VARCHAR(255),
	PRIMARY KEY (id),
	CONSTRAINT fk_project_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id),
	CONSTRAINT fk_project_status FOREIGN KEY (status_id) REFERENCES {prefix}_status(id)
);

CREATE SEQUENCE {prefix}_comment_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_comment (
	id					INTEGER DEFAULT nextval('{prefix}_comment_id_seq') NOT NULL,
	comment    			TEXT NOT NULL,
	user_id    			INTEGER,
	mail				VARCHAR(320) NOT NULL,
	status  			INTEGER NOT NULL,
	name 				VARCHAR(50) NOT NULL,
	project_id			INTEGER,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id),
	CONSTRAINT fk_comment_project FOREIGN KEY (project_id) REFERENCES {prefix}_project(id)
);

CREATE SEQUENCE {prefix}_page_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_page (
	id                    	INTEGER DEFAULT nextval('{prefix}_page_id_seq') NOT NULL,
	title 					VARCHAR(255) NOT NULL,
	content					TEXT,
	slug 					VARCHAR(255) NOT NULL,
    creation_date 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	publication_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_id				INTEGER NOT NULL,
	user_id 				INTEGER,
	PRIMARY KEY (id),
	CONSTRAINT fk_page_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id),
	CONSTRAINT fk_page_status FOREIGN KEY (status_id) REFERENCES {prefix}_status(id)
);

CREATE SEQUENCE {prefix}_setting_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_setting
(
    id 						Integer DEFAULT nextval('{prefix}_setting_id_seq') NOT NULL,
    key						VARCHAR(255),
	value					VARCHAR(255),
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id)
);

CREATE SEQUENCE {prefix}_project_tags_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE {prefix}_project_tags (
	id					Integer DEFAULT nextval('{prefix}_project_tags_id_seq') NOT NULL,
	id_tag				INTEGER,
	id_project          INTEGER,
	PRIMARY KEY (id),
	FOREIGN KEY (id_project) REFERENCES {prefix}_project(id),
	FOREIGN KEY (id_tag) REFERENCES {prefix}_media(id)
);
