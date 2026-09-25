<?php
require_once("conexao.php");

$id = $_GET['cd'] ?? null;

if (!$id) {
    header("Location: professores.php");
    exit;
}

$sql_reservas = "DELETE FROM reservas WHERE id_professor= ?";
$stmt_reservas = mysqli_prepare($conexao, $sql_reservas);
mysqli_stmt_bind_param($stmt_reservas, "i", $id);
mysqli_stmt_execute($stmt_reservas);


$sql = "DELETE FROM professores WHERE cd_professor = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: professores.php?msg=excluido");
    exit;
} else {
    echo "Erro ao excluir o laboratório: " . mysqli_error($conexao);
}
?>