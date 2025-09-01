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

$stmtPendentes = $pdo->query("SELECT idusuario, nomeusuario, emailusuario, instituicaousuario, registrousuario, nivelusuario 
                             FROM usuarios 
                             WHERE statususuario = 'pendente'
                             ORDER BY registrousuario ASC");
$usuariosPendentes = $stmtPendentes->fetchAll(PDO::FETCH_ASSOC);
$totalPendentes = count($usuariosPendentes);

$stmt = $pdo->query("SELECT idusuario, nomeusuario, emailusuario, nivelusuario 
                     FROM usuarios 
                     WHERE statususuario = 'ativo'
                     ORDER BY nivelusuario DESC, nomeusuario ASC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tipos = [
    3 => 'Administradores',
    2 => 'Professores',
    1 => 'Alunos',
    0 => 'Visitantes'
];
$usuariosPorTipo = [3 => [], 2 => [], 1 => [], 0 => []];
foreach ($usuarios as $u) {
    $nivel = (int)$u['nivelusuario'];
    $usuariosPorTipo[$nivel][] = $u;
}
if (isset($_SESSION['EmailUsuario'])) {
    $email = $_SESSION['EmailUsuario'];
    $stmt = $pdo->prepare("SELECT nomeusuario, nivelusuario FROM usuarios WHERE EmailUsuario = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $nomeusuario = $user ? $user['nomeusuario'] : 'Usuário';
    if ($user['nivelusuario'] == 3) {
        $nivelusuario = 'Administrador';
    } elseif ($user['nivelusuario'] == 2) {
        $nivelusuario = 'Professor';
    } elseif ($user['nivelusuario'] == 1) {
        $nivelusuario = 'Aluno';
    } else {
        $nivelusuario = 'Usuario Visitante';
    }
} else {
    $email = false;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/gerenciar.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <section class="header">
                    <nav>
                        <a href="../index.php"><img src="assets/img/logo.png" alt="Dicioralho" class="logo"></a>
                        <?php switch ($nivelusuario ?? '') {
                            case 'Administrador': ?>
                                <div class="dropdown">
                                    <button class="dropbtn">Administrador<i class="uil uil-angle-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="admin/gerenciarusuarios.php" class="NavItem">Gerenciar usuarios</a>
                                        <a href="admin/gerenciarpalavras.php" class="NavItem">Gerenciar palavras</a>
                                        <a href="admin/gerenciarcategorias.php" class="NavItem">Gerenciar categorias</a>
                                        <a href="admin/gerenciarinstituicoes.php" class="NavItem">Gerenciar instituições</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="dropbtn">Palavras<i class="uil uil-angle-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="gerenciarpalavras.php" class="NavItem">gerenciar palavras</a>
                                        <a href="adicionarpalavras.php" class="NavItem">Adicionar Palavras</a>
                                    </div>
                                </div>
                            <?php
                                break;
                            case 'Professor': ?>
                                <div class="dropdown">
                                    <button class="dropbtn">Professor<i class="uil uil-angle-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="gerenciarturmas.php" class="NavItem">Gerenciar Turmas</a>
                                        <a href="gerenciartarefas.php" class="NavItem">Gerenciar Tarefas</a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="dropbtn">Palavras<i class="uil uil-angle-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="gerenciarpalavras.php" class="NavItem">gerenciar palavras</a>
                                        <a href="adicionarpalavras.php" class="NavItem">Adicionar Palavras</a>
                                    </div>
                                </div>
                            <?php
                                break;
                            case 'Aluno': ?>
                                <div class="dropdown">
                                    <button class="dropbtn">Aluno<i class="uil uil-angle-down"></i></button>
                                    <div class="dropdown-content">
                                        <a href="gerenciarturmas.php" class="NavItem">Turma</a>
                                        <a href="gerenciartarefas.php" class="NavItem">Tarefas</a>
                                    </div>
                                </div>
                            <?php
                                break;
                            case 'Usuario Visitante':
                                default:
                                break;
                        } ?>

                        <div class="usersection">
                            <?php if ($email): ?>
                                <div class="dropdown" style="float:right;">
                                    <button class="dropbtnimg"><img class="userimage" src="assets/img/userdefault.svg" alt="user"></button>
                                    <div class="dropdown-content" style="right: 0;">
                                        <a href="" class="NavItem">Configurações</a>
                                        <a href="../../src/function/logout.php">Sair</a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="login.php"><button class="LogButton">Entrar</button></a>
                            <?php endif; ?>
                        </div>

                    </nav>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <section class="gerenciar-usuarios">
                    <div class="header-with-notification">
                        <h2>Gerenciar Usuários</h2>
                        <?php if ($totalPendentes > 0): ?>
                            <a href="#" class="notification-badge" id="mostrarPendentes">
                                <?php echo $totalPendentes; ?> solicitação(ões)
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div id="pendentesModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h3>Solicitações Pendentes</h3>
                            <?php if ($totalPendentes > 0): ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Instituição</th>
                                            <th>Nível</th>
                                            <th>Data</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuariosPendentes as $pendente): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($pendente['nomeusuario']); ?></td>
                                                <td><?php echo htmlspecialchars($pendente['emailusuario']); ?></td>
                                                <td><?php echo htmlspecialchars($pendente['instituicaousuario'] ?? '-'); ?></td>
                                                <td><?php echo $tipos[$pendente['nivelusuario']] ?? 'Visitante'; ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($pendente['registrousuario'])); ?></td>
                                                <td>
                                                    <form action="../../src/function/processar_solicitacao.php" method="post" style="display:inline;">
                                                        <input type="hidden" name="idusuario" value="<?php echo $pendente['idusuario']; ?>">
                                                        <button type="submit" name="action" value="aprovar" class="btn-aprovar">Aprovar</button>
                                                        <button type="submit" name="action" value="rejeitar" class="btn-rejeitar">Rejeitar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Não há solicitações pendentes.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    

                    <div class="container mt-4" id="tipo-usuario-selector">
                        <h2>Selecione o tipo de usuário</h2>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="user-type-card card-select" data-tipo="3">
                                    <img src="../assets/img/admin.svg" alt="Administrador" class="user-type-img">
                                    <h4>Administradores</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="user-type-card card-select" data-tipo="2">
                                    <img src="../assets/img/professor.svg" alt="Professor" class="user-type-img">
                                    <h4>Professores</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="user-type-card card-select" data-tipo="1">
                                    <img src="../assets/img/aluno.svg" alt="Aluno" class="user-type-img">
                                    <h4>Alunos</h4>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="user-type-card card-select" data-tipo="0">
                                    <img src="../assets/img/visitante.svg" alt="Visitante" class="user-type-img">
                                    <h4>Visitantes</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-4" id="usuarios-lista" style="display:none;">
                        <button class="btn btn-secondary mb-3" id="voltar-tipos">Voltar</button>
                        <div class="row" id="usuarios-cards"></div>
                    </div>
                </section>
            </div>
        </div>
        
    </div>
    <script>
    const usuariosPorTipo = <?php echo json_encode($usuariosPorTipo); ?>;
</script>
<script src="../assets/js/usuarios.js"></script>
</body>
</html>