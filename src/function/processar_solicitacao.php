<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../src/config/pg_config.php');

if (!isset($_SESSION['EmailUsuario'])) {
    header('Location: ../login.php');
    exit;
}

$email = $_SESSION['EmailUsuario'];
$stmt = $pdo->prepare("SELECT nivelusuario FROM usuarios WHERE emailusuario = :email");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['nivelusuario'] != 3) {
    echo "Acesso restrito.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idusuario']) && isset($_POST['action'])) {
    $idusuario = $_POST['idusuario'];
    $action = $_POST['action'];
    
    if ($action === 'aprovar') {
        $status = 'ativo';
        $mensagem = 'Usuário aprovado com sucesso!';
    } else {
        $status = 'desativado';
        $mensagem = 'Usuário rejeitado com sucesso!';
    }

    $stmt = $pdo->prepare("UPDATE usuarios SET status = :status WHERE idusuario = :idusuario");
    $stmt->execute([':status' => $status, ':idusuario' => $idusuario]);

    $_SESSION['mensagem'] = $mensagem;
    header('Location: ../admin/usuarios.php');
    exit;
}

$stmt = $pdo->prepare("SELECT idusuario, emailusuario, nomeusuario FROM usuarios WHERE status = 'pendente'");
$stmt->execute();
$usuariosPendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gerenciar Usuários</title>
    <link rel="stylesheet" href="../../src/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Usuários Pendentes</h1>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['mensagem'] ?>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuariosPendentes as $usuario): ?>
                    <tr>
                        <td><?= $usuario['idusuario'] ?></td>
                        <td><?= $usuario['emailusuario'] ?></td>
                        <td><?= $usuario['nomeusuario'] ?></td>
                        <td>
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="idusuario" value="<?= $usuario['idusuario'] ?>">
                                <input type="hidden" name="action" value="aprovar">
                                <button type="submit" class="btn btn-success">Aprovar</button>
                            </form>
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="idusuario" value="<?= $usuario['idusuario'] ?>">
                                <input type="hidden" name="action" value="rejeitar">
                                <button type="submit" class="btn btn-danger">Rejeitar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>