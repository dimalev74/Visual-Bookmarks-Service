<?php session_start(); require_once "main.php"; require_once "start_mysql.php";
StartDB();
Add_group();
EndDB();
header("Location: edit_group.php");
