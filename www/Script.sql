
DROP TABLE IF EXISTS {prefix}_status CASCADE;
DROP TABLE IF EXISTS {prefix}_role CASCADE;
DROP TABLE IF EXISTS {prefix}_user CASCADE;
DROP TABLE IF EXISTS {prefix}_tag CASCADE;
DROP TABLE IF EXISTS {prefix}_media CASCADE;
DROP TABLE IF EXISTS {prefix}_project CASCADE;
DROP TABLE IF EXISTS {prefix}_comment CASCADE;
DROP TABLE IF EXISTS {prefix}_formation CASCADE;
DROP TABLE IF EXISTS {prefix}_experience CASCADE;
DROP TABLE IF EXISTS {prefix}_skill CASCADE;
DROP TABLE IF EXISTS {prefix}_contact CASCADE;
DROP TABLE IF EXISTS {prefix}_page CASCADE;
DROP TABLE IF EXISTS {prefix}_setting CASCADE;
DROP TABLE IF EXISTS {prefix}_project_tags CASCADE;
DROP TABLE IF EXISTS {prefix}_pagehistory CASCADE;
DROP TABLE IF EXISTS {prefix}_menu CASCADE;

CREATE TABLE {prefix}_status (
	id        SERIAL PRIMARY KEY NOT NULL,
  	status 	  VARCHAR(255) NOT NULL
);
INSERT INTO {prefix}_status (status) VALUES
  ('Publié'),
  ('Supprimé'),
  ('Brouillon');

CREATE TABLE {prefix}_role (
	id        SERIAL PRIMARY KEY NOT NULL,
	role      VARCHAR(50) NOT NULL
);
INSERT INTO {prefix}_role (role) VALUES
  ('Administrateur'),
  ('Editeur'),
  ('Utilisateur');

CREATE TABLE {prefix}_user (
	id        				SERIAL PRIMARY KEY NOT NULL,
	firstname               VARCHAR(50) NOT NULL,
	lastname                VARCHAR(50) NOT NULL,
	email                   VARCHAR(320) NOT NULL UNIQUE,
	password                VARCHAR(255) NOT NULL,
	slug 					VARCHAR(255) NOT NULL UNIQUE,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status                  INTEGER NOT NULL DEFAULT 0,
	photo                   VARCHAR(255),
	id_role                 INTEGER NOT NULL,
    reset_token             VARCHAR(255),
    reset_expires           TIMESTAMP,
    activation_token        VARCHAR(255),
	occupation				VARCHAR(255),
	birthday				DATE,
	country					VARCHAR(255),
	city 					VARCHAR(60),
	website					VARCHAR(2000),
	description				VARCHAR(1000),
	interest				VARCHAR(1000),
	CONSTRAINT fk_user_role FOREIGN KEY (id_role) REFERENCES {prefix}_role(id)
);

CREATE TABLE {prefix}_tag (
	id   				SERIAL PRIMARY KEY NOT NULL,
	name 				VARCHAR(255) NOT NULL,
	slug 				VARCHAR(255) NOT NULL UNIQUE,
	description 		VARCHAR(1000),
	user_id 			INTEGER NOT NULL,
	creation_date 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_tag_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE TABLE {prefix}_media (
	id        			SERIAL PRIMARY KEY NOT NULL,
	title           	VARCHAR(255) NOT NULL,
	description 		VARCHAR(1000) NOT NULL,
	name           		VARCHAR(255) NOT NULL,
	type 				VARCHAR(255) NOT NULL,
	size           		INTEGER NOT NULL,
	url 				VARCHAR(255) NOT NULL UNIQUE,
	user_id 			INTEGER NOT NULL,
	creation_date 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_media_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE TABLE {prefix}_project (
	id        				SERIAL PRIMARY KEY NOT NULL,
	title          			VARCHAR(255) NOT NULL,
	content        			TEXT NOT NULL,
	slug 					VARCHAR(255) NOT NULL UNIQUE,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	publication_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status_id				INTEGER NOT NULL,
	user_id 				INTEGER NOT NULL,
	seo_title				VARCHAR(255),
	seo_description			VARCHAR(255),
	seo_keyword				VARCHAR(100),
	featured_image			VARCHAR(255),
	CONSTRAINT fk_project_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id),
	CONSTRAINT fk_project_status FOREIGN KEY (status_id) REFERENCES {prefix}_status(id)
);

CREATE TABLE {prefix}_comment (
	id        			SERIAL PRIMARY KEY NOT NULL,
	comment    			VARCHAR(1000) NOT NULL,
	user_id    			INTEGER,
	mail				VARCHAR(320) NOT NULL,
	status  			INTEGER NOT NULL DEFAULT 0,
	name 				VARCHAR(110) NOT NULL,
	project_id			INTEGER NOT NULL,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id),
	CONSTRAINT fk_comment_project FOREIGN KEY (project_id) REFERENCES {prefix}_project(id)
);

CREATE TABLE {prefix}_formation (
	id        			SERIAL PRIMARY KEY NOT NULL,
	school           	VARCHAR(255),
	start_date          DATE,
	end_date        	DATE,
	diploma 			VARCHAR(255),
	mention             VARCHAR(255),
	domain    			VARCHAR(255),
	training_center     VARCHAR(255),
	user_id             INTEGER NOT NULL,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE TABLE {prefix}_experience (
	id         			SERIAL PRIMARY KEY NOT NULL,
	name               	VARCHAR(255),
	type 				VARCHAR(255),
	company      		VARCHAR(255),
	start_date          DATE,
	end_date           	DATE,
	domain              VARCHAR(255),
	description 		VARCHAR(1000),
	user_id             INTEGER NOT NULL,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE TABLE {prefix}_skill (
	id            		SERIAL PRIMARY KEY NOT NULL,
	title               VARCHAR(255),
	level 				VARCHAR(255),
	description   		VARCHAR(1000),
	user_id             INTEGER NOT NULL,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE TABLE {prefix}_contact (
	id        			SERIAL PRIMARY KEY NOT NULL,
	name      			VARCHAR(255),
	link      			VARCHAR(2000),
	user_id	  			INT NOT NULL,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES {prefix}_user(id)
);

CREATE TABLE {prefix}_page (
	id        				SERIAL PRIMARY KEY NOT NULL,
	title 					VARCHAR(255) NOT NULL,
	content					TEXT NOT NULL,
	slug 					VARCHAR(255) NOT NULL UNIQUE,
    creation_date 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	publication_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_id				INTEGER NOT NULL,
	user_id 				INTEGER NOT NULL,
	seo_title				VARCHAR(255),
	seo_description			VARCHAR(255),
	seo_keyword				VARCHAR(100),
	CONSTRAINT fk_page_user FOREIGN KEY (user_id) REFERENCES {prefix}_user(id),
	CONSTRAINT fk_page_status FOREIGN KEY (status_id) REFERENCES {prefix}_status(id)
);

CREATE TABLE {prefix}_setting
(
   	id        				SERIAL PRIMARY KEY NOT NULL,
    key						VARCHAR(255),
	value					VARCHAR(255),
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE {prefix}_project_tags (
	id        		SERIAL PRIMARY KEY NOT NULL,
	tag_id			INTEGER NOT NULL,
	project_id      INTEGER NOT NULL,
	FOREIGN KEY (project_id) REFERENCES {prefix}_project(id),
	FOREIGN KEY (tag_id) REFERENCES {prefix}_tag(id)
);

CREATE TABLE {prefix}_pagehistory (
  id        	SERIAL PRIMARY KEY NOT NULL,
  page_id 		INT NOT NULL,
  title 		VARCHAR(255) NOT NULL,
  content 		text NOT NULL,
  slug 			VARCHAR(255) NOT NULL UNIQUE,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (page_id) REFERENCES {prefix}_page(id)
);

CREATE TABLE {prefix}_menu (
    id    			SERIAL PRIMARY KEY NOT NULL,
    menu 			VARCHAR(255),
	position 		VARCHAR(255),
	alignement 		VARCHAR(255),
    title 			VARCHAR(255) NOT NULL,
    url 			VARCHAR(255) NOT NULL,
    parent_id 		INT DEFAULT NULL,
    item_position 	INT NOT NULL,
    FOREIGN KEY (parent_id) REFERENCES {prefix}_menu(id) ON DELETE CASCADE
);