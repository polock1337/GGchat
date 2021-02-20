-- Database: ggchat

-- DROP DATABASE ggchat;

CREATE DATABASE ggchat
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'French_Canada.1252'
    LC_CTYPE = 'French_Canada.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;
	
-- Table: public.groupe

-- DROP TABLE public.groupe;

CREATE TABLE public.groupe
(
    id SERIAL NOT NULL,
    groupe_nom character varying(50) COLLATE pg_catalog."default",
    CONSTRAINT groupe_pkey PRIMARY KEY (id)
)

-- Table: public.membre

-- DROP TABLE public.membre;

CREATE TABLE public.membre
(
    id SERIAL NOT NULL,
    membre_admin boolean,
    membre_first character varying(50) COLLATE pg_catalog."default",
    membre_last character varying(50) COLLATE pg_catalog."default",
    membre_email character varying(100) COLLATE pg_catalog."default",
    membre_uid character varying(50) COLLATE pg_catalog."default",
    membre_pwd character varying(262) COLLATE pg_catalog."default",
    
    CONSTRAINT membre_pkey PRIMARY KEY (id)
)

-- Table: public.message_groupe

-- DROP TABLE public.message_groupe;

CREATE TABLE public.message_groupe
(
    id SERIAL NOT NULL,
    groupe_fkey integer,
    membre_fkey integer,
    message_groupe_contenu character varying(255) COLLATE pg_catalog."default",
    "timestamp" character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT groupe_fkey FOREIGN KEY (groupe_fkey)
        REFERENCES public.groupe (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT membre_fkey FOREIGN KEY (membre_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

-- Table: public.message_groupe_archive

-- DROP TABLE public.message_groupe_archive;

CREATE TABLE public.message_groupe_archive
(
    id SERIAL NOT NULL,
    groupe_fkey integer,
    membre_fkey integer,
    message_groupe_contenu character varying(255) COLLATE pg_catalog."default",
    "timestamp" character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT groupe_fkey FOREIGN KEY (groupe_fkey)
        REFERENCES public.groupe (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT membre_fkey FOREIGN KEY (membre_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

-- Table: public.message_prive

-- DROP TABLE public.message_prive;

CREATE TABLE public.message_prive
(
    id SERIAL NOT NULL,
    membre_envoyeur_fkey integer,
    membre_receveur_fkey integer,
    message_prive_contenu character varying(255) COLLATE pg_catalog."default",
    "timestamp" character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT membre_envoyeur_fkey FOREIGN KEY (membre_envoyeur_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT membre_receveur_fkey FOREIGN KEY (membre_receveur_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

-- Table: public.message_prive_archive

-- DROP TABLE public.message_prive_archive;

CREATE TABLE public.message_prive_archive
(
    id SERIAL NOT NULL,
    membre_envoyeur_fkey integer,
    membre_receveur_fkey integer,
    message_prive_contenu character varying(255) COLLATE pg_catalog."default",
    "timestamp" character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT membre_envoyeur_fkey FOREIGN KEY (membre_envoyeur_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT membre_receveur_fkey FOREIGN KEY (membre_receveur_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

CREATE INDEX index_message_groupe_contenu ON message_groupe(message_groupe_contenu)
CREATE INDEX index_message_groupe_fkey ON message_groupe(groupe_fkey)
CREATE INDEX index_message_membre_fkey ON message_groupe(membre_fkey)

CREATE INDEX index_message_membre_envoyeur_fkey ON message_prive(membre_envoyeur_fkey)
CREATE INDEX index_message_membre_receveur_fkey ON message_prive(membre_receveur_fkey)
CREATE INDEX index_message_prive_contenu ON message_prive(message_prive_contenu)

CREATE VIEW nombre_msg_group AS SELECT COUNT(id) as nombre, groupe_fkey FROM public.message_groupe GROUP BY groupe_fkey;