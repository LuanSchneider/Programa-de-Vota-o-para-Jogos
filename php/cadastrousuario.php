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
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos";
    } else {
        $senhaHash = hash('sha256', $senha);

        $stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $senhaHash);

        if ($stmt->execute()) {
            header("Location: ../loginusuarios.html");
        } else {
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
