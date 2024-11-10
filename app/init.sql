\connect "mydb";

DROP TABLE IF EXISTS "categoria";
DROP SEQUENCE IF EXISTS categoria_id_seq;
CREATE SEQUENCE categoria_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."categoria" (
    "id" integer DEFAULT nextval('categoria_id_seq') NOT NULL,
    "nome" text NOT NULL,
    "imposto" smallint NOT NULL,
    CONSTRAINT "categoria_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "categoria" ("id", "nome", "imposto") VALUES
(11,	'Higiene',	4),
(12,	'Carnes',	10),
(13,	'bebidas',	9),
(14,	'Laticínios',	6),
(15,	'Padaria',	4);

DROP TABLE IF EXISTS "produtos";
DROP SEQUENCE IF EXISTS produtos_id_seq;
CREATE SEQUENCE produtos_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."produtos" (
    "id" integer DEFAULT nextval('produtos_id_seq') NOT NULL,
    "nome" text NOT NULL,
    "preco" numeric NOT NULL,
    "img" text,
    "descricao" text NOT NULL,
    "categoria_id" integer NOT NULL,
    CONSTRAINT "produtos_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "produtos" ("id", "nome", "preco", "img", "descricao", "categoria_id") VALUES
(14,	'Sabonete',	3,	'files/images/2024/11/sabonete.png',	'Sabonete 15 em 1',	11),
(15,	'Shampoo',	15,	'files/images/2024/11/shampoo.png',	'Shampoo 25 em 1 WD40 incluido',	11),
(16,	'Sprite',	4,	'files/images/2024/11/sprite.png',	'Bão',	13),
(17,	'Coca',	6,	'files/images/2024/11/coca.png',	'Coca cola dora',	13),
(18,	'Cacetinho la ele',	26,	'files/images/2024/11/cacetinho-la-ele.png',	'La ele 1000x',	15);

DROP TABLE IF EXISTS "usuario";
DROP SEQUENCE IF EXISTS usuario_id_seq;
CREATE SEQUENCE usuario_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."usuario" (
    "id" integer DEFAULT nextval('usuario_id_seq') NOT NULL,
    "nome" text NOT NULL,
    "cpf" text NOT NULL,
    "email" text NOT NULL,
    "nasc" date NOT NULL,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "role" text NOT NULL,
    "profile" text,
    "block" smallint DEFAULT '0' NOT NULL,
    "access" bigint,
    CONSTRAINT "usuario_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "usuario" ("id", "nome", "cpf", "email", "nasc", "created_at", "role", "profile", "block", "access") VALUES
(27,	'Guilherme Brasil',	'792.151.950-41',	'guilherme@gmail.com',	'2001-04-07',	'2024-11-08 20:12:06.00857',	'caixa',	'files/images/2024/11/guilherme-brasil-1731099949.png',	0,	829443),
(25,	'Raminho caixa dgua',	'711.133.770-03',	'raminho@gmail.com',	'2001-04-07',	'2024-11-08 14:19:03.322525',	'caixa',	'files/images/2024/11/raminho-caixa-dgua-1731093730.png',	0,	411773),
(24,	'reicariri',	'736.712.720-90',	'cariri@gmail.com',	'2001-04-07',	'2024-11-08 13:39:08.211291',	'admin',	'files/images/2024/11/reicariri.png',	0,	123456);

DROP TABLE IF EXISTS "venda";
DROP SEQUENCE IF EXISTS venda_id_seq;
CREATE SEQUENCE venda_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."venda" (
    "id" integer DEFAULT nextval('venda_id_seq') NOT NULL,
    "metodo" text,
    "created_at" timestamp DEFAULT now() NOT NULL,
    "cpf" text,
    "vendedor_id" integer NOT NULL,
    "open" integer DEFAULT '1' NOT NULL,
    CONSTRAINT "venda_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "venda" ("id", "metodo", "created_at", "cpf", "vendedor_id", "open") VALUES
(36,	'DINHEIRO',	'2024-11-08 19:41:32.597229',	'503.065.128-40',	25,	0),
(37,	'CREDITO',	'2024-11-08 20:06:36.646272',	'503.065.128-40',	25,	0),
(39,	'CREDITO',	'2024-11-08 20:44:34.193914',	'503.065.128-40',	27,	0),
(40,	'DEBITO',	'2024-11-08 23:16:00.641335',	'503.065.128-40',	25,	0);

DROP TABLE IF EXISTS "vendaproduto";
DROP SEQUENCE IF EXISTS venda_produto_id_seq;
CREATE SEQUENCE venda_produto_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."vendaproduto" (
    "id" integer DEFAULT nextval('venda_produto_id_seq') NOT NULL,
    "venda_id" integer NOT NULL,
    "produto_id" integer NOT NULL,
    "qtd" integer NOT NULL,
    CONSTRAINT "venda_produto_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "vendaproduto" ("id", "venda_id", "produto_id", "qtd") VALUES
(53,	40,	18,	3),
(54,	40,	14,	1),
(55,	40,	15,	1),
(56,	40,	17,	1),
(57,	40,	16,	3),
(46,	36,	17,	9),
(47,	36,	14,	7),
(48,	36,	18,	2),
(50,	37,	17,	1),
(49,	37,	16,	2),
(51,	39,	15,	2),
(52,	39,	18,	2);

ALTER TABLE ONLY "public"."produtos" ADD CONSTRAINT "produtos_categoria_id_fkey" FOREIGN KEY (categoria_id) REFERENCES categoria(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."venda" ADD CONSTRAINT "venda_vendedor_fkey" FOREIGN KEY (vendedor_id) REFERENCES usuario(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."vendaproduto" ADD CONSTRAINT "venda_produto_produto_id_fkey" FOREIGN KEY (produto_id) REFERENCES produtos(id) NOT DEFERRABLE;
ALTER TABLE ONLY "public"."vendaproduto" ADD CONSTRAINT "venda_produto_venda_id_fkey" FOREIGN KEY (venda_id) REFERENCES venda(id) NOT DEFERRABLE;

-- 2024-11-10 18:07:50.593099+00