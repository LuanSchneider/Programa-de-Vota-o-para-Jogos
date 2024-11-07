<?php
$host = "localhost";
$user = "admin";
$password = "admin";
$dbname = "avaliajogos";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos";
    } else {
        $senhaHash = hash('sha256', $senha);

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        
        if ($stmt->execute()) {
            header("Location: ../index.html");
            exit;
        } else {
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }
        
        $stmt->close();
        
    }}
$conn->close();
?>