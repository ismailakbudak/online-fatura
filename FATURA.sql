-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 14 Mar 2014, 10:55:02
-- Sunucu sürümü: 5.5.31
-- PHP Sürümü: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `fatura`
--
CREATE DATABASE IF NOT EXISTS `fatura` DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci;
USE `fatura`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adres`
--

CREATE TABLE IF NOT EXISTS `adres` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `adres` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `baslik` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=52 ;

--
-- Tablo döküm verisi `adres`
--

INSERT INTO `adres` (`pk`, `adres`, `baslik`, `aciklama`) VALUES
(51, 'sadasd as ads ', 'İlk Adres', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adres_musteri`
--

CREATE TABLE IF NOT EXISTS `adres_musteri` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `adres_fk` int(11) NOT NULL,
  `musteri_fk` int(11) NOT NULL,
  PRIMARY KEY (`pk`),
  KEY `adres_fk` (`adres_fk`),
  KEY `musteri_fk` (`musteri_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin5 AUTO_INCREMENT=51 ;

--
-- Tablo döküm verisi `adres_musteri`
--

INSERT INTO `adres_musteri` (`pk`, `adres_fk`, `musteri_fk`) VALUES
(50, 51, 63);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `element`
--

CREATE TABLE IF NOT EXISTS `element` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `isim` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `database_name` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=19 ;

--
-- Tablo döküm verisi `element`
--

INSERT INTO `element` (`pk`, `isim`, `database_name`) VALUES
(1, 'Ünvan', 'musteri_unvan'),
(2, 'Adres', 'adres'),
(5, 'Fatura Tarihi', 'fatura_tarih'),
(6, 'Fatura Basım Tarihi', 'fatura_basim_tarihi'),
(7, 'Fiili Sevk Tarihi', 'fiili_sevk_tarihi'),
(8, 'Vergi Dairesi', 'vergi_daire_no'),
(9, 'Vergi No', 'vergi_no'),
(10, 'Ürün Cinsi', 'urun_adi'),
(11, 'Ürün Birimi', 'miktar_birim'),
(12, 'Ürün Miktarı', 'miktar'),
(13, 'Birim Fiyatı', 'birim_fiyati'),
(14, 'Ürün Tutarı', 'tutar'),
(15, 'KDV''siz Toplam Tutar', 'kdvsiz_toplam_tutar'),
(16, 'KDV Tutarı', 'kdv_tutar'),
(17, 'Toplam Tutar', 'toplam_tutar'),
(18, 'Ürünün KDV Oranı', 'urun_kodu');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_detay`
--

CREATE TABLE IF NOT EXISTS `fatura_detay` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `musteri_fk` int(11) NOT NULL,
  `odeme_turu` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `fatura_tarih` date DEFAULT NULL,
  `aciklama` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `acik` int(1) NOT NULL,
  `fatura_basim_tarihi` time DEFAULT NULL,
  `kdv_tutar` float NOT NULL,
  `toplam_tutar` float NOT NULL,
  `kdvsiz_toplam_tutar` float NOT NULL,
  `vergi_daire_no` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `vergi_no` int(11) NOT NULL,
  `toplamdan_iskonto_tutari` float NOT NULL,
  `fiili_sevk_tarihi` date DEFAULT NULL,
  `iskontadan_onceki_toplam` float NOT NULL,
  `fatura_no` int(11) DEFAULT NULL,
  `sirket_fk` int(11) NOT NULL,
  PRIMARY KEY (`pk`),
  KEY `musteri_fk` (`musteri_fk`),
  KEY `sirket_fk` (`sirket_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=77 ;

--
-- Tablo döküm verisi `fatura_detay`
--

INSERT INTO `fatura_detay` (`pk`, `musteri_fk`, `odeme_turu`, `fatura_tarih`, `aciklama`, `acik`, `fatura_basim_tarihi`, `kdv_tutar`, `toplam_tutar`, `kdvsiz_toplam_tutar`, `vergi_daire_no`, `vergi_no`, `toplamdan_iskonto_tutari`, `fiili_sevk_tarihi`, `iskontadan_onceki_toplam`, `fatura_no`, `sirket_fk`) VALUES
(75, 63, '  PEŞIN', '2013-07-01', '', 1, '10:33:36', 18, 117.89, 99.89, 'başkent', 20202022, 0.11, '2013-07-01', 118, 1, 7),
(76, 63, '  PEŞIN', '2013-11-06', '', 1, '03:37:43', 120.96, 680.96, 560, 'başkent', 20202022, 112, '2013-11-06', 792.96, 0, 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_irsaliye`
--

CREATE TABLE IF NOT EXISTS `fatura_irsaliye` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `irsaliye_detay_fk` int(11) DEFAULT NULL,
  `fatura_urun_fk` int(11) DEFAULT NULL,
  `miktar` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `irsaliye_detay_fk` (`irsaliye_detay_fk`),
  KEY `fatura_urun_fk` (`fatura_urun_fk`),
  KEY `irsaliye_detay_fk_2` (`irsaliye_detay_fk`),
  KEY `fatura_urun_fk_2` (`fatura_urun_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_normal`
--

CREATE TABLE IF NOT EXISTS `fatura_normal` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `fatura_detay_fk` int(11) DEFAULT NULL,
  `irsaliye_tarih` date DEFAULT NULL,
  `irsaliye_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `fatura_detay_fk` (`fatura_detay_fk`),
  KEY `fatura_detay_fk_2` (`fatura_detay_fk`),
  KEY `irsaliye_tarih` (`irsaliye_tarih`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_position`
--

CREATE TABLE IF NOT EXISTS `fatura_position` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_fk` int(11) DEFAULT NULL,
  `fatura_tur_fk` int(11) DEFAULT NULL,
  `dizayn_adi` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `width` float NOT NULL,
  `height` float NOT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `dizayn_adi` (`dizayn_adi`),
  KEY `sirket_fk` (`sirket_fk`),
  KEY `fatura_tur_fk` (`fatura_tur_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=31 ;

--
-- Tablo döküm verisi `fatura_position`
--

INSERT INTO `fatura_position` (`pk`, `sirket_fk`, `fatura_tur_fk`, `dizayn_adi`, `width`, `height`) VALUES
(26, 7, 2, 'İsmail 345', 500, 500),
(27, 7, 1, 'My', 633, 234),
(28, 7, 2, 'Test', 633, 234),
(30, 7, 1, 'Myy', 633, 234);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_position_xy`
--

CREATE TABLE IF NOT EXISTS `fatura_position_xy` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `fatura_position_fk` int(11) NOT NULL,
  `element_fk` int(11) NOT NULL,
  `left` double NOT NULL,
  `top` double NOT NULL,
  PRIMARY KEY (`pk`),
  KEY `fatura_position_fk` (`fatura_position_fk`),
  KEY `element_fk` (`element_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=130 ;

--
-- Tablo döküm verisi `fatura_position_xy`
--

INSERT INTO `fatura_position_xy` (`pk`, `fatura_position_fk`, `element_fk`, `left`, `top`) VALUES
(109, 26, 9, 321, 16),
(110, 26, 10, 321, 102),
(111, 27, 12, 13, 13),
(112, 27, 11, 454, 13),
(113, 27, 5, 199, 80),
(114, 27, 8, 454, 217),
(115, 27, 2, 454, 156),
(116, 27, 1, 13, 217),
(117, 28, 17, 416, 155),
(118, 28, 11, 13, 159),
(119, 28, 16, 219, 74),
(120, 28, 14, 13, 75),
(121, 28, 13, 416, 75),
(122, 28, 2, 219, 119),
(123, 28, 1, 454, 18),
(124, 30, 1, 13, 217),
(125, 30, 2, 454, 156),
(126, 30, 8, 454, 217),
(127, 30, 5, 13, 71),
(128, 30, 11, 454, 13),
(129, 30, 12, 13, 13);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_tur`
--

CREATE TABLE IF NOT EXISTS `fatura_tur` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `tur_adi` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `fatura_tur`
--

INSERT INTO `fatura_tur` (`pk`, `tur_adi`) VALUES
(1, 'İrsaliye Faturası'),
(2, 'İrsaliyeli Fatura'),
(3, 'İrsaliyesiz Fatura');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_urun`
--

CREATE TABLE IF NOT EXISTS `fatura_urun` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `fatura_detay_fk` int(11) NOT NULL,
  `urun_kodu` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `urun_adi` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `miktar` int(11) NOT NULL,
  `birim_fiyati` float NOT NULL,
  `miktar_birim` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `iskonto_tutari` float NOT NULL,
  `tutar` float NOT NULL,
  PRIMARY KEY (`pk`),
  KEY `fatura_detay_fk` (`fatura_detay_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=472 ;

--
-- Tablo döküm verisi `fatura_urun`
--

INSERT INTO `fatura_urun` (`pk`, `fatura_detay_fk`, `urun_kodu`, `urun_adi`, `miktar`, `birim_fiyati`, `miktar_birim`, `iskonto_tutari`, `tutar`) VALUES
(469, 75, '0001', ' MASA ', 10, 10, '10', 0.1111, 117),
(470, 76, '0001', ' MASA ', 6, 56, '56', 56, 340),
(471, 76, '0001', ' MASA ', 6, 56, '56', 56, 340);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `irsaliye_detay`
--

CREATE TABLE IF NOT EXISTS `irsaliye_detay` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `fatura_detay_fk` int(11) NOT NULL,
  `irsaliye_tarih` date DEFAULT NULL,
  `duzenleme_saat` time DEFAULT NULL,
  `fiili_sevk_tarih` date DEFAULT NULL,
  `aciklama` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `fatura_detay_fk` (`fatura_detay_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_adi` varchar(45) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_sifre` varchar(45) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_yetki_fk` int(11) NOT NULL,
  PRIMARY KEY (`pk`),
  KEY `ad` (`ad`),
  KEY `kullanici_yetki_fk` (`kullanici_yetki_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=22 ;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`pk`, `ad`, `soyad`, `kullanici_adi`, `kullanici_sifre`, `kullanici_yetki_fk`) VALUES
(16, 'ISMAIL2', 'ISMAIL2', 'ismail', 'c4ca4238a0b923820dcc509a6f75849b', 10),
(19, 'EREN MUSTAFA ', 'KESDI', 'eren', '1fff500ae0735d21632d0cf3fb628f77', 10),
(20, 'v', 'vdf', 'dv', '73656372657470617373776F7264', 10),
(21, 'v', 'vdf', 'dv', '73656372657470617373776F7264', 10);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_sirket`
--

CREATE TABLE IF NOT EXISTS `kullanici_sirket` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_fk` int(11) DEFAULT NULL,
  `sirket_fk` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk`),
  KEY `kullanici_fk` (`kullanici_fk`),
  KEY `sirket_fk` (`sirket_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=17 ;

--
-- Tablo döküm verisi `kullanici_sirket`
--

INSERT INTO `kullanici_sirket` (`pk`, `kullanici_fk`, `sirket_fk`, `date`) VALUES
(11, 16, 7, '2013-06-28 12:34:04'),
(15, 19, 9, '2013-07-23 14:42:09'),
(16, 19, 7, '2013-07-23 14:43:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_yetki`
--

CREATE TABLE IF NOT EXISTS `kullanici_yetki` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `yetkisi` varchar(45) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=12 ;

--
-- Tablo döküm verisi `kullanici_yetki`
--

INSERT INTO `kullanici_yetki` (`pk`, `yetkisi`) VALUES
(10, 'Yönetici'),
(11, 'Kullanıcı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri_detay`
--

CREATE TABLE IF NOT EXISTS `musteri_detay` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_fk` int(11) NOT NULL,
  `musteri_tabela` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `musteri_unvan` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `vergi_dairesi` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `vergi_no` int(11) NOT NULL,
  `web` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `eposta` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `aciklama` varchar(150) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `sirket_fk` (`sirket_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=64 ;

--
-- Tablo döküm verisi `musteri_detay`
--

INSERT INTO `musteri_detay` (`pk`, `sirket_fk`, `musteri_tabela`, `musteri_unvan`, `vergi_dairesi`, `vergi_no`, `web`, `eposta`, `aciklama`) VALUES
(63, 7, 'elektronikçiler', 'portakal ltd', 'başkent', 20202022, '', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri_kod`
--

CREATE TABLE IF NOT EXISTS `musteri_kod` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_fk` int(11) NOT NULL,
  `kod` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `extra` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `sirket_fk` (`sirket_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=13 ;

--
-- Tablo döküm verisi `musteri_kod`
--

INSERT INTO `musteri_kod` (`pk`, `sirket_fk`, `kod`, `aciklama`, `extra`) VALUES
(9, 7, 'elektronikçiler', 'elektronik malzeme', ''),
(10, 7, 'deneme', 'deneme', ''),
(11, 7, 'asdasd', 'sadasd', ''),
(12, 7, 'DD', 'Denizli', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `odeme_detay`
--

CREATE TABLE IF NOT EXISTS `odeme_detay` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `odeme_tur` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=25 ;

--
-- Tablo döküm verisi `odeme_detay`
--

INSERT INTO `odeme_detay` (`pk`, `odeme_tur`) VALUES
(24, '  PEŞIN');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sirket_ayar`
--

CREATE TABLE IF NOT EXISTS `sirket_ayar` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_fk` int(11) NOT NULL,
  `kurus_ayar` int(8) DEFAULT '2',
  `extra` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `sirket_fk` (`sirket_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `sirket_ayar`
--

INSERT INTO `sirket_ayar` (`pk`, `sirket_fk`, `kurus_ayar`, `extra`) VALUES
(2, 15, 2, 0),
(3, 17, 2, 0),
(4, 7, 5, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sirket_detay`
--

CREATE TABLE IF NOT EXISTS `sirket_detay` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_isim` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `vergi_dairesi` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `vergi_no` int(11) NOT NULL,
  `web` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `eposta` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `aciklama` varchar(150) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `sirket_isim` (`sirket_isim`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=18 ;

--
-- Tablo döküm verisi `sirket_detay`
--

INSERT INTO `sirket_detay` (`pk`, `sirket_isim`, `vergi_dairesi`, `vergi_no`, `web`, `eposta`, `aciklama`) VALUES
(7, 'İSMAİL AKBUDAK', 'ANKARA KOLEJ', 2323, 'www.ismailakbudak.com', 'isoakbbudak@gmail.com', 'Deneme '),
(9, 'PORTAKAL', 'BAşKENT', 12112121, '', '', ''),
(10, 'DD', 'SD', 32, '33', 'iso@ho.com', '33'),
(11, 'AS', 'ASS', 23, '34', 'iso@ho.com', '3223'),
(15, '43', '34', 3433, '', '', ''),
(17, '1', '1', 1, '1', '', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stok`
--

CREATE TABLE IF NOT EXISTS `stok` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_fk` int(11) NOT NULL,
  `urun_fk` int(11) NOT NULL,
  `kullanici_fk` int(11) NOT NULL,
  `musteri_fk` int(11) NOT NULL,
  `urun_adet` int(11) NOT NULL,
  `adet_birim` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `birim_fiyat` double NOT NULL,
  `indirim` double NOT NULL,
  `islem` tinyint(1) NOT NULL,
  `tarih` date NOT NULL,
  `islem_tarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk`),
  KEY `sirket_fk` (`sirket_fk`),
  KEY `urun_fk` (`urun_fk`),
  KEY `kullanici_fk` (`kullanici_fk`),
  KEY `musteri_fk` (`musteri_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=569 ;

--
-- Tablo döküm verisi `stok`
--

INSERT INTO `stok` (`pk`, `sirket_fk`, `urun_fk`, `kullanici_fk`, `musteri_fk`, `urun_adet`, `adet_birim`, `birim_fiyat`, `indirim`, `islem`, `tarih`, `islem_tarihi`) VALUES
(557, 7, 15, 16, 63, 1, 'ADET', 444, 0, 0, '2013-07-23', '2013-07-23 09:54:43'),
(558, 7, 15, 16, 63, 23, '23', 32, 23, 0, '2013-07-23', '2013-07-23 10:27:36'),
(559, 7, 15, 16, 63, 1, 'ADET', 444, 0, 1, '2013-07-23', '2013-07-23 10:48:39'),
(560, 7, 15, 16, 63, 23, '23', 32, 23, 1, '2013-07-23', '2013-07-23 10:48:39'),
(561, 7, 15, 16, 63, 12, '12', 12, 12, 0, '2013-07-23', '2013-07-23 14:34:42'),
(562, 7, 15, 16, 63, 12, '12', 12, 2111, 0, '2013-07-23', '2013-07-23 14:34:42'),
(563, 7, 15, 16, 63, 11, '1', 1, 0, 1, '2013-07-23', '2013-07-23 14:34:59'),
(564, 7, 15, 16, 63, 32, '133', 133, 32, 0, '2013-07-25', '2013-07-25 19:37:10'),
(565, 7, 15, 16, 63, 23, '10', 10, 0.4, 1, '2013-07-25', '2013-07-25 19:38:11'),
(566, 7, 15, 16, 63, 12, '12', 12, 12, 1, '2013-07-25', '2013-07-25 19:38:11'),
(567, 7, 15, 16, 63, 6, '56', 56, 56, 0, '2013-11-21', '2013-11-21 01:38:05'),
(568, 7, 15, 16, 63, 6, '56', 56, 56, 0, '2013-11-21', '2013-11-21 01:38:05');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `telefon`
--

CREATE TABLE IF NOT EXISTS `telefon` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `adres_fk` int(11) NOT NULL,
  `telefon` varchar(13) COLLATE utf8_turkish_ci NOT NULL,
  `faks` varchar(13) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `adres_fk` (`adres_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE IF NOT EXISTS `urunler` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `grup_fk` int(11) NOT NULL,
  `urun_kodu` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `urun_ismi` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sinirsiz_stok` tinyint(1) NOT NULL,
  `kritik_seviye` int(11) DEFAULT NULL,
  `kdv_orani` int(2) NOT NULL,
  `aciklama` varchar(150) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `urun_kodu` (`urun_kodu`),
  KEY `grup_fk` (`grup_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=16 ;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`pk`, `grup_fk`, `urun_kodu`, `urun_ismi`, `sinirsiz_stok`, `kritik_seviye`, `kdv_orani`, `aciklama`) VALUES
(15, 3, '0001', 'MASA', 1, 5, 18, 'ddd');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_grup`
--

CREATE TABLE IF NOT EXISTS `urun_grup` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `sirket_fk` int(11) NOT NULL,
  `grup_ismi` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`pk`),
  KEY `sirket_fk` (`sirket_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `urun_grup`
--

INSERT INTO `urun_grup` (`pk`, `sirket_fk`, `grup_ismi`) VALUES
(3, 7, ' DENEME 3');

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `adres_musteri`
--
ALTER TABLE `adres_musteri`
  ADD CONSTRAINT `adres_musteri_ibfk_1` FOREIGN KEY (`adres_fk`) REFERENCES `adres` (`pk`),
  ADD CONSTRAINT `adres_musteri_ibfk_2` FOREIGN KEY (`musteri_fk`) REFERENCES `musteri_detay` (`pk`);

--
-- Tablo kısıtlamaları `fatura_detay`
--
ALTER TABLE `fatura_detay`
  ADD CONSTRAINT `fatura_detay_ibfk_1` FOREIGN KEY (`musteri_fk`) REFERENCES `musteri_detay` (`pk`),
  ADD CONSTRAINT `fatura_detay_ibfk_2` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`);

--
-- Tablo kısıtlamaları `fatura_irsaliye`
--
ALTER TABLE `fatura_irsaliye`
  ADD CONSTRAINT `fatura_irsaliye_ibfk_1` FOREIGN KEY (`irsaliye_detay_fk`) REFERENCES `irsaliye_detay` (`pk`),
  ADD CONSTRAINT `fatura_irsaliye_ibfk_2` FOREIGN KEY (`fatura_urun_fk`) REFERENCES `fatura_urun` (`pk`);

--
-- Tablo kısıtlamaları `fatura_normal`
--
ALTER TABLE `fatura_normal`
  ADD CONSTRAINT `fatura_normal_ibfk_1` FOREIGN KEY (`fatura_detay_fk`) REFERENCES `fatura_detay` (`pk`);

--
-- Tablo kısıtlamaları `fatura_position`
--
ALTER TABLE `fatura_position`
  ADD CONSTRAINT `fatura_position_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fatura_position_ibfk_2` FOREIGN KEY (`fatura_tur_fk`) REFERENCES `fatura_tur` (`pk`);

--
-- Tablo kısıtlamaları `fatura_position_xy`
--
ALTER TABLE `fatura_position_xy`
  ADD CONSTRAINT `fatura_position_xy_ibfk_1` FOREIGN KEY (`fatura_position_fk`) REFERENCES `fatura_position` (`pk`),
  ADD CONSTRAINT `fatura_position_xy_ibfk_2` FOREIGN KEY (`element_fk`) REFERENCES `element` (`pk`);

--
-- Tablo kısıtlamaları `fatura_urun`
--
ALTER TABLE `fatura_urun`
  ADD CONSTRAINT `fatura_urun_ibfk_1` FOREIGN KEY (`fatura_detay_fk`) REFERENCES `fatura_detay` (`pk`);

--
-- Tablo kısıtlamaları `irsaliye_detay`
--
ALTER TABLE `irsaliye_detay`
  ADD CONSTRAINT `irsaliye_detay_ibfk_1` FOREIGN KEY (`fatura_detay_fk`) REFERENCES `fatura_detay` (`pk`);

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `kullanicilar_ibfk_1` FOREIGN KEY (`kullanici_yetki_fk`) REFERENCES `kullanici_yetki` (`pk`);

--
-- Tablo kısıtlamaları `kullanici_sirket`
--
ALTER TABLE `kullanici_sirket`
  ADD CONSTRAINT `kullanici_sirket_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`),
  ADD CONSTRAINT `kullanici_sirket_ibfk_2` FOREIGN KEY (`kullanici_fk`) REFERENCES `kullanicilar` (`pk`);

--
-- Tablo kısıtlamaları `musteri_detay`
--
ALTER TABLE `musteri_detay`
  ADD CONSTRAINT `musteri_detay_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`);

--
-- Tablo kısıtlamaları `musteri_kod`
--
ALTER TABLE `musteri_kod`
  ADD CONSTRAINT `musteri_kod_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`);

--
-- Tablo kısıtlamaları `sirket_ayar`
--
ALTER TABLE `sirket_ayar`
  ADD CONSTRAINT `sirket_ayar_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`),
  ADD CONSTRAINT `stok_ibfk_2` FOREIGN KEY (`urun_fk`) REFERENCES `urunler` (`pk`),
  ADD CONSTRAINT `stok_ibfk_3` FOREIGN KEY (`kullanici_fk`) REFERENCES `kullanicilar` (`pk`),
  ADD CONSTRAINT `stok_ibfk_4` FOREIGN KEY (`musteri_fk`) REFERENCES `musteri_detay` (`pk`);

--
-- Tablo kısıtlamaları `telefon`
--
ALTER TABLE `telefon`
  ADD CONSTRAINT `telefon_ibfk_1` FOREIGN KEY (`adres_fk`) REFERENCES `adres` (`pk`);

--
-- Tablo kısıtlamaları `urunler`
--
ALTER TABLE `urunler`
  ADD CONSTRAINT `urunler_ibfk_1` FOREIGN KEY (`grup_fk`) REFERENCES `urun_grup` (`pk`);

--
-- Tablo kısıtlamaları `urun_grup`
--
ALTER TABLE `urun_grup`
  ADD CONSTRAINT `urun_grup_ibfk_1` FOREIGN KEY (`sirket_fk`) REFERENCES `sirket_detay` (`pk`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
