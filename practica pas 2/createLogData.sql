create table logdata(
    "message" text,
    "loglevel" smallint,
    "logdate" timestamp without time zone DEFAULT now() NOT NULL,
    "module" varchar(255)
)