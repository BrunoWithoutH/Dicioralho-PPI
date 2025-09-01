<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../config/pg_config.php");

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE emailusuario = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senhausuario'])) {
        session_start();
        $_SESSION['EmailUsuario'] = $user['emailusuario'];
        $_SESSION['NomeUsuario'] = $user['nomeusuario'];
        $_SESSION['IdUsuario'] = $user['idusuario'];

        $redirectUrl = $_SESSION['previous_page'] ?? '../../public/index.php';
        unset($_SESSION['previous_page']);
        header('Location: ' . $redirectUrl);
        exit();
    } else {
        echo "Credenciais inválidas.";
    }
} else {
    echo "Formulário incompleto.";
}