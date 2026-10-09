/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100414
 Source Host           : localhost:3306
 Source Schema         : KHM2025

 Target Server Type    : MySQL
 Target Server Version : 100414
 File Encoding         : 65001

 Date: 20/10/2024 21:35:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for master_city
-- ----------------------------
DROP TABLE IF EXISTS `master_city`;
CREATE TABLE `master_city` (
  `city_id` int(11) NOT NULL,
  `city_provinceid` int(11) DEFAULT NULL,
  `city_name` varchar(255) DEFAULT NULL,
  `city_type` varchar(255) DEFAULT NULL,
  `city_postalcode` varchar(255) DEFAULT NULL,
  `city_jnecode` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of master_city
-- ----------------------------
BEGIN;
INSERT INTO `master_city` VALUES (1, 21, 'Aceh Barat', 'Kabupaten', '23681', 'BTJ21300');
INSERT INTO `master_city` VALUES (2, 21, 'Aceh Barat Daya', 'Kabupaten', '23764', 'BTJ21300');
INSERT INTO `master_city` VALUES (3, 21, 'Aceh Besar', 'Kabupaten', '23951', 'BTJ21300');
INSERT INTO `master_city` VALUES (4, 21, 'Aceh Jaya', 'Kabupaten', '23654', 'BTJ21300');
INSERT INTO `master_city` VALUES (5, 21, 'Aceh Selatan', 'Kabupaten', '23719', 'BTJ20600');
INSERT INTO `master_city` VALUES (6, 21, 'Aceh Singkil', 'Kabupaten', '24785', 'BTJ21300');
INSERT INTO `master_city` VALUES (7, 21, 'Aceh Tamiang', 'Kabupaten', '24476', 'BTJ21300');
INSERT INTO `master_city` VALUES (8, 21, 'Aceh Tengah', 'Kabupaten', '24511', 'BTJ21300');
INSERT INTO `master_city` VALUES (9, 21, 'Aceh Tenggara', 'Kabupaten', '24611', 'BTJ21300');
INSERT INTO `master_city` VALUES (10, 21, 'Aceh Timur', 'Kabupaten', '24454', 'BTJ21400');
INSERT INTO `master_city` VALUES (11, 21, 'Aceh Utara', 'Kabupaten', '24382', 'BTJ21500');
INSERT INTO `master_city` VALUES (12, 32, 'Agam', 'Kabupaten', '26411', 'PDG22200');
INSERT INTO `master_city` VALUES (13, 23, 'Alor', 'Kabupaten', '85811', 'KOE20200');
INSERT INTO `master_city` VALUES (14, 19, 'Ambon', 'Kota', '97222', 'AMQ10000');
INSERT INTO `master_city` VALUES (15, 34, 'Asahan', 'Kabupaten', '21214', 'MES10100');
INSERT INTO `master_city` VALUES (16, 24, 'Asmat', 'Kabupaten', '99777', 'DJJ10000');
INSERT INTO `master_city` VALUES (17, 1, 'Badung', 'Kabupaten', '80351', 'DPS21100');
INSERT INTO `master_city` VALUES (18, 13, 'Balangan', 'Kabupaten', '71611', 'BDJ21200');
INSERT INTO `master_city` VALUES (19, 15, 'Balikpapan', 'Kota', '76111', 'BPN10000');
INSERT INTO `master_city` VALUES (20, 21, 'Banda Aceh', 'Kota', '23238', 'BTJ21300');
INSERT INTO `master_city` VALUES (21, 18, 'Bandar Lampung', 'Kota', '35139', 'TKG10000');
INSERT INTO `master_city` VALUES (22, 9, 'Bandung', 'Kabupaten', '40311', 'BDO10000');
INSERT INTO `master_city` VALUES (23, 9, 'Bandung', 'Kota', '40111', 'BDO10000');
INSERT INTO `master_city` VALUES (24, 9, 'Bandung Barat', 'Kabupaten', '40721', 'BDO21000');
INSERT INTO `master_city` VALUES (25, 29, 'Banggai', 'Kabupaten', '94711', 'PLW20100');
INSERT INTO `master_city` VALUES (26, 29, 'Banggai Kepulauan', 'Kabupaten', '94881', 'PLW20500');
INSERT INTO `master_city` VALUES (27, 2, 'Bangka', 'Kabupaten', '33212', 'PGK10206');
INSERT INTO `master_city` VALUES (28, 2, 'Bangka Barat', 'Kabupaten', '33315', 'PGK10300');
INSERT INTO `master_city` VALUES (29, 2, 'Bangka Selatan', 'Kabupaten', '33719', 'PGK10502');
INSERT INTO `master_city` VALUES (30, 2, 'Bangka Tengah', 'Kabupaten', '33613', 'PGK10400');
INSERT INTO `master_city` VALUES (31, 11, 'Bangkalan', 'Kabupaten', '69118', 'SUB20100');
INSERT INTO `master_city` VALUES (32, 1, 'Bangli', 'Kabupaten', '80619', 'DPS20200');
INSERT INTO `master_city` VALUES (33, 13, 'Banjar', 'Kabupaten', '70619', 'TSM20000');
INSERT INTO `master_city` VALUES (34, 9, 'Banjar', 'Kota', '46311', 'TSM20000');
INSERT INTO `master_city` VALUES (35, 13, 'Banjarbaru', 'Kota', '70712', 'BDJ10500');
INSERT INTO `master_city` VALUES (36, 13, 'Banjarmasin', 'Kota', '70117', 'BDJ10000');
INSERT INTO `master_city` VALUES (37, 10, 'Banjarnegara', 'Kabupaten', '53419', 'SRG21800');
INSERT INTO `master_city` VALUES (38, 28, 'Bantaeng', 'Kabupaten', '92411', 'UPG20100');
INSERT INTO `master_city` VALUES (39, 5, 'Bantul', 'Kabupaten', '55715', 'JOG10000');
INSERT INTO `master_city` VALUES (40, 33, 'Banyuasin', 'Kabupaten', '30911', 'PLM20800');
INSERT INTO `master_city` VALUES (41, 10, 'Banyumas', 'Kabupaten', '53114', 'TGL30000');
INSERT INTO `master_city` VALUES (42, 11, 'Banyuwangi', 'Kabupaten', '68416', 'JBR20100');
INSERT INTO `master_city` VALUES (43, 13, 'Barito Kuala', 'Kabupaten', '70511', 'BDJ20200');
INSERT INTO `master_city` VALUES (44, 14, 'Barito Selatan', 'Kabupaten', '73711', 'BDJ20200');
INSERT INTO `master_city` VALUES (45, 14, 'Barito Timur', 'Kabupaten', '73671', 'BDJ20200');
INSERT INTO `master_city` VALUES (46, 14, 'Barito Utara', 'Kabupaten', '73881', 'BDJ20200');
INSERT INTO `master_city` VALUES (47, 28, 'Barru', 'Kabupaten', '90719', 'UPG20200');
INSERT INTO `master_city` VALUES (48, 17, 'Batam', 'Kota', '29413', 'BTH10000');
INSERT INTO `master_city` VALUES (49, 10, 'Batang', 'Kabupaten', '51211', 'SRG20200');
INSERT INTO `master_city` VALUES (50, 8, 'Batang Hari', 'Kabupaten', '36613', 'DJB20200');
INSERT INTO `master_city` VALUES (51, 11, 'Batu', 'Kota', '65311', 'MXG20200');
INSERT INTO `master_city` VALUES (52, 34, 'Batu Bara', 'Kabupaten', '21655', 'MES21511');
INSERT INTO `master_city` VALUES (53, 30, 'Bau-Bau', 'Kota', '93719', 'KDI20100');
INSERT INTO `master_city` VALUES (54, 9, 'Bekasi', 'Kabupaten', '17837', 'CKR10000');
INSERT INTO `master_city` VALUES (55, 9, 'Bekasi', 'Kota', '17121', 'CKR10000');
INSERT INTO `master_city` VALUES (56, 2, 'Belitung', 'Kabupaten', '33419', 'TJQ10103');
INSERT INTO `master_city` VALUES (57, 2, 'Belitung Timur', 'Kabupaten', '33519', 'TJQ10103');
INSERT INTO `master_city` VALUES (58, 23, 'Belu', 'Kabupaten', '85711', 'KOE20100');
INSERT INTO `master_city` VALUES (59, 21, 'Bener Meriah', 'Kabupaten', '24581', 'BTJ21700');
INSERT INTO `master_city` VALUES (60, 26, 'Bengkalis', 'Kabupaten', '28719', 'PKU20200');
INSERT INTO `master_city` VALUES (61, 12, 'Bengkayang', 'Kabupaten', '79213', 'PNK20600');
INSERT INTO `master_city` VALUES (62, 4, 'Bengkulu', 'Kota', '38229', 'BKS10000');
INSERT INTO `master_city` VALUES (63, 4, 'Bengkulu Selatan', 'Kabupaten', '38519', 'BKS20300');
INSERT INTO `master_city` VALUES (64, 4, 'Bengkulu Tengah', 'Kabupaten', '38319', 'BKS10000');
INSERT INTO `master_city` VALUES (65, 4, 'Bengkulu Utara', 'Kabupaten', '38619', 'BKS20100');
INSERT INTO `master_city` VALUES (66, 15, 'Berau', 'Kabupaten', '77311', 'BPN20200');
INSERT INTO `master_city` VALUES (67, 24, 'Biak Numfor', 'Kabupaten', '98119', 'MKQ10000');
INSERT INTO `master_city` VALUES (68, 22, 'Bima', 'Kabupaten', '84171', 'AMI20100');
INSERT INTO `master_city` VALUES (69, 22, 'Bima', 'Kota', '84139', 'AMI20100');
INSERT INTO `master_city` VALUES (70, 34, 'Binjai', 'Kota', '20712', 'MES20200');
INSERT INTO `master_city` VALUES (71, 17, 'Bintan', 'Kabupaten', '29135', 'DJJ21300');
INSERT INTO `master_city` VALUES (72, 21, 'Bireuen', 'Kabupaten', '24219', 'BTJ20100');
INSERT INTO `master_city` VALUES (73, 31, 'Bitung', 'Kota', '95512', 'MDC10000');
INSERT INTO `master_city` VALUES (74, 11, 'Blitar', 'Kabupaten', '66171', 'MXG20100');
INSERT INTO `master_city` VALUES (75, 11, 'Blitar', 'Kota', '66124', 'MXG20100');
INSERT INTO `master_city` VALUES (76, 10, 'Blora', 'Kabupaten', '58219', 'SRG20300');
INSERT INTO `master_city` VALUES (77, 7, 'Boalemo', 'Kabupaten', '96319', 'GTO20200');
INSERT INTO `master_city` VALUES (78, 9, 'Bogor', 'Kabupaten', '16911', 'BOO10000');
INSERT INTO `master_city` VALUES (79, 9, 'Bogor', 'Kota', '16119', 'BOO10000');
INSERT INTO `master_city` VALUES (80, 11, 'Bojonegoro', 'Kabupaten', '62119', 'SRG20400');
INSERT INTO `master_city` VALUES (81, 31, 'Bolaang Mongondow (Bolmong)', 'Kabupaten', '95755', 'MDC20100');
INSERT INTO `master_city` VALUES (82, 31, 'Bolaang Mongondow Selatan', 'Kabupaten', '95774', 'MDC20100');
INSERT INTO `master_city` VALUES (83, 31, 'Bolaang Mongondow Timur', 'Kabupaten', '95783', 'MDC20100');
INSERT INTO `master_city` VALUES (84, 31, 'Bolaang Mongondow Utara', 'Kabupaten', '95765', 'MDC20100');
INSERT INTO `master_city` VALUES (85, 30, 'Bombana', 'Kabupaten', '93771', 'KDI20500');
INSERT INTO `master_city` VALUES (86, 11, 'Bondowoso', 'Kabupaten', '68219', 'JBR20200');
INSERT INTO `master_city` VALUES (87, 28, 'Bone', 'Kabupaten', '92713', 'UPG21800');
INSERT INTO `master_city` VALUES (88, 7, 'Bone Bolango', 'Kabupaten', '96511', 'GTO10000');
INSERT INTO `master_city` VALUES (89, 15, 'Bontang', 'Kota', '75313', 'BTG10000');
INSERT INTO `master_city` VALUES (90, 24, 'Boven Digoel', 'Kabupaten', '99662', 'MKQ10000');
INSERT INTO `master_city` VALUES (91, 10, 'Boyolali', 'Kabupaten', '57312', 'SOC20100');
INSERT INTO `master_city` VALUES (92, 10, 'Brebes', 'Kabupaten', '52212', 'TGL20000');
INSERT INTO `master_city` VALUES (93, 32, 'Bukittinggi', 'Kota', '26115', 'PDG20200');
INSERT INTO `master_city` VALUES (94, 1, 'Buleleng', 'Kabupaten', '81111', 'DPS20609');
INSERT INTO `master_city` VALUES (95, 28, 'Bulukumba', 'Kabupaten', '92511', 'UPG20300');
INSERT INTO `master_city` VALUES (96, 16, 'Bulungan (Bulongan)', 'Kabupaten', '77211', 'TRK20100');
INSERT INTO `master_city` VALUES (97, 8, 'Bungo', 'Kabupaten', '37216', 'DJB20300');
INSERT INTO `master_city` VALUES (98, 29, 'Buol', 'Kabupaten', '94564', 'PLW20600');
INSERT INTO `master_city` VALUES (99, 19, 'Buru', 'Kabupaten', '97371', 'AMQ20300');
INSERT INTO `master_city` VALUES (100, 19, 'Buru Selatan', 'Kabupaten', '97351', 'AMQ20307');
INSERT INTO `master_city` VALUES (101, 30, 'Buton', 'Kabupaten', '93754', 'KDI20600');
INSERT INTO `master_city` VALUES (102, 30, 'Buton Utara', 'Kabupaten', '93745', 'KDI20600');
INSERT INTO `master_city` VALUES (103, 9, 'Ciamis', 'Kabupaten', '46211', 'TSM30000');
INSERT INTO `master_city` VALUES (104, 9, 'Cianjur', 'Kabupaten', '43217', 'BDO21200');
INSERT INTO `master_city` VALUES (105, 10, 'Cilacap', 'Kabupaten', '53211', 'CXP10000');
INSERT INTO `master_city` VALUES (106, 3, 'Cilegon', 'Kota', '42417', 'CLG10000');
INSERT INTO `master_city` VALUES (107, 9, 'Cimahi', 'Kota', '40512', 'CBN10000');
INSERT INTO `master_city` VALUES (108, 9, 'Cirebon', 'Kabupaten', '45611', 'CBN10000');
INSERT INTO `master_city` VALUES (109, 9, 'Cirebon', 'Kota', '45116', 'CBN10000');
INSERT INTO `master_city` VALUES (110, 1, 'Dairi', 'Kabupaten', '22211', 'MES10300');
INSERT INTO `master_city` VALUES (111, 24, 'Deiyai (Deliyai)', 'Kabupaten', '98784', 'MKQ10000');
INSERT INTO `master_city` VALUES (112, 34, 'Deli Serdang', 'Kabupaten', '20511', 'MES10600');
INSERT INTO `master_city` VALUES (113, 10, 'Demak', 'Kabupaten', '59519', 'SRG20700');
INSERT INTO `master_city` VALUES (114, 1, 'Denpasar', 'Kota', '80227', 'DPS10000');
INSERT INTO `master_city` VALUES (115, 9, 'Depok', 'Kota', '16416', 'DPK10000');
INSERT INTO `master_city` VALUES (116, 32, 'Dharmasraya', 'Kabupaten', '27612', 'PDG21200');
INSERT INTO `master_city` VALUES (117, 24, 'Dogiyai', 'Kabupaten', '98866', 'MKQ10000');
INSERT INTO `master_city` VALUES (118, 22, 'Dompu', 'Kabupaten', '84217', 'AMI20200');
INSERT INTO `master_city` VALUES (119, 29, 'Donggala', 'Kabupaten', '94341', 'PLW20700');
INSERT INTO `master_city` VALUES (120, 26, 'Dumai', 'Kota', '28811', 'PKU10100');
INSERT INTO `master_city` VALUES (121, 33, 'Empat Lawang', 'Kabupaten', '31811', 'PLM21100');
INSERT INTO `master_city` VALUES (122, 23, 'Ende', 'Kabupaten', '86351', 'KOE20800');
INSERT INTO `master_city` VALUES (123, 28, 'Enrekang', 'Kabupaten', '91719', 'UPG20400');
INSERT INTO `master_city` VALUES (124, 25, 'Fakfak', 'Kabupaten', '98651', 'SOQ20000');
INSERT INTO `master_city` VALUES (125, 23, 'Flores Timur', 'Kabupaten', '86213', 'KOE20400');
INSERT INTO `master_city` VALUES (126, 9, 'Garut', 'Kabupaten', '44126', 'PWT10000');
INSERT INTO `master_city` VALUES (127, 21, 'Gayo Lues', 'Kabupaten', '24653', 'BTJ21700');
INSERT INTO `master_city` VALUES (128, 1, 'Gianyar', 'Kabupaten', '80519', 'DPS20300');
INSERT INTO `master_city` VALUES (129, 7, 'Gorontalo', 'Kabupaten', '96218', 'GTO10000');
INSERT INTO `master_city` VALUES (130, 7, 'Gorontalo', 'Kota', '96115', 'GTO10000');
INSERT INTO `master_city` VALUES (131, 7, 'Gorontalo Utara', 'Kabupaten', '96611', 'GTO20400');
INSERT INTO `master_city` VALUES (132, 28, 'Gowa', 'Kabupaten', '92111', 'UPG21600');
INSERT INTO `master_city` VALUES (133, 11, 'Gresik', 'Kabupaten', '61115', 'SUB10100');
INSERT INTO `master_city` VALUES (134, 10, 'Grobogan', 'Kabupaten', '58111', 'SRG21100');
INSERT INTO `master_city` VALUES (135, 5, 'Gunung Kidul', 'Kabupaten', '55812', 'JOG10000');
INSERT INTO `master_city` VALUES (136, 14, 'Gunung Mas', 'Kabupaten', '74511', 'PKY20400');
INSERT INTO `master_city` VALUES (137, 34, 'Gunungsitoli', 'Kota', '22813', 'DTB20100');
INSERT INTO `master_city` VALUES (138, 20, 'Halmahera Barat', 'Kabupaten', '97757', 'TTE20200');
INSERT INTO `master_city` VALUES (139, 20, 'Halmahera Selatan', 'Kabupaten', '97911', 'TTE20300');
INSERT INTO `master_city` VALUES (140, 20, 'Halmahera Tengah', 'Kabupaten', '97853', 'TTE20400');
INSERT INTO `master_city` VALUES (141, 20, 'Halmahera Timur', 'Kabupaten', '97862', 'TTE20500');
INSERT INTO `master_city` VALUES (142, 20, 'Halmahera Utara', 'Kabupaten', '97762', 'TTE20600');
INSERT INTO `master_city` VALUES (143, 13, 'Hulu Sungai Selatan', 'Kabupaten', '71212', 'BDJ10200');
INSERT INTO `master_city` VALUES (144, 13, 'Hulu Sungai Tengah', 'Kabupaten', '71313', 'BDJ10100');
INSERT INTO `master_city` VALUES (145, 13, 'Hulu Sungai Utara', 'Kabupaten', '71419', 'BDJ10100');
INSERT INTO `master_city` VALUES (146, 34, 'Humbang Hasundutan', 'Kabupaten', '22457', 'DTB20800');
INSERT INTO `master_city` VALUES (147, 26, 'Indragiri Hilir', 'Kabupaten', '29212', 'PKU20400');
INSERT INTO `master_city` VALUES (148, 26, 'Indragiri Hulu', 'Kabupaten', '29319', 'PKU20300');
INSERT INTO `master_city` VALUES (149, 9, 'Indramayu', 'Kabupaten', '45214', 'CBN20100');
INSERT INTO `master_city` VALUES (150, 24, 'Intan Jaya', 'Kabupaten', '98771', 'DJJ10000');
INSERT INTO `master_city` VALUES (151, 6, 'Jakarta Barat', 'Kota', '11220', 'CGK10000');
INSERT INTO `master_city` VALUES (152, 6, 'Jakarta Pusat', 'Kota', '10540', 'CGK10000');
INSERT INTO `master_city` VALUES (153, 6, 'Jakarta Selatan', 'Kota', '12230', 'CGK10000');
INSERT INTO `master_city` VALUES (154, 6, 'Jakarta Timur', 'Kota', '13330', 'CGK10000');
INSERT INTO `master_city` VALUES (155, 6, 'Jakarta Utara', 'Kota', '14140', 'CGK10000');
INSERT INTO `master_city` VALUES (156, 8, 'Jambi', 'Kota', '36111', 'DJB10000');
INSERT INTO `master_city` VALUES (157, 24, 'Jayapura', 'Kabupaten', '99352', 'DJJ10000');
INSERT INTO `master_city` VALUES (158, 24, 'Jayapura', 'Kota', '99114', 'DJJ10000');
INSERT INTO `master_city` VALUES (159, 24, 'Jayawijaya', 'Kabupaten', '99511', 'DJJ10000');
INSERT INTO `master_city` VALUES (160, 11, 'Jember', 'Kabupaten', '68113', 'JBR10000');
INSERT INTO `master_city` VALUES (161, 1, 'Jembrana', 'Kabupaten', '82251', 'DPS20400');
INSERT INTO `master_city` VALUES (162, 28, 'Jeneponto', 'Kabupaten', '92319', 'UPG20500');
INSERT INTO `master_city` VALUES (163, 10, 'Jepara', 'Kabupaten', '59419', 'SRG10100');
INSERT INTO `master_city` VALUES (164, 11, 'Jombang', 'Kabupaten', '61415', 'MJK10100');
INSERT INTO `master_city` VALUES (165, 25, 'Kaimana', 'Kabupaten', '98671', 'SOQ20100');
INSERT INTO `master_city` VALUES (166, 26, 'Kampar', 'Kabupaten', '28411', 'PKU20100');
INSERT INTO `master_city` VALUES (167, 14, 'Kapuas', 'Kabupaten', '73583', 'PKY20300');
INSERT INTO `master_city` VALUES (168, 12, 'Kapuas Hulu', 'Kabupaten', '78719', 'PNK20200');
INSERT INTO `master_city` VALUES (169, 10, 'Karanganyar', 'Kabupaten', '57718', 'SOC20200');
INSERT INTO `master_city` VALUES (170, 1, 'Karangasem', 'Kabupaten', '80819', 'DPS20108');
INSERT INTO `master_city` VALUES (171, 9, 'Karawang', 'Kabupaten', '41311', 'KRW10000');
INSERT INTO `master_city` VALUES (172, 17, 'Karimun', 'Kabupaten', '29611', 'BTH10403');
INSERT INTO `master_city` VALUES (173, 34, 'Karo', 'Kabupaten', '22119', 'MES20800');
INSERT INTO `master_city` VALUES (174, 14, 'Katingan', 'Kabupaten', '74411', 'PKY20200');
INSERT INTO `master_city` VALUES (175, 4, 'Kaur', 'Kabupaten', '38911', 'BKS21100');
INSERT INTO `master_city` VALUES (176, 12, 'Kayong Utara', 'Kabupaten', '78852', 'PNK10000');
INSERT INTO `master_city` VALUES (177, 10, 'Kebumen', 'Kabupaten', '54319', 'MGL10100');
INSERT INTO `master_city` VALUES (178, 11, 'Kediri', 'Kabupaten', '64184', 'KDR10000');
INSERT INTO `master_city` VALUES (179, 11, 'Kediri', 'Kota', '64125', 'KDR10000');
INSERT INTO `master_city` VALUES (180, 24, 'Keerom', 'Kabupaten', '99461', 'DJJ10000');
INSERT INTO `master_city` VALUES (181, 10, 'Kendal', 'Kabupaten', '51314', 'SRG20800');
INSERT INTO `master_city` VALUES (182, 30, 'Kendari', 'Kota', '93126', 'KDI10000');
INSERT INTO `master_city` VALUES (183, 4, 'Kepahiang', 'Kabupaten', '39319', 'BKS21200');
INSERT INTO `master_city` VALUES (184, 17, 'Kepulauan Anambas', 'Kabupaten', '29991', 'BTH10306');
INSERT INTO `master_city` VALUES (185, 19, 'Kepulauan Aru', 'Kabupaten', '97681', 'AMQ20400');
INSERT INTO `master_city` VALUES (186, 32, 'Kepulauan Mentawai', 'Kabupaten', '25771', 'PDG20900');
INSERT INTO `master_city` VALUES (187, 26, 'Kepulauan Meranti', 'Kabupaten', '28791', 'PKU21301');
INSERT INTO `master_city` VALUES (188, 31, 'Kepulauan Sangihe', 'Kabupaten', '95819', 'MDC20200');
INSERT INTO `master_city` VALUES (189, 6, 'Kepulauan Seribu', 'Kabupaten', '14550', 'CGK10000');
INSERT INTO `master_city` VALUES (190, 31, 'Kepulauan Siau Tagulandang Biaro (Sitaro)', 'Kabupaten', '95862', 'MDC21500');
INSERT INTO `master_city` VALUES (191, 20, 'Kepulauan Sula', 'Kabupaten', '97995', 'TTE20700');
INSERT INTO `master_city` VALUES (192, 31, 'Kepulauan Talaud', 'Kabupaten', '95885', 'MDC10000');
INSERT INTO `master_city` VALUES (193, 24, 'Kepulauan Yapen (Yapen Waropen)', 'Kabupaten', '98211', 'DJJ10000');
INSERT INTO `master_city` VALUES (194, 8, 'Kerinci', 'Kabupaten', '37167', 'DJB20400');
INSERT INTO `master_city` VALUES (195, 12, 'Ketapang', 'Kabupaten', '78874', 'PNK10100');
INSERT INTO `master_city` VALUES (196, 10, 'Klaten', 'Kabupaten', '57411', 'SOC20300');
INSERT INTO `master_city` VALUES (197, 1, 'Klungkung', 'Kabupaten', '80719', 'DPS20502');
INSERT INTO `master_city` VALUES (198, 30, 'Kolaka', 'Kabupaten', '93511', 'KDI20200');
INSERT INTO `master_city` VALUES (199, 30, 'Kolaka Utara', 'Kabupaten', '93911', 'KDI20700');
INSERT INTO `master_city` VALUES (200, 30, 'Konawe', 'Kabupaten', '93411', 'KDI20800');
INSERT INTO `master_city` VALUES (201, 30, 'Konawe Selatan', 'Kabupaten', '93811', 'KDI20800');
INSERT INTO `master_city` VALUES (202, 30, 'Konawe Utara', 'Kabupaten', '93311', 'KDI21104');
INSERT INTO `master_city` VALUES (203, 13, 'Kotabaru', 'Kabupaten', '72119', 'BDJ10300');
INSERT INTO `master_city` VALUES (204, 31, 'Kotamobagu', 'Kota', '95711', 'MDC20100');
INSERT INTO `master_city` VALUES (205, 14, 'Kotawaringin Barat', 'Kabupaten', '74119', 'PKY10000');
INSERT INTO `master_city` VALUES (206, 14, 'Kotawaringin Timur', 'Kabupaten', '74364', 'PKY10000');
INSERT INTO `master_city` VALUES (207, 26, 'Kuantan Singingi', 'Kabupaten', '29519', 'PKU20900');
INSERT INTO `master_city` VALUES (208, 12, 'Kubu Raya', 'Kabupaten', '78311', 'PNK10000');
INSERT INTO `master_city` VALUES (209, 10, 'Kudus', 'Kabupaten', '59311', 'SRG10200');
INSERT INTO `master_city` VALUES (210, 5, 'Kulon Progo', 'Kabupaten', '55611', 'JOG20400');
INSERT INTO `master_city` VALUES (211, 9, 'Kuningan', 'Kabupaten', '45511', 'CBN20200');
INSERT INTO `master_city` VALUES (212, 23, 'Kupang', 'Kabupaten', '85362', 'KOE10000');
INSERT INTO `master_city` VALUES (213, 23, 'Kupang', 'Kota', '85119', 'KOE10000');
INSERT INTO `master_city` VALUES (214, 15, 'Kutai Barat', 'Kabupaten', '75711', 'SMD20100');
INSERT INTO `master_city` VALUES (215, 15, 'Kutai Kartanegara', 'Kabupaten', '75511', 'BPN10008');
INSERT INTO `master_city` VALUES (216, 15, 'Kutai Timur', 'Kabupaten', '75611', 'BTG20100');
INSERT INTO `master_city` VALUES (217, 34, 'Labuhan Batu', 'Kabupaten', '21412', 'MES20700');
INSERT INTO `master_city` VALUES (218, 34, 'Labuhan Batu Selatan', 'Kabupaten', '21511', 'MES20704');
INSERT INTO `master_city` VALUES (219, 34, 'Labuhan Batu Utara', 'Kabupaten', '21711', 'MES20713');
INSERT INTO `master_city` VALUES (220, 33, 'Lahat', 'Kabupaten', '31419', 'PLM20300');
INSERT INTO `master_city` VALUES (221, 14, 'Lamandau', 'Kabupaten', '74611', 'PKY10000');
INSERT INTO `master_city` VALUES (222, 11, 'Lamongan', 'Kabupaten', '64125', 'SUB10200');
INSERT INTO `master_city` VALUES (223, 18, 'Lampung Barat', 'Kabupaten', '34814', 'TKG20400');
INSERT INTO `master_city` VALUES (224, 18, 'Lampung Selatan', 'Kabupaten', '35511', 'TKG20100');
INSERT INTO `master_city` VALUES (225, 18, 'Lampung Tengah', 'Kabupaten', '34212', 'TKG20300');
INSERT INTO `master_city` VALUES (226, 18, 'Lampung Timur', 'Kabupaten', '34319', 'TKG20300');
INSERT INTO `master_city` VALUES (227, 18, 'Lampung Utara', 'Kabupaten', '34516', 'TKG20200');
INSERT INTO `master_city` VALUES (228, 12, 'Landak', 'Kabupaten', '78319', 'PNK20700');
INSERT INTO `master_city` VALUES (229, 34, 'Langkat', 'Kabupaten', '20811', 'MES20900');
INSERT INTO `master_city` VALUES (230, 21, 'Langsa', 'Kota', '24412', 'BTJ10100');
INSERT INTO `master_city` VALUES (231, 24, 'Lanny Jaya', 'Kabupaten', '99531', 'DJJ10000');
INSERT INTO `master_city` VALUES (232, 3, 'Lebak', 'Kabupaten', '42319', 'TGR10113');
INSERT INTO `master_city` VALUES (233, 4, 'Lebong', 'Kabupaten', '39264', 'BKS21300');
INSERT INTO `master_city` VALUES (234, 23, 'Lembata', 'Kabupaten', '86611', 'KOE21800');
INSERT INTO `master_city` VALUES (235, 21, 'Lhokseumawe', 'Kota', '24352', 'BTJ10200');
INSERT INTO `master_city` VALUES (236, 32, 'Lima Puluh Koto/Kota', 'Kabupaten', '26671', 'PDG20100');
INSERT INTO `master_city` VALUES (237, 17, 'Lingga', 'Kabupaten', '29811', 'PLM21600');
INSERT INTO `master_city` VALUES (238, 22, 'Lombok Barat', 'Kabupaten', '83311', 'AMI20800');
INSERT INTO `master_city` VALUES (239, 22, 'Lombok Tengah', 'Kabupaten', '83511', 'AMI20300');
INSERT INTO `master_city` VALUES (240, 22, 'Lombok Timur', 'Kabupaten', '83612', 'AMI20400');
INSERT INTO `master_city` VALUES (241, 22, 'Lombok Utara', 'Kabupaten', '83711', 'AMI20807');
INSERT INTO `master_city` VALUES (242, 33, 'Lubuk Linggau', 'Kota', '31614', 'PLM21600');
INSERT INTO `master_city` VALUES (243, 11, 'Lumajang', 'Kabupaten', '67319', 'PBL20100');
INSERT INTO `master_city` VALUES (244, 28, 'Luwu', 'Kabupaten', '91994', 'UPG23100');
INSERT INTO `master_city` VALUES (245, 28, 'Luwu Timur', 'Kabupaten', '92981', 'UPG23200');
INSERT INTO `master_city` VALUES (246, 28, 'Luwu Utara', 'Kabupaten', '92911', 'UPG23300');
INSERT INTO `master_city` VALUES (247, 11, 'Madiun', 'Kabupaten', '63153', 'MDN10000');
INSERT INTO `master_city` VALUES (248, 11, 'Madiun', 'Kota', '63122', 'MDN10000');
INSERT INTO `master_city` VALUES (249, 10, 'Magelang', 'Kabupaten', '56519', 'MGL10000');
INSERT INTO `master_city` VALUES (250, 10, 'Magelang', 'Kota', '56133', 'MGL10000');
INSERT INTO `master_city` VALUES (251, 11, 'Magetan', 'Kabupaten', '63314', 'MDN20100');
INSERT INTO `master_city` VALUES (252, 9, 'Majalengka', 'Kabupaten', '45412', 'CBN20300');
INSERT INTO `master_city` VALUES (253, 27, 'Majene', 'Kabupaten', '91411', 'UPG20900');
INSERT INTO `master_city` VALUES (254, 28, 'Makassar', 'Kota', '90111', 'UPG10000');
INSERT INTO `master_city` VALUES (255, 11, 'Malang', 'Kabupaten', '65163', 'MXG10000');
INSERT INTO `master_city` VALUES (256, 11, 'Malang', 'Kota', '65112', 'MXG10000');
INSERT INTO `master_city` VALUES (257, 16, 'Malinau', 'Kabupaten', '77511', 'TRK20200');
INSERT INTO `master_city` VALUES (258, 19, 'Maluku Barat Daya', 'Kabupaten', '97451', 'AMQ20900');
INSERT INTO `master_city` VALUES (259, 19, 'Maluku Tengah', 'Kabupaten', '97513', 'AMQ20100');
INSERT INTO `master_city` VALUES (260, 19, 'Maluku Tenggara', 'Kabupaten', '97651', 'AMQ20800');
INSERT INTO `master_city` VALUES (261, 19, 'Maluku Tenggara Barat', 'Kabupaten', '97465', 'AMQ20800');
INSERT INTO `master_city` VALUES (262, 27, 'Mamasa', 'Kabupaten', '91362', 'UPG23400');
INSERT INTO `master_city` VALUES (263, 24, 'Mamberamo Raya', 'Kabupaten', '99381', 'DJJ10000');
INSERT INTO `master_city` VALUES (264, 24, 'Mamberamo Tengah', 'Kabupaten', '99553', 'DJJ10000');
INSERT INTO `master_city` VALUES (265, 27, 'Mamuju', 'Kabupaten', '91519', 'UPG23500');
INSERT INTO `master_city` VALUES (266, 27, 'Mamuju Utara', 'Kabupaten', '91571', 'UPG23500');
INSERT INTO `master_city` VALUES (267, 31, 'Manado', 'Kota', '95247', 'MDC10000');
INSERT INTO `master_city` VALUES (268, 34, 'Mandailing Natal', 'Kabupaten', '22916', 'PLM21000');
INSERT INTO `master_city` VALUES (269, 23, 'Manggarai', 'Kabupaten', '86551', 'KOE20600');
INSERT INTO `master_city` VALUES (270, 23, 'Manggarai Barat', 'Kabupaten', '86711', 'KOE21200');
INSERT INTO `master_city` VALUES (271, 23, 'Manggarai Timur', 'Kabupaten', '86811', 'KOE21300');
INSERT INTO `master_city` VALUES (272, 25, 'Manokwari', 'Kabupaten', '98311', 'SOQ20608');
INSERT INTO `master_city` VALUES (273, 25, 'Manokwari Selatan', 'Kabupaten', '98355', 'SOQ20608');
INSERT INTO `master_city` VALUES (274, 24, 'Mappi', 'Kabupaten', '99853', 'DJJ10000');
INSERT INTO `master_city` VALUES (275, 28, 'Maros', 'Kabupaten', '90511', 'UPG20800');
INSERT INTO `master_city` VALUES (276, 22, 'Mataram', 'Kota', '83131', 'AMI10000');
INSERT INTO `master_city` VALUES (277, 25, 'Maybrat', 'Kabupaten', '98051', 'SOQ20608');
INSERT INTO `master_city` VALUES (278, 34, 'Medan', 'Kota', '20228', 'MES10000');
INSERT INTO `master_city` VALUES (279, 12, 'Melawi', 'Kabupaten', '78619', 'PNK20800');
INSERT INTO `master_city` VALUES (280, 8, 'Merangin', 'Kabupaten', '37319', 'DJB20100');
INSERT INTO `master_city` VALUES (281, 24, 'Merauke', 'Kabupaten', '99613', 'MKQ10000');
INSERT INTO `master_city` VALUES (282, 18, 'Mesuji', 'Kabupaten', '34911', 'TKG21201');
INSERT INTO `master_city` VALUES (283, 18, 'Metro', 'Kota', '34111', 'TKG20300');
INSERT INTO `master_city` VALUES (284, 24, 'Mimika', 'Kabupaten', '99962', 'TIM10000');
INSERT INTO `master_city` VALUES (285, 31, 'Minahasa', 'Kabupaten', '95614', 'MDC20300');
INSERT INTO `master_city` VALUES (286, 31, 'Minahasa Selatan', 'Kabupaten', '95914', 'MDC20900');
INSERT INTO `master_city` VALUES (287, 31, 'Minahasa Tenggara', 'Kabupaten', '95995', 'MDC21000');
INSERT INTO `master_city` VALUES (288, 31, 'Minahasa Utara', 'Kabupaten', '95316', 'MDC20800');
INSERT INTO `master_city` VALUES (289, 11, 'Mojokerto', 'Kabupaten', '61382', 'MJK10000');
INSERT INTO `master_city` VALUES (290, 11, 'Mojokerto', 'Kota', '61316', 'MJK10000');
INSERT INTO `master_city` VALUES (291, 29, 'Morowali', 'Kabupaten', '94911', 'PLW20800');
INSERT INTO `master_city` VALUES (292, 33, 'Muara Enim', 'Kabupaten', '31315', 'PLM20517');
INSERT INTO `master_city` VALUES (293, 8, 'Muaro Jambi', 'Kabupaten', '36311', 'DJB10000');
INSERT INTO `master_city` VALUES (294, 4, 'Muko Muko', 'Kabupaten', '38715', 'BKS21400');
INSERT INTO `master_city` VALUES (295, 30, 'Muna', 'Kabupaten', '93611', 'KDI20300');
INSERT INTO `master_city` VALUES (296, 14, 'Murung Raya', 'Kabupaten', '73911', 'BDJ20200');
INSERT INTO `master_city` VALUES (297, 33, 'Musi Banyuasin', 'Kabupaten', '30719', 'PLM21001');
INSERT INTO `master_city` VALUES (298, 33, 'Musi Rawas', 'Kabupaten', '31661', 'PLM10300');
INSERT INTO `master_city` VALUES (299, 24, 'Nabire', 'Kabupaten', '98816', 'DJJ20500');
INSERT INTO `master_city` VALUES (300, 21, 'Nagan Raya', 'Kabupaten', '23674', 'BTJ21700');
INSERT INTO `master_city` VALUES (301, 23, 'Nagekeo', 'Kabupaten', '86911', 'KOE21400');
INSERT INTO `master_city` VALUES (302, 17, 'Natuna', 'Kabupaten', '29711', 'BTH10300');
INSERT INTO `master_city` VALUES (303, 24, 'Nduga', 'Kabupaten', '99541', 'MKQ10000');
INSERT INTO `master_city` VALUES (304, 23, 'Ngada', 'Kabupaten', '86413', 'KOE20900');
INSERT INTO `master_city` VALUES (305, 11, 'Nganjuk', 'Kabupaten', '64414', 'MJK10200');
INSERT INTO `master_city` VALUES (306, 11, 'Ngawi', 'Kabupaten', '63219', 'MDN20200');
INSERT INTO `master_city` VALUES (307, 34, 'Nias', 'Kabupaten', '22876', 'DTB20106');
INSERT INTO `master_city` VALUES (308, 34, 'Nias Barat', 'Kabupaten', '22895', 'DTB20106');
INSERT INTO `master_city` VALUES (309, 34, 'Nias Selatan', 'Kabupaten', '22865', 'DTB20106');
INSERT INTO `master_city` VALUES (310, 34, 'Nias Utara', 'Kabupaten', '22856', 'DTB20106');
INSERT INTO `master_city` VALUES (311, 16, 'Nunukan', 'Kabupaten', '77421', 'TRK20300');
INSERT INTO `master_city` VALUES (312, 33, 'Ogan Ilir', 'Kabupaten', '30811', 'PLM21300');
INSERT INTO `master_city` VALUES (313, 33, 'Ogan Komering Ilir', 'Kabupaten', '30618', 'PLM21400');
INSERT INTO `master_city` VALUES (314, 33, 'Ogan Komering Ulu', 'Kabupaten', '32112', 'PLM21500');
INSERT INTO `master_city` VALUES (315, 33, 'Ogan Komering Ulu Selatan', 'Kabupaten', '32211', 'PLM21500');
INSERT INTO `master_city` VALUES (316, 33, 'Ogan Komering Ulu Timur', 'Kabupaten', '32312', 'PLM21500');
INSERT INTO `master_city` VALUES (317, 11, 'Pacitan', 'Kabupaten', '63512', 'MDN20300');
INSERT INTO `master_city` VALUES (318, 32, 'Padang', 'Kota', '25112', 'PDG10000');
INSERT INTO `master_city` VALUES (319, 34, 'Padang Lawas', 'Kabupaten', '22763', 'DTB20700');
INSERT INTO `master_city` VALUES (320, 34, 'Padang Lawas Utara', 'Kabupaten', '22753', 'DTB20700');
INSERT INTO `master_city` VALUES (321, 32, 'Padang Panjang', 'Kota', '27122', 'PDG21100');
INSERT INTO `master_city` VALUES (322, 32, 'Padang Pariaman', 'Kabupaten', '25583', 'PDG20600');
INSERT INTO `master_city` VALUES (323, 34, 'Padang Sidempuan', 'Kota', '22727', 'DTB20500');
INSERT INTO `master_city` VALUES (324, 33, 'Pagar Alam', 'Kota', '31512', 'PLM20600');
INSERT INTO `master_city` VALUES (325, 34, 'Pakpak Bharat', 'Kabupaten', '22272', 'MES22100');
INSERT INTO `master_city` VALUES (326, 14, 'Palangka Raya', 'Kota', '73112', 'PKY10000');
INSERT INTO `master_city` VALUES (327, 33, 'Palembang', 'Kota', '30111', 'PLM10000');
INSERT INTO `master_city` VALUES (328, 28, 'Palopo', 'Kota', '91911', 'UPG21000');
INSERT INTO `master_city` VALUES (329, 29, 'Palu', 'Kota', '94111', 'PLW10000');
INSERT INTO `master_city` VALUES (330, 11, 'Pamekasan', 'Kabupaten', '69319', 'SUB20500');
INSERT INTO `master_city` VALUES (331, 3, 'Pandeglang', 'Kabupaten', '42212', 'CLG20100');
INSERT INTO `master_city` VALUES (332, 9, 'Pangandaran', 'Kabupaten', '46511', 'TSM40000');
INSERT INTO `master_city` VALUES (333, 28, 'Pangkajene Kepulauan', 'Kabupaten', '90611', 'UPG22100');
INSERT INTO `master_city` VALUES (334, 2, 'Pangkal Pinang', 'Kota', '33115', 'PGK10000');
INSERT INTO `master_city` VALUES (335, 24, 'Paniai', 'Kabupaten', '98765', 'MKQ10000');
INSERT INTO `master_city` VALUES (336, 28, 'Parepare', 'Kota', '91123', 'UPG22300');
INSERT INTO `master_city` VALUES (337, 32, 'Pariaman', 'Kota', '25511', 'PDG20600');
INSERT INTO `master_city` VALUES (338, 29, 'Parigi Moutong', 'Kabupaten', '94411', 'PLW20900');
INSERT INTO `master_city` VALUES (339, 32, 'Pasaman', 'Kabupaten', '26318', 'PDG20300');
INSERT INTO `master_city` VALUES (340, 32, 'Pasaman Barat', 'Kabupaten', '26511', 'PDG20300');
INSERT INTO `master_city` VALUES (341, 15, 'Paser', 'Kabupaten', '76211', 'BPN20300');
INSERT INTO `master_city` VALUES (342, 11, 'Pasuruan', 'Kabupaten', '67153', 'PSR10000');
INSERT INTO `master_city` VALUES (343, 11, 'Pasuruan', 'Kota', '67118', 'PSR10000');
INSERT INTO `master_city` VALUES (344, 10, 'Pati', 'Kabupaten', '59114', 'SRG20900');
INSERT INTO `master_city` VALUES (345, 32, 'Payakumbuh', 'Kota', '26213', 'PDG20700');
INSERT INTO `master_city` VALUES (346, 25, 'Pegunungan Arfak', 'Kabupaten', '98354', 'SOQ20608');
INSERT INTO `master_city` VALUES (347, 24, 'Pegunungan Bintang', 'Kabupaten', '99573', 'MKQ10000');
INSERT INTO `master_city` VALUES (348, 10, 'Pekalongan', 'Kabupaten', '51161', 'SRG10300');
INSERT INTO `master_city` VALUES (349, 10, 'Pekalongan', 'Kota', '51122', 'SRG10300');
INSERT INTO `master_city` VALUES (350, 26, 'Pekanbaru', 'Kota', '28112', 'PKU10000');
INSERT INTO `master_city` VALUES (351, 26, 'Pelalawan', 'Kabupaten', '28311', 'PKU10000');
INSERT INTO `master_city` VALUES (352, 10, 'Pemalang', 'Kabupaten', '52319', 'SRG21000');
INSERT INTO `master_city` VALUES (353, 34, 'Pematang Siantar', 'Kota', '21126', 'MES22600');
INSERT INTO `master_city` VALUES (354, 15, 'Penajam Paser Utara', 'Kabupaten', '76311', 'BPN20300');
INSERT INTO `master_city` VALUES (355, 18, 'Pesawaran', 'Kabupaten', '35312', 'TKG21400');
INSERT INTO `master_city` VALUES (356, 18, 'Pesisir Barat', 'Kabupaten', '35974', 'TKG20404');
INSERT INTO `master_city` VALUES (357, 32, 'Pesisir Selatan', 'Kabupaten', '25611', 'PDG20500');
INSERT INTO `master_city` VALUES (358, 21, 'Pidie', 'Kabupaten', '24116', 'BTJ20400');
INSERT INTO `master_city` VALUES (359, 21, 'Pidie Jaya', 'Kabupaten', '24186', 'BTJ20400');
INSERT INTO `master_city` VALUES (360, 28, 'Pinrang', 'Kabupaten', '91251', 'UPG21100');
INSERT INTO `master_city` VALUES (361, 7, 'Pohuwato', 'Kabupaten', '96419', 'GTO10000');
INSERT INTO `master_city` VALUES (362, 27, 'Polewali Mandar', 'Kabupaten', '91311', 'UPG21200');
INSERT INTO `master_city` VALUES (363, 11, 'Ponorogo', 'Kabupaten', '63411', 'MDN20400');
INSERT INTO `master_city` VALUES (364, 12, 'Pontianak', 'Kabupaten', '78971', 'PNK10000');
INSERT INTO `master_city` VALUES (365, 12, 'Pontianak', 'Kota', '78112', 'PNK10000');
INSERT INTO `master_city` VALUES (366, 29, 'Poso', 'Kabupaten', '94615', 'PLW20200');
INSERT INTO `master_city` VALUES (367, 33, 'Prabumulih', 'Kota', '31121', 'PLM20700');
INSERT INTO `master_city` VALUES (368, 18, 'Pringsewu', 'Kabupaten', '35719', 'TKG21303');
INSERT INTO `master_city` VALUES (369, 11, 'Probolinggo', 'Kabupaten', '67282', 'PBL10000');
INSERT INTO `master_city` VALUES (370, 11, 'Probolinggo', 'Kota', '67215', 'PBL10000');
INSERT INTO `master_city` VALUES (371, 14, 'Pulang Pisau', 'Kabupaten', '74811', 'PKY20400');
INSERT INTO `master_city` VALUES (372, 20, 'Pulau Morotai', 'Kabupaten', '97771', 'TTE20900');
INSERT INTO `master_city` VALUES (373, 24, 'Puncak', 'Kabupaten', '98981', 'DJJ21400');
INSERT INTO `master_city` VALUES (374, 24, 'Puncak Jaya', 'Kabupaten', '98979', 'DJJ21400');
INSERT INTO `master_city` VALUES (375, 10, 'Purbalingga', 'Kabupaten', '53312', 'SRG21700');
INSERT INTO `master_city` VALUES (376, 9, 'Purwakarta', 'Kabupaten', '41119', 'PWT10000');
INSERT INTO `master_city` VALUES (377, 10, 'Purworejo', 'Kabupaten', '54111', 'MGL10300');
INSERT INTO `master_city` VALUES (378, 25, 'Raja Ampat', 'Kabupaten', '98489', 'SOQ20300');
INSERT INTO `master_city` VALUES (379, 4, 'Rejang Lebong', 'Kabupaten', '39112', 'BKS20200');
INSERT INTO `master_city` VALUES (380, 10, 'Rembang', 'Kabupaten', '59219', 'SRG21200');
INSERT INTO `master_city` VALUES (381, 26, 'Rokan Hilir', 'Kabupaten', '28992', 'PKU20500');
INSERT INTO `master_city` VALUES (382, 26, 'Rokan Hulu', 'Kabupaten', '28511', 'PKU21113');
INSERT INTO `master_city` VALUES (383, 23, 'Rote Ndao', 'Kabupaten', '85982', 'KOE10000');
INSERT INTO `master_city` VALUES (384, 21, 'Sabang', 'Kota', '23512', 'BTJ20700');
INSERT INTO `master_city` VALUES (385, 23, 'Sabu Raijua', 'Kabupaten', '85391', 'KOE21920');
INSERT INTO `master_city` VALUES (386, 10, 'Salatiga', 'Kota', '50711', 'SRG21300');
INSERT INTO `master_city` VALUES (387, 15, 'Samarinda', 'Kota', '75133', 'SMD10000');
INSERT INTO `master_city` VALUES (388, 12, 'Sambas', 'Kabupaten', '79453', 'PNK21000');
INSERT INTO `master_city` VALUES (389, 34, 'Samosir', 'Kabupaten', '22392', 'MES22200');
INSERT INTO `master_city` VALUES (390, 11, 'Sampang', 'Kabupaten', '69219', 'SUB20600');
INSERT INTO `master_city` VALUES (391, 12, 'Sanggau', 'Kabupaten', '78557', 'PNK10200');
INSERT INTO `master_city` VALUES (392, 24, 'Sarmi', 'Kabupaten', '99373', 'DJJ10000');
INSERT INTO `master_city` VALUES (393, 8, 'Sarolangun', 'Kabupaten', '37419', 'DJB20700');
INSERT INTO `master_city` VALUES (394, 32, 'Sawah Lunto', 'Kota', '27416', 'PDG20800');
INSERT INTO `master_city` VALUES (395, 12, 'Sekadau', 'Kabupaten', '79583', 'PNK21100');
INSERT INTO `master_city` VALUES (396, 28, 'Selayar (Kepulauan Selayar)', 'Kabupaten', '92812', 'UPG22000');
INSERT INTO `master_city` VALUES (397, 4, 'Seluma', 'Kabupaten', '38811', 'BKS23000');
INSERT INTO `master_city` VALUES (398, 10, 'Semarang', 'Kabupaten', '50511', 'SRG10000');
INSERT INTO `master_city` VALUES (399, 10, 'Semarang', 'Kota', '50135', 'SRG10000');
INSERT INTO `master_city` VALUES (400, 19, 'Seram Bagian Barat', 'Kabupaten', '97561', 'AMQ20307');
INSERT INTO `master_city` VALUES (401, 19, 'Seram Bagian Timur', 'Kabupaten', '97581', 'AMQ20307');
INSERT INTO `master_city` VALUES (402, 3, 'Serang', 'Kabupaten', '42182', 'CLG10000');
INSERT INTO `master_city` VALUES (403, 3, 'Serang', 'Kota', '42111', 'CLG10000');
INSERT INTO `master_city` VALUES (404, 34, 'Serdang Bedagai', 'Kabupaten', '20915', 'MES22300');
INSERT INTO `master_city` VALUES (405, 14, 'Seruyan', 'Kabupaten', '74211', 'PKY10000');
INSERT INTO `master_city` VALUES (406, 26, 'Siak', 'Kabupaten', '28623', 'PKU21209');
INSERT INTO `master_city` VALUES (407, 34, 'Sibolga', 'Kota', '22522', 'DTB20400');
INSERT INTO `master_city` VALUES (408, 28, 'Sidenreng Rappang/Rapang', 'Kabupaten', '91613', 'UPG21300');
INSERT INTO `master_city` VALUES (409, 11, 'Sidoarjo', 'Kabupaten', '61219', 'SUB20700');
INSERT INTO `master_city` VALUES (410, 29, 'Sigi', 'Kabupaten', '94364', 'PLW20709');
INSERT INTO `master_city` VALUES (411, 32, 'Sijunjung (Sawah Lunto Sijunjung)', 'Kabupaten', '27511', 'PDG20800');
INSERT INTO `master_city` VALUES (412, 23, 'Sikka', 'Kabupaten', '86121', 'KOE20500');
INSERT INTO `master_city` VALUES (413, 34, 'Simalungun', 'Kabupaten', '21162', 'MES20601');
INSERT INTO `master_city` VALUES (414, 21, 'Simeulue', 'Kabupaten', '23891', 'BTJ22100');
INSERT INTO `master_city` VALUES (415, 12, 'Singkawang', 'Kota', '79117', 'PNK10300');
INSERT INTO `master_city` VALUES (416, 28, 'Sinjai', 'Kabupaten', '92615', 'UPG21500');
INSERT INTO `master_city` VALUES (417, 12, 'Sintang', 'Kabupaten', '78619', 'PNK10400');
INSERT INTO `master_city` VALUES (418, 11, 'Situbondo', 'Kabupaten', '68316', 'PBL20200');
INSERT INTO `master_city` VALUES (419, 5, 'Sleman', 'Kabupaten', '55513', 'JOG10000');
INSERT INTO `master_city` VALUES (420, 32, 'Solok', 'Kabupaten', '27365', 'PDG20900');
INSERT INTO `master_city` VALUES (421, 32, 'Solok', 'Kota', '27315', 'PDG20900');
INSERT INTO `master_city` VALUES (422, 32, 'Solok Selatan', 'Kabupaten', '27779', 'PDG20900');
INSERT INTO `master_city` VALUES (423, 28, 'Soppeng', 'Kabupaten', '90812', 'UPG21900');
INSERT INTO `master_city` VALUES (424, 25, 'Sorong', 'Kabupaten', '98431', 'SOQ10000');
INSERT INTO `master_city` VALUES (425, 25, 'Sorong', 'Kota', '98411', 'SOQ10000');
INSERT INTO `master_city` VALUES (426, 25, 'Sorong Selatan', 'Kabupaten', '98454', 'SOQ20400');
INSERT INTO `master_city` VALUES (427, 10, 'Sragen', 'Kabupaten', '57211', 'SOC20400');
INSERT INTO `master_city` VALUES (428, 9, 'Subang', 'Kabupaten', '41215', 'PWT20000');
INSERT INTO `master_city` VALUES (429, 21, 'Subulussalam', 'Kota', '24882', 'BTJ22200');
INSERT INTO `master_city` VALUES (430, 9, 'Sukabumi', 'Kabupaten', '43311', 'SMI10005');
INSERT INTO `master_city` VALUES (431, 9, 'Sukabumi', 'Kota', '43114', 'SMI10000');
INSERT INTO `master_city` VALUES (432, 14, 'Sukamara', 'Kabupaten', '74712', 'PKY21300');
INSERT INTO `master_city` VALUES (433, 10, 'Sukoharjo', 'Kabupaten', '57514', 'SOC20500');
INSERT INTO `master_city` VALUES (434, 23, 'Sumba Barat', 'Kabupaten', '87219', 'KOE21100');
INSERT INTO `master_city` VALUES (435, 23, 'Sumba Barat Daya', 'Kabupaten', '87453', 'KOE21100');
INSERT INTO `master_city` VALUES (436, 23, 'Sumba Tengah', 'Kabupaten', '87358', 'KOE21100');
INSERT INTO `master_city` VALUES (437, 23, 'Sumba Timur', 'Kabupaten', '87112', 'KOE21000');
INSERT INTO `master_city` VALUES (438, 22, 'Sumbawa', 'Kabupaten', '84315', 'AMI20500');
INSERT INTO `master_city` VALUES (439, 22, 'Sumbawa Barat', 'Kabupaten', '84419', 'AMI20500');
INSERT INTO `master_city` VALUES (440, 9, 'Sumedang', 'Kabupaten', '45326', 'BDO20200');
INSERT INTO `master_city` VALUES (441, 11, 'Sumenep', 'Kabupaten', '69413', 'SUB20800');
INSERT INTO `master_city` VALUES (442, 8, 'Sungaipenuh', 'Kota', '37113', 'DJB20400');
INSERT INTO `master_city` VALUES (443, 24, 'Supiori', 'Kabupaten', '98164', 'DJJ10000');
INSERT INTO `master_city` VALUES (444, 11, 'Surabaya', 'Kota', '60119', 'SUB20800');
INSERT INTO `master_city` VALUES (445, 10, 'Surakarta (Solo)', 'Kota', '57113', 'SOC10000');
INSERT INTO `master_city` VALUES (446, 13, 'Tabalong', 'Kabupaten', '71513', 'BDJ10400');
INSERT INTO `master_city` VALUES (447, 1, 'Tabanan', 'Kabupaten', '82119', 'DPS20700');
INSERT INTO `master_city` VALUES (448, 28, 'Takalar', 'Kabupaten', '92212', 'UPG21700');
INSERT INTO `master_city` VALUES (449, 25, 'Tambrauw', 'Kabupaten', '98475', 'SOQ20500');
INSERT INTO `master_city` VALUES (450, 16, 'Tana Tidung', 'Kabupaten', '77611', 'TRK20400');
INSERT INTO `master_city` VALUES (451, 28, 'Tana Toraja', 'Kabupaten', '91819', 'UPG20600');
INSERT INTO `master_city` VALUES (452, 13, 'Tanah Bumbu', 'Kabupaten', '72211', 'BDJ21300');
INSERT INTO `master_city` VALUES (453, 32, 'Tanah Datar', 'Kabupaten', '27211', 'PDG20100');
INSERT INTO `master_city` VALUES (454, 13, 'Tanah Laut', 'Kabupaten', '70811', 'BDJ10300');
INSERT INTO `master_city` VALUES (455, 3, 'Tangerang', 'Kabupaten', '15914', 'TGR10054');
INSERT INTO `master_city` VALUES (456, 3, 'Tangerang', 'Kota', '15111', 'TGR10054');
INSERT INTO `master_city` VALUES (457, 3, 'Tangerang Selatan', 'Kota', '15332', 'TGR10113');
INSERT INTO `master_city` VALUES (458, 18, 'Tanggamus', 'Kabupaten', '35619', 'TKG21300');
INSERT INTO `master_city` VALUES (459, 34, 'Tanjung Balai', 'Kota', '21321', 'MES22500');
INSERT INTO `master_city` VALUES (460, 8, 'Tanjung Jabung Barat', 'Kabupaten', '36513', 'DJB20800');
INSERT INTO `master_city` VALUES (461, 8, 'Tanjung Jabung Timur', 'Kabupaten', '36719', 'DJB20607');
INSERT INTO `master_city` VALUES (462, 17, 'Tanjung Pinang', 'Kota', '29111', 'BTH10306');
INSERT INTO `master_city` VALUES (463, 34, 'Tapanuli Selatan', 'Kabupaten', '22742', 'DTB21200');
INSERT INTO `master_city` VALUES (464, 34, 'Tapanuli Tengah', 'Kabupaten', '22611', 'DTB20400');
INSERT INTO `master_city` VALUES (465, 34, 'Tapanuli Utara', 'Kabupaten', '22414', 'DTB20600');
INSERT INTO `master_city` VALUES (466, 13, 'Tapin', 'Kabupaten', '71119', 'BDJ10300');
INSERT INTO `master_city` VALUES (467, 16, 'Tarakan', 'Kota', '77114', 'TRK10000');
INSERT INTO `master_city` VALUES (468, 9, 'Tasikmalaya', 'Kabupaten', '46411', 'TSM10000');
INSERT INTO `master_city` VALUES (469, 9, 'Tasikmalaya', 'Kota', '46116', 'TSM10000');
INSERT INTO `master_city` VALUES (470, 34, 'Tebing Tinggi', 'Kota', '20632', 'PLM21100');
INSERT INTO `master_city` VALUES (471, 8, 'Tebo', 'Kabupaten', '37519', 'DJB20900');
INSERT INTO `master_city` VALUES (472, 10, 'Tegal', 'Kabupaten', '52419', 'TGL10200');
INSERT INTO `master_city` VALUES (473, 10, 'Tegal', 'Kota', '52114', 'TGL10000');
INSERT INTO `master_city` VALUES (474, 25, 'Teluk Bintuni', 'Kabupaten', '98551', 'SOQ20500');
INSERT INTO `master_city` VALUES (475, 25, 'Teluk Wondama', 'Kabupaten', '98591', 'SOQ20500');
INSERT INTO `master_city` VALUES (476, 10, 'Temanggung', 'Kabupaten', '56212', 'MGL10400');
INSERT INTO `master_city` VALUES (477, 20, 'Ternate', 'Kota', '97714', 'TTE10000');
INSERT INTO `master_city` VALUES (478, 20, 'Tidore Kepulauan', 'Kota', '97815', 'TTE20800');
INSERT INTO `master_city` VALUES (479, 23, 'Timor Tengah Selatan', 'Kabupaten', '85562', 'KOE20700');
INSERT INTO `master_city` VALUES (480, 23, 'Timor Tengah Utara', 'Kabupaten', '85612', 'KOE20700');
INSERT INTO `master_city` VALUES (481, 34, 'Toba Samosir', 'Kabupaten', '22316', 'DTB10000');
INSERT INTO `master_city` VALUES (482, 29, 'Tojo Una-Una', 'Kabupaten', '94683', 'PLW21000');
INSERT INTO `master_city` VALUES (483, 29, 'Toli-Toli', 'Kabupaten', '94542', 'PLW20300');
INSERT INTO `master_city` VALUES (484, 24, 'Tolikara', 'Kabupaten', '99411', 'DJJ10000');
INSERT INTO `master_city` VALUES (485, 31, 'Tomohon', 'Kota', '95416', 'MDC21100');
INSERT INTO `master_city` VALUES (486, 28, 'Toraja Utara', 'Kabupaten', '91831', 'UPG20605');
INSERT INTO `master_city` VALUES (487, 11, 'Trenggalek', 'Kabupaten', '66312', 'SUB22000');
INSERT INTO `master_city` VALUES (488, 19, 'Tual', 'Kota', '97612', 'AMQ20800');
INSERT INTO `master_city` VALUES (489, 11, 'Tuban', 'Kabupaten', '62319', 'SUB20900');
INSERT INTO `master_city` VALUES (490, 18, 'Tulang Bawang', 'Kabupaten', '34613', 'TKG21204');
INSERT INTO `master_city` VALUES (491, 18, 'Tulang Bawang Barat', 'Kabupaten', '34419', 'TKG21204');
INSERT INTO `master_city` VALUES (492, 11, 'Tulungagung', 'Kabupaten', '66212', 'SUB21000');
INSERT INTO `master_city` VALUES (493, 28, 'Wajo', 'Kabupaten', '90911', 'UPG21400');
INSERT INTO `master_city` VALUES (494, 30, 'Wakatobi', 'Kabupaten', '93791', 'KDI20900');
INSERT INTO `master_city` VALUES (495, 24, 'Waropen', 'Kabupaten', '98269', 'DJJ10000');
INSERT INTO `master_city` VALUES (496, 18, 'Way Kanan', 'Kabupaten', '34711', 'TKG21102');
INSERT INTO `master_city` VALUES (497, 10, 'Wonogiri', 'Kabupaten', '57619', 'SOC20600');
INSERT INTO `master_city` VALUES (498, 10, 'Wonosobo', 'Kabupaten', '56311', 'MGL10200');
INSERT INTO `master_city` VALUES (499, 24, 'Yahukimo', 'Kabupaten', '99041', 'DJJ10000');
INSERT INTO `master_city` VALUES (500, 24, 'Yalimo', 'Kabupaten', '99481', 'DJJ10000');
INSERT INTO `master_city` VALUES (501, 5, 'Yogyakarta', 'Kota', '55111', 'JOG10000');
COMMIT;

-- ----------------------------
-- Table structure for master_group
-- ----------------------------
DROP TABLE IF EXISTS `master_group`;
CREATE TABLE `master_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_user` int(11) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `group_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for master_kategori
-- ----------------------------
DROP TABLE IF EXISTS `master_kategori`;
CREATE TABLE `master_kategori` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_status` int(11) NOT NULL DEFAULT 1,
  `kategori_kategori` enum('pelajar','umum','difabel') NOT NULL DEFAULT 'umum',
  `kategori_name` varchar(255) DEFAULT NULL,
  `kategori_prefix` varchar(3) DEFAULT NULL,
  `kategori_startid` varchar(255) NOT NULL DEFAULT '1',
  `kategori_umurmin` int(11) DEFAULT NULL,
  `kategori_umurmax` int(11) DEFAULT NULL,
  `kategori_priceearly` varchar(255) DEFAULT NULL,
  `kategori_dateearly` datetime DEFAULT NULL,
  `kategori_price` varchar(255) DEFAULT NULL,
  `kategori_kaosfinish` enum('T','F') NOT NULL DEFAULT 'F',
  `kategori_kuota` int(11) DEFAULT NULL,
  `kategori_dateexp` datetime DEFAULT NULL,
  `kategori_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of master_kategori
-- ----------------------------
BEGIN;
INSERT INTO `master_kategori` VALUES (1, 1, 'umum', '10K UMUM', 'U', '5000', 7, 100, '275000', '2024-08-31 23:59:00', '300000', 'F', 4999, '2025-06-30 23:59:00', '2024-03-10 15:49:08');
INSERT INTO `master_kategori` VALUES (2, 1, 'pelajar', '10K PELAJAR', 'P', '2000', 10, 19, '0', '2024-08-31 23:59:00', '0', 'F', 1999, '2025-06-30 23:59:00', '2024-03-10 16:09:19');
INSERT INTO `master_kategori` VALUES (3, 1, 'difabel', '10K Difabel', 'D', '1000', 9, 100, '0', '2024-08-31 23:59:00', '0', 'F', 999, '2025-06-30 23:59:00', '2024-03-10 17:14:35');
COMMIT;

-- ----------------------------
-- Table structure for master_notif
-- ----------------------------
DROP TABLE IF EXISTS `master_notif`;
CREATE TABLE `master_notif` (
  `notif_id` int(11) NOT NULL AUTO_INCREMENT,
  `notif_user` int(11) DEFAULT NULL,
  `notif_title` varchar(255) DEFAULT NULL,
  `notif_text` text DEFAULT NULL,
  `notif_created` datetime NOT NULL DEFAULT current_timestamp(),
  `notif_status` enum('n','r') DEFAULT 'n',
  PRIMARY KEY (`notif_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for master_options
-- ----------------------------
DROP TABLE IF EXISTS `master_options`;
CREATE TABLE `master_options` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` text DEFAULT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_options
-- ----------------------------
BEGIN;
INSERT INTO `master_options` VALUES (1, 'contact_telp', '085157511818');
INSERT INTO `master_options` VALUES (2, 'contact_email', 'kedirihalfmarathon@gmail.com');
INSERT INTO `master_options` VALUES (3, 'contact_address', 'Kediri');
INSERT INTO `master_options` VALUES (42, 'running_modul', '2024-10-10');
INSERT INTO `master_options` VALUES (43, 'informasi', '1. Jadwal pengambilan paket lomba akan disampaikan melalui instagram dan website resmi.<br>\r\n2. Peserta wajib menunjukkan bukti email konfirmasi yang diterima atau bisa dicek di notifikasi pada halaman login user.<br>\r\n3. Apabila berhalangan untuk mengambil dapat diambilkan oleh orang lain dengan menunjukkan email konfirmasi dan fotokopi KTP<br>');
COMMIT;

-- ----------------------------
-- Table structure for master_pelari
-- ----------------------------
DROP TABLE IF EXISTS `master_pelari`;
CREATE TABLE `master_pelari` (
  `pelari_id` int(11) NOT NULL AUTO_INCREMENT,
  `pelari_user` int(11) DEFAULT NULL,
  `pelari_group` int(11) DEFAULT NULL,
  `pelari_kategori` int(11) DEFAULT NULL,
  `pelari_name` varchar(255) DEFAULT NULL,
  `pelari_namabib` varchar(255) DEFAULT NULL,
  `pelari_bib` varchar(255) DEFAULT NULL,
  `pelari_club` varchar(255) DEFAULT NULL,
  `pelari_alamat` text DEFAULT NULL,
  `pelari_provinsi` int(11) DEFAULT NULL,
  `pelari_kota` int(11) DEFAULT NULL,
  `pelari_telp` varchar(255) DEFAULT NULL,
  `pelari_sex` varchar(2) NOT NULL DEFAULT 'L',
  `pelari_tgllahir` date DEFAULT NULL,
  `pelari_goldar` varchar(255) DEFAULT NULL,
  `pelari_identitas` varchar(255) DEFAULT NULL,
  `pelari_riwayat` enum('T','F') NOT NULL DEFAULT 'F',
  `pelari_ketriwayat` varchar(255) DEFAULT NULL,
  `pelari_namadarurat` varchar(255) DEFAULT NULL,
  `pelari_tlpdarurat` varchar(255) DEFAULT NULL,
  `pelari_kaos` varchar(255) DEFAULT NULL,
  `pelari_kaosfinish` varchar(255) DEFAULT NULL,
  `pelari_ambilinfo` datetime DEFAULT NULL,
  `pelari_ambil` enum('T','F') NOT NULL DEFAULT 'F',
  `pelari_ambildate` datetime DEFAULT NULL,
  `pelari_created` datetime NOT NULL DEFAULT current_timestamp(),
  `pelari_bypass` enum('true','false') NOT NULL DEFAULT 'false',
  `pelari_ambilnama` text DEFAULT NULL,
  PRIMARY KEY (`pelari_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for master_provinsi
-- ----------------------------
DROP TABLE IF EXISTS `master_provinsi`;
CREATE TABLE `master_provinsi` (
  `provinsi_id` int(11) NOT NULL AUTO_INCREMENT,
  `provinsi_nama` varchar(150) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`provinsi_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of master_provinsi
-- ----------------------------
BEGIN;
INSERT INTO `master_provinsi` VALUES (1, 'Bali');
INSERT INTO `master_provinsi` VALUES (2, 'Bangka Belitung');
INSERT INTO `master_provinsi` VALUES (3, 'Banten');
INSERT INTO `master_provinsi` VALUES (4, 'Bengkulu');
INSERT INTO `master_provinsi` VALUES (5, 'DI Yogyakarta');
INSERT INTO `master_provinsi` VALUES (6, 'DKI Jakarta');
INSERT INTO `master_provinsi` VALUES (7, 'Gorontalo');
INSERT INTO `master_provinsi` VALUES (8, 'Jambi');
INSERT INTO `master_provinsi` VALUES (9, 'Jawa Barat');
INSERT INTO `master_provinsi` VALUES (10, 'Jawa Tengah');
INSERT INTO `master_provinsi` VALUES (11, 'Jawa Timur');
INSERT INTO `master_provinsi` VALUES (12, 'Kalimantan Barat');
INSERT INTO `master_provinsi` VALUES (13, 'Kalimantan Selatan');
INSERT INTO `master_provinsi` VALUES (14, 'Kalimantan Tengah');
INSERT INTO `master_provinsi` VALUES (15, 'Kalimantan Timur');
INSERT INTO `master_provinsi` VALUES (16, 'Kalimantan Utara');
INSERT INTO `master_provinsi` VALUES (17, 'Kepulauan Riau');
INSERT INTO `master_provinsi` VALUES (18, 'Lampung');
INSERT INTO `master_provinsi` VALUES (19, 'Maluku');
INSERT INTO `master_provinsi` VALUES (20, 'Maluku Utara');
INSERT INTO `master_provinsi` VALUES (21, 'Nanggroe Aceh Darussalam (NAD)');
INSERT INTO `master_provinsi` VALUES (22, 'Nusa Tenggara Barat (NTB)');
INSERT INTO `master_provinsi` VALUES (23, 'Nusa Tenggara Timur (NTT)');
INSERT INTO `master_provinsi` VALUES (24, 'Papua');
INSERT INTO `master_provinsi` VALUES (25, 'Papua Barat');
INSERT INTO `master_provinsi` VALUES (26, 'Riau');
INSERT INTO `master_provinsi` VALUES (27, 'Sulawesi Barat');
INSERT INTO `master_provinsi` VALUES (28, 'Sulawesi Selatan');
INSERT INTO `master_provinsi` VALUES (29, 'Sulawesi Tengah');
INSERT INTO `master_provinsi` VALUES (30, 'Sulawesi Tenggara');
INSERT INTO `master_provinsi` VALUES (31, 'Sulawesi Utara');
INSERT INTO `master_provinsi` VALUES (32, 'Sumatera Barat');
INSERT INTO `master_provinsi` VALUES (33, 'Sumatera Selatan');
INSERT INTO `master_provinsi` VALUES (34, 'Sumatera Utara');
COMMIT;

-- ----------------------------
-- Table structure for master_tiket
-- ----------------------------
DROP TABLE IF EXISTS `master_tiket`;
CREATE TABLE `master_tiket` (
  `tiket_id` int(11) NOT NULL AUTO_INCREMENT,
  `tiket_order_id` varchar(255) NOT NULL,
  `tiket_status` enum('pending','failed','success') NOT NULL DEFAULT 'pending',
  `tiket_user` int(11) DEFAULT NULL,
  `tiket_data` text DEFAULT NULL,
  `tiket_amount` varchar(255) DEFAULT NULL,
  `tiket_price` varchar(255) DEFAULT NULL,
  `tiket_discount` varchar(255) DEFAULT NULL,
  `tiket_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`tiket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of master_tiket
-- ----------------------------
BEGIN;
INSERT INTO `master_tiket` VALUES (1, 'SBKVC000002723', 'pending', 2, '[{\"kategori\":\"1\",\"nama_kategori\":\"10K UMUM\",\"price\":\"300000\",\"id_user\":\"2\",\"id_pelari\":\"1\",\"nama\":\"Andreas Septian Adi\"},{\"kategori\":\"3\",\"nama_kategori\":\"10K Difabel\",\"price\":\"0\",\"id_user\":\"3\",\"id_pelari\":\"2\",\"nama\":\"Andreas Septian Adi\"},{\"kategori\":\"2\",\"nama_kategori\":\"10K PELAJAR\",\"price\":\"0\",\"id_user\":\"4\",\"id_pelari\":\"3\",\"nama\":\"asdasd\"}]', '3', '300000', NULL, '2024-10-10 11:42:00');
COMMIT;

-- ----------------------------
-- Table structure for master_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `master_transaksi`;
CREATE TABLE `master_transaksi` (
  `transaksi_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_status` varchar(255) DEFAULT NULL,
  `transaksi_order_id` varchar(255) DEFAULT NULL,
  `transaksi_type` varchar(255) DEFAULT NULL,
  `transaksi_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transaksi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for master_user
-- ----------------------------
DROP TABLE IF EXISTS `master_user`;
CREATE TABLE `master_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_status` int(11) NOT NULL DEFAULT 1,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_last_login` datetime DEFAULT current_timestamp(),
  `user_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_forgot` varchar(255) DEFAULT NULL,
  `user_is` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of master_user
-- ----------------------------
BEGIN;
INSERT INTO `master_user` VALUES (1, 1, 'kedirihaldmarathon@gmail.com', '0b1ec80dfa93a3abdd9c52fe4391fbfb', '2024-10-10 11:36:14', '2024-03-10 13:15:30', NULL, 'admin');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
