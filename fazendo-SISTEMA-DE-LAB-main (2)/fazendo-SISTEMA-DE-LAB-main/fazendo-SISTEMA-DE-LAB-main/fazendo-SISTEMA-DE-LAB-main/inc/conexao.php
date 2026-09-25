<?php
$servidor = "127.0.0.1";
$usuario  = "root";
$senha    = "";
$banco    = "laboratorio";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conexao, "utf8mb4");
?>