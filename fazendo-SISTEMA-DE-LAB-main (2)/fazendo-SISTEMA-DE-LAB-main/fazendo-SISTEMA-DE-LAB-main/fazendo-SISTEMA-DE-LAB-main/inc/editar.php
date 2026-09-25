<?php
require_once("conexao.php");

$id = $_GET['cd'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}


$sql = "SELECT * FROM labs WHERE cd_lab = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$lab = mysqli_fetch_assoc($resultado);

if (!$lab) {
    header("Location: index.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nr_lab = $_POST['nr_lab'] ?? '';

    $sql = "UPDATE labs SET nr_lab = ? WHERE cd_lab = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nr_lab, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?msg=editado");
        exit;
    } else {
        $erro = "Erro ao atualizar: " . mysqli_error($conexao);
    }
}

$pagina = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Laboratório</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #0a192f;
            min-height: 100vh;
            overflow-x: hidden;
            padding-top: 56px;
        }
        .navbar {
            background-color: #112240 !important;
            height: 56px;
        }
        .sidebar {
            width: 250px;
            height: calc(100vh - 56px);
            background-color: #112240;
            position: fixed;
            top: 56px;
            left: 0;
            border-right: 1px solid #1e3a5f;
        }
        .sidebar .nav-link {
            color: #a8b2d1;
            padding: 12px 20px;
            margin: 4px 10px;
            border-radius: 8px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #1e3a5f;
            color: #ffffff;
        }
        .main-content {
            margin-left: 250px;
            padding: 25px 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        }
        .card-header {
            background: linear-gradient(135deg, #1e90ff, #0066cc);
            border: none;
            padding: 16px 24px;
            color: white;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 14px;
        }
        .btn-salvar {
            background: linear-gradient(135deg, #1e90ff, #0066cc);
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-salvar:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container-fluid px-3">
            <a class="navbar-brand fw-bold" href="#">Sistema de Labs</a>
            <div class="ms-auto">
                <a class="nav-link text-white" href="#">Sair</a>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <ul class="nav flex-column pt-3">
            <li class="nav-item">
                <a class="nav-link <?= $pagina == 'index.php' ? 'active' : '' ?>" href="index.php">Laboratórios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="turma.php">Turmas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reserva.php">Reservas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="professores.php">Professores</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Editar Laboratório</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (isset($erro)): ?>
                            <div class="alert alert-danger"><?= $erro ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Número do Laboratório</label>
                                <input type="text" 
                                       name="nr_lab" 
                                       class="form-control" 
                                       value="<?= htmlspecialchars($lab['nr_lab']) ?>" 
                                       required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-salvar">
                                    Salvar Alterações
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>