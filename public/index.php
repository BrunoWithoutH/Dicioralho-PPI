<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../src/config/pg_config.php');

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Um dicionário de gírias e palavrões">
    <meta name="keywords" content="dicionário, gírias, palavrões, português, Brasil">
    <link rel="icon" type="image/x-icon" href="../public/assets/favicon/favicon.ico">
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <title>Dicioralho</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <section class="header">
                    <nav>
                        <a href="index.php"><img src="assets/img/logo.png" alt="Dicioralho" class="logo"></a>
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
                                        <a href="../src/function/logout.php">Sair</a>
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
                <section class="palavras">
                    <h4>Palavras recentes no Dicioralho</h4>
                </section>
            </div>
        </div>
    </div>

    <footer class="textcenter footer">
        <p> PPI: Grupo 6</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>