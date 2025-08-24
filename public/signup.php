<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../src/config/pg_config.php");
require '../vendor/autoload.php'; // Isso aq é o Nanoid, uma biblioteca pra gerar IDs únicos que eu achei
use Hidehalo\Nanoid\Client;

if (isset($_POST["submit"])) {

    if ($_POST["senha"] === $_POST["confirmsenha"]) {
        $nome  = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Isso aqui é pra criptografar a senha antes de salvar no banco

        $client = new Client();
        $user_id = $client->generateId(12); // Isso aquei gera um ID único com 12 caracteres

        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (id, nomeusuario, emailusuario, senhausuario) 
                                   VALUES (:id, :nome, :email, :senha)");
            $stmt->bindParam(':id', $user_id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_hash);

            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    } else {
        echo "As senhas não coincidem";
    }
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
    <link rel="stylesheet" href="../public/assets/css/stylegeral.css">
    <title>Cadastro | Dicioralho</title>
</head>
<body>
    <form action="signup.php" method="POST">
        <div class="input-field">
            <input type="text" name="nome" placeholder="Insira seu nome" required>
            <i class="uil uil-user"></i>
        </div>
        <div class="input-field">
            <input type="email" name="email" placeholder="Insira seu email" required>
            <i class="uil uil-envelope icon"></i>
        </div>
        <div class="input-field">
            <input type="password" name="senha" class="password" placeholder="Crie uma senha" required>
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
        </div>
        <div class="input-field">
            <input type="password" name="confirmsenha" class="password" placeholder="Confirme sua senha" required>
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
        </div>
        <!-- Vou fazer depois
        <div class="checkbox-text">
            <div class="checkbox-content">
                <input type="checkbox" id="termCon">
                <label for="termCon" class="text">Li e aceito os <a href="eula.html">Termos e condições de Uso</a></label>
            </div>
        </div> -->
        <div class="input-field button">
            <input type="submit" name="submit" value="Cadastrar">
        </div>
        <div class="login-signup">
        <span class="text">Já tem uma conta? <a href="login.php">Entrar</a></span>
        </div>
    </form>
