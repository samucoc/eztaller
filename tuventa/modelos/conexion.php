<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=tuventa",
			            "root",
			            "ypUNvkW3MrM23s");

		$link->exec("set names utf8");

		return $link;

	}

}