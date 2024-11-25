INSERT INTO public.servicios (id_servicio, nombre, precio, cantidad_limite, estado, descripcion, imagen) VALUES
(3, 'Alojamiento', NULL, NULL, 'A', NULL, NULL),
(1, 'Pasar el dia', 40000, 10, 'A', 'Veni a pasar el dia con nostros', 'assets/img/otros/PRUEBA-PASAR2.jpg'),
(2, 'Camping', 50000, 10, 'A', NULL, 'assets/img/otros/PRUEBA-CAMPING.jpg');

INSERT INTO public.habitaciones (id_habitacion, nombre, capacidad, estado, precio, descripcion, imagen) VALUES
(4, 'habitacion cuadruple', 4, 'A', 390000, NULL, NULL),
(1, 'habitacion matrimonial 1', 2, 'A', 260000, NULL, 'assets/img/habitaciones/habitacion matrimonial 1-disponibilidad.jpg'),
(2, 'habitacion matrimonial 2', 2, 'A', 260000, NULL, 'assets/img/habitaciones/habitacion matrimonial 2-disponibilidad.jpg'),
(3, 'habitacion triple', 3, 'A', 330000, NULL, 'assets/img/habitaciones/habitacion triple-disponibilidad.jpg');

INSERT INTO public.personas (id_persona, nombre, email, apellido, telefono, cedula, contrasenha) VALUES
(1, 'Guillermo', 'guillemvera92@gmail.com', 'Maldonado', '0991375933', '5124867', '1234'),
(2, 'Pepe', 'guille.ps4cod@gmail.com', 'Pepe', '0991375933', '5124867', '$2y$10$9HF9Q1aqb7HH/uq7F7TSSu7SumqFkLLOmqlqUOVzaJTsrBv3KbF8e'),
(3, 'Pepe', 'pepe@gmail.com', 'Pepe', '0991375933', '1111', '$2y$10$usF9Z0RaQtuyhEcM/kwXb.6vY3yifBvA98uX4VIm.hFDyG19prO1O'),
(4, 'hola', 'hola@gmail.com', 'hola', '0991375933', '11', '$2y$10$no8OrI.upR0blRv.CfolnuYRewWqVa17HdDZOFIoTMgQYHizOiA.i');

INSERT INTO public.reservas (id_reserva, id_persona, fecha_reserva, estado) VALUES
(2, NULL, '2024-11-06', 1),
(16, 1, '2024-11-06', 1),
(21, 1, '2024-11-06', 1),
(22, 1, '2024-11-07', 1),
(23, 1, '2024-11-07', 1),
(24, 1, '2024-11-07', 1),
(32, 1, '2024-11-07', 1),
(33, 4, '2024-11-07', 1),
(34, 4, '2024-11-07', 1),
(35, 1, '2024-11-11', 1),
(36, 1, '2024-11-23', 1),
(37, 1, '2024-11-23', 1),
(38, 1, '2024-11-23', 1),
(39, 1, '2024-11-23', 1),
(40, 1, '2024-11-23', 1),
(20, 1, '2024-11-06', 0),
(41, 1, '2024-11-23', 1),
(42, 1, '2024-11-23', 1),
(43, 1, '2024-11-23', 1),
(44, 1, '2024-11-23', 1),
(45, 1, '2024-11-23', 1),
(46, 1, '2024-11-23', 1),
(47, 1, '2024-11-23', 1),
(48, 1, '2024-11-23', 1),
(49, 1, '2024-11-23', 1),
(50, 1, '2024-11-23', 1),
(51, 1, '2024-11-23', 1),
(52, 1, '2024-11-23', 1),
(53, 1, '2024-11-23', 1),
(54, 1, '2024-11-23', 1),
(55, 1, '2024-11-23', 1),
(56, 1, '2024-11-23', 1),
(57, 1, '2024-11-23', 1);

INSERT INTO public.reserva_servicio (id_reserva, id_servicio, cantidad, fecha_inicio, fecha_fin) VALUES
(2, 2, 2, '2024-11-08', '2024-11-09'),
(16, 2, 3, '2024-11-15', '2024-11-16'),
(20, 1, 5, '2024-11-15', '2024-11-15'),
(21, 2, 5, '2024-11-15', '2024-11-16'),
(22, 1, 5, '2024-11-09', '2024-11-09'),
(23, 2, 5, '2024-11-22', '2024-11-23'),
(32, 2, 3, '2024-11-24', '2024-11-25'),
(33, 2, 3, '2024-11-26', '2024-11-28'),
(34, 2, 2, '2024-11-19', '2024-11-20'),
(36, 1, 1, '2024-11-27', NULL),
(37, 1, 1, '2024-11-27', NULL),
(38, 1, 2, '2024-12-31', NULL),
(39, 2, 2, '2024-11-28', '2024-11-29'),
(40, 1, 2, '2024-12-26', NULL),
(41, 1, 2, '2025-01-15', NULL),
(42, 2, 2, '2024-12-10', '2024-12-11'),
(43, 1, 2, '2025-01-26', NULL),
(44, 2, 2, '2025-01-21', '2025-01-22'),
(45, 2, 3, '2025-02-12', '2025-02-14'),
(47, 2, 2, '2024-11-26', '2024-11-28'),
(48, 2, 2, '2024-11-24', '2024-11-25'),
(53, 1, 1, '2024-11-25', NULL),
(54, 2, 2, '2024-11-29', '2024-11-30'),
(55, 2, 1, '2024-11-29', '2024-11-30'),
(56, 1, 1, '2024-12-12', NULL),
(57, 2, 1, '2025-01-08', '2025-01-09');

INSERT INTO public.reserva_habitacion (id_reserva, id_habitacion, fecha_inicio, fecha_fin) VALUES
(24, 1, '2024-11-09', '2024-11-10'),
(35, 1, '2024-11-13', '2024-11-15'),
(46, 1, '2024-11-28', '2024-11-29'),
(49, 2, '2024-11-27', '2024-11-28'),
(50, 3, '2024-11-26', '2024-11-27'),
(51, 4, '2024-11-25', '2024-11-26'),
(52, 4, '2024-11-27', '2024-11-28');

INSERT INTO public.resenha (id_resenha, id_reserva, titulo, calificacion, descripcion, estado) VALUES
(1, 53, 'Good', 4, 'goood', 1),
(2, 52, 'Hasoo', 3, 'Muy haso', 1),
(3, 57, 'OIKO', 5, 'Muy oiko', 1);

INSERT INTO public.pago (id_pago, id_factura, forma_pago, fecha, monto_pagado, paypal_order_id, estado_pago, id_reserva) VALUES
(1, NULL, 1, '2024-11-23', 100000, '692279188Y035543E', 'COMPLETADO', 39),
(2, NULL, 1, '2024-11-23', 80000, '77467931DU5513615', 'COMPLETADO', 40),
(3, NULL, 1, '2024-11-23', 80000, '0PG69441T99198910', 'COMPLETADO', 41),
(4, NULL, 1, '2024-11-23', 100000, '90X2275650563971F', 'COMPLETADO', 42),
(5, NULL, 1, '2024-11-23', 80000, '43416084DP478251V', 'COMPLETADO', 43),
(6, NULL, 1, '2024-11-23', 100000, '6GK386466L888072B', 'COMPLETADO', 44),
(7, NULL, 1, '2024-11-23', 300000, '29192018132203035', 'COMPLETADO', 45),
(8, NULL, 1, '2024-11-23', 260000, '1NT21770R2700900H', 'COMPLETADO', 46),
(9, NULL, 1, '2024-11-23', 200000, '1KK56033BB572691F', 'COMPLETADO', 47),
(10, NULL, 1, '2024-11-23', 100000, '2E932427GD893680L', 'COMPLETADO', 48),
(11, NULL, 1, '2024-11-23', 260000, '87S4282315773030J', 'COMPLETADO', 49),
(12, NULL, 1, '2024-11-23', 330000, '28W41374TL304212A', 'COMPLETADO', 50),
(13, NULL, 1, '2024-11-23', 390000, '4V243591RM741160J', 'COMPLETADO', 51),
(14, NULL, 1, '2024-11-23', 390000, '5UB61855LU7069026', 'COMPLETADO', 52),
(15, NULL, 1, '2024-11-23', 40000, '2C0468333L3828056', 'COMPLETADO', 53),
(16, NULL, 1, '2024-11-23', 100000, '3RS587738T8642452', 'COMPLETADO', 54),
(17, NULL, 1, '2024-11-23', 50000, '70R1220824415632M', 'COMPLETADO', 55),
(18, NULL, 1, '2024-11-23', 40000, '1CT49956YK315431P', 'COMPLETADO', 56),
(19, NULL, 1, '2024-11-23', 50000, '6YK03271E1615173U', 'COMPLETADO', 57);