<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=pos",
			            "ss_admin",
			            "2903vane");

		$link->exec("set names utf8");

		return $link;

	}

}