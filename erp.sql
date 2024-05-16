-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-12-2023 a las 20:08:36
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `erp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_articulo` int(11) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `descripcion_articulo` varchar(80) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `estado_articulo` int(11) NOT NULL,
  `id_empresa_articulo` int(11) NOT NULL,
  `id_usuario_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `nombre_articulo`, `descripcion_articulo`, `cantidad`, `precio_venta`, `estado_articulo`, `id_empresa_articulo`, `id_usuario_articulo`) VALUES
(33, 'coca cola', 'botella extranjera', 21, 12, 1, 167, 1),
(34, 'fanta', 'botella extranjera', 15, 11, 1, 167, 1),
(35, 'lata paceña', 'botella nacional', 0, 6, 1, 167, 1),
(39, 'televisor samsung 46 plg', '', 6, 2500, 1, 168, 1),
(42, 'mouse', '', 10, 80, 1, 168, 1),
(43, 'teclado', '', 0, 150, 1, 168, 1),
(44, 'galleta oreo', '', 10, 15, 1, 170, 1),
(45, 'galleta mabel', '', 0, 15, 1, 170, 1),
(47, 'galleta serranita', '', 0, 15, 1, 170, 1),
(49, 'Iphone X', 'Celular', 25, 1000, 1, 169, 1),
(50, 'Iphone 5', '', 0, 500, 1, 169, 1),
(51, 'Cargador Inalambrico Iphone', '', 95, 35, 1, 169, 1),
(52, 'coca cola', 'bebida extranjera', 5, 15, 1, 172, 1),
(53, 'Pinza metalica', 'pinza nacional', 30, 100, 1, 173, 1),
(54, 'sprite', '', 0, 15, 1, 173, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_categorias`
--

CREATE TABLE `articulo_categorias` (
  `id_ca` int(11) NOT NULL,
  `id_articulo_ca` int(11) NOT NULL,
  `id_categoria_ca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articulo_categorias`
--

INSERT INTO `articulo_categorias` (`id_ca`, `id_articulo_ca`, `id_categoria_ca`) VALUES
(77, 33, 66),
(78, 33, 67),
(79, 33, 68),
(89, 34, 66),
(90, 34, 67),
(91, 34, 69),
(85, 35, 66),
(86, 35, 70),
(98, 39, 82),
(99, 39, 83),
(104, 42, 79),
(105, 42, 81),
(106, 43, 79),
(107, 43, 81),
(108, 44, 84),
(109, 44, 85),
(110, 45, 84),
(111, 45, 86),
(113, 47, 87),
(115, 49, 90),
(116, 50, 90),
(117, 51, 92),
(118, 52, 93),
(119, 52, 94),
(120, 53, 96),
(121, 53, 97),
(124, 54, 98);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL,
  `descripcion_categoria` varchar(50) NOT NULL,
  `id_empresa_categoria` int(11) NOT NULL,
  `id_usuario_categoria` int(11) NOT NULL,
  `id_categoria_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion_categoria`, `id_empresa_categoria`, `id_usuario_categoria`, `id_categoria_padre`) VALUES
(66, 'bebidas', '', 167, 1, NULL),
(67, 'Gaseosas', '', 167, 1, 66),
(68, 'coca cola', '', 167, 1, 67),
(69, 'fanta', '', 167, 1, 67),
(70, 'alcochol', '', 167, 1, 66),
(71, 'cerveza paceña', '', 167, 1, 70),
(72, 'cerveza conti', '', 167, 1, 70),
(73, 'Electrodomesticos', '', 167, 1, NULL),
(74, 'Televisores', '', 167, 1, 73),
(75, 'Aire acondicionado', '', 167, 1, 73),
(76, 'tv samsung', '', 167, 1, 74),
(77, 'aire acondicionado LG', '', 167, 1, 75),
(79, 'Perifericos ', '', 168, 1, NULL),
(80, 'mouse', '', 168, 1, 79),
(81, 'teclado', '', 168, 1, 79),
(82, 'Electrodomesticos', '', 168, 1, NULL),
(83, 'Televisores', '', 168, 1, 82),
(84, 'Galletas', '', 170, 1, NULL),
(85, 'oreo', '', 170, 1, 84),
(86, 'mabel', '', 170, 1, 84),
(87, 'serranitas', '', 170, 1, 84),
(90, 'Unica', '', 169, 1, NULL),
(91, 'Unica 2', '', 169, 1, NULL),
(92, 'Hija', '', 169, 1, 90),
(93, 'gaseosas', '', 172, 1, NULL),
(94, 'sodas', '', 172, 1, 93),
(95, 'alcohol', '', 172, 1, 93),
(96, 'Utensilios', '', 173, 1, NULL),
(97, 'pinzas', '', 173, 1, 96),
(98, 'sodas', 'gaseosas', 173, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id_comprobante` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `glosa_principal` varchar(50) NOT NULL,
  `fecha_comprobante` date NOT NULL,
  `tc` float NOT NULL,
  `estado` int(11) NOT NULL,
  `tipo_comprobante` varchar(50) NOT NULL,
  `id_empresa_comprobante` int(11) NOT NULL,
  `id_usuario_comprobante` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id_comprobante`, `serie`, `glosa_principal`, `fecha_comprobante`, `tc`, `estado`, `tipo_comprobante`, `id_empresa_comprobante`, `id_usuario_comprobante`, `id_moneda`) VALUES
(95, 1, 'Compra de mercaderias', '2023-01-01', 2.55, 1, 'Egreso', 168, 1, 1),
(96, 2, 'Compra de mercaderias', '2023-01-01', 2.55, 1, 'Egreso', 168, 1, 1),
(97, 3, 'Venta de mercaderias', '2023-01-01', 2.55, 1, 'Ingreso', 168, 1, 1),
(98, 4, 'Venta de mercaderias', '2023-01-01', 2.55, 1, 'Ingreso', 168, 1, 1),
(99, 1, 'glosa principal', '2024-01-01', 6.95, 1, 'Apertura', 170, 1, 1),
(100, 2, 'glosa principal anular', '2024-01-02', 6.95, 0, 'Traspaso', 170, 1, 1),
(101, 3, 'Venta de mercaderias', '2024-01-02', 6.95, 1, 'Ingreso', 170, 1, 1),
(102, 4, 'Venta de mercaderias', '2024-01-02', 6.95, 1, 'Ingreso', 170, 1, 1),
(103, 1, 'Apertura de Sociedad', '2023-01-01', 6.95, 1, 'Apertura', 169, 1, 1),
(104, 2, 'Por Compra de Mercaderia, se paga con cheque y let', '2023-01-02', 6.95, 1, 'Ingreso', 169, 1, 1),
(105, 3, 'Por Pago de Debito Fiscar e IT por pagar con chequ', '2023-01-03', 6.95, 1, 'Ingreso', 169, 1, 1),
(106, 4, 'Por venta de mercaderi ', '2023-01-04', 6.95, 1, 'Ingreso', 169, 1, 1),
(107, 5, 'Por compra de Material de escritorio', '2023-01-05', 6.95, 1, 'Egreso', 169, 1, 1),
(108, 6, 'Por cancelacion de Deuda', '2023-01-06', 6.95, 1, 'Ajuste', 169, 1, 1),
(109, 7, 'Por cancelacion de cuentas por cobrar', '2023-01-07', 6.95, 1, 'Ajuste', 169, 1, 1),
(110, 1, 'Por Apertura de Empresa', '2023-01-20', 6.97, 1, 'Apertura', 171, 1, 1),
(111, 8, 'Pago de sueldos', '2023-02-20', 6.95, 1, 'Egreso', 169, 1, 1),
(112, 9, 'Compra de mercaderias', '2023-02-20', 6.95, 1, 'Egreso', 169, 1, 1),
(113, 10, 'Compra de mercaderias', '2023-02-20', 6.95, 0, 'Egreso', 169, 1, 1),
(114, 11, 'Venta de mercaderias', '2023-02-22', 6.95, 1, 'Ingreso', 169, 1, 1),
(115, 12, 'Venta de mercaderias', '2023-02-20', 6.95, 1, 'Ingreso', 169, 1, 1),
(116, 5, 'Venta de mercaderias', '2024-01-01', 6.95, 1, 'Ingreso', 170, 1, 1),
(117, 6, 'Venta de mercaderias', '2024-01-01', 6.95, 0, 'Ingreso', 170, 1, 1),
(118, 1, 'aperturando la empresa', '2024-01-01', 6.95, 1, 'Apertura', 172, 1, 1),
(119, 1, 'Apertura de empresa', '2023-01-01', 7.5, 0, 'Apertura', 173, 1, 1),
(120, 2, 'Compra de mercaderias', '2023-01-01', 7.5, 1, 'Egreso', 173, 1, 1),
(121, 3, 'Venta de mercaderias', '2023-01-01', 7.5, 0, 'Ingreso', 173, 1, 1),
(122, 2, 'glosa de prueba', '2022-01-01', 6.97, 0, 'Apertura', 171, 1, 1),
(123, 4, 'Compra de mercaderias', '2023-01-01', 7.5, 1, 'Egreso', 173, 1, 1),
(124, 5, 'Compra de mercaderias', '2023-01-01', 7.5, 1, 'Egreso', 173, 1, 1),
(125, 6, 'Venta de mercaderias', '2023-01-01', 7.5, 1, 'Ingreso', 173, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id_cuenta` int(11) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `nombre_cuenta` varchar(100) NOT NULL,
  `tipo_cuenta` varchar(50) NOT NULL,
  `nivel` int(11) NOT NULL,
  `id_usuario_cuenta` int(11) NOT NULL,
  `id_empresa_cuenta` int(11) NOT NULL,
  `id_cuenta_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id_cuenta`, `codigo`, `nombre_cuenta`, `tipo_cuenta`, `nivel`, `id_usuario_cuenta`, `id_empresa_cuenta`, `id_cuenta_padre`) VALUES
(615, '1.0.0', 'Activo', 'Global', 1, 1, 167, NULL),
(616, '2.0.0', 'Pasivo', 'Global', 1, 1, 167, NULL),
(617, '3.0.0', 'Patrimonio', 'Global', 1, 1, 167, NULL),
(618, '4.0.0', 'Ingresos', 'Global', 1, 1, 167, NULL),
(619, '5.0.0', 'Egresos', 'Global', 1, 1, 167, NULL),
(620, '5.1.0', 'Costos', 'Global', 2, 1, 167, 619),
(621, '5.2.0', 'Gastos', 'Global', 2, 1, 167, 619),
(622, '1.1.0', 'Activo corriente', 'Global', 2, 1, 167, 615),
(623, '1.2.0', 'Activo no corriente', 'Global', 2, 1, 167, 615),
(624, '1.1.1', 'Caja M/N', 'Detalle', 3, 1, 167, 622),
(625, '1.1.2', 'Banco M/E', 'Detalle', 3, 1, 167, 622),
(626, '1.1.3', 'Cuentas por cobrar', 'Detalle', 3, 1, 167, 622),
(627, '1.1.4', 'Credito fiscal', 'Detalle', 3, 1, 167, 622),
(628, '1.2.1', 'Equipo de computacion', 'Detalle', 3, 1, 167, 623),
(629, '1.2.2', 'Material de escritorio', 'Detalle', 3, 1, 167, 623),
(630, '2.1.0', 'Pasivo corriente', 'Global', 2, 1, 167, 616),
(631, '2.1.1', 'Debito Fiscal', 'Detalle', 3, 1, 167, 630),
(632, '2.1.2', 'Documentos por pagar', 'Detalle', 3, 1, 167, 630),
(633, '2.1.3', 'IT por pagar', 'Detalle', 3, 1, 167, 630),
(634, '2.1.4', 'Cuentas por pagar', 'Detalle', 3, 1, 167, 630),
(635, '3.1.0', 'Capital Social', 'Global', 2, 1, 167, 617),
(636, '4.1.0', 'Ventas', 'Global', 2, 1, 167, 618),
(637, '5.1.1', 'IT', 'Detalle', 3, 1, 167, 620),
(638, '5.1.2', 'Compras', 'Detalle', 3, 1, 167, 620),
(639, '5.2.1', 'Sueldos', 'Detalle', 3, 1, 167, 621),
(640, '4.1.1', 'ventas de mercaderia', 'Detalle', 3, 1, 167, 636),
(641, '5.2.2', 'gastos de ventas', 'Detalle', 3, 1, 167, 621),
(642, '1.0.0', 'Activo', 'Global', 1, 1, 168, NULL),
(643, '2.0.0', 'Pasivo', 'Global', 1, 1, 168, NULL),
(644, '3.0.0', 'Patrimonio', 'Global', 1, 1, 168, NULL),
(645, '4.0.0', 'Ingresos', 'Global', 1, 1, 168, NULL),
(646, '5.0.0', 'Egresos', 'Global', 1, 1, 168, NULL),
(647, '5.1.0', 'Costos', 'Global', 2, 1, 168, 646),
(648, '5.2.0', 'Gastos', 'Global', 2, 1, 168, 646),
(649, '1.1.0', 'Activo corriente', 'Global', 2, 1, 168, 642),
(650, '1.2.0', 'Activo no corriente', 'Global', 2, 1, 168, 642),
(651, '1.1.1', 'Caja M/N', 'Detalle', 3, 1, 168, 649),
(652, '1.1.2', 'Banco M/E', 'Detalle', 3, 1, 168, 649),
(653, '1.0.0', 'Activo', 'Global', 1, 1, 169, NULL),
(654, '2.0.0', 'Pasivo', 'Global', 1, 1, 169, NULL),
(655, '3.0.0', 'Patrimonio', 'Global', 1, 1, 169, NULL),
(656, '4.0.0', 'Ingresos', 'Global', 1, 1, 169, NULL),
(657, '5.0.0', 'Egresos', 'Global', 1, 1, 169, NULL),
(658, '5.1.0', 'Costos', 'Global', 2, 1, 169, 657),
(659, '5.2.0', 'Gastos', 'Global', 2, 1, 169, 657),
(660, '1.1.0', 'Activo Corriente', 'Global', 2, 1, 169, 653),
(661, '1.2.0', 'Activo no corriente', 'Global', 2, 1, 169, 653),
(662, '1.1.1', 'Caja M/N', 'Detalle', 3, 1, 169, 660),
(663, '1.1.2', 'Banco M/N', 'Detalle', 3, 1, 169, 660),
(664, '1.2.1', 'Equipo de computacion', 'Detalle', 3, 1, 169, 661),
(665, '1.2.2', 'Material de escritorio', 'Detalle', 3, 1, 169, 661),
(666, '2.1.0', 'Pasivo corriente', 'Global', 2, 1, 169, 654),
(667, '2.1.1', 'Debito Fiscal', 'Detalle', 3, 1, 169, 666),
(668, '2.1.2', 'Documentos por pagar', 'Detalle', 3, 1, 169, 666),
(669, '2.1.3', 'IT por pagar', 'Detalle', 3, 1, 169, 666),
(670, '2.1.4', 'Cuentas por pagar', 'Detalle', 3, 1, 169, 666),
(671, '3.1.0', 'Patrimonio Capital', 'Global', 2, 1, 169, 655),
(672, '3.1.1', 'Patrimonio Capital Social', 'Detalle', 3, 1, 169, 671),
(673, '4.1.0', 'Ingresos M/N', 'Global', 2, 1, 169, 656),
(674, '4.1.1', 'Ventas', 'Detalle', 3, 1, 169, 673),
(675, '5.1.1', 'IT', 'Detalle', 3, 1, 169, 658),
(676, '5.2.1', 'Sueldos', 'Detalle', 3, 1, 169, 659),
(677, '1.2.1', 'Equipo de computacion', 'Detalle', 3, 1, 168, 650),
(678, '1.2.2', 'Material de escritorio', 'Detalle', 3, 1, 168, 650),
(679, '2.1.0', 'Pasivo corriente', 'Global', 2, 1, 168, 643),
(680, '2.1.1', 'Debito Fiscal', 'Detalle', 3, 1, 168, 679),
(681, '2.1.2', 'Documentos por pagar', 'Detalle', 3, 1, 168, 679),
(682, '2.1.3', 'IT por pagar', 'Detalle', 3, 1, 168, 679),
(683, '2.1.4', 'Cuentas por pagar', 'Detalle', 3, 1, 168, 679),
(684, '3.1.0', 'Patrimonio x2', 'Global', 2, 1, 168, 644),
(685, '3.1.1', 'Capital Social', 'Detalle', 3, 1, 168, 684),
(686, '4.1.0', 'Ingresos x2', 'Global', 2, 1, 168, 645),
(687, '5.1.1', 'IT', 'Detalle', 3, 1, 168, 647),
(688, '5.1.2', 'Compras', 'Detalle', 3, 1, 168, 647),
(689, '5.2.1', 'Sueldos', 'Detalle', 3, 1, 168, 648),
(690, '2.1.5', 'Credito fiscal', 'Detalle', 3, 1, 168, 679),
(691, '4.1.1', 'Ventas', 'Detalle', 3, 1, 168, 686),
(692, '1.0.0', 'Activo', 'Global', 1, 1, 170, NULL),
(693, '2.0.0', 'Pasivo', 'Global', 1, 1, 170, NULL),
(694, '3.0.0', 'Patrimonio', 'Global', 1, 1, 170, NULL),
(695, '4.0.0', 'Ingresos', 'Global', 1, 1, 170, NULL),
(696, '5.0.0', 'Egresos', 'Global', 1, 1, 170, NULL),
(697, '5.1.0', 'Costos', 'Global', 2, 1, 170, 696),
(698, '5.2.0', 'Gastos', 'Global', 2, 1, 170, 696),
(699, '5.1.1', 'CajaMN', 'Detalle', 3, 1, 170, 697),
(700, '5.1.2', 'Credito fiscal', 'Detalle', 3, 1, 170, 697),
(701, '5.1.3', 'Debito Fiscal', 'Detalle', 3, 1, 170, 697),
(702, '5.1.4', 'It', 'Detalle', 3, 1, 170, 697),
(703, '5.1.5', 'IT por pagar', 'Detalle', 3, 1, 170, 697),
(704, '5.1.6', 'Ventas', 'Detalle', 3, 1, 170, 697),
(705, '5.1.7', 'Compras', 'Detalle', 3, 1, 170, 697),
(706, '1.1.3', 'Cuentas por cobrar', 'Detalle', 3, 1, 169, 660),
(707, '1.1.4', 'Credito fiscal', 'Detalle', 3, 1, 169, 660),
(708, '5.1.2', 'Compras', 'Detalle', 3, 1, 169, 658),
(709, '1.0.0.0', 'Activo', 'Global', 1, 1, 171, NULL),
(710, '2.0.0.0', 'Pasivo', 'Global', 1, 1, 171, NULL),
(711, '3.0.0.0', 'Patrimonio', 'Global', 1, 1, 171, NULL),
(712, '4.0.0.0', 'Ingresos', 'Global', 1, 1, 171, NULL),
(713, '5.0.0.0', 'Egresos', 'Global', 1, 1, 171, NULL),
(714, '5.1.0.0', 'Costos', 'Global', 2, 1, 171, 713),
(715, '5.2.0.0', 'Gastos', 'Global', 2, 1, 171, 713),
(716, '1.1.0.0', 'Act X', 'Global', 2, 1, 171, 709),
(717, '1.1.1.0', 'Activo Corriente 2', 'Global', 3, 1, 171, 716),
(718, '1.1.2.0', 'Activo no Corriente', 'Global', 3, 1, 171, 716),
(719, '1.1.1.1', 'Caja', 'Detalle', 4, 1, 171, 717),
(720, '1.1.1.2', 'Banco MN', 'Detalle', 4, 1, 171, 717),
(721, '1.1.1.3', 'Credito Fiscal', 'Detalle', 4, 1, 171, 717),
(722, '1.1.2.1', 'Vehiculos', 'Detalle', 4, 1, 171, 718),
(723, '1.1.2.2', 'Material de escritorio', 'Detalle', 4, 1, 171, 718),
(724, '1.1.2.3', 'Eq. de computacion', 'Detalle', 4, 1, 171, 718),
(725, '2.1.0.0', 'Pas X', 'Global', 2, 1, 171, 710),
(726, '2.1.1.0', 'Pasivo corriente', 'Global', 3, 1, 171, 725),
(727, '2.1.1.1', 'Debito Fiscal', 'Detalle', 4, 1, 171, 726),
(728, '2.1.1.2', 'Cuentas x Pagar', 'Detalle', 4, 1, 171, 726),
(729, '2.1.1.3', 'IT x pagar', 'Detalle', 4, 1, 171, 726),
(730, '3.1.0.0', 'Pat X', 'Global', 2, 1, 171, 711),
(731, '3.1.1.0', 'Patrimonio y capital', 'Global', 3, 1, 171, 730),
(732, '3.1.1.1', 'Capital Social', 'Detalle', 4, 1, 171, 731),
(733, '4.1.0.0', 'Ing X', 'Global', 2, 1, 171, 712),
(734, '4.1.1.0', 'INgresos Netos', 'Global', 3, 1, 171, 733),
(735, '4.1.1.1', 'Ventas', 'Detalle', 4, 1, 171, 734),
(736, '5.1.1.0', 'Costos Varios', 'Global', 3, 1, 171, 714),
(737, '5.1.1.1', 'Compras', 'Detalle', 4, 1, 171, 736),
(739, '1.0.0', 'Activo', 'Global', 1, 1, 172, NULL),
(740, '2.0.0', 'Pasivo', 'Global', 1, 1, 172, NULL),
(741, '3.0.0', 'Patrimonio', 'Global', 1, 1, 172, NULL),
(742, '4.0.0', 'Ingresos', 'Global', 1, 1, 172, NULL),
(743, '5.0.0', 'Egresos', 'Global', 1, 1, 172, NULL),
(744, '5.1.0', 'Costos', 'Global', 2, 1, 172, 743),
(745, '5.2.0', 'Gastos', 'Global', 2, 1, 172, 743),
(747, '1.1.0', 'Activo corriente', 'Global', 2, 1, 172, 739),
(748, '1.1.1', 'Caja MN', 'Detalle', 3, 1, 172, 747),
(749, '2.1.0', 'Pasivo corriente', 'Global', 2, 1, 172, 740),
(750, '2.1.1', 'Edificio', 'Detalle', 3, 1, 172, 749),
(754, '1.1.2', 'Credito fiscal', 'Detalle', 3, 1, 172, 747),
(755, '1.1.3', 'Debito fiscal', 'Detalle', 3, 1, 172, 747),
(756, '4.1.0', 'ingresos x2', 'Global', 2, 1, 172, 742),
(757, '4.1.1', 'compras', 'Detalle', 3, 1, 172, 756),
(758, '5.1.1', 'ventas', 'Detalle', 3, 1, 172, 744),
(759, '5.2.1', 'IT', 'Detalle', 3, 1, 172, 745),
(760, '5.1.2', 'IT por pagar', 'Detalle', 3, 1, 172, 744),
(761, '1.0.0', 'Activo', 'Global', 1, 1, 173, NULL),
(762, '2.0.0', 'Pasivo', 'Global', 1, 1, 173, NULL),
(763, '3.0.0', 'Patrimonio', 'Global', 1, 1, 173, NULL),
(764, '4.0.0', 'Ingresos', 'Global', 1, 1, 173, NULL),
(765, '5.0.0', 'Egresos', 'Global', 1, 1, 173, NULL),
(766, '5.1.0', 'Costos', 'Global', 2, 1, 173, 765),
(767, '5.2.0', 'Gastos', 'Global', 2, 1, 173, 765),
(768, '1.1.0', 'Activo corriente', 'Global', 2, 1, 173, 761),
(769, '1.1.1', 'Caja M/N', 'Detalle', 3, 1, 173, 768),
(770, '1.1.2', 'Compra', 'Detalle', 3, 1, 173, 768),
(771, '1.1.3', 'Venta', 'Detalle', 3, 1, 173, 768),
(772, '1.1.4', 'IT', 'Detalle', 3, 1, 173, 768),
(773, '1.1.5', 'IT por pagar', 'Detalle', 3, 1, 173, 768),
(774, '1.1.6', 'Credito fiscal', 'Detalle', 3, 1, 173, 768),
(775, '1.1.7', 'Debito Fiscal', 'Detalle', 3, 1, 173, 768),
(776, '1.1.1.4', 'prueba', 'Detalle', 4, 1, 171, 717),
(777, '1.1.8', 'prueba', 'Detalle', 3, 1, 173, 768),
(778, '1.0.0', 'Activo', 'Global', 1, 1, 174, NULL),
(779, '2.0.0', 'Pasivo', 'Global', 1, 1, 174, NULL),
(780, '3.0.0', 'Patrimonio', 'Global', 1, 1, 174, NULL),
(781, '4.0.0', 'Ingresos', 'Global', 1, 1, 174, NULL),
(782, '5.0.0', 'Egresos', 'Global', 1, 1, 174, NULL),
(783, '5.1.0', 'Costos', 'Global', 2, 1, 174, 782),
(784, '5.2.0', 'Gastos', 'Global', 2, 1, 174, 782),
(785, '3.1.0', 'prueba 1', 'Global', 2, 1, 174, 780),
(787, '1.1.0', 'mira miguel', 'Global', 2, 1, 174, 778);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles`
--

CREATE TABLE `detalles` (
  `id_detalle` int(11) NOT NULL,
  `id_articulo_detalle` int(11) NOT NULL,
  `id_lote_detalle` int(11) NOT NULL,
  `id_nota_detalle` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalles`
--

INSERT INTO `detalles` (`id_detalle`, `id_articulo_detalle`, `id_lote_detalle`, `id_nota_detalle`, `cantidad`, `precio_venta`) VALUES
(48, 39, 137, 133, 2, 2500),
(49, 39, 138, 134, 2, 2500),
(50, 39, 137, 137, 2, 2500),
(51, 42, 140, 137, 1, 80),
(52, 39, 138, 138, 3, 2500),
(53, 42, 140, 138, 4, 80),
(54, 44, 142, 141, 10, 15),
(55, 44, 144, 144, 20, 15),
(56, 45, 143, 144, 15, 15),
(57, 45, 145, 145, 15, 15),
(58, 44, 142, 146, 5, 15),
(59, 45, 145, 146, 5, 15),
(60, 49, 146, 149, 5, 1000),
(61, 51, 147, 149, 5, 35),
(62, 49, 146, 150, 10, 1000),
(63, 51, 147, 150, 10, 35),
(64, 44, 142, 151, 5, 15),
(65, 45, 143, 151, 5, 15),
(66, 44, 142, 152, 5, 15),
(67, 52, 150, 154, 10, 15),
(68, 53, 151, 156, 10, 100),
(69, 53, 152, 158, 5, 100),
(70, 54, 154, 161, 5, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_comprobantes`
--

CREATE TABLE `detalle_comprobantes` (
  `id_detalle_comprobante` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `glosa_secundaria` varchar(50) NOT NULL,
  `monto_debe` int(11) NOT NULL,
  `monto_haber` int(11) NOT NULL,
  `monto_debe_alt` int(11) NOT NULL,
  `monto_haber_alt` int(11) NOT NULL,
  `id_usuario_comprobante` int(11) NOT NULL,
  `id_comprobante` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_comprobantes`
--

INSERT INTO `detalle_comprobantes` (`id_detalle_comprobante`, `numero`, `glosa_secundaria`, `monto_debe`, `monto_haber`, `monto_debe_alt`, `monto_haber_alt`, `id_usuario_comprobante`, `id_comprobante`, `id_cuenta`) VALUES
(246, 1, 'Compra de mercaderias', 390, 0, 0, 0, 1, 95, 690),
(247, 2, 'Compra de mercaderias', 2610, 0, 0, 0, 1, 95, 688),
(248, 3, 'Compra de mercaderias', 0, 3000, 0, 0, 1, 95, 651),
(249, 1, 'Compra de mercaderias', 156, 0, 0, 0, 1, 96, 690),
(250, 2, 'Compra de mercaderias', 1044, 0, 0, 0, 1, 96, 688),
(251, 3, 'Compra de mercaderias', 0, 1200, 0, 0, 1, 96, 651),
(252, 1, 'Venta de mercaderias', 1800, 0, 0, 0, 1, 97, 651),
(253, 2, 'Venta de mercaderias', 540, 0, 0, 0, 1, 97, 687),
(254, 3, 'Venta de mercaderias', 0, 234, 0, 0, 1, 97, 680),
(255, 3, 'Venta de mercaderias', 0, 1566, 0, 0, 1, 97, 691),
(256, 3, 'Venta de mercaderias', 0, 540, 0, 0, 1, 97, 682),
(257, 1, 'Venta de mercaderias', 1200, 0, 0, 0, 1, 98, 651),
(258, 2, 'Venta de mercaderias', 360, 0, 0, 0, 1, 98, 687),
(259, 3, 'Venta de mercaderias', 0, 156, 0, 0, 1, 98, 680),
(260, 3, 'Venta de mercaderias', 0, 1044, 0, 0, 1, 98, 691),
(261, 3, 'Venta de mercaderias', 0, 360, 0, 0, 1, 98, 682),
(262, 1, 'glosa principal', 50, 0, 7, 0, 1, 99, 700),
(263, 2, 'glosa principal', 0, 50, 0, 7, 1, 99, 701),
(264, 1, 'glosa principal anular', 500, 0, 72, 0, 1, 100, 700),
(265, 2, 'glosa principal anular', 0, 500, 0, 72, 1, 100, 701),
(266, 1, 'Venta de mercaderias', 225, 0, 0, 0, 1, 101, 699),
(267, 2, 'Venta de mercaderias', 68, 0, 0, 0, 1, 101, 702),
(268, 3, 'Venta de mercaderias', 0, 29, 0, 0, 1, 101, 701),
(269, 3, 'Venta de mercaderias', 0, 196, 0, 0, 1, 101, 704),
(270, 3, 'Venta de mercaderias', 0, 68, 0, 0, 1, 101, 703),
(271, 1, 'Venta de mercaderias', 150, 0, 0, 0, 1, 102, 699),
(272, 2, 'Venta de mercaderias', 45, 0, 0, 0, 1, 102, 702),
(273, 3, 'Venta de mercaderias', 0, 20, 0, 0, 1, 102, 701),
(274, 3, 'Venta de mercaderias', 0, 131, 0, 0, 1, 102, 704),
(275, 3, 'Venta de mercaderias', 0, 45, 0, 0, 1, 102, 703),
(276, 1, 'Apertura de Sociedad', 3500, 0, 504, 0, 1, 103, 662),
(277, 2, 'Apertura de Sociedad', 60000, 0, 8633, 0, 1, 103, 663),
(278, 3, 'Apertura de Sociedad', 5000, 0, 719, 0, 1, 103, 664),
(279, 4, 'Apertura de Sociedad', 1000, 0, 144, 0, 1, 103, 706),
(280, 5, 'Apertura de Sociedad', 0, 7000, 0, 1007, 1, 103, 667),
(281, 6, 'Apertura de Sociedad', 0, 3200, 0, 460, 1, 103, 669),
(282, 7, 'Apertura de Sociedad', 0, 12500, 0, 1799, 1, 103, 670),
(283, 8, 'Apertura de Sociedad', 0, 46800, 0, 6734, 1, 103, 672),
(284, 1, 'Por Compra de Mercaderia, se paga con cheque y let', 15660, 0, 2253, 0, 1, 104, 708),
(285, 2, 'Por Compra de Mercaderia, se paga con cheque y let', 2340, 0, 337, 0, 1, 104, 707),
(286, 3, 'Por Compra de Mercaderia, se paga con cheque y let', 0, 15000, 0, 2158, 1, 104, 663),
(287, 4, 'Por Compra de Mercaderia, se paga con cheque y let', 0, 3000, 0, 432, 1, 104, 668),
(288, 1, 'Por Pago de Debito Fiscar e IT por pagar con chequ', 7000, 0, 1007, 0, 1, 105, 667),
(289, 2, 'Por Pago de Debito Fiscar e IT por pagar con chequ', 3200, 0, 460, 0, 1, 105, 669),
(290, 3, 'Por Pago de Debito Fiscar e IT por pagar con chequ', 0, 10200, 0, 1468, 1, 105, 663),
(291, 1, 'Por venta de mercaderi ', 25600, 0, 3683, 0, 1, 106, 662),
(292, 2, 'Por venta de mercaderi ', 768, 0, 111, 0, 1, 106, 675),
(293, 3, 'Por venta de mercaderi ', 0, 768, 0, 111, 1, 106, 669),
(294, 4, 'Por venta de mercaderi ', 0, 22272, 0, 3205, 1, 106, 674),
(295, 5, 'Por venta de mercaderi ', 0, 3328, 0, 479, 1, 106, 667),
(296, 1, 'Por compra de Material de escritorio', 2001, 0, 288, 0, 1, 107, 665),
(297, 2, 'Por compra de Material de escritorio', 299, 0, 43, 0, 1, 107, 707),
(298, 3, 'Por compra de Material de escritorio', 0, 2300, 0, 331, 1, 107, 663),
(299, 1, 'Por cancelacion de Deuda', 12500, 0, 1799, 0, 1, 108, 670),
(300, 2, 'Por cancelacion de Deuda', 0, 12500, 0, 1799, 1, 108, 663),
(301, 1, 'Por cancelacion de cuentas por cobrar', 1000, 0, 144, 0, 1, 109, 662),
(302, 2, 'Por cancelacion de cuentas por cobrar', 0, 1000, 0, 144, 1, 109, 706),
(303, 1, 'Por Apertura de Empresa', 10000, 0, 1435, 0, 1, 110, 719),
(304, 2, 'Por Apertura de Empresa', 50000, 0, 7174, 0, 1, 110, 720),
(305, 3, 'Por Apertura de Empresa', 1000, 0, 143, 0, 1, 110, 721),
(306, 4, 'Por Apertura de Empresa', 15000, 0, 2152, 0, 1, 110, 724),
(307, 5, 'Por Apertura de Empresa', 3000, 0, 430, 0, 1, 110, 723),
(308, 6, 'Por Apertura de Empresa', 100000, 0, 14347, 0, 1, 110, 722),
(309, 7, 'Por Apertura de Empresa', 0, 5000, 0, 717, 1, 110, 727),
(310, 8, 'Por Apertura de Empresa', 0, 10000, 0, 1435, 1, 110, 728),
(311, 9, 'Por Apertura de Empresa', 0, 164000, 0, 23529, 1, 110, 732),
(312, 1, 'Pago de sueldos', 5000, 0, 719, 0, 1, 111, 676),
(313, 2, 'Pago de sueldos', 0, 5000, 0, 719, 1, 111, 662),
(314, 1, 'Compra de mercaderias', 2080, 0, 0, 0, 1, 112, 707),
(315, 2, 'Compra de mercaderias', 13920, 0, 0, 0, 1, 112, 708),
(316, 3, 'Compra de mercaderias', 0, 16000, 0, 0, 1, 112, 662),
(317, 1, 'Compra de mercaderias', 1430, 0, 0, 0, 1, 113, 707),
(318, 2, 'Compra de mercaderias', 9570, 0, 0, 0, 1, 113, 708),
(319, 3, 'Compra de mercaderias', 0, 11000, 0, 0, 1, 113, 662),
(320, 1, 'Venta de mercaderias', 10000, 0, 0, 0, 1, 114, 662),
(321, 2, 'Venta de mercaderias', 3000, 0, 0, 0, 1, 114, 675),
(322, 3, 'Venta de mercaderias', 0, 1300, 0, 0, 1, 114, 667),
(323, 3, 'Venta de mercaderias', 0, 8700, 0, 0, 1, 114, 674),
(324, 3, 'Venta de mercaderias', 0, 3000, 0, 0, 1, 114, 669),
(325, 1, 'Venta de mercaderias', 20000, 0, 0, 0, 1, 115, 662),
(326, 2, 'Venta de mercaderias', 6000, 0, 0, 0, 1, 115, 675),
(327, 3, 'Venta de mercaderias', 0, 2600, 0, 0, 1, 115, 667),
(328, 3, 'Venta de mercaderias', 0, 17400, 0, 0, 1, 115, 674),
(329, 3, 'Venta de mercaderias', 0, 6000, 0, 0, 1, 115, 669),
(330, 1, 'Venta de mercaderias', 150, 0, 0, 0, 1, 116, 699),
(331, 2, 'Venta de mercaderias', 45, 0, 0, 0, 1, 116, 702),
(332, 3, 'Venta de mercaderias', 0, 20, 0, 0, 1, 116, 701),
(333, 3, 'Venta de mercaderias', 0, 131, 0, 0, 1, 116, 704),
(334, 3, 'Venta de mercaderias', 0, 45, 0, 0, 1, 116, 703),
(335, 1, 'Venta de mercaderias', 75, 0, 0, 0, 1, 117, 699),
(336, 2, 'Venta de mercaderias', 23, 0, 0, 0, 1, 117, 702),
(337, 3, 'Venta de mercaderias', 0, 10, 0, 0, 1, 117, 701),
(338, 3, 'Venta de mercaderias', 0, 65, 0, 0, 1, 117, 704),
(339, 3, 'Venta de mercaderias', 0, 23, 0, 0, 1, 117, 703),
(340, 1, 'aperturando la empresa', 350, 0, 50, 0, 1, 118, 748),
(341, 2, 'aperturando la empresa', 0, 350, 0, 50, 1, 118, 750),
(342, 1, 'Apertura de empresa', 500, 0, 67, 0, 1, 119, 770),
(343, 2, 'Apertura de empresa', 0, 500, 0, 67, 1, 119, 771),
(344, 1, 'Compra de mercaderias', 52, 0, 0, 0, 1, 120, 774),
(345, 2, 'Compra de mercaderias', 348, 0, 0, 0, 1, 120, 770),
(346, 3, 'Compra de mercaderias', 0, 400, 0, 0, 1, 120, 769),
(347, 1, 'Venta de mercaderias', 500, 0, 0, 0, 1, 121, 769),
(348, 2, 'Venta de mercaderias', 150, 0, 0, 0, 1, 121, 772),
(349, 3, 'Venta de mercaderias', 0, 65, 0, 0, 1, 121, 775),
(350, 3, 'Venta de mercaderias', 0, 435, 0, 0, 1, 121, 771),
(351, 3, 'Venta de mercaderias', 0, 150, 0, 0, 1, 121, 773),
(352, 1, 'glosa de prueba', 0, 150, 0, 22, 1, 122, 719),
(353, 2, 'glosa de prueba', 150, 0, 22, 0, 1, 122, 721),
(354, 1, 'Compra de mercaderias', 98, 0, 0, 0, 1, 123, 774),
(355, 2, 'Compra de mercaderias', 653, 0, 0, 0, 1, 123, 770),
(356, 3, 'Compra de mercaderias', 0, 750, 0, 0, 1, 123, 769),
(357, 1, 'Compra de mercaderias', 13, 0, 0, 0, 1, 124, 774),
(358, 2, 'Compra de mercaderias', 87, 0, 0, 0, 1, 124, 770),
(359, 3, 'Compra de mercaderias', 0, 100, 0, 0, 1, 124, 769),
(360, 1, 'Venta de mercaderias', 75, 0, 0, 0, 1, 125, 769),
(361, 2, 'Venta de mercaderias', 23, 0, 0, 0, 1, 125, 772),
(362, 3, 'Venta de mercaderias', 0, 10, 0, 0, 1, 125, 775),
(363, 3, 'Venta de mercaderias', 0, 65, 0, 0, 1, 125, 771),
(364, 3, 'Venta de mercaderias', 0, 23, 0, 0, 1, 125, 773);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `nit` int(11) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `nivel` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `id_usuario_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id_empresa`, `nombre_empresa`, `nit`, `sigla`, `telefono`, `correo`, `direccion`, `nivel`, `estado`, `id_usuario_empresa`) VALUES
(167, 'ApiSoft', 48961891, 'APS', 76000898, 'api_soft@gmail.com', '', 3, 0, 1),
(168, 'Casa Hogar', 2147483647, 'CH', 75364229, 'nati@gmail.com', 'av. La paz esquina lemoine', 3, 0, 1),
(169, 'Parcial Final', 4892164, 'PAF', 75012147, 'vamos_que_se_puede@gmail.com', 'av. La paz esquina lemoine', 3, 0, 1),
(170, 'Ultima prueba', 189545641, '505', 0, '', '', 3, 1, 1),
(171, 'Transversal', 465456789, 'TRAN', 760451181, 'asenseve@gmail.com', 'av. La paz esquina  ', 4, 1, 1),
(172, 'Pro Dental SCZ', 2147483647, 'Pdscz', 78186405, 'faniolita@gmail.com', '4to anillo, radila 27', 3, 1, 1),
(173, 'Daniel Company', 79484940, 'DCH', 75012147, 'company@gmail.com', 'av. banzer', 3, 1, 1),
(174, 'abc chile', 486449864, 'ABC', 75015646, '', 'aqui', 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_monedas`
--

CREATE TABLE `empresa_monedas` (
  `id_empresa_moneda` int(11) NOT NULL,
  `cambio` float DEFAULT NULL,
  `activo` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `id_empresa_m` int(11) NOT NULL,
  `id_moneda_principal` int(11) NOT NULL,
  `id_moneda_alternativa` int(11) DEFAULT NULL,
  `id_usuario_moneda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa_monedas`
--

INSERT INTO `empresa_monedas` (`id_empresa_moneda`, `cambio`, `activo`, `fecha_registro`, `id_empresa_m`, `id_moneda_principal`, `id_moneda_alternativa`, `id_usuario_moneda`) VALUES
(107, NULL, 0, '2023-06-14 00:24:42', 167, 1, NULL, 1),
(108, 6.95, 1, '2023-06-14 00:33:15', 167, 1, 2, 1),
(109, NULL, 0, '2023-06-19 18:03:45', 168, 1, NULL, 1),
(110, 5.65, 0, '2023-06-20 11:06:01', 168, 1, 3, 1),
(111, NULL, 0, '2023-06-20 11:09:22', 169, 1, NULL, 1),
(112, 2.55, 1, '2023-06-20 11:50:20', 168, 1, 5, 1),
(113, NULL, 0, '2023-06-20 14:54:42', 170, 1, NULL, 1),
(114, 6.95, 1, '2023-06-20 14:56:28', 170, 1, 2, 1),
(115, 6.95, 1, '2023-06-20 15:48:03', 169, 1, 2, 1),
(116, NULL, 0, '2023-06-20 19:13:21', 171, 1, NULL, 1),
(117, 6.87, 0, '2023-06-20 19:20:09', 171, 1, 2, 1),
(118, 6.88, 0, '2023-06-20 19:20:30', 171, 1, 3, 1),
(119, 6.97, 1, '2023-06-20 19:20:38', 171, 1, 2, 1),
(120, NULL, 0, '2023-06-22 16:17:50', 172, 1, NULL, 1),
(121, 6.95, 0, '2023-06-22 16:40:39', 172, 1, 2, 1),
(122, 7.5, 1, '2023-06-22 16:48:44', 172, 1, 3, 1),
(123, NULL, 0, '2023-06-22 19:00:56', 173, 1, NULL, 1),
(124, 6.95, 0, '2023-06-22 19:06:31', 173, 1, 2, 1),
(125, 7.5, 1, '2023-06-22 19:06:40', 173, 1, 2, 1),
(126, NULL, 1, '2023-08-17 16:28:47', 174, 2, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestiones`
--

CREATE TABLE `gestiones` (
  `id_gestion` int(11) NOT NULL,
  `nombre_gestion` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado_gestion` tinyint(1) NOT NULL,
  `id_usuario_gestion` int(11) NOT NULL,
  `id_empresa_gestion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gestiones`
--

INSERT INTO `gestiones` (`id_gestion`, `nombre_gestion`, `fecha_inicio`, `fecha_fin`, `estado_gestion`, `id_usuario_gestion`, `id_empresa_gestion`) VALUES
(119, 'Gestion 2023', '2023-01-01', '2023-12-31', 1, 1, 167),
(120, 'Gestion 2024', '2024-01-01', '2024-12-31', 1, 1, 167),
(121, 'Gestion 2023', '2023-01-01', '2023-12-31', 1, 1, 168),
(122, 'Gestion 2024', '2024-01-01', '2024-12-31', 1, 1, 170),
(123, '2023', '2023-01-01', '2023-12-31', 1, 1, 169),
(124, 'Gestion 2022', '2022-01-01', '2022-12-31', 1, 1, 171),
(125, 'Gestion 2023', '2023-01-01', '2023-12-31', 1, 1, 171),
(126, 'Gestion 2024', '2024-01-01', '2024-12-31', 1, 1, 172),
(128, 'Gestion 2023', '2023-01-01', '2023-12-31', 1, 1, 173),
(129, 'Gestion 2023', '2023-01-01', '2023-06-30', 1, 1, 174);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integraciones`
--

CREATE TABLE `integraciones` (
  `id_integracion` int(11) NOT NULL,
  `caja` int(11) NOT NULL,
  `credito_fiscal` int(11) NOT NULL,
  `debito_fiscal` int(11) NOT NULL,
  `compra` int(11) NOT NULL,
  `venta` int(11) NOT NULL,
  `it` int(11) NOT NULL,
  `it_pago` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `activacion` int(11) NOT NULL,
  `id_empresa_integracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `integraciones`
--

INSERT INTO `integraciones` (`id_integracion`, `caja`, `credito_fiscal`, `debito_fiscal`, `compra`, `venta`, `it`, `it_pago`, `estado`, `activacion`, `id_empresa_integracion`) VALUES
(32, 626, 627, 631, 638, 640, 637, 633, 0, 0, 167),
(33, 626, 627, 631, 638, 640, 637, 633, 0, 1, 167),
(34, 626, 627, 631, 638, 640, 637, 633, 0, 0, 167),
(35, 626, 627, 631, 638, 640, 637, 633, 1, 1, 167),
(36, 651, 690, 680, 688, 691, 687, 682, 0, 1, 168),
(37, 651, 690, 680, 688, 691, 687, 682, 1, 0, 168),
(38, 699, 700, 701, 705, 704, 702, 703, 0, 0, 170),
(39, 699, 700, 701, 705, 704, 702, 703, 1, 1, 170),
(40, 662, 707, 667, 708, 674, 675, 669, 1, 1, 169),
(41, 748, 754, 755, 757, 758, 759, 760, 0, 0, 172),
(42, 748, 754, 755, 757, 758, 759, 760, 1, 1, 172),
(43, 769, 774, 775, 770, 771, 772, 773, 0, 1, 173),
(44, 769, 774, 775, 770, 771, 772, 773, 1, 1, 173);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id_lote` int(11) NOT NULL,
  `nro_lote` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `cantidad_lote` int(11) NOT NULL,
  `precio_compra` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `estado_lote` int(11) NOT NULL,
  `id_articulo_lote` int(11) NOT NULL,
  `id_nota_lote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`id_lote`, `nro_lote`, `fecha_ingreso`, `fecha_vencimiento`, `cantidad_lote`, `precio_compra`, `stock`, `estado_lote`, `id_articulo_lote`, `id_nota_lote`) VALUES
(137, 1, '2023-06-20', '0000-00-00', 10, 2000, 6, 1, 39, 131),
(138, 2, '2023-06-20', '2023-06-30', 5, 2000, 0, 2, 39, 132),
(139, 1, '2023-06-20', '0000-00-00', 10, 80, 10, 1, 42, 135),
(140, 2, '2023-06-20', '0000-00-00', 5, 80, 0, 2, 42, 136),
(141, 1, '2023-06-20', '0000-00-00', 5, 15, 5, 0, 44, 139),
(142, 2, '2023-06-20', '0000-00-00', 20, 15, 10, 1, 44, 140),
(143, 1, '2023-06-20', '0000-00-00', 20, 15, 0, 2, 45, 142),
(144, 3, '2023-06-20', '0000-00-00', 20, 12, 0, 2, 44, 143),
(145, 2, '2023-06-20', '0000-00-00', 20, 15, 0, 2, 45, 143),
(146, 1, '2023-02-20', '0000-00-00', 30, 500, 25, 1, 49, 147),
(147, 1, '2023-02-20', '0000-00-00', 100, 10, 95, 1, 51, 147),
(148, 2, '2023-02-20', '0000-00-00', 15, 400, 15, 0, 49, 148),
(149, 1, '2023-02-20', '0000-00-00', 50, 100, 50, 0, 50, 148),
(150, 1, '2023-06-22', '0000-00-00', 15, 10, 5, 1, 52, 153),
(151, 1, '2023-06-22', '0000-00-00', 20, 80, 20, 1, 53, 155),
(152, 2, '2023-01-01', '0000-00-00', 5, 80, 5, 2, 53, 157),
(153, 3, '2023-01-01', '0000-00-00', 5, 150, 5, 1, 53, 159),
(154, 1, '2023-01-01', '0000-00-00', 5, 20, 0, 2, 54, 160);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `id_moneda` int(11) NOT NULL,
  `nombre_moneda` varchar(50) NOT NULL,
  `descripcion_moneda` varchar(50) NOT NULL,
  `abreviatura` varchar(10) NOT NULL,
  `id_usuario_moneda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`id_moneda`, `nombre_moneda`, `descripcion_moneda`, `abreviatura`, `id_usuario_moneda`) VALUES
(1, 'Bolivianos', 'moneda del país de Bolivia', 'BS', 1),
(2, 'Dólar', 'moneda de USA', '$', 1),
(3, 'Libra', 'moneda del Reino Unido', '£', 1),
(4, 'Euro', 'moneda de Europa', '€', 1),
(5, 'Peso Argentino', 'moneda del país de Argentina', 'ARS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `nro_nota` int(11) NOT NULL,
  `fecha_nota` date NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `total_nota` int(11) NOT NULL,
  `tipo_nota` varchar(50) NOT NULL,
  `estado_nota` int(11) NOT NULL,
  `id_empresa_nota` int(11) NOT NULL,
  `id_usuario_nota` int(11) NOT NULL,
  `id_comprobante_nota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_nota`, `nro_nota`, `fecha_nota`, `descripcion`, `total_nota`, `tipo_nota`, `estado_nota`, `id_empresa_nota`, `id_usuario_nota`, `id_comprobante_nota`) VALUES
(131, 1, '2023-06-20', 'compra tv', 20000, 'Compra', 1, 168, 1, NULL),
(132, 2, '2023-06-20', 'compra de tv 2', 10000, 'Compra', 1, 168, 1, NULL),
(133, 3, '2023-06-20', '', 5000, 'Venta', 1, 168, 1, NULL),
(134, 4, '2023-06-20', '', 5000, 'Venta', 1, 168, 1, NULL),
(135, 5, '2023-06-20', '', 800, 'Compra', 1, 168, 1, NULL),
(136, 6, '2023-06-20', 'mouse', 400, 'Compra', 1, 168, 1, NULL),
(137, 7, '2023-06-20', 'compra doble', 5080, 'Venta', 1, 168, 1, NULL),
(138, 8, '2023-06-20', 'venta solo lote 2 agotar', 7820, 'Venta', 1, 168, 1, NULL),
(139, 1, '2023-06-20', '', 75, 'Compra', 0, 170, 1, NULL),
(140, 2, '2023-06-20', 'compra oreo', 300, 'Compra', 1, 170, 1, NULL),
(141, 3, '2023-06-20', 'venta de oreo', 150, 'Venta', 0, 170, 1, NULL),
(142, 4, '2023-06-20', 'galleta una mabel', 300, 'Compra', 1, 170, 1, NULL),
(143, 5, '2023-06-20', 'galleta mabel y galleta oreo', 540, 'Compra', 1, 170, 1, NULL),
(144, 6, '2023-06-20', 'venta de dos galletas mabel y oreo', 525, 'Venta', 1, 170, 1, NULL),
(145, 7, '2024-01-02', 'venta galleta mabel integ.', 225, 'Venta', 1, 170, 1, 101),
(146, 8, '2024-01-02', 'galleta mabel y oreo lote 2', 150, 'Venta', 1, 170, 1, 102),
(147, 1, '2023-02-20', 'Compra 1', 16000, 'Compra', 1, 169, 1, 112),
(148, 2, '2023-02-20', 'compra 2', 11000, 'Compra', 0, 169, 1, 113),
(149, 3, '2023-02-22', 'Venta', 10000, 'Venta', 1, 169, 1, 114),
(150, 4, '2023-02-20', '', 20000, 'Venta', 0, 169, 1, 115),
(151, 9, '2024-01-01', '', 150, 'Venta', 1, 170, 1, 116),
(152, 10, '2024-01-01', '', 75, 'Venta', 0, 170, 1, 117),
(153, 1, '2023-06-22', 'compra de coca cola', 150, 'Compra', 1, 172, 1, NULL),
(154, 2, '2023-06-22', 'venta de coca cola', 150, 'Venta', 1, 172, 1, NULL),
(155, 1, '2023-06-22', 'nota de compra', 1600, 'Compra', 1, 173, 1, NULL),
(156, 2, '2023-06-22', 'venta de pinza ', 1000, 'Venta', 0, 173, 1, NULL),
(157, 3, '2023-01-01', 'nota de compra con integraciones', 400, 'Compra', 1, 173, 1, 120),
(158, 4, '2023-01-01', 'nota de venta con integracion', 500, 'Venta', 0, 173, 1, 121),
(159, 5, '2023-01-01', 'prueba', 750, 'Compra', 1, 173, 1, 123),
(160, 6, '2023-01-01', 'compra de soda', 100, 'Compra', 1, 173, 1, 124),
(161, 7, '2023-01-01', 'prueba venta', 75, 'Venta', 1, 173, 1, 125);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `id_periodo` int(11) NOT NULL,
  `nombre_periodo` varchar(50) NOT NULL,
  `fecha_inicio_periodo` date NOT NULL,
  `fecha_fin_periodo` date NOT NULL,
  `estado_periodo` int(11) NOT NULL,
  `id_usuario_periodo` int(11) NOT NULL,
  `id_gestion_periodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`id_periodo`, `nombre_periodo`, `fecha_inicio_periodo`, `fecha_fin_periodo`, `estado_periodo`, `id_usuario_periodo`, `id_gestion_periodo`) VALUES
(295, 'Enero', '2024-01-01', '2024-01-31', 1, 1, 120),
(296, 'Febrero', '2024-02-01', '2024-02-28', 1, 1, 120),
(297, 'Marzo', '2024-03-01', '2024-03-31', 1, 1, 120),
(298, 'Enero', '2023-01-01', '2023-01-31', 1, 1, 119),
(300, 'Enero', '2023-01-01', '2023-01-31', 1, 1, 121),
(301, 'Febrero', '2023-02-01', '2023-02-28', 1, 1, 121),
(302, 'Enero', '2024-01-01', '2024-01-31', 1, 1, 122),
(303, 'Enero', '2023-01-01', '2023-01-31', 1, 1, 123),
(304, 'Febrero', '2023-02-01', '2023-02-28', 1, 1, 123),
(305, 'Marzo', '2023-03-01', '2023-03-31', 1, 1, 123),
(306, 'Enero', '2023-01-01', '2023-01-31', 1, 1, 125),
(307, 'Febrero', '2023-02-01', '2023-02-28', 1, 1, 125),
(308, 'Abril', '2023-04-01', '2023-04-30', 1, 1, 125),
(309, 'Marzo', '2023-03-01', '2023-03-31', 1, 1, 125),
(310, 'Enero', '2024-01-01', '2024-01-31', 1, 1, 126),
(311, 'Febrero', '2024-02-01', '2024-02-28', 1, 1, 126),
(312, 'Enero', '2023-01-01', '2023-01-31', 1, 1, 128),
(313, 'Marzo', '2023-03-01', '2023-03-31', 1, 1, 128),
(314, 'Febrero', '2023-02-01', '2023-02-28', 1, 1, 128),
(315, 'Enero', '2022-01-01', '2022-01-31', 1, 1, 124),
(316, 'Marzo', '2022-03-01', '2022-03-31', 1, 1, 124),
(317, 'Febrero', '2022-02-01', '2022-02-28', 1, 1, 124),
(318, 'Enero', '2023-01-01', '2023-01-31', 1, 1, 129),
(320, 'Febrero', '2023-02-01', '2023-02-28', 1, 1, 129);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `usuario`, `contrasena`, `tipo`) VALUES
(1, 'Cesar', 'admin', 'admin', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`),
  ADD KEY `id_empresa_articulo` (`id_empresa_articulo`,`id_usuario_articulo`),
  ADD KEY `id_usuario_articulo` (`id_usuario_articulo`);

--
-- Indices de la tabla `articulo_categorias`
--
ALTER TABLE `articulo_categorias`
  ADD PRIMARY KEY (`id_ca`),
  ADD KEY `id_articulo_lf` (`id_articulo_ca`,`id_categoria_ca`),
  ADD KEY `articulo_categorias_ibfk_2` (`id_categoria_ca`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `id_empresa_categoria` (`id_empresa_categoria`,`id_usuario_categoria`,`id_categoria_padre`),
  ADD KEY `id_usuario_categoria` (`id_usuario_categoria`),
  ADD KEY `id_categoria_padre` (`id_categoria_padre`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id_comprobante`),
  ADD KEY `id_usuario_comprobante` (`id_usuario_comprobante`,`id_moneda`),
  ADD KEY `id_moneda` (`id_moneda`),
  ADD KEY `id_empresa_comprobante` (`id_empresa_comprobante`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id_cuenta`),
  ADD KEY `id_usuario_cuenta` (`id_usuario_cuenta`),
  ADD KEY `id_empresa_cuenta` (`id_empresa_cuenta`),
  ADD KEY `id_cuenta_padre` (`id_cuenta_padre`);

--
-- Indices de la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_articulo_detalle` (`id_articulo_detalle`,`id_nota_detalle`),
  ADD KEY `id_nota_detalle` (`id_nota_detalle`),
  ADD KEY `id_lote_detalle` (`id_lote_detalle`);

--
-- Indices de la tabla `detalle_comprobantes`
--
ALTER TABLE `detalle_comprobantes`
  ADD PRIMARY KEY (`id_detalle_comprobante`),
  ADD KEY `id_usuario_comprobante` (`id_usuario_comprobante`,`id_comprobante`,`id_cuenta`),
  ADD KEY `id_comprobante` (`id_comprobante`),
  ADD KEY `id_cuenta` (`id_cuenta`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id_empresa`),
  ADD KEY `id_usuario_empresa` (`id_usuario_empresa`);

--
-- Indices de la tabla `empresa_monedas`
--
ALTER TABLE `empresa_monedas`
  ADD PRIMARY KEY (`id_empresa_moneda`),
  ADD KEY `id_empresa_m` (`id_empresa_m`),
  ADD KEY `id_moneda_principal` (`id_moneda_principal`),
  ADD KEY `id_moneda_alternativa` (`id_moneda_alternativa`,`id_usuario_moneda`),
  ADD KEY `id_usuario_moneda` (`id_usuario_moneda`);

--
-- Indices de la tabla `gestiones`
--
ALTER TABLE `gestiones`
  ADD PRIMARY KEY (`id_gestion`),
  ADD KEY `id_usuario_gestion` (`id_usuario_gestion`),
  ADD KEY `id_empresa_gestion` (`id_empresa_gestion`);

--
-- Indices de la tabla `integraciones`
--
ALTER TABLE `integraciones`
  ADD PRIMARY KEY (`id_integracion`),
  ADD KEY `caja` (`caja`,`credito_fiscal`,`debito_fiscal`,`compra`,`venta`,`it`,`it_pago`),
  ADD KEY `debito_fiscal` (`debito_fiscal`),
  ADD KEY `compra` (`compra`),
  ADD KEY `venta` (`venta`),
  ADD KEY `it` (`it`),
  ADD KEY `it_pago` (`it_pago`),
  ADD KEY `id_empresa_integracion` (`id_empresa_integracion`),
  ADD KEY `integraciones_ibfk_3` (`credito_fiscal`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `id_articulo_lote` (`id_articulo_lote`,`id_nota_lote`),
  ADD KEY `id_nota_lote` (`id_nota_lote`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`id_moneda`),
  ADD KEY `id_usuario_moneda` (`id_usuario_moneda`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_empresa_nota` (`id_empresa_nota`,`id_usuario_nota`),
  ADD KEY `id_usuario_nota` (`id_usuario_nota`),
  ADD KEY `id_comprobante_nota` (`id_comprobante_nota`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id_periodo`),
  ADD KEY `id_usuario_periodo` (`id_usuario_periodo`),
  ADD KEY `id_gestion_periodo` (`id_gestion_periodo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id_articulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `articulo_categorias`
--
ALTER TABLE `articulo_categorias`
  MODIFY `id_ca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id_comprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=788;

--
-- AUTO_INCREMENT de la tabla `detalles`
--
ALTER TABLE `detalles`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `detalle_comprobantes`
--
ALTER TABLE `detalle_comprobantes`
  MODIFY `id_detalle_comprobante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT de la tabla `empresa_monedas`
--
ALTER TABLE `empresa_monedas`
  MODIFY `id_empresa_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT de la tabla `gestiones`
--
ALTER TABLE `gestiones`
  MODIFY `id_gestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `integraciones`
--
ALTER TABLE `integraciones`
  MODIFY `id_integracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`id_empresa_articulo`) REFERENCES `empresas` (`id_empresa`),
  ADD CONSTRAINT `articulos_ibfk_2` FOREIGN KEY (`id_usuario_articulo`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `articulo_categorias`
--
ALTER TABLE `articulo_categorias`
  ADD CONSTRAINT `articulo_categorias_ibfk_1` FOREIGN KEY (`id_articulo_ca`) REFERENCES `articulos` (`id_articulo`) ON DELETE CASCADE,
  ADD CONSTRAINT `articulo_categorias_ibfk_2` FOREIGN KEY (`id_categoria_ca`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_empresa_categoria`) REFERENCES `empresas` (`id_empresa`),
  ADD CONSTRAINT `categorias_ibfk_2` FOREIGN KEY (`id_usuario_categoria`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `categorias_ibfk_3` FOREIGN KEY (`id_categoria_padre`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD CONSTRAINT `comprobantes_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `monedas` (`id_moneda`),
  ADD CONSTRAINT `comprobantes_ibfk_2` FOREIGN KEY (`id_usuario_comprobante`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `comprobantes_ibfk_3` FOREIGN KEY (`id_empresa_comprobante`) REFERENCES `empresas` (`id_empresa`);

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`id_usuario_cuenta`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `cuentas_ibfk_2` FOREIGN KEY (`id_empresa_cuenta`) REFERENCES `empresas` (`id_empresa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cuentas_ibfk_3` FOREIGN KEY (`id_cuenta_padre`) REFERENCES `cuentas` (`id_cuenta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD CONSTRAINT `detalles_ibfk_1` FOREIGN KEY (`id_articulo_detalle`) REFERENCES `articulos` (`id_articulo`),
  ADD CONSTRAINT `detalles_ibfk_2` FOREIGN KEY (`id_nota_detalle`) REFERENCES `notas` (`id_nota`),
  ADD CONSTRAINT `detalles_ibfk_3` FOREIGN KEY (`id_lote_detalle`) REFERENCES `lotes` (`id_lote`);

--
-- Filtros para la tabla `detalle_comprobantes`
--
ALTER TABLE `detalle_comprobantes`
  ADD CONSTRAINT `detalle_comprobantes_ibfk_1` FOREIGN KEY (`id_usuario_comprobante`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `detalle_comprobantes_ibfk_2` FOREIGN KEY (`id_comprobante`) REFERENCES `comprobantes` (`id_comprobante`),
  ADD CONSTRAINT `detalle_comprobantes_ibfk_3` FOREIGN KEY (`id_cuenta`) REFERENCES `cuentas` (`id_cuenta`);

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`id_usuario_empresa`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empresa_monedas`
--
ALTER TABLE `empresa_monedas`
  ADD CONSTRAINT `empresa_monedas_ibfk_1` FOREIGN KEY (`id_empresa_m`) REFERENCES `empresas` (`id_empresa`) ON DELETE CASCADE,
  ADD CONSTRAINT `empresa_monedas_ibfk_2` FOREIGN KEY (`id_moneda_principal`) REFERENCES `monedas` (`id_moneda`),
  ADD CONSTRAINT `empresa_monedas_ibfk_3` FOREIGN KEY (`id_moneda_alternativa`) REFERENCES `monedas` (`id_moneda`),
  ADD CONSTRAINT `empresa_monedas_ibfk_4` FOREIGN KEY (`id_usuario_moneda`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `gestiones`
--
ALTER TABLE `gestiones`
  ADD CONSTRAINT `gestiones_ibfk_1` FOREIGN KEY (`id_usuario_gestion`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `gestiones_ibfk_2` FOREIGN KEY (`id_empresa_gestion`) REFERENCES `empresas` (`id_empresa`);

--
-- Filtros para la tabla `integraciones`
--
ALTER TABLE `integraciones`
  ADD CONSTRAINT `integraciones_ibfk_2` FOREIGN KEY (`caja`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_3` FOREIGN KEY (`credito_fiscal`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_4` FOREIGN KEY (`debito_fiscal`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_5` FOREIGN KEY (`compra`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_6` FOREIGN KEY (`venta`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_7` FOREIGN KEY (`it`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_8` FOREIGN KEY (`it_pago`) REFERENCES `cuentas` (`id_cuenta`),
  ADD CONSTRAINT `integraciones_ibfk_9` FOREIGN KEY (`id_empresa_integracion`) REFERENCES `empresas` (`id_empresa`);

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`id_articulo_lote`) REFERENCES `articulos` (`id_articulo`),
  ADD CONSTRAINT `lotes_ibfk_2` FOREIGN KEY (`id_nota_lote`) REFERENCES `notas` (`id_nota`);

--
-- Filtros para la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD CONSTRAINT `monedas_ibfk_1` FOREIGN KEY (`id_usuario_moneda`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`id_empresa_nota`) REFERENCES `empresas` (`id_empresa`),
  ADD CONSTRAINT `notas_ibfk_3` FOREIGN KEY (`id_usuario_nota`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `notas_ibfk_4` FOREIGN KEY (`id_comprobante_nota`) REFERENCES `comprobantes` (`id_comprobante`);

--
-- Filtros para la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD CONSTRAINT `periodos_ibfk_1` FOREIGN KEY (`id_usuario_periodo`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `periodos_ibfk_2` FOREIGN KEY (`id_gestion_periodo`) REFERENCES `gestiones` (`id_gestion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
