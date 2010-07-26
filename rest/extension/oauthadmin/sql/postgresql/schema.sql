CREATE SEQUENCE ezprest_clients_s
    START 1
    INCREMENT 1
    MAXVALUE 9223372036854775807
    MINVALUE 1
    CACHE 1;

CREATE TABLE ezprest_clients (
    id integer DEFAULT nextval('ezprest_clients_s'::text) NOT NULL,
    client_id character varying(200) DEFAULT ''::character varying NOT NULL,
    client_secret character varying(200) DEFAULT ''::character varying NOT NULL,
    endpoint_uri character varying(200) DEFAULT ''::character varying NOT NULL,
);

ADD CONSTRAINT ezprest_clients PRIMARY KEY (id);
