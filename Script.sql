DROP SEQUENCE IF EXISTS msnu_role_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_role CASCADE;
DROP TABLE IF EXISTS msnu_status CASCADE;
DROP SEQUENCE IF EXISTS msnu_user_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_user CASCADE;
DROP SEQUENCE IF EXISTS msnu_media_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_media CASCADE;
DROP SEQUENCE IF EXISTS msnu_page_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_page CASCADE;
DROP SEQUENCE IF EXISTS msnu_project_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_project CASCADE;
DROP SEQUENCE IF EXISTS msnu_tag_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_tag CASCADE;
DROP SEQUENCE IF EXISTS msnu_comment_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_comment CASCADE;
DROP SEQUENCE IF EXISTS msnu_setting_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_setting CASCADE;
DROP SEQUENCE IF EXISTS msnu_project_tags_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_project_tags CASCADE;
DROP SEQUENCE IF EXISTS msnu_pagehistory_id_seq CASCADE;
DROP TABLE IF EXISTS msnu_pagehistory CASCADE;

CREATE TABLE msnu_status (
	id SERIAL PRIMARY KEY,
  	status VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO msnu_status (status) VALUES
  ('Publié'),
  ('Supprimé'),
  ('Brouillon');

CREATE SEQUENCE msnu_role_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE msnu_role (
	id                       INTEGER DEFAULT nextval('msnu_role_id_seq') NOT NULL,
	role                	 VARCHAR(50) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO msnu_role (role) VALUES
  ('Administrateur'),
  ('Editeur'),
  ('Utilisateur');

CREATE SEQUENCE msnu_user_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_user table
CREATE TABLE msnu_user (
	id                        INTEGER DEFAULT nextval('msnu_user_id_seq') NOT NULL,
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
	CONSTRAINT fk_user_role FOREIGN KEY (id_role) REFERENCES msnu_role(id)
);

-- Define the msnu_type_notification table
-- CREATE TABLE msnu_type_notification (
-- 	id_type_notification SERIAL,
-- 	libelle              VARCHAR(50),
-- 	PRIMARY KEY (id_type_notification)
-- );


CREATE SEQUENCE msnu_tag_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_category table
CREATE TABLE msnu_tag (
	id INTEGER DEFAULT nextval('msnu_tag_id_seq'::regclass),
	name VARCHAR(50) NOT NULL,
	slug VARCHAR(255),
	description VARCHAR(500),
	user_id INTEGER,
	creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	CONSTRAINT fk_tag_user FOREIGN KEY (user_id) REFERENCES msnu_user(id)
);




CREATE SEQUENCE msnu_media_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_media table
CREATE TABLE msnu_media (
	id       		INTEGER DEFAULT nextval('msnu_media_id_seq') NOT NULL,
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
	CONSTRAINT fk_media_user FOREIGN KEY (user_id) REFERENCES msnu_user(id)
);

CREATE SEQUENCE msnu_project_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_project table
CREATE TABLE msnu_project (
	id    					INTEGER DEFAULT nextval('msnu_project_id_seq') NOT NULL,
	title          			VARCHAR(64) NOT NULL,
	content        			TEXT,
	slug 					VARCHAR(255) NOT NULL,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	publication_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status_id				INTEGER NOT NULL,
	user_id 				INTEGER,
	tag_id 					INTEGER,
	PRIMARY KEY (id),
	CONSTRAINT fk_project_user FOREIGN KEY (user_id) REFERENCES msnu_user(id),
	CONSTRAINT fk_project_status FOREIGN KEY (status_id) REFERENCES msnu_status(id)
);

-- Define the msnu_category_project table
-- CREATE TABLE msnu_project_tags (
-- 	id SERIAL NOT NULL PRIMARY KEY,
-- 	project_id INTEGER NOT NULL,
-- 	tag_id INTEGER NOT NULL,
-- 	FOREIGN KEY (project_id) REFERENCES msnu_project(id),
-- 	FOREIGN KEY (tag_id) REFERENCES msnu_tag(id)
-- );



CREATE SEQUENCE msnu_comment_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_comment table
CREATE TABLE msnu_comment (
	id					INTEGER DEFAULT nextval('msnu_comment_id_seq') NOT NULL,
	comment    			TEXT NOT NULL,
	user_id    			INTEGER,
	mail				VARCHAR(320) NOT NULL,
	status  			INTEGER NOT NULL,
	name 				VARCHAR(50) NOT NULL,
	project_id			INTEGER,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
<<<<<<< HEAD
	CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES esgi_user(id),
	CONSTRAINT fk_comment_project FOREIGN KEY (project_id) REFERENCES esgi_project(id)
=======
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id),
	CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES msnu_user(id),
	CONSTRAINT fk_comment_project FOREIGN KEY (project_id) REFERENCES msnu_project(id)
>>>>>>> Dev
);

-- Define the msnu_notification table
-- CREATE TABLE msnu_notification (
-- 	id_notification      SERIAL,
-- 	content              VARCHAR(50),
-- 	date_notification    DATE,
-- 	id_user              INTEGER,
-- 	id_type_notification INTEGER,
-- 	PRIMARY KEY (id_notification),
-- 	FOREIGN KEY (id_user) REFERENCES msnu_user(id),
-- 	FOREIGN KEY (id_type_notification) REFERENCES msnu_type_notification(id_type_notification)
-- );

-- -- Define the msnu_formation table
-- CREATE TABLE msnu_formation (
-- 	id_formation        SERIAL,
-- 	title               VARCHAR(50),
-- 	start_date          DATE,
-- 	Diploma_date        DATE,
-- 	mention             VARCHAR(155),
-- 	domain_formation    VARCHAR(50),
-- 	Training_center     VARCHAR(50),
-- 	Description_formation TEXT,
-- 	id_user             INTEGER,
-- 	PRIMARY KEY (id_formation),
-- 	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
-- );

-- -- Define the msnu_professional_experience table
-- CREATE TABLE msnu_professional_experience (
-- 	id_experience         SERIAL,
-- 	libelle               VARCHAR(50),
-- 	start_date            DATE,
-- 	finish_date           DATE,
-- 	mention               VARCHAR(155),
-- 	domain_formation      VARCHAR(50),
-- 	business              VARCHAR(50),
-- 	Description_experience TEXT,
-- 	id_user               INTEGER,
-- 	PRIMARY KEY (id_experience),
-- 	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
-- );

-- -- Define the msnu_skills table
-- CREATE TABLE msnu_skills (
-- 	id_skills            SERIAL,
-- 	title                VARCHAR(50),
-- 	level_skills         DATE,
-- 	description_skills   TEXT,
-- 	id_user              INTEGER,
-- 	PRIMARY KEY (id_skills),
-- 	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
-- );

-- -- Define the msnu_interests table
-- CREATE TABLE msnu_interests (
-- 	id_interests          SERIAL,
-- 	title                 VARCHAR(50),
-- 	level_skills          VARCHAR(50),
-- 	description_interests TEXT,
-- 	id_user               INTEGER,
-- 	PRIMARY KEY (id_interests),
-- 	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
-- );

CREATE SEQUENCE msnu_page_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE msnu_page (
	id                    	INTEGER DEFAULT nextval('msnu_page_id_seq') NOT NULL,
	title 					VARCHAR(255) NOT NULL,
	content					TEXT,
	slug 					VARCHAR(255) NOT NULL,
    creation_date 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	publication_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_id				INTEGER NOT NULL,
	user_id 				INTEGER,
	PRIMARY KEY (id),
	CONSTRAINT fk_page_user FOREIGN KEY (user_id) REFERENCES msnu_user(id),
	CONSTRAINT fk_page_status FOREIGN KEY (status_id) REFERENCES msnu_status(id)
);

-- Define the msnu_setting table
CREATE SEQUENCE msnu_setting_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE msnu_setting
(
    id 						Integer DEFAULT nextval('msnu_setting_id_seq') NOT NULL,
    key						VARCHAR(255),
	value					VARCHAR(255),
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id)
);

CREATE SEQUENCE msnu_project_tags_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE msnu_project_tags (
	id					Integer DEFAULT nextval('msnu_project_tags_id_seq') NOT NULL,
	tag_id				INTEGER,
	project_id          INTEGER,
	PRIMARY KEY (id),
	FOREIGN KEY (project_id) REFERENCES msnu_project(id),
	FOREIGN KEY (tag_id) REFERENCES msnu_tag(id)
);

CREATE SEQUENCE msnu_pagehistory_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE msnu_pagehistory (
  id Integer DEFAULT nextval('msnu_pagehistory_id_seq') NOT NULL,
  page_id INT NOT NULL,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(255),
  content text,
  slug VARCHAR(255),
  FOREIGN KEY (page_id) REFERENCES msnu_page(id)
);