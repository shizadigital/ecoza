-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jan 2020 pada 08.49
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memo_framework`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_ads`
--

CREATE TABLE `memo_ads` (
  `adsId` int(11) UNSIGNED NOT NULL,
  `adposId` int(11) UNSIGNED NOT NULL,
  `adsJudul` varchar(150) NOT NULL,
  `adsUrlTujuan` varchar(255) NOT NULL,
  `adsDeskripsi` text NOT NULL,
  `adsType` varchar(20) NOT NULL,
  `adsCode` text NOT NULL,
  `adsImg` text NOT NULL,
  `adsSwf` text NOT NULL,
  `adsDirFile` varchar(25) NOT NULL,
  `adsStartDate` date NOT NULL,
  `adsEndDate` date NOT NULL,
  `adsTerbit` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_ads_posisi`
--

CREATE TABLE `memo_ads_posisi` (
  `adposId` int(11) UNSIGNED NOT NULL,
  `adposNama` varchar(255) NOT NULL,
  `adposW` int(10) UNSIGNED NOT NULL,
  `adposH` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_ads_posisi`
--

INSERT INTO `memo_ads_posisi` (`adposId`, `adposNama`, `adposW`, `adposH`) VALUES
(1, 'header', 650, 90),
(2, 'headline_bottom', 1000, 90),
(3, 'left_1', 250, 250),
(4, 'left_2', 250, 250),
(5, 'left_3', 250, 250),
(6, 'left_4', 250, 250),
(7, 'left_5', 250, 250),
(8, 'left_6', 250, 250),
(9, 'center_main_1', 630, 90),
(10, 'center_main_2', 630, 90),
(11, 'center_main_3', 630, 90),
(12, 'center_main_4', 630, 90),
(13, 'center_main_5', 630, 90),
(14, 'center_main_6', 630, 90),
(15, 'right_1', 300, 250),
(16, 'right_2', 300, 250),
(17, 'right_3', 300, 250),
(18, 'right_4', 300, 250),
(19, 'right_5', 300, 250),
(20, 'right_6', 300, 250);

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_android_device`
--

CREATE TABLE `memo_android_device` (
  `devId` int(10) UNSIGNED NOT NULL,
  `devAndroidId` varchar(35) NOT NULL,
  `devAccountId` int(10) UNSIGNED NOT NULL,
  `devAccountType` varchar(25) NOT NULL,
  `devRegId` varchar(255) NOT NULL,
  `devIMEI` varchar(35) NOT NULL,
  `devName` varchar(255) NOT NULL,
  `devStatus` enum('on','off') NOT NULL,
  `devSIMSerial` varchar(30) NOT NULL,
  `devLog` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_badge`
--

CREATE TABLE `memo_badge` (
  `badgeId` int(11) UNSIGNED NOT NULL,
  `badgeLabel` varchar(60) NOT NULL,
  `badgeDesc` text NOT NULL,
  `badgeType` varchar(50) NOT NULL,
  `badgeDir` varchar(25) NOT NULL,
  `badgePic` varchar(255) NOT NULL,
  `badgeAktif` int(3) UNSIGNED NOT NULL,
  `badgeDeleted` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_badge_relasi`
--

CREATE TABLE `memo_badge_relasi` (
  `bdgrelId` int(10) UNSIGNED NOT NULL,
  `bdgrelType` varchar(50) NOT NULL,
  `badgeId` int(10) UNSIGNED NOT NULL,
  `relationId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_badge_relasi`
--

INSERT INTO `memo_badge_relasi` (`bdgrelId`, `bdgrelType`, `badgeId`, `relationId`) VALUES
(1, 'product', 0, 2),
(7, 'product', 0, 6),
(9, 'product', 0, 4),
(10, 'product', 0, 1),
(11, 'product', 0, 9),
(12, 'product', 0, 8),
(13, 'product', 0, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_cron_list`
--

CREATE TABLE `memo_cron_list` (
  `cronId` int(10) UNSIGNED NOT NULL,
  `cronName` varchar(50) NOT NULL,
  `cronData` text NOT NULL,
  `cronDesc` varchar(255) NOT NULL,
  `cronDirModule` text NOT NULL,
  `cronLastAct` int(10) UNSIGNED NOT NULL,
  `cronReport` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_cron_list`
--

INSERT INTO `memo_cron_list` (`cronId`, `cronName`, `cronData`, `cronDesc`, `cronDirModule`, `cronLastAct`, `cronReport`) VALUES
(1, 'BACKUP_DATABASE', '', '', 'mod_backup_db/cron_backup.php', 1565809203, ''),
(2, 'SPAM_REMOVE', '', 'Penghapusan komentar yang ditandai spam', 'mod_komentar/cron_spam_removing.php', 1565766002, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_dynamic_translations`
--

CREATE TABLE `memo_dynamic_translations` (
  `dtId` int(11) UNSIGNED NOT NULL,
  `dtRelatedTable` varchar(20) NOT NULL COMMENT 'Table name without prefix table',
  `dtRelatedField` varchar(20) NOT NULL COMMENT 'Field table',
  `dtRelatedId` int(11) UNSIGNED NOT NULL COMMENT 'Related ID',
  `dtLang` varchar(10) NOT NULL,
  `dtTranslation` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dtInputType` enum('text','textarea','texteditor') NOT NULL,
  `dtCreateDate` int(11) UNSIGNED NOT NULL,
  `dtUpdateDate` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_dynamic_translations`
--

INSERT INTO `memo_dynamic_translations` (`dtId`, `dtRelatedTable`, `dtRelatedField`, `dtRelatedId`, `dtLang`, `dtTranslation`, `dtInputType`, `dtCreateDate`, `dtUpdateDate`) VALUES
(1, 'users_menu', 'menuName', 1, 'en_US', 'Post Management', 'text', 1545593132, 1545603426),
(2, 'users_menu', 'menuName', 2, 'en_US', 'Post', 'text', 1545417843, 1545663283),
(3, 'users_menu', 'menuName', 3, 'en_US', 'Categories', 'text', 1545594094, 1545594094),
(4, 'users_menu', 'menuName', 45, 'en_US', 'Content', 'text', 1545594130, 1545594130),
(5, 'users_menu', 'menuName', 5, 'en_US', 'Pages', 'text', 1545594184, 1545594184),
(6, 'users_menu', 'menuName', 44, 'en_US', 'Additional Content', 'text', 1545594217, 1545594217),
(7, 'users_menu', 'menuName', 43, 'en_US', 'Pop UP', 'text', 1545594470, 1545594470),
(8, 'users_menu', 'menuName', 37, 'en_US', 'Slider', 'text', 1545594529, 1545594529),
(9, 'users_menu', 'menuName', 6, 'en_US', 'Images Gallery', 'text', 1545594567, 1545594567),
(10, 'users_menu', 'menuName', 7, 'en_US', 'Gallery', 'text', 1545594591, 1545594591),
(11, 'users_menu', 'menuName', 8, 'en_US', 'Gallery Categories', 'text', 1545594626, 1545594626),
(12, 'users_menu', 'menuName', 4, 'en_US', 'Comments', 'text', 1545594654, 1545594654),
(13, 'users_menu', 'menuName', 9, 'en_US', 'Ads Banner', 'text', 1545594695, 1545594695),
(14, 'users_menu', 'menuName', 10, 'en_US', 'Statistics', 'text', 1545594739, 1545594739),
(15, 'users_menu', 'menuName', 24, 'en_US', 'Messages', 'text', 1545594771, 1545594771),
(16, 'users_menu', 'menuName', 14, 'en_US', 'Settings', 'text', 1545594812, 1545594812),
(17, 'users_menu', 'menuName', 46, 'en_US', 'Website Menu', 'text', 1545594830, 1545594830),
(18, 'users_menu', 'menuName', 15, 'en_US', 'Manage Site', 'text', 1545594879, 1545594879),
(19, 'users_menu', 'menuName', 16, 'en_US', 'My Account', 'text', 1545594904, 1545594904),
(20, 'users_menu', 'menuName', 47, 'en_US', 'URL Links', 'text', 1545594936, 1545594936),
(21, 'users_menu', 'menuName', 25, 'en_US', 'Users', 'text', 1545594958, 1545594958),
(22, 'users_menu', 'menuName', 26, 'en_US', 'All Users', 'text', 1545595025, 1545595025),
(23, 'users_menu', 'menuName', 27, 'en_US', 'User Accesses', 'text', 1545595126, 1545595126),
(24, 'users_menu', 'menuName', 30, 'en_US', 'Utilities', 'text', 1545595162, 1545595162),
(25, 'users_menu', 'menuName', 39, 'en_US', 'Email Templates', 'text', 1545595203, 1545595203),
(26, 'users_menu', 'menuName', 29, 'en_US', 'Database Backup', 'text', 1545595244, 1545595244),
(27, 'users_menu', 'menuName', 31, 'en_US', 'Cron List', 'text', 1545595292, 1545595292),
(28, 'users_menu', 'menuName', 17, 'en_US', 'Developer Settings', 'text', 1545595328, 1545595328),
(29, 'users_menu', 'menuName', 20, 'en_US', 'Admin Modules', 'text', 1545595379, 1545595379),
(30, 'users_menu', 'menuName', 18, 'en_US', 'Admin Module Master', 'text', 1545595763, 1545595763),
(31, 'users_menu', 'menuName', 23, 'en_US', 'Admin Module Access', 'text', 1545595804, 1545595804),
(32, 'users_menu', 'menuName', 21, 'en_US', 'Admin Menus', 'text', 1545595829, 1545595845),
(33, 'users_menu', 'menuName', 19, 'en_US', 'Admin Menu Master', 'text', 1545595869, 1545595869),
(34, 'users_menu', 'menuName', 22, 'en_US', 'Admin Menu Access', 'text', 1545595893, 1545595893),
(35, 'users_module', 'modName', 1, 'en_US', 'Post', 'text', 1545675001, 1545675001),
(36, 'users_module', 'modName', 2, 'en_US', 'Categories', 'text', 1545675133, 1545675133),
(37, 'users_module', 'modName', 3, 'en_US', 'Comments', 'text', 1545675238, 1545675238),
(38, 'users_module', 'modName', 4, 'en_US', 'Pages', 'text', 1545675252, 1545675252),
(39, 'users_module', 'modName', 5, 'en_US', 'Gallery', 'text', 1545675269, 1545675269),
(40, 'users_module', 'modName', 6, 'en_US', 'Gallery Categories', 'text', 1545675294, 1545675294),
(41, 'users_module', 'modName', 7, 'en_US', 'Ads Banner', 'text', 1545675315, 1545675315),
(42, 'users_module', 'modName', 8, 'en_US', 'Visitor Statistics', 'text', 1545675336, 1545675737),
(43, 'users_module', 'modName', 11, 'en_US', 'Manage Web', 'text', 1545675780, 1545675780),
(44, 'users_module', 'modName', 12, 'en_US', 'Admin Menu Master', 'text', 1545675802, 1545675821),
(45, 'users_module', 'modName', 13, 'en_US', 'Admin Module Master', 'text', 1545675873, 1545676842),
(46, 'users_module', 'modName', 14, 'en_US', 'Admin Module Access', 'text', 1545676956, 1545676956),
(47, 'users_module', 'modName', 15, 'en_US', 'Account', 'text', 1545676985, 1545676985),
(48, 'users_module', 'modName', 16, 'en_US', 'Messages', 'text', 1545677007, 1545677007),
(49, 'users_module', 'modName', 17, 'en_US', 'Admin Menu Access', 'text', 1545677035, 1545677035),
(50, 'users_module', 'modName', 18, 'en_US', 'All Users', 'text', 1545677058, 1545677058),
(51, 'users_module', 'modName', 19, 'en_US', 'User Accesses', 'text', 1545677091, 1545677091),
(52, 'users_module', 'modName', 20, 'en_US', 'Database Backup', 'text', 1545677120, 1545677120),
(53, 'users_module', 'modName', 21, 'en_US', 'Cron List', 'text', 1545677152, 1545677163),
(54, 'users_module', 'modName', 26, 'en_US', 'Slider', 'text', 1545677180, 1545677180),
(55, 'users_module', 'modName', 28, 'en_US', 'Email Template', 'text', 1545677397, 1545677397),
(56, 'users_module', 'modName', 31, 'en_US', 'Pop Up', 'text', 1545677459, 1545677459),
(57, 'users_module', 'modName', 32, 'en_US', 'Additional Content', 'text', 1545677502, 1545677502),
(58, 'users_module', 'modName', 33, 'en_US', 'Website Menu', 'text', 1545677526, 1545677532),
(59, 'users_module', 'modName', 34, 'en_US', 'URL Links', 'text', 1545677732, 1545677732),
(60, 'users_module', 'modName', 35, 'en_US', 'File Manager', 'text', 1560323257, 1560323257),
(61, 'users_menu', 'menuName', 48, 'en_US', 'File Manager', 'text', 1560325369, 1560325369),
(62, 'users_menu', 'menuName', 49, 'en_US', 'System Info', 'text', 1560626040, 1560626040),
(63, 'menu_website', 'menuName', 9, 'en_US', 'News', 'text', 1561919048, 1561919048);

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_email_queue`
--

CREATE TABLE `memo_email_queue` (
  `emailId` int(10) UNSIGNED NOT NULL,
  `emailTo` varchar(50) NOT NULL,
  `emailSubject` varchar(255) NOT NULL,
  `emailMsg` mediumtext DEFAULT NULL,
  `emailMsgType` enum('text','html') NOT NULL,
  `emailHead` varchar(255) NOT NULL,
  `emailDate` int(10) UNSIGNED NOT NULL,
  `emailDateSent` int(10) UNSIGNED NOT NULL,
  `emailStatus` char(1) NOT NULL,
  `emailAttachDir` char(8) DEFAULT NULL,
  `emailAttachFile` varchar(255) DEFAULT NULL,
  `emailAttachType` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_email_template`
--

CREATE TABLE `memo_email_template` (
  `tId` int(10) UNSIGNED NOT NULL,
  `tName` varchar(255) NOT NULL,
  `tEmail` mediumtext NOT NULL,
  `tEmailbak` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_email_template`
--

INSERT INTO `memo_email_template` (`tId`, `tName`, `tEmail`, `tEmailbak`) VALUES
(1, 'Customer - Informasi Pembayaran', '<p>Bapak/Ibu {MEMBERNAME},<br />\r\nDengan Hormat , Kami menerima pesanaan Poin dengan Nomor Invoice {INVOICE}.<br />\r\n------------------------------------------------------------<br />\r\nLakukan pembayaran senilai {GRANDTOTAL} ke salah satu rekening:<br />\r\n<br />\r\n{BANK}<br />\r\n------------------------------------------------------------<br />\r\nAgar poin anda cepat diproses, konfirmasi pembayaran anda via sms/email.</p>\r\n\r\n<p>Ke:</p>\r\n\r\n<p>{SYSTEMMAIL}</p>\r\n\r\n<p>{SYSTEMPHONE}</p>\r\n\r\n<p><br />\r\nPembayaran harus sesuai dengan yang tertera: {GRANDTOTAL} (Tidak dibulatkan).<br />\r\nJika harus dibulatkan, informasikan ke kami melalui SMS/EMAIL, atau tulis pada kolom keterangan : {INVOICE} saat melakukan konfirmasi.<br />\r\n<br />\r\nTerima kasih atas kepercayaan anda pada {SYSTEMNAME}<br />\r\n<br />\r\n{SIGNATURE}<br />\r\n<br />\r\n<br />\r\nDETAIL ORDER:<br />\r\n<br />\r\nCustomer Name : {MEMBERNAME}<br />\r\nEmail : {MEMBEREMAIL}<br />\r\nMobile Phone : {MEMBERTEL}<br />\r\nOrder Date : {ORDERDATE}<br />\r\n<br />\r\nYour order:<br />\r\n<br />\r\n{ORDERPOINTDETAIL}<br />\r\n<br />\r\nDetail Pembayaran:<br />\r\nKode Transaksi: {CODEID}<br />\r\nTotal: {ORDERTOTAL}<br />\r\n----------------------------------------<br />\r\nGrand Total : {GRANDTOTAL}</p>\r\n', 'Mr/Mrs/Miss {MEMBERNAME}, <br /><span lang=\"en\">Dear Sirs , We have received your order with invoice numbers</span>&nbsp;{INVOICE}. <br />------------------------------------------------------------ <br /><span lang=\"en\">Please make a payment of</span>&nbsp;{GRANDTOTAL} <span lang=\"en\">to one of the accounts</span>:<br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br /><span lang=\"en\">In order to your order can be processed and delivered faster, confirm your payment via SMS/Email</span>. <br />Confirm your order via menu order and click the <strong>order confirmation</strong> button on the order that you have paid.<br /><br /><span lang=\"en\">We hope you make a payment according to the total</span>&nbsp;{GRANDTOTAL} (<span lang=\"en\">unrounded</span>). <br /><span lang=\"en\">If it should be rounded</span>,&nbsp;<span lang=\"en\">please inform us via SMS or email,</span> or write information coloumn at: {INVOICE} <br /><br /><span lang=\"en\">Payments received no later than</span>: {ORDEREXP} <br /><span lang=\"en\">After we receive your payment, your order will be handling and we will send it .</span>&nbsp;<br /><span lang=\"en\">Receipt number will be informed via email after we send the package so that you can tracking.</span>&nbsp;<br /><br /><span lang=\"en\">To cancel this order , click the <strong>Cancel</strong> button in the order you want to cancel. </span><br /><br /><span lang=\"en\">Thank you for shopping at</span>&nbsp;{SITEURL} <br /><br />{SIGNATURE} <br /><br /><br />DETAIL ORDER: <br /><br />Customer Name : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Mobile Phone : {MEMBERTEL} <br />Order Date : {ORDERDATE} <br /><br />Your order: <br /><br />{ORDERDETAIL} <br /><br /><br />Your order will be sent to: <br />{MEMBERRECNAME} <br />{MEMBERADD} <br />{MEMBERTOWN} <br /><br />Shipping Method : {SHIPMETHOD} <br />Special Info : {MEMBERMSG} <br /><br />Detail Cost<br />Subtotal : {SUBTOTAL} <br />Tax({TAX}%) : {TAXAMOUNT} <br />Discount: {DISCOUNT} <br />Transaction Code: {CODEID} <br />Shipping Cost : {SHIPPRICE} <br />Shipping Cost Discount: {DISCOUNTSHIP} <br />---------------------------------------- <br />Grand Total : {GRANDTOTAL}'),
(2, 'Order Reminder', 'Mr/Mrs/Miss {MEMBERNAME},<br />Dear Sir,<br /><span lang=\"en\">This email is a reminder of your order with an invoice number</span>&nbsp;{INVOICE}.<br />&nbsp;------------------------------------------------------------ <br /><br />Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts: <br /><br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br />Your order details can be seen at the bottom of this email or click here:<br />{VERIFYCODE}<br />In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />Confirm yout order from the following link:<br />{ORDERCONFIRMATION}<br />We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br /><br />Payments received no later than: {ORDEREXP}<br />After we receive your payment, your order will be handling and we will send it . <br />Receipt number will be informed via email after we send the package so that you can tracking. <br /><br /><br />Thank you for shopping at {SITEURL}<br /><br />{SIGNATURE}', 'Mr/Mrs/Miss {MEMBERNAME},<br />Dear Sir,<br /><span lang=\"en\">This email is a reminder of your order with an invoice number</span>&nbsp;{INVOICE}.<br />&nbsp;------------------------------------------------------------ <br /><br />Please make a payment of&nbsp;{GRANDTOTAL},- o one of the accounts: <br /><br />{STORERECNAME} <br /><br />------------------------------------------------------------ <br />Your order details can be seen at the bottom of this email or click here:<br />{VERIFYCODE}<br />In order to your order can be processed and delivered faster, confirm your payment via SMS/Email.<br />Confirm yout order from the following link:<br />{ORDERCONFIRMATION}<br />We hope you make a payment according to the total {GRANDTOTAL} (unrounded).<br />If it should be rounded, please inform us via SMS or email, or write information coloumn at: {INVOICE}<br /><br />Payments received no later than: {ORDEREXP}<br />After we receive your payment, your order will be handling and we will send it . <br />Receipt number will be informed via email after we send the package so that you can tracking. <br /><br /><br />Thank you for shopping at {SITEURL}<br /><br />{SIGNATURE}'),
(4, 'Payment Received', 'Mr/Mrs/Ms {MEMBERNAME}, <br />With respect, <br /><br />We would like to inform you that your payment for the invoice number {INVOICE} has been received <br />on {CHECKRECDATE}. We have checked our account and with this fully ensure that your payment has been received. <br /><br />We are currently preparing the products you ordered and will be sent as soon as possible. <br />If your order has been sent, we will re-send email notifications.<br /><br />Thank you for payments you make and of course on your TRUST in&nbsp;{SITEURL}. <br /><br />{SIGNATURE}', 'Mr/Mrs/Ms {MEMBERNAME}, <br />With respect, <br /><br />We would like to inform you that your payment for the invoice number {INVOICE} has been received <br />on {CHECKRECDATE}. We have checked our account and with this fully ensure that your payment has been received. <br /><br />We are currently preparing the products you ordered and will be sent as soon as possible. <br />If your order has been sent, we will re-send email notifications.<br /><br />Thank you for payments you make and of course on your TRUST in&nbsp;{SITEURL}. <br /><br />{SIGNATURE}'),
(5, 'Package Delivery Information', 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform you that your order in {SITEURL} has been processed. Products that we have sent you a message with the following information: <br />{SENTINFO} <br />{DIGITALPRODUCTLINK} <br /><br />Please inform us as soon as the order is received. Call us back if you have not received your order until the deadline. <br /><br />- <span id=\"result_box\" lang=\"en\"><span class=\"hps\">If</span> <span class=\"hps\">you are satisfied</span> <span class=\"hps\">with</span> <span class=\"hps\">our service and products</span><span>,</span> <span class=\"hps\">please</span> <span class=\"hps\">write</span> <span class=\"hps\">a testimonial</span> <span class=\"hps\">to</span> <span class=\"hps\">reply to</span> <span class=\"hps\">this email</span></span>. <br />- If you are not satisfied, submit your complaint. Your complaint must be delivered within max 1 week from when the order is received. <br /><br />Thanks for the order and the trust to us! <br /><br /><br />{SIGNATURE}', 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform you that your order in {SITEURL} has been processed. Products that we have sent you a message with the following information: <br />{SENTINFO} <br />{DIGITALPRODUCTLINK} <br /><br />Please inform us as soon as the order is received. Call us back if you have not received your order until the deadline. <br /><br />- <span id=\"result_box\" lang=\"en\"><span class=\"hps\">If</span> <span class=\"hps\">you are satisfied</span> <span class=\"hps\">with</span> <span class=\"hps\">our service and products</span><span>,</span> <span class=\"hps\">please</span> <span class=\"hps\">write</span> <span class=\"hps\">a testimonial</span> <span class=\"hps\">to</span> <span class=\"hps\">reply to</span> <span class=\"hps\">this email</span></span>. <br />- If you are not satisfied, submit your complaint. Your complaint must be delivered within max 1 week from when the order is received. <br /><br />Thanks for the order and the trust to us! <br /><br /><br />{SIGNATURE}'),
(7, 'Order Delete', 'Mr/Mrs/Ms {MEMBERNAME}, <br />With Respect, <br /><br />We would like to inform that your order invoice number&nbsp;{INVOICE} has abort. The reason for cancellation due to one of the following reasons:<br />- You do not transfer until the payment due.<br />- Email data or the address you provide is invalid. <br />- You order two times or more.<br />-&nbsp;The other reason. <br /><br />You can order the products you ordered back to visit our website at&nbsp;{SITEURL} . <br />We beg your understanding on this matter and apologize if it has caused inconvenience. <br />Thank you for your attention.<br /><br /><br />{SIGNATURE}', 'Bapak/Ibu {MEMBERNAME}, \r\nDengan hormat, \r\n\r\nKami ingin menginformasikan bahwa pesanan Anda dengan nomor invoice {INVOICE} telah kami batalkan.\r\n Alasan pembatalan karena salah satu sebab berikut ini:\r\n\r\n - Anda tidak melakukan transfer sampai batas waktu pembayaran. \r\n - Data email atau alamat yang Anda berikan tidak valid.\r\n - Anda memesan 2 kali atau lebih.\r\n - Alasan lainnya.\r\n\r\nAnda dapat memesan kembali produk yang Anda pesan dengan mengunjungi website kami di {SITEURL}	.\r\nKami memohon pengertian dari Bapak/Ibu atas hal ini dan memohon maaf jika telah menimbulkan ketidaknyamanan.\r\nTerima kasih atas perhatian Anda!\r\n\r\n{SIGNATURE}'),
(9, 'Payment Confirmation', 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}', 'The customer informs that a payment the following data have been paid: <br /><br />Number of Invoice : {INVOICE} <br />Nama : {MEMBERNAME} <br />Email : {MEMBEREMAIL} <br />Transfer To : {PAYMENTBANK} <br />Nominal : {TRANSFERAMOUNT} <br />Transfer Date : {TRANSFERDATE} <br /><br />Information: {NOTES} <br /><br /><br />{SIGNATURE}'),
(10, 'Customer - Verify Email Change', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\n	<tbody>\n		<tr>\n			<td>{HEADER}</td>\n		</tr>\n		<tr>\n			<td>\n			<p>Dear Bapak/Ibu {MEMBERNAME},<br />\n			<br />\n			Anda telah melakukan permintaan perubahan alamat email anda di {SYSTEMNAME}.<br />\n			Verify your email by clicking this link :<br />\n			<br />\n			{EMAILCHANGEVERIFYURL}<br />\n			<br />\n			(Copy and paste the link above into your browser if it can not click)<br />\n			<br />\n			Thank You.</p>\n\n			<p><strong>Abaikan email ini jika anda tidak merasa melakukan aktifitas ini</strong>.</p>\n			</td>\n		</tr>\n		<tr>\n			<td>{SIGNATURE}</td>\n		</tr>\n	</tbody>\n</table>\n', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td>Dear,<br /><br /><span lang=\"en\">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang=\"en\">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang=\"en\">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(11, 'Member - Verifikasi Email (Welcome)', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p><br />\r\n			Anda telah bergabung di {SYSTEMNAME}.<br />\r\n			Silahkan verifikasi akun anda dengan meng-klik link dibawah ini agar anda dapat masuk ke sistem kami:<br />\r\n			<br />\r\n			<a href=\"{VERIFYLINK}\">{VERIFYLINK}</a><br />\r\n			<br />\r\n			(Copy paste link jika tidak bisa diklik)</p>\r\n\r\n			<p>Terima kasih.<br />\r\n			&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\n	<tbody>\n		<tr>\n			<td>{HEADER}</td>\n		</tr>\n		<tr>\n			<td>With respect,<br />\n			<br />\n			Thanks for joining us on {SYSTEMNAME}.<br />\n			Verify your email by clicking this link :<br />\n			<br />\n			<a href=\"{VERIFYLINK}\">{VERIFYLINK}</a><br />\n			<br />\n			(Copy and paste the link above into your browser if it can not click)<br />\n			<br />\n			This link will expire within 1 hour. You can request verification email on customer area.<br />\n			&nbsp;</td>\n		</tr>\n		<tr>\n			<td>{SIGNATURE}</td>\n		</tr>\n	</tbody>\n</table>\n'),
(12, 'Customer - Reset Password', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}</td>\n</tr>\n<tr>\n<td>Mr/Mrs/Ms {CUSTOMERNAME}, <br /> With respect, <br /><br /> Your password has been successfully changed. <br /> From now on, you have to log in using your email and your new password. <br /><br /> Thank You. <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td>Mr/Mrs/Ms {CUSTOMERNAME},<br /><span id=\"result_box\" class=\"short_text\" lang=\"en\"><span class=\"hps\">With</span> <span class=\"hps\">respect</span></span>,<br /><br /> <span lang=\"en\">Your password has been successfully changed.</span><br /><span lang=\"en\">From now on, you have to log in using your email and your new password.</span><br /><br /> Thank You. <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(13, 'Customer - Selamat Datang (Admin)', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Bapak/Ibu {MEMBERNAME},<br />\r\n			<br />\r\n			Terima kasih telah mendaftar di {SYSTEMNAME}.<br />\r\n			Silahkan set password anda melalui link dibawah ini:<br />\r\n			{FORGOTPASSWORDLINK}<br />\r\n			<br />\r\n			(copy link diatas ke browser jika tidak bisa di klik)<br />\r\n			<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {FORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(15, 'Supplier - Welcome', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>With respect, <br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Click the link below to login: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> (Copy and paste the link above into your browser if it can not click) <br /><br /> You can reset your password via FORGOT PASSWORD features. <br /><br /> Terima kasih. <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(16, 'Customer - Forgot Password', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Bapak/Ibu {MEMBERNAME},<br />\r\n			Dengan hormat,<br />\r\n			<br />\r\n			Anda atau orang lain telah melakukan permintaan reset password melalui fitur LUPA PASSWORD.<br />\r\n			Jika anda ingin benar-benar melakukan reset password, klik link dibawah ini:<br />\r\n			<br />\r\n			{FORGOTPASSWORDLINK}<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td>Bapak/Ibu {MEMBERNAME},<br /> Dengan hormat,<br /><br /> Anda atau seseorang telah melakukan request untuk melakukan reset password melalui fasilitas LUPA PASSWORD.<br />Password anda yang lama belum berubah. Jika anda ingin melakukan reset, lakukan langkah berikut: <br /><br /> {FORGOTPASSWORDLINK} <br /><br />Jika link diatas tidak bisa di-klik, silahkan copy dan paste link ke browser anda. <br /><br /> Masa berlaku link ini hanya 60 Menit.<br /> Abaikan email ini jika anda tidak merasa pernah melakukan permohonan reset password.<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(18, 'Supplier - Forgot Password', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}</td>\n</tr>\n<tr>\n<td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td>Mr/Mrs/Ms {SUPPLIERNAME}, <br />With respect, <br /><br /> You or someone has done a request to reset the password through PASSWORD FORGOT facilities. <br /> Your old password has not been changed. If you want to do a reset, do the following: <br /><br /> {SUPPLIERFORGOTPASSWORDLINK} <br /><br /> If the link above does not work in clicking, please copy and paste the link into your browser. <br /><br /> This link will expire within 1 hour. Ignore this message if you did not have to do a password reset request. <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(19, 'Supplier - Verify Email Change', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}</td>\n</tr>\n<tr>\n<td>Dear,<br /><br /><span lang=\"en\">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang=\"en\">Verify your email by clicking this link :</span><br /><br /> {SUPPLIEREMAILCHANGEVERIFYURL} <br /><br />(<span lang=\"en\">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td>Dear,<br /><br /><span lang=\"en\">You have changed your email on </span>{SYSTEMNAME}. <br /> <span lang=\"en\">Verify your email by clicking this link :</span><br /><br /> {EMAILCHANGEVERIFYURL} <br /><br />(<span lang=\"en\">Copy and paste the link above into your browser if it can not click</span>) <br /><br /> Thank You.<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(20, 'Customer - Reset Password Sukses', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Bapak/Ibu {MEMBERNAME},<br />\r\n			Dengan Hormat,<br />\r\n			<br />\r\n			Password anda sukses diganti.<br />\r\n			Sekarang anda dapat login menggunakan password baru anda.<br />\r\n			<br />\r\n			Terima kasih.<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td>Bapak/Ibu {SUPPLIERNAME},<br />Dengan hormat,<br /><br /> Password anda telah berhasil diubah. <br /> Mulai saat ini, anda harus login menggunakan email dan password baru anda. Gunakan kembali fitur FORGOT PASSWORD jika anda kembali lupa password. <br /><br /> Terima kasih. <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(21, 'Supplier - Verify Email', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}</td>\n</tr>\n<tr>\n<td><span id=\"result_box\" class=\"short_text\" lang=\"en\"><span class=\"hps\">With</span> <span class=\"hps\">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang=\"en\">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang=\"en\">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td><span id=\"result_box\" class=\"short_text\" lang=\"en\"><span class=\"hps\">With</span> <span class=\"hps\">respect</span></span>,<br /><br /> Thanks for joining us on {SYSTEMNAME}. <br /> Verify your email by clicking this link : <br /><br /> {SUPPLIEREMAILVERIFYURL} <br /><br /> (<span lang=\"en\">Copy and paste the link above into your browser if it can not click</span>) <br /><br /><span lang=\"en\">This link will expire within 1 hour. You can request verification email on customer area.</span><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(22, 'Purchase Order Information to Supplier', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SUPPLIERNAME}, <br /><br /> You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>'),
(23, 'Quotation Information to Owner', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> You have a new quotation with article number {ARTICLENUMBER}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>'),
(24, 'Customer - Receipt', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\">\n<tbody>\n<tr>\n<td colspan=\"2\" align=\"center\">{HEADER}</td>\n</tr>\n<tr>\n<td colspan=\"2\" align=\"center\"><strong style=\"font-size: 24px;\">RECEIPT</strong><br /><br /></td>\n</tr>\n<tr>\n<td valign=\"top\" width=\"35%\">Number</td>\n<td valign=\"top\">:&nbsp;{KWITANSINUMBER}</td>\n</tr>\n<tr>\n<td valign=\"top\">Received From</td>\n<td valign=\"top\">:&nbsp;{MEMBERNAME}</td>\n</tr>\n<tr>\n<td valign=\"top\">In Payment for</td>\n<td>:&nbsp;</td>\n</tr>\n<tr>\n<td colspan=\"2\">{DETAILKWITANSI}</td>\n</tr>\n<tr>\n<td>Amount</td>\n<td>: {GRANDTOTAL}</td>\n</tr>\n<tr>\n<td colspan=\"2\">&nbsp;<br /><br /><br /></td>\n</tr>\n<tr>\n<td colspan=\"2\" align=\"left\"><hr />\n<div style=\"font-size: 10px; color: #999999;\">{ADDITIONALINFO}</div>\n</td>\n</tr>\n<tr>\n<td colspan=\"2\" align=\"left\">&nbsp;<br /><br />{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td colspan=\"2\" align=\"center\">{HEADER}</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"2\" align=\"center\"><strong style=\"font-size: 24px;\">RECEIPT</strong><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\" width=\"35%\"><em>Number</em></td>\r\n<td valign=\"top\">:&nbsp;{KWITANSINUMBER}</td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\"><em>Received From</em></td>\r\n<td valign=\"top\">:&nbsp;{MEMBERNAME}</td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\"><em>The SUM of</em></td>\r\n<td>:&nbsp;<em>{TERBILANG} Rupiah</em></td>\r\n</tr>\r\n<tr>\r\n<td valign=\"top\"><em>In Payment for</em></td>\r\n<td>:&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"2\">{DETAILKWITANSI}</td>\r\n</tr>\r\n<tr>\r\n<td><em>Amount</em></td>\r\n<td>:&nbsp;Rp {GRANDTOTAL}</td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"2\">&nbsp;<br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td colspan=\"2\" align=\"left\"><hr />\r\n<div style=\"font-size: 10px; color: #999999;\">{PAYMENTINFO}</div>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(26, 'Re-Order PO Information', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SUPPLIERNAME}, <br /><br /> You have re-order PO with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(27, 'Purchase Order Has Been Revised to Supplier', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SUPPLIERNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(28, 'Purchase Order Has Been Revised to Owner', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br />Purchase order has been revised by Owner with article number {ARTICLENUMBER}.<br />Please visit your supplier area: <br /><br /> {ADMINAREALINK} <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(29, 'Owner - New Custom Design Information', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> You have a new custom design from customer with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(30, 'Supplier - New Design Information', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(31, 'Reminder of approval new PO to Supplier', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(32, 'Reminder of approval new PO to Owner', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br />The system reminded You that You have a new purchase order with article number {ARTICLENUMBER}.<br />Please visit your supplier area:<br /><br /> {ADMINAREALINK} <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(33, 'Supplier - Approve New Design', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> You have an <strong>approved</strong> new design from {MEMBERNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(34, 'Supplier - Sending New Design', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> Your new design&nbsp;<strong>{DESIGNNAME}</strong> has been sending by {MEMBERNAME}.<strong><br /><br /></strong>Please check your admin area: <br /><br /> {ADMINAREALINK} <br /><br />thank you.<br /><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(35, 'Owner - Custom Design Deleted By Customer', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> One of a new custom design has been canceled by each customer with design name <strong>{DESIGNNAME}</strong>.<br /><br />Thank You.<br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br /> You have a new design from customer with design name {DESIGNNAME}.<br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(36, 'Owner - Pembayaran Order Poin Diterima', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Yang Terhormat {MEMBERNAME},<br />\r\n			<br />\r\n			Kami telah menerima pembayaran atas pesanan <strong>POIN</strong> anda dengan nomor invoice: #{INVOICE}</p>\r\n\r\n			<p>Secara otomaris poin anda telah ditambahkan.<br />\r\n			<br />\r\n			Terima kasih.<br />\r\n			<br />\r\n			&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(38, 'Supplier - Notification for create PO from Quotation', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SUPPLIERNAME}, <br /><br />We reminded You, that You have a new purchase order ({ARTICLENUMBER}) from quotation ({ARTICLENUMBER2}).<br /><br />Please visit your supplier area:<br /><br /> {SUPPLIERAREALINK} <br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(41, 'Owner - Inactive Customer', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} is in active. Because he did not shop more than 1 month<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(44, 'Owner - Customer is not Spending More than 2 Weeks', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {SYSTEMNAME}, <br /><br /> Customer with customer code {MEMBERCODE} and customer name {MEMBERNAME} did not shop more than 2 weeks.<br /><br />Please visit your admin area: <br /><br /> {ADMINAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(45, 'Owner - Quotation request from new design', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n<tbody>\n<tr>\n<td align=\"center\">{HEADER}<br /><br /></td>\n</tr>\n<tr>\n<td>Dear {MEMBERNAME}, <br /><br /> You have an <strong>requested</strong> quotation of new design from {SYSTEMNAME} with design name <strong>{DESIGNNAME}</strong>.<br />Please check your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br />thank you.<br /><br /><br /></td>\n</tr>\n<tr>\n<td>{SIGNATURE}</td>\n</tr>\n</tbody>\n</table>', '<table style=\"width: 800px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"center\">{HEADER}<br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>Dear {MEMBERNAME}, <br /><br /> You have a new design from {SYSTEMNAME} with design name {DESIGNNAME}.<br />Please visit your client area: <br /><br /> {SUPPLIERAREALINK} <br /><br /><br /></td>\r\n</tr>\r\n<tr>\r\n<td>{SIGNATURE}</td>\r\n</tr>\r\n</tbody>\r\n</table>'),
(46, 'Coba Email Template', '<p>Assalamualaikum Wr Wb Yaa</p>\r\n', '<p>Assalamualaikum Wr Wb</p>\r\n'),
(47, 'Email Customer Baru Dari Facebook', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Bapak/Ibu {MEMBERNAME},<br />\r\n			<br />\r\n			Terima kasih telah mendaftar di {SYSTEMNAME}.<br />\r\n			Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br />\r\n			<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Bapak/Ibu {MEMBERNAME},<br />\r\n			<br />\r\n			Terima kasih telah mendaftar di {SYSTEMNAME}.<br />\r\n			Kami senang Anda telah bergabung bersama kami. silahkan pilih menu masakan lezat dari kami<br />\r\n			<br />\r\n			&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n'),
(48, 'Pemberitahuan Pesan Baru', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Bapak/Ibu {MEMBERNAME},<br />\r\n			Dengan hormat,<br />\r\n			<br />\r\n			Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />\r\n			&nbsp;</p>\r\n\r\n			<p><a href=\"{INBOXANSWERLINK}\"><input name=\"Balas\" type=\"button\" value=\"Balas\" /></a></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:800px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>{HEADER}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Bapak/Ibu {MEMBERNAME},<br />\r\n			Dengan hormat,<br />\r\n			<br />\r\n			Anda menerima pesan baru dari {SENDER}, cek segera siapa tahu ada rezeki dari allah :)<br />\r\n			&nbsp;</p>\r\n\r\n			<p><input name=\"Balas\" type=\"button\" value=\"Balas\" /></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>{SIGNATURE}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_galeri_pic`
--

CREATE TABLE `memo_galeri_pic` (
  `galpicId` bigint(25) UNSIGNED NOT NULL,
  `kontenId` int(11) UNSIGNED NOT NULL,
  `galpicText` text NOT NULL,
  `galpicPicture` text NOT NULL,
  `galpicDir` varchar(25) NOT NULL,
  `galpicPhotographer` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_galeri_pic`
--

INSERT INTO `memo_galeri_pic` (`galpicId`, `kontenId`, `galpicText`, `galpicPicture`, `galpicDir`, `galpicPhotographer`) VALUES
(1, 63, 'text gal', '3c7ae2052016_bluetshirt.jpg', 'galeri_foto/052016', 'photographer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_kategori`
--

CREATE TABLE `memo_kategori` (
  `katId` int(11) UNSIGNED NOT NULL,
  `katNama` varchar(100) NOT NULL,
  `katSlug` varchar(255) NOT NULL,
  `katKeterangan` text NOT NULL,
  `katWarna` varchar(12) NOT NULL,
  `katAktif` int(3) UNSIGNED NOT NULL,
  `katType` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_kategori`
--

INSERT INTO `memo_kategori` (`katId`, `katNama`, `katSlug`, `katKeterangan`, `katWarna`, `katAktif`, `katType`) VALUES
(1, 'Menu Utama', '', 'primary', '', 1, 'webmenu'),
(2, 'Komputer', 'komputer', '', '#265ab7', 1, 'post'),
(3, 'Smartphone', 'smartphone', '', '#bc2020', 1, 'post'),
(4, 'Kamera', 'kamera', '', '#99b921', 1, 'post'),
(5, 'Artikel', 'artikel', '', '#353535', 1, 'post'),
(6, 'Internet', 'internet', '', '#9b27a8', 1, 'post'),
(7, 'Laptop', 'laptop', '', '#e59527', 1, 'post'),
(8, 'Software', 'software', '', '#d326b0', 1, 'post'),
(9, 'Hardware', 'hardware', '', '#7f4f0d', 1, 'post'),
(10, 'Tips dan Trik', 'tips-dan-trik', '', '#85b21e', 1, 'post'),
(11, 'Apa Itu?', 'apa-itu', '', '#c5ef07', 1, 'post'),
(12, 'Android', 'android', '', '#32b43d', 1, 'post'),
(13, 'iOS', 'ios', '', '#4a4a4a', 1, 'post'),
(14, 'Berita', 'berita', '', '#c63434', 1, 'post'),
(15, 'Gadget', 'gadget', '', '#23ad89', 1, 'post');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_kategori_relasi`
--

CREATE TABLE `memo_kategori_relasi` (
  `krId` bigint(20) UNSIGNED NOT NULL,
  `katId` int(10) UNSIGNED NOT NULL,
  `kontenId` int(10) UNSIGNED NOT NULL,
  `krType` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_kategori_relasi`
--

INSERT INTO `memo_kategori_relasi` (`krId`, `katId`, `kontenId`, `krType`) VALUES
(1, 3, 4, 'post'),
(2, 15, 4, 'post'),
(5, 5, 7, 'post'),
(6, 4, 7, 'post'),
(7, 3, 8, 'post'),
(8, 15, 8, 'post'),
(9, 6, 9, 'post'),
(10, 3, 9, 'post'),
(11, 7, 10, 'post'),
(12, 2, 10, 'post'),
(19, 11, 13, 'post'),
(20, 9, 13, 'post'),
(21, 11, 14, 'post'),
(22, 9, 14, 'post'),
(23, 3, 14, 'post'),
(24, 6, 15, 'post'),
(25, 3, 15, 'post'),
(26, 5, 16, 'post'),
(27, 3, 16, 'post'),
(28, 15, 16, 'post'),
(29, 4, 17, 'post'),
(30, 3, 17, 'post'),
(31, 15, 17, 'post'),
(32, 5, 18, 'post'),
(33, 2, 18, 'post'),
(34, 6, 12, 'post'),
(35, 5, 12, 'post'),
(36, 12, 19, 'post'),
(37, 3, 19, 'post'),
(42, 10, 21, 'post'),
(43, 9, 21, 'post'),
(44, 13, 22, 'post'),
(45, 12, 22, 'post'),
(46, 10, 22, 'post'),
(47, 5, 23, 'post'),
(48, 2, 23, 'post'),
(51, 11, 25, 'post'),
(52, 10, 25, 'post'),
(53, 5, 25, 'post'),
(62, 14, 26, 'post'),
(63, 12, 26, 'post'),
(64, 8, 26, 'post'),
(68, 14, 20, 'post'),
(69, 9, 20, 'post'),
(70, 6, 20, 'post'),
(71, 5, 20, 'post'),
(72, 3, 20, 'post'),
(73, 14, 28, 'post'),
(74, 12, 28, 'post'),
(75, 10, 29, 'post'),
(76, 6, 29, 'post'),
(83, 10, 5, 'post'),
(84, 5, 5, 'post'),
(85, 10, 11, 'post'),
(86, 8, 11, 'post'),
(87, 7, 11, 'post'),
(88, 2, 11, 'post'),
(89, 11, 30, 'post'),
(90, 6, 30, 'post'),
(91, 5, 30, 'post'),
(92, 1, 1, 'webmenu'),
(93, 1, 3, 'webmenu'),
(94, 1, 4, 'webmenu'),
(95, 1, 5, 'webmenu'),
(96, 1, 6, 'webmenu'),
(98, 1, 8, 'webmenu'),
(99, 14, 31, 'post'),
(100, 12, 31, 'post'),
(101, 3, 31, 'post'),
(102, 14, 24, 'post'),
(103, 12, 24, 'post'),
(104, 8, 24, 'post'),
(107, 10, 27, 'post'),
(108, 2, 27, 'post'),
(109, 10, 32, 'post'),
(110, 3, 32, 'post'),
(111, 14, 33, 'post'),
(112, 6, 33, 'post'),
(113, 14, 34, 'post'),
(114, 1, 9, 'webmenu'),
(115, 15, 35, 'post'),
(116, 14, 35, 'post'),
(117, 3, 35, 'post');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_komentar`
--

CREATE TABLE `memo_komentar` (
  `komenId` bigint(20) UNSIGNED NOT NULL,
  `kontenId` bigint(20) UNSIGNED NOT NULL,
  `komenIdInduk` bigint(20) UNSIGNED NOT NULL,
  `komenKontenType` varchar(25) NOT NULL,
  `komenPenulis` varchar(255) NOT NULL,
  `komenEmail` varchar(255) NOT NULL,
  `komenWeblog` varchar(255) NOT NULL,
  `komenIsi` text NOT NULL,
  `komenHari` varchar(11) NOT NULL,
  `komenJam` time NOT NULL,
  `komenDate` date NOT NULL,
  `komenTimestamp` varchar(10) NOT NULL,
  `komenIp` varchar(25) NOT NULL,
  `komenApproved` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_komentar`
--

INSERT INTO `memo_komentar` (`komenId`, `kontenId`, `komenIdInduk`, `komenKontenType`, `komenPenulis`, `komenEmail`, `komenWeblog`, `komenIsi`, `komenHari`, `komenJam`, `komenDate`, `komenTimestamp`, `komenIp`, `komenApproved`) VALUES
(1, 8, 0, 'post', 'Anonymous', 'anonim@gmail.com', '', 'Makanan kuliner khas melayu ada gak? percuma donk nama situsnya kabar melayu tapi makanan khas melayunya tidak ada. ^_^\r\n', 'Rabu', '17:09:34', '2015-11-11', '1447236574', '36.76.55.236', '1'),
(3, 8, 1, 'post', 'Kabar Melayu', 'kabarmelayu777@gmail.com', 'http://www.kabarmelayu.com/', 'Terimakasih, akan kita tampilkan satu persatu :D', 'Kamis', '23:55:18', '2015-11-12', '1447347318', '202.67.44.29', '1'),
(4, 35, 0, 'post', 'Mariah', 'mariah5875s@yahoo.com', '', 'Semoga atuk cepat sembuh....Aamiin.', 'Jumat', '19:47:30', '2015-11-13', '1447418850', '180.254.125.210', '1'),
(5, 35, 0, 'post', 'Rama Zannata', 'rama_zannata@rocketmail.com', '', 'Semoga atuk Anas Maamun cepat diberikan kesembuhan dari penyakit yang diderita.. dan diberikan umur yang panjang dan diberikan ketabahan oleh allah swt... berkat jerih payah dan semangat juang beliaulah.. kita bisa merasakan pembangunan dan pendidikan serta kemajuan yang ada diRokan Hilir tercinta...', 'Jumat', '23:26:01', '2015-11-13', '1447431961', '202.67.44.31', '1'),
(6, 35, 0, 'post', 'Rama Zannata', 'rama_zannata@rocketmail.com', '', 'save for Mantan Pemimpin kami.. Annas Maamun..', 'Jumat', '23:28:08', '2015-11-13', '1447432088', '202.67.44.31', '1'),
(7, 35, 0, 'post', 'Buter', 'uthe_nine@yahoo.co.id', '', 'Atuk, copek sehat yo, rohil merupakan perjuangan atuk dimata rakyat rohil, atuk lah pemimpin yang seleb di riau', 'Sabtu', '14:08:04', '2015-11-14', '1447484884', '114.125.11.100', '1'),
(8, 35, 0, 'post', 'Annisa Yunita', 'nisa.ajjah@gmail.com', '', 'Semoga atuk Anas Maamun cepat diberikan kesembuhan dari penyakit yang diderita.. dan diberikan umur yang panjang amiiiiiiiiiiiin ya Allah ya rabb o:)', 'Sabtu', '17:15:27', '2015-11-14', '1447496127', '103.246.201.49', '1'),
(9, 35, 0, 'post', 'Annisa Yunita', 'nisa.ajjah@gmail.com', 'http://www.annas mamun.cepat sembuh/', 'Semoga atuk diberi kesembuhan di hindari dari penyakit yg di derita atuk, dan diberi umur yang panjang amiiiiin ya Allah rabballa&#039;alamin, sabar ya atuk kami semua selalu mendoakan atuk o:)', 'Sabtu', '17:20:28', '2015-11-14', '1447496428', '103.246.200.59', '1'),
(10, 35, 0, 'post', 'ridwan', 'riko_afriansyah@yahoo.co.id', '', 'Ass. Tuk semoga atu anas&#039; mamun cpat sembuh&#039; dan semoga allah membrikan petunjuk dalan jalan buat atauk yo&#039;&#039; dan smoga allah membrikan ktbahan buat kluarga atuk dan atuk jugo ye&#039; semoga cepat smbuh dan smga atuk tdak brsalah &#039; kami doakan ye thu&#039;', 'Sabtu', '21:29:45', '2015-11-14', '1447511385', '103.246.201.52', '1'),
(11, 16, 0, 'post', 'marewa', 'sonny.anhar@gmail.com', '', 'Kerajaan Riau \r\nRaja Haji adalah Bangsawan Bugis yg memimpin di Negeri Melayu  dan ini awal dari persenatian Bangsawan Melayu Bugis untuk negeri Riau Melayu tercinta....', 'Rabu', '21:08:53', '2015-11-18', '1447855733', '114.125.43.11', '1'),
(12, 16, 0, 'post', 'Haris', 'Alammelayusriwijaya@gmail.com', '', 'Salam,\r\n\r\nSalam kenal dr kami yayasan alam melayu sriwijaya (Malaya), semoga kita bisa bertukar informasi mengenai pendidikan dan budaya, khususnya budaya melayu. \r\n\r\nWassalam,\r\n\r\nHaris\r\nwww.malaya.or.id', 'Kamis', '18:37:09', '2015-11-19', '1447933029', '202.67.42.36', '1'),
(13, 8, 0, 'post', 'Test name coment', 'afrioni01@gmail.com', '', 'Test msg coment', 'Sabtu', '21:14:41', '2016-05-28', '1464444881', '127.0.0.1', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_kontak`
--

CREATE TABLE `memo_kontak` (
  `kontakId` int(11) UNSIGNED NOT NULL,
  `kontakBalasId` int(15) UNSIGNED NOT NULL,
  `kontakNama` varchar(150) NOT NULL,
  `kontakEmail` varchar(255) NOT NULL,
  `kontakEmailSent` varchar(255) NOT NULL,
  `kontakTlp` varchar(60) NOT NULL,
  `kontakPesan` text NOT NULL,
  `kontakWaktu` varchar(11) NOT NULL,
  `kontakHari` varchar(10) NOT NULL,
  `kontakStatus` enum('B','L') NOT NULL DEFAULT 'B',
  `kontakStatusPesan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_konten`
--

CREATE TABLE `memo_konten` (
  `kontenId` bigint(20) UNSIGNED NOT NULL,
  `kontenUsername` varchar(150) NOT NULL,
  `kontenJudul` text NOT NULL,
  `kontenJudulBesar` varchar(255) NOT NULL,
  `kontenJudulKecil` varchar(255) NOT NULL,
  `kontenPost` longtext NOT NULL,
  `kontenRingkas` text NOT NULL,
  `kontenType` varchar(25) NOT NULL,
  `kontenHari` varchar(10) NOT NULL,
  `kontenDd` int(5) UNSIGNED NOT NULL,
  `kontenMm` int(5) UNSIGNED NOT NULL,
  `kontenYy` int(8) UNSIGNED NOT NULL,
  `kontenDate` date NOT NULL,
  `kontenJam` time NOT NULL,
  `kontenTimestamp` varchar(11) NOT NULL,
  `kontenDatetime` datetime NOT NULL,
  `kontenAddDate` varchar(11) NOT NULL,
  `kontenSlug` varchar(255) NOT NULL,
  `kontenRead` bigint(30) UNSIGNED NOT NULL,
  `kontenStatusKomen` int(3) UNSIGNED NOT NULL,
  `kontenStatus` int(3) UNSIGNED NOT NULL,
  `kontenEditor` varchar(100) NOT NULL,
  `kontenPenulis` varchar(100) NOT NULL,
  `kontenImg` varchar(255) NOT NULL,
  `kontenDirImg` varchar(25) NOT NULL,
  `kontenTextImg` text NOT NULL,
  `kontenHeadline` int(3) UNSIGNED NOT NULL,
  `kontenFeature` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_konten`
--

INSERT INTO `memo_konten` (`kontenId`, `kontenUsername`, `kontenJudul`, `kontenJudulBesar`, `kontenJudulKecil`, `kontenPost`, `kontenRingkas`, `kontenType`, `kontenHari`, `kontenDd`, `kontenMm`, `kontenYy`, `kontenDate`, `kontenJam`, `kontenTimestamp`, `kontenDatetime`, `kontenAddDate`, `kontenSlug`, `kontenRead`, `kontenStatusKomen`, `kontenStatus`, `kontenEditor`, `kontenPenulis`, `kontenImg`, `kontenDirImg`, `kontenTextImg`, `kontenHeadline`, `kontenFeature`) VALUES
(1, 'demo', 'Kebijakan Privasi', '', '', '<p><span style=\"font-size:14pt\"><strong>Kebijakan Privasi Pro Digital</strong></span></p>\r\n\r\n<p>Jika Anda memerlukan informasi lebih lanjut atau memiliki pertanyaan apapun tentang kebijakan privasi kami, jangan ragu untuk menghubungi kami melalui email di <strong>info@prodigital.web.id</strong>. Dengan menggunakan Pro Digital Anda setuju dengan kebijakan privasi ini.<br />\r\nDi www.prodigital.web.id, privasi pengunjung kami sangatlah penting bagi kami. Dokumen kebijakan privasi ini menjelaskan jenis-jenis informasi pribadi yang diterima dan dikumpulkan oleh <em>www.prodigital.web.id</em> dan bagaimana ia digunakan.</p>\r\n\r\n<p><strong>File-file log</strong></p>\r\n\r\n<p>Seperti kebanyakan situs Web lain, <em>www.prodigital.web.id</em> menggunakan file-file log. Informasi di dalam file-file log meliputi IP address, jenis browser, Internet Service Provider (ISP), stamp tanggal/waktu, halaman referring/keluar, dan jumlah klik untuk menganalisis kecenderungan, mengelola situs, melacak pergerakan pengguna di sekitar situs, dan mengumpulkan informasi demografis. IP address, dan informasi lain tersebut tidak terkait dengan informasi apapun yang bersifat pribadi.</p>\r\n\r\n<p><strong>Cookies &amp; Web Beacons</strong></p>\r\n\r\n<p><em>www.prodigital.web.id</em> menggunakan cookies untuk menyimpan informasi tentang preferensi pengunjung, merekam informasi pengguna tertentu pada halaman mana pengguna akses atau kunjungi, menyesuaikan konten halaman web berdasarkan jenis browser pengunjung atau informasi lainnya yang pengunjung kirimkan melalui browser mereka.</p>\r\n\r\n<p>Beberapa partner periklanan kami mungkin menggunakan cookies dan web beacon di situs kami. Mitra periklanan kami antara lain:</p>\r\n\r\n<ul>\r\n	<li>Google Adsense</li>\r\n	<li>RevenueHits</li>\r\n</ul>\r\n\r\n<p>Server-server iklan pihak ketiga atau jaringan iklan dengan menggunakan teknologi iklan dan link yang muncul di <em>www.prodigital.web.id</em> mengirim secara langsung ke browser Anda. Mereka secara otomatis menerima IP address anda ketika hal ini terjadi. Teknologi-teknologi lainnya (seperti cookies, JavaScript, atau Web Beacon) juga dapat digunakan oleh jaringan iklan pihak ketiga untuk mengukur efektivitas iklan mereka dan/atau untuk personalisasi konten iklan yang Anda lihat.</p>\r\n\r\n<p><u><em>www.prodigital.web.id</em></u> tidak memiliki akses atau kontrol terhadap cookies yang digunakan oleh pengiklan pihak ketiga.</p>\r\n\r\n<p>Anda harus berkonsultasi dengan kebijakan privasi masing-masing dari server iklan pihak ketiga untuk informasi lebih rinci tentang praktek-praktek mereka serta untuk mendapatkan petunjuk tentang cara pilihan keluar dari praktek-praktek tertentu. Kebijakan privasi <em>www.prodigital.web.id</em> tidak berlaku untuk itu, dan kami tidak dapat mengontrol kegiatan, pengiklan atau situs web lain.</p>\r\n\r\n<p>Jika Anda ingin menonaktifkan cookies, Anda dapat melakukannya melalui pilihan browser tersendiri. Informasi lebih lanjut tentang pengelolaan cookies dengan browser web tertentu dapat ditemukan di masing-masing situs web browser.</p>', 'Kebijakan Privasi Pro Digital\r\n\r\nJika Anda memerlukan informasi lebih lanjut atau memiliki pertanyaan apapun tentang kebijakan privasi kami, jangan ragu untuk menghubungi kami melalui email di', 'page', 'Senin', 29, 4, 2019, '2019-04-29', '09:45:00', '1556505900', '2019-04-29 09:45:00', '', 'kebijakan-privasi', 87, 0, 1, '', '', '', '', '', 0, 0),
(2, 'demo', 'Disclaimer', '', '', '<p>Dengan mengakses dan menggunakan ProDigital.web.id, Anda perlu menyetujui dan memahami beberapa hal berikut:</p>\r\n\r\n<p><strong>Penggunaan Nama ProDigital.web.id</strong><br />\r\nDilarang menggunakan atau mengatasnamakan ProDigital.web.id untuk kepentingan pribadi atau kelompok tertentu tanpa izin dari ProDigital.web.id. Pelanggaran ini bisa berakibat pelanggaran hak cipta dan intelektual.</p>\r\n\r\n<p><strong>Konten</strong><br />\r\nSegala jenis tulisan yang diposting oleh penulis asli/kontributor ProDigital.web.id adalah dilindungi. Dilarang untuk menyebarkan, memposting tanpa referensi dari ProDigital.web.id. Apabila ingin mengcopy tulisan dari ProDigital.web.id harap cantumkan referensi dari ProDigital.web.id baik berupa link atau nama dari ProDigital.web.id.</p>\r\n\r\n<p>Data maupun informasi yang disajikan di ProDigital.web.id tidak kami jamin keakuratannya 100% meskpun telah dilakukan upaya untuk menampilkan data dan informasi seakurat mungkin, ProDigital.web.id tidak bertanggung jawab atas segala kesalahan maupun keterlambatan memperbarui data atau informasi.</p>\r\n\r\n<p><strong>Komentar</strong><br />\r\nPendapat dan komentar dari dari pengunjung maupun moderator adalah pendapat pribadi dan tidak mencerminkan pandangan dari ProDigital.web.id sehingga ProDigital.web.id tidak bertanggung jawab atas pelanggaran yang terjadi dari komentar pengunjung/moderator yang muncul dalam interaksi pada konten lainnya pada website ini.</p>\r\n\r\n<p><strong>Link</strong><br />\r\nProDigital.web.id mencantumkan link ke situs lain, namun hal ini tidak menunjukan bahwa ProDigital.web.id menyetujui situs pihak lain tersebut.&nbsp; Anda mengetahui dan menyetujui bahwa ProDigital.web.id tidak bertanggung jawab atas isi atau materi lainnya yang ada pada situs pihak lain tersebut.</p>\r\n\r\n<p><strong>Kritik dan Saran</strong><br />\r\nSegala jenis kritik dan saran dapat dikirim melalui email atau kontak form</p>\r\n\r\n<p><strong>Gambar dan Video</strong><br />\r\nSemua gambar dan video yang ditampilkan pada ProDigital.web.id adalah hak cipta masing-masing pemiliknya yang dikumpulkan dari sumber publik yang berbeda, termasuk website yang berbeda, yang dianggap berada dalam domain publik.</p>\r\n\r\n<p>ProDigital.web.id tidak mengklaim hak eksklusif pada semua gambar dan video yang dipublikasikan, dan kami memberikan kredit atau backlink pada gambar maupun video dari sumber lain yang kami gunakan.</p>\r\n\r\n<p>Jika ditemukan pelanggaran hak cipta untuk materi seperti foto,gambar/image maupun video di ProDigital.web.id dan ingin kami menghapusnya dari website kami, silakan hubungi kami untuk mengklaim kepemilikan tersebut dan kami akan merespon Anda.</p>\r\n\r\n<p>Mohon maaf jika tidak berkenan dengan aturan yang telah kami tetapkan. Hal ini kami lakukan demi untuk kenyamanan pengunjung dan yang membuat konten di ProDigital.web.id. Silahkan hubungi kami apabila ada kritik dan saran, terima kasih.</p>', 'Dengan mengakses dan menggunakan ProDigital.web.id, Anda perlu menyetujui dan memahami beberapa hal berikut:\r\n\r\nPenggunaan Nama ProDigital.web.id\r\nDilarang menggunakan atau mengatasnamakan', 'page', 'Senin', 29, 4, 2019, '2019-04-29', '11:42:00', '1556512920', '2019-04-29 11:42:00', '', 'disclaimer', 75, 0, 1, '', '', '', '', '', 0, 0),
(3, 'demo', 'Tentang Kami', '', '', '<p>ProDigital.web.id adalah sebuah media online yang menyediakan dan menyajikan informasi teknologi mengenai Komputer, Gadget dan IT terbaru, dan berita seputar ilmu pengetahuan yang berkaitan dengan teknologi, serta bisnis berbasis teknologi atau startup yang terupdate dan terhangat saat ini.</p>\r\n\r\n<p>Melalui media online, ProDigital.web.id berusaha menggali informasi tentang teknologi guna memberikan wawasan luas untuk anak bangsa, baik itu mempublikasikan karya inovasi terbaru, prestasi, startup dan menjadi media partner untuk acara bertemakan teknologi.</p>\r\n\r\n<p>Selain memberikan informasi terupate tentang berita teknologi, ProDigital.web.id juga memberikan akses navigasi yang mudah bagi pengunjung, baik menyajikan artikel yang relevan juga fitur untuk berinteraksi melalui kolom komentar. ProDigital.web.id juga didukung oleh tim redaksi yang berkompeten.</p>\r\n\r\n<p>Jika ada pertanyaan, saran dan/atau kritik yang membangun, bisa disampaikan melalui halaman <a href=\"https://www.prodigital.web.id/kontak.html\" target=\"_blank\">Kontak</a> yang telah disediakan.</p>', 'ProDigital.web.id adalah sebuah media online yang menyediakan dan menyajikan informasi teknologi mengenai Komputer, Gadget dan IT terbaru, dan berita seputar ilmu pengetahuan yang berkaitan dengan', 'page', 'Senin', 29, 4, 2019, '2019-04-29', '10:44:00', '1556509440', '2019-04-29 10:44:00', '1451828653', 'tentang-kami', 71, 0, 1, '', '', '', '', '', 0, 0),
(4, 'demo', 'Redmi Y3 Spesifikasi dan Harga', '', '', '<p>Setelah beberapa minggu ini Xiaomi mengeluarkan teaser tentang smartphone terbarunya, kini akhirnya perusahaan secara resmi telah meluncurkan smartphone seri Redmi terbaru miliknya yang bernama Redmi Y3. Smartphone ini pertama kali meluncur di pasar India bersama dengan Redmi 7, di mana kedua smartphone ini memiliki banyak kemiripan kecuali di bagian kamera selfie.</p>\r\n\r\n<p>Remi Y3 memiliki kamera selfie beresolusi 32MP yang menjadikannya sebagai smartphone dengan kamera selfie tertingi yang dimiliki oleh perusahaan. Selain itu, smartphone ini juga hadir dengan desain Aurora yang memiliki lekukan halus serta dilapisi Gorilla Glass 5 di belakang. Xiaomi memposisikan Y3 sebagai mesin selfie terbaik dan menetapkan harga secara agresif untuk bersaing di segmen entry-level.</p>\r\n\r\n<p>Di bagian depan, Y3 hadir dengan layar seluas 6,26 inci berjenis IPS dan memiliki resolusi HD+ dengan filter cahaya biru bersertifikat TUV. Ada juga notch waterdrop untuk menampung kamera depan 32MP yang mengemas deteksi scene AI, sudut pandang hingga pandang 80 derajat dan EIS untuk stabilisasi video.</p>\r\n\r\n<p><img alt=\"\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/Redmi-Y3-32mp.png\" style=\"height:314px; margin:0 auto; text-align:center; width:453px\" /></p>\r\n\r\n<p>Bagian belakang pada kedua ponsel ini memiliki lapisan Gorilla Glass 5 dan memiliki kamera utama beresolusi 12MP dan sensor kedalaman 2MP. Di bawah kamera terdapat LED flash dan di sebelah kanannya terdapat pemindai sidik jari.</p>\r\n\r\n<p>Untuk jeroannya, smartphone ini didukung oleh prosesor Snapdragon 632 dengan pilihan 3GB atau 4GB RAM bersama dengan penyimpanan 32/64GB. Kedua model sama-sama mendukung slot microSD hingga 512GB berkat slot kartu 2+1. Kapasitas baterainya sebesar 4.000mAh dan dilengkapi dengan pengisian daya hingga 10W.</p>\r\n\r\n<p>Keduanya tahan percikan berkat lapisan hidrofobik P2i, yang jarang pada ponsel Xiaomi dan tentu saja langkah ke arah yang lebih baik. Tak ketinggalan, terdapat jack audio 3.5mm dan IR blaster.</p>\r\n\r\n<p>Perangkat Redmi baru akan datang dalam warna Hitam, Biru, dan Merah. Sementara untuk harga, Redmi Y3 akan dibanderol mulai dari INR 9999 (Rp2 juta) untuk versi basic 3/32GB, sedangkan varian 4/64GB akan dibanderol INR 11.999 (Rp2,4 juta). Sayangnya belum diketahui ketersediannya di negara lain dan berapa harganya jika masuk ke pasar Indonesia.</p>', 'Setelah beberapa minggu ini Xiaomi mengeluarkan teaser tentang smartphone terbarunya, kini akhirnya perusahaan secara resmi telah meluncurkan smartphone seri Redmi terbaru miliknya yang bernama', 'post', 'Senin', 29, 4, 2019, '2019-04-29', '01:13:00', '1556475180', '2019-04-29 01:13:00', '1556475190', 'redmi-y3-spesifikasi-dan-harga', 131, 1, 1, '', 'Afrioni', 'f939b6042019_redmiy3.png', 'post/042019', '', 1, 1),
(5, 'demo', 'Yang Harus Dilakukan Saat Smartphone Anda Terendam Air', '', '', '<p>Menyebalkan memang jika <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> kesayangan kita kemasukan air. Terkadang terjadi pada saat-saat yang tidak terduga-duga, terlebih lagi dengan kecerobohan kita saat sedang memegangnya. Banyak hal yang membuat smartphone ataupun handphone pintar dapat kemasukan oleh air yakni; basah karena hujan, masuk kedalam saluran air, jatuh ditempat becek hingga terendam oleh air didalam bak mandi.</p>\r\n\r\n<p>Namun Anda seharusnya tidak perlu panik karena ada beberapa tips agar smartphone kesayangan Anda nyala kembali. Nah, kali ini <a href=\"https://www.prodigital.web.id/\" target=\"_blank\">Pro Digital</a> akan berbagi <a href=\"https://www.prodigital.web.id/kategori/10/tips-dan-trik.html\" target=\"_blank\">tips</a> untuk Anda apabila handphone kita kemasukan ataupun terendam oleh air, tentunya dapat membuat smartphone kita menjadi rusak. berikut tipsnya.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>1. Matikan Smartphone</strong></span></p>\r\n\r\n<p>Apabila smartphone Anda terendam oleh air, segera matikan smartphone Anda, setelah itu buka baterai smartphone Anda dengan segera, karena dengan melepas baterai smartphone Anda maka tegangan yang masuk dari baterai akan terhenti dan meminimalisir kerusakan komponen pada smartphone Anda.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>2. Gunakan Kain Atau Tisu Untuk Menyerap Air</strong></span></p>\r\n\r\n<p>Gunakan kain atau tisu untuk menghilangkan bagian yang basah terkena air. Lakukan dengan cara menepuk-nepuk bagian yang basah dan jangan menggosoknya. Karena apabila menggosoknya maka bagian yang basah tersebut akan menyebar kebagian yang lain.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>3. Gunakan Vacuum Cleaner Untuk Menyedot Air</strong></span></p>\r\n\r\n<p>Jika Anda memiliki vacuum cleaner silahkan coba untuk menggunakannya, karena ini lebih baik untuk menyedot air keluar. Namun, jangan gunakan alat pengering rambut karena dapat merusak bagian dalam smartphone Anda.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>4. Keringkan Smartphone Anda Pada Tempat Yang Hangat</strong></span></p>\r\n\r\n<p>Setelah Anda melakukan cara seperti poin 1, 2 dan 3 maka cobalah untuk mengeringkannya pada tempat&nbsp; yang hangat seperti diatas televisi, radio ataupun benda-benda yang hangat lainnya dan diamkan beberapa menit hingga smartphone Anda benar-benar kering dan setelah itu cobalah untuk menyalakan. Jangan jemur langsung dibawah matahari karena dapat merusak beberapa komponen yang terdapat pada smartphone Anda.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>5. Bawa Ke Tempat Service</strong></span></p>\r\n\r\n<p>Jika smartphone Anda masih tidak dapat menyala, silahkan bawa smartphone Anda ke tempat service yang Anda percaya. Dan jika perlu bawalah ke tempat service center dan ini adalah cara terbaik.</p>\r\n\r\n<p>Itulah tips dan trik sederhana dari Pro Digital untuk Anda dalam mengatasi smartphone Anda yang terkena Air. Silahkan tunggu <a href=\"https://www.prodigital.web.id/kategori/10/tips-dan-trik.html\" target=\"_blank\">tips dan trik</a> lainnya dari kami.</p>', 'Menyebalkan memang jika smartphone kesayangan kita kemasukan air. Terkadang terjadi pada saat-saat yang tidak terduga-duga, terlebih lagi dengan kecerobohan kita saat sedang memegangnya. Banyak', 'post', 'Senin', 29, 4, 2019, '2019-04-29', '13:47:00', '1556520420', '2019-04-29 13:47:00', '1556520440', 'yang-harus-dilakukan-saat-smartphone-anda-terendam-air', 96, 1, 1, '', 'Afrioni', '7e8592042019_yukdownloadcom_ul7tm_59.png', 'post/042019', '', 0, 0),
(6, 'demo', 'Konten Kontak', '', '', '<p>Silahkan menghubungi melalui beberapa metode di atas. Semoga ini dapat membantu kami dalam meningkatkan kualitas konten kami. terima kasih atas perhatian Anda</p>', 'Silahkan menghubungi melalui beberapa metode di atas. Semoga ini dapat membantu kami dalam meningkatkan kualitas konten kami. terima kasih atas perhatian', 'addctn', 'Senin', 29, 4, 2019, '2019-04-29', '15:04:00', '1556525040', '2019-04-29 15:04:00', '1556525042', 'konten-kontak', 0, 0, 1, '', '', '', '', '', 0, 0),
(7, 'demo', 'Agar Tak Menyesal Beli Kamera Mirrorless Buat Pemula', '', '', '<p>Bisa dibilang nih, kamera mirrorless kini tengah jadi tren di kalangan anak muda. Gak lengkap rasanya motret objek estetis atau OOTD tanpa pakai kamera mirrorless. Sayangnya nih masih banyak yang asal beli kamera mirrorless, sehingga gak jarang banyak yang tertipu karena beli cuma asal murah saja.</p>\r\n\r\n<p>Nah, biar gak ketipu lagi ada baiknya kamu perhatikan deh tips berikut ini agar tak menyesal beli kamera mirrorless.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>1. Beli kamera mirrorless perlu perhatikan kebutuhan terlebih dahulu.</strong></span></p>\r\n\r\n<p>Prinsip ini memang perlu dipikirkan ketika pertama kali membeli apapun itu bentuk gadgetnya. Khusus untuk mirrorless coba tanyakan pada dirimu sebelum membeli, apa sih sebenarnya tujuan nanti kamu mau membeli kamera mirrorless. Untuk memotret pemandangan, untuk nge-vlog ataukah hanya untuk memotret gayamu dalam format OOTD ala selebgram?<br />\r\n<br />\r\nJika sudah diketahui apa kebutuhanmu beli kamera mirrorless, maka kamu bisa menentukan kualitas kamera seperti apa yang mau dibeli. Karena pada dasarnya tiap kamera mirrorless yang mau kamu beli punya kelebihan masing-masing. Usahakan sih, pilih kamera mirrorless dengan paket penjualan lensa sekalian.<br />\r\n<br />\r\nSoalnya, kamu yang baru pertama kali pakai kamera mirrorless biasanya akan masih banyak belajar. Sehingga, saat membeli paket penjualan kamera mirrorless dengan lensa jadi bisa memilih-milih lensa mana yang mau dipakai dan cocok dengan karakter foto yang ingin kamu tonjolkan.</p>\r\n\r\n<p><strong><span style=\"font-size:14pt\">2. Gak perlu kamera mirrorless mahal dulu, murah asalkan sesuai kebutuhan.</span></strong></p>\r\n\r\n<p>Namanya juga kamu mau beli kamera mirrorless pertama kali pasti tujuan untuk belajar motret kan? So, gak perlu deh langsung beli kamera mirrorless yang harganya mahal dan selangit. Cukup beli kamera mirrorless yang harganya murah atau terjangkau saja (lebih tepat sih sesuaikan sama budgetmu). Toh, misal hasrat kalian untuk motret pakai kamera mirrorless tiba-tiba sirna jadi gak menyesal di kemudian hari karena membeli kamera mirrorless dengan harga yang terlalu mahal.</p>\r\n\r\n<p><strong><span style=\"font-size:14pt\">3. Kalau sudah tahu kebutuhan, yang perlu diperhatikan selanjutnya adalah soal sensor yang disediakan si kamera mirrorless.</span></strong></p>\r\n\r\n<p>Mengapa hal ini begitu penting? Soalnya, beda sensor yang dipakai maka beda hasil foto yang dihasilkan. Biasanya ada tiga sensor yang biasa dipakai oleh kamera mirrorless ini guys yakni full frame, APS-C dan four thirds. Ketiga sensor ini punya kelebihan dan kekurangan masing-masing, tapi jika mempertimbangkan hasil foto yang lebih jernih dan indah maka kamera mirrorless dengan sensor full frame lebih baik jadi pilihan. Soalnya, sensor full frame diklaim lebih baik dalam menangkap cahaya sehingga foto yang dihasilkan lebih berkualitas dan nampak jernih.</p>\r\n\r\n<p><strong><span style=\"font-size:14pt\">4. Jika beli kamera mirrorless untuk nge-vlog, pastikan kualitas rekamannya juara.</span></strong></p>\r\n\r\n<p>Sekarang makin banyak anak muda menggunakan kamera mirrorless untuk bikin video blogging alias vlog. Oleh karena itulah, kamu yang pertama kali beli kamera mirrorless dan tujuannya untuk nge-vlog maka wajib banget memperhatikan kualitas video yang dihasilkan.<br />\r\n<br />\r\nPaling mudah sih, kamu bisa mempertimbangkan kemampuan autofocus si kamera saat dipakai untuk merekam. Fitur ini sangat penting jika tujuanmu membeli kamera mirrorless memang nge-vlog. Bayangin jika fitur autofocus kamera mirrorless yang kamu beli jelek, maka saat kamu pakai nge-vlog kemungkinan besar akan kesusahan mendapatkan fokus video yang baik dan jernih. Hasilnya, vlog kamu bakal jelek banget dan gak memuaskan.<br />\r\n<br />\r\nSelain itu, kalau kamu mau beli kamera mirrorless untuk keperluan nge-vlog pastikan deh si kamera layar LCD-nya bisa diputar menghadap ke depan agar lebih mudah saat di gunakan untuk merekam diri sendiri.<br />\r\n<br />\r\nItulah guys, tips untuk membeli kamera mirrorless untuk kamu para pemula agar tak menyesal. Semoga bermanfaat ya tipsnya.</p>', 'Bisa dibilang nih, kamera mirrorless kini tengah jadi tren di kalangan anak muda. Gak lengkap rasanya motret objek estetis atau OOTD tanpa pakai kamera mirrorless. Sayangnya nih masih banyak yang', 'post', 'Senin', 29, 4, 2019, '2019-04-29', '16:12:13', '1556529133', '2019-04-29 16:12:13', '1556529133', 'agar-tak-menyesal-beli-kamera-mirrorless-buat-pemula', 61, 1, 1, '', 'Afrioni', '073c44042019_yukdownloadcom_lew2q_14.jpg', 'post/042019', '', 0, 0),
(8, 'demo', 'Indonesia Kedatangan Ponsel 3 Kamera Oleh Vivo Y17', '', '', '<p>Beberapa waktu lalu sempat ada desas-desus akan ada smartphone dengan 3 kamera keluaran Vivo akan hadir di Indonesia. Hal tersebut ternyata bukan desas-desus belaka, Vivo Y17 akhirnya resmi mulai dipasarkan di Indonesia. Vivo memposisikan Y17 sebagai alternatif untuk konsumen gadget yang ingin memiliki ponsel berdesain dan berfitur menarik tapi tidak menguras kantong.</p>\r\n\r\n<p>Adapun spesifikasi kamera yang telah dipersiapkan Vivo Y17 untuk bersaing dipasaran adalah layar berukuran 6,35 inci (resolusi 720 x 1.544 piksel, rasio layar 19,3:9). Di sisi atasnya terdapat poni yang memuat kamera selfie 20 megapiksel. Bagian punggung perangkat ini yang terbuat dari kaca dilabur warna glossy. Ada dua varian warna yang disediakan, yakni pink dan biru. Di sisi belakang ini pula bertengger tiga kamera yang masing-masing memiliki resolusi 13 MP, 8 MP (ultra wide), dan 2 MP (depth sensor). Disamping itu, kamera tersebut telah dipersiapkan dengan software dari Vivo Y17 yang dibekali fitur AI Beauty untuk mempercantik jepretan gambar.</p>\r\n\r\n<p>Demi siap bersaing dengan brand lain dipasaran, Vivo Y17 mengandalkan chip processor octa-core berkecepatan 2,3 GHz yang dipadukan dengan RAM 4 GB dan memori internal 128 GB. Baterainya terbilang besar dengan kapasitas 5.000 mAh.</p>\r\n\r\n<p>Sistem operasi yang digunakan adalah Android 9.0 dengan laposan antarmuka ala Vivo, FunTouch OS Di Indonesia. Vivo Y17 dipasarkan dengan harga Rp 2.999.000 dan bisa didapatkan secara offline di mitra retail vivo yang tersebar di berbagai daerah di Indonesia mulai 28 April 2019. Vivo juga membuka penjualan Y17 secara online di e-commerce Akulaku 29 April hingga 3 Mei 2019. Bagaimana, apakah Anda berminat?</p>', 'Beberapa waktu lalu sempat ada desas-desus akan ada smartphone dengan 3 kamera keluaran Vivo akan hadir di Indonesia. Hal tersebut ternyata bukan desas-desus belaka, Vivo Y17 akhirnya resmi mulai', 'post', 'Senin', 29, 4, 2019, '2019-04-29', '21:58:00', '1556549880', '2019-04-29 21:58:00', '1556549897', 'indonesia-kedatangan-ponsel-3-kamera-oleh-vivo-y17', 196, 1, 1, '', 'Afrioni', '01649e042019_vivoy17.png', 'post/042019', '', 1, 1),
(9, 'demo', 'Brand Smartphone Ini Akan Diluncurkan Untuk Menyambut Teknologi 5G', '', '', '<p>Teknologi 5G digadang-gadang kan akan diluncurkan dalam waktu dekat ini. Dan kita akan menikmati fasilitas dari generasi ke 5 dari jaringan nirkable ini. Beberapa negara maju seperti Amerika Serikat, Jepang, dan Korea Selatan telah menargetkan penggunaan teknologi jaringan nirkabel 5G yang lebih luas mulai dari tahun 2019 hingga 2020.</p>\r\n\r\n<p>Jaringan 5G merupakan perombakan total terkait konektivitas dari jaringan 4G. 5G akan cukup cepat untuk menggantikan WiFi di rumah dan dengan demikian akan memungkinkan perangkat untuk benar-benar selalu tetap terhubung di mana pun Anda berada.</p>\r\n\r\n<p>Jaringan 5G juga memiliki bandwidth yang jauh lebih tinggi untuk mendukung lebih banyak perangkat yang dapat terhubung secara bersamaan dengan latensi(jeda waktu yang dibutuhkan dalam pengantaran paket data dari pengirim ke penerima) yang lebih sedikit.</p>\r\n\r\n<p>Dalam acara Snapdragon Technology Summit yang digelar oleh Qualcomm yang diadakan di Maui, Hawaii, Cristiano Amon sebagai Presiden Qualcomm mengatakan, Qualcomm beserta para produsen smartphone dan operator seluler di industri telekomunikasi bekerja sama membangun ekosistem 5G agar bisa dinikmati lebih cepat. Dari penyataan tersebut, sang Presiden berharap agar teknologi 5G dapat segera diterapkan.</p>\r\n\r\n<p>Amon juga mengatakan, &quot;Ini akan menjadi infrastruktur dasar bagi masyarakat yang akan dapat menghubungkan segala sesuatu di sekitar kita. 5G juga akan memimpin penciptaan industri dan jasa yang belum dibayangkan&quot;. Menurutnya, teknologi 5G memiliki potensi untuk menjadi salah satu transisi teknologi terbesar.</p>\r\n\r\n<p>Salah satu tantangan terbesar dari teknologi 5G ialah memastikan bahwa teknologi ini benar-benar bekerja sebagaimana yang dijanjikan.</p>\r\n\r\n<p>Selain itu, produsen ponsel juga harus memperhatikan perangkat mereka yang mendukung jaringan 5G. Produsen ponsel harus berpikir tentang masa pakai baterai, karena setiap generasi baru dari konektivitas seluler yang lebih cepat telah mengurangi pemakaian baterai. 5G juga harus didukung dengan performa, mobilitas, form factor dan lain-lain.</p>\r\n\r\n<p>Sejumlah produsen ponsel tengah bersiap menghadirkan smartphone berkemampuan 5G. Samsung, misalnya, berancang-ancang meluncurkan ponsel 5G pada tahun 2019 ini</p>\r\n\r\n<p>Samsung tidak menyebutkan merek ponsel tersebut, namun terdapat isu bahwa smartphone ini disinyalir merupakan smartphone flagship seri Galaxy S berikutnya, yakni Galaxy S10.</p>\r\n\r\n<p>Selain Samsung, brand ternama ponsel lainnya juga sedang menyiapkan perangkat serupa, antara lain Google, Motorola, OnePlus, Asus, LG, Xiaomi, Oppo, dan Vivo.</p>\r\n\r\n<p>Jaringan 5G akan hadir di Amerika Utara, Eropa, Australia, dan Asia. Khusus di Asia, sejumlah operator seluler akan dimulai di tiga negara, yakni China, Jepang, dan Korea Selatan. Negara tersebut telah menyiapkan penggunaan 5G setidaknya mulai akhir 2019.</p>', 'Teknologi 5G digadang-gadang kan akan diluncurkan dalam waktu dekat ini. Dan kita akan menikmati fasilitas dari generasi ke 5 dari jaringan nirkable ini. Beberapa negara maju seperti Amerika', 'post', 'Selasa', 30, 4, 2019, '2019-04-30', '10:47:00', '1556596020', '2019-04-30 10:47:00', '1556596023', 'brand-smartphone-ini-akan-diluncurkan-untuk-menyambut-teknologi-5g', 98, 1, 1, '', 'Afrioni', 'a8a6b9042019_first_5g_network_deployments.jpg', 'post/042019', '', 0, 0),
(10, 'demo', 'Asus ROG Berbasis Intel Core Generasi ke-9 dan GeForce GTX 1660 Ti Akan Hadir Di Indonesia', '', '', '<p>Asus ROG adalah laptop Asus dengan kategori laptop gaming yang sangat populer sekali bagi para gamer di Indonesia. Asus jenis ROG dengan berbasis Intel Core Generasi ke-9 dengan chip grafis NVIDIA GeForce GTX 1660 Ti dan seri lainnya dengan NVIDIA GeForce RTX 2070 akan dipasarkan di Indonesia dalam waktu dekat ini, dan akan memanjakan para pecinta gaming dan content creator dengan fasilitas yang ditawarkan oleh laptop ini. Produsen laptop gaming dengan pasar terbesar di Indonesia tersebut menjadi yang pertama yang menghadirkan solusi dengan kombinasi CPU-GPU.</p>\r\n\r\n<p>&quot;ASUS selalu menghadirkan produk dengan teknologi terbaru dan terbaik. Hal tersebut merupakan komitmen ASUS dalam menghadirkan produk yang berkualitas,&quot; ujar Jimmy Lin, Country Manager ASUS Indonesia. &quot;Seri laptop gaming ROG terbaru kali ini akan hadir dengan performa yang lebih kencang lagi berkat penggunaan prosesor Intel Core Generasi ke-9 dan GeForce GTX 1600 series yang dapat memastikan dominasi penggunanya di setiap sesi gaming,&quot; jelas Jimmy menambahkan.</p>\r\n\r\n<p><strong>ROG Zephyrus S GX502GW, Laptop Untuk Gamer Hardcore sekaligus Content Creator</strong></p>\r\n\r\n<p><img alt=\"\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/zephyrus-03.jpg\" style=\"display:block; height:576px; margin-left:auto; margin-right:auto; padding:10px; width:1024px\" />ROG Zephyrus sukses mendefinisikan ulang sebuah laptop gaming yang sebelumnya harus tampil tebal dan berat menjadi tipis dan ringan. Dengan sedikit gebrakan, ASUS kembali menghadirkan inovasi melalui ROG Zephyrus S GX502GW, yaitu sebuah laptop gaming ultra-tipis dengan spesifikasi yang dirancang tidak hanya untuk bermain game, tetapi juga untuk para content creator profesional yang juga membutuhkan laptop powerful dan dapat diandalkan.</p>\r\n\r\n<p>Secara fisik ROG Zephyrus S GX502GW memiliki tampilan yang sedikit berbeda dari lini laptop Zephyrus lainnya. Laptop gaming ini menggunakan desain tradisional dengan posisi keyboard seperti laptop pada umumnya, sementara seri Zephyrus lainnya menggunakan keyboard dengan posisi berada di bawah.</p>\r\n\r\n<p>Para content creator juga membutuhkan layar dengan reproduksi warna yang akurat. Untuk itulah ROG Zephyrus S GX502GW dilengkapi dengan layar yang sudah mengantongi sertifikasi kalibrasi warna dari PANTONE. Tidak hanya itu, layar ROG Zephyrus S GX502GW juga dirancang untuk bermain game dengan refresh rate 144Hz dan response time 3ms.</p>\r\n\r\n<p>Soal performa, ROG Zephyrus S GX502GW hadir dengan spesifikasi premium. Dengan otak yang ditenagai oleh prosesor Intel Core 9th Gen yaitu Intel Core i7-9750H yang menggunakan konfigurasi 6 core dan 12 thread sangat cocok untuk berbagai kegiatan, mulai dari bermain game, menjalankan aplikasi profesional, bahkan melakukan multitasking. Sementara dari segi grafis, ROG Zephyrus S GX502GW didukung oleh chip grafis NVIDIA GeForce RTX 2070 dengan VRAM GDDR6 sebesar 8GB yang tentu saja dapat menjalankan semua game PC yang ada saat ini.</p>\r\n\r\n<p>Pada sistem pendingin, ASUS ROG jenis ini masih menggunakan Active Aerodynamic System (AAS) yang merupakan salah satu ciri khas dari laptop seri Zephyrus. AAS membuat bagian bawah bodi ROG Zephyrus S GX502GW terangkat dan menghadirkan ruang ekstra untuk aliran udara sehingga pendinginan dapat berjalan lebih optimal bahkan ketika digunakan di ruang yang terbatas.</p>\r\n\r\n<p><strong>ROG Zephyrus M GU502GU, Perkasa dengan Intel Core 9th Gen dan GTX 1660Ti</strong></p>\r\n\r\n<p><img alt=\"\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/ASUS-ROG-Zephyrus-M-GU502GU.jpg\" style=\"display:block; height:561px; margin-left:auto; margin-right:auto; padding:10px; width:1024px\" />Meski sama-sama menggunakan nama Zephyrus, ROG Zephyrus M GU502GU berbeda dengan seri Zephyrus lainnya. Selain merupakan salah satu laptop gaming ASUS berbasis NVIDIA GeForce GTX 1660Ti yang pertama, laptop gaming ini juga tidak memiliki sistem pendingin Active Aerodynamic System (AAS). Meski demikian, teknisi ASUS berhasil menghadirkan sistem pendingin khusus yang dapat menjaga suhu komponen utama pada laptop gaming ini tetap optimal.</p>\r\n\r\n<p>Sebagai bagian dari keluarga Zephyrus, ROG Zephyrus M GU502GU masih hadir dengan berbagai fitur eksklusif. Fitur seperti layar bersertifikasi PANTONE dengan refresh rate 144Hz dan response time 3ms, hingga teknologi USB Type-C power delivery agar dayanya bisa diisi ulang menggunakan adapter USB Type-C yang lebih mungil kembali hadir di laptop gaming ini.</p>\r\n\r\n<p>ROG Zephyrus M GU502GU juga tetap menggunakan bodi berbahan magnesium alloy yang sangat kokoh. Desain bodi yang sangat simpel membuat ROG Zephyrus M GU502GU tidak terlalu mencolok ketika digunakan di tempat umum. Laptop gaming ini memang dirancang agar dapat menemani penggunanya sehari-hari diberbagai kegiatan dan telah diukung oleh fitur konektivitas yang lengkap.</p>\r\n\r\n<p>Sama seperti ROG Zephyrus GX502GW, laptop gaming ini ditenagai oleh prosesor Intel Core 9th Gen yaitu Intel Core i7-9750H. Prosesor ini memastikan ROG Zephyrus M GU502GU dapat berjalan kencang diberbagai penggunaan.</p>\r\n\r\n<p>Di Indonesia, Hendra Wijaya, Product Marketing ASUS ROG menyebutkan, produk-produk laptop gaming berbasis Intel Core generasi ke-9 dan Nvidia GeForce GTX 1660Ti akan hadir di bulan Mei mendatang.</p>\r\n\r\n<p>Sumber: PCplus Online</p>', 'Asus ROG adalah laptop Asus dengan kategori laptop gaming yang sangat populer sekali bagi para gamer di Indonesia. Asus jenis ROG dengan berbasis Intel Core Generasi ke-9 dengan chip grafis NVIDIA', 'post', 'Rabu', 1, 5, 2019, '2019-05-01', '12:08:00', '1556687280', '2019-05-01 12:08:00', '1556687325', 'asus-rog-berbasis-intel-core-generasi-ke-9-dan-geforce-gtx-1660-ti-akan-hadir-di-indonesia', 125, 1, 1, '', 'Afrioni', 'aa48df052019_rogcontesthingjonwallpapers1.jpg', 'post/052019', '', 1, 1),
(11, 'demo', 'Blue Screen Pada PC Atau Laptop Anda? Berikut Cara Mengatasinya', '', '', '<p>Terkadang disaat Anda sedang mengerjakan banyak pekerjaan pada <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">PC</a> atau laptop kesayangan Anda tiba-tiba laptop Anda mati dan muncul layar yang berwarna biru dengan seketika. Sehingga terkadang pekerjaan Anda terhenti karena hal tersebut. Memang menyebalkan sekali disaat Anda sedang fokus bekerja lalu PC atau laptop Anda tiba-tiba mengalami hal seperti itu. Kodisi ini biasanya dinamakan Blue Screen atau Blue Screen of Death.</p>\r\n\r\n<p><strong>Apa sih yang menyebabkan blue screen ini terjadi?</strong></p>\r\n\r\n<p>Pada dasarnya Blue Screen atau Blue Screen of Death (BSOD) merupakan sebuah kondisi dimana laptop yang sedang Anda gunakan tiba-tiba mati dan muncul warna biru secara total dilayar Anda dengan beberapa tulisan yang menunjukkan bahwa dalam laptop Anda telah terjadi crash sistem. Apalagi disaat Anda membuka banyak aplikasi komputer yang membuat <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">komputer</a> Anda bekerja dengan sangat keras dan membuat komputer Anda macet lalu terjadilah blue screen.</p>\r\n\r\n<p>Hal ini dikarenakan ketika PC atau laptop Anda berada dalam kondisi blue screen maka biasanya adanya masalah yang terjadi pada <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">hardware</a> atau <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\">software</a> yang berada pada laptop Anda. Blue screen akan secara otomatis terjadi ketika Windows dan Error Stop bertemu yang akan menyebabkan kegagalan yang fatal yang terjadi pada <a href=\"https://www.prodigital.web.id/kategori/7/laptop.html\" target=\"_blank\">laptop</a> Anda dan menyebabkan laptop Anda berhenti bekerja.</p>\r\n\r\n<p>Tentu saja masalah tersebut harus segera diatasi dengan cepat. Selain itu, mengatasi blue screen juga penting untuk dilakukan karena ketika laptop Anda berada dalam kondisi blue screen maka data atau tugas yang sedang Anda kerjakan menjadi hilang tanpa tersisa. Tentunya ini merupakan hal yang sangat menyebalkan apalagi jika itu merupakan tugas atau data Anda bersifat penting.</p>\r\n\r\n<p>Berikut adalah beberapa cara yang dapat Anda lakukan untuk mengatasi blue screen yang terjadi pada laptop Anda:</p>\r\n\r\n<p><strong>1. Scan Mallware</strong></p>\r\n\r\n<p>Cara mengatasi blue screen yang pertama adalah dengan scan malware. Ketika blue screen terjadi, maka secara otomatis atau default laptop Anda atau windows pada laptop Anda akan melakukan restart, dan ketika restart telah selesai maka akan sangat disarankan untuk Anda melakukan scan terhadap segala malware atau bahaya yang ada dalam laptop Anda menggunakan antivirus yang terpercaya.</p>\r\n\r\n<p>Dengan melakukan scan pada PC atau laptop Anda terhadap malware, Anda bisa mengetahui dan menghilangkan kemungkinan virus lain yang akan menyerang laptop Anda sehingga blue screen bisa dicegah dikemudian hari.</p>\r\n\r\n<p><strong>2. Masuklah Dalam Keadaan Safe Mode</strong></p>\r\n\r\n<p>Coba Anda masuk pada PC atau laptop Anda dalam keadaan safe mode. Dalam keadaan safe mode, Windows akan secara otomatis mengambil beberapa driver utama yang penting. Hal ini dapat dilakukan terutama ketika blue screen yang terjadi disebabkan karena Anda salah menginstall driver komputer Anda hingga menyebab blue screen.</p>\r\n\r\n<p><strong>3. Periksa Hardware pada PC atau Laptop Anda</strong></p>\r\n\r\n<p>Terjadinya blue screen pada PC atau laptop Anda tidak hanya disebabkan oleh masalah software saja akan tetapi terkadang juga masalah hardware Anda. Salah satu cara untuk mengatasi blue screen yang sepert ini adalah dengan melakukan pemeriksaan terhadap hardware PC atau laptop Anda. Anda dapat melakukannya dengan cara menggunakan aplikasi bawaan dari Windows yakni Memory Diagnostic Tool pada start menu.</p>\r\n\r\n<p><strong>4. Update Driver Anda</strong></p>\r\n\r\n<p>Terkadang blue screen dapat disebabkan karena kesalahan install driver atau driver tersebut tidak diupdate. Mengatasi blue screen dapat dilakukan dengan cara menginstall driver terbaru atau mengupdatenya. Namun perlu diingat terkadang ada beberapa driver pada PC atau laptop Anda yang tidak diperkenankan untuk diupdate driver-nya, karena biasanya kendala lain akan terjadi ketika Anda sudah meng-update driver pada PC atau laptop kesayangan Anda. Sangat disarankan hal ini dilakukan oleh ahlinya atau oleh orang yang telah berpengalaman.</p>\r\n\r\n<p><strong>5. Install Ulang Sistem Operasi Anda</strong></p>\r\n\r\n<p>Install ulang secara total sistem operasi pada PC atau laptop Anda adalah pilihan terakhir yang bisa Anda lakukan ketika Anda mengalami masalah blue screen. Dengan cara ini maka sistem yang berjalan pada PC atau laptop Anda akan berjalan seperti awal lagi dengan keadaan yang baru dan fresh.</p>\r\n\r\n<p>Jika cara di atas masih saja tidak dapat diatasi maka silahkan bawa PC atau laptop Anda pada service center atau teknisi yang Anda percayai untuk mengatasi masalah ini.</p>\r\n\r\n<p>Mudah-mudah informasi ini bermanfaat untuk Anda dan memberikan solusi pada komputer Anda yang bermasalah. Selamat mencoba. ^_^</p>', 'Terkadang disaat Anda sedang mengerjakan banyak pekerjaan pada PC atau laptop kesayangan Anda tiba-tiba laptop Anda mati dan muncul layar yang berwarna biru dengan seketika. Sehingga terkadang', 'post', 'Kamis', 2, 5, 2019, '2019-05-02', '00:13:00', '1556730780', '2019-05-02 00:13:00', '1556730805', 'blue-screen-pada-pc-atau-laptop-anda-berikut-cara-mengatasinya', 105, 1, 1, '', 'Afrioni', 'd44ada052019_0118_bsod727x485.jpg', 'post/052019', '', 0, 0),
(12, 'demo', 'Ternyata Video Call Orang Indonesia Lebih Lama Karena Sering Curhat Menurut Google', '', '', '<p>Aplikasi video call Duo dari Google yang sudah tersedia untuk para pengguna Android dan iOS di Indonesia sejak beberapa tahun lalu telah membuat banyak daftar saing aplikasi video call untuk Android dan iOS.</p>\r\n\r\n<p>Google sebagai raksasa internet telah mencatat adanya tren menarik berupa durasi penggilan<em> video call</em> untuk pengguna yang ada di Indonesia yang lebih lama 10 persen dibandingkan rata-rata global.</p>\r\n\r\n<p>Google menyebutkan lamanya durasi panggilan melalui video call ini dipengaruhi oleh budaya orang Indonesia. Orang Indonesia ternyata gemar berbicara dan<em> </em>ngobrol, termasuk salah satunya adalah curhat<em>. </em></p>\r\n\r\n<p>Fibriyani Elastria adalah sebagai Head of Consumer Marketing, Google Indonesia saat ditemui awak media di acara peluncuran fitur terbaru Google Duo di Jakarta, Rabu (24/4/2019) mengatakan &quot;Karena orang Indonesia itu sering cerita, sering<em> </em>curhat<em>,</em> sering ngobrol day to day,&quot;.</p>\r\n\r\n<p>Berdasarkan data internal Google yang diambil di beberapa kota besar yang ada di Indonesia dari kalangan berumur 18 tahun ke atas, sebanyak 75 persen pengguna melakukan video call karena mereka ingin menyampaikan rindunya kepada sang penerima.</p>\r\n\r\n<p>Sebanyak 48 persen dari pengguna tersebut menyampaikan rindu kepada pasangan mereka masing-masing sementara 40 persen ke sanak keluarga.</p>\r\n\r\n<p>Selain itu, Fibriyani turut mengklaim bahwa pengguna Duo di Indonesia merupakan yang terbanyak ketiga di dunia, setelah Amerika Serikat dan India. Kendati demikian, dia enggan mengungkapkan angka pastinya.</p>\r\n\r\n<p>Google mengatakan akan terus mendukung pengguna aplikasi Duo di Tanah Air dan mengembangkan aplikasi tersebut lebih lanjut.</p>\r\n\r\n<p>Salah satu bentuk perwujudannya adalah empat fitur baru yang menurut Google sengaja diterapkan di Google Duo dalam rangka menyambut Ramadan.</p>\r\n\r\n<p>&quot;Indonesia merupakan important market yang akan terus mendapatkan perhatian untuk mengembangkan proyeknya (Google Duo) lebih lanjut lagi,&quot; imbuh Fibriyani.</p>\r\n\r\n<p>Secara keseluruhan, mengacu pada data internal Google per Desember 2018, Fibriyani mengklaim jumlah pengguna Google Duo naik 94 persen dibandingkan dengan tahun 2017.</p>\r\n\r\n<p>Sumber: tekno.kompas.com</p>', 'Aplikasi video call Duo dari Google yang sudah tersedia untuk para pengguna Android dan iOS di Indonesia sejak beberapa tahun lalu telah membuat banyak daftar saing aplikasi video call untuk', 'post', 'Kamis', 2, 5, 2019, '2019-05-02', '15:48:00', '1556786880', '2019-05-02 15:48:00', '1556786913', 'ternyata-video-call-orang-indonesia-lebih-lama-karena-sering-curhat-menurut-google', 74, 1, 1, '', 'Afrioni', '825140052019_google_duo.jpg', 'post/052019', '', 0, 0);
INSERT INTO `memo_konten` (`kontenId`, `kontenUsername`, `kontenJudul`, `kontenJudulBesar`, `kontenJudulKecil`, `kontenPost`, `kontenRingkas`, `kontenType`, `kontenHari`, `kontenDd`, `kontenMm`, `kontenYy`, `kontenDate`, `kontenJam`, `kontenTimestamp`, `kontenDatetime`, `kontenAddDate`, `kontenSlug`, `kontenRead`, `kontenStatusKomen`, `kontenStatus`, `kontenEditor`, `kontenPenulis`, `kontenImg`, `kontenDirImg`, `kontenTextImg`, `kontenHeadline`, `kontenFeature`) VALUES
(13, 'demo', '8 Tipe USB yang Wajib untuk Kita Ketahui', '', '', '<p>USB merupakan sebuah konektor yang menghubungkan sebuah perangkat dengan perangkat lainnya. Pada zaman sekarang ini, USB merupakan sebuah benda yang sangatlah penting untuk kebutuhan transfer data antar perangkat, baik itu menggunakan <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a>, tablet, printer, mouse, <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">komputer</a>, laptop, <a href=\"https://www.prodigital.web.id/kategori/4/kamera.html\" target=\"_blank\">kamera</a> ataupun perangkat lainnya. Tidak hanya itu saja, USB juga dapat digunakan untuk menghubungkan power supply ataupun charger smartphone kesayangan kamu untuk mensupply tegangan ke baterai smartphone kamu.</p>\r\n\r\n<p>Tahukah kamu kepanjangan dari singkatan USB ini?. Ya, USB adalah singkatan dari Universal Serial Bus yang menghubungkan perangkat elektronik yang bersifat eksternal untuk berbagai kebutuhan.</p>\r\n\r\n<p>Jika kita melihat sekilas, semua port USB yang ada pada komputer atau laptop cenderung memiliki ukuran yang sama. Namun ternyata tidak. Ada banyak sekali jenis-jenis USB. Jenis-jenis USB ini dapat kita bedakan melalui bentuk fisiknya. Biasanya kita bisa mengenali bentuk port-nya. Selain dibedakan berdasarkan bentuk fisiknya, USB juga dapat dibedakan dari kecepatan transfer datanya. Mari kita simak pembahasan mengenai perbedaan jenis-jenis USB menurut bentuk fisik serta kecepatan transfer datanya di bawah ini.</p>\r\n\r\n<p><strong>1. USB Tipe A</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/a-Copy.jpg\" style=\"height:426px; width:600px\" /></p>\r\n\r\n<p>USB Tipe A merupakan salah satu dari sekian banyak tipe USB yang paling sering digunakan dan sangat mudah ditemukan dimana-mana. USB Tipe-A ini memiliki bentuk persegi dan cenderung lebar.</p>\r\n\r\n<p>Biasanya, tipe yang satu ini digunakan untuk menghubungkan perangkat atau periferal seperti mouse dan keyboard ke komputer ataupun laptop. Selain itu, USB Tipe A juga memiliki fungsi sebagai alat transfer data.</p>\r\n\r\n<p>Karena USB Tipe A ini merupakan salah satu jenis USB yang paling umum, USB Tipe A ini bisa dipakai di berbagai jenis port USB seperti USB 3.0, USB 2.0 hingga USB 1.1 yang terdapat pada komputer personal, laptop dan perangkat elektronik lainnya.</p>\r\n\r\n<p>Tidak hanya komputer personal dan laptop, konsol game seperti PlayStation, Xbox hingga Wifi dilengkapi dengan USB Tipe A. Beberapa alat elektronik seperti televisI, DVD dan Blu-Ray player juga menggunakan USB jenis ini.</p>\r\n\r\n<p><strong>2 USB Tipe B</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/USB-Type-B.jpg\" style=\"height:446px; width:600px\" /></p>\r\n\r\n<p>Jenis USB yang satu ini biasanya digunakan untuk menghubungkan perangkat tambahan seperti printer dan scanner ke komputer atau laptop. Tidak hanya itu, <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">hard drive</a> eksternal juga dilengkapi dengan USB Tipe B.</p>\r\n\r\n<p>Meski sama-sama berbentuk persegi, bentuk USB Tipe B tidak selebar pendahulunya yakni USB Tipe A. Dari sekian banyak jenis-jenis USB yang ada, USB Tipe B merupakan salah satu jenis USB yang tidak terlalu umum dan jarang digunakan.</p>\r\n\r\n<p><strong>3. Mini USB</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/mini-Copy.jpg\" style=\"height:450px; width:450px\" /></p>\r\n\r\n<p>Mini USB memiliki bentuk yang lebih kecil dibanding USB Tipe A. USB jenis ini merupakan jenis USB yang umumnya digunakan pada berbagai mobile device seperti smartphone. Fungsi dari mini USB pada smartphone adalah untuk membantu pengisian daya baterai atau charging.</p>\r\n\r\n<p>Selain smartphone, mini USB juga digunakan pada MP3 player serta beberapa kamera digital yang memiliki konektor dengan standar berbeda dari konektor pada umumnya. Namun kini, mini USB sudah jarang digunakan lagi. Penggunaan USB jenis ini sudah mulai berkurang sejak hadirnya Micro USB.</p>\r\n\r\n<p><strong>4. Micro USB Tipe A</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/5m-usb-2.0-micro-b-to-usb-a-cable-2763-p-Copy-1.jpg\" style=\"height:421px; width:600px\" /></p>\r\n\r\n<p>Diantara banyak jenis-jenis USB yang ada, micro USB merupakan salah satu jenis yang paling banyak digunakan saat ini. Micro USB dinilai sangat mobile friendly dibanding pendahulunya, mini USB. Salah satu jenis dari micro-USB adalah micro USB tipe-A.</p>\r\n\r\n<p>Micro USB Tipe A memiliki bentuk yang lebih lebar dan pipih jika dibandingkan dengan Mini USB. USB jenis ini biasanya ditemukan pada <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">ponsel</a>, kamera digital serta PDA. Micro USB Tipe A ini memiliki kecepatan transfer hingga 480 Mbps.</p>\r\n\r\n<p><strong>5. Micro USB Tipe B</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/micro-USB-Type-B.jpg\" style=\"height:449px; width:600px\" /></p>\r\n\r\n<p>Selain Micro USB Tipe A, ada satu tipe Micro USB lainnya yaitu micro USB Tipe B. Berdasarkan makeusof Terdapat perbedaan pada bentuk dari Micro USB ini. Jika Micro USB Tipe A memiliki bentuk persegi panjang yang lebar dan pipih dengan kedua ujung besi yang lurus, kedua ujung besi Micro USB Tipe B memiliki bentuk yang sedikit melengkung.</p>\r\n\r\n<p>Sama halnya dengan Micro USB Tipe A, Micro USB Tipe B juga banyak ditemukan pada ponsel, kamera digital dan PDA. Untuk kecepatan transfer, Micro USB Tipe A mempunyai ukuran kecepatan transfer yang sama dengan Tipe A yakni 480 Mbps.</p>\r\n\r\n<p><strong>6. USB Tipe C</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/c-Copy.jpg\" style=\"height:337px; width:600px\" /></p>\r\n\r\n<p>Jenis USB yang selanjutnya adalah USB Tipe C. USB Tipe C digadang-gadang sebagai salah satu jenis USB dengan kecepatan transfer data yang jauh lebih tinggi dibanding pendahulunya yakni Tipe A dan Tipe B. Dimasa depan, akan banyak perangkat yang menggunakan port USB ini.</p>\r\n\r\n<p>Penggunaan USB Tipe C sudah banyak diaplikasikan diberbagai pernagkat, seperti smartphone terbaru yang beredar saat ini. Sebenarnya, masih banyak juga smartphone yang masih memakai port Micro USB tetapi untuk beberapa smartphone kelas menengah dan hampir semua smartphone kelas atas sudah menggunakan port USB Tipe C.</p>\r\n\r\n<p><strong>7. Lightning</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/lt-Copy.jpg\" style=\"height:450px; width:450px\" /></p>\r\n\r\n<p>Kalau kamu pengguna iPhone atau iPad mungkin sudah tidak asing dengan yang namanya USB Lightning Cable. Ya, jenis USB yang satu ini adalah jenis USB yang memiliki ukuran hampir sama dengan Micro USB. Namun, Lightning USB dibuat khusus untuk produk Apple sehingga kompatibilitas dari USB ini sangat terbatas yakni hanya bisa digunakan pada produk Apple yang diproduksi setelah bulan September 2012.</p>\r\n\r\n<p>Lightning USB sendiri memiliki fungsi yang sama dengan USB pada umumnya yakni menghubungkan perangkat Apple seperti iPod, iPad ataupun iPhone ke komputer, kamera dan mengisi daya baterai.</p>\r\n\r\n<p><strong>8. USB On-The-Go</strong></p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/usb-otg-adapter-cable-for-lenovo-phab-maxbhi-9-5-1-Copy.jpg\" style=\"height:450px; width:450px\" /></p>\r\n\r\n<p>USB On-The-Go atau disingkat USB OTG memungkinkan penggunanya untuk membaca dan mentransfer data dari satu perangkat ke perangkat lainnya. Misalnya, dari flash disk ke smartphone. USB On-The-Go menjadikan smartphone sebagai host bagi flash disk yang terhubung, sehingga pengguna bisa membaca ataupun mentransfer file dari flash disk ke smartphone secara langsung tanpa menggunakan perantara PC ataupun laptop.</p>\r\n\r\n<p>Nah itulah bentuk bermacam-macam jenis USB yang harus kita ketahui. Jenis-jenis USB ini selain dapat dibedakan dari bentuk fisiknya, USB juga dapat dibedakan dari kecepatan transfer datanya. Mulai dari USB 1.1 dengan kecepatan 1.5 Mbps, ini bisa dibilang memiliki kecepatan yang terbilang sangat lambat, USB 2.0 sebesar 480 Mbps hingga USB 3.0 yang memiliki tingkat kecepatan transfer hingga sebesar 5 Gbps dan dijuluki sebagai USB Super Speed.</p>\r\n\r\n<p>Sejak awal kemunculannya pada tahun 90-an hingga saat ini, USB tetap memiliki peranan penting dalam menunjang berbagai jenis perangkat elektronik yang marak digunakan saat ini. Mulai dari PC, laptop bahkan hingga pemutar DVD agar dapat berfungsi dengan baik.</p>\r\n\r\n<p>Nah, itulah perkembangan teknologi USB yang perlu kita ketahui agar menambah wawasan kita dengan dunia teknologi. Karena dari wawasan itulah kita dapat belajar dan mengembangkan ilmu pengetahuan di dunia teknologi.</p>\r\n\r\n<p>Sumber: carisinyal.com</p>', 'USB merupakan sebuah konektor yang menghubungkan sebuah perangkat dengan perangkat lainnya. Pada zaman sekarang ini, USB merupakan sebuah benda yang sangatlah penting untuk kebutuhan transfer data', 'post', 'Kamis', 2, 5, 2019, '2019-05-02', '21:14:00', '1556806440', '2019-05-02 21:14:00', '1556806499', '8-tipe-usb-yang-wajib-untuk-kita-ketahui', 65, 1, 1, '', 'Afrioni', '8bbdfe052019_teknologiusb4bakalsecepat40gbps.jpg', 'post/052019', '', 0, 0),
(14, 'demo', 'Mengenal Fungsi Chipset di Smartphone dan Jenis-jenisnya', '', '', '<p>Pada <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a>, chipset tentunya hal yang wajib tersedia. Ponsel cerdas yang kamu gunakan untuk berbagai aktifitas seperti mendengarkan audio, video, kamera dan lainnya, disebabkan oleh adanya chipset.</p>\r\n\r\n<p>Chipset pada sebuah smartphone memiliki peranan lebih dari sekadar menghubungkan CPU, GPU, memori dan yang lainnya. Chipset atau system-on-chip (SoC) adalah sebuah <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">hardware</a> yang didalamnya terdapat berbagai komponen untuk mengatur dan memprosesan data, memproses grafis, <a href=\"https://www.prodigital.web.id/kategori/4/kamera.html\" target=\"_blank\">kamera</a>, modem, dan lainnya. Bisa dibilang, chipset adalah sebuah paket lengkap yang jadi &ldquo;otak&rdquo; utama dibalik kemampuan sebuah ponsel. Chipset ini juga berfungsi mengatur berbagai tugas komputasi dan menghubungkan berbagai hardware di motherboard.</p>\r\n\r\n<p><strong>Chipset dan Arsitektur ARM</strong></p>\r\n\r\n<p>Di dalam chipset sebuah perangkat smartphone, terdapat banyak sekali controller yakni untuk video, audio, tampilan layar, tipe RAM yang digunakan, modem (untuk kebutuhan <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\">internet</a>), dan fitur baru lainnya seperti pendukung pengisian baterai cepat atau fitur untuk memaksimalkan AI (Artificial Intelligence).</p>\r\n\r\n<p>Ukuran chipset ini sangat kecil namun terdapat banyak sekali fungsi. Bayangkan dengan bentuk yang kecil, terdapat banyak ruang untuk CPU, GPU, pengatur modem, ISP (Image Signal Prosesor), NSP dan lainnya. Hal ini tentu dimungkinkan karena chipset tidak sembarang dibangun tetapi melalui proses fabrikasi dan berdasarkan arsitektur tertentu.</p>\r\n\r\n<p>Coba perhatikan gambar berikut</p>\r\n\r\n<p><img alt=\"\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/Kirin-930.jpg\" style=\"height:294px; width:579px\" /></p>\r\n\r\n<p>Gambar di atas adalah sebuah arsitektur pada sebuah chipset. Terlihat bahwa di dalam ukuran yang kecil pada chipset, pembuat atau pendesain chipset mampu memasukan semua fungsi dan menjadi &quot;otak kecil&quot; dari sebuah perangkat pintar bernama smartphone.</p>\r\n\r\n<p>Bagaimana bisa sebuah hardware kecil bisa memiliki berbagai fungsi untuk menjalankan sebuah perangkat? Tentu saja dan kita perlu berterimakasih kepada ARM, perusahaan yang mendesain arsitektur prosesor ARM.</p>\r\n\r\n<p>Bagi yang belum tahu, ARM ini adalah pemilik lisensi dari arsitektur ARM yang kemudian dikembangkan menjadi sebuah chipset. ARM inilah yang jadi pendobrak lahirnya prosesor untuk mobile dan meninggalkan arsitektur x86, arsitektur yang digunakan AMD dan Intel untuk perangkat PC <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">komputer</a>.</p>\r\n\r\n<p>Prosesor dengan teknologi ARM kemudian jadi prosesor yang umum dipakai di smartphone, 90% lebih umumnya chipset yang dipakai di smartphone berasal dari ARM. Meskipun demikian, ARM sendiri bukanlah produsen chipset. ARM hanya pemegang lisensi atas teknologi ARM.</p>\r\n\r\n<p>Lisensi pertama yang disediakan ARM adalah memakai desain prosesor yang sudah dirancang ARM. Jika ada chipset yang memakai prosesor dengan nama Cortex dan GPU Mali, hal ini berarti produsen chipset tersebut memilih memakai desain prosesor ARM. Pasalnya, Cortex dan Mali adalah prosesor dan GPU yang dikembangkan oleh ARM.</p>\r\n\r\n<p>Lisensi kedua adalah lisensi untuk custom-core. Lisensi ini memungkinkan produsen mendesain ulang prosesornya asal kompatibel dengan arsitektur ARM. Ciri produsen chipset ini dapat dilihat dari nama prosesor dan pengolah grafisnya yang tidak memakai Cortex dan Mali.</p>\r\n\r\n<p>Lantas, siapa saja produsen chipset untuk smartphone atau perangkat mobile lain? Jawabannya, ada sekitar 5 pemain besar yang kelimanya memiliki izin lisensi arsitektur ARM. Ada juga produsen chipset lainnya yang jarang terdengar. Banyaknya produsen chipset ini membuat smartphone memiliki berbagai jenis chipset. Apa sajakah jenis-jenis tersebut? Simak pembahasannya berikut ini.</p>\r\n\r\n<p>Jenis-jenis Chipset yang Digunakan Pada Smartphone</p>\r\n\r\n<p><strong>1. Qualcomm Snapdragon</strong></p>\r\n\r\n<p>Snapdragon adalah chipset paling terkenal. Chipset ini dikembangkan oleh Qualcomm, perusahaan asal Amerika yang belakangan fokus menghadirkan chipset untuk berbagai platform. Qualcomm sendiri memiliki izin lisensi mendesain prosesor dari ARM.</p>\r\n\r\n<p>Karena izin lisensi tersebut, chipset Snapdragon ada yang tidak memakai prosesor Cortex. Qualcomm mengembangkan prosesornya dengan nama Kryo. Selain itu, pengolah grafis atau GPU yang ada di Snapdragon bukanlah Mali tetapi Adreno.</p>\r\n\r\n<p>Adreno ini awalnya dimiliki ATI Radeon dengan nama Imageon. Tahun 2006, ATI Radeon dibeli oleh AMD. Akusisi ini menyebabkan Imageon, proyek pengembangan prosesor grafis untuk mobile terbengkalai. Tahun 2009, Qualcomm membeli Imageon dari ATI (yang sudah dimiliki AMD) dan mengubahnya menjadi Adreno, anagram dari Radeon.</p>\r\n\r\n<p>Gabungan prosesor Kryo dan grafis Adreno ini banyak ditemukan di chipset Qualcomm kelas atas dan menengah, sebut saja Qualcomm Snapdragon 855, Snapdragon 845, Snapdragon 730, Snapdragon 636, dan lainnya. Snapdragon sendiri jadi chipset yang paling banyak disuka pengguna, tidak heran banyak vendor ponsel yang memilih Snapdragon sebagai chipset pilihan terbaik.</p>\r\n\r\n<p><strong>2. Apple A (Fusion,Bionic)</strong></p>\r\n\r\n<p>Serupa dengan Qualcomm, Apple memiliki lisensi mengembangkan prosesor sendiri dengan basis arsitektur ARM. Apple mengembangkan chipset mereka dengan nama yang mudah yakni seri A yang kemudian diikuti huruf seperti A7, A8, A9, dan seterusnya.</p>\r\n\r\n<p>Sejak seri A10, Apple menambahkan nama tambahan dibelakang seri chipset besutan mereka. Misalnya, A10 memiliki nama resmi Apple A10 Fusion. Selanjutnya ada A11 dengan nama A11 Bionic. Nama Bionic dipertahankan saat Apple mengeluarkan chipset generasi penerusnya, yakni A12 Bionic. Apple A12 Bionic inilah yang jadi otak alias chipset yang ada di seri Apple iPhone XS, XS Max, dan XR.</p>\r\n\r\n<p>Serupa dengan sistem operasi dan produk mereka yang eksklusif, chipset yang dikembangkan oleh Apple ini juga hadir eksklusif untuk perangkat Apple, tidak hanya untuk smartphone tentunya. Contohnya adalah varian Apple A12 Bionic, yakni A12X Bionic yang dipakai jadi &quot;otak&quot; dari iPad Pro 11 inci dan iPad Pro 12,9 generasi ketiga.</p>\r\n\r\n<p><strong>3. MediaTek</strong></p>\r\n\r\n<p>MediaTek termasuk salah satu produsen chipset yang cukup besar. Perusahaan asal Taiwan ini konsisten menghadirkan chipset dengan fitur tinggi tetapi dengan harga yang terjangkau. Pada awalnya, MediaTek dikenal sebagai produsen chipset yang kurang begitu baik. Banyak yang menganggap ponsel dengan chipset dari MediaTek seringkali cepat panas dan performanya kurang kencang.</p>\r\n\r\n<p>MediaTek pun berbenah dan menghadirkan beberapa chipset yang bagus seperti Helio P60 dan Helio P70. Banyak chipset dari MediaTek yang dipakai di ponsel murah di kisaran harga Rp1 jutaan atau Rp2 jutaan. Beberapa vendor ponsel lokal juga banyak yang memakai MediaTek sebagai chipset karena ongkos produksinya lebih murah.</p>\r\n\r\n<p>MediaTek memiliki prosesor dengan nama Cortex tetapi untuk GPU, kadang memakai Mali, kadang juga memakai PowerVR. Bisa jadi MediaTek memiliki lisensi semi-custom ARM yang memungkinkan produsen mengembangkan bagian tertentu dari sebuah chipset.</p>\r\n\r\n<p><strong>4. Samsung Eyxnos</strong></p>\r\n\r\n<p>Selain dikenal sebagai produsen ponsel ternama, Samsung juga dikenal sebagai produsen chipset. Samsung mengembangkan chipset sendiri dengan nama Exynos. Chipset ini tidak kalah secara performa jika dibandingkan dengan Snapdragon, bahkan performanya cenderung bersaing.</p>\r\n\r\n<p>Chipset Exynos sendiri banyak dipakai di ponsel besutan Samsung. Kabarnya, Samsung ingin menjual chipset ke produsen lain tetapi terhambat karena urusan hak paten dengan Qualcomm. Menariknya, Meizu, produsen asal Tiongkok memiliki beberapa produk ponsel yang memakai chipset Exynos.</p>\r\n\r\n<p>Exynos sendiri terdiri dari prosesor Cortex dan GPU Mali. Jarang sekali Samsung mengubah kedua bagian ini. Entah lisensi mana yang Samsung pakai tetapi Exynos hadir sebagai chipset yang bagus, terlebih untuk Exynos 9820 yang digunakan di perangkat Samsung Galaxy S10 series.</p>\r\n\r\n<p><strong>5. HiSilicon Kirin (Huawei)</strong></p>\r\n\r\n<p>Lewat anak perusahaan bernama HiSilicon, Huawei mengembangkan chipset mereka sendiri. Chipset besutan Huawei bernama Kirin yang berasal dari arsitektur ARM. Chipset Kirin ini khusus dibuat untuk ponsel besutan Huawei dan Honor, sub-brand dari Huawei.</p>\r\n\r\n<p>Chipset Kirin awalnya kurang begitu diperhitungkan mengingat ponsel Huawei dengan Kirin jarang mendapat sorotan. Baru ketika Huawei merilis Huawei P20 Pro yang dibekali Kirin 970, Kirin pun dianggap sebagai chipset yang mumpuni. Huawei pun menghadirkan penerusnya, yakni Kirin 980 yang performanya lebih kencang.</p>\r\n\r\n<p>Satu hal yang menarik dari chipset Kirin adalah penambahan fitur di dalamnya. Huawei menanamkan dua fitur penting untuk chipset Kirin, yakni HiAi dan GPU Turbo. Dari namaya, fitur HiAI jelas jadi fitur untuk mengoptimalkan kemampuan kecerdasan buatan. GPU Turbo sendiri adalah fitur di chipset Kirin yang berfungsi untuk meningkatkan kemampuan chipset dalam menjalankan game yang populer.</p>\r\n\r\n<p><strong>6. Spreadtrum</strong></p>\r\n\r\n<p>Produsen chipset lainnya adalah Spreadtrum Communications. Perusahaan yang bermarkas di Shanghai ini memiliki beberapa chipset dengan nama Spreadtrum. Produsen ponsel kelas atas jarang memakai chipset besutan Spreadtrum. Kebanyakan yang memakai chipset Spreadtrum adalah vendor kelas bawah.</p>\r\n\r\n<p>Beberapa produsen ponsel dalam negeri ada yang memakai chipset Spreadtrum. Salah satunya adalah SPC. Beberapa ponsel besutan SPC di bawah harga Rp1 juta ada yang memakai chipset Spreadtrum.</p>\r\n\r\n<p><strong>7. Nvidia Tegra</strong></p>\r\n\r\n<p>Produsen kartu grafis untuk PC, Nvidia, juga ikut bermain diranah mobile. Perusahaan ini menghadirkan chipset berarsitektur ARM dengan nama Nvidia Tegra. Nvidia Tegra ini dihadirkan sebagai chipset untuk perangkat mobile yang fokus pada gaming.</p>\r\n\r\n<p>Sayangnya, Nvidia tampaknya kurang fokus pada industri mobile. Perusahaan ini lebih fokus pada pengembangan produk kartu grafis untuk komputer. Hal ini tentu berpengaruh pada Nvidia Tegra yang jarang dilirik oleh produsen ponsel atau produsen tablet.</p>\r\n\r\n<p><strong>8. Produsen Chipset Lain</strong></p>\r\n\r\n<p>Selain tujuh nama yang sudah disebutkan sebelumnya, banyak perusahaan lain yang juga memproduksi chipset. Umumnya perusahaannya kecil dan fokus pada perangkat tertentu. Seperti halnya Rockchip yang memproduksi chipset untuk perangkat TV Box.</p>\r\n\r\n<p>Intel, perusahaan raksasa di ranah PC juga pernah menghadirkan chipset untuk mobile. Perusahaan ini pernah jadi otak dibalik ponsel Asus Zenfone generasi pertama. Sayangnya, Intel mengangkat bendera putih dan kembali ke ranah prosesor arsitektur x86.</p>\r\n\r\n<p>Menyerahnya Intel ini disebabkan karena prosesor Intel untuk perangkat mobile tidak berkembang. Isu prosesor cepat panas dan terbatasnya dukungan game pada Android kabarnya jadi salah satu penyebab prosesor Intel untuk mobile tidak diteruskan.</p>\r\n\r\n<p>Sebenarnya ada banyak lagi perusahan yang memproduksi bisnisnya. Namun tidak begitu fokus dan akhirnya menghilang. Faktor dari pemasaran dan peluang bisnis sebenarnya yang menjadi fokus utama.</p>\r\n\r\n<p>Semoga ini menambah wawasan kita untuk Mengenal Fungsi Chipset di Smartphone dan Jenis-jenisnya.</p>\r\n\r\n<p>Sumber: carisinyal.com</p>', 'Pada smartphone, chipset tentunya hal yang wajib tersedia. Ponsel cerdas yang kamu gunakan untuk berbagai aktifitas seperti mendengarkan audio, video, kamera dan lainnya, disebabkan oleh adanya', 'post', 'Sabtu', 4, 5, 2019, '2019-05-04', '09:14:00', '1556936040', '2019-05-04 09:14:00', '1556936092', 'mengenal-fungsi-chipset-di-smartphone-dan-jenis-jenisnya', 128, 1, 1, '', 'Afrioni', '001141052019_chipsetsmartphone.jpg', 'post/052019', '', 0, 0),
(15, 'demo', 'Huawei, Xiaomi dan Oppo Rilis Smartphone 5G di Swiss', '', '', '<p>Swiss melalui perusahaan telekomunikasi Sunrise, akan membuat teknologi 5G menjadi semakin nyata. Sunrise mengumumkan bahwa pekan ini mereka mulai menawarkan tiga <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> 5G dari tiga merek asal Cina, yaitu Huawei, Xiaomi dan Oppo.</p>\r\n\r\n<p>Dilansir laman GSM Arena, Selasa, 30 April 2019, Huawei menghadirkan Mate 20 X 5G. Versi tersebut adalah yang terbesar dari seri Mate 20 yang pertama kali diluncurkan Oktober lalu di London, Inggris.</p>\r\n\r\n<p>Beberapa pekan terakhir, terdengar isu bahwa varian 5G dan peluncurannya pertama kali akan dibesut oleh Sunrise. Smartphone dengan brand Huawei ini memiliki baterai lebih kecil yaitu 4.200 mAh, dibandingkan versi standarnya yakni 5.000 mAh, namun diimbangi dengan fitur Super Charge 40W yang lebih cepat. Harga <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">ponsel</a> ini dibanderol senilai US$ 978 atau setara 13,7 juta rupiah. Yah, cukup untuk menguras dompet kamu.</p>\r\n\r\n<p>Sementara itu, Xiaomi pertama kali mengumumkan smartphone 5G andalannya Mi Mix 3, pada Februari lalu dalam acara Mobile World Congress (MWC) yang digelar di Barcelona, Spanyol. Mi Mix 3 dibekali dengan <a href=\"https://www.prodigital.web.id/post/14/mengenal-fungsi-chipset-di-smartphone-dan-jenis-jenisnya.html\" target=\"_blank\">chipset</a> Snapdragon 855 yang diperbarui untuk mendukung modem Qualcomm X50 5G.</p>\r\n\r\n<p>Xiaomi juga telah mengumumkan kemitraannya dengan berbagai operator yang ada di seluruh Uni Eropa, termasuk Three, Oranye, Telefonica, TIM, Vodafone, dan Sunrise, yang merupakan yang pertama untuk mendapatkannya. Xiaomi juga mengumumkan kerangka waktu peluncuran pada Mei, dan kabarnya mulai dijual di Swiss pada hari Kamis, 2 Mei 2019 kemarin.</p>\r\n\r\n<p>Untuk harga, Mi Mix 3 5G awalnya dinilai dengan 599 Euro setara dengan 9,6 juta rupiah, namun dengan melihat konsumen, kemungkinan akan membayar lebih dari itu. Operator Swiss akan melabeli ponsel 5G itu seharga US$ 831 sekitar 11,6 juta rupiah. Harga ini merupakan yang termurah dibandingkan dengan smartphone 5G lainnya.</p>\r\n\r\n<p>Adapun Oppo baru-baru ini mengumumkan seri Oppo Reno, untuk varian 5G yang akan tiba di Zurich sebagai bagian dari kemitraan Swisscom. Swisscom adalah operator pertama yang meluncurkan varian 5G yang dilengkapi dengan 256 GB penyimpanan internal, kamera zoom 10x, dan RAM 8GB.</p>\r\n\r\n<p>Smartphone dengan daya baterai 4.065 mAh itu bakal dihargai US$ 980 setara dengan 13,7 juta rupiah dan akan tersedia di toko-toko pada 1 Mei 2019.</p>\r\n\r\n<p>Sunrise Communications AG memiliki <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\">jaringan</a> 5G pertama di Swiss, yang mencakup lebih dari 150 kota dengan 5G sejak awal April. Sunrise berencana untuk menyelesaikan peluncuran 5G secara nasional pada akhir 2019.</p>\r\n\r\n<p>Sumber: tempo.co</p>', 'Swiss melalui perusahaan telekomunikasi Sunrise, akan membuat teknologi 5G menjadi semakin nyata. Sunrise mengumumkan bahwa pekan ini mereka mulai menawarkan tiga smartphone 5G dari tiga merek', 'post', 'Sabtu', 4, 5, 2019, '2019-05-04', '12:20:00', '1556947200', '2019-05-04 12:20:00', '1556947223', 'huawei-xiaomi-dan-oppo-rilis-smartphone-5g-di-swiss', 135, 1, 1, '', 'Afrioni', '1c6491052019_5g100719145large.jpg', 'post/052019', '', 0, 1),
(16, 'demo', 'Smartphone Huawei Tumbuh Melewati iPhone, Ancam Samsung', '', '', '<p>Enam kuartal berturut-turut pasar smartphone atau ponsel pintar mengalami penurunan sejauh ini. Para pemimpin pasar seperti Apple dan Samsung benar-benar merasakan sakitnya, tapi tidak dengan Huawei.</p>\r\n\r\n<p>Menguat di Eropa, Huawei mengalami pertumbuhan penjualan <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> 50 persen pada Q1 tahun ke tahun, sementara Apple anjlok 30 persen, menurut IDC sebagaimana dilaporkan Toms Guide, akhir pekan ini.</p>\r\n\r\n<p>Samsung tidak seburuk Apple, tetapi pengirimannya masih turun 8 persen, dan itu sebelum termasuk bencana Galaxy Fold.</p>\r\n\r\n<p>Bagian yang menakutkan adalah ponsel Huawei bahkan tidak dijual secara resmi di Amerika Serikat. Ini sebagian besar karena masalah keamanan dan tautan yang dilaporkan antara Huawei dan pemerintah Cina. Huawei telah membantah klaim tersebut dan menuntut pemerintah Amerika Serikat. Namun Huawei tetap berkembang.</p>\r\n\r\n<p>&quot;Huawei tidak perlu memiliki posisi di Amerika Serikat,&quot; kata Peter Richardson dari Counterpoint Research. &quot;Bekerja dengan operator Amerika Serikat bisa mahal karena kebutuhan untuk pengujian ekstensif dan kemudian dukungan pemasaran.&quot;</p>\r\n\r\n<p>Terlepas dari kontroversi politik, Huawei telah menjadi salah satu pembuat smartphone paling inovatif selama beberapa tahun terakhir. Misalnya, pada tahun 2016, Huawei P9 adalah ponsel pertama yang direkayasa bersama dengan Leica dengan penembak dua lensa.</p>\r\n\r\n<p>Huawei Mate 10 pada 2017 adalah smartphone pertama dengan <a href=\"https://www.prodigital.web.id/post/14/mengenal-fungsi-chipset-di-smartphone-dan-jenis-jenisnya.html\" target=\"_blank\">chipset</a> AI tertanam. Dan Huawei Mate 20 Pro tahun lalu adalah ponsel pertama di dunia yang menawarkan pengisian daya nirkabel terbalik (jauh sebelum Galaxy S10).</p>\r\n\r\n<p>Sumber: tekno.tempo.co</p>', 'Enam kuartal berturut-turut pasar smartphone atau ponsel pintar mengalami penurunan sejauh ini. Para pemimpin pasar seperti Apple dan Samsung benar-benar merasakan sakitnya, tapi tidak dengan', 'post', 'Minggu', 5, 5, 2019, '2019-05-05', '23:19:05', '1557073145', '2019-05-05 23:19:05', '1557073145', 'smartphone-huawei-tumbuh-melewati-iphone-ancam-samsung', 81, 1, 1, '', 'Afrioni', '02bf31052019_839139_720.jpg', 'post/052019', '', 0, 0),
(17, 'demo', 'Kamera Periskop, Persaingan Teknologi Kamera Baru Pada Smartphone', '', '', '<p>Teknologi periskop pada kamera <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> adalah teknologi baru yang digunakan para vendor kamera untuk bisa melakukan perbesaran gambar optikal. Teknologi ini akan menjadi teknologi yang sangat bersaing kedepannya dalam perkembangan smartphone atau ponsel pintar kamu. Sebelumnya persaingan kamera smartphone ini adalah perang pixel yang lebih besar dan teknologi multilensa.</p>\r\n\r\n<p>Keterbatasan akan tempat untuk menempatkan lensa dikarenakan ukuran sebuah smartphone yang tipis menjadi faktor munculnya teknologi kamera periskop pada smartphone ini. Biasanya, selama ini perbesaran objek secara optik terbatas dan hanya bisa dilakukan 2 atau 3 kali saja. Dengan teknologi kamera periskop, perbesaran objek bisa dilakukan hingga 5 kali bahkan sampai 10 kali.</p>\r\n\r\n<p>Bagi kamu yang sering sekali mengambil gambar dengan menggunakan smartphone untuk perbesaran optik ini merupakan hal yang penting, karena sering kita tidak bisa mendekati objek saat mau mengambil gambar. Untuk mendekati objek pada kamera, opsi zoom adalah menjadi pilihan. Karena melakukan perbesaran gambar secara digital. Namun sering kali perbesaran digital ini membuat gambar pecah dan tidak bagus. Dibandingkan dengan perbesaran digital, perbesaran lensa atau optik menghasilkan gambar yang lebih baik.</p>\r\n\r\n<p>Agar kamera dapat melakukan perbesaran optik dengan sempurna, saat ini para vendor menerapkan prinsip periskop pada kameranya. Mirip dengan prinsip periskop pada umumnya, perbesaran optik dengan <a href=\"https://www.prodigital.web.id/kategori/4/kamera.html\" target=\"_blank\">kamera</a> periskop dilakukan dengan menyusun komponen kamera smartphone, seperti lensa kamera dan sensor gambar, disusun berbeda.</p>\r\n\r\n<p><img alt=\"Teknologi kamera periskop\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/d09a2391-2347-43ec-ad56-1d73f240e94c_169.jpeg\" style=\"height:348px; width:620px\" /></p>\r\n\r\n<p>Para vendor yang menggunakan teknologi ini yakni membelokkan 90 derajat saat menyusun lensa-lensa ini secara horizontal yang ada pada ujung deretan lensa. Pada ujung deretan lensa ini terdapat cermin untuk membelokkan objek yang akan ditangkap, agar bisa masuk ke dalam lensa dan berakhir pada sensor gambar. Oppo menyebut teknik ini sebagai folded optik (optik yang dilipat).</p>\r\n\r\n<p>Teknologi kamera periskop ini dilengkapi dengan cermin yang mengarahkan cahaya yang masuk serta dipantulkan mengenai sensor gambar pada smartphone, seperti cara kerja periskop pada dunia nyata.</p>\r\n\r\n<p>Pada smartphone dengan multi kamera, kemampuan memperbesar gambar biasanya dilakukan oleh sensor kamera kedua yang menggunakan lensa yang bisa menangkap lebih jauh.</p>\r\n\r\n<p>Dilansir dari Ars Technica, kamera zoom ini terdiri dari berbagai lensa kecil. Beberapa lensa bahkan bergerak, agar dapat menyesuaikan fokus pada objek. Oleh karena itu, kamera ini membutuhkan lebih banyak tempat untuk menyusun lensa-lensa tersebut.</p>\r\n\r\n<p>Namun kamera pada smartphone tidak bisa terlalu menonjol. Samsung pernah mencoba mengakalinya dengan membuat smartphone dimana bagian belakangnya terdapat kamera yang bisa di-zoom-in dan zoom-out lewat Galaxy K Zoom. Tapi dengan bodi ponsel yang bongsor dan berat, menjadikan ponsel ini tak populer di pasaran.</p>\r\n\r\n<p>Oleh karena itu, saat ini kebutuhan zoom pada kamera smartphone diakali dengan desain periskop. Dari luar, ponsel milik Huawei terlihat normal dengan susunan rangkaian empat kamera yakni satu lensa ultra lebar 16 milimeter, satu lensa lebar 27 milimeter, lensa telephoto 125 milimeter, serta kamera pendeteksi kedalaman gambar atau kamera depth.</p>\r\n\r\n<p>Perbedaan terlihat pada sensor kamera telephoto yang berbentuk kotak. Dalam sensor kamera berbentuk kotak tersebut, lensa pembesar gambar, serta sensor CMOS (komponen sensor gambar yang berfungsi menampilkan apa yang dilihat lensa kamera ke pengguna) disusun 90 derajat mendatar.</p>\r\n\r\n<p>Untuk dapat mengambil gambar, sebuah cermin berbentuk kotak menjadi jalan masuknya cahaya, lensa tinggal memotret apa yang dipantulkan di cermin tersebut. Huawei juga menonjolkan sensor CMOS mereka sebagai sensor yang menerapkan pixel &#39;RYYB&#39;, dimana sensor CMOS biasa menggunakan &#39;RGGB&#39; (satu pixel merah, dua pixel hijau, dan satu pixel biru).</p>\r\n\r\n<p>&#39;RYYB&#39; yang mengganti pixel hijau menjadi kuning, diklaim Huawei dapat mengambil gambar dengan 40 persen lebih banyak cahaya, serta perangkat lunak yang dapat menyempurnakan hasil foto tersebut.</p>\r\n\r\n<p>Oppo juga menggunakan konsep yang sama. Namun, vendor China ini mengklaim ponselnya bisa melakukan perbesaran gambar hingga sepuluh kali lipat. Tiga rangkaian kameranya nanti akan terdiri dari satu lensa lebar 15,9 milimeter, satu kamera utama yang menentukan kedalaman gambar, serta satu kamera telephoto 159 milimeter.</p>\r\n\r\n<p><img alt=\"kamera periskop oppo\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/kameraperiskopoppo.jpg\" style=\"height:425px; width:640px\" /></p>\r\n\r\n<p>Dilansir dari Extreme Tech, Oppo akan menghadirkan dua penyeimbang gambar pada rangkaian kameranya. Namun perusahaan tersebut belum mengumumkan aperture pada setiap lensa kamera yang ada.</p>\r\n\r\n<p>Sehingga belum diketahui apakah penyeimbang gambar nantinya akan dapat bekerja sesuai dengan kecepatan shutter, atau apakah akan ada masalah pada fokus kamera tersebut ketika melakukan zoom.</p>\r\n\r\n<p>Bagi kamu yang menyukai fotografi tidak salahnya mencoba smartphone ini karena telah dilengkapi dengan teknologi kamera yang sudah cukup canggih.</p>\r\n\r\n<p>Sumber: cnnindonesia.com</p>', 'Teknologi periskop pada kamera smartphone adalah teknologi baru yang digunakan para vendor kamera untuk bisa melakukan perbesaran gambar optikal. Teknologi ini akan menjadi teknologi yang sangat', 'post', 'Senin', 6, 5, 2019, '2019-05-06', '04:50:00', '1557093000', '2019-05-06 04:50:00', '1557093035', 'kamera-periskop-persaingan-teknologi-kamera-baru-pada-smartphone', 185, 1, 1, '', 'Afrioni', '97192b052019_teknologiperiskopkamera.jpg', 'post/052019', '', 0, 1),
(18, 'demo', 'Tips Agar Komputer Tidak Terserang Virus', '', '', '<p><a href=\"https://www.prodigital.web.id/post/18/tips-agar-komputer-tidak-terserang-virus.html\" target=\"_blank\">Tips Agar Komputer Tidak Terserang Virus</a> - Memiliki perangkat elektronik seperti komputer ataupun <a href=\"https://www.prodigital.web.id/kategori/7/laptop.html\" target=\"_blank\">laptop</a>, tentunya tidak lepas dari masalah serangan virus, ransomware, malware, worm dan sejenisnya. Terutama jika memiliki usaha yang berbasis online, segala carapun &quot;dihalalkan&quot; agar semua perangkat yang kita gunakan aman.</p>\r\n\r\n<p>Walaupun bukan pelaku usaha berbasis online, tentunya keamanan adalah hal yang penting. Beragam file seperti tugas kampus, materi kuliah, software dan film bahkan file skripsi akan dijaga dengan ketat.</p>\r\n\r\n<p>Virus terkadang datang tanpa kita sadari, atau kita lupa bahwa mungkin kita telah melakukan sesuatu pada komputer kita. Virus bisa masuk pada komputer kita melalui beberapa hal seperti; mengakses <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\">internet</a> dimana terdapat situs yang mengandung virus atau malware, colokan flashdisk ataupun <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">harddrive</a> orang lain yang telah terjangkit virus dari komputer lain ataupun <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">komputer</a> yang telah terjangkit virus dan komputer kita berada dalam jaringan komputer tersebut.</p>\r\n\r\n<p>Untuk mengantisipasi hal-hal yang berkaitan dengan virus ini, tentunya komputer kita harus memiliki perawatan yang cukup pada <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\">software</a> yang ada didalamnya. Nah, supaya komputer kita tidak mudah terkena virus dkk, yuk praktikkan beberapa tips berikut.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>1. Gunakan antivirus yang udah terjamin kualitasnya</strong></span></p>\r\n\r\n<p>Beberapa software antivirus populer seperti Avast, AVG, Kaspersky dan Avira dapat dipertimbangkan untuk melindungi komputer dari berbagai serangan yang bersifat merusak. Jika memiliki dana lebih, belilah produk tersebut untuk tingkat keamanan lebih tinggi.</p>\r\n\r\n<p>Namun, versi gratis juga tidak kalah hebatnya dengan yang berbayar namun tentunya fasilitas yang didapatkan terbatas. Bagi Anda yang suka gratisan, Anda mempertimbangkan Avast versi free atau antivirus gratis buatan Microsoft, Windows Defender.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>2. Selalu update semua aplikasi pada komputer Anda</strong></span></p>\r\n\r\n<p>Pembaharuan sebuah aplikasi tidak hanya untuk mengatasi bug yang ada atau penambahan fitur. Biasanya pembaharuan sebuah aplikasi juga membawa patch untuk menutupi celah keamanan dan meningkatkan keamanan aplikasi tersebut.</p>\r\n\r\n<p>Jadi, pastikan semua aplikasi yang digunakan adalah versi yang paling terbaru.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>3. Sebaik mungkin, gunakan OS versi terbaru</strong></span></p>\r\n\r\n<p>Jika Anda pengguna Windows lawas, sebaiknya segeralah untuk upgrade ke Windows 10. Selain mendapat dukungan aplikasi yang lebih banyak, Windows 10 juga diklaim aman oleh Microsoft. Begitu pula jika Anda menggunakan perangkat buatan Apple, pastikan perangkat Anda berada pada OS paling terbaru.</p>\r\n\r\n<p><span style=\"font-size:14pt\"><strong>4. Instal aplikasi hanya dari sumber terpercaya</strong></span></p>\r\n\r\n<p>Sebaiknya install lah aplikasi dari sumber terpercaya seperti Windows Store (Sekarang Microsoft Store) atau dari website resmi penyedia aplikasi/<a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\">software</a> tersebut. Meskipun sudah menginstal dari sumber terpercaya, ada baiknya kita berhati-hati sebab sekarang ini banyak aplikasi palsu yang berseliweran di Store resmi. Untuk mencegahnya, kita perlu melihat rating dan komentar pengguna aplikasi tersebut.</p>\r\n\r\n<p>Namun, tidak perlu khawatir berlebihan. Kebanyakan virus, ransomware, worm dan sejenisnya biasanya menargetkan perusahaan skala besar karna keuntungan yang didapatnya lebih besar ketimbang individu. Lagi pula, jika sudah mempraktekkan 4 tips di atas, Anda sudah tidak perlu lagi khawatir dengan hal tersebut.<br />\r\n<br />\r\nYuk share artikel ini jika bermanfaat dan silahkan tinggalkan komentar Anda. Silahkan tunggu tips dan trik terbaru dari artikel <a href=\"https://www.prodigital.web.id/\" target=\"_blank\">Pro Digital</a>.</p>', 'Tips Agar Komputer Tidak Terserang Virus - Memiliki perangkat elektronik seperti komputer ataupun laptop, tentunya tidak lepas dari masalah serangan virus, ransomware, malware, worm dan', 'post', 'Senin', 6, 5, 2019, '2019-05-06', '13:33:00', '1557124380', '2019-05-06 13:33:00', '1557124418', 'tips-agar-komputer-tidak-terserang-virus', 109, 1, 1, '', 'Afrioni', '6fd0ea052019_tf9wy_126.jpg', 'post/052019', '', 0, 0),
(19, 'demo', 'Android Q Dapat Hidupkan Mode Gelap Otomatis', '', '', '<p><a href=\"https://www.prodigital.web.id/post/19/android-q-dapat-hidupkan-mode-gelap-otomatis.html\" target=\"_blank\">Android Q Dapat Hidupkan Mode Gelap Otomatis</a> - Siapa yang tidak kenal dengan sistem operasi <a href=\"https://www.prodigital.web.id/kategori/12/android.html\" target=\"_blank\">Android</a>. Ya, sistem operasi ini memang sangat populer pada smartphone kita. Perkembangannya pun juga sangat pesat sekali. Sistem operasi di bawah naungan Google ini memang sangat diminati para penggunanya dengan kemudahan dan banyak sekali <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\">aplikasi</a> yang ditawarkan oleh sistem operasi ini. Selain itu, sistem operasi ini juga digemari oleh para pengembang aplikasi yang berbasis Android.</p>\r\n\r\n<p>Salah satu sistem operasinya yakni Android Q akan memperkenalkan fitur uniknya yaitu mode gelap sistem lebar (system-wide dark mode). Fitur ini telah disebarluaskan namun masih dalam versi beta dan dapat diatur jadwal aktivasinya.</p>\r\n\r\n<p>Kelebihan dari fitur ini adalah kamu tidak perlu repot-repot menyalakan atau mematikan mode gelap pada <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> kamu nantinya.</p>\r\n\r\n<p>Fitur ini juga akan bekerja sesuai dengan jadwal yang sudah diatur. Misal, saat malam hari mode gelap pada fitur ini akan aktif dan akan mati pada pagi harinya. Pengguna tentunya harus menyetel pengaturan aktifasi mode gelapnya untuk malam hari. Lalu ia dapat juga menjadwalkan kapan mode gelap ini akan dinonaktifkan.</p>\r\n\r\n<p>Fitur mode gelap ini tentunya akan mempermudah pengguna yang tanpa harus menyalakan atau mematikan mode gelap secara manual pada smartphone mereka.</p>\r\n\r\n<p>Selain itu, pada mode gelap ini juga dapat mendeteksi kapan baterai smartphone kamu akan kritis. Saat baterai smartphone akan kritis maka smartphone kamu akan mati lebih awal secara otomatis.</p>\r\n\r\n<p>Google juga menyatakan bahwa pada mode gelap ini sangat membantu untuk penghematan masa pakai baterai pada smartphone kamu. Dikabarkan bahwa berkat mode gelap ini konsumsi daya pada baterai ternyata dapat hemat hingga 50 persen. Terlihat bahwa, kurangnya cahaya pada layar smartphone pengguna tentunya mempengaruhi berapa banyak kapasitas baterai yang terpakai.</p>\r\n\r\n<p>Fitur mode gelap ini ternyata bukanlah hal baru pada Android Q. Fitur yang sama sebenarnya sudah ditanamkan pada versi beta sebelumnya.</p>\r\n\r\n<p>Untuk informasi, tanggal 13 Maret 2019, Android Q Beta 1 telah diluncurkan dan dapat diunduh untuk seri Pixel, Pixel 2, dan Pixel 3. Untuk Beta 2 telah diluncurkan pada 3 April lalu, Beta 3 akan diluncurkan pada awal Mei dan Beta 4 pada awal Juli.</p>\r\n\r\n<p>Sayangnya, pihak Google masih belum mau menginformasikan mengenai kapan peluncuran OS Android Q atau Android generasi kesepuluh ini.</p>\r\n\r\n<p>Untuk Beta 5, Beta 6 dan peluncuran final kemungkinan akan dilakukan pada kuartal ke-3 tahun ini.</p>\r\n\r\n<p>Sumber: liputan6.com</p>', 'Android Q Dapat Hidupkan Mode Gelap Otomatis - Siapa yang tidak kenal dengan sistem operasi Android. Ya, sistem operasi ini memang sangat populer pada smartphone kita. Perkembangannya pun juga', 'post', 'Selasa', 7, 5, 2019, '2019-05-07', '12:18:00', '1557206280', '2019-05-07 12:18:00', '1557206291', 'android-q-dapat-hidupkan-mode-gelap-otomatis', 185, 1, 1, '', 'Afrioni', 'f2b717052019_androidq.jpg', 'post/052019', '', 0, 1),
(20, 'demo', 'Dukung Jaringan 5G, Qualcomm Siapkan Chipset Snapdragon 865', '', '', '<p><a href=\"https://www.prodigital.web.id/post/20/dukung-jaringan-5g-qualcomm-siapkan-chipset-snapdragon-865.html\" target=\"_blank\">Dukung Jaringan 5G, Qualcomm Siapkan Chipset Snapdragon 865</a> - Qualcomm tengah menggebu-gebu akan mengeluarkan chipset terbaru andalannya yakni Snapdragon 865. Chipset ini diprediksi akan menjadi sebuah persaingan ponsel kelas atas pada 2020 mendatang. Qualcomm Snapdragon 865 dikabarkan akan dirilis akhir tahun ini.</p>\r\n\r\n<p>Informasi dari halaman Android Pit, pada Selasa 7 Mei 2019 lalu, <a href=\"https://www.prodigital.web.id/post/14/mengenal-fungsi-chipset-di-smartphone-dan-jenis-jenisnya.html\" target=\"_blank\">chipset</a> ini akan menawarkan dua versi koneksi jaringan, yang pertama koneksi 4G dan kedua koneksi 5G. Meskipun saat ini koneksi jaringan 5G masih terbatas pada beberapa negara, produsen <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> saat ini sedang bergegas untuk merancang produk mereka agar kompatibel dengan chipset Snapdragon 865 ini.</p>\r\n\r\n<p>Snapdragon 865, kabarnya akan menjadi SoC (System on Chip) pertama Qualcomm dengan modem 5G yang terintegrasi. Pada chipset versi sebelumnya yakni Snapdragon 855 sebenarnya saat ini sudah cocok untuk modem jaringan 5G, namun jika menggunakan modem 5G eksternal Snapdragon X50. Hal inilah yang diterapkan oleh Xiaomi Mi MIX 3 5G dan Samsung Galaxy S10 5G.</p>\r\n\r\n<p>Sementara itu chipset Snapdragon 865 ini, modem telah diintegrasikan di dalam <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">prosesor</a> itu sendiri, sehingga memberi banyak ruang yang ada pada perangkat smartphone.</p>\r\n\r\n<p>Qualcomm telah mengkonfirmasikan bahwa akan menggunakan module antena sub-GHz dan mmWave generasi kedua. Hal ini akan menampilkan teknologi PowerSave 5G baru yang akan meningkatkan masa pakai baterai pada smartphone. Sehingga pengguna tidak perlu khawatir akan pemborosan pada baterai smartphone mereka untuk penggunaan jaringan 5G.&nbsp;</p>\r\n\r\n<p>Saat ini banyak sekali pengguna smartphone telah menggunakan <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\">jaringan</a> 4G yang merupakan kebutuhan primer pada jaringan smartphone mereka. Pada versi duplikat chip ini, Qualcomm ingin memberi pabrikan pilihan antara memasukkan koneksi 5G atau melanjutkan dengan 4G biasa. Dikarenakan jaringan 5G masih dalam masa perkembangan dan juga masa transisi, masuk akal jika Qualcomm menawarkan pilihan ini.&nbsp;</p>\r\n\r\n<p>Saat ini SoC Qualcomm telah menjadi produk pilihan bagi sebagian besar produsen perangkat smartphone yang berbasis Android. Sementara itu pesaing mereka, seperti MediaTek belum memiliki prosesor dengan modem jaringan 5G.</p>\r\n\r\n<p>Bahkan, salah satu perusahaan pesaing ketat mereka dikabarkan sedang dalam pengembangan modem smartphone, Intel harus mengakui kehebatan Qualcomm. Mereka pun memutuskan untuk memberhentikan lini bisnis tersebut pada beberapa waktu lalu.&nbsp;</p>', 'Dukung Jaringan 5G, Qualcomm Siapkan Chipset Snapdragon 865 - Qualcomm tengah menggebu-gebu akan mengeluarkan chipset terbaru andalannya yakni Snapdragon 865. Chipset ini diprediksi akan menjadi', 'post', 'Rabu', 8, 5, 2019, '2019-05-08', '14:41:00', '1557301260', '2019-05-08 14:41:00', '1557301299', 'dukung-jaringan-5g-qualcomm-siapkan-chipset-snapdragon-865', 165, 1, 1, '', 'Afrioni', '37e1c0052019_qualcommchipbehindback.png', 'post/052019', '', 0, 1);
INSERT INTO `memo_konten` (`kontenId`, `kontenUsername`, `kontenJudul`, `kontenJudulBesar`, `kontenJudulKecil`, `kontenPost`, `kontenRingkas`, `kontenType`, `kontenHari`, `kontenDd`, `kontenMm`, `kontenYy`, `kontenDate`, `kontenJam`, `kontenTimestamp`, `kontenDatetime`, `kontenAddDate`, `kontenSlug`, `kontenRead`, `kontenStatusKomen`, `kontenStatus`, `kontenEditor`, `kontenPenulis`, `kontenImg`, `kontenDirImg`, `kontenTextImg`, `kontenHeadline`, `kontenFeature`) VALUES
(21, 'demo', 'Begini Cara Merawat Power Bank Agar Awet Digunakan', '', '', '<p><a href=\"https://www.prodigital.web.id/post/21/begini-cara-merawat-power-bank-agar-awet-digunakan.html\" target=\"_blank\">Begini Cara Merawat Power Bank Agar Awet Digunakan</a> - Bagi kamu yang memiliki mobilitas yang tinggi, power bank adalah sebuah perangkat yang akan selalu menemani kamu untuk pada setiap aktifitas yang akan kamu jalani. Terlebih lagi apabila baterai <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> kamu sudah kritis dan kamu tidak sempat untuk mengisi daya menggunakan listrik.</p>\r\n\r\n<p>Dengan kebutuhan dan ketergantungan kita menggunakan power bank yang semakin sering digunakan maka umur dari power bank ini akan semakin berkurang. Sehingga kinerja power bank ini akan semakin lemah dan tidak maksimal.</p>\r\n\r\n<p>Bagi kamu yang memiliki power bank, akan sulit rasanya untuk men-charge daya baterai smartphone apabila power bank kamu tidak bekerja secara maksimal. Berikut ada beberapa tips yang dapat kamu lakukan agar membuat power bank nyaman digunakan dan awet, seperti dilansir laman vanguardngr beberapa waktu lalu:</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>1. Pilihlah power bank yang berkualitas</strong></span></p>\r\n\r\n<p>Berawal dari pertama kali kamu membeli sebuah power bank yang akan kamu gunakan. Pilihlah power bank yang berkualitas agar kamu dapat menggunakannya secara awet dan tahan lama, Jangan tanggung-tanggung dan jangan membeli power bank dengan harga murah, karena kebanyakan power bank yang harganya murah kualitasnya sudah jelas tidak bagus dan masa penggunaannya juga sebentar.</p>\r\n\r\n<p>Di pasar saat ini, ada banyak power bank murah dalam berbagai kapasitas penyimpanan daya. Mulai dari 2.500 mAh hingga 50.000 mAh yang besarnya berlebihan. Dengan harga yang menggoda dan kapasitas penyimpanan dayanya juga tidak sesuai dengan standar,tentu saja power bank jenis ini begitu mengkhawatirkan. Untuk itu jangan segan dengan kualitas dan harga power bank yang cukup mahal</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>2. Pengisian daya yang sesuai</strong></span></p>\r\n\r\n<p>Seperti smartphone baru, power bank yang baru juga memerlukan pengisian daya yang memadai sebelum ia dapat digunakan. Artinya, berapa lama kamu mengisi daya pada power bank kamu sebelum digunakan, akan memainkan peran besar pada umur power bank kamu.&nbsp; Untuk itu pengisian daya pada power bank tidak bisa dilakukan secara terus menerus.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>3. Pastikan kompatibilitas power bank sesuai dengan perangkat yang diisi</strong></span></p>\r\n\r\n<p>Periksalah power bank kamu, apakah kompatibel dengan perangkat yang kamu gunakan. Setiap power bank memiliki ketentuan daya yang berbeda untuk pengisian daya pada <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">perangkat</a> kamu. Apabila tidak kompatibel pada perangkat kamu dikhawtirkan akan merusak perangkat ataupun power bank yang kamu gunakan.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>4. Jaga power bank Anda dalam kondisi baik</strong></span></p>\r\n\r\n<p>Semua perangkat elektronik memiliki tingkat keausan sendiri. Jagalah power bank kamu dengan baik, jangan biarkan power bank kamu masih tercolok kelistrik terlalu lama dan&nbsp;simpan di tempat sejuk dan kering, jangan disimpan di tempat yang panas seperti diatas alat elektronik yang mengeluarkan panas seperti diatas kulkas, komputer atau alat elektronik lainnya yang sedang menyala.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>5. Hindari penggunaan smartphone sambil mengisi daya pada power bank</strong></span></p>\r\n\r\n<p>Saat smartphone kesayangan kamu sedang mengisi daya dari&nbsp;power bank hindarilah penggunaannya seperti sambil bermain game atau malakukan atau&nbsp;menjawab panggilan dari smartphone ketika sedang di-charge dari power bank. Selain tindakan tersebut dapat membahayakan kesehatan kamu, tindakan itu juga dapat menyebabkan kerusakan pada kedua perangkat kamu.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>6. Sebisa mungkin hindarilah dari menjatuhkannya</strong></span></p>\r\n\r\n<p>Hal ini terkadang sulit kita duga, namun berusahalah untuk tidak menjatuhkannya pada tempat yang keras atau dari ketinggian. Kerusakan internal ataupun fisik dapat disebabkan jika power bank jatuh sembarangan. Selain itu hindarilah meletakkan benda-benda yang berat, terpijak ataupun terduduk di atas power bank kamu. Terkadang ada sebagian orang yang meletakkan power bank mereka pada saku belakang dan itu adalah hal yang keliru. Hal tersebut adalah cara yang salah dalam menangani perangkat karena power bank juga adalah perangkat yang sensitif.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>7. Hindari menggunakan charger eksternal</strong></span></p>\r\n\r\n<p>Terkadang hal ini kita sepelekan namun ini adalah suatu yang juga harus kita hindari. Gunakanlah pengisi daya asli untuk mengisi daya power bank kamu, jangan menggunakan pengisi daya eksternal yang bukan bawaan dari&nbsp;power bank yang kamu beli. Hal ini dilakukan karena menggunakan pengisi daya eksternal tidak hanya mempengaruhi power bank kamu, tapi juga perangkat smartphone kamu.</p>\r\n\r\n<p>Walaupun terkadang hal-hal yang sepele namun terkadang dengan hal-hal yang sepele ini bisa menghindari power bank kami dari umur yang pendek. Tetaplah hemat pada penggunaan power bank kamu, ini lebih baik dari pada harus merogoh kocek untuk membeli power bank kamu.</p>\r\n\r\n<p>Mudah-mudah <a href=\"https://www.prodigital.web.id/kategori/10/tips-dan-trik.html\" target=\"_blank\">tips</a> ini dapat membantu kamu agar tetap awet dalam menggunakan power bank kesayangan kamu.</p>', 'Begini Cara Merawat Power Bank Agar Awet Digunakan - Bagi kamu yang memiliki mobilitas yang tinggi, power bank adalah sebuah perangkat yang akan selalu menemani kamu untuk pada setiap aktifitas', 'post', 'Kamis', 9, 5, 2019, '2019-05-09', '09:23:00', '1557368580', '2019-05-09 09:23:00', '1557368609', 'begini-cara-merawat-power-bank-agar-awet-digunakan', 126, 1, 1, '', 'Afrioni', '44ab16052019_xiaomimipowerbanklede.jpg', 'post/052019', '', 0, 0),
(22, 'demo', 'Cara Menghentikan Unduh Otomatis Foto dan Video pada WhatsApp', '', '', '<p>Tips kali ini <a href=\"https://www.prodigital.web.id/\" target=\"_blank\">ProDigital.web.id</a> akan mengulas bagaimana <a href=\"https://www.prodigital.web.id/post/22/cara-menghentikan-unduh-otomatis-foto-dan-video-pada-whatsapp.html\" target=\"_blank\">cara menghentikan unduh otomatis foto dan video otomatis pada WhatsApp</a>.</p>\r\n\r\n<p>Pengunduhan otomatis adalah fitur bawaan yang ada pada WhatsApp. Terkadang fitur ini membuat ruang penyimpanan smartphone kita menjadi cepat penuh dan mengacaukan ruang penyimpanan pada <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> kita.</p>\r\n\r\n<p>WhatsApp telah digunakan lebih dari 1,2 miliar orang yang ada di seluruh dunia. Unduhan secara otomatis menjadi kendala ketika semua file media tersimpan secara otomatis, dari gambar, GIF, belum lagi file audio dan video. Apalagi jika media penyimpanan kita tidaklah besar, tentu mengganggu sekali.</p>\r\n\r\n<p>Untuk mengatasi hal tersebut, kita harus melakukan beberapa langkah untuk menghentikan fitur WhatsApp ini dari mengunduh audio dan foto di ponsel secara otomatis, berikut langkah tersebut:</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>WhatsApp <a href=\"https://www.prodigital.web.id/kategori/12/android.html\" target=\"_blank\">Android</a></strong></span></p>\r\n\r\n<p>Untuk menghentikan pengunduhan otomatis Whatsapp Android memiliki pilihan yang memungkinkan kita menghentikan file video, audio dan gambar agar tidak diunduh. Pertama kita membuka aplikasi pesan WhatsApp, kemudian pilih pengaturan.</p>\r\n\r\n<p>Setelah itu ketuk Pengaturan Obrolan dan silahkan pilih Unduhan otomatis media. Maka terlihat ada tiga opsi: saat menggunakan data seluler, saat roaming dan saat terhubung pada Wi-Fi. Silahkan ketuk masing-masing dan nonaktifkan unduhan otomatis dengan menghapus centang ketiga opsi, Audio, Gambar dan Video.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>WhatsApp <a href=\"https://www.prodigital.web.id/kategori/13/ios.html\" target=\"_blank\">iOS</a></strong></span></p>\r\n\r\n<p>Sementara ini untuk menghentikan pengunduhan otomatis dan menyimpan video, gambar, dan media lain di WhatsApp iPhone, kita bisa menonaktifkan pengunduhan otomatis melalui menu Pengaturan. Caranya kita harus membuka WhatsApp, lalu ketuk tombol Pengaturan dan ketuk Penggunaan Data dan Penyimpanan.</p>\r\n\r\n<p>Kemudian di dalam menu tersebut, ada opsi Unduh Otomatis Media di bagian atas. Untuk Audio, foto, Video, dan Dokumen, pilih opsi Jangan, pilih file yang kita inginkan untuk diunduh secara manual akan muncul, bahkan kita dapat memilih untuk menghentikan foto dan video agar tidak muncul di galeri ponsel.</p>\r\n\r\n<p>Yang perlu dilakukan adalah masuk ke Obrolan di Pengaturan, buka menu Simpan ke Rol Kamera, dan matikan. Ini menghentikan gambar yang dikirim orang yang muncul di rol kamera dan juga mengambil alih Stream Foto kita yang disinkronkan.</p>\r\n\r\n<p>Tidak menyimpan gambar, audio ataupun video secara otomatis memiliki kelebihan sendiri. Tapi juga berarti bahwa kita harus mengunduh setiap foto secara manual. Jika kita akhirnya ingin mengunduh setiap gambar, maka mungkin yang terbaik adalah membiarkan fitur ini aktif.</p>\r\n\r\n<p>Sumber: tekno.tempo.co</p>', 'Tips kali ini ProDigital.web.id akan mengulas bagaimana cara menghentikan unduh otomatis foto dan video otomatis pada WhatsApp.\r\n\r\nPengunduhan otomatis adalah fitur bawaan yang ada pada WhatsApp.', 'post', 'Kamis', 9, 5, 2019, '2019-05-09', '18:01:00', '1557399660', '2019-05-09 18:01:00', '1557399718', 'cara-menghentikan-unduh-otomatis-foto-dan-video-pada-whatsapp', 123, 1, 1, '', 'Afrioni', '5d2a17052019_800551_720.jpg', 'post/052019', '', 0, 0),
(23, 'demo', 'Teknologi Komputer Terbaru dan Tercanggih yang Mempermudah Manusia', '', '', '<p><a href=\"https://www.prodigital.web.id/post/23/teknologi-komputer-terbaru-dan-tercanggih-yang-mempermudah-manusia.html\" target=\"_blank\">Teknologi Komputer Terbaru dan Tercanggih yang Mempermudah Manusia</a> - Berbicara mengenai penemuan dalam bidang <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">komputer</a>, dengan berjalannya waktu penemuan-penemuannya pun sangat unik dan tentunya sangat membantu manusia di dalam mengerjakan berbagai pekerjaannya.</p>\r\n\r\n<p>Tak hanya itu, tetapi komputer juga dapat membantu mengurangi waktu kerjamu. Bila biasanya kamu mengerjakan sesuatu itu sangat lama, maka bila kita menggunakan komputer, kita bisa mengerjakannya dengan lebih singkat.</p>\r\n\r\n<p>Berikut ini merupakan teknologi komputer terbaru yang perlu untuk kamu ketahui:</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>1. Biometric Sensor</strong></span></p>\r\n\r\n<p>Biometric Sensor merupakan teknologi paling baru yang bisa diaplikasikan pada komputer kita. Pasaknya teknologi canggih tersebut diciptakan oleh salah satu dari perusahaan komputer terbesar, yakni Intel.</p>\r\n\r\n<p>Teknologi Biometric hampir sama dengan teknologi Apple yang saat ini digunakan untuk keperluan otorisasi kartu kredit apabila kita melakukan pembayaran dengan menggunakan Pay Apple.</p>\r\n\r\n<p>Biometric sensor sangat bermanfaat untuk mempermudah melakukan otorisasi pada berbagai situs. Jika biasanya harus menggunakan password atau dengan username dalam mengakses situs, maka dengan menggunakan biometric sensor kita bisa masuk dengan mudah, praktis dan aman.</p>\r\n\r\n<p><strong><span style=\"font-size:16px\">2. Wireless Display</span></strong></p>\r\n\r\n<p>Wireless Display adalah salah satu teknologi yang paling baru dan juga canggih yang diprakarsai oleh perusahaan komputer terbesar yaitu Intel. Apabila kita menggunakan Wireless Display, maka komputer atau <a href=\"https://www.prodigital.web.id/kategori/7/laptop.html\" target=\"_blank\">laptop</a> tak perlu dihubungkan dengan kabel.</p>\r\n\r\n<p>Teknologi ini juga dapat membuat sebuah komputer atau laptop dapat terhubung dengan komputer atau laptop yang lain. Dan untuk kamu yang sering mempresentasikan sesuatu di depan publik, tentu teknologi ini akan sangat membantu dalam hal tersebut.</p>\r\n\r\n<p>Kamu tidak perlu untuk memasang kabel untuk mempresentasikan hasil kerja kamu. Kita cukup dengan gunakan teknologi ini, maka kamu sudah dapat mempresentasikan apa pun secara mudah.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>3. Wireless Charging</strong></span></p>\r\n\r\n<p>Sama-sama berasal dari perusahaan Intel, teknologi wireless charging ini pun begitu canggih dan pastinya akan sangat membantu kamu.</p>\r\n\r\n<p>Apabila kamu biasanya harus mengulur kabel dalam mengisi baterai laptopmu, maka sekarang hal tersebut tidak perlu dilakukan lagi saat kamu mempunyai wireless charging. Dengan menggunakan wireless charging, kamu akan lebih mudah dalam mengisi baterai laptopmu tanpa repot menggunakan kabel.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>4. Komputer Interaktif</strong></span></p>\r\n\r\n<p>Kompuer interaktif merupakan teknologi yang canggih dari perusahaan Intel. Komputer jenis ini sangat peka terhadap suatu visual serta berbagai inputan yang kita lakukan. Dan nantinya, teknologi ini akan dilengkapi dengan teknologi intel realsense 3D <a href=\"https://www.prodigital.web.id/kategori/4/kamera.html\" target=\"_blank\">camera</a>, yang mana teknologi tersebut dapat sangat peka bahkan dapat mengatur jarak diantara pengguna dengan sensor.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>5. Creative Desktop dengan Touch Mat</strong></span></p>\r\n\r\n<p>Selanjutnya, teknologi komputer terbaru adalah Creative Desktop dengan Touch Mat. Yang mana teknologi ini diciptakan oleh perusahaan komputer yang bernama HP (Hewlett-Packard).</p>\r\n\r\n<p>Teknologi ini seperti halnya kanvas yang telah dikombinasikan dengan menggunakan komputer yang berteknologi kamara 3D. Teknologi ini dapat memungkinkan penggunanya dalam memindai berbagai benda yang terdapat di depan komputer, kemudian memanipulasinya dengan kanvas tadi yang berada di atas meja.</p>\r\n\r\n<p>Misalnya, ada sebuah cangkir yang berada di depan komputer ini, kemudian komputer tersebut akan memindai cangkir tadi. Setelah gambarnya berada di dalam komputer, maka kamu dapat memanipulasi gambar tadi sesuai dengan keinginan dengan cara menggunakan kanvas yang berada di depan komputermu.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>6. Virtual Keyboard</strong></span></p>\r\n\r\n<p>Teknologi canggih yang diciptakan oleh perusahaan Dell ini, prinsip kerjanya adalah dengan cara menggabungkan sebuah PC all in one dengan smart desk. Dengan menggunakan teknologi ini, maka pengguna dapat mengetik secara langsung di atas meja.</p>\r\n\r\n<p>Nah, pastinya teknologi ini akan sangat membantmu bukan? Jari-jari kamu tak perlu lagi memegang keyboard komputer dan pastinya akan lebih lincah dalam bergerak saat mengetik.</p>\r\n\r\n<p>Sumber: satujam.com</p>', 'Teknologi Komputer Terbaru dan Tercanggih yang Mempermudah Manusia - Berbicara mengenai penemuan dalam bidang komputer, dengan berjalannya waktu penemuan-penemuannya pun sangat unik dan tentunya', 'post', 'Selasa', 14, 5, 2019, '2019-05-14', '04:52:00', '1557784320', '2019-05-14 04:52:00', '1557784360', 'teknologi-komputer-terbaru-dan-tercanggih-yang-mempermudah-manusia', 158, 1, 1, '', 'Afrioni', '9b664d052019_456498.jpg', 'post/052019', '', 0, 0),
(24, 'demo', 'Perbarui Segera WhatsApp Anda, Ada Serangan Spyware Israel', '', '', '<p>WhatsApp merupakan aplikasi <a href=\"https://www.prodigital.web.id/kategori/12/android.html\" target=\"_blank\" rel=\"noopener\">android</a> yang saat ini sangat populer telah menghimbau para penggunanya untuk memperbarui aplikasinya ke versi yang terbaru, WhatsApp telah menemukan kerentanan yang memungkinkan spyware menyusupi <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\" rel=\"noopener\">smartphone</a> pengguna melalui fungsi panggilan telepon <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\" rel=\"noopener\">aplikasi</a>.</p>\r\n<p>Dari laman Thetelegraph, Selasa, 14 Mei 2019, telah menyebutkan, spyware ini dikembangkan oleh perusahaan intelijen cyber Israel NSO Group. Spyware ini menggunakan panggilan telepon yang terinfeksi untuk mengambil alih fungsi sistem operasi pada smartphone pengguna.</p>\r\n<p>Penyerang mengirimkan kode berbahaya ke perangkat target dengan cara memanggil pengguna dan menginfeksi panggilan apakah penerima menjawab panggilan atau tidak. Log panggilan masuk sering dihapus.</p>\r\n<p>\"Kerentanan itu ditemukan bulan ini, WhatsApp dengan cepat mengatasi masalah dalam infrastrukturnya sendiri. Pembaruan untuk aplikasi ini diterbitkan mulai Senin kemarin, dan mendorong pengguna untuk tetap waspada,\" ujar Juru Bicara WhatsApp seperti dilansir laman Financial Times.</p>\r\n<p>WhatsApp menyatakan akan mengambil langkah hukum atas kasus serangan ini.</p>\r\n<p>Spyware ini bermula dari upaya serangan terhadap telepon seorang pengacara Inggris. Pengacara tersebut, yang tidak disebutkan namanya, terlibat dalam gugatan terhadap NSO yang diajukan oleh sekelompok wartawan Meksiko, kritikus pemerintah, dan seorang pembangkan Arab Saudi yang menetap di Kanada. Gugatan diajukan karena NSO dianggap ikut bertanggung jawab atas penyalahgunaan perangkat lunaknya oleh klien.</p>\r\n<p>WhatsApp menyatakan sebuah tim bekerja keras di San Fransisco dan London untuk menutup celah ini. Tim berhasil melokalisir serangan pada Jumat lalu dan mengeluarkan pembaruan aplikasi pada Senin, 13 Mei 2019.</p>\r\n<p>NSO mengatakan telah memeriksa pelanggan dengan hati-hati dan menyelidiki setiap penyalahgunaan. Ditanya tentang serangan WhatsApp, NSO mengatakan sedang menyelidiki masalah tersebut.</p>\r\n<p>\"Dalam situasi apa pun NSO tidak akan terlibat dalam operasi atau identifikasi target teknologinya, yang hanya dioperasikan oleh badan intelijen dan penegak hukum,\"kata NSO Group kepada&nbsp; Financial Times.</p>\r\n<p>\"NSO tidak akan, atau tidak bisa, menggunakan teknologinya dengan haknya sendiri. Untuk menargetkan orang atau organisasi apa pun, termasuk orang ini.\" &nbsp;</p>\r\n<p>Produk andalan NSO adalah Pegasus, sebuah program yang dapat menyalakan mikrofon dan kamera ponsel, menjaring email dan pesan dan mengumpulkan data lokasi.</p>\r\n<p>Kemampuan spyware hampir absolut. Setelah diinstal pada ponsel, perangkat lunak dapat mengekstraksi semua data yang ada di perangkat (pesan teks, kontak, lokasi GPS, email, riwayat browser, dll), selain membuat data baru dengan menggunakan mikrofon dan kamera ponsel untuk merekam lingkungan dan suara sekitar pengguna, demikian menurut laporan New York Times .</p>\r\n<p>WhatsApp memiliki sekitar 1,5 miliar pengguna di seluruh dunia. <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\" rel=\"noopener\">Aplikasi</a> olah pesan ini menggunakan enkripsi ujung ke ujung, membuatnya populer dan aman untuk para aktivis.</p>\r\n<p>Sumber: tekno.tempo.co</p>', 'WhatsApp merupakan aplikasi android yang saat ini sangat populer telah menghimbau para penggunanya untuk memperbarui aplikasinya ke versi yang terbaru, WhatsApp telah menemukan kerentanan yang', 'post', 'Rabu', 15, 5, 2019, '2019-05-15', '05:16:00', '1557872160', '2019-05-15 05:16:00', '1557872176', 'perbarui-segera-whatsapp-anda-ada-serangan-spyware-israel', 187, 1, 1, '', 'Afrioni', 'af649d052019_whatsappreliance.jpg', 'post/052019', '', 1, 1),
(25, 'demo', 'Dasar Keamanan Facebook, Netizen Wajib Tahu', '', '', '<p><a href=\"https://www.prodigital.web.id/post/25/dasar-keamanan-facebook-netizen-wajib-tahu.html\" target=\"_blank\">Dasar Keamanan Facebook, Netizen Wajib Tahu</a> - <strong>ProDigital.web.id</strong> akan mengulas tentang dasar-dasar keamanan pada platform sosial media Facebook. Platform ini memiliki beberapa kebijakan dan fitur yang harus kamu tahu demi menjaga identitas dan informasi pribadi pengguna tetap terlindungi dari berbagai macam ancaman pembajakan dan pencurian data. Facebook saat ini memiliki pengguna di hampir seluruh penduduk yang ada di dunia.</p>\r\n\r\n<p>Facebook ingin mendorong semua orang atau semua penggunanya menyadari pentingnya menjaga informasi dan identitas pribadi agar tetap aman. Banyak sekali langkah yang telah diterapkan oleh Facebook agar pengguna tetap aman dan nyaman dengan layanan yang diberikan oleh Facebook. Mulai dari bersosial media secara pribadi hingga merangkul bisnis dan ecommerce.</p>\r\n\r\n<p>Bagi Facebook data pengguna adalah suatu hal yang sangat penting, yang harus dijaga dengan aman dan memberikan kesan postif untuk penggunanya. Terkadang banyak pengguna yang belum menyadari bahwa ada beberapa fitur dasar yang dapat digunakan agar pengguna dapat dengan nyaman menggunakan Facebook. Apalagi kamu adalah seorang Netizen yang sering meluncur dengan sosial media buatan Mark Zuckerberg.</p>\r\n\r\n<p>Ada lima poin dasar dari fitur keamanan Facebook yang harus kamu atau Netizen ketahui agar data pribadi tetap aman.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>1. Where You&rsquo;re Logged In (dimana Anda login)</strong></span></p>\r\n\r\n<p>Fitur ini merupakan fitur untuk menunjukkan lokasi pengguna yang login dan perangkat yang digunakan. Fitur ini sangat berguna untuk memberitahu Anda tentang aktivitas yang aneh atau tidak biasa, yang dilakukan oleh pengguna selain kamu atau pihak lain. Fitur ini juga memberikan opsi untuk mengambil tindakan dengan cara keluar dari perangkat tersebut. Kamu juga sebagai pengguna diharuskan untuk melakukan dan memeriksanya secara berkala apabila mengakses Facebook pada komputer umum atau perangkat lain selain yang Anda gunakan.</p>\r\n\r\n<p><strong><span style=\"font-size:16px\">2. Apakah itu Anda?</span></strong></p>\r\n\r\n<p>Facebook merekomendasikan dan menyarankan pengguna untuk mendaftarkan diri agar mendapatkan pemberitahuan terkait login yang tidak dikenal. Apabila mengaktifkan fitur ini, kamu akan mendapat notifikasi pada akun Facebook, Facebook Messenger, dan email yang terdaftar pada Facebook kamu, yang menginformasikan apabila ada pihak lain yang telah masuk untuk login melalui perangkat tidak dikenal. Pengguna juga bisa memilih &#39;not me&#39; untuk keluar dari perangkat lain jika itu bukan kamu yang melakukan login.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>3. Perkuat Kata Sandi</strong></span></p>\r\n\r\n<p>Banyak sekali pengguna menggunakan kata sandi yang mudah diingat dan mudah ditebak berkaitan dengan hal yang pribadi serta umum diketahui orang lain. Sangat penting sekali untuk menggunakan kata sandi yang kuat dan unik pada akun Facebook kamu, sehingga tidak mudah ditebak oleh orang lain yang ingin iseng atau bahkan membajak Facebook kamu. Untuk dapat memperkuat kata sandi ini&nbsp; sebaiknya, kamu menggunakan kombinasi unik yang terdiri dari angka, karakter, dan kata. Silahkan mengunjungi menu &#39;Changing Password&#39; (ubah kata sandi) untuk mengubah kata sandi Facebook kamu. Sangat disarankan dan lebih aman apabila kamu mengganti kata sandi Facebook kamu secara berkala.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>4. Akses Keamanan Ganda</strong></span></p>\r\n\r\n<p>Cara lain untuk memperkuat keamanan Facebook adalah dengan memanfaatkan fitur &#39;two-factor authentication&#39; atau 2FA untuk melakukan login. Fungsi 2FA pada Facebook ini juga dapat membuat akun kamu lebih aman karena kamu harus menggunakan kombinasi identifikasi personal untuk login. Biasanya cara fitur ini bekerja adalah kata sandi dan kode unik login dikirimkan ke nomor <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">ponsel</a> melalui pesan singkat untuk divalidasi.</p>\r\n\r\n<p>Layanan lapisan kedua perlindungan ini banyak digunakan oleh bank dan berbagai penyedia layanan online lain yang menggunakan data pribadi atau data keuangan mereka. Setelah akun aman, pengguna dapat mendaftarkan perangkat yang sering dipakai untuk Authorized Logins (Login yang resmi), yang tidak membutuhkan kode, dan juga mengatur App Passwords (Kata Sandi Aplikasi) khusus.</p>\r\n\r\n<p><strong><span style=\"font-size:16px\">5. Pilihlah Orang yang Kamu Percayai</span></strong></p>\r\n\r\n<p>Selain fitur di atas, facebook juga mampu mengatur sistem keamanan ekstra yakni pengguna dapat memiliki 3 hingga 5 orang teman yang dapat dipercaya dan dihubungi jika tidak dapat mengakses akunnya. Fitur ini bermanfaat jika ada seseorang mengakses akun kamu dan mengganti email dan kata sandi.</p>\r\n\r\n<p>Untuk menggunakan fitur ini silahkan pilih Reveal my Trusted Contacts (ungkap kontak tepercaya) dan ketik nama lengkap teman yang kamu percayai. Selanjutnya kamu akan menerima link yang hanya dapat diakses oleh teman yang kamu percayai tersebut dan mereka dapat memberikan kode validasi untuk mengakses kembali akun pribadinya. Informasi keamanan itu juga dapat diakses dengan mudah melalui menu Pengaturan, kemudian Umum, dilanjutkan Keamanan dan Login.</p>\r\n\r\n<p>Inilah <a href=\"https://www.prodigital.web.id/kategori/10/tips-dan-trik.html\" target=\"_blank\">tips</a> yang dapat kamu gunakan untuk menjaga keamanan Facebook kamu dalam berselancar di dunia maya.</p>\r\n\r\n<p>Sumber: tekno.tempo.co</p>', 'Dasar Keamanan Facebook, Netizen Wajib Tahu - ProDigital.web.id akan mengulas tentang dasar-dasar keamanan pada platform sosial media Facebook. Platform ini memiliki beberapa kebijakan dan fitur', 'post', 'Rabu', 15, 5, 2019, '2019-05-15', '10:55:00', '1557892500', '2019-05-15 10:55:00', '1557892508', 'dasar-keamanan-facebook-netizen-wajib-tahu', 143, 1, 1, '', 'Afrioni', '86e5be052019_facebookprivacyguide.jpg', 'post/052019', '', 0, 0),
(26, 'demo', 'Peretas Masih Bisa Akses WhatsApp yang Belum Update, Pengguna Harap Berhati-hati', '', '', '<p>Mengenai berita beberapa hari lalu yakni &quot;<a href=\"https://www.prodigital.web.id/post/24/perbarui-segera-whatsapp-anda-ada-serangan-spyware-israel.html\" target=\"_blank\">Perbarui Segera WhatsApp Anda, Ada Serangan Spyware Israel</a>&quot;, WhatsApp memberikan informasi yang sedikit tentang peretasan besar pekan ini. Sejumlah pengguna yang gagal memperbarui WhatsApp khawatir peretas bisa mendapatkan informasi pribadinya, termasuk pesan dan lokasi data.</p>\r\n\r\n<p>Wandera, sebuah perusahaan keamanan <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> yang juga bekerja sama dengan Rolex, Deloitte, General Electric, dan Bloomberg, melakukan penelitian. Wandera membantu mengamankan smartphone karyawan di perusahaan tersebut, dan memiliki lebih dari 1 juta <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">perangkat</a> di bawah manajemennya, 30 persen di antaranya memiliki WhatsApp yang diinstal.</p>\r\n\r\n<p>Artinya, Wandera dapat melihat apakah 300.000 pengguna perangkat telah mengambil saran Facebook dan memperbarui WhatsApp untuk menambal kerentanan keamanan.</p>\r\n\r\n<p>Pada Kamis, 16 Mei 2019, Wandera menemukan bahwa 80,2 persen perangkat <a href=\"https://www.prodigital.web.id/kategori/13/ios.html\" target=\"_blank\">iOS</a> dalam kelompok 300.000 ini tidak diperbarui, sementara 55,4 persen perangkat <a href=\"https://www.prodigital.web.id/kategori/12/android.html\" target=\"_blank\">Android</a> juga rentan.</p>\r\n\r\n<p>Menurut laman Businessinsider, 17 Mei 2019, para peretas, yang belum diidentifikasi, memperoleh akses dengan memanfaatkan kerentanan dalam fungsi panggilan WhatsApp untuk memasang penyadap yang dikembangkan oleh NSO Group Israel. Bahkan jika target tidak menerima panggilan, <a href=\"https://www.prodigital.web.id/post/18/tips-agar-komputer-tidak-terserang-virus.html\" target=\"_blank\">malware</a> dapat menginfeksi ponsel.</p>\r\n\r\n<p>WhatsApp belum memberi tahu pengguna secara langsung tentang masalah ini, dan keamanan tidak disebutkan sebagai bagian dari proses pembaruan <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\">aplikasi</a> di Apple App Store dan Google Play Store. Sebaliknya, WhatsApp telah mengeluarkan pernyataan pers yang mendesak orang untuk memperbarui aplikasinya.</p>\r\n\r\n<p>&quot;WhatsApp mendorong pengguna untuk meningkatkan ke versi terbaru dari aplikasi kami, serta menjaga sistem operasi seluler mereka tetap up to date, untuk melindungi terhadap eksploitasi potensial yang ditargetkan dan dirancang untuk mencuri informasi yang tersimpan di perangkat seluler,&quot; kata pihak WhatsApp.</p>\r\n\r\n<p>Dalam sebuah wawancara dengan CNBC pada hari Kamis, Sheryl Sandberg, chief operating officer Facebook, mengatakan investasi perusahaan dalam keselamatan dan keamanan memungkinkan para insinyurnya menemukan peretasan WhatsApp. &quot;Karena kami menempatkan lebih banyak insinyur untuk mencari bug, mencari kerentanan, kami menemukan ini, makan kami mematikannya,&quot; kata Sandberg.</p>\r\n\r\n<p>Sumber: tekno.tempo.co</p>', 'Mengenai berita beberapa hari lalu yakni &amp;quot;Perbarui Segera WhatsApp Anda, Ada Serangan Spyware Israel&amp;quot;, WhatsApp memberikan informasi yang sedikit tentang peretasan besar pekan', 'post', 'Minggu', 19, 5, 2019, '2019-05-19', '04:58:00', '1558216680', '2019-05-19 04:58:00', '1558216688', 'peretas-masih-bisa-akses-whatsapp-yang-belum-update-pengguna-harap-berhati-hati', 172, 1, 1, '', 'Afrioni', 'af649d052019_whatsappreliance.jpg', 'post/052019', '', 1, 1),
(27, 'demo', 'Berikut Cara Menghilangkan Virus Shortcut Pada Komputer Atau Laptop', '', '', '<p><a href=\"https://www.prodigital.web.id/post/27/berikut-cara-menghilangkan-virus-shortcut-pada-komputer-atau-laptop.html\" target=\"_blank\" rel=\"noopener\">Berikut Cara Menghilangkan Virus Shortcut Pada Komputer Atau Laptop</a> - Perangkat elektronik saat sekarang ini seperti laptop, komputer ataupun <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\" rel=\"noopener\">smartphone</a> tidak terpisah pada kehidupan kita sehari-hari. Terlebih lagi bagi Anda yang bekerja menggunakan perangkat ini yang bahkan sudah menjadi kebutuhan Anda sehari-hari. Komputer ataupun laptop sudah menjadi sebuah barang elektronik yang tidak bisa hilang dari keseharian kita. Dengan komputer atau laptop ini, Anda bisa lebih produktif dan memudahkan pekerjaan yang Anda hadapi setiap harinya. Selain itu, Anda dapat berselancar di media sosial dengan leluasa menggunakan perangkat ini.</p>\r\n<p>Ada banyak hal yang dapat kita lakukan dengan menggunakan <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\" rel=\"noopener\">komputer</a> ataupun laptop ini. Bermain game hingga seharian, mengerjakan tugas atau pekerjaan, menonton film bahkan menonton acara televisi, streaming pada berbagai situs dan lain sebagainya. Bahkan laptop yang sifatnya sangat fleksible, dapat dibawa kemana saja yang memudahkan kita untuk mengerjakan berbagai pekerjaan dimana saja.</p>\r\n<p>Perangkat seperti komputer ataupun laptop ini tentunya rentan sekali terkena virus, malware, worm, trojan, FAT virus ataupun sejenisnya jika tidak kita proteksi dengan baik. Apalagi saat kita beselancar di <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\" rel=\"noopener\">internet</a> dan membuka situs yang sudah mengandung virus maka perangkat Anda akan gampang sekali terinfeksi. Bahkan saat sedang mengunduh sebuah file virus tersebut juga akan ikut terunduh pada komputer atau laptop Anda.</p>\r\n<p>Terinfeksi virus pada komputer Anda bisa saja terjadi karena Anda tidak sengaja membuka situs-situs yang sudah terjangkit virus atau mengklik iklan-iklan yang tidak disarankan. Apabila sudah terjangkit pada perangkat Anda dan tidak segera diatasi tentunya dapat merusak sistem yang ataupun perangkat pada komputer Anda.</p>\r\n<p>Ada banyak sekali jenis virus yang dapat menjangkit komputer atau laptop Anda, salah satu virus yang menyebalkan adalah virus shortcut. Virus ini adalah jenis virus yang mudah menular melalui storage device seperti Flash Disk, Memory Micro SD, External Hardisk dan lain-lain. Biasanya virus ini menginfeksi direktory file pada komputer dan storage device Anda.</p>\r\n<p>Virus shortcut ini sebenarnya tidak terlalu berbahaya dan membuat file Anda rusak ataupun corrupt bahkan mudah untuk diatasi. Akan tetapi virus ini jika dibiarkan akan mengganggu performa komputer Anda. Bahkan virus ini dapat menularkan dirinya ke perangkat lain jika ia terhubung pada komputer ataupun laptop Anda yang sedang terinfeksi.</p>\r\n<p>ProDigital.web.id akan <a href=\"https://www.prodigital.web.id/kategori/5/artikel.html\" target=\"_blank\" rel=\"noopener\">mengulas</a> beberapa cara untuk mengatasi virus shortcut ini. Untuk itu, silahkan simak cara mengatasinya berikut ini.</p>\r\n<p><span style=\"font-size: 16px;\"><strong>1. Tampilkan hidden files</strong></span></p>\r\n<p><img class=\"aligncenter\" style=\"height: 569px; width: 750px;\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/Unhide-Folders.jpg\" alt=\"Unhide File Folders\" /></p>\r\n<p>Hal pertama yang harus Anda lakukan yakni menampilkan semua file hidden pada komputer ataupun laptop Anda. Caranya, silahkan buka control panel pada windows Anda, lalu pilih folder options dan masuklah ke dalam tab view. Lalu setelah itu, munculkan file hidden Anda dengan cara mengklik opsi \"Show hidden files, folders and drives. Dengan melakukan langkah ini, maka bisa dipastikan seluruh file Anda yang ter-hidden akan muncul bahkan virus shortcut juga akan ikut muncul.</p>\r\n<p><span style=\"font-size: 16px;\"><strong>2. Lakukan proses remove attribute pada storage device Anda</strong></span></p>\r\n<p><img class=\"aligncenter\" style=\"height: 329px; width: 606px;\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/command-prompt-remove-attribute.jpg\" alt=\"command prompt\" /></p>\r\n<p>Pada langkah kedua ini Anda melakukan proses remove attribute. Silahkan buka Command Prompt Anda pada start menu. Setelah itu, ketiklah drive yang Anda ingin tuju, misalnya Anda ingin masuk ke drive D, lalu ketiklah pada Command Prompt Anda D: lalu tekan enter, maka sistem pada windows Anda akan menjalankan perintah untuk pindah ke drive yang Anda inginkan. Langkah selanjutnya adalah melakukan remove attribut dengan cara tuliskan \"attrib -s -h -r /s /d\" pada Command Prompt Anda tadi, kemudian tekan enter.</p>\r\n<p><strong><span style=\"font-size: 16px;\">3. Hapuslah virus dari storage device</span></strong></p>\r\n<p><img class=\"aligncenter\" style=\"height: 503px; width: 800px;\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/removing-malware.jpg\" alt=\"anti-virus\" /></p>\r\n<p>Langkah terakhir yang dapat Anda lakuka yakni dengan cara menghapus ataupun membuang virus dari storage device komputer dan laptop Anda. Terdapat dua cara yang bisa Anda lakukan, pertama menghapus menggunakan anti-virus, dan yang kedua yaitu menghapusnya secara manual. Apabila Anda memilih untuk menghapus virus tersebut dengan menggunakan anti-virus, Anda cukup melakukannya dengan cara scanning.</p>\r\n<p>Jika Anda ingin menghapusnya secara manual, silahkan hapus file yang terkena virus shortcut yang telah tertera pada komputer Anda, biasanya virus ini berekstensi file \'.ink\'. Namun akan sangat disarankan menghapusnya dengan anti-virus dikarenakan dengan menggunakan anti-virus akar-akar virus shortcut ini dapat diberantas habis oleh anti-virus.</p>\r\n<p>Inilah langkah-langkah yang dapat ProDigital.web.id jabarkan. Semoga bermanfaat untuk Anda.</p>\r\n<p>Sumber: carisinyal.com</p>', 'Berikut Cara Menghilangkan Virus Shortcut Pada Komputer Atau Laptop - Perangkat elektronik saat sekarang ini seperti laptop, komputer ataupun smartphone tidak terpisah pada kehidupan kita', 'post', 'Minggu', 19, 5, 2019, '2019-05-19', '22:03:00', '1558278180', '2019-05-19 22:03:00', '1558278181', 'berikut-cara-menghilangkan-virus-shortcut-pada-komputer-atau-laptop', 252, 1, 1, '', 'Afrioni', 'd3786e052019_viruscomputer.jpg', 'post/052019', '', 0, 0),
(28, 'demo', 'Google Akan Cabut Lisensi Android Pada Smartphone Huawei', '', '', '<p><a href=\"https://www.prodigital.web.id/post/28/google-akan-cabut-lisensi-android-pada-smartphone-huawei.html\" target=\"_blank\">Google Akan Cabut Lisensi Android Pada Smartphone Huawei</a> - tekno.kompas.com - Perang dagang antara Amerika Serikat dan China terus berbuntut panjang. Setelah dinyatakan masuk dalam daftar hitam oleh pemerintah AS, Huawei kini berpotensi kehilangan lisensi sistem operasi Android miliknya.</p>\r\n\r\n<p>Hal tersebut karena Google dikabarkan bakal mengambil langkah ekstrem dengan menangguhkan bisnis dan kerja sama dengan Huawei, baik <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\">hardware</a> maupun <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\">software</a>.</p>\r\n\r\n<p>Langkah tersebut merupakan tindak lanjut atas peraturan pemerintah AS yang melarang Huawei membeli segala komponen dalam bentuk apa pun dari perusahaan AS tanpa persetujuan pemerintah setempat.</p>\r\n\r\n<p>Menurut sumber terdekat, kebijakan pemerintah AS ini tentu akan berpengaruh besar pada lini bisnis ponsel pintar Android milik Huawei.</p>\r\n\r\n<p>Selain kehilangan lisensi, <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a> Android berikutnya yang digarap Huawei akan kehilangan akses ke layanan utama milik Google, termasuk Google Play Store, Gmail, dan YouTube.</p>\r\n\r\n<p>Update: Juru bicara Google telah memberikan pernyataan resmi perusahaan terkait kabar penarikan lisensi <a href=\"https://www.prodigital.web.id/kategori/12/android.html\" target=\"_blank\">Android</a> Huawei.</p>\r\n\r\n<p>&quot;Kami mematuhi order yang diberikan (pemerintah AS) dan sedang menganalisis dampaknya&quot;, ujar juru bicara Google ke situs teknologi Android Police.</p>\r\n\r\n<p>Kendati demikian, Huawei masih memiliki kesempatan untuk menggunakan sistem operasi Android meski telah kehilangan lisensi. Pasalnya, Android merupakan sistem operasi terbuka (open-source) yang berbasis komunitas.</p>\r\n\r\n<p>Hanya, aplikasi buatan Google lain, seperti Gmail, Chrome, dan Play Store, tidak akan dapat digunakan di smartphone Android karena layanan tersebut memerlukan perjanjian komersial antara Huawei dan Google.</p>\r\n\r\n<p>&quot;Huawei hanya akan dapat menggunakan sistem operasi Android versi publik dan tidak akan mendapatkan akses ke aplikasi dan layanan eksklusif dari Google,&quot; ujar sumber tersebut.</p>\r\n\r\n<p>Dikutip KompasTekno dari Reuters, Senin (20/5/2019), dengan dicabutnya lisensi ini, artinya Huawei tidak akan lagi mendapat dukungan teknis dari Google. Kendati demikian, hal tersebut sejatinya sudah diantisipasi oleh Huawei sejak jauh-jauh hari.</p>\r\n\r\n<p>Huawei dikabarkan telah menyiapkan sebuah &quot;rencana B&quot; yakni dengan membuat serta mengembangkan teknologi sendiri seandainya Huawei diblokir dari penggunaan Android.</p>\r\n\r\n<p>Menurut salah satu petinggi Huawei, Eric Xu, siapa pun sejatinya berhak mendapatkan dan mengembangkan Android karena Android merupakan sistem operasi terbuka yang berbasis komunitas.</p>\r\n\r\n<p>&quot;Apa pun yang terjadi, Android tidak memiliki hak hukum untuk memblokir perusahaan mana pun untuk dapat mengakses lisensi open-source,&quot; kata Eric. Meski Huawei memiliki rencana lain, menurut peneliti dari lembaga riset pasar CCS Insight, aturan yang diberlakukan pemerintah AS ini akan tetap berdampak signifikan pada lini bisnis smartphone Huawei, khususnya untuk wilayah Eropa.</p>\r\n\r\n<p>Pasalnya, sampai saat ini, wilayah Eropa menjadi pasar terbesar kedua milik Huawei.</p>\r\n\r\n<p>&quot;Memiliki aplikasi-aplikasi tersebut sangat penting bagi produsen ponsel pintar agar tetap kompetitif di wilayah semisal Eropa,&quot; ungkap Geoff Blaber, Vice President Research dari CCS Insight. Huawei sendiri baru saja dimasukkan ke dalam blacklist sebagai brand yang terlarang dalam urusan perdagangan. Pemerintah AS tak hanya memasukkan nama Huawei. Ada pula sebanyak 70 afiliasi Huawei yang ikut serta dimasukkan ke dalam daftar hitam bernama &quot;entity list&quot; tersebut.</p>\r\n\r\n<p>Seluruh perusahaan yang masuk dalam daftar ini dilarang membeli komponen dalam bentuk apa pun dari perusahaan AS tanpa persetujuan pemerintah AS. Jika Huawei ingin membeli komponen tertentu dari perusahaan AS, Huawei harus mengajukan izin kepada pemerintah AS untuk membeli komponen tersebut. Posisi Huawei saat ini memang sangat bergantung pada para pemasok komponen dari Amerika Serikat, termasuk Google sebagai pemilik lisensi sistem operasi Android untuk ponsel pintar yang juga digarap oleh Huawei.</p>\r\n\r\n<p>Sumber: tekno.kompas.com<br />\r\nPenulis : Yudha Pratomo<br />\r\nEditor : Reza Wahyudi</p>', 'Google Akan Cabut Lisensi Android Pada Smartphone Huawei - tekno.kompas.com - Perang dagang antara Amerika Serikat dan China terus berbuntut panjang. Setelah dinyatakan masuk dalam daftar hitam', 'post', 'Rabu', 22, 5, 2019, '2019-05-22', '17:33:00', '1558521180', '2019-05-22 17:33:00', '1558521227', 'google-akan-cabut-lisensi-android-pada-smartphone-huawei', 91, 1, 1, '', 'Afrioni', '80c201052019_googleimg.jpg', 'post/052019', '', 1, 1),
(29, 'demo', '3 Fitur Whatsapp Yang Mungkin Belum Diketahui Banyak Orang', '', '', '<p><a href=\"https://www.prodigital.web.id/post/29/3-fitur-whatsapp-yang-mungkin-belum-diketahui-banyak-orang.html\" target=\"_blank\">3 Fitur Whatsapp Yang Mungkin Belum Diketahui Banyak Orang</a> - WhatsApp adalah sarana komunikasi online yang saat ini banyak digunakan oleh orang di seluruh dunia dengan menggunakan <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a>. dengan banyak fitur yang ditawarkan oleh WhatsApp dan kemudahan penggunaannya membuat banyak orang tidak ingin lepas dari WhatsApp.</p>\r\n\r\n<p>Pengguna WhatsApp ini hampir mencakup semua kalangan dan semua umur, mulai dari anak-anak hingga orang dewasa. Penggunaan WhatsApp ini juga memberikan banyak manfaat sebagai sarana komunikasi yang menggunakan <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\">internet</a> secara online. Seperti layaknya group di WhatsApp, penggunanya dapat menikmati komunikasi secara beramai-ramai dan membentuk sebuah komunitas yang terdapat pada aplikasi WhatsApp.</p>\r\n\r\n<p>Untuk kemajuan dan pengembangan, WhatsApp telah banyak melakukan pembaruan sehingga terdapat fitur yang telah ditambah ataupun tidak lagi ditampilkan. Hal tersebut dilakukan untuk mepermudah penggunanya. Aplikasi ini juga dilengkapi dengan perlindungan kuota data dan banyak fitur lainya yang dapat dinikmati oleh penggunanya.</p>\r\n\r\n<p>Berikut adalah 3 fitur WhatsApp yang mungkin belum diketahui oleh banyak orang belum yang dilansir dari berbagai sumber:</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>1. Limited Data Usage</strong></span></p>\r\n\r\n<p>Pada fitur ini, pengguna bisa melindungi banyak penggunaan data yang digunakan melalui pengaturan yakni fitur Limiting Data Usage.</p>\r\n\r\n<p>Pada fitur tersebut, pengguna WhatsApp bisa mengatur pemilihan kapan pengunduhan file dengan kuota data atau konektivitas WiFi.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>2. Senyapkan Pesan</strong></span></p>\r\n\r\n<p>Fitur ini sangat cocok ketika pengguna memiliki banyak percakapan yang aktif pada saat yang sama. Pengguna juga dapat menyematkan percakapan yang paling penting agar tidak &quot;tenggelam&quot; ataupun terlewatkan oleh percakapan yang baru masuk.</p>\r\n\r\n<p>Untuk penggunaan WhatsApp pada perangkat <a href=\"https://www.prodigital.web.id/kategori/13/ios.html\" target=\"_blank\">iOS</a>, pengguna dapat menggeser percakapan dari kiri ke kanan, setelah itu pengguna dapa melihat opsi untuk menyematkan percakapan.</p>\r\n\r\n<p>Pada sistem operasi Android tertentu, pengguna biasanya harus menekan salah satu percakapan beberapa detik lalu mengetuk ikon pin.</p>\r\n\r\n<p><strong><span style=\"font-size:16px\">3. Sesuaikan Notifikasi</span></strong></p>\r\n\r\n<p>WhatsApp juga memberikan kemudahan untuk penggunanya yakni mampu menyesuaikan nada peringatan untuk setiap pesan yang masuk. Hal ini dapat membantu pengguna WhatsApp untuk membedakan dan menandai dari percakapan mana setiap pesan berasal.</p>\r\n\r\n<p>Untuk itu, pengguna dapat mengatur fitur dengan cara mengetuk nama jendela obrolan lalu pilih Custom Tone atau pada sistem operasi <a href=\"https://www.prodigital.web.id/kategori/12/android.html\" target=\"_blank\">Android</a> terdapat pada opsi Notifikasi khusus. Kemudian pilih nada spesifik yang diinginkan untuk grup atau obrolan secara&nbsp; individual di WhatsApp.</p>', '3 Fitur Whatsapp Yang Mungkin Belum Diketahui Banyak Orang - WhatsApp adalah sarana komunikasi online yang saat ini banyak digunakan oleh orang di seluruh dunia dengan menggunakan smartphone.', 'post', 'Jum\'at', 24, 5, 2019, '2019-05-24', '13:59:00', '1558681140', '2019-05-24 13:59:00', '1558681147', '3-fitur-whatsapp-yang-mungkin-belum-diketahui-banyak-orang', 207, 1, 1, '', 'Afrioni', '28323f052019_fiturterbaruwhatsapp.jpg', 'post/052019', '', 0, 0);
INSERT INTO `memo_konten` (`kontenId`, `kontenUsername`, `kontenJudul`, `kontenJudulBesar`, `kontenJudulKecil`, `kontenPost`, `kontenRingkas`, `kontenType`, `kontenHari`, `kontenDd`, `kontenMm`, `kontenYy`, `kontenDate`, `kontenJam`, `kontenTimestamp`, `kontenDatetime`, `kontenAddDate`, `kontenSlug`, `kontenRead`, `kontenStatusKomen`, `kontenStatus`, `kontenEditor`, `kontenPenulis`, `kontenImg`, `kontenDirImg`, `kontenTextImg`, `kontenHeadline`, `kontenFeature`) VALUES
(30, 'demo', 'Apa Itu VPN? dan Cara Kerja VPN', '', '', '<p>Pro Digital kali ini akan membahas secara lengkap apa itu Virtual Private Network atau bisa disingkat dengan VPN. VPN adalah perluasan jaringan pribadi hingga ke jaringan publik, dan memberikan kemampuan bagi pengguna untuk mengirimkan dan menerima data sepanjang jaringan publik atau jaringan bersama seakan-akan komputer pengguna tersebut berhubungan dalam jaringan pribadi (<a href=\"https://id.wikipedia.org/wiki/Jaringan_pribadi_virtual\" target=\"_blank\">Wikipedia</a>). VPN saat sekarang ini sudah banyak digunakan orang dengan tujuan mendapatkan koneksi jaringan internet secara aman, pribadi, dan tentunya diakses secara remote.</p>\r\n\r\n<p>Secara sederhananya, VPN mengkoneksikan perangkat kita seperti <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\">smartphone</a>, <a href=\"https://www.prodigital.web.id/kategori/7/laptop.html\" target=\"_blank\">laptop</a> atau <a href=\"https://www.prodigital.web.id/kategori/2/komputer.html\" target=\"_blank\">komputer</a> PC ataupun tablet ke jaringan komputer lain atau VPN Server yang terkoneksi <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\">internet</a> yang mengizinkan kita untuk berinternet menggunakan komputer VPN server terebut. VPN biasanya menggunakan Server dari berbagai negara, baik dari negara kita sendiri maupun di negara yang berbeda.</p>\r\n\r\n<p>Saat berselancar dengan internet yang menggunakan VPN, koneksi jaringan internet yang digunakan adalah koneksi dimana kita menggunakan IP dari negara yang telah kita pilih menggunakan VPN. Misal, saat kita menggunakan VPN dari negara singapura maka koneksi jaringan internet yang digunakan adalah jaringan internet dari singapura.</p>\r\n\r\n<p>Agar bisa memahami cara kerja VPN ini, ada baiknya kita simak dari penjelasan berikut ini.</p>\r\n\r\n<p><span style=\"font-size:20px\"><strong>Cara Kerja VPN</strong></span></p>\r\n\r\n<p>Dari penjelasan di atas tadi maka kita dapat mengetahui fungsi dari VPN. Pada point ini kita akan membahas cara kerja dari VPN. Cara kerja VPN&nbsp; adalah melakukan enkripsi pertukaran data melalui koneksi internet secara aman yang mengunakan jalur khusus atau tanpa menggunakan koneksi jaringan internet pada umumnya.</p>\r\n\r\n<p>Dengan berinternet menggunakan VPN maka sebenarnya kita sudah menghindari adanya penyusup saat sedang melakukan pertukaran data menggunakan internet yang sewaktu-waktu bisa masuk ke jalur lintas jaringan pada umumnya.</p>\r\n\r\n<p>Server VPN yang kita gunakan bertugas untuk meneruskan permintaan data pada situs yang sedang kita akses. Permintaan data atau situs yang sedang kita akses akan dikenali sebagai koneksi dari jaringan server VPN bukan jaringan yang digunakan pada saat itu.</p>\r\n\r\n<p>Berikut adalah topologi dari koneksi jaringan internet yang menggunakan VPN.</p>\r\n\r\n<p><img alt=\"VPN Topology\" class=\"aligncenter\" src=\"https://www.prodigital.web.id/memo_konten/uploads/images/content_post/images/vpn-protects-from-isp2.jpg\" style=\"height:318px; width:650px\" /></p>\r\n\r\n<p>Dapat kita lihat dari toplogi di atas, ketika kita menggunakan VPN, data dienkripsi oleh aplikasi VPN setelah itu dikirimkan melalui Internet Service Provider (ISP) kemudian ke server VPN. Server VPN adalah perangkat ketiga yang menghubungkan kita dengan situs yang kita minta.</p>\r\n\r\n<p>Apabila kita tidak menggunakan VPN atau koneksi jaringan internet standar maka tidak akan ada proses enkripsi data dan data yang kita minta dengan koneksi internet seperti ini bisa saja akan dilihat oleh orang lain.</p>\r\n\r\n<p>Tidak ada masalah apabila kita mengakses hanya untuk sekedar nonton video, melakukan pencarian di google, hiburan dan bersosial media. Namun akan menjadi sangat penting ketika melakukan transaksi data penting seperti, email, bisnis, transaksi perbankan atau data yang dianggap penting lainnya. Oleh karena itu berbeda pula cara mengaksesnya.</p>\r\n\r\n<p><span style=\"font-size:20px\"><strong>Manfaat Menggunakan VPN</strong></span></p>\r\n\r\n<p>Ada beberapa manfaat yang akan kita dapatkan pada saat menggunakan VPN, antara lain adalah:</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>1. Remote Access</strong></span></p>\r\n\r\n<p>Dengan mengunakan VPN maka kita dapat mengakses jaringan komputer di kantor atau di mana saja melalui jaringan internet. Walaupun kita menggunakan jaringan luar, ketika kita telah menggunakan VPN maka jaringan kita bisa dikenali oleh internet menggunakan jaringan kantor.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>2. ByPass</strong></span></p>\r\n\r\n<p>Kita bisa melwati pembatas terhadap situs yang tidak bisa diakses menggunakan jaringan biasa, namun dengan menggunakan VPN, situs yang tadinya tidak bisa kita akses dapat diakses menggunakan VPN. Misalnya situs yang diblokir oleh kebijakan pemerintah ataupun mengakses situs yang dianggap membahayakan, dan lain sebagainya.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>3. Pengamanan Data Pada Jaringan Publik</strong></span></p>\r\n\r\n<p>Melindungi transaksi data yang kita lakukan dari WiFi, jaringan publik atau jaringan yang tidak dapat dipercaya. Misalnya jaringan publik seperti kafe, bar, dan semacamnya.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>4. Mengamankan Informasi Pribadi Secara Anonim</strong></span></p>\r\n\r\n<p>VPN dapat menyembunyikan lokasi kita secara realtime atau langsung. Jadi, tidak sembarangan orang bisa mengetahui lokasi kita saat melakukan akses. Biasanya lokasi yang terdeteksi adalah lokasi server VPN berada.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>5. Data Dienkripsi</strong></span></p>\r\n\r\n<p>Saat berselancar di internet data kita dienkripsi oleh aplikasi VPN. Sehingga meskipun seseorang melihat apa yang komputer kita kirimkan, mereka hanya melihat informasi yang sudah terenkripsi.</p>\r\n\r\n<p><span style=\"font-size:16px\"><strong>6. Meng-enkripsi Informasi Perangkat</strong></span></p>\r\n\r\n<p>Orang lain tidak bisa dengan mudah membaca perangkat yang sedang kita gunakan, atau apa yang sedang lakukan.</p>\r\n\r\n<p><span style=\"font-size:20px\"><strong>Kekurangan dan Kelebihan VPN</strong></span></p>\r\n\r\n<p>Ada beberapa kekurangan dan kelebihan dalam menggunakan VPN ini. Berikut kelebihan dan kekurangannya.</p>\r\n\r\n<p><strong>Kelebihan </strong></p>\r\n\r\n<ul>\r\n	<li>Kerahasiaan data lebih aman.</li>\r\n	<li>Bisa mengakses website terblok.</li>\r\n	<li>Identitas IP asli tidak langsung diketahui.</li>\r\n	<li>Akses jaringan dari lokasi yang berbeda.</li>\r\n</ul>\r\n\r\n<p><strong>Kekurangan</strong></p>\r\n\r\n<ul>\r\n	<li>Koneksi lebih lambat.</li>\r\n	<li>Koneksi tidak stabil.</li>\r\n	<li>Konfigurasi manual cukup rumit.</li>\r\n	<li>Ada batasan penggunaan.</li>\r\n</ul>\r\n\r\n<p><span style=\"font-size:20px\"><strong>Cukup Amankah Menggunakan VPN?</strong></span></p>\r\n\r\n<p>VPN dapat membuat koneksi jaringan kita sangat aman, namun tergantung dengan protokol yang kita gunakan untuk melakukan koneksi. Keamanan ini terkadang menjadi faktor utama.</p>\r\n\r\n<p>Sebenarnya masih ada penghalang dalam menggunakan VPN yaitu:</p>\r\n\r\n<p><span style=\"font-size:14px\"><strong>Batasan Teknologi</strong></span></p>\r\n\r\n<p>Limitasi teknologi yang digunakan untuk mengembangan VPN, seperti tipe protokol dan enkripsi yang digunakan.</p>\r\n\r\n<p><span style=\"font-size:14px\"><strong>Batasan Hukum</strong></span></p>\r\n\r\n<p>Batasan hukum dan kebijakan memengaruhi apa yang dapat dilakukan pada suatu perkembangan teknologi itu. Begitu pula dengan undang-undang negara tempat server dan perusahaan penyedia VPN berada. Kebijakan perusahaan sendiri juga dapat mempengaruhi cara perusahaan yang menerapkan teknologi ini dalam layanan mereka.</p>\r\n\r\n<p>Jadi boleh dibilang tidak sepenuhnya penggunaan VPN itu aman. Namun, paling tidak penggunaan VPN ini bisa lebih aman dibandingkan menggunakan koneksi jaringan internet biasa.</p>\r\n\r\n<p><span style=\"font-size:20px\"><strong>Kapan kita harus menggunakan VPN?</strong></span></p>\r\n\r\n<p>Kapankah kita harus menggunakan VPN adalah alasan menarik dalam memaksimalkan penggunaan VPN ini. yakni ketika.</p>\r\n\r\n<ul>\r\n	<li>Membantu kita mendapatkan koneksi yang lebih aman saat menggunakan jaringan internet secara publik.</li>\r\n	<li>Mengenkripsi aktivitas kita pada situs web.</li>\r\n	<li>Menyembunyikan aktivitas kita terhadap orang yang ingin mencoba masuk kejaringan kita dan mengetahui secara diam-diam.</li>\r\n	<li>Menyembunyikan lokasi, dan mengizinkan kita mengakses geo-blocked content atau konten-konten yang diblok berdasarkan wilayah geografis.</li>\r\n	<li>Memastikan kita lebih anonim di dalam situs web.</li>\r\n</ul>\r\n\r\n<p>Itulah beberapa penjelasan secara umum mengenai apa itu VPN dan cara kerjanya. Semoga tulisan ini memeberikan manfaat dan wawasan kita dengan teknologi VPN.</p>\r\n\r\n<p>Sumber: www.niagahoster.co.id, id.wikipedia.org</p>', 'Pro Digital kali ini akan membahas secara lengkap apa itu Virtual Private Network atau bisa disingkat dengan VPN. VPN adalah perluasan jaringan pribadi hingga ke jaringan publik, dan memberikan', 'post', 'Sabtu', 25, 5, 2019, '2019-05-25', '14:03:00', '1558767780', '2019-05-25 14:03:00', '1558695444', 'apa-itu-vpn-dan-cara-kerja-vpn', 311, 1, 1, '', 'Afrioni', '76e69d052019_phonevpn.jpeg', 'post/052019', '', 0, 0),
(31, 'demo', 'Xiaomi, Oppo, Vivo Sudah Jajal OS Pengganti Android Buatan Huawei', '', '', '<p>Huawei yang kehilangan lisensi Android, mengembangkan HongMeng sebagai sistem operasi pengganti. Tak hanya Huawei, vendor smartphone asal China lainnya yakni Xiaomi, Oppo dan Vivo turut mencoba sistem operasi ini.</p>\r\n<p>Menurut kabar, Huawei kini tengah gencar mengujicoba HongMeng yang konon akan dirilis pada tahun ini. Dalam uji coba tersebut, Xiaomi, Oppo dan Vivo juga mengirimkan tim internal untuk ikut merasakan sistem operasi tersebut.</p>\r\n<p>Hasilnya, sistem operasi HongMeng ini diklaim bisa mendongkrak performa ponsel 60 persen lebih cepat dibandingkan jika menggunakan OS Android.</p>\r\n<p>Dikutip KompasTekno dari Global Times, Jumat (14/6/2019), dalam pengembangan sistem operasi ini Huawei tak bekerja sendirian. Selain bekerja dengan Xiaomi, Oppo dan Vivo, Huawei juga menggandeng Tencent untuk turut meningkatkan kinerja OS HongMeng.</p>\r\n<p>Sayangnya baik Tencent maupun Xiaomi, menolak untuk berkomentar terkait kabar tersebut.</p>\r\n<p>Huawei sendiri mempercepat pembuatan sistem operasi ini setelah pemerintah Amerika Serikat memasukkan nama Huawei ke dalam daftar bernama \"entity list\".</p>\r\n<p>Perusahaan yang masuk dalam daftar tersebut tidak diperkenankan membeli komponen dalam bentuk <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\" rel=\"noopener\">software</a> dan hardware ke perusahaan asal AS, tanpa seizin pemerintah AS.</p>\r\n<p>Sehingga, Huawei berpotensi kehilangan lisensi sistem operasi Android yang notabene dimiliki oleh Google yang merupakan perusahaan asal Amerika Serikat.</p>\r\n<p>Tak hanya itu, beberapa perusahaan lain pun turut menangguhkan kerja sama mereka dengan Huawei. Contohnya Facebook.</p>\r\n<p>Perusahaan ini juga menangguhkan kerja sama dengan Huawei sehingga aplikasi seperti Facebook, Instagram dan WhatsApp tidak akan dapat terinstal secara bawaan pada ponsel Huawei.</p>\r\n<p>Kendati demikian, beberapa analis mengungkapkan bahwa sistem operasi HongMeng diduga akan mulai dibenamkan pada ponsel Huawei P40 mendatang.</p>\r\n<p>Bahkan menurut sumber terdekat, masih ada sejumlah perusahaan teknologi besar yang juga turut membantu Huawei mengembangkan sistem operasi ini.</p>\r\n<p>Sumber: tekno.kompas.com</p>', 'Huawei yang kehilangan lisensi Android, mengembangkan HongMeng sebagai sistem operasi pengganti. Tak hanya Huawei, vendor smartphone asal China lainnya yakni Xiaomi, Oppo dan Vivo turut mencoba', 'post', 'Minggu', 16, 6, 2019, '2019-06-16', '12:35:00', '1560663300', '2019-06-16 12:35:00', '1560663326', 'xiaomi-oppo-vivo-sudah-jajal-os-pengganti-android-buatan-huawei', 103, 1, 1, '', 'Afrioni', 'ac9ee0062019_huaweiajukanmerekdaganguntukosbarupenggantiandroidvisote3y1q.jpg', 'post/062019', '', 1, 1),
(32, 'demo', 'Berikut Penyebab Baterai Handphone Cepat Habis dan Cara Mengatasinya', '', '', '<p>Baterai merupakan sumber daya utama bagi banyak perangkat portabel seperti handphone (HP). Agar dapat digunakan dalam jangka waktu yang lama, jenis baterai yang digunakan oleh perangkat seperti handphone adalah yang dapat diisi ulang. Beberapa baterai hp model lama dapat dicabut dan diganti jika sudah rusak. Sedangkan saat ini banyak <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\" rel=\"noopener\">smartphone</a> yang sudah mengadopsi fitur baterai yang tidak dapat dilepas (non-removable).</p>\r\n<p>Meskipun sebuah HP memiliki ukuran baterai yang besar (dihitung dalam mAh), belum tentu daya tahan baterainya bagus. Terdapat beberapa penyebab baterai HP yang cepat habis, hal ini disebabkan oleh beberapa fitur atau aplikasi HP yang terus berjalan di belakang layar atau tingkat kecerahan layar yang terlalu tinggi.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>1. Tingkat Kecerahan Layar Terlalu Tinggi</strong></span></p>\r\n<p>Saat berada di luar ruangan yang cerah, kadang kita harus menaikkan tingkat kecerahan layar handphone kita. Gunanya tak lain agar kita dapat membaca layar dengan mudah. Ternyata hal ini adalah salah satu penyebab utama mengapa daya baterai lebih cepat terkuras.</p>\r\n<p>Untuk meminimalisir hal ini, segera atur kembali tingkat kecerahan handphone kita serendah mungkin (cukup untuk bisa membaca layar di dalam ruangan) setelah aktivitas di luar ruangan selesai. Jika tidak ingin ribet mengatur-atur, gunakan saja fitur kecerahan layar otomatis yang akan berubah sesuai kondisi pencahayaan disekitarnya.</p>\r\n<p>Cara lain yang bisa dilakukan untuk menghemat daya baterai adalah dengan segera mematikan layar handphone setelah berhenti menggunakannya.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>2. WiFi yang Terus Bekerja</strong></span></p>\r\n<p>Umumnya setiap ponsel pintar sudah dibekali dengan fitur WiFi agar dapat terhubung ke jaringan nirkabel tersebut. Cukup dengan mengaktifkan tombol WiFi di menu pengaturan jaringan, handphone kita akan bekerja mencari-cari sinyal WiFi yang tersedia. Terhubung dengan jaringan WiFi adalah sebuah cara untuk menghemat kuota data kita.</p>\r\n<p>Jika ternyata tidak ada sinyal WiFi yang ditemukan dan kita membiarkan pemindai WiFi terus bekerja, maka bukan tidak mungkin baterai hp kita jadi cepat habis. Oleh karena itu, segera matikan pemindai WiFi jika kita tidak menemukan sinyal WiFi yang bisa digunakan.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>3. GPS Aktif Terus Menerus</strong></span></p>\r\n<p>GPS yang terus-terusan aktif juga bisa menjadi salah satu penyebab baterai handphone cepat habis. Jika fitur ini tidak dimatikan, sistem akan terus bekerja melacak lokasi dimana kita berada (saat terhubung ke internet). Fitur ini memang sangat berguna bagi sebagian pengguna sehingga diaktifkan terus sepanjang hari.</p>\r\n<p>Beberapa aplikasi membutuhkan GPS untuk dapat bekerja, seperti Google Maps saat kita hendak mencari sebuah lokasi. Jika hal ini sedang tidak dibutuhkan, pastikan untuk mematikan GPS dan menutup aplikasi tersebut.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>4. Aplikasi yang Terus Berjalan di Belakang Layar</strong></span></p>\r\n<p>Penyebab baterai hp cepat habis lainnya adalah adanya aplikasi-aplikasi yang terus berjalan di belakang layar tanpa sepengetahuan kita. Tidak semua aplikasi yang telah selesai kita gunakan dan tutup akan berhenti begitu saja. Beberapa diantaranya ada yang terus beraktivitas di latar belakang untuk tujuan tertentu.</p>\r\n<p>Kita dapat mengetahui aplikasi mana saja yang menggunakan daya baterai paling banyak dengan cara pergi ke pengaturan baterai (tersedia di Android dan iOS). Di sana terdapat informasi yang menunjukkan aplikasi yang berjalan lengkap dengan besaran daya baterai yang telah mereka konsumsi.</p>\r\n<p>Agar baterai jadi lebih awet, kita bisa menonaktifkan aplikasi tidak penting yang bekerja di belakang layar. Jika hp-mu memiliki fitur optimisasi bawaan, kamu bisa menggunakan hal itu untuk memaksimalkan daya baterai.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>5. Berlebihan Menggunakan Aplikasi dan Aktivitas yang Menguras Baterai</strong></span></p>\r\n<p>Beberapa aplikasi hiburan seperti video dan musik streaming bisa sangat menguras daya baterai jika digunakan berlebihan. Begitu juga dengan bermain game-game bergrafis berat, jika kita terlalu lama menggunakannya, maka baterai hp kita bisa cepat terkuras. Sedangkan contoh aktivitas yang dapat menguras cukup banyak baterai jika dipakai berlebihan adalah tethering.</p>\r\n<p>Jadi, bagaimana caranya agar baterai hp kita lebih hemat? Misalnya, jika ingin membaca sebuah berita atau mencari informasi, kamu bisa membaca daripada menonton video. Juga, hindari bermain game untuk jangka waktu yang lama, karena selain dapat menguras daya cukup cepat, hal itu juga dapat membuat masa pakai baterai lebih cepat menurun.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>6. Susah Sinyal</strong></span></p>\r\n<p>Sebuah handphone akan menggunakan lebih banyak memakan daya saat mencoba terhubung di area dengan sinyal yang rendah. Jika kita tidak bisa mendapatkan sinyal, sebaiknya nyalakan mode pesawat (airplane mode) agar daya ponsel tidak terkuras cepat. Kemudian restart koneksi seluler ketika sudah berada di area dengan jangkauan sinyal yang lebih baik.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>7. Software Tidak Up-To-Date</strong></span></p>\r\n<p>Masalah baterai handphone cepat habis juga dapat disebabkan oleh software yang sudah usang atau tidak up-to-date. <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\" rel=\"noopener\">Software</a> yang diperbarui biasanya membawa perbaikan untuk bug tertentu yang mungkin berkontribusi pada masalah masa pakai baterai handphone kita. Jika memang demikian, sebaiknya segera perbarui software ke versi yang lebih baru.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>8. Masalah Pada Hardware</strong></span></p>\r\n<p>Masalah pada <a href=\"https://www.prodigital.web.id/kategori/9/hardware.html\" target=\"_blank\" rel=\"noopener\">hardware</a> utamanya disebabkan oleh kondisi baterai yang sudah buruk dan pengisi daya yang rusak. Jika masa pakai baterai hp kita sudah melebihi ketentuannya, maka bukan tidak mungkin masalah baterai cepat habis akan terus terjadi sepanjang hari.</p>\r\n<p>Selain itu, pengisi daya atau charger yang tidak berfungsi dengan baik juga dapat menyebabkan kerusakan pada baterai yang akhirnya berpengaruh pada daya tahannya.</p>\r\n<p>Jika kedua hal ini yang menjadi penyebab utama baterai hp cepat habis, maka opsi terbaik kita adalah mengganti baterai atau charger dengan yang baru. Beberapa baterai handphone masa kini tidak dapat kita lepas sendiri sehingga harus dilakukan oleh ahlinya pada pusat layanan.</p>\r\n<p>Hal yang paling penting di sini adalah dengan menggunakan produk pengganti atau aksesoris original agar kualitasnya terjamin. Meskipun produk original selalu dijual lebih mahal, tetapi apa yang kamu dapatkan bisa sesuai dengan ekspektasi yang diinginkan.</p>\r\n<p>Itulah beberapa penyebab baterai handphone atau smartphone cepat habis dan juga cara mengatasinya. Kasus di atas terjadi disetiap pengguna handphone yang berbeda-beda, jadi kemungkinan kecil semuanya terjadi bersamaan dalam satu perangkat.</p>\r\n<p>Jika masalah di atas sudah sudah dilakukan tapi baterai hp masih tetap boros, solusi terbaiknya adalah dengan mengganti handphone dengan unit baru. Daripada harus mengeluarkan banyak biaya untuk perbaikan yang berkepanjangan, sementara membeli yang baru bisa lebih baik dan lebih hemat?</p>\r\n<p>Sumber: carisinyal.com</p>', 'Baterai merupakan sumber daya utama bagi banyak perangkat portabel seperti handphone (HP). Agar dapat digunakan dalam jangka waktu yang lama, jenis baterai yang digunakan oleh perangkat seperti', 'post', 'Jum\'at', 28, 6, 2019, '2019-06-28', '01:05:00', '1561658700', '2019-06-28 01:05:00', '1561241624', 'berikut-penyebab-baterai-handphone-cepat-habis-dan-cara-mengatasinya', 88, 1, 1, '', 'Afrioni', '70a22a062019_bateraismartphonemenggelembung.jpg', 'post/062019', '', 0, 0),
(33, 'demo', 'Pembatasan Hak Akses Internet di Indonesia, SAFEnet Desak Pemerintah Menghentikan', '', '', '<p>Diperayaan hari jadinya yang ke-6, Southeast Freedom of Expression Network (SAFEnet) menyoroti pembatasan akses informasi <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\" rel=\"noopener\">internet</a> di Indonesia.</p>\r\n<p>\"Praktik semacam ini merupakan wujud mendasar dari praktik internet shutdown yang jelas melanggar hak-hak digital,\" ujar SAFEnet dalam keterangan tertulisnya, Jumat 28 Juni 2019.</p>\r\n<p>Menurut SAFEnet, prinsip pembatasan ekspresi, seperti yang tertuang dalam pasal 20 pada International Covenant on Civil and Political Rights (ICCPR), mencantumkan syarat bahwa pelaksanaan pembatasan tindak pidana harus jelas dan spesifik. \"Tidak menyamaratakan seperti yang dipraktikkan belakangan ini,\" tambah SAFEnet.</p>\r\n<p>Pembatasan informasi dalam bentuk internet throttling terjadi belum lama ini, pada 22-25 Mei 2019. Saat itu pemerintah Indonesia melakukan pembatasan akses terhadap media sosial terutama Twitter, Instagram, dan Facebook, serta <a href=\"https://www.prodigital.web.id/kategori/8/software.html\" target=\"_blank\" rel=\"noopener\">aplikasi</a> WhatsApp setelah aksi demonstrasi dan kerusuhan 21-22 Mei 2019.</p>\r\n<p>Melalui Kementerian Komunikasi dan Informasi (Kemkominfo), Pemerintah beralasan bahwa pembatasan fitur media sosial dan layanan pesan instan itu bertujuan untuk menghindari dampak negatif penyebarluasan konten yang tidak bisa dipertanggungjawabkan dan bersifat memprovokasi.</p>\r\n<p>Langkah tersebut diambil mengacu pada Undang-Undang Informasi dan Transaksi Elektronik (UU ITE), terutama bagian manajemen konten, yang mencakup pembatasan akses.</p>\r\n<p>Sekalipun pembatasan akses pada aplikasi tersebut di atas sudah tidak berlaku lagi, namun wacana untuk menggunakannya kembali muncul menjelang pengumuman sidang putusan Mahkamah Konstitusi hari ini, 27 Juni 2019.</p>\r\n<p>\"Sampai hari ini pertanggungjawaban atas evaluasi praktik pembatasan akses internet tidak kunjung dilaporkan. Alih-alih pemerintah malah mengumumkan bahwa mereka telah memberangus 61.000 akun Whatsapp yang diduga telah menyebarkan hoaks,\" tulis SAFEnet.</p>\r\n<p>Sumber: tekno.tempo.co</p>', 'Diperayaan hari jadinya yang ke-6, Southeast Freedom of Expression Network (SAFEnet) menyoroti pembatasan akses informasi internet di Indonesia.\r\n&quot;Praktik semacam ini merupakan wujud mendasar', 'post', 'Sabtu', 29, 6, 2019, '2019-06-29', '03:54:00', '1561755240', '2019-06-29 03:54:00', '1561755240', 'pembatasan-hak-akses-internet-di-indonesia-safenet-desak-pemerintah-menghentikan', 129, 1, 1, '', 'Afrioni', '3b1d14062019_tentanginternet.jpg', 'post/062019', '', 1, 1),
(34, 'demo', 'Presiden AS Donald Trump Izinkan Huawei Kembali Berbisnis dengan Perusahaan AS', '', '', '<p>Gempuran \"blacklist\" pemerintah Amerika Serikat (AS) kepada perusahaan Cina, termasuk Huawei, sepertinya bakal berakhir sebentar lagi.</p>\r\n<p>Pasalnya, Presiden AS, Donald Trump menyatakan bahwa perusahaan-perusahaan AS boleh kembali berbisnis dengan Huawei.</p>\r\n<p><strong>Baca juga: </strong><a href=\"https://www.prodigital.web.id/post/28/google-akan-cabut-lisensi-android-pada-smartphone-huawei.html\" target=\"_blank\" rel=\"noopener\"><strong>Google Akan Cabut Lisensi Android Pada Smartphone Huawei</strong> </a></p>\r\n<p>\"Perusahaan-perusahaan asal AS dapat menjual peralatan (komponen) mereka ke Huawei,\" kata Trump di momen pertemuan G-20 di Osaka, Jepang, Sabtu (29/6/2019) sore waktu setempat.</p>\r\n<p>Ia menambahkan, produk yang dijual ke Huawei adalah produk yang tidak memiliki efek untuk menimbulkan isu-isu keamanan nasional. Ia kemudian berkata bahwa Huawei pun diizinkan untuk menjual produk-produknya di AS.</p>\r\n<p>\"Saya telah setuju untuk mengizinkan mereka (perusahaan AS) untuk menjual produknya (ke Huawei),\" ujar Trump.</p>\r\n<p>Kendati begitu, Huawei masih belum dihapus dari daftar \"blacklist\", atau daftar merek yang tidak boleh bekerja sama dengan perusahaan-perusahaan AS.</p>\r\n<p>Trump pun masih terus membicarakan nasib Huawei dengan Presiden China, Xi Jinping. Trump menjelaskan, keputusan untuk mencabut Huawei dari daftar entitas Kementerian Perdagangan AS bakal dibicarakan kemudian karena dia bakal merapatkannya Selasa (2/7/2019).</p>\r\n<p>\"Kami bakal membahas Huawei di akhir. Kami akan melihat apa yang akan terjadi dengan perjanjian perdagangan yang disepakati,\" terang presiden 73 tahun itu.</p>\r\n<p>Secara tidak langsung, pernyataan Trump itu menunjukkan keputusan untuk mencabut larangan sepenuhnya terhadap Huawei bakal bergantung negosiasi mengakhiri perang dagang.</p>\r\n<p>Sumber: tekno.kompas.com</p>', 'Gempuran &quot;blacklist&quot; pemerintah Amerika Serikat (AS) kepada perusahaan Cina, termasuk Huawei, sepertinya bakal berakhir sebentar lagi.\r\nPasalnya, Presiden AS, Donald Trump menyatakan', 'post', 'Minggu', 30, 6, 2019, '2019-06-30', '23:55:00', '1561913700', '2019-06-30 23:55:00', '1561913746', 'presiden-as-donald-trump-izinkan-huawei-kembali-berbisnis-dengan-perusahaan-as', 59, 1, 1, '', 'Afrioni', '1ccc89062019_huaweilagi.jpeg', 'post/062019', '', 0, 0),
(35, 'demo', 'Mate 20 X, Ponsel 5G Pertama Huawei Meluncur 26 Juli?', '', '', '<p>Nasib Huawei dengan mitra bisnisnnya di AS saat ini <a href=\"https://www.prodigital.web.id/kategori/14/berita.html\" target=\"_blank\" rel=\"noopener\">diberitakan</a> memang masih terkatung-katung. Tapi hal itu tidak menyurutkan langkah vendor ponsel China itu untuk meluncurkan ponsel 5G pertamanya secara komersil.</p>\r\n<p>Kabarnya, Huawei berencana meluncurkan ponsel 5G perdananya, yakni Mate 20 X pada 26 Juli mendatang. Salah seorang sumber dalam mengumbar informasi tersebut. Huawei Mate 20 X akan dirilis di markas besar Huawei di Shenzen, Provinsi Guangdong, China.</p>\r\n<p><strong>Baca Juga: <a href=\"https://www.prodigital.web.id/post/34/presiden-as-donald-trump-izinkan-huawei-kembali-berbisnis-dengan-perusahaan-as.html\" target=\"_blank\" rel=\"noopener\">Presiden AS Donald Trump Izinkan Huawei Kembali Berbisnis dengan Perusahaan AS</a></strong></p>\r\n<p>Dengan begitu, Huawei akan merapatkan barisan bersama vendor <a href=\"https://www.prodigital.web.id/kategori/3/smartphone.html\" target=\"_blank\" rel=\"noopener\">smartphone</a> lain seperti Samsung, Xiaomi, dan Oppo yang lebih dulu meluncurkan <a href=\"https://www.prodigital.web.id/kategori/15/gadget.html\" target=\"_blank\" rel=\"noopener\">ponsel</a> 5G pertama masing-masing.</p>\r\n<p>Peluncuran ponsel 5G Huawei baru dilakukan setelah pemerintah China memberikan lampu hijau pada perusahaan telekomunikasi BUMN setempat, untuk menggulirkan layanan 5G pada bulan lalu.</p>\r\n<p>\"Peluncuran Huawei Mate 20 X akan mempercepat pertumbuhan pasar 5G di China, yang merupakan pasar smartphone terbesar,\" jelas James Yan, periset Counterpoint Beijing.</p>\r\n<p>Hal itu disebut Yan akan mengarahkan konsumen teknologi 5G menjadi lebih besar, dan menopang lebih banyak peluang di sektor rantai pasokan dan aplikasi.</p>\r\n<p>Huawei mengklaim, Mate 20X adalah smartphone pertama China yang mengantongi lisensi jaringan 5G. Itu artinya, pembeli akan bisa langsung merasakan betapa cepatnya konektivitas <a href=\"https://www.prodigital.web.id/kategori/6/internet.html\" target=\"_blank\" rel=\"noopener\">internet</a> generasi kelima itu setelah membeli Mate 20X.</p>\r\n<p>Kecepatan koneksi 5G bisa 10 hingga 100 kali lebih cepat dibanding jaringan 4G LTE. Kota Beijing disebut telah membangun 4.300 menara BTS 5G di titik area urban dan bangunan ikonik di sana.</p>\r\n<p><span style=\"font-size: 18pt;\"><strong>Spesifikasi Huawei Mate 20X</strong></span></p>\r\n<p>Soal spesifikasi, Mate 20X akan ditenagai chipset Kirin besutan Huawei sendiri. Dari rumor yang beredar, penampilan Mate 20X ini mirip dengan Mate 20, yakni dengan tiga kamera belakang yang tersusun persegi.</p>\r\n<p>Layarnya berbentang 7,2 inci dengan desain teardrop, alias notch yang membulat di sudut atas layar untuk menampung kamera depan.</p>\r\n<p>Tiga kamera belakangnya terdiri dari kamera utama 40 megapiksel, 8 megapiksel telefoto, dan 20 megapiksel ultra-wide. Sementara kamera depannya akan diisi oleh kamera tunggal beresolusi 24 megapiksel.</p>\r\n<p>Ponsel ini akan dibekali baterai 4.200 mAh dengan colokan USB type-C. Belum diketahui apakah ponsel ini akan berjalan dengan OS Android atau HongmengOS buatan Huawei. Harganya juga belum terkuak hingga saat ini.</p>\r\n<p>Berikut review dari ponsel Huawei Mate 20x</p>\r\n<p><iframe src=\"//www.youtube.com/embed/7cmhASOAVgs\" width=\"560\" height=\"315\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"></iframe></p>\r\n<p>Sumber: tekno.kompas.com</p>', 'Nasib Huawei dengan mitra bisnisnnya di AS saat ini diberitakan memang masih terkatung-katung. Tapi hal itu tidak menyurutkan langkah vendor ponsel China itu untuk meluncurkan ponsel 5G pertamanya', 'post', 'Sabtu', 13, 7, 2019, '2019-07-13', '23:44:00', '1563036240', '2019-07-13 23:44:00', '1563036263', 'mate-20-x-ponsel-5g-pertama-huawei-meluncur-26-juli', 53, 1, 1, '', 'Afrioni', 'ae2662072019_huawei_mate_20_x_5g_10.jpg', 'post/072019', '', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_menu_website`
--

CREATE TABLE `memo_menu_website` (
  `menuId` int(10) UNSIGNED NOT NULL,
  `menuParentId` int(10) UNSIGNED NOT NULL,
  `menuRelationshipId` int(10) UNSIGNED NOT NULL,
  `menuName` varchar(255) NOT NULL,
  `menuAccessType` varchar(50) NOT NULL,
  `menuUrlAccess` text NOT NULL,
  `menuAddedDate` int(11) UNSIGNED NOT NULL,
  `menuSort` mediumint(5) UNSIGNED NOT NULL,
  `menuActive` enum('y','n') NOT NULL,
  `menuAttrClass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_menu_website`
--

INSERT INTO `memo_menu_website` (`menuId`, `menuParentId`, `menuRelationshipId`, `menuName`, `menuAccessType`, `menuUrlAccess`, `menuAddedDate`, `menuSort`, `menuActive`, `menuAttrClass`) VALUES
(1, 0, 2, 'Komputer', 'newscategory_link', '{HOME_URL}/kategori/2/komputer.html', 1556517457, 1, 'y', ''),
(3, 0, 3, 'Smartphone', 'newscategory_link', '{HOME_URL}/kategori/3/smartphone.html', 1556517521, 2, 'y', ''),
(4, 0, 4, 'Kamera', 'newscategory_link', '{HOME_URL}/kategori/4/kamera.html', 1556517542, 3, 'y', ''),
(5, 0, 8, 'Software', 'newscategory_link', '{HOME_URL}/kategori/8/software.html', 1556517564, 4, 'y', ''),
(6, 0, 6, 'Internet', 'newscategory_link', '{HOME_URL}/kategori/6/internet.html', 1556517583, 5, 'y', ''),
(8, 0, 9, 'Hardware', 'newscategory_link', '{HOME_URL}/kategori/9/hardware.html', 1556517681, 6, 'y', ''),
(9, 0, 14, 'Berita', 'newscategory_link', '{HOME_URL}/kategori/14/berita.html', 1561919048, 8, 'y', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_options`
--

CREATE TABLE `memo_options` (
  `optionId` bigint(30) UNSIGNED NOT NULL,
  `optionName` varchar(100) NOT NULL,
  `optionValue` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_options`
--

INSERT INTO `memo_options` (`optionId`, `optionName`, `optionValue`) VALUES
(1, 'sitename', 'Framework Memo Indo Media'),
(2, 'sitekeywords', 'framework, ci, codeigniter,memo indo media'),
(3, 'sitedescription', 'Framework memo indo media dibuat dengan source code base dari CodeIgniter'),
(4, 'template', 'themekeren'),
(6, 'timezone', 'Asia/Jakarta'),
(7, 'phpsupport', '5.2.x'),
(8, 'mysqlsupport', '5.2.x'),
(9, 'robots', 'index,follow'),
(10, 'admindirectory', 'memo_admin'),
(11, 'socialmediaurl', 'a:7:{s:8:\"facebook\";s:38:\"https://www.facebook.com/memoindomedia\";s:7:\"twitter\";s:0:\"\";s:7:\"youtube\";s:0:\"\";s:9:\"instagram\";s:39:\"https://www.instagram.com/memoindomedia\";s:4:\"line\";s:0:\"\";s:8:\"whatsapp\";s:0:\"\";s:10:\"googleplay\";s:0:\"\";}'),
(12, 'ringkaspost', '197'),
(13, 'siteemail', 'info@memoindomedia.com'),
(14, 'favicon', ''),
(15, 'tagline', 'This is tagline'),
(16, 'emailsignature', '--\r\nBest Regards,\r\n\r\nAdmin'),
(17, 'emailheader', ''),
(18, 'sitephone', '082283884599'),
(19, 'defaultlang', 'id_ID'),
(20, 'smtp_password', 'TFJlbkV3R1BvOUt4Zlg3eWs1VlpOZz09'),
(21, 'smtp_host', 'myhostmail.com'),
(22, 'smtp_port', '465'),
(23, 'smtp_ssltype', 'ssl'),
(24, 'smtp_username', 'info@mail.com'),
(25, 'siteaddress', 'Jalan Cumi-cumi II No. 6 Kec. Marphoyan Damai - Pekanbaru'),
(26, 'httpsmode', 'no');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_rating`
--

CREATE TABLE `memo_rating` (
  `ratingId` int(10) UNSIGNED NOT NULL,
  `mId` int(10) UNSIGNED NOT NULL,
  `ratingRelasiId` int(10) UNSIGNED NOT NULL,
  `ratingType` varchar(20) NOT NULL,
  `ratingDate` int(11) UNSIGNED NOT NULL,
  `ratingDesc` text NOT NULL,
  `ratingValue` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_rating`
--

INSERT INTO `memo_rating` (`ratingId`, `mId`, `ratingRelasiId`, `ratingType`, `ratingDate`, `ratingDesc`, `ratingValue`) VALUES
(1, 1, 10, 'product', 1554391596, 'Kualitasnya tokcer deh, mantap', 60),
(2, 1, 6, 'product', 1554877052, 'tes', 70);

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_seo_halaman`
--

CREATE TABLE `memo_seo_halaman` (
  `seoId` bigint(20) UNSIGNED NOT NULL,
  `kontenId` bigint(20) UNSIGNED NOT NULL,
  `seoTypePage` varchar(25) NOT NULL,
  `seoTitle` text NOT NULL,
  `seoDesc` text NOT NULL,
  `seoKeyword` varchar(200) NOT NULL,
  `seoCanonical` varchar(150) NOT NULL,
  `seoRobots` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_seo_halaman`
--

INSERT INTO `memo_seo_halaman` (`seoId`, `kontenId`, `seoTypePage`, `seoTitle`, `seoDesc`, `seoKeyword`, `seoCanonical`, `seoRobots`) VALUES
(1, 4, 'post', 'Redmi Y3 Spesifikasi dan Harga', 'Setelah beberapa minggu ini Xiaomi mengeluarkan teaser tentang smartphone terbarunya, kini akhirnya perusahaan secara resmi telah meluncurkan smartphone seri Redmi terbaru miliknya yang bernama Redmi Y3', 'xiaomi,redmi,y3,redmi y3,smartphone,handphone,redmi 7', 'redmi-y3-spesifikasi-dan-harga', ''),
(2, 8, 'post', 'Indonesia Kedatangan Ponsel 3 Kamera Oleh Vivo Y17', 'Beberapa waktu lalu sempat ada desas-desus akan ada smartphone dengan 3 kamera keluaran Vivo akan hadir di Indonesia. Hal tersebut ternyata bukan desas-desus belaka, Vivo Y17 akhirnya resmi mulai dipasarkan di Indonesia.', 'kamera,vivo,vivo y17,ponsel,indonesia,kamera vivo,spesifikasi', 'indonesia-kedatangan-ponsel-3-kamera-oleh-vivo-y17', ''),
(3, 9, 'post', 'Brand Smartphone Ini Akan Diluncurkan Untuk Menyambut Teknologi 5G', 'Samsung tidak menyebutkan merek ponsel tersebut, namun terdapat isu bahwa smartphone ini disinyalir merupakan smartphone flagship seri Galaxy S berikutnya, yakni Galaxy S10.', 'samsung,vivo,motorola,oppo,lg,5g,jaringan 5g,teknologi 5g,smartphone,hp,4g', 'brand-smartphone-ini-akan-diluncurkan-untuk-menyambut-teknologi-5g', ''),
(4, 10, 'post', 'Asus ROG Berbasis Intel Core Generasi ke-9 dan GeForce GTX 1660 Ti Akan Hadir Di Indonesia', 'Asus ROG dengan Intel Core Generasi ke-9 dengan chip grafis NVIDIA GeForce GTX 1660 Ti dan seri lainnya dengan NVIDIA GeForce RTX 2070 akan dipasarkan di Indonesia dalam waktu dekat.', 'asus,asus rog,gaming,nvidia,GeForce GTX,laptop,Intel Core,9th Gen,Core i7,content creator,rog,Zephyrus,S GX502GW,M GU502GU,GeForce RTX', 'asus-rog-berbasis-intel-core-generasi-ke-9-dan-geforce-gtx-1660-ti-akan-hadir-di-indonesia', ''),
(5, 11, 'post', 'Blue Screen Pada PC Atau Laptop Anda? Berikut Cara Mengatasinya', 'Terkadang disaat Anda sedang mengerjakan banyak pekerjaan pada PC atau laptop kesayangan Anda tiba-tiba laptop Anda mati dan muncul layar yang berwarna biru dengan seketika.', 'blue screen,pc,laptop,komputer,mengatasi,solusi,cara mengatasi,biru,software,hardware,mengatasinya', 'blue-screen-pada-pc-atau-laptop-anda-berikut-cara-mengatasinya', ''),
(6, 12, 'post', 'Ternyata &quot;Video Call&quot; Orang Indonesia Lebih Lama Karena Sering Curhat Menurut Google', 'Aplikasi video call Duo dari Google yang sudah tersedia untuk para pengguna Android dan iOS di Indonesia sejak beberapa tahun lalu telah membuat banyak daftar saing aplikasi video call.', 'video call,google,curhat,orang indonesia,indonesia,duo,google duo,android', 'ternyata-video-call-orang-indonesia-lebih-lama-karena-sering-curhat-menurut-google', ''),
(7, 13, 'post', '8 Tipe USB yang Wajib untuk Kita Ketahui', 'USB merupakan sebuah konektor yang menghubungkan sebuah perangkat dengan perangkat lainnya. Pada zaman sekarang ini, USB merupakan sebuah benda yang sangatlah penting untuk kebutuhan transfer data antar perangkat.', 'usb,flashdisk,usb tipe a,usb tipe b,mini usb,micro usb,lightning,on-the-go,komputer,laptop,usb otg,jenis-jenis usb,teknologi', '8-tipe-usb-yang-wajib-untuk-kita-ketahui', ''),
(8, 14, 'post', 'Mengenal Fungsi Chipset di Smartphone dan Jenis-jenisnya', 'Pada smartphone, chipset tentunya hal yang wajib tersedia. Ponsel cerdas yang kamu gunakan untuk berbagai aktifitas seperti mendengarkan audio, video, kamera dan lainnya, disebabkan oleh adanya chipset.', 'chipset,smartphone,ponsel,arm,arsitektur arm,Qualcomm,Snapdragon,Fusion,Bionic,MediaTek,Samsung Eyxnos,HiSilicon Kirin,huawei,Spreadtrum,hardware,cpu,prosesor,processor,chip', 'mengenal-fungsi-chipset-di-smartphone-dan-jenis-jenisnya', ''),
(9, 15, 'post', 'Huawei, Xiaomi dan Oppo Mulai Luncurkan Smartphone 5G di Swiss', 'Swiss melalui perusahaan telekomunikasi Sunrise, akan membuat teknologi 5G menjadi semakin nyata.', 'oppo,smartphone,5g,xiaomi,huawei,ponsel,peluncuran,luncurkan,teknologi,internet', 'huawei-xiaomi-dan-oppo-rilis-smartphone-5g-di-swiss', ''),
(10, 16, 'post', 'Smartphone Huawei Tumbuh Melewati iPhone, Ancam Samsung', 'Para pemimpin pasar seperti Apple dan Samsung benar-benar merasakan sakitnya, tapi tidak dengan Huawei.', 'huawei,samsung,smartphone,apple,galaxy,ponsel,iphone', 'smartphone-huawei-tumbuh-melewati-iphone-ancam-samsung', ''),
(11, 17, 'post', 'Kamera Periskop, Persaingan Teknologi Kamera Baru Pada Smartphone', 'Teknologi periskop pada kamera smartphone adalah teknologi baru yang digunakan para vendor kamera untuk bisa melakukan perbesaran gambar optikal.', 'periskop,teknologi,teknologi periskop,smartphone,ponsel,oppo,kamera,kamera periskop,huawei,optik,objek', 'kamera-periskop-persaingan-teknologi-kamera-baru-pada-smartphone', ''),
(12, 18, 'post', 'Tips Agar Komputer Tidak Terserang Virus', 'Memiliki perangkat elektronik seperti komputer ataupun laptop, tentunya tidak lepas dari masalah serangan virus, ransomware, malware dan sejenisnya.', 'virus,malware,komputer,elektronik,ransomware,antivirus,microsoft,windows,worm', 'tips-agar-komputer-tidak-terserang-virus', ''),
(13, 19, 'post', 'Android Q Dapat Hidupkan Mode Gelap Otomatis', 'Salah satu sistem operasinya yakni Android Q akan memperkenalkan fitur uniknya yaitu mode gelap sistem lebar (system-wide dark mode).', 'android q,sistem operasi,mode gelap,dark mode,google,smartphone,mode,gelap,fitur', 'android-q-dapat-hidupkan-mode-gelap-otomatis', ''),
(14, 20, 'post', 'Dukung Jaringan 5G, Qualcomm Siapkan Chipset Snapdragon 865', 'Qualcomm akan mengeluarkan chipset terbaru andalannya yakni Snapdragon 865. Chipset ini diprediksi akan menjadi sebuah persaingan ponsel kelas atas pada 2020 mendatang.', 'snapdragon 865,qualcomm,smartphone,snapdragon,4g,5g,jaringan', 'dukung-jaringan-5g-qualcomm-siapkan-chipset-snapdragon-865', ''),
(15, 21, 'post', 'Begini Cara Merawat Power Bank Agar Awet Digunakan', 'Bagi kamu yang memiliki mobilitas yang tinggi, power bank adalah sebuah perangkat yang akan selalu menemani kamu untuk pada setiap aktifitas yang akan kamu jalani.', 'power,bank,power bank,smartphone,perangkat,awet,merawat', 'begini-cara-merawat-power-bank-agar-awet-digunakan', ''),
(16, 22, 'post', 'Cara Menghentikan Unduh Otomatis Foto dan Video pada WhatsApp', 'Tips kali ini ProDigital.web.id akan mengulas bagaimana cara menghentikan unduh otomatis foto dan video otomatis pada WhatsApp.', 'otomatis,whatsapp,video,gambar,menghentikan,foto', 'cara-menghentikan-unduh-otomatis-foto-dan-video-pada-whatsapp', ''),
(17, 23, 'post', 'Teknologi Komputer Terbaru dan Tercanggih yang Mempermudah Manusia', 'Berbicara mengenai penemuan dalam bidang komputer, dengan berjalannya waktu penemuan-penemuannya pun sangat unik dan tentunya sangat membantu manusia di dalam mengerjakan berbagai pekerjaannya', 'manusia,komputer,teknologi,tercanggih,canggih', 'teknologi-komputer-terbaru-dan-tercanggih-yang-mempermudah-manusia', ''),
(18, 24, 'post', 'Perbarui Segera WhatsApp Anda, Ada Serangan Spyware Israel', 'WhatsApp merupakan aplikasi android yang saat ini sangat populer telah menghimbau para penggunanya untuk memperbarui aplikasinya ke versi yang terbaru', 'whatsapp,pengguna,aplikasi,israel,smartphone', 'perbarui-segera-whatsapp-anda-ada-serangan-spyware-israel', ''),
(19, 25, 'post', 'Dasar Keamanan Facebook, Netizen Wajib Tahu', 'ProDigital.web.id akan mengulas tentang dasar-dasar keamanan pada platform sosial media Facebook.', 'facebook,pengguna,fitur,netizen,keamanan,prodigital.web.id,prodigital,sosial media,sosial,media', 'dasar-keamanan-facebook-netizen-wajib-tahu', ''),
(20, 26, 'post', 'Peretas Masih Bisa Akses WhatsApp yang Belum Update, Pengguna Harap Berhati-hati', 'Sejumlah pengguna yang gagal memperbarui WhatsApp khawatir peretas bisa mendapatkan informasi pribadinya, termasuk pesan dan lokasi data.', 'whatsapp,perangkat,pengguna,wandera,keamanan', 'peretas-masih-bisa-akses-whatsapp-yang-belum-update-pengguna-harap-berhati-hati', ''),
(21, 27, 'post', 'Berikut Cara Menghilangkan Virus Shortcut Pada Komputer Atau Laptop', 'Perangkat elektronik saat sekarang ini seperti laptop, komputer ataupun smartphone tidak terpisah pada kehidupan kita sehari-hari.', 'komputer,virus,anti-virus,shortcut,laptop,menghilangkan', 'berikut-cara-menghilangkan-virus-shortcut-pada-komputer-atau-laptop', ''),
(22, 28, 'post', 'Google Akan Cabut Lisensi Android Pada Smartphone Huawei', 'Perang dagang antara Amerika Serikat dan China terus berbuntut panjang. Setelah dinyatakan masuk dalam daftar hitam oleh pemerintah AS', 'huawei,google,android,pemerintah,as,amerika,dagang', 'google-akan-cabut-lisensi-android-pada-smartphone-huawei', ''),
(23, 29, 'post', '3 Fitur Whatsapp Yang Mungkin Belum Diketahui Banyak Orang', 'WhatsApp adalah sarana komunikasi online yang saat ini banyak digunakan oleh orang di seluruh dunia.', 'whatsapp,pengguna,fitur,banyak', '3-fitur-whatsapp-yang-mungkin-belum-diketahui-banyak-orang', ''),
(24, 5, 'post', 'Yang Harus Dilakukan Saat Smartphone Anda Terendam Air', 'Menyebalkan memang jika smartphone kesayangan kita kemasukan air. Terkadang terjadi pada saat-saat yang tidak terduga-duga, terlebih lagi dengan kecerobohan kita saat sedang memegangnya.', 'smartphone,air,terendam,harus,dilakukan,apa,yang', 'yang-harus-dilakukan-saat-smartphone-anda-terendam-air', ''),
(25, 30, 'post', 'Apa Itu VPN? dan Cara Kerja VPN', 'Pro Digital kali ini akan membahas secara lengkap apa itu Virtual Private Network atau bisa disingkat dengan VPN.', 'vpn,jaringan,internet,virtual,private,network,server,koneksi,data', 'apa-itu-vpn-dan-cara-kerja-vpn', ''),
(26, 31, 'post', 'Xiaomi, Oppo, Vivo Sudah Jajal OS Pengganti Android Buatan Huawei', 'Huawei yang kehilangan lisensi Android, mengembangkan HongMeng sebagai sistem operasi pengganti.', 'hongmeng,android,huawei,xiaomi,oppo,vivo', 'xiaomi-oppo-vivo-sudah-jajal-os-pengganti-android-buatan-huawei', ''),
(27, 32, 'post', 'Berikut Penyebab Baterai Handphone Cepat Habis dan Cara Mengatasinya', 'Baterai merupakan sumber daya utama bagi banyak perangkat portabel seperti handphone (HP). Agar dapat digunakan dalam jangka waktu yang lama', 'baterai,cara,mengatasinya,penyebab,hp,handphone,Penyebab', 'berikut-penyebab-baterai-handphone-cepat-habis-dan-cara-mengatasinya', ''),
(28, 33, 'post', 'Pembatasan Hak Akses Internet di Indonesia, SAFEnet Desak Pemerintah Menghentikan', 'Southeast Freedom of Expression Network (SAFEnet) menyoroti pembatasan akses informasi internet di Indonesia.', 'safenet,internet,pemerintah,indonesia,pembatasan,akses', 'pembatasan-hak-akses-internet-di-indonesia-safenet-desak-pemerintah-menghentikan', ''),
(29, 34, 'post', 'Presiden AS Donald Trump Izinkan Huawei Kembali Berbisnis dengan Perusahaan AS', 'Gempuran blacklist pemerintah Amerika Serikat kepada perusahaan Cina, termasuk Huawei, sepertinya bakal berakhir sebentar lagi.', 'Donald Trump,donald,trumb,as,amerika,huawei,cina,perusahaan,bisnis', 'presiden-as-donald-trump-izinkan-huawei-kembali-berbisnis-dengan-perusahaan-as', ''),
(30, 35, 'post', 'Mate 20 X, Ponsel 5G Pertama Huawei Meluncur 26 Juli?', 'Nasib Huawei dengan mitra bisnisnnya di AS memang masih terkatung-katung. Tapi hal itu tidak menyurutkan langkah vendor ponsel China itu untuk meluncurkan ponsel 5G', 'huawei,ponsel,mate 20 x,smartphone', 'mate-20-x-ponsel-5g-pertama-huawei-meluncur-26-juli', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_slider`
--

CREATE TABLE `memo_slider` (
  `slideId` int(11) UNSIGNED NOT NULL,
  `slideJudul` varchar(150) NOT NULL,
  `slideUrlTujuan` varchar(255) NOT NULL,
  `slideDeskripsi` text NOT NULL,
  `slideType` varchar(20) NOT NULL,
  `slideImg` text NOT NULL,
  `slideDirFile` varchar(25) NOT NULL,
  `slideAnimate` varchar(30) NOT NULL,
  `slideOverlay` enum('y','n') NOT NULL,
  `slideTerbit` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_stats_useronline`
--

CREATE TABLE `memo_stats_useronline` (
  `ID` bigint(25) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL,
  `agent` varchar(200) NOT NULL,
  `platform` varchar(20) NOT NULL,
  `referred` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_stats_useronline`
--

INSERT INTO `memo_stats_useronline` (`ID`, `ip`, `timestamp`, `tgl`, `jam`, `agent`, `platform`, `referred`) VALUES
(92, '127.0.0.1', '1564921230', '2019-08-04', '19:20:30', 'Firefox', 'Windows 10', 'http://memo_ecommerce/product/detail/2/kaos-dakwah-faza-the-power-of-prayer.html');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_stats_visitor`
--

CREATE TABLE `memo_stats_visitor` (
  `ID_visitor` bigint(25) NOT NULL,
  `tgl_visitor` date NOT NULL,
  `jam_visitor` time NOT NULL,
  `agent` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `hits` int(11) NOT NULL,
  `referred` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_testimonial`
--

CREATE TABLE `memo_testimonial` (
  `testiId` int(11) UNSIGNED NOT NULL,
  `testiNama` varchar(100) NOT NULL,
  `testiPekerjaan` varchar(100) NOT NULL,
  `testiKonten` text NOT NULL,
  `testiDir` varchar(25) NOT NULL,
  `testiImg` varchar(255) NOT NULL,
  `testiStatus` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_url_list`
--

CREATE TABLE `memo_url_list` (
  `urlId` int(10) UNSIGNED NOT NULL,
  `urlName` varchar(255) NOT NULL,
  `urlUrl` text NOT NULL,
  `urlRel` enum('nofollow','dofollow') NOT NULL,
  `urlActive` enum('y','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_url_list`
--

INSERT INTO `memo_url_list` (`urlId`, `urlName`, `urlUrl`, `urlRel`, `urlActive`) VALUES
(1, 'Berita', '{HOME_URL}/post.html', 'dofollow', 'y'),
(2, 'Tetang Kami', '{HOME_URL}/tentang-kami.html', 'dofollow', 'y'),
(3, 'Login', '{HOME_URL}/login.html', 'dofollow', 'y'),
(4, 'Feed / RSS', '{HOME_URL}/rss.xml', 'dofollow', 'y'),
(5, 'Galeri Foto', '{HOME_URL}/galeri.html', 'dofollow', 'y'),
(6, 'Kontak', '{HOME_URL}/kontak.html', 'dofollow', 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_users`
--

CREATE TABLE `memo_users` (
  `userId` int(11) UNSIGNED NOT NULL,
  `userLogin` varchar(65) NOT NULL,
  `userPass` varchar(65) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userTlp` varchar(25) NOT NULL,
  `userDisplayName` varchar(250) NOT NULL,
  `levelId` int(10) UNSIGNED NOT NULL,
  `userBlokir` enum('y','n') NOT NULL,
  `userDelete` int(11) UNSIGNED NOT NULL,
  `userLastLogin` int(10) UNSIGNED NOT NULL,
  `userActivationKey` varchar(255) NOT NULL,
  `userRegistered` int(11) UNSIGNED NOT NULL,
  `userSession` varchar(255) NOT NULL,
  `userCheckPoint` longtext NOT NULL,
  `userDir` varchar(20) NOT NULL,
  `userPic` text NOT NULL,
  `userOnlineStatus` enum('online','offline','busy') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_users`
--

INSERT INTO `memo_users` (`userId`, `userLogin`, `userPass`, `userEmail`, `userTlp`, `userDisplayName`, `levelId`, `userBlokir`, `userDelete`, `userLastLogin`, `userActivationKey`, `userRegistered`, `userSession`, `userCheckPoint`, `userDir`, `userPic`, `userOnlineStatus`) VALUES
(1, 'superadmin', '123ddab3392adb83b5d99faca5f4404c64841aa6', 'afrioni@afrioni.web.id', '081276540054', 'Afrioni', 1, 'n', 0, 1579608949, '', 1358259589, 'g87h6ns1npmblhvtdbvrndb42c81gahj', '', '', '', 'offline'),
(2, 'demo', '123ddab3392adb83b5d99faca5f4404c64841aa6', 'demo@demo.com', '', 'Demo Administrator', 2, 'n', 0, 1565019560, '', 1565017383, 'uhugeprv49jpbfkonhp9bc3l52', '', '', '', 'online');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_users_level`
--

CREATE TABLE `memo_users_level` (
  `levelId` int(10) UNSIGNED NOT NULL,
  `levelName` varchar(255) NOT NULL,
  `levelActive` enum('y','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_users_level`
--

INSERT INTO `memo_users_level` (`levelId`, `levelName`, `levelActive`) VALUES
(1, 'Super Admin', 'y'),
(2, 'Admin', 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_users_menu`
--

CREATE TABLE `memo_users_menu` (
  `menuId` int(10) UNSIGNED NOT NULL,
  `menuParentId` int(10) UNSIGNED NOT NULL,
  `menuName` varchar(255) NOT NULL,
  `menuAccess` text NOT NULL,
  `menuAddedDate` int(11) UNSIGNED NOT NULL,
  `menuSort` mediumint(5) UNSIGNED NOT NULL,
  `menuIcon` varchar(100) NOT NULL,
  `menuAttrClass` varchar(100) NOT NULL,
  `menuActive` enum('y','n') NOT NULL,
  `menuView` enum('y','n') NOT NULL,
  `menuAdd` enum('y','n') NOT NULL,
  `menuEdit` enum('y','n') NOT NULL,
  `menuDelete` enum('y','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_users_menu`
--

INSERT INTO `memo_users_menu` (`menuId`, `menuParentId`, `menuName`, `menuAccess`, `menuAddedDate`, `menuSort`, `menuIcon`, `menuAttrClass`, `menuActive`, `menuView`, `menuAdd`, `menuEdit`, `menuDelete`) VALUES
(1, 0, 'Pengaturan Pengembang', '', 1452867589, 4, 'icon-briefcase', '', 'y', 'y', 'y', 'y', 'y'),
(2, 1, 'Menu Admin', '', 1453820948, 1, '', '', 'y', 'y', 'y', 'y', 'y'),
(3, 2, 'Menu Admin Master ', 'a:1:{s:10:\"admin_link\";s:17:\"menu_admin_master\";}', 1452867589, 1, '', '', 'y', 'y', 'y', 'y', 'y'),
(4, 2, 'Menu Admin Privilage', 'a:1:{s:10:\"admin_link\";s:20:\"menu_admin_privilage\";}', 1577632987, 2, '', '', 'y', 'y', 'y', 'y', 'y'),
(5, 0, 'Alat', '', 1577728905, 3, 'icon-hammer-wrench', '', 'y', 'y', 'y', 'y', 'y'),
(6, 5, 'Info Sistem', 'a:1:{s:10:\"admin_link\";s:11:\"info_sistem\";}', 1577729211, 1, '', '', 'y', 'y', 'y', 'y', 'y'),
(7, 0, 'Pengaturan', '', 1577892258, 2, 'icon-equalizer2', '', 'y', 'y', 'n', 'n', 'n'),
(8, 7, 'Atur Web', 'a:1:{s:10:\"admin_link\";s:8:\"atur_web\";}', 1577892344, 1, '', '', 'y', 'y', 'n', 'y', 'n'),
(9, 0, 'Pengguna', '', 1578138421, 1, 'icon-users', '', 'y', 'y', 'n', 'n', 'n'),
(10, 9, 'Kelola Pengguna', 'a:1:{s:10:\"admin_link\";s:12:\"manage_users\";}', 1578138586, 1, '', '', 'y', 'y', 'y', 'y', 'y'),
(11, 9, 'Grup Pengguna', 'a:1:{s:10:\"admin_link\";s:11:\"users_group\";}', 1579535259, 2, '', '', 'y', 'y', 'y', 'y', 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memo_users_menu_access`
--

CREATE TABLE `memo_users_menu_access` (
  `lmnId` int(10) UNSIGNED NOT NULL,
  `levelId` int(10) UNSIGNED NOT NULL,
  `menuId` int(10) UNSIGNED NOT NULL,
  `lmnView` enum('y','n') NOT NULL,
  `lmnAdd` enum('y','n') NOT NULL,
  `lmnEdit` enum('y','n') NOT NULL,
  `lmnDelete` enum('y','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `memo_users_menu_access`
--

INSERT INTO `memo_users_menu_access` (`lmnId`, `levelId`, `menuId`, `lmnView`, `lmnAdd`, `lmnEdit`, `lmnDelete`) VALUES
(1, 1, 1, 'y', 'y', 'y', 'y'),
(2, 1, 2, 'y', 'y', 'y', 'y'),
(3, 1, 3, 'y', 'y', 'y', 'y'),
(4, 1, 4, 'y', 'y', 'y', 'y'),
(5, 1, 5, 'y', 'y', 'y', 'y'),
(6, 1, 6, 'y', 'y', 'y', 'y'),
(7, 1, 7, 'y', 'n', 'n', 'n'),
(8, 1, 8, 'y', 'n', 'y', 'n'),
(9, 1, 9, 'y', 'n', 'n', 'n'),
(10, 1, 10, 'y', 'y', 'y', 'y'),
(11, 1, 11, 'y', 'y', 'y', 'y');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `memo_ads`
--
ALTER TABLE `memo_ads`
  ADD PRIMARY KEY (`adsId`),
  ADD KEY `adposId` (`adposId`);

--
-- Indeks untuk tabel `memo_ads_posisi`
--
ALTER TABLE `memo_ads_posisi`
  ADD PRIMARY KEY (`adposId`);

--
-- Indeks untuk tabel `memo_android_device`
--
ALTER TABLE `memo_android_device`
  ADD PRIMARY KEY (`devId`);

--
-- Indeks untuk tabel `memo_badge`
--
ALTER TABLE `memo_badge`
  ADD PRIMARY KEY (`badgeId`);

--
-- Indeks untuk tabel `memo_badge_relasi`
--
ALTER TABLE `memo_badge_relasi`
  ADD PRIMARY KEY (`bdgrelId`),
  ADD KEY `badgeId` (`badgeId`),
  ADD KEY `relationId` (`relationId`);

--
-- Indeks untuk tabel `memo_cron_list`
--
ALTER TABLE `memo_cron_list`
  ADD PRIMARY KEY (`cronId`);

--
-- Indeks untuk tabel `memo_dynamic_translations`
--
ALTER TABLE `memo_dynamic_translations`
  ADD PRIMARY KEY (`dtId`),
  ADD KEY `dtRelatedId` (`dtRelatedId`);

--
-- Indeks untuk tabel `memo_email_queue`
--
ALTER TABLE `memo_email_queue`
  ADD PRIMARY KEY (`emailId`);

--
-- Indeks untuk tabel `memo_email_template`
--
ALTER TABLE `memo_email_template`
  ADD PRIMARY KEY (`tId`);

--
-- Indeks untuk tabel `memo_galeri_pic`
--
ALTER TABLE `memo_galeri_pic`
  ADD PRIMARY KEY (`galpicId`),
  ADD KEY `kontenId` (`kontenId`);

--
-- Indeks untuk tabel `memo_kategori`
--
ALTER TABLE `memo_kategori`
  ADD PRIMARY KEY (`katId`);

--
-- Indeks untuk tabel `memo_kategori_relasi`
--
ALTER TABLE `memo_kategori_relasi`
  ADD PRIMARY KEY (`krId`),
  ADD KEY `katId` (`katId`),
  ADD KEY `kontenId` (`kontenId`);

--
-- Indeks untuk tabel `memo_komentar`
--
ALTER TABLE `memo_komentar`
  ADD PRIMARY KEY (`komenId`),
  ADD KEY `kontenId` (`kontenId`),
  ADD KEY `komenId` (`komenId`,`komenIdInduk`);

--
-- Indeks untuk tabel `memo_kontak`
--
ALTER TABLE `memo_kontak`
  ADD PRIMARY KEY (`kontakId`);

--
-- Indeks untuk tabel `memo_konten`
--
ALTER TABLE `memo_konten`
  ADD PRIMARY KEY (`kontenId`),
  ADD KEY `kontenTimestamp` (`kontenTimestamp`);

--
-- Indeks untuk tabel `memo_menu_website`
--
ALTER TABLE `memo_menu_website`
  ADD PRIMARY KEY (`menuId`),
  ADD KEY `menuId` (`menuId`,`menuParentId`),
  ADD KEY `menuRelationshipId` (`menuRelationshipId`);

--
-- Indeks untuk tabel `memo_options`
--
ALTER TABLE `memo_options`
  ADD PRIMARY KEY (`optionId`),
  ADD KEY `option_name` (`optionName`);

--
-- Indeks untuk tabel `memo_rating`
--
ALTER TABLE `memo_rating`
  ADD PRIMARY KEY (`ratingId`);

--
-- Indeks untuk tabel `memo_seo_halaman`
--
ALTER TABLE `memo_seo_halaman`
  ADD PRIMARY KEY (`seoId`),
  ADD KEY `kontenId` (`kontenId`);

--
-- Indeks untuk tabel `memo_slider`
--
ALTER TABLE `memo_slider`
  ADD PRIMARY KEY (`slideId`);

--
-- Indeks untuk tabel `memo_stats_useronline`
--
ALTER TABLE `memo_stats_useronline`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `memo_stats_visitor`
--
ALTER TABLE `memo_stats_visitor`
  ADD PRIMARY KEY (`ID_visitor`);

--
-- Indeks untuk tabel `memo_testimonial`
--
ALTER TABLE `memo_testimonial`
  ADD PRIMARY KEY (`testiId`);

--
-- Indeks untuk tabel `memo_url_list`
--
ALTER TABLE `memo_url_list`
  ADD PRIMARY KEY (`urlId`),
  ADD KEY `urlId` (`urlId`);

--
-- Indeks untuk tabel `memo_users`
--
ALTER TABLE `memo_users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `ID` (`userId`),
  ADD KEY `levelId` (`levelId`);

--
-- Indeks untuk tabel `memo_users_level`
--
ALTER TABLE `memo_users_level`
  ADD PRIMARY KEY (`levelId`);

--
-- Indeks untuk tabel `memo_users_menu`
--
ALTER TABLE `memo_users_menu`
  ADD PRIMARY KEY (`menuId`),
  ADD KEY `menuId` (`menuId`,`menuParentId`);

--
-- Indeks untuk tabel `memo_users_menu_access`
--
ALTER TABLE `memo_users_menu_access`
  ADD PRIMARY KEY (`lmnId`),
  ADD KEY `levelId` (`levelId`),
  ADD KEY `menuId` (`menuId`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `memo_ads`
--
ALTER TABLE `memo_ads`
  MODIFY `adsId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `memo_ads_posisi`
--
ALTER TABLE `memo_ads_posisi`
  MODIFY `adposId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `memo_android_device`
--
ALTER TABLE `memo_android_device`
  MODIFY `devId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `memo_badge`
--
ALTER TABLE `memo_badge`
  MODIFY `badgeId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `memo_cron_list`
--
ALTER TABLE `memo_cron_list`
  MODIFY `cronId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `memo_dynamic_translations`
--
ALTER TABLE `memo_dynamic_translations`
  MODIFY `dtId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `memo_email_template`
--
ALTER TABLE `memo_email_template`
  MODIFY `tId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `memo_galeri_pic`
--
ALTER TABLE `memo_galeri_pic`
  MODIFY `galpicId` bigint(25) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `memo_kategori`
--
ALTER TABLE `memo_kategori`
  MODIFY `katId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `memo_kategori_relasi`
--
ALTER TABLE `memo_kategori_relasi`
  MODIFY `krId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `memo_komentar`
--
ALTER TABLE `memo_komentar`
  MODIFY `komenId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `memo_kontak`
--
ALTER TABLE `memo_kontak`
  MODIFY `kontakId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `memo_konten`
--
ALTER TABLE `memo_konten`
  MODIFY `kontenId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `memo_menu_website`
--
ALTER TABLE `memo_menu_website`
  MODIFY `menuId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `memo_options`
--
ALTER TABLE `memo_options`
  MODIFY `optionId` bigint(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `memo_seo_halaman`
--
ALTER TABLE `memo_seo_halaman`
  MODIFY `seoId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `memo_url_list`
--
ALTER TABLE `memo_url_list`
  MODIFY `urlId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `memo_users_level`
--
ALTER TABLE `memo_users_level`
  MODIFY `levelId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `memo_users_menu`
--
ALTER TABLE `memo_users_menu`
  MODIFY `menuId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `memo_users_menu_access`
--
ALTER TABLE `memo_users_menu_access`
  MODIFY `lmnId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
