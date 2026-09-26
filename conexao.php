<?php

$conexao = new mysqli(
    "localhost",
    "root",
    "usbw",
    "labs"
);

if ($conexao->connect_error) {
    die("Erro na conexão com o banco.");
}

$conexao->set_charset("utf8");

?>
