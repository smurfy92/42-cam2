<?php

//user config
session_start();
$DB="camagru";
$DB_DSN = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "toto";

//connection to db creating it if not exists

//$sql="DROP DATABASE camagru"
$sql="CREATE DATABASE IF NOT EXISTS camagru";
$db = new PDO('mysql:host='.$DB_DSN, $DB_USER, $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$db->exec($sql);
$sql="use camagru";
$db->exec($sql);
