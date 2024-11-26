-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 05:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_proyecto`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL,
  `categoria_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`) VALUES
(1, 'Frutas'),
(2, 'Verduras'),
(3, 'Lácteos'),
(4, 'Carnes'),
(5, 'Pescados y Mariscos'),
(6, 'Granos y Cereales'),
(7, 'Bebidas'),
(8, 'Panadería y Pastelería'),
(9, 'Snacks y Botanas'),
(10, 'Condimentos y Especias'),
(11, 'Aceites y Grasas'),
(12, 'Dulces y Postres'),
(13, 'Salsas y Aderezos'),
(14, 'Legumbres'),
(15, 'Frutos Secos'),
(16, 'Congelados'),
(17, 'Conservas'),
(18, 'Huevos'),
(19, 'Harinas y Féculas'),
(20, 'Bebidas Alcohólicas');

-- --------------------------------------------------------

--
-- Table structure for table `elemento`
--

CREATE TABLE `elemento` (
  `elemento_id` int(11) NOT NULL,
  `elemento_nombre` varchar(100) NOT NULL,
  `elemento_descripcion` text DEFAULT NULL,
  `elemento_cantidad` int(11) DEFAULT NULL,
  `elemento_unidad` varchar(20) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `elemento_foto` varchar(535) DEFAULT NULL,
  `elemento_creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `elemento_actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elemento`
--

INSERT INTO `elemento` (`elemento_id`, `elemento_nombre`, `elemento_descripcion`, `elemento_cantidad`, `elemento_unidad`, `categoria_id`, `elemento_foto`, `elemento_creado`, `elemento_actualizado`) VALUES
(20, 'Banano', 'gdfgsdfvgdfg', 45, 'unidades', 1, 'Banano_98.png', '2024-10-04 15:41:26', '2024-10-04 15:41:26'),
(21, 'Manzana', 'dsfgdfgsdfgsdg', 7, 'unidades', 1, '', '2024-10-04 15:41:26', '2024-10-04 15:41:26'),
(22, 'papa', 'safdsafdsadsf', 4, 'kilogramos', 2, '', '2024-10-04 15:41:26', '2024-10-04 15:41:26'),
(23, 'Habichuela', 'sadfvcdagvsdfgadfvdsf', 1, 'libras', 14, '', '2024-10-04 15:41:26', '2024-10-04 15:41:26'),
(24, 'Frijol', 'dsfdsafacsxfvdaed', 2, 'libras', 6, 'Frijol_40.jpg', '2024-10-04 15:41:26', '2024-10-04 15:41:26'),
(25, 'Atun', 'gdsdfgsftg', 5, 'unidades', 17, '', '2024-10-04 15:42:55', '2024-10-04 17:00:16'),
(26, 'pera', 'fdgdfsgvsdfgvsd', 4, 'unidades', 1, '', '2024-10-04 17:09:19', '2024-10-04 17:09:19'),
(27, 'Pollo', 'dsfcsajdhcnlskxncoiSN CXJKñsnoicx', 7, 'kilogramos', 4, '', '2024-10-04 17:47:35', '2024-10-04 17:48:01'),
(28, 'Zapotes', 'dsfmsdlñafo´dskfas', 20, 'libras', 1, '', '2024-11-13 01:46:35', '2024-11-13 01:46:35'),
(29, 'Arroz', 'Arroz blanco', 10, 'kg', 1, '', '2024-11-22 00:42:56', '2024-11-22 00:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(70) NOT NULL,
  `usuario_apellido` varchar(70) NOT NULL,
  `usuario_email` varchar(100) NOT NULL,
  `usuario_usuario` varchar(30) NOT NULL,
  `usuario_clave` varchar(200) NOT NULL,
  `usuario_foto` varchar(535) NOT NULL,
  `usuario_creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_actualizado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_creado`, `usuario_actualizado`) VALUES
(1, 'Administrador', 'Principal', 'admin@admin.com', 'Administrador', '$2y$10$F0J8k.lFjgGAK6I/tcbhyuMKSaitXy8ENMSBVZWErIoA6.VSU8MQy', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Leonardo', 'Caicedo', 'leo1@hotmail.com', 'leo1', '$2y$10$j96ZFSbdciYBsrQtXGHDDOCK8.yDBjkgBFYp/ZIWVxf/cM/TXfwFe', 'Leonardo_59.png', '2024-09-18 12:11:55', '2024-09-18 12:11:55'),
(12, 'Leonardo', 'Caicedo', 'leo2@hotmail.com', 'leo2', '$2y$10$HMBlHRylzbirCOm0JxvG5Oe76/vgxeo86HEkCN3PB7WYUpjBS3.CK', '', '2024-10-04 15:28:02', '2024-11-22 09:30:58'),
(14, 'Leonardo', 'Caicedo', 'leo3@hotmail.com', 'leo3', '$2y$10$PbhxfndmuwY6OuXanQ4lcOgJR19/DE7jOAMMSjuvVveHJbgh2ApQe', '', '2024-10-04 17:45:54', '2024-10-04 17:45:54'),
(15, 'Leonardo', 'Caicedo', 'Kaicedo413@gmail.com', 'Kaicedo413', '$2y$10$xHjVOd9aJrWHmtF37YHr6.UEgdm9PBNDVdOV23BoeoN0w4i0o7n9q', '', '2024-11-11 00:41:01', '2024-11-11 00:41:01'),
(16, 'Juan', 'Pérez', 'email_existente@example.com', 'juanperez', '$2y$10$o4nnwN.PayLC1.c7jwNzQu7Gwq2GbY1dNdkdenDFuhpwcRnhDRt/O', '', '2024-11-20 08:44:38', '2024-11-20 08:44:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indexes for table `elemento`
--
ALTER TABLE `elemento`
  ADD PRIMARY KEY (`elemento_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `elemento`
--
ALTER TABLE `elemento`
  MODIFY `elemento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
