-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:106
-- Generation Time: Jun 01, 2021 at 10:14 AM
-- Server version: 8.0.11
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



drop database voyage;

CREATE DATABASE voyage;
use voyage ; 

drop table if exists continent;

CREATE TABLE continent
(idcon integer not null AUTO_INCREMENT primary key, nomcon VARCHAR(10)) ;

drop table if exists pays;

CREATE TABLE pays
(idpay integer not null AUTO_INCREMENT primary key, nompay VARCHAR(10), idcon integer,
foreign key (idcon) references continent(idcon)) ;

drop table if exists ville;

CREATE TABLE ville
(idvil integer not null AUTO_INCREMENT primary key, nomvil VARCHAR(10), descvil VARCHAR(255), idpay integer,
foreign key (idpay) references pays(idpay)) ;

drop table if exists sites;

CREATE TABLE sites
(idsit integer not null AUTO_INCREMENT primary key, nomsit VARCHAR(10), cheminphoto VARCHAR(255), idvil integer,
foreign key (idvil) references ville (idvil)) ;

drop table if exists necessaire;

CREATE TABLE necessaire
(idnec integer not null AUTO_INCREMENT primary key, typenec VARCHAR(10), nomnec VARCHAR(20), idvil integer,
foreign key (idvil) references ville (idvil)) ;



insert into continent(nomCon) values("europe");
insert into pays(nompay,idcon) values("england", 1);

insert into pays(nompay,idcon) values("france", 1);

insert into continent(nomCon) values("afrique");
insert into pays(nompay,idcon) values("egypt", 2);

insert into ville(nomvil, descvil, idpay) values("al'qahira", "capitale de egypt", 3);
insert into necessaire(typenec,nomnec,idvil) values("hotel","collic", 1);
insert into necessaire(typenec,nomnec,idvil) values("hotel","bnabel", 1);
insert into necessaire(typenec,nomnec,idvil) values("restaurant","saedoun", 1);
insert into necessaire(typenec,nomnec,idvil) values("restaurant","sultane", 1);
insert into necessaire(typenec,nomnec,idvil) values("gare","metro", 1);
insert into necessaire(typenec,nomnec,idvil) values("airoport","national", 1);
insert into sites(nomsit,cheminphoto,idvil) values( "shibuya", "https://commons.wikimedia.org/wiki/File:Tokyo_Shibuya_Scramble_Crossing_2018-10-09.jpg", 1);
insert into sites(nomsit,cheminphoto,idvil) values( "nuit", "https://commons.wikimedia.org/wiki/File:Night_in_Luna_Park,_Coney_Island_(1905).jpg", 1);
insert into sites(nomsit,cheminphoto,idvil) values( "mosque", "https://commons.wikimedia.org/wiki/File:KotaKinabalu_Sabah_CityMosque-08.jpg", 1);
insert into sites(nomsit,cheminphoto,idvil) values( "university", "https://commons.wikimedia.org/wiki/File:Administration_building,_Future_University_in_Egypt_(New_Cairo,_Egypt,_28_September_2008).jpg", 1);
insert into pays(nompay,idcon) values("wwwww", 1);
insert into ville(nomvil, descvil, idpay) values("wwww", "ewqtewtweqwrewret", 2);
insert into necessaire(typenec,nomnec,idvil) values("hotel","wqrewqrwq", 2);
insert into necessaire(typenec,nomnec,idvil) values("hotel","ggggggggggg", 2);
insert into necessaire(typenec,nomnec,idvil) values("restaurant","segfdsgfds", 2);
insert into necessaire(typenec,nomnec,idvil) values("gare","dsfgdsgdsg", 2);
insert into sites(nomsit,cheminphoto,idvil) values( "", "", 2);
