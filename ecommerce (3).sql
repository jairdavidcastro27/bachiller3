-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2025 a las 01:37:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `rol_admin` text DEFAULT NULL,
  `name_admin` text DEFAULT NULL,
  `email_admin` text DEFAULT NULL,
  `password_admin` text DEFAULT NULL,
  `token_admin` text DEFAULT NULL,
  `token_exp_admin` text DEFAULT NULL,
  `date_created_admin` date DEFAULT NULL,
  `date_updated_admin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id_admin`, `rol_admin`, `name_admin`, `email_admin`, `password_admin`, `token_admin`, `token_exp_admin`, `date_created_admin`, `date_updated_admin`) VALUES
(1, 'admin', 'Jair David', 'admin@ecommerce.com', '$2a$07$azybxcags23425sdg23sdecpKJbxGIdTekpSGtvCaxAzCYz/U2Jpq', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTA1MjAwNTAsImV4cCI6MTc1MDYwNjQ1MCwiZGF0YSI6eyJpZCI6IjEiLCJlbWFpbCI6ImFkbWluQGVjb21tZXJjZS5jb20ifX0.239CkN8ZiexnE8-BaIx7sPq_FKKcB2ng-2yiX13OuD0', '1750606450', '2022-09-21', '2025-06-21 22:07:36'),
(3, 'editor', 'Juan Editor', 'editor@ecommerce.com', '$2a$07$azybxcags23425sdg23sde6O2XwC3JISITojuDRKxnpYYe9FEREU.', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MTY4NTEwMDAsImV4cCI6MTcxNjkzNzQwMCwiZGF0YSI6eyJpZCI6IjMiLCJlbWFpbCI6ImVkaXRvckBlY29tbWVyY2UuY29tIn19.HOzoTXcQDEkjEATdFeM2EjWOts3p7U6L45aj444WRrk', '1716937400', '2024-05-27', '2025-06-13 04:39:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE `banners` (
  `id_banner` int(11) NOT NULL,
  `location_banner` text DEFAULT NULL,
  `id_category_banner` int(11) NOT NULL DEFAULT 0,
  `id_subcategory_banner` int(11) NOT NULL DEFAULT 0,
  `background_banner` text DEFAULT NULL,
  `text_banner` text DEFAULT NULL,
  `discount_banner` text DEFAULT NULL,
  `end_banner` date DEFAULT NULL,
  `status_banner` int(11) NOT NULL DEFAULT 1,
  `date_created_banner` date DEFAULT NULL,
  `date_updated_banner` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `banners`
--

INSERT INTO `banners` (`id_banner`, `location_banner`, `id_category_banner`, `id_subcategory_banner`, `background_banner`, `text_banner`, `discount_banner`, `end_banner`, `status_banner`, `date_created_banner`, `date_updated_banner`) VALUES
(1, 'HOME', 0, 0, 'default.jpg', 'Ofertas especiales', '50', '2030-04-30', 1, '2024-05-22', '2024-05-22 21:24:48'),
(3, 'CATEGORÍA', 1, 0, 'bg.jpg', 'Descuentos Especiales', '50', '2030-12-31', 1, '2024-05-22', '2024-05-22 21:28:53'),
(4, 'CATEGORÍA', 5, 0, 'bg.jpg', 'Ofertas de Cursos', '50', '2029-12-20', 1, '2024-05-22', '2024-05-22 21:30:00'),
(5, 'SUBCATEGORÍA', 0, 6, 'bg.jpg', 'Ofertas en Calzado Hombre', '30', '2028-11-22', 1, '2024-05-22', '2024-05-22 21:38:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletas_electronicas`
--

CREATE TABLE `boletas_electronicas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `numero_boleta` varchar(50) NOT NULL,
  `pdf_url` varchar(255) NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `estado` enum('emitida','anulada') DEFAULT 'emitida',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boletas_electronicas`
--

INSERT INTO `boletas_electronicas` (`id`, `id_venta`, `numero_boleta`, `pdf_url`, `fecha_emision`, `estado`, `created_at`) VALUES
(1, 30, 'BOL-37B88051B2', '', '2025-06-22 01:12:23', 'emitida', '2025-06-21 23:12:23'),
(2, 31, 'BOL-E85E029A9C', '', '2025-06-22 01:23:54', 'emitida', '2025-06-21 23:23:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `usuario_apertura` int(11) NOT NULL,
  `monto_apertura` decimal(10,2) NOT NULL,
  `usuario_cierre` int(11) DEFAULT NULL,
  `monto_cierre` decimal(10,2) DEFAULT NULL,
  `estado` enum('abierta','cerrada') DEFAULT 'abierta',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `fecha`, `usuario_apertura`, `monto_apertura`, `usuario_cierre`, `monto_cierre`, `estado`, `created_at`) VALUES
(1, '2025-06-21', 0, 100.00, NULL, NULL, 'abierta', '2025-06-21 17:39:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id_cart` int(11) NOT NULL,
  `id_user_cart` int(11) NOT NULL DEFAULT 0,
  `id_product_cart` int(11) NOT NULL DEFAULT 0,
  `id_variant_cart` int(11) NOT NULL DEFAULT 0,
  `quantity_cart` int(11) DEFAULT 0,
  `price_cart` double NOT NULL DEFAULT 0,
  `ref_cart` text DEFAULT NULL,
  `order_cart` text DEFAULT NULL,
  `method_cart` text DEFAULT NULL,
  `date_created_cart` date DEFAULT NULL,
  `date_updated_cart` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carts`
--

INSERT INTO `carts` (`id_cart`, `id_user_cart`, `id_product_cart`, `id_variant_cart`, `quantity_cart`, `price_cart`, `ref_cart`, `order_cart`, `method_cart`, `date_created_cart`, `date_updated_cart`) VALUES
(30, 4, 20, 48, 1, 0, NULL, NULL, NULL, '2025-06-03', '2025-06-03 00:42:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name_category` text DEFAULT NULL,
  `url_category` text DEFAULT NULL,
  `icon_category` text DEFAULT NULL,
  `image_category` text DEFAULT NULL,
  `description_category` text DEFAULT NULL,
  `keywords_category` text DEFAULT NULL,
  `subcategories_category` int(11) DEFAULT 0,
  `products_category` int(11) DEFAULT 0,
  `views_category` int(11) DEFAULT 0,
  `status_category` int(11) DEFAULT 1,
  `date_created_category` date DEFAULT NULL,
  `date_updated_category` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id_category`, `name_category`, `url_category`, `icon_category`, `image_category`, `description_category`, `keywords_category`, `subcategories_category`, `products_category`, `views_category`, `status_category`, `date_created_category`, `date_updated_category`) VALUES
(1, 'Ropa', 'ropa', 'fas fa-tshirt', 'ropa.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt velit a ullamcorper eleifend. Aenean aliquam, odio et laoreet ultricies, dolor nibh dignissim sapien, ac lacinia quam ligula et massa.', 'ropa,camisas,pantalones,blusas,faldas', 4, 21, 0, 1, '2023-06-29', '2025-06-20 08:57:57'),
(2, 'Calzado', 'calzado', 'fas fa-shoe-prints', 'calzado.jpg', 'Duis dolor ex, condimentum in purus in, sodales convallis velit. Sed malesuada non ligula lobortis porta. Etiam aliquam tincidunt justo, id aliquet metus hendrerit nec. In congue leo risus, vel varius sapien porta in. Aenean efficitur', 'calzado,tennis,chanclas,sandalias', 4, 2, 0, 1, '2023-06-29', '2023-08-10 23:41:52'),
(3, 'Tecnología', 'tecnologia', 'fas fa-laptop', 'tecnologia.jpg', 'urabitur nibh libero, aliquet scelerisque tellus non, pulvinar mollis erat. Donec ac vehicula dolor. Nulla lobortis nisi at dapibus imperdiet. In ornare ante viverra quam efficitur efficitur. Sed felis sem, rutrum nec iaculis eget,', 'pc,portatil,ordenador,servidor', 4, 0, 0, 0, '2023-06-29', '2025-06-10 00:44:29'),
(5, 'Cursos', 'cursos', 'fas fa-graduation-cap', 'cursos.jpg', 'Nunc erat est, suscipit eu vulputate id, venenatis volutpat nulla. Proin et mauris et odio faucibus laoreet quis viverra massa. Suspendisse potenti.', 'cursos,tutorías,tutoriales,virtualidad', 4, 5, 0, 0, '2023-06-30', '2025-06-10 00:44:25'),
(6, 'Accesorios', 'accesorios', 'fas fa-anchor', 'accesorios.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt velit a ullamcorper eleifend. Aenean aliquam, odio et laoreet ultricies, dolor nibh dignissim sapien, ac lacinia quam ligula et massa.', 'accesorios,lorem,ipsum', 1, 4, 0, 1, '2023-08-08', '2025-06-10 00:55:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_notes`
--

CREATE TABLE `credit_notes` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `credit_notes`
--

INSERT INTO `credit_notes` (`id`, `order_id`, `user_id`, `amount`, `reason`, `created_at`) VALUES
(1, 1, 4, 3.00, 'sdfs', '2025-06-13 06:22:27'),
(2, 2, 4, 23.00, 'sdfsdf', '2025-06-13 06:22:59'),
(3, 2, 4, 23.00, 'sdfsdf', '2025-06-13 06:24:49'),
(4, 1, 4, 12.00, 'DESCUENTO', '2025-06-17 01:18:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorites`
--

CREATE TABLE `favorites` (
  `id_favorite` int(11) NOT NULL,
  `id_user_favorite` int(11) NOT NULL DEFAULT 0,
  `id_product_favorite` int(11) NOT NULL DEFAULT 0,
  `date_created_favorite` date DEFAULT NULL,
  `date_updated_favorite` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `favorites`
--

INSERT INTO `favorites` (`id_favorite`, `id_user_favorite`, `id_product_favorite`, `date_created_favorite`, `date_updated_favorite`) VALUES
(10, 4, 21, '2024-01-25', '2024-01-25 17:58:52'),
(13, 4, 21, '2024-01-25', '2024-01-25 19:44:07'),
(22, 5, 46, '2025-06-12', '2025-06-12 19:15:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja`
--

CREATE TABLE `movimientos_caja` (
  `id` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `tipo` enum('ingreso','egreso') NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `pdf_comprobante` longblob DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_caja`
--

INSERT INTO `movimientos_caja` (`id`, `id_caja`, `tipo`, `descripcion`, `monto`, `id_venta`, `pdf_comprobante`, `created_at`) VALUES
(1, 1, 'ingreso', 'Ingreso por venta #29', 150.00, 29, NULL, '2025-06-21 21:13:01'),
(2, 1, 'ingreso', 'Ingreso por venta #30', 150.00, 30, NULL, '2025-06-21 23:12:23'),
(3, 1, 'ingreso', 'Ingreso por venta #31', 150.00, 31, NULL, '2025-06-21 23:23:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `uniqid_order` text DEFAULT NULL,
  `id_user_order` int(11) NOT NULL DEFAULT 0,
  `id_product_order` int(11) NOT NULL DEFAULT 0,
  `id_variant_order` int(11) NOT NULL DEFAULT 0,
  `quantity_order` int(11) NOT NULL DEFAULT 0,
  `price_order` double NOT NULL DEFAULT 0,
  `ref_order` text DEFAULT NULL,
  `number_order` text DEFAULT NULL,
  `method_order` text DEFAULT NULL,
  `warranty_order` int(11) NOT NULL DEFAULT 0,
  `process_order` int(11) NOT NULL DEFAULT 0,
  `track_order` text DEFAULT NULL,
  `start_date_order` date DEFAULT NULL,
  `medium_date_order` date DEFAULT NULL,
  `end_date_order` date DEFAULT NULL,
  `date_created_order` date DEFAULT NULL,
  `date_updated_order` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id_order`, `uniqid_order`, `id_user_order`, `id_product_order`, `id_variant_order`, `quantity_order`, `price_order`, `ref_order`, `number_order`, `method_order`, `warranty_order`, `process_order`, `track_order`, `start_date_order`, `medium_date_order`, `end_date_order`, `date_created_order`, `date_updated_order`) VALUES
(1, '664fa12bef541', 4, 21, 50, 3, 450, '86291706914879', 'DP-41467', 'dlocal', 7, 2, '24124124', '2024-02-02', '2024-05-01', '2024-05-23', '2024-02-02', '2024-05-23 20:05:36'),
(2, '664fa1938e116', 4, 20, 48, 1, 150, '86291706914879', 'DP-41467', 'dlocal', 7, 2, '24124124', '2024-02-02', '2024-02-03', '2024-02-05', '2024-02-02', '2024-05-23 20:05:47'),
(4, '664fa2123da8d', 5, 20, 48, 1, 150, '45071707152340', '36U83700DE932372L', 'paypal', 7, 1, '21241251236', '2024-02-05', '2024-05-23', '2024-05-27', '2024-02-05', '2024-05-23 20:07:53'),
(7, '664fa22f822e5', 4, 17, 41, 2, 300, '65631712934911', '97W699981W093833Y', 'paypal', 7, 0, NULL, '2024-04-12', NULL, NULL, '2024-04-12', '2024-05-23 20:08:22'),
(8, '664fa2385c534', 4, 22, 52, 2, 300, '65631712934911', '97W699981W093833Y', 'paypal', 7, 0, NULL, '2024-04-12', NULL, NULL, '2024-04-12', '2024-05-23 20:08:30'),
(10, '6654e3c962f17', 4, 18, 45, 1, 300, '12801716839143', '19G74859EU5691709', 'paypal', 7, 0, NULL, '2024-05-27', NULL, NULL, '2024-05-27', '2024-05-27 19:49:29'),
(11, '6654e3c98afad', 4, 18, 44, 1, 300, '12801716839143', '19G74859EU5691709', 'paypal', 7, 0, NULL, '2024-05-27', NULL, NULL, '2024-05-27', '2024-05-27 19:49:29'),
(12, '6654e4aa6a09b', 4, 21, 49, 1, 150, '14391716839510', 'DP-54074', 'dlocal', 7, 0, '', '2024-05-27', '0000-00-00', '0000-00-00', '2024-05-27', '2025-06-10 00:57:10'),
(18, '684b435d92c79', 5, 21, 49, 1, 1050, '54191749762669', 'DP-99550', 'dlocal', 7, 0, NULL, '2025-06-12', NULL, NULL, '2025-06-12', '2025-06-12 21:15:09'),
(19, '684b435de5b6b', 5, 21, 49, 3, 1050, '54191749762669', 'DP-99550', 'dlocal', 7, 0, NULL, '2025-06-12', NULL, NULL, '2025-06-12', '2025-06-12 21:15:09'),
(20, '684b435e264ee', 5, 21, 49, 1, 1050, '54191749762669', 'DP-99550', 'dlocal', 7, 0, NULL, '2025-06-12', NULL, NULL, '2025-06-12', '2025-06-12 21:15:10'),
(21, '684b435e57a3f', 5, 21, 50, 2, 1050, '54191749762669', 'DP-99550', 'dlocal', 7, 2, '', '2025-06-12', '0000-00-00', '0000-00-00', '2025-06-12', '2025-06-12 21:33:10'),
(22, '684b4577689a2', 8, 19, 46, 1, 150, '38831749763341', 'DP-99569', 'dlocal', 7, 2, '', '2025-06-12', '0000-00-00', '0000-00-00', '2025-06-12', '2025-06-12 21:33:00'),
(23, '684b48d44b381', 5, 1, 2, 1, 150, '43591749764223', 'DP-99570', 'dlocal', 7, 0, NULL, '2025-06-12', NULL, NULL, '2025-06-12', '2025-06-12 21:38:28'),
(24, '6850a5a63bbc1', 5, 20, 48, 1, 150, '16821750115688', 'DP-100536', 'dlocal', 7, 2, '', '2025-06-16', '0000-00-00', '0000-00-00', '2025-06-16', '2025-06-16 23:19:05'),
(25, '6850c148f2b2e', 5, 21, 49, 2, 300, '39261750122754', 'DP-100544', 'dlocal', 7, 1, '', '2025-06-16', '0000-00-00', '0000-00-00', '2025-06-16', '2025-06-17 01:15:34'),
(26, '6856ef24bb4af', 5, 19, 47, 1, 150, '27171750527710', 'DP-101668', 'dlocal', 7, 0, NULL, '2025-06-21', NULL, NULL, '2025-06-21', '2025-06-21 17:43:00'),
(27, '6856f26b82ffb', 5, 21, 49, 1, 150, '49361750528558', 'DP-101669', 'dlocal', 7, 0, NULL, '2025-06-21', NULL, NULL, '2025-06-21', '2025-06-21 17:56:59'),
(28, '6856f55072024', 5, 20, 48, 1, 150, '57651750529264', 'DP-101671', 'dlocal', 7, 0, NULL, '2025-06-21', NULL, NULL, '2025-06-21', '2025-06-21 18:09:20'),
(29, '6857205d3f689', 5, 19, 46, 1, 150, '16201750540290', 'DP-101704', 'dlocal', 7, 0, NULL, '2025-06-21', NULL, NULL, '2025-06-21', '2025-06-21 21:13:01'),
(30, '68573c578e2f2', 5, 21, 49, 1, 150, '52331750547491', 'DP-101728', 'dlocal', 7, 0, NULL, '2025-06-21', NULL, NULL, '2025-06-21', '2025-06-21 23:12:23'),
(31, '68573f0a8f04c', 5, 20, 48, 1, 150, '31681750548178', 'DP-101730', 'dlocal', 7, 0, NULL, '2025-06-21', NULL, NULL, '2025-06-21', '2025-06-21 23:23:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `id_category_product` int(11) NOT NULL DEFAULT 0,
  `id_subcategory_product` int(11) NOT NULL DEFAULT 0,
  `provider_id` int(11) DEFAULT NULL,
  `name_product` text DEFAULT NULL,
  `url_product` text DEFAULT NULL,
  `image_product` text DEFAULT NULL,
  `description_product` text DEFAULT NULL,
  `keywords_product` text DEFAULT NULL,
  `info_product` longtext DEFAULT NULL,
  `views_product` int(11) NOT NULL DEFAULT 0,
  `sales_product` int(11) NOT NULL DEFAULT 0,
  `status_product` int(11) NOT NULL DEFAULT 1,
  `date_created_product` date DEFAULT NULL,
  `date_updated_product` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id_product`, `id_category_product`, `id_subcategory_product`, `provider_id`, `name_product`, `url_product`, `image_product`, `description_product`, `keywords_product`, `info_product`, `views_product`, `sales_product`, `status_product`, `date_created_product`, `date_updated_product`) VALUES
(1, 1, 1, NULL, 'Conjunto 1 Ropa Dama 1', 'conjunto-1-ropa-dama-1', 'conjunto-1-ropa-dama-1.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\n							            </p>', 8, 1, 1, '2023-07-03', '2025-06-12 21:38:28'),
(4, 1, 1, NULL, 'Conjunto 2 Ropa Dama 1', 'conjunto-2-ropa-dama-1', 'conjunto-2-ropa-dama-1.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-2-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-07-27 18:46:55'),
(5, 1, 1, NULL, 'Conjunto 3 Ropa Dama 1', 'conjunto-3-ropa-dama-1', 'conjunto-3-ropa-dama-1.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-3-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-07-27 18:46:55'),
(6, 1, 2, NULL, 'Conjunto 1 Ropa Hombre 1', 'conjunto-1-ropa-hombre-1', 'conjunto-1-ropa-hombre-1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,hombre,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-hombre-1/4865831814.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 1, 0, 1, '2023-08-03', '2024-05-27 23:10:21'),
(7, 1, 2, NULL, 'Conjunto 2 Ropa Hombre 1', 'conjunto-2-ropa-hombre-1', 'conjunto-2-ropa-hombre-1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,hombre,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-2-ropa-hombre-1/4865831814.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 9, 0, 1, '2023-08-03', '2024-05-28 00:57:15'),
(8, 1, 3, NULL, 'Conjunto Deportivo 1', 'conjunto-deportivo-1', 'conjunto-deportivo-1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,deportiva,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -500px -100px no-repeat;background-size:825px 175px;\" alt=\":football:\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.<img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -750px -100px no-repeat;background-size:825px 175px;\" alt=\":bicyclist:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-deportivo-1/1758272835.jpg\" class=\"img-fluid\"><br></p><p>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.<br></p><p>							            				\r\n							            </p>', 0, 0, 1, '2023-08-03', '2023-08-03 17:14:11'),
(9, 1, 1, NULL, 'Conjunto 1 Ropa Dama 2', 'conjunto-1-ropa-dama-2', 'conjunto-1-ropa-dama-2.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-2/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-08-03 17:09:13'),
(10, 1, 1, NULL, 'Conjunto 2 Ropa Dama 2', 'conjunto-2-ropa-dama-2', 'conjunto-2-ropa-dama-2.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-2-ropa-dama-2/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-08-03 17:09:13'),
(11, 1, 1, NULL, 'Conjunto 3 Ropa Dama 2', 'conjunto-3-ropa-dama-2', 'conjunto-3-ropa-dama-2.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-3-ropa-dama-2/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 3, 0, 1, '2023-07-03', '2023-08-10 23:24:42'),
(12, 1, 2, NULL, 'Conjunto 1 Ropa Hombre 2', 'conjunto-1-ropa-hombre-2', 'conjunto-1-ropa-hombre-2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,hombre,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-hombre-2/4865831814.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 1, 0, 1, '2023-08-03', '2024-05-27 23:24:34'),
(13, 1, 2, NULL, 'Conjunto 2 Ropa Hombre 2', 'conjunto-2-ropa-hombre-2', 'conjunto-2-ropa-hombre-2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,hombre,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-2-ropa-hombre-2/4865831814.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 1, 0, 1, '2023-08-03', '2024-05-27 23:53:12'),
(14, 1, 3, NULL, 'Conjunto Deportivo 2', 'conjunto-deportivo-2', 'conjunto-deportivo-2.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,deportiva,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -500px -100px no-repeat;background-size:825px 175px;\" alt=\":football:\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.<img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -750px -100px no-repeat;background-size:825px 175px;\" alt=\":bicyclist:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-deportivo-2/1758272835.jpg\" class=\"img-fluid\"><br></p><p>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.<br></p><p>							            				\r\n							            </p>', 0, 0, 1, '2023-08-03', '2023-08-03 17:14:11'),
(15, 1, 1, NULL, 'Conjunto 1 Ropa Dama 3', 'conjunto-1-ropa-dama-3', 'conjunto-1-ropa-dama-3.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-3/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-08-03 17:09:13'),
(16, 1, 1, NULL, 'Conjunto 2 Ropa Dama 3', 'conjunto-2-ropa-dama-3', 'conjunto-2-ropa-dama-3.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-2-ropa-dama-3/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-08-03 17:09:13'),
(17, 1, 1, NULL, 'Conjunto 3 Ropa Dama 3', 'conjunto-3-ropa-dama-3', 'conjunto-3-ropa-dama-3.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'ropa,dama,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-3-ropa-dama-3/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-07-03', '2023-08-03 17:09:13'),
(18, 1, 2, NULL, 'Conjunto 1 Ropa Hombre 3', 'conjunto-1-ropa-hombre-3', 'conjunto-1-ropa-hombre-3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,hombre,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-hombre-3/4865831814.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 1, 0, 1, '2023-08-03', '2024-05-27 23:39:07'),
(19, 1, 2, NULL, 'Conjunto 2 Ropa Hombre 3', 'conjunto-2-ropa-hombre-3', 'conjunto-2-ropa-hombre-3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,hombre,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-2-ropa-hombre-3/4865831814.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 4, 3, 1, '2023-08-03', '2025-06-21 21:13:01'),
(20, 1, 3, NULL, 'Conjunto Deportivo 3', 'conjunto-deportivo-3', 'conjunto-deportivo-3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'ropa,deportiva,lorem,ipsum', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -500px -100px no-repeat;background-size:825px 175px;\" alt=\":football:\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.<img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -750px -100px no-repeat;background-size:825px 175px;\" alt=\":bicyclist:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-deportivo-3/1758272835.jpg\" class=\"img-fluid\"><br></p><p>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.<br></p><p>							            				\r\n							            </p>', 20, 3, 1, '2023-08-03', '2025-06-21 23:23:54'),
(21, 2, 7, NULL, 'Tennis Deportivo 1', 'tennis-deportivo-1', 'tennis-deportivo-1.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'tennis,calzado,deportivo', '<div><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -500px -100px no-repeat;background-size:825px 175px;\" alt=\":football:\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.<img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -450px 0px no-repeat;background-size:825px 175px;\" alt=\":balloon:\"></div><div><br></div><div><img style=\"width: 100%;\" src=\"/views/assets/img/products/tennis-deportivo-1/7313634339.png\" class=\"img-fluid\"><br></div><div><br></div><div>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.</div>', 40, 6, 1, '2023-08-03', '2025-06-21 23:12:23');
INSERT INTO `products` (`id_product`, `id_category_product`, `id_subcategory_product`, `provider_id`, `name_product`, `url_product`, `image_product`, `description_product`, `keywords_product`, `info_product`, `views_product`, `sales_product`, `status_product`, `date_created_product`, `date_updated_product`) VALUES
(22, 2, 7, NULL, 'Tennis Deportivo 2', 'tennis-deportivo-2', 'tennis-deportivo-2.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'tennis,calzado,deportivo', '<div><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -500px -100px no-repeat;background-size:825px 175px;\" alt=\":football:\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.<img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -450px 0px no-repeat;background-size:825px 175px;\" alt=\":balloon:\"></div><div><br></div><div><img style=\"width: 100%;\" src=\"/views/assets/img/products/tennis-deportivo-2/7313634339.png\" class=\"img-fluid\"><br></div><div><br></div><div>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.</div>', 0, 0, 1, '2023-08-03', '2023-08-03 18:04:23'),
(23, 2, 7, NULL, 'Tennis Deportivo 3', 'tennis-deportivo-3', 'tennis-deportivo-3.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'tennis,calzado,deportivo', '<div><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -500px -100px no-repeat;background-size:825px 175px;\" alt=\":football:\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.<img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_2.png\') -450px 0px no-repeat;background-size:825px 175px;\" alt=\":balloon:\"></div><div><br></div><div><img style=\"width: 100%;\" src=\"/views/assets/img/products/tennis-deportivo-3/7313634339.png\" class=\"img-fluid\"><br></div><div><br></div><div>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.</div>', 1, 0, 1, '2023-08-03', '2025-06-03 00:39:58'),
(24, 2, 6, NULL, 'Calzado Masculino', 'calzado-masculino', 'calzado-masculino.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.', 'calzado,masculino,lorem', '<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper feugiat enim vitae aliquet. Nunc quis commodo libero. Etiam non pellentesque mi, quis ultricies velit. Nulla ultrices congue odio accumsan pellentesque.</div><div><br></div><div><img style=\"width: 100%;\" src=\"/views/assets/img/products/calzado-masculino/3053216752.jpg\" class=\"img-fluid\"><br></div><div><br></div><div>Sed mi tortor, venenatis eget ante sed, dignissim blandit lectus. Etiam rhoncus nibh at velit elementum posuere. Donec semper scelerisque lectus, nec ornare ipsum fermentum non.</div>', 0, 0, 1, '2023-08-03', '2023-08-03 18:10:12'),
(43, 6, 17, NULL, 'Accesorio 1', 'accesorio-1', 'accesorio-1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt velit a ullamcorper eleifend. Aenean aliquam, odio et laoreet ultricies, dolor nibh dignissim sapien, ac lacinia quam ligula et massa.', 'accesorio,joyas,lorem', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 0, 0, 1, '2023-08-08', '2023-08-08 21:24:55'),
(44, 6, 17, NULL, 'Accesorio 2', 'accesorio-2', 'accesorio-2.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'accesorio,maleta', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 7, 0, 1, '2023-08-08', '2025-06-21 23:22:43'),
(45, 6, 17, NULL, 'Accesorio 3', 'accesorio-3', 'accesorio-3.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'accesorio,maleta', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 4, 0, 1, '2023-08-08', '2025-06-10 00:46:32'),
(46, 6, 17, NULL, 'Accesorio 4', 'accesorio-4', 'accesorio-4.jpg', 'Morbi eu risus nisi. Mauris nisl augue, pellentesque id arcu ut, commodo volutpat nisl. Vivamus consectetur justo sit amet lectus fermentum accumsan. Curabitur ac orci nisl.', 'accesorio,anillo', '<p><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -250px -150px no-repeat;background-size:675px 175px;\" alt=\":heart:\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget aliquam urna, eu pharetra nisi. Maecenas lacinia tristique tincidunt. Aliquam in auctor metus. Pellentesque neque ante, rutrum ut est at, lacinia aliquet neque. Donec vitae ex orci.</span><img src=\"/views/assets/css/plugins/summernote/img/blank.gif\" class=\"img\" style=\"display:inline-block;width:25px;height:25px;background:url(\'/views/assets/css/plugins/summernote/img/emoji_spritesheet_0.png\') -75px -75px no-repeat;background-size:675px 175px;\" alt=\":see_no_evil:\"></p><p><img style=\"width: 100%;\" src=\"/views/assets/img/products/conjunto-1-ropa-dama-1/6546023218.jpg\" class=\"img-fluid\"><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><br></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"> Duis vehicula vehicula lacus, vel congue eros ultrices vel. Nam posuere elit ut ligula venenatis volutpat. Nullam ac lectus vel felis pretium auctor a ac massa. </span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\"><b>Fusce in fringilla ante. Vestibulum auctor accumsan dui, non pharetra urna gravida id. Sed in felis et urna posuere egestas vel feugiat eros. </b></span></p><p><span style=\"color: rgb(0, 0, 0); font-family: \" open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Nunc malesuada, nibh id venenatis eleifend, mi augue rutrum purus, dignissim luctus justo lorem non risus. Nulla iaculis metus non justo consequat, ac placerat arcu fringilla. Praesent nec consectetur nunc. Aenean sollicitudin, diam vel mollis semper, est est tincidunt ligula, et accumsan mi risus quis erat. Nulla sagittis ex a consectetur mollis.</span>							            							            								            				\r\n							            </p>', 10, 0, 0, '2023-08-08', '2025-06-17 01:17:03'),
(47, 1, 1, 1, 'Aaaa', 'aaaa', 'aaaa.jpg', 'lhvkjh', 'ytfy', 'jhjm', 0, 0, 1, '2025-06-20', '2025-06-20 08:19:02'),
(48, 1, 2, 1, 'Qweqeqwe', 'qweqeqwe', 'qweqeqwe.jpg', 'qeqwe', 'qweqwe', 'qweqe', 0, 0, 1, '2025-06-20', '2025-06-20 08:01:44'),
(49, 1, 2, NULL, '11111111111', '11111111111', '11111111111.jpg', 'ssdfsdf', 'asdasd', 'asdasd', 0, 0, 1, '2025-06-20', '2025-06-20 08:57:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_purchases`
--

CREATE TABLE `product_purchases` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `final_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product_purchases`
--

INSERT INTO `product_purchases` (`id`, `product_id`, `purchase_price`, `invoice_number`, `purchase_date`, `quantity`, `final_price`) VALUES
(3, 47, 12.00, '12312313423', '2025-06-27', 4, 48.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `providers`
--

INSERT INTO `providers` (`id`, `name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'lupita', 'lupita@gmsail.com', '123456789', 'santa rosa lima', '2025-06-20 07:39:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slides`
--

CREATE TABLE `slides` (
  `id_slide` int(11) NOT NULL,
  `background_slide` text DEFAULT NULL,
  `direction_slide` text DEFAULT NULL,
  `img_png_slide` text DEFAULT NULL,
  `coord_img_slide` text DEFAULT NULL,
  `text_slide` text DEFAULT NULL,
  `coord_text_slide` text DEFAULT NULL,
  `link_slide` text DEFAULT NULL,
  `text_btn_slide` text DEFAULT NULL,
  `status_slide` int(11) NOT NULL DEFAULT 1,
  `date_created_slide` date DEFAULT NULL,
  `date_updated_slide` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `slides`
--

INSERT INTO `slides` (`id_slide`, `background_slide`, `direction_slide`, `img_png_slide`, `coord_img_slide`, `text_slide`, `coord_text_slide`, `link_slide`, `text_btn_slide`, `status_slide`, `date_created_slide`, `date_updated_slide`) VALUES
(1, 'back_default.jpg', 'opt1', 'calzado.png', 'top:15%; right:10%; width:45%', '[{\"text\":\"Lorem Ipsum\",\"color\":\"#333\"},{\"text\":\"Lorem ipsum dolor sit\",\"color\":\"#777\"},{\"text\":\"Lorem ipsum dolor sit\",\"color\":\"#888\"}]', 'top:20%; left:10%; width:40%', 'http://ecommerce.com/calzado', 'VER PRODUCTO', 1, '2024-05-22', '2024-05-22 19:00:50'),
(2, 'fondo2.jpg', 'opt2', 'iphone.png', 'bottom:0%; left:15%; width:28%', '[{\"text\":\"Lorem Ipsum\",\"color\":\"#ffffff\"},{\"text\":\"Lorem ipsum dolor sit\",\"color\":\"#e8e8e8\"},{\"text\":\"Lorem ipsum dolor sit\",\"color\":\"#d6d6d6\"}]', 'top:20%; right:15%; width:40%', 'http://ecommerce.com/no-found', 'VER PRODUCTO', 1, '2024-05-22', '2024-05-22 19:00:49'),
(4, 'bg.jpg', '', '', '', '', '', '', '', 0, '2024-05-22', '2025-06-17 01:22:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socials`
--

CREATE TABLE `socials` (
  `id_social` int(11) NOT NULL,
  `name_social` text DEFAULT NULL,
  `url_social` text DEFAULT NULL,
  `icon_social` text DEFAULT NULL,
  `color_social` text DEFAULT NULL,
  `date_created_social` date DEFAULT NULL,
  `date_updated_social` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `socials`
--

INSERT INTO `socials` (`id_social`, `name_social`, `url_social`, `icon_social`, `color_social`, `date_created_social`, `date_updated_social`) VALUES
(1, 'facebook', 'https://facebook.com', 'fab fa-facebook-f', 'text-white', '2022-09-24', '2024-05-20 22:22:38'),
(2, 'youtube', 'https://youtube.com', 'fab fa-youtube', 'text-white', '2022-09-24', '2022-09-24 18:20:47'),
(3, 'twitter', 'https://twitter.com', 'fab fa-twitter', 'text-white', '2022-09-24', '2022-09-24 18:20:51'),
(4, 'instagram', 'https://instagram.com', 'fab fa-instagram', 'text-white', '2022-09-24', '2022-09-24 18:20:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE `subcategories` (
  `id_subcategory` int(11) NOT NULL,
  `id_category_subcategory` int(11) NOT NULL DEFAULT 0,
  `name_subcategory` text DEFAULT NULL,
  `url_subcategory` text DEFAULT NULL,
  `image_subcategory` text DEFAULT NULL,
  `description_subcategory` text DEFAULT NULL,
  `keywords_subcategory` text DEFAULT NULL,
  `products_subcategory` int(11) NOT NULL DEFAULT 0,
  `views_subcategory` int(11) NOT NULL DEFAULT 0,
  `status_subcategory` int(11) NOT NULL DEFAULT 1,
  `date_created_subcategory` date DEFAULT NULL,
  `date_updated_subcategory` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`id_subcategory`, `id_category_subcategory`, `name_subcategory`, `url_subcategory`, `image_subcategory`, `description_subcategory`, `keywords_subcategory`, `products_subcategory`, `views_subcategory`, `status_subcategory`, `date_created_subcategory`, `date_updated_subcategory`) VALUES
(1, 1, 'Ropa Para Dama', 'ropa-para-dama', 'ropa-para-dama.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut cum quae laboriosam asperiores dolorem iure id provident voluptates ipsum magni ea ipsam tempore, aut, expedita at maxime autem consequuntur distinctio!', 'ropa,lorem,ipsum', 1, 0, 1, '2023-03-04', '2025-06-20 08:19:03'),
(2, 1, 'Ropa Para Hombre', 'ropa-para-hombre', 'ropa-para-hombre.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'ropa,lorem,ipsum', 3, 0, 1, '2023-03-08', '2025-06-20 08:57:57'),
(3, 1, 'Ropa Deportiva', 'ropa-deportiva', 'ropa-deportiva.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'ropa,lorem,ipsum', 1, 0, 1, '2023-03-08', '2023-08-03 17:14:11'),
(4, 1, 'Ropa Infantil', 'ropa-infantil', 'ropa-infantil.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'ropa,lorem,ipsum', 0, 0, 1, '2023-03-08', '2023-07-02 16:50:01'),
(5, 2, 'Calzado Para Dama', 'calzado-para-dama', 'calzado-para-dama.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'calzado,lorem,ipsum', 0, 0, 1, '2023-03-08', '2023-07-05 20:01:23'),
(6, 2, 'Calzado Para Hombre', 'calzado-para-hombre', 'calzado-para-hombre.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'calzado,lorem,ipsum', 1, 0, 1, '2023-03-08', '2023-08-03 18:10:12'),
(7, 2, 'Calzado Deportivo', 'calzado-deportivo', 'calzado-deportivo.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'calzado,lorem,ipsum', 1, 0, 1, '2023-03-08', '2023-08-10 23:41:52'),
(8, 2, 'Calzado Infantil', 'calzado-infantil', 'calzado-infantil.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'calzado,lorem,ipsum', 0, 0, 1, '2023-03-08', '2023-07-02 16:56:43'),
(13, 5, 'Desarrollo Web', 'desarrollo-web', 'desarrollo-web.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'cursos,lorem,ipsum', 5, 0, 1, '2023-03-08', '2025-05-31 18:35:27'),
(14, 5, 'Aplicaciones Móviles', 'aplicaciones-moviles', 'aplicaciones-moviles.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'cursos,lorem,ipsum', 0, 0, 1, '2023-03-08', '2023-07-02 16:54:11'),
(15, 5, 'Diseño Gráfico', 'diseno-grafico', 'diseno-grafico.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'cursos,lorem,ipsum', 0, 0, 1, '2023-03-08', '2023-07-02 16:54:13'),
(16, 5, 'Marketing Digital', 'marketing-digital', 'marketing-digital.jpg', 'Lorem ipsum dolor, sit amet consectetur adipisicing, elit. Corporis aspernatur temporibus vero sit error, consectetur, dignissimos excepturi enim? Facilis dolor blanditiis molestiae dolores fugiat alias fugit reprehenderit soluta earum ducimus', 'cursos,lorem,ipsum', 0, 0, 1, '2023-03-08', '2023-07-02 16:54:15'),
(17, 6, 'Variedades', 'variedades', 'variedades.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tincidunt velit a ullamcorper eleifend. Aenean aliquam, odio et laoreet ultricies, dolor nibh dignissim sapien, ac lacinia quam ligula et massa.', 'variedades,accesorios,lorem,ipsum', 4, 0, 1, '2023-08-08', '2025-06-10 00:56:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templates`
--

CREATE TABLE `templates` (
  `id_template` int(11) NOT NULL,
  `logo_template` text DEFAULT NULL,
  `icon_template` text DEFAULT NULL,
  `cover_template` text DEFAULT NULL,
  `title_template` text DEFAULT NULL,
  `description_template` text DEFAULT NULL,
  `keywords_template` text DEFAULT NULL,
  `fonts_template` text DEFAULT NULL,
  `colors_template` text DEFAULT NULL,
  `active_template` text DEFAULT NULL,
  `date_created_template` date DEFAULT NULL,
  `date_updated_template` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `templates`
--

INSERT INTO `templates` (`id_template`, `logo_template`, `icon_template`, `cover_template`, `title_template`, `description_template`, `keywords_template`, `fonts_template`, `colors_template`, `active_template`, `date_created_template`, `date_updated_template`) VALUES
(1, 'logo.png', 'icono.png', 'cover.jpg', 'Sistema Ecommerce', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin tempor sem, at rutrum leo aliquet in. Phasellus et gravida magna. ', 'ecommerce,comercio electrónico,moda,sistemas', '{\"fontFamily\":\"%20%3Clink%20rel%3D%22preconnect%22%20href%3D%22https%3A%2F%2Ffonts.googleapis.com%22%3E%0A%20%20%3Clink%20rel%3D%22preconnect%22%20href%3D%22https%3A%2F%2Ffonts.gstatic.com%22%20crossorigin%3E%0A%20%20%3Clink%20href%3D%22https%3A%2F%2Ffonts.googleapis.com%2Fcss2%3Ffamily%3DUbuntu%2BCondensed%26family%3DUbuntu%3Aital%2Cwght%400%2C300%3B0%2C400%3B0%2C500%3B0%2C700%3B1%2C300%3B1%2C400%3B1%2C500%3B1%2C700%26display%3Dswap%22%20rel%3D%22stylesheet%22%3E\",\"fontBody\":\"Ubuntu\",\"fontSlide\":\"Ubuntu Condensed\"}', '[{\"top\":{\"background\":\"black\",\"color\":\"white\"}},{\"template\":\n{\"background\":\"#47BAC1\",\"color\":\"white\"}}]', 'NULL', '2022-09-22', '2025-06-12 21:48:19'),
(2, 'logo.png', 'icono.png', 'cover.jpg', 'Sistema Ecommerce', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sollicitudin tempor sem, at rutrum leo aliquet in. Phasellus et gravida magna. ', 'ecommerce,comercio electrónico,moda,sistemas', '{\"fontFamily\":\"%3Clink%20rel%3D%22preconnect%22%20href%3D%22https%3A%2F%2Ffonts.googleapis.com%22%3E%0A%3Clink%20rel%3D%22preconnect%22%20href%3D%22https%3A%2F%2Ffonts.gstatic.com%22%20crossorigin%3E%0A%3Clink%20href%3D%22https%3A%2F%2Ffonts.googleapis.com%2Fcss2%3Ffamily%3DMontserrat%3Awght%40300%3B700%26display%3Dswap%22%20rel%3D%22stylesheet%22%3E\",\"fontBody\":\"Montserrat\",\"fontSlide\":\"Montserrat\"}', '[{\"top\":{\"background\":\"#03f9b6\",\"color\":\"black\"}},{\"template\":{\"background\":\"#c147b5\",\"color\":\"white\"}}]', 'ok', '2022-09-22', '2025-06-12 21:48:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name_user` text DEFAULT NULL,
  `email_user` text DEFAULT NULL,
  `password_user` text DEFAULT NULL,
  `token_user` text DEFAULT NULL,
  `token_exp_user` text DEFAULT NULL,
  `method_user` text DEFAULT NULL,
  `verification_user` int(11) NOT NULL DEFAULT 0,
  `confirm_user` text DEFAULT NULL,
  `country_user` text DEFAULT NULL,
  `department_user` text DEFAULT NULL,
  `city_user` text DEFAULT NULL,
  `address_user` text DEFAULT NULL,
  `phone_user` text DEFAULT NULL,
  `date_created_user` date DEFAULT NULL,
  `date_updated_user` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `email_user`, `password_user`, `token_user`, `token_exp_user`, `method_user`, `verification_user`, `confirm_user`, `country_user`, `department_user`, `city_user`, `address_user`, `phone_user`, `date_created_user`, `date_updated_user`) VALUES
(4, 'Tutoriales A Tu Alcance', 'correo.tutorialesatualcance@gmail.com', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NDk3NTMzNTgsImV4cCI6MTc0OTgzOTc1OCwiZGF0YSI6eyJpZCI6IjQiLCJlbWFpbCI6ImNvcnJlby50dXRvcmlhbGVzYXR1YWxjYW5jZUBnbWFpbC5jb20ifX0.xmkMfzZd3pNoOyOqRiILC-A0d6mGm8xdrWmZ4T8459I', '1749839758', 'google', 1, NULL, 'Colombia', 'Antioquia', 'Envigado', 'Calle 43 # 33', '57_2352562436', '2024-01-24', '2025-06-12 18:37:01'),
(5, 'Juan Urrego', 'juanu@gmail.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NTA1Mjc2NDEsImV4cCI6MTc1MDYxNDA0MSwiZGF0YSI6eyJpZCI6IjUiLCJlbWFpbCI6Imp1YW51QGdtYWlsLmNvbSJ9fQ.FkRBB9cv4uYp20DuS5drBnUSEus9rMTfyMvvQ5J9rWQ', '1750614041', 'directo', 1, 'fc42ho3p8elrd91t6kb0', 'Colombia', 'Cundinamarca', 'Bogotá', 'Calle 34 # 45', '57_1354135213', '2024-01-25', '2025-06-21 23:23:53'),
(6, 'Juan Fernando Urrego', 'vivirdelainternet@gmail.com', '$2a$07$azybxcags23425sdg23sdebwAHuUuSFHF3NY2PY1Aj/Vn/KCI5xtW', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MTY1ODc4NTEsImV4cCI6MTcxNjY3NDI1MSwiZGF0YSI6eyJpZCI6IjYiLCJlbWFpbCI6InZpdmlyZGVsYWludGVybmV0QGdtYWlsLmNvbSJ9fQ.DJpGBE49olpeBU6XABUoF9bI476xgAXTNR_J77-ky8Y', '1716674251', 'directo', 1, 'y4uf9xdc58sh6z30orvb', NULL, NULL, NULL, NULL, NULL, '2024-05-24', '2024-05-24 22:47:15'),
(7, 'Wilmer Suma', 'wilmersuma@gmail.com', '$2a$07$azybxcags23425sdg23sdey68q/TGWyZ6WXugNle6t/xN6nM0IUju', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3MTY2OTI1OTIsImV4cCI6MTcxNjc3ODk5MiwiZGF0YSI6eyJpZCI6IjciLCJlbWFpbCI6IndpbG1lcnN1bWFAZ21haWwuY29tIn19.8mb0Sw4s4lC7EGcK6eLzMH-mBPJsKx6jNWk2Ts0hOLg', '1716778992', 'directo', 1, 'hnymq5rlp8s20xudikv3', 'Peru', 'Peru', 'Cusco', 'san sebastian', '51_900904592_', '2024-05-26', '2024-05-26 03:03:28'),
(8, 'Jair David', 'cjair759@gmail.com', '$2a$07$azybxcags23425sdg23sdeS.uQfLLtxee48c1PsPfl1CXM32NQw/u', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NDk3NjMyMDMsImV4cCI6MTc0OTg0OTYwMywiZGF0YSI6eyJpZCI6IjgiLCJlbWFpbCI6ImNqYWlyNzU5QGdtYWlsLmNvbSJ9fQ.4SuDjOTv7bdOMKLKIXi8zJ1d8MvR-WcA_Gf9Rm4C-f8', '1749849603', 'directo', 1, 'a5usi12bnv0wg8p93fmx', 'Peru', 'Ica', 'Ica', 'santa rosa de lima segunda etapa', '51_982664642_', '2025-05-31', '2025-06-13 02:10:44'),
(9, 'Jair David', 'jair@gmail.com', '$2a$07$azybxcags23425sdg23sdeOEMZyF0G0YtWjFZiKje8H6YXiEXTizi', NULL, NULL, 'directo', 0, 'kvaj7x5fe0bms3gzq6hc', NULL, NULL, NULL, NULL, NULL, '2025-05-31', '2025-05-31 19:25:44'),
(10, 'Jair David', 'jairdavid@gmail.com', '$2a$07$azybxcags23425sdg23sdeOEMZyF0G0YtWjFZiKje8H6YXiEXTizi', NULL, NULL, 'directo', 0, 'o16kpni0v5xceyq289r4', NULL, NULL, NULL, NULL, NULL, '2025-05-31', '2025-05-31 19:45:15'),
(11, 'Jair David', 'j@gmail.com', '$2a$07$azybxcags23425sdg23sdeOEMZyF0G0YtWjFZiKje8H6YXiEXTizi', NULL, NULL, 'directo', 0, '5pcfrk0io6nshwvxqe82', NULL, NULL, NULL, NULL, NULL, '2025-05-31', '2025-05-31 19:54:27'),
(12, 'Jair David', 'c@gmail.com', '$2a$07$azybxcags23425sdg23sdeOEMZyF0G0YtWjFZiKje8H6YXiEXTizi', NULL, NULL, 'directo', 0, 'emgjuiqp72syr91wfb5d', NULL, NULL, NULL, NULL, NULL, '2025-05-31', '2025-05-31 19:55:06'),
(13, 'Jair David', 'd@gmail.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', NULL, NULL, 'directo', 0, 'coadt6gpyu2x93q07vks', NULL, NULL, NULL, NULL, NULL, '2025-05-31', '2025-05-31 20:24:54'),
(14, 'Jair David', 'jair27@gmail.com', '$2a$07$azybxcags23425sdg23sdehhxOOHgRaxOJ6xKVSwx8WqRlK/mrf5S', NULL, NULL, 'directo', 0, 'i8yshq7c20u36v5awgmn', NULL, NULL, NULL, NULL, NULL, '2025-05-31', '2025-05-31 20:46:55'),
(15, 'Jair David', 'usuario@gmail.com', '$2a$07$azybxcags23425sdg23sdeanQZqjaf6Birm2NvcYTNtJw24CsO5uq', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NDg5MDg3NTMsImV4cCI6MTc0ODk5NTE1MywiZGF0YSI6eyJpZCI6IjE1IiwiZW1haWwiOiJ1c3VhcmlvQGdtYWlsLmNvbSJ9fQ.R3WMbVeyXrJ9f-H_l6DQup2DogDd0DIy8VQc9Swr9Zk', '1748995153', 'directo', 0, 'bdn1tqewogax68sy93pi', NULL, NULL, NULL, NULL, NULL, '2025-06-02', '2025-06-03 00:59:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variants`
--

CREATE TABLE `variants` (
  `id_variant` int(11) NOT NULL,
  `id_product_variant` int(11) DEFAULT 0,
  `type_variant` text DEFAULT NULL,
  `media_variant` text DEFAULT NULL,
  `description_variant` text DEFAULT NULL,
  `cost_variant` double NOT NULL DEFAULT 0,
  `price_variant` double NOT NULL DEFAULT 0,
  `offer_variant` text DEFAULT NULL,
  `end_offer_variant` date DEFAULT NULL,
  `stock_variant` int(11) NOT NULL DEFAULT 0,
  `date_created_variant` date DEFAULT NULL,
  `date_updated_variant` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `variants`
--

INSERT INTO `variants` (`id_variant`, `id_product_variant`, `type_variant`, `media_variant`, `description_variant`, `cost_variant`, `price_variant`, `offer_variant`, `end_offer_variant`, `stock_variant`, `date_created_variant`, `date_updated_variant`) VALUES
(2, 1, 'gallery', '[\"78123.jpg\",\"87200.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:45:29'),
(7, 1, 'gallery', '[\"61137.jpg\",\"17566.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:45:41'),
(9, 1, 'gallery', '[\"59749.jpg\",\"19866.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:45:43'),
(10, 4, 'gallery', '[\"28350.jpg\",\"11684.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:45:59'),
(11, 4, 'gallery', '[\"21325.jpg\",\"86726.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:46:03'),
(12, 4, 'gallery', '[\"59749.jpg\",\"19866.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:08'),
(13, 5, 'gallery', '[\"20984.jpg\",\"98565.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:46:12'),
(14, 5, 'gallery', '[\"61137.jpg\",\"17566.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:46:18'),
(15, 5, 'gallery', '[\"51505.jpg\",\"42147.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:21'),
(16, 6, 'gallery', '[\"38789.jpg\",\"71099.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:25'),
(17, 6, 'gallery', '[\"26258.jpg\",\"79873.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:31'),
(18, 7, 'gallery', '[\"85656.jpg\",\"50072.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:39'),
(19, 7, 'gallery', '[\"85265.jpg\",\"44462.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:46'),
(20, 8, 'gallery', '[\"81003.jpg\",\"28510.jpg\"]', 'Conjunto deportivo verde', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:46:51'),
(21, 9, 'gallery', '[\"78123.jpg\",\"87200.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:46:58'),
(22, 9, 'gallery', '[\"61137.jpg\",\"17566.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:47:03'),
(23, 9, 'gallery', '[\"59749.jpg\",\"19866.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:07'),
(24, 10, 'gallery', '[\"28350.jpg\",\"11684.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:47:12'),
(25, 10, 'gallery', '[\"21325.jpg\",\"86726.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:47:18'),
(26, 10, 'gallery', '[\"59749.jpg\",\"19866.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:22'),
(27, 11, 'gallery', '[\"20984.jpg\",\"98565.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:47:26'),
(28, 11, 'gallery', '[\"61137.jpg\",\"17566.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:47:31'),
(29, 11, 'gallery', '[\"51505.jpg\",\"42147.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:34'),
(30, 12, 'gallery', '[\"38789.jpg\",\"71099.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:40'),
(31, 12, 'gallery', '[\"26258.jpg\",\"79873.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:44'),
(32, 13, 'gallery', '[\"86981.jpg\",\"88573.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:54'),
(33, 13, 'gallery', '[\"40517.jpg\",\"54102.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:47:58'),
(34, 14, 'gallery', '[\"81003.jpg\",\"28510.jpg\"]', 'Conjunto deportivo verde', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:48:02'),
(35, 15, 'gallery', '[\"78123.jpg\",\"87200.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:48:07'),
(36, 15, 'gallery', '[\"61137.jpg\",\"17566.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:48:10'),
(37, 15, 'gallery', '[\"59749.jpg\",\"19866.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:48:15'),
(38, 16, 'gallery', '[\"28350.jpg\",\"11684.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-08-30 20:48:20'),
(39, 16, 'gallery', '[\"21325.jpg\",\"86726.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-07-28', '2023-08-30 20:48:25'),
(40, 16, 'gallery', '[\"59749.jpg\",\"19866.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:48:33'),
(41, 17, 'gallery', '[\"20984.jpg\",\"98565.jpg\"]', 'Conjunto Azul', 100, 200, '150', '0000-00-00', 100, '2023-07-26', '2023-09-21 21:46:38'),
(42, 17, 'gallery', '[\"61137.jpg\",\"17566.jpg\"]', 'Conjunto Blanco', 100, 180, '140', '2023-10-01', 0, '2023-07-28', '2023-09-21 22:34:36'),
(43, 17, 'gallery', '[\"51505.jpg\",\"42147.jpg\"]', 'Conjunto Beige', 100, 210, '180', '0000-00-00', 30, '2023-08-03', '2023-09-21 21:47:37'),
(44, 18, 'gallery', '[\"38789.jpg\",\"71099.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:48:49'),
(45, 18, 'gallery', '[\"26258.jpg\",\"79873.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:48:54'),
(46, 19, 'gallery', '[\"86981.jpg\",\"88573.jpg\"]', 'Conjunto Blanco', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:48:57'),
(47, 19, 'gallery', '[\"40517.jpg\",\"54102.jpg\"]', 'Conjunto Beige', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:01'),
(48, 20, 'gallery', '[\"81003.jpg\",\"28510.jpg\"]', 'Conjunto deportivo verde', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:06'),
(49, 21, 'gallery', '[\"23224.jpg\",\"34013.jpg\",\"66353.jpg\"]', 'Tennis Verde', 100, 200, '150', '0000-00-00', 0, '2023-08-03', '2023-08-30 20:49:12'),
(50, 21, 'gallery', '[\"38033.jpg\",\"97518.jpg\",\"79550.jpg\",\"41346.jpg\",\"98179.jpg\"]', 'Tennis Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:18'),
(51, 21, 'gallery', '[\"21891.jpg\",\"88137.jpg\",\"69877.jpg\",\"29563.jpg\",\"61658.jpg\"]', 'Tennis Rojo', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:25'),
(52, 22, 'gallery', '[\"38033.jpg\",\"97518.jpg\",\"79550.jpg\",\"41346.jpg\",\"98179.jpg\"]', 'Tennis Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:34'),
(53, 22, 'gallery', '[\"99902.jpg\",\"61653.jpg\",\"77377.jpg\",\"34013.jpg\",\"66353.jpg\"]', 'Tennis Verde', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:38'),
(54, 22, 'gallery', '[\"21891.jpg\",\"88137.jpg\",\"69877.jpg\",\"29563.jpg\",\"61658.jpg\"]', 'Tennis Rojo', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:43'),
(55, 23, 'gallery', '[\"21891.jpg\",\"88137.jpg\",\"69877.jpg\",\"29563.jpg\",\"61658.jpg\"]', 'Tennis Rojo', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:49'),
(56, 23, 'gallery', '[\"99902.jpg\",\"61653.jpg\",\"77377.jpg\",\"34013.jpg\",\"66353.jpg\"]', 'Tennis Verde', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:49:55'),
(57, 23, 'gallery', '[\"38033.jpg\",\"97518.jpg\",\"79550.jpg\",\"41346.jpg\",\"98179.jpg\"]', 'Tennis Azul', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:50:12'),
(58, 24, 'gallery', '[\"82088.jpg\",\"45600.jpg\"]', 'Calzado masculino', 100, 200, '150', '0000-00-00', 100, '2023-08-03', '2023-08-30 20:50:24'),
(77, 43, 'gallery', '[\"72409.jpg\"]', 'Collar', 10, 0, '0', '0000-00-00', 100, '2023-08-08', '2023-08-30 20:52:05'),
(78, 44, 'gallery', '[\"36094.jpg\"]', 'Maleta Gris', 10, 0, '0', '0000-00-00', 100, '2023-08-08', '2023-08-30 20:52:09'),
(79, 45, 'gallery', '[\"51340.jpg\"]', 'Maleta Verde', 10, 0, '0', '0000-00-00', 100, '2023-08-08', '2023-08-30 20:52:10'),
(80, 46, 'gallery', '[\"72980.jpg\"]', 'Anillo', 10, 0, '0', '0000-00-00', 100, '2023-08-08', '2023-08-30 20:52:12'),
(81, 47, 'gallery', '[\"19474.jpg\"]', 'sdfsdf', 7, 8, '9', '2025-06-10', 9, '2025-06-20', '2025-06-20 07:50:36'),
(82, 48, 'gallery', '[\"61967.jpg\"]', 'sdfsdf', 2, 4, '5', '2025-06-03', 55, '2025-06-20', '2025-06-20 08:01:45'),
(83, 49, 'gallery', '[\"82047.jpg\"]', 'sdfsdf', 23, 4, '5', '2025-06-18', 3, '2025-06-20', '2025-06-20 08:57:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visits`
--

CREATE TABLE `visits` (
  `id_visit` int(11) NOT NULL,
  `ip_visit` text DEFAULT NULL,
  `country_visit` text DEFAULT NULL,
  `region_visit` text DEFAULT NULL,
  `city_visit` text DEFAULT NULL,
  `date_created_visit` date DEFAULT NULL,
  `date_updated_visit` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `visits`
--

INSERT INTO `visits` (`id_visit`, `ip_visit`, `country_visit`, `region_visit`, `city_visit`, `date_created_visit`, `date_updated_visit`) VALUES
(1, '181.132.146.224', 'Colombia', 'Antioquia', 'Envigado', '2024-05-20', '2024-05-27 22:24:07'),
(2, '101.44.176.0', 'Mexico', 'Mexico City', 'Mexico City', '2024-05-27', '2024-05-27 15:45:44'),
(3, '102.177.160.0', 'Ecuador', 'Pichincha', 'Quito', '2024-05-27', '2024-05-27 15:46:08'),
(4, '102.38.204.0', 'Peru', 'Lima Province', 'Lima', '2024-05-27', '2024-05-27 15:46:26'),
(5, '1.178.48.0', 'Argentina', 'Buenos Aires', 'Buenos Aires', '2024-05-27', '2024-05-27 15:46:46'),
(6, '102.217.238.0', 'Colombia', 'Bogota D.C.', 'Bogotá', '2024-05-27', '2024-05-27 15:47:02'),
(7, '102.38.236.0', 'Ecuador', 'Pichincha', 'Quito', '2024-05-27', '2024-05-27 15:47:54'),
(8, '103.14.26.255', 'Mexico', 'Mexico City', 'Mexico City', '2024-05-27', '2024-05-27 15:48:56'),
(9, '104.106.95.255', 'Peru', 'Lima Province', 'Lima', '2024-05-27', '2024-05-27 15:49:28'),
(10, '102.217.237.255', 'Argentina', 'Buenos Aires F.D.', 'Buenos Aires', '2024-05-27', '2024-05-27 15:49:45'),
(11, '103.219.169.255', 'Colombia', 'Bogota D.C.', 'Bogota D.C.', '2024-05-27', '2024-05-27 15:49:56'),
(12, '1.178.255.255', 'Spain', 'Castellon', 'Torreblanca', '2024-05-27', '2024-05-27 15:55:20'),
(13, '181.132.146.224', 'Colombia', 'Antioquia', 'Envigado', '2024-05-27', '2024-05-27 22:24:33'),
(14, '190.144.218.193', 'Colombia', 'Bogota D.C.', 'Bogotá', '2024-05-27', '2024-05-28 00:27:52'),
(15, '40.77.167.73', 'United States', 'Virginia', 'Boydton', '2024-05-27', '2024-05-28 00:43:01'),
(16, '52.167.144.186', 'United States', 'Virginia', 'Boydton', '2024-05-28', '2024-05-28 05:03:56'),
(17, '181.132.146.224', 'Colombia', 'Antioquia', 'Envigado', '2024-05-28', '2024-05-28 14:03:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indices de la tabla `boletas_electronicas`
--
ALTER TABLE `boletas_electronicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id_favorite`),
  ADD KEY `id_product_favorite` (`id_product_favorite`),
  ADD KEY `id_user_favorite` (`id_user_favorite`);

--
-- Indices de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_caja` (`id_caja`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_variant_order` (`id_variant_order`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category_product` (`id_category_product`),
  ADD KEY `id_subcategory_product` (`id_subcategory_product`),
  ADD KEY `fk_products_provider` (`provider_id`);

--
-- Indices de la tabla `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id_slide`);

--
-- Indices de la tabla `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id_social`);

--
-- Indices de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id_subcategory`),
  ADD KEY `id_category_subcategory` (`id_category_subcategory`);

--
-- Indices de la tabla `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id_template`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id_variant`),
  ADD KEY `id_product_variant` (`id_product_variant`);

--
-- Indices de la tabla `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id_visit`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `banners`
--
ALTER TABLE `banners`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `boletas_electronicas`
--
ALTER TABLE `boletas_electronicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carts`
--
ALTER TABLE `carts`
  MODIFY `id_cart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `credit_notes`
--
ALTER TABLE `credit_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id_favorite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `slides`
--
ALTER TABLE `slides`
  MODIFY `id_slide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `socials`
--
ALTER TABLE `socials`
  MODIFY `id_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id_subcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `templates`
--
ALTER TABLE `templates`
  MODIFY `id_template` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `variants`
--
ALTER TABLE `variants`
  MODIFY `id_variant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `visits`
--
ALTER TABLE `visits`
  MODIFY `id_visit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `credit_notes`
--
ALTER TABLE `credit_notes`
  ADD CONSTRAINT `credit_notes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `credit_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`id_product_favorite`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`id_user_favorite`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD CONSTRAINT `movimientos_caja_ibfk_1` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_variant_order`) REFERENCES `variants` (`id_variant`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_provider` FOREIGN KEY (`provider_id`) REFERENCES `providers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category_product`) REFERENCES `categories` (`id_category`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_subcategory_product`) REFERENCES `subcategories` (`id_subcategory`);

--
-- Filtros para la tabla `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD CONSTRAINT `product_purchases_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_product`);

--
-- Filtros para la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`id_category_subcategory`) REFERENCES `categories` (`id_category`);

--
-- Filtros para la tabla `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`id_product_variant`) REFERENCES `products` (`id_product`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
