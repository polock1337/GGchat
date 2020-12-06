-- Table: public.ggchat

CREATE DATABASE ggchat
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'French_Canada.1252'
    LC_CTYPE = 'French_Canada.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- Table: public.membre

CREATE TABLE public.membre
(
    id SERIAL,
    membre_first character varying(50) COLLATE pg_catalog."default",
    membre_last character varying(50) COLLATE pg_catalog."default",
    membre_email character varying(50) COLLATE pg_catalog."default",
    membre_uid character varying(50) COLLATE pg_catalog."default",
    membre_pwd character varying(262) COLLATE pg_catalog."default",
    CONSTRAINT membre_pkey PRIMARY KEY (id)
);

-- Table: public.groupe

CREATE TABLE public.groupe
(
    id SERIAL,
    groupe_nom character varying(50) COLLATE pg_catalog."default",
    CONSTRAINT groupe_pkey PRIMARY KEY (id)

);
-- Table: public.message_groupe

CREATE TABLE public.message_groupe
(
    id SERIAL,
    groupe_fkey integer,
    membre_fkey integer,
    message_groupe_contenu character varying(255) COLLATE pg_catalog."default",
    CONSTRAINT groupe_fkey FOREIGN KEY (groupe_fkey)
        REFERENCES public.groupe (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT membre_fkey FOREIGN KEY (membre_fkey)
        REFERENCES public.membre (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);