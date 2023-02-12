/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100427
 Source Host           : localhost:3306
 Source Schema         : prova_curso_rbm_2023_1

 Target Server Type    : MySQL
 Target Server Version : 100427
 File Encoding         : 65001

 Date: 09/02/2023 16:08:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `CPF` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NOME` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DATA_NASCIMENTO` datetime NULL DEFAULT NULL,
  `CELULAR` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `RENDA_MENSAL` decimal(10, 2) NULL DEFAULT NULL,
  `DATA_HORA_INSERT` timestamp NULL DEFAULT current_timestamp,
  PRIMARY KEY (`ID`, `CPF`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for emprestimos
-- ----------------------------
DROP TABLE IF EXISTS `emprestimos`;
CREATE TABLE `emprestimos`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_CLIENTE` int NULL DEFAULT NULL,
  `VALOR_TOTAL_FINANCIADO` decimal(10, 2) NULL DEFAULT NULL,
  `VALOR_SOLICITADO` decimal(10, 2) NULL DEFAULT NULL,
  `QUANTIDADE_PARCELAS` decimal(10, 2) NULL DEFAULT NULL,
  `VALOR_PARCELA` decimal(10, 2) NULL DEFAULT NULL,
  `VALOR_IOF` decimal(10, 2) NULL DEFAULT NULL,
  `VALOR_TARIFA_CADASTRO` decimal(10, 2) NULL DEFAULT NULL,
  `DATA_HORA_INSERT` timestamp NULL DEFAULT current_timestamp,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for parcelas
-- ----------------------------
DROP TABLE IF EXISTS `parcelas`;
CREATE TABLE `parcelas`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_EMPRESTIMO` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `VALOR_PARCELA` decimal(10, 2) NULL DEFAULT NULL,
  `STATUS_PAGAMENTO` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `VENCIMENTO` datetime NULL DEFAULT NULL,
  `DATA_HORA_INSERT` timestamp NULL DEFAULT current_timestamp,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `ID` int NOT NULL AUTO_INCREMENT,
  `CPF` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NOME` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `SENHA` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `DATA_HORA_INSERT` timestamp NULL DEFAULT current_timestamp,
  PRIMARY KEY (`ID`, `CPF`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
