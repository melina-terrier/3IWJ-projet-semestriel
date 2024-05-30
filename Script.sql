CREATE TABLE msnu_type_media (
	id_type_media        SERIAL,
	label_type_media     VARCHAR(50),
	PRIMARY KEY (id_type_media)
);

-- Define the msnu_status table
CREATE TABLE msnu_status (
	id SERIAL PRIMARY KEY,
  	status VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO msnu_status (status) VALUES
  ('published'),
  ('deleted'),
  ('draft');

CREATE SEQUENCE msnu_user_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_user table
CREATE TABLE msnu_user (
	id                        INTEGER DEFAULT nextval('msnu_user_id_seq') NOT NULL,
	firstname                 VARCHAR(50) NOT NULL,
	lastname                  VARCHAR(50) NOT NULL,
	email                     VARCHAR(155),
	password                  VARCHAR(155),
	creation_date       	  TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status                    INTEGER DEFAULT 0,
	photo                     VARCHAR(155),
	role                      VARCHAR(15),
	-- adress                    VARCHAR(50),
	-- telephone                 INTEGER,
    reset_token               VARCHAR(255),
    reset_expires             TIMESTAMP,
    activation_token          VARCHAR(255),
	-- date                      DATE,
	-- description               TEXT,
	PRIMARY KEY (id)
);

-- Define the msnu_type_notification table
CREATE TABLE msnu_type_notification (
	id_type_notification SERIAL,
	libelle              VARCHAR(50),
	PRIMARY KEY (id_type_notification)
);


CREATE SEQUENCE msnu_tag_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_category table
CREATE TABLE msnu_tag (
	id INTEGER PRIMARY KEY DEFAULT nextval('msnu_tag_id_seq'::regclass),
	name VARCHAR(50) NOT NULL,
	slug VARCHAR(255),
	description VARCHAR(500),
	status_id INTEGER NOT NULL,
	user_id INTEGER NOT NULL,
	creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_tag_status FOREIGN KEY (status_id) REFERENCES msnu_status(id),
	CONSTRAINT fk_tag_user FOREIGN KEY (user_id) REFERENCES msnu_user(id)
);




CREATE SEQUENCE msnu_media_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_media table
CREATE TABLE msnu_media (
	id       		INTEGER DEFAULT nextval('msnu_media_id_seq') NOT NULL,
	url       VARCHAR(255),
	title           VARCHAR(50),
	description 	VARCHAR(255),
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status					VARCHAR(50),
	-- id_type_media   INTEGER,
	-- id_user        INTEGER,
	PRIMARY KEY (id)
	-- FOREIGN KEY (id_type_media) REFERENCES msnu_type_media(id_type_media)
	-- FOREIGN KEY (id_user) REFERENCES msnu_user(id),
);

CREATE SEQUENCE msnu_project_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_project table
CREATE TABLE msnu_project (
	id    					INTEGER DEFAULT nextval('msnu_project_id_seq') NOT NULL,
	title          			VARCHAR(64) NOT NULL,
	content        			TEXT NOT NULL,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status					VARCHAR(50),
	-- id_categorie   INTEGER,
	-- id_user        INTEGER,
	-- id_media       INTEGER,
	-- id_status      INTEGER,
	PRIMARY KEY (id)
	-- FOREIGN KEY (id_categorie) REFERENCES msnu_category(id_categorie),
	-- FOREIGN KEY (id_user) REFERENCES msnu_user(id),
	-- FOREIGN KEY (id_media) REFERENCES msnu_media(id_media),
	-- FOREIGN KEY (id_status) REFERENCES msnu_status(id_status)
);

-- Define the msnu_category_project table
CREATE TABLE msnu_category_project (
	id_category_project SERIAL,
	id_project          INTEGER,
	id_media            INTEGER,
	PRIMARY KEY (id_category_project),
	FOREIGN KEY (id_project) REFERENCES msnu_project(id_project),
	FOREIGN KEY (id_media) REFERENCES msnu_media(id_media)
);

-- Define the msnu_media_project table
CREATE TABLE msnu_media_project (
	id_media_project SERIAL,
	id_project       INTEGER,
	id_media         INTEGER,
	PRIMARY KEY (id_media_project),
	FOREIGN KEY (id_project) REFERENCES msnu_project(id_project),
	FOREIGN KEY (id_media) REFERENCES msnu_media(id_media)
);


CREATE SEQUENCE msnu_comment_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
-- Define the msnu_comment table
CREATE TABLE msnu_comment (
	id				INTEGER DEFAULT nextval('msnu_comment_id_seq') NOT NULL,
	comment    		TEXT NOT NULL,
	isReported  	INTEGER,
	status			VARCHAR(50),
	-- id_user    INTEGER,
	-- id_project INTEGER,
	creation_date     		TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
	-- FOREIGN KEY (id_user) REFERENCES msnu_user(id),
	-- FOREIGN KEY (id_project) REFERENCES msnu_project(id_project)
);

-- Define the msnu_notification table
CREATE TABLE msnu_notification (
	id_notification      SERIAL,
	content              VARCHAR(50),
	date_notification    DATE,
	id_user              INTEGER,
	id_type_notification INTEGER,
	PRIMARY KEY (id_notification),
	FOREIGN KEY (id_user) REFERENCES msnu_user(id),
	FOREIGN KEY (id_type_notification) REFERENCES msnu_type_notification(id_type_notification)
);

-- Define the msnu_formation table
CREATE TABLE msnu_formation (
	id_formation        SERIAL,
	title               VARCHAR(50),
	start_date          DATE,
	Diploma_date        DATE,
	mention             VARCHAR(155),
	domain_formation    VARCHAR(50),
	Training_center     VARCHAR(50),
	Description_formation TEXT,
	id_user             INTEGER,
	PRIMARY KEY (id_formation),
	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
);

-- Define the msnu_professional_experience table
CREATE TABLE msnu_professional_experience (
	id_experience         SERIAL,
	libelle               VARCHAR(50),
	start_date            DATE,
	finish_date           DATE,
	mention               VARCHAR(155),
	domain_formation      VARCHAR(50),
	business              VARCHAR(50),
	Description_experience TEXT,
	id_user               INTEGER,
	PRIMARY KEY (id_experience),
	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
);

-- Define the msnu_skills table
CREATE TABLE msnu_skills (
	id_skills            SERIAL,
	title                VARCHAR(50),
	level_skills         DATE,
	description_skills   TEXT,
	id_user              INTEGER,
	PRIMARY KEY (id_skills),
	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
);

-- Define the msnu_interests table
CREATE TABLE msnu_interests (
	id_interests          SERIAL,
	title                 VARCHAR(50),
	level_skills          VARCHAR(50),
	description_interests TEXT,
	id_user               INTEGER,
	PRIMARY KEY (id_interests),
	FOREIGN KEY (id_user) REFERENCES msnu_user(id)
);

CREATE SEQUENCE msnu_page_id_seq INCREMENT 1 MINVALUE 1 CACHE 1;
CREATE TABLE msnu_page (
	id                    	INTEGER DEFAULT nextval('msnu_page_id_seq') NOT NULL,
	title 					VARCHAR(255) NOT NULL,
	content					TEXT NOT NULL,
	slug 					VARCHAR(255) NOT NULL,
    status					VARCHAR(50) NOT NULL,
    creation_date 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- id_user 				INTEGER NOT NULL,
	PRIMARY KEY (id)
	-- FOREIGN KEY (id_user) REFERENCES msnu_user(id)
)