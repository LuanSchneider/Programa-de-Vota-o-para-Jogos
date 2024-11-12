<?php
session_start();

$conn = mysqli_connect("localhost", "admin", "admin", "avaliajogos");

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Preencha todos os campos";
    } else {
        $senhaHash = hash('sha256', $senha);

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        
        
        if ($stmt->execute()) {
            header("Location: ../index.html");
            exit;
        } else {
            echo "Erro ao cadastrar usuário";
        }

        $stmt->close();
    }
}

$conn->close();
?>
