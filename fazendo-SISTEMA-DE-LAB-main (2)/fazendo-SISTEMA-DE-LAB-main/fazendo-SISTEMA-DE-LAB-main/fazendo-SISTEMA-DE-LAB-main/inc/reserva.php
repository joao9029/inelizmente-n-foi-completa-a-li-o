<?php 
require_once("conexao.php");

$id = $_GET['cd'] ?? null;

if ($id) {
    $sql = "SELECT * FROM reservas WHERE cd_reserva = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM reservas";
    $resultado = mysqli_query($conexao, $sql);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professores</title>
    
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
            z-index: 1030;
        }

        .sidebar {
            width: 250px;
            height: calc(100vh - 56px);
            background-color: #112240;
            position: fixed;
            top: 56px;
            left: 0;
            border-right: 1px solid #1e3a5f;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #a8b2d1;
            padding: 12px 20px;
            margin: 4px 10px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #1e3a5f;
            color: #ffffff;
        }

        .main-content {
            margin-left: 250px;
            padding: 25px 30px;
            min-height: calc(100vh - 56px);
        }

        .card {
            border: none;
            border-radius: 12px;
            background-color: #ffffff;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        }

        .card-header {
            background: linear-gradient(135deg, #1e90ff, #0066cc);
            border: none;
            padding: 16px 24px;
        }

        .card-header h4 {
            font-weight: 600;
            letter-spacing: 0.3px;
            margin: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #1a365d;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.6px;
            padding: 14px 20px;
            border: none;
        }

        .table tbody td {
            padding: 14px 20px;
            vertical-align: middle;
            border-color: #eef2f7;
            color: #2d3748;
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: background-color 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: #ebf8ff !important;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: #f8fafc;
        }

        .badge-id {
            background-color: #ebf8ff;
            color: #2b6cb0;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
        }

        .btn-action {
            padding: 5px 12px;
            font-size: 0.82rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-novo {
            background-color: #ffffff;
            color: #0066cc;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-novo:hover {
            background-color: #e6f0ff;
            color: #004d99;
        }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
            color: #718096;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container-fluid px-3">
            <a class="navbar-brand fw-bold" href="#">Sistema de Labs</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   <div class="sidebar">
    <ul class="nav flex-column pt-3">
        <li class="nav-item">
            <a class="nav-link " href="index.php">
                Laboratórios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="turma.php">
                Turmas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $pagina == 'reserva.php' ? 'active' : '' ?>" href="reserva.php">
                Reservas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="professores.php">
                Professores
            </a>
        </li>
    </ul>
</div>

    <div class="main-content">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Lista de Professores</h4>
                        <a href="cadastrar_professor.php" class="btn btn-novo">
                             Novo Professor
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <?php if (mysqli_num_rows($resultado) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px;">ID</th>
                                            <th>professores</th>
                                            <th>turma</th>
                                            <th>lab</th>
                                            <th>entrada</th>
                                            <th>saida</th>
                                            <th>Descrição</th>
                                            <th style="width: 180px;" class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge-id">
                                                        <?= htmlspecialchars($linha['cd_reserva']) ?>
                                                    </span>
                                                </td>
                                                <td class="fw-medium">
                                                    <?= htmlspecialchars($linha['id_professor']) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($linha['id_turma']) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($linha['id_lab']) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($linha['hr_inicio']) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($linha['hr_saida']) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($linha['ds_reserva']) ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="editar.php?cd=<?= $linha['cd_reserva'] ?>" 
                                                       class="btn btn-outline-primary btn-action me-1">
                                                        Editar
                                                    </a>
                                                    <a href="excluir.php?cd=<?= $linha['cd_reserva'] ?>" 
                                                       class="btn btn-outline-danger btn-action"
                                                       onclick="return confirm('Tem certeza que deseja excluir este professor?')">
                                                        Excluir
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                
                                <h5>Nenhuma reserva encontrada</h5>
                                <p class="mb-0">Não há registros para exibir no momento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>