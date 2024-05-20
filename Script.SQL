CREATE TABLE pro_type_media (
	id_type_media        SERIAL,
	label_type_media     VARCHAR(50),
	PRIMARY KEY (id_type_media)
);

-- Define the pro_type_notification table
CREATE TABLE pro_type_notification (
	id_type_notification SERIAL,
	libelle              VARCHAR(50),
	PRIMARY KEY (id_type_notification)
);

-- Define the pro_category table
CREATE TABLE pro_category (
	id_categorie   SERIAL,
	title          VARCHAR(50),
	PRIMARY KEY (id_categorie)
);

-- Define the pro_user table
CREATE TABLE pro_user (
	id_user                   SERIAL,
	firstname                 VARCHAR(50) NOT NULL,
	lastname                  VARCHAR(50) NOT NULL,
	email                     VARCHAR(155),
	password                  VARCHAR(155),
	registration_date         DATE,
	last_modification_date    DATE,
	status                    INTEGER,
	Photo                     VARCHAR(155),
	role                      INTEGER,
	adress                    VARCHAR(50),
	telephone                 INTEGER,
	date                      DATE,
	description               TEXT,
	PRIMARY KEY (id_user)
);

-- Define the pro_status table
CREATE TABLE pro_status (
	id_status    SERIAL,
	label_status VARCHAR(50),
	PRIMARY KEY (id_status)
);

-- Define the pro_media table
CREATE TABLE pro_media (
	id_media        SERIAL,
	url_media       VARCHAR(50),
	title           VARCHAR(50),
	id_type_media   INTEGER,
	PRIMARY KEY (id_media),
	FOREIGN KEY (id_type_media) REFERENCES pro_type_media(id_type_media)
);

-- Define the pro_project table
CREATE TABLE pro_project (
	id_project     SERIAL,
	Title          VARCHAR(64) NOT NULL,
	content        VARCHAR(155) NOT NULL,
	date_to_create DATE,
	id_categorie   INTEGER,
	id_user        INTEGER,
	id_media       INTEGER,
	id_status      INTEGER,
	PRIMARY KEY (id_project),
	FOREIGN KEY (id_categorie) REFERENCES pro_category(id_categorie),
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user),
	FOREIGN KEY (id_media) REFERENCES pro_media(id_media),
	FOREIGN KEY (id_status) REFERENCES pro_status(id_status)
);

-- Define the pro_category_project table
CREATE TABLE pro_category_project (
	id_category_project SERIAL,
	id_project          INTEGER,
	id_media            INTEGER,
	PRIMARY KEY (id_category_project),
	FOREIGN KEY (id_project) REFERENCES pro_project(id_project),
	FOREIGN KEY (id_media) REFERENCES pro_media(id_media)
);

-- Define the pro_media_project table
CREATE TABLE pro_media_project (
	id_media_project SERIAL,
	id_project       INTEGER,
	id_media         INTEGER,
	PRIMARY KEY (id_media_project),
	FOREIGN KEY (id_project) REFERENCES pro_project(id_project),
	FOREIGN KEY (id_media) REFERENCES pro_media(id_media)
);

-- Define the pro_comment table
CREATE TABLE pro_comment (
	id_comment SERIAL,
	Title      VARCHAR(64) NOT NULL,
	content    TEXT NOT NULL,
	date       DATE,
	signal     INTEGER,
	id_user    INTEGER,
	id_project INTEGER,
	PRIMARY KEY (id_comment),
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user),
	FOREIGN KEY (id_project) REFERENCES pro_project(id_project)
);

-- Define the pro_notification table
CREATE TABLE pro_notification (
	id_notification      SERIAL,
	content              VARCHAR(50),
	date_notification    DATE,
	id_user              INTEGER,
	id_type_notification INTEGER,
	PRIMARY KEY (id_notification),
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user),
	FOREIGN KEY (id_type_notification) REFERENCES pro_type_notification(id_type_notification)
);

-- Define the pro_formation table
CREATE TABLE pro_formation (
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
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user)
);

-- Define the pro_professional_experience table
CREATE TABLE pro_professional_experience (
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
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user)
);

-- Define the pro_skills table
CREATE TABLE pro_skills (
	id_skills            SERIAL,
	title                VARCHAR(50),
	level_skills         DATE,
	description_skills   TEXT,
	id_user              INTEGER,
	PRIMARY KEY (id_skills),
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user)
);

-- Define the pro_interests table
CREATE TABLE pro_interests (
	id_interests          SERIAL,
	title                 VARCHAR(50),
	level_skills          VARCHAR(50),
	description_interests TEXT,
	id_user               INTEGER,
	PRIMARY KEY (id_interests),
	FOREIGN KEY (id_user) REFERENCES pro_user(id_user)
);
