--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4
-- Dumped by pg_dump version 16.4

-- Started on 2024-11-24 17:13:09

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 25234)
-- Name: factura; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.factura (
    id_factura integer NOT NULL,
    id_reserva integer,
    fecha_factura date,
    monto_total numeric(10,3)
);


ALTER TABLE public.factura OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 25233)
-- Name: factura_id_factura_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.factura_id_factura_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.factura_id_factura_seq OWNER TO postgres;

--
-- TOC entry 4887 (class 0 OID 0)
-- Dependencies: 215
-- Name: factura_id_factura_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.factura_id_factura_seq OWNED BY public.factura.id_factura;


--
-- TOC entry 218 (class 1259 OID 25241)
-- Name: habitaciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.habitaciones (
    id_habitacion integer NOT NULL,
    nombre character varying(50),
    capacidad character(2),
    estado character(1) DEFAULT 'A'::bpchar,
    precio integer,
    descripcion text,
    imagen character varying(255),
    CONSTRAINT ckc_estado_habitaci CHECK (((estado IS NULL) OR (estado = ANY (ARRAY['A'::bpchar, 'I'::bpchar, 'M'::bpchar, 'L'::bpchar, 'O'::bpchar]))))
);


ALTER TABLE public.habitaciones OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 25240)
-- Name: habitaciones_id_habitacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.habitaciones_id_habitacion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.habitaciones_id_habitacion_seq OWNER TO postgres;

--
-- TOC entry 4888 (class 0 OID 0)
-- Dependencies: 217
-- Name: habitaciones_id_habitacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.habitaciones_id_habitacion_seq OWNED BY public.habitaciones.id_habitacion;


--
-- TOC entry 220 (class 1259 OID 25250)
-- Name: pago; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pago (
    id_pago integer NOT NULL,
    id_factura integer,
    forma_pago integer,
    fecha date,
    monto_pagado integer,
    paypal_order_id character varying(255),
    estado_pago character varying(50) DEFAULT 'pendiente'::character varying,
    id_reserva integer
);


ALTER TABLE public.pago OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 25249)
-- Name: pago_id_pago_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pago_id_pago_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pago_id_pago_seq OWNER TO postgres;

--
-- TOC entry 4889 (class 0 OID 0)
-- Dependencies: 219
-- Name: pago_id_pago_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pago_id_pago_seq OWNED BY public.pago.id_pago;


--
-- TOC entry 222 (class 1259 OID 25257)
-- Name: personas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personas (
    id_persona integer NOT NULL,
    nombre character varying(50),
    email character varying(50),
    apellido character varying(50),
    telefono character varying(12),
    cedula character varying(10),
    contrasenha character varying(150)
);


ALTER TABLE public.personas OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 25256)
-- Name: personas_id_persona_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personas_id_persona_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personas_id_persona_seq OWNER TO postgres;

--
-- TOC entry 4890 (class 0 OID 0)
-- Dependencies: 221
-- Name: personas_id_persona_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personas_id_persona_seq OWNED BY public.personas.id_persona;


--
-- TOC entry 224 (class 1259 OID 25264)
-- Name: promocion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promocion (
    id_servicio integer,
    id_habitacion integer,
    id_promocion integer NOT NULL,
    descuento numeric(10,3),
    fecha_inicio date,
    fecha_fin date,
    estado integer
);


ALTER TABLE public.promocion OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 25263)
-- Name: promocion_id_promocion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promocion_id_promocion_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promocion_id_promocion_seq OWNER TO postgres;

--
-- TOC entry 4891 (class 0 OID 0)
-- Dependencies: 223
-- Name: promocion_id_promocion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promocion_id_promocion_seq OWNED BY public.promocion.id_promocion;


--
-- TOC entry 226 (class 1259 OID 25271)
-- Name: resenha; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.resenha (
    id_resenha integer NOT NULL,
    id_reserva integer,
    titulo character varying(150),
    calificacion integer,
    descripcion character varying(255),
    estado integer
);


ALTER TABLE public.resenha OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 25270)
-- Name: resenha_id_resenha_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.resenha_id_resenha_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.resenha_id_resenha_seq OWNER TO postgres;

--
-- TOC entry 4892 (class 0 OID 0)
-- Dependencies: 225
-- Name: resenha_id_resenha_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.resenha_id_resenha_seq OWNED BY public.resenha.id_resenha;


--
-- TOC entry 230 (class 1259 OID 25289)
-- Name: reserva_habitacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reserva_habitacion (
    id_reserva integer NOT NULL,
    id_habitacion integer NOT NULL,
    fecha_inicio date,
    fecha_fin date
);


ALTER TABLE public.reserva_habitacion OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 25284)
-- Name: reserva_servicio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reserva_servicio (
    id_reserva integer NOT NULL,
    id_servicio integer NOT NULL,
    cantidad character(2),
    fecha_inicio date,
    fecha_fin date
);


ALTER TABLE public.reserva_servicio OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 25278)
-- Name: reservas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservas (
    id_reserva integer NOT NULL,
    id_persona integer,
    fecha_reserva date,
    estado integer
);


ALTER TABLE public.reservas OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 25277)
-- Name: reservas_id_reserva_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reservas_id_reserva_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reservas_id_reserva_seq OWNER TO postgres;

--
-- TOC entry 4893 (class 0 OID 0)
-- Dependencies: 227
-- Name: reservas_id_reserva_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reservas_id_reserva_seq OWNED BY public.reservas.id_reserva;


--
-- TOC entry 232 (class 1259 OID 25295)
-- Name: servicios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.servicios (
    id_servicio integer NOT NULL,
    nombre character varying(50),
    precio integer,
    cantidad_limite character(2),
    estado character(1) DEFAULT 'A'::bpchar,
    descripcion text,
    imagen character varying(255),
    CONSTRAINT ckc_estado_servicio CHECK (((estado IS NULL) OR (estado = ANY (ARRAY['A'::bpchar, 'I'::bpchar]))))
);


ALTER TABLE public.servicios OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 25294)
-- Name: servicios_id_servicio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.servicios_id_servicio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.servicios_id_servicio_seq OWNER TO postgres;

--
-- TOC entry 4894 (class 0 OID 0)
-- Dependencies: 231
-- Name: servicios_id_servicio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.servicios_id_servicio_seq OWNED BY public.servicios.id_servicio;


--
-- TOC entry 4677 (class 2604 OID 25237)
-- Name: factura id_factura; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factura ALTER COLUMN id_factura SET DEFAULT nextval('public.factura_id_factura_seq'::regclass);


--
-- TOC entry 4678 (class 2604 OID 25244)
-- Name: habitaciones id_habitacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.habitaciones ALTER COLUMN id_habitacion SET DEFAULT nextval('public.habitaciones_id_habitacion_seq'::regclass);


--
-- TOC entry 4680 (class 2604 OID 25253)
-- Name: pago id_pago; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pago ALTER COLUMN id_pago SET DEFAULT nextval('public.pago_id_pago_seq'::regclass);


--
-- TOC entry 4682 (class 2604 OID 25260)
-- Name: personas id_persona; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personas ALTER COLUMN id_persona SET DEFAULT nextval('public.personas_id_persona_seq'::regclass);


--
-- TOC entry 4683 (class 2604 OID 25267)
-- Name: promocion id_promocion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion ALTER COLUMN id_promocion SET DEFAULT nextval('public.promocion_id_promocion_seq'::regclass);


--
-- TOC entry 4684 (class 2604 OID 25274)
-- Name: resenha id_resenha; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenha ALTER COLUMN id_resenha SET DEFAULT nextval('public.resenha_id_resenha_seq'::regclass);


--
-- TOC entry 4685 (class 2604 OID 25281)
-- Name: reservas id_reserva; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservas ALTER COLUMN id_reserva SET DEFAULT nextval('public.reservas_id_reserva_seq'::regclass);


--
-- TOC entry 4686 (class 2604 OID 25298)
-- Name: servicios id_servicio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.servicios ALTER COLUMN id_servicio SET DEFAULT nextval('public.servicios_id_servicio_seq'::regclass);


--
-- TOC entry 4865 (class 0 OID 25234)
-- Dependencies: 216
-- Data for Name: factura; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.factura (id_factura, id_reserva, fecha_factura, monto_total) FROM stdin;
\.


--
-- TOC entry 4867 (class 0 OID 25241)
-- Dependencies: 218
-- Data for Name: habitaciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.habitaciones (id_habitacion, nombre, capacidad, estado, precio, descripcion, imagen) FROM stdin;
4	habitacion cuadruple	4 	A	390000	\N	\N
1	habitacion matrimonial 1	2 	A	260000	\N	assets/img/habitaciones/habitacion matrimonial 1-disponibilidad.jpg
2	habitacion matrimonial 2	2 	A	260000	\N	assets/img/habitaciones/habitacion matrimonial 2-disponibilidad.jpg
3	habitacion triple	3 	A	330000	\N	assets/img/habitaciones/habitacion triple-disponibilidad.jpg
\.


--
-- TOC entry 4869 (class 0 OID 25250)
-- Dependencies: 220
-- Data for Name: pago; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pago (id_pago, id_factura, forma_pago, fecha, monto_pagado, paypal_order_id, estado_pago, id_reserva) FROM stdin;
1	\N	1	2024-11-23	100000	692279188Y035543E	COMPLETADO	39
2	\N	1	2024-11-23	80000	77467931DU5513615	COMPLETADO	40
3	\N	1	2024-11-23	80000	0PG69441T99198910	COMPLETADO	41
4	\N	1	2024-11-23	100000	90X2275650563971F	COMPLETADO	42
5	\N	1	2024-11-23	80000	43416084DP478251V	COMPLETADO	43
6	\N	1	2024-11-23	100000	6GK386466L888072B	COMPLETADO	44
7	\N	1	2024-11-23	300000	29192018132203035	COMPLETADO	45
8	\N	1	2024-11-23	260000	1NT21770R2700900H	COMPLETADO	46
9	\N	1	2024-11-23	200000	1KK56033BB572691F	COMPLETADO	47
10	\N	1	2024-11-23	100000	2E932427GD893680L	COMPLETADO	48
11	\N	1	2024-11-23	260000	87S4282315773030J	COMPLETADO	49
12	\N	1	2024-11-23	330000	28W41374TL304212A	COMPLETADO	50
13	\N	1	2024-11-23	390000	4V243591RM741160J	COMPLETADO	51
14	\N	1	2024-11-23	390000	5UB61855LU7069026	COMPLETADO	52
15	\N	1	2024-11-23	40000	2C0468333L3828056	COMPLETADO	53
16	\N	1	2024-11-23	100000	3RS587738T8642452	COMPLETADO	54
17	\N	1	2024-11-23	50000	70R1220824415632M	COMPLETADO	55
18	\N	1	2024-11-23	40000	1CT49956YK315431P	COMPLETADO	56
19	\N	1	2024-11-23	50000	6YK03271E1615173U	COMPLETADO	57
\.


--
-- TOC entry 4871 (class 0 OID 25257)
-- Dependencies: 222
-- Data for Name: personas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.personas (id_persona, nombre, email, apellido, telefono, cedula, contrasenha) FROM stdin;
1	Guillermo	guillemvera92@gmail.com	Maldonado	0991375933	5124867	1234
2	Pepe	guille.ps4cod@gmail.com	Pepe	0991375933	5124867	$2y$10$9HF9Q1aqb7HH/uq7F7TSSu7SumqFkLLOmqlqUOVzaJTsrBv3KbF8e
3	Pepe	pepe@gmail.com	Pepe	0991375933	1111	$2y$10$usF9Z0RaQtuyhEcM/kwXb.6vY3yifBvA98uX4VIm.hFDyG19prO1O
4	hola	hola@gmail.com	hola	0991375933	11	$2y$10$no8OrI.upR0blRv.CfolnuYRewWqVa17HdDZOFIoTMgQYHizOiA.i
\.


--
-- TOC entry 4873 (class 0 OID 25264)
-- Dependencies: 224
-- Data for Name: promocion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promocion (id_servicio, id_habitacion, id_promocion, descuento, fecha_inicio, fecha_fin, estado) FROM stdin;
\.


--
-- TOC entry 4875 (class 0 OID 25271)
-- Dependencies: 226
-- Data for Name: resenha; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.resenha (id_resenha, id_reserva, titulo, calificacion, descripcion, estado) FROM stdin;
1	53	Good	4	goood	1
2	52	Hasoo	3	Muy haso	1
3	57	OIKO	5	Muy oiko	1
\.


--
-- TOC entry 4879 (class 0 OID 25289)
-- Dependencies: 230
-- Data for Name: reserva_habitacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reserva_habitacion (id_reserva, id_habitacion, fecha_inicio, fecha_fin) FROM stdin;
24	1	2024-11-09	2024-11-10
35	1	2024-11-13	2024-11-15
46	1	2024-11-28	2024-11-29
49	2	2024-11-27	2024-11-28
50	3	2024-11-26	2024-11-27
51	4	2024-11-25	2024-11-26
52	4	2024-11-27	2024-11-28
\.


--
-- TOC entry 4878 (class 0 OID 25284)
-- Dependencies: 229
-- Data for Name: reserva_servicio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reserva_servicio (id_reserva, id_servicio, cantidad, fecha_inicio, fecha_fin) FROM stdin;
2	2	2 	2024-11-08	2024-11-09
16	2	3 	2024-11-15	2024-11-16
20	1	5 	2024-11-15	2024-11-15
21	2	5 	2024-11-15	2024-11-16
22	1	5 	2024-11-09	2024-11-09
23	2	5 	2024-11-22	2024-11-23
32	2	3 	2024-11-24	2024-11-25
33	2	3 	2024-11-26	2024-11-28
34	2	2 	2024-11-19	2024-11-20
36	1	1 	2024-11-27	\N
37	1	1 	2024-11-27	\N
38	1	2 	2024-12-31	\N
39	2	2 	2024-11-28	2024-11-29
40	1	2 	2024-12-26	\N
41	1	2 	2025-01-15	\N
42	2	2 	2024-12-10	2024-12-11
43	1	2 	2025-01-26	\N
44	2	2 	2025-01-21	2025-01-22
45	2	3 	2025-02-12	2025-02-14
47	2	2 	2024-11-26	2024-11-28
48	2	2 	2024-11-24	2024-11-25
53	1	1 	2024-11-25	\N
54	2	2 	2024-11-29	2024-11-30
55	2	1 	2024-11-29	2024-11-30
56	1	1 	2024-12-12	\N
57	2	1 	2025-01-08	2025-01-09
\.


--
-- TOC entry 4877 (class 0 OID 25278)
-- Dependencies: 228
-- Data for Name: reservas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reservas (id_reserva, id_persona, fecha_reserva, estado) FROM stdin;
2	\N	2024-11-06	1
16	1	2024-11-06	1
21	1	2024-11-06	1
22	1	2024-11-07	1
23	1	2024-11-07	1
24	1	2024-11-07	1
32	1	2024-11-07	1
33	4	2024-11-07	1
34	4	2024-11-07	1
35	1	2024-11-11	1
36	1	2024-11-23	1
37	1	2024-11-23	1
38	1	2024-11-23	1
39	1	2024-11-23	1
40	1	2024-11-23	1
20	1	2024-11-06	0
41	1	2024-11-23	1
42	1	2024-11-23	1
43	1	2024-11-23	1
44	1	2024-11-23	1
45	1	2024-11-23	1
46	1	2024-11-23	1
47	1	2024-11-23	1
48	1	2024-11-23	1
49	1	2024-11-23	1
50	1	2024-11-23	1
51	1	2024-11-23	1
52	1	2024-11-23	1
53	1	2024-11-23	1
54	1	2024-11-23	1
55	1	2024-11-23	1
56	1	2024-11-23	1
57	1	2024-11-23	1
\.


--
-- TOC entry 4881 (class 0 OID 25295)
-- Dependencies: 232
-- Data for Name: servicios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.servicios (id_servicio, nombre, precio, cantidad_limite, estado, descripcion, imagen) FROM stdin;
3	Alojamiento	\N	\N	A	\N	\N
1	Pasar el dia	40000	10	A	Veni a pasar el dia con nostros	assets/img/otros/PRUEBA-PASAR2.jpg
2	Camping	50000	10	A	\N	assets/img/otros/PRUEBA-CAMPING.jpg
\.


--
-- TOC entry 4895 (class 0 OID 0)
-- Dependencies: 215
-- Name: factura_id_factura_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.factura_id_factura_seq', 1, false);


--
-- TOC entry 4896 (class 0 OID 0)
-- Dependencies: 217
-- Name: habitaciones_id_habitacion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.habitaciones_id_habitacion_seq', 4, true);


--
-- TOC entry 4897 (class 0 OID 0)
-- Dependencies: 219
-- Name: pago_id_pago_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pago_id_pago_seq', 19, true);


--
-- TOC entry 4898 (class 0 OID 0)
-- Dependencies: 221
-- Name: personas_id_persona_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.personas_id_persona_seq', 4, true);


--
-- TOC entry 4899 (class 0 OID 0)
-- Dependencies: 223
-- Name: promocion_id_promocion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promocion_id_promocion_seq', 1, false);


--
-- TOC entry 4900 (class 0 OID 0)
-- Dependencies: 225
-- Name: resenha_id_resenha_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.resenha_id_resenha_seq', 3, true);


--
-- TOC entry 4901 (class 0 OID 0)
-- Dependencies: 227
-- Name: reservas_id_reserva_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reservas_id_reserva_seq', 57, true);


--
-- TOC entry 4902 (class 0 OID 0)
-- Dependencies: 231
-- Name: servicios_id_servicio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.servicios_id_servicio_seq', 3, true);


--
-- TOC entry 4691 (class 2606 OID 25239)
-- Name: factura pk_factura; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factura
    ADD CONSTRAINT pk_factura PRIMARY KEY (id_factura);


--
-- TOC entry 4693 (class 2606 OID 25248)
-- Name: habitaciones pk_habitaciones; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.habitaciones
    ADD CONSTRAINT pk_habitaciones PRIMARY KEY (id_habitacion);


--
-- TOC entry 4695 (class 2606 OID 25255)
-- Name: pago pk_pago; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pago
    ADD CONSTRAINT pk_pago PRIMARY KEY (id_pago);


--
-- TOC entry 4697 (class 2606 OID 25262)
-- Name: personas pk_personas; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personas
    ADD CONSTRAINT pk_personas PRIMARY KEY (id_persona);


--
-- TOC entry 4699 (class 2606 OID 25269)
-- Name: promocion pk_promocion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion
    ADD CONSTRAINT pk_promocion PRIMARY KEY (id_promocion);


--
-- TOC entry 4701 (class 2606 OID 25276)
-- Name: resenha pk_resenha; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenha
    ADD CONSTRAINT pk_resenha PRIMARY KEY (id_resenha);


--
-- TOC entry 4705 (class 2606 OID 25288)
-- Name: reserva_servicio pk_reserva_servicio; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reserva_servicio
    ADD CONSTRAINT pk_reserva_servicio PRIMARY KEY (id_reserva, id_servicio);


--
-- TOC entry 4703 (class 2606 OID 25283)
-- Name: reservas pk_reservas; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservas
    ADD CONSTRAINT pk_reservas PRIMARY KEY (id_reserva);


--
-- TOC entry 4707 (class 2606 OID 25293)
-- Name: reserva_habitacion pk_reseva_habitacion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reserva_habitacion
    ADD CONSTRAINT pk_reseva_habitacion PRIMARY KEY (id_reserva, id_habitacion);


--
-- TOC entry 4709 (class 2606 OID 25302)
-- Name: servicios pk_servicios; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.servicios
    ADD CONSTRAINT pk_servicios PRIMARY KEY (id_servicio);


--
-- TOC entry 4710 (class 2606 OID 25303)
-- Name: factura fk_factura_reference_reservas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factura
    ADD CONSTRAINT fk_factura_reference_reservas FOREIGN KEY (id_reserva) REFERENCES public.reservas(id_reserva) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4711 (class 2606 OID 25308)
-- Name: pago fk_pago_reference_factura; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pago
    ADD CONSTRAINT fk_pago_reference_factura FOREIGN KEY (id_factura) REFERENCES public.factura(id_factura) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4712 (class 2606 OID 25367)
-- Name: pago fk_pago_reference_reserva; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pago
    ADD CONSTRAINT fk_pago_reference_reserva FOREIGN KEY (id_reserva) REFERENCES public.reservas(id_reserva) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4713 (class 2606 OID 25318)
-- Name: promocion fk_promocio_reference_habitaci; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion
    ADD CONSTRAINT fk_promocio_reference_habitaci FOREIGN KEY (id_habitacion) REFERENCES public.habitaciones(id_habitacion) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4714 (class 2606 OID 25313)
-- Name: promocion fk_promocio_reference_servicio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promocion
    ADD CONSTRAINT fk_promocio_reference_servicio FOREIGN KEY (id_servicio) REFERENCES public.servicios(id_servicio) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4715 (class 2606 OID 25323)
-- Name: resenha fk_resenha_reference_reservas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resenha
    ADD CONSTRAINT fk_resenha_reference_reservas FOREIGN KEY (id_reserva) REFERENCES public.reservas(id_reserva) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4717 (class 2606 OID 25333)
-- Name: reserva_servicio fk_reserva__reference_reservas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reserva_servicio
    ADD CONSTRAINT fk_reserva__reference_reservas FOREIGN KEY (id_reserva) REFERENCES public.reservas(id_reserva) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4718 (class 2606 OID 25338)
-- Name: reserva_servicio fk_reserva__reference_servicio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reserva_servicio
    ADD CONSTRAINT fk_reserva__reference_servicio FOREIGN KEY (id_servicio) REFERENCES public.servicios(id_servicio) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4716 (class 2606 OID 25328)
-- Name: reservas fk_reservas_reference_personas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservas
    ADD CONSTRAINT fk_reservas_reference_personas FOREIGN KEY (id_persona) REFERENCES public.personas(id_persona) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4719 (class 2606 OID 25348)
-- Name: reserva_habitacion fk_reseva_h_reference_habitaci; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reserva_habitacion
    ADD CONSTRAINT fk_reseva_h_reference_habitaci FOREIGN KEY (id_habitacion) REFERENCES public.habitaciones(id_habitacion) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 4720 (class 2606 OID 25343)
-- Name: reserva_habitacion fk_reseva_h_reference_reservas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reserva_habitacion
    ADD CONSTRAINT fk_reseva_h_reference_reservas FOREIGN KEY (id_reserva) REFERENCES public.reservas(id_reserva) ON UPDATE RESTRICT ON DELETE RESTRICT;


-- Completed on 2024-11-24 17:13:09

--
-- PostgreSQL database dump complete
--

