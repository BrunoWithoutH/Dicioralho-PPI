<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../src/config/pg_config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dicioralho</title>
    <meta name="description" content="Um dicionário de gírias e palavrões">
    <meta name="keywords" content="dicionário, gírias, palavrões, português, Brasil">
    <link rel="icon" type="image/x-icon" href="../public/assets/favicon/favicon.ico">
    <link rel="stylesheet" href="../public/assets/css/stylegeral.css">
</head>
<body>
<div class="form">
    <span class="title">Entrar</span>

    <form action="../src/function/testlogin.php" method="POST">
        <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : ''; ?>">
                    
        <div class="input-field">
            <input type="text" name="email" placeholder="Insira seu email" required>
            <i class="uil uil-envelope icon"></i>
        </div>
                    
        <div class="input-field">
            <input type="password" name="senha" class="password" placeholder="Insira sua senha" required>
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
        </div>

                    <!-- Quando eu tiver mais tempo, vou trabalhar nisso -->
                    <!-- <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" name="ULembrar">
                            <label for="lembrar" class="text">Lembrar-me</label>
                        </div> 
                        <a href="#" class="text">Esqueceu sua senha?</a>
                    </div> -->

        <div class="input-field button">
            <input type="submit" name="submit" value="Entrar">
        </div>
                    
        <div class="login-signup">
            <span class="text">Não tem uma conta?
                <a href="signup.php">Cadastre-se Agora</a>
            </span>
        </div>
    </form>
</div>