<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
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
    <header>
        <h1>{logo}</h1>
        <h1>{nav_bar}</h1>
        <h1>{user}</h1>
        <a href="login.php">login</a>
    </header>
    <main>
        <div class="searchbar">
            <input type="text" placeholder="Buscar...">
            <button type="submit">Pesquisar</button>
        </div>
        <div class="content">
            <h1>Palavras recentes no Dicioralho</h1>
                <div class="recent-words">
                </div>
        </div>
        <div class="page-buttons">
            <button class="page-btn">Mais Curtidas</button>
            <button class="page-btn">Explorar</button>
            <button class="page-btn">Sugestões</button>
    </main>
    <footer>
        
    </footer>
</body>
</html>