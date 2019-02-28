CREATE SCHEMA cs313_php_project
    AUTHORIZATION rohbhucrknntgd;

CREATE TABLE cs313_php_project."user"
(
    user_id integer NOT NULL DEFAULT nextval('cs313_php_project.user_user_id_seq'::regclass),
    user_name character varying(40) COLLATE pg_catalog."default" NOT NULL,
    user_password character varying(300) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT user_pkey PRIMARY KEY (user_id),
    CONSTRAINT user_user_name_key UNIQUE (user_name)

)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

CREATE TABLE cs313_php_project.list
(
    list_id integer NOT NULL DEFAULT nextval('cs313_php_project.list_list_id_seq'::regclass),
    content character varying(200) COLLATE pg_catalog."default" NOT NULL,
    user_id integer NOT NULL DEFAULT 1,
    CONSTRAINT list_pkey PRIMARY KEY (list_id),
    CONSTRAINT list_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES cs313_php_project."user" (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

CREATE TABLE cs313_php_project.user_permission
(
    user_permision_id integer NOT NULL DEFAULT nextval('cs313_php_project.user_permission_user_permision_id_seq'::regclass),
    user_id_owner integer NOT NULL,
    list_id integer NOT NULL,
    user_id_shared integer NOT NULL,
    CONSTRAINT user_permission_pkey PRIMARY KEY (user_permision_id),
    CONSTRAINT user_permission_list_id_fkey FOREIGN KEY (list_id)
        REFERENCES cs313_php_project.list (list_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT user_permission_user_id_owner_fkey FOREIGN KEY (user_id_owner)
        REFERENCES cs313_php_project."user" (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT user_permission_user_id_shared_fkey FOREIGN KEY (user_id_shared)
        REFERENCES cs313_php_project."user" (user_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;
