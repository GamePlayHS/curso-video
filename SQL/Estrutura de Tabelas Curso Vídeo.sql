
DROP TABLE IF EXISTS public.TBCURSO CASCADE;
CREATE TABLE public.TBCURSO (
                CURCODIGO BIGINT NOT NULL,
                CURNOME VARCHAR(100) NOT NULL,
                CURDESCRICAO VARCHAR(500) NOT NULL,
                CURIMAGEM BYTEA NOT NULL,
                CURNOMEIMAGEM VARCHAR NOT NULL,
                CONSTRAINT pk_tbcurso PRIMARY KEY (CURCODIGO)
);

DROP SEQUENCE public.tbvideo_vidcodigo_seq CASCADE;
CREATE SEQUENCE public.tbvideo_vidcodigo_seq;

DROP TABLE IF EXISTS public.tbvideo CASCADE;
CREATE TABLE public.tbvideo (
                VIDCODIGO BIGINT NOT NULL DEFAULT nextval('public.tbvideo_vidcodigo_seq'),
                VIDTITULO VARCHAR(255) NOT NULL,
                VIDDESCRICAO VARCHAR NOT NULL,
                VIDARQUIVO VARCHAR(255) NOT NULL,
                VIDDATAHORAREGISTRO TIMESTAMP DEFAULT now()::timestamp NOT NULL,
                CONSTRAINT pk_tbvideo PRIMARY KEY (VIDCODIGO)
);

ALTER SEQUENCE public.tbvideo_vidcodigo_seq OWNED BY public.tbvideo.VIDCODIGO;

DROP TABLE IF EXISTS public.TBCURSOVIDEO CASCADE;
CREATE TABLE public.TBCURSOVIDEO (
                CURCODIGO BIGINT NOT NULL,
                CVISEQUENCIA BIGINT NOT NULL,
                VIDCODIGO BIGINT NOT NULL,
                CONSTRAINT pk_tbcursovideo PRIMARY KEY (CURCODIGO, CVISEQUENCIA)
);

DROP SEQUENCE IF EXISTS public.tbavaliacao_avacodigo_seq CASCADE;
CREATE SEQUENCE public.tbavaliacao_avacodigo_seq;

DROP TABLE IF EXISTS public.TBAVALIACAO CASCADE;
CREATE TABLE public.TBAVALIACAO (
                AVACODIGO BIGINT NOT NULL DEFAULT nextval('public.tbavaliacao_avacodigo_seq'),
                VIDCODIGO BIGINT NOT NULL,
                AVAQUESTAO VARCHAR NOT NULL,
                CONSTRAINT pk_tbavaliacao PRIMARY KEY (AVACODIGO, VIDCODIGO)
);

ALTER SEQUENCE public.tbavaliacao_avacodigo_seq OWNED BY public.TBAVALIACAO.AVACODIGO;

DROP SEQUENCE IF EXISTS public.tbalternativas_altcodigo_seq CASCADE;
CREATE SEQUENCE public.tbalternativas_altcodigo_seq;

DROP TABLE IF EXISTS public.tbalternativas CASCADE;
CREATE TABLE public.tbalternativas (
                ALTCODIGO BIGINT NOT NULL DEFAULT nextval('public.tbalternativas_altcodigo_seq'),
                ALTDESCRICAO VARCHAR(255) NOT NULL,
                ALTCORRETA BOOLEAN DEFAULT false NOT NULL,
                AVACODIGO BIGINT NOT NULL,
                VIDCODIGO BIGINT NOT NULL,
                CONSTRAINT pk_tbalternativas PRIMARY KEY (ALTCODIGO)
);

ALTER SEQUENCE public.tbalternativas_altcodigo_seq OWNED BY public.tbalternativas.ALTCODIGO;

ALTER TABLE public.TBCURSOVIDEO ADD CONSTRAINT tbcurso_tbcursovideo_fk
FOREIGN KEY (CURCODIGO)
REFERENCES public.TBCURSO (CURCODIGO)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.TBAVALIACAO ADD CONSTRAINT tbvideo_tbavaliacoes_fk
FOREIGN KEY (VIDCODIGO)
REFERENCES public.tbvideo (VIDCODIGO)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.TBCURSOVIDEO ADD CONSTRAINT tbvideo_tbcursovideo_fk
FOREIGN KEY (VIDCODIGO)
REFERENCES public.tbvideo (VIDCODIGO)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tbalternativas ADD CONSTRAINT tbavaliacao_tbalternativas_fk
FOREIGN KEY (AVACODIGO, VIDCODIGO)
REFERENCES public.TBAVALIACAO (AVACODIGO, VIDCODIGO)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;