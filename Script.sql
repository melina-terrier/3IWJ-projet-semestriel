DROP TABLE IF EXISTS esgi_status CASCADE;
DROP TABLE IF EXISTS esgi_role CASCADE;
DROP TABLE IF EXISTS esgi_user CASCADE;
DROP TABLE IF EXISTS esgi_tag CASCADE;
DROP TABLE IF EXISTS esgi_media CASCADE;
DROP TABLE IF EXISTS esgi_project CASCADE;
DROP TABLE IF EXISTS esgi_comment CASCADE;
DROP TABLE IF EXISTS esgi_formation CASCADE;
DROP TABLE IF EXISTS esgi_experience CASCADE;
DROP TABLE IF EXISTS esgi_skill CASCADE;
DROP TABLE IF EXISTS esgi_contact CASCADE;
DROP TABLE IF EXISTS esgi_page CASCADE;
DROP TABLE IF EXISTS esgi_setting CASCADE;
DROP TABLE IF EXISTS esgi_project_tags CASCADE;
DROP TABLE IF EXISTS esgi_pagehistory CASCADE;
DROP TABLE IF EXISTS esgi_menu CASCADE;

CREATE TABLE esgi_status (
	id        SERIAL PRIMARY KEY NOT NULL,
  	status 	  VARCHAR(255) NOT NULL
);
INSERT INTO esgi_status (status) VALUES
  ('Publié'),
  ('Supprimé'),
  ('Brouillon');

CREATE TABLE esgi_role (
	id        SERIAL PRIMARY KEY NOT NULL,
	role      VARCHAR(50) NOT NULL
);
INSERT INTO esgi_role (role) VALUES
  ('Administrateur'),
  ('Editeur'),
  ('Utilisateur');

CREATE TABLE esgi_user (
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
	country					VARCHAR(255),
	city 					VARCHAR(60),
	website					VARCHAR(2000),
	link					VARCHAR(2000),
	skill					VARCHAR(2000),
	formation				VARCHAR(2000),
	experience				VARCHAR(2000),
	description				VARCHAR(1000),
	interest				VARCHAR(1000),
	CONSTRAINT fk_user_role FOREIGN KEY (id_role) REFERENCES esgi_role(id)
);

CREATE TABLE esgi_tag (
	id   				SERIAL PRIMARY KEY NOT NULL,
	name 				VARCHAR(255) NOT NULL,
	slug 				VARCHAR(255) NOT NULL UNIQUE,
	description 		VARCHAR(1000),
	user_id 			INTEGER NOT NULL,
	creation_date 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_tag_user FOREIGN KEY (user_id) REFERENCES esgi_user(id)
);

CREATE TABLE esgi_media (
	id        			SERIAL PRIMARY KEY NOT NULL,
	title           	VARCHAR(255) NOT NULL,
	description 		VARCHAR(1000) NOT NULL,
	name           		VARCHAR(255) NOT NULL,
	type 				VARCHAR(255) NOT NULL,
	size           		INTEGER NOT NULL,
	url 				VARCHAR(255) NOT NULL,
	user_id 			INTEGER NOT NULL,
	creation_date 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	modification_date 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_media_user FOREIGN KEY (user_id) REFERENCES esgi_user(id)
);

CREATE TABLE esgi_project (
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
	CONSTRAINT fk_project_user FOREIGN KEY (user_id) REFERENCES esgi_user(id),
	CONSTRAINT fk_project_status FOREIGN KEY (status_id) REFERENCES esgi_status(id)
);

CREATE TABLE esgi_comment (
	id        			SERIAL PRIMARY KEY NOT NULL,
	comment    			VARCHAR(1000) NOT NULL,
	user_id    			INTEGER,
	mail				VARCHAR(320) NOT NULL,
	status  			INTEGER NOT NULL DEFAULT 0,
	name 				VARCHAR(110) NOT NULL,
	project_id			INTEGER NOT NULL,
	creation_date     	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    modification_date   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES esgi_user(id),
	CONSTRAINT fk_comment_project FOREIGN KEY (project_id) REFERENCES esgi_project(id)
);

CREATE TABLE esgi_page (
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
	CONSTRAINT fk_page_user FOREIGN KEY (user_id) REFERENCES esgi_user(id),
	CONSTRAINT fk_page_status FOREIGN KEY (status_id) REFERENCES esgi_status(id)
);

CREATE TABLE esgi_setting
(
   	id        				SERIAL PRIMARY KEY NOT NULL,
    key						VARCHAR(255),
	value					VARCHAR(255),
    modification_date		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	creation_date       	TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE esgi_project_tags (
	id        		SERIAL PRIMARY KEY NOT NULL,
	tag_id			INTEGER NOT NULL,
	project_id      INTEGER NOT NULL,
	FOREIGN KEY (project_id) REFERENCES esgi_project(id),
	FOREIGN KEY (tag_id) REFERENCES esgi_tag(id)
);

CREATE TABLE esgi_pagehistory (
  id        	SERIAL PRIMARY KEY NOT NULL,
  page_id 		INT NOT NULL,
  title 		VARCHAR(255) NOT NULL,
  content 		text NOT NULL,
  slug 			VARCHAR(255) NOT NULL UNIQUE,
  creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (page_id) REFERENCES esgi_page(id)
);

CREATE TABLE esgi_menu (
    id    			SERIAL PRIMARY KEY NOT NULL,
    type 			VARCHAR(255),
	position 		VARCHAR(255),
	alignement 		VARCHAR(255)
);

CREATE TABLE esgi_itemMenu (
    id    			SERIAL PRIMARY KEY NOT NULL,
    menu_id 		INT,
    title 			VARCHAR(255) NOT NULL,
    url 			VARCHAR(255) NOT NULL,
    item_position 	INT NOT NULL,
    FOREIGN KEY (menu_id) REFERENCES esgi_menu(id)
);