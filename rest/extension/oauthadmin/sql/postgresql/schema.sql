CREATE SEQUENCE ezprest_clients_s
    START 1
    INCREMENT 1
    MAXVALUE 9223372036854775807
    MINVALUE 1
    CACHE 1;

CREATE TABLE ezprest_clients (
    id integer DEFAULT nextval('ezprest_clients_s'::text) NOT NULL,
    name character varying(100) DEFAULT ''::character varying NOT NULL,
    description text DEFAULT ''::text NOT NULL,
    client_id character varying(200) DEFAULT ''::character varying NOT NULL,
    client_secret character varying(200) DEFAULT ''::character varying NOT NULL,
    endpoint_uri character varying(200) DEFAULT ''::character varying NOT NULL,
    owner_id integer DEFAULT 0 NOT NULL,
    created integer DEFAULT 0 NOT NULL,
    updated integer DEFAULT 0 NOT NULL,
    "version" integer DEFAULT 0 NOT NULL
);

ALTER TABLE ezprest_clients ADD CONSTRAINT ezprest_clients_pkey PRIMARY KEY (id);
CREATE INDEX client_id ON ezprest_clients USING btree ( client_id );
CREATE UNIQUE INDEX client_id_UNIQUE ON ezprest_clients USING btree ( client_id, "version" );
