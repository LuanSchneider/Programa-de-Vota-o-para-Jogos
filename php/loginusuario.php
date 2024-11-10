<?php
session_start();

$conn = mysqli_connect("localhost", "admin", "admin", "avaliajogos");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$nome_usuario = $_POST['usuario_nome'];
$senha_usuario = $_POST['usuario_senha'];

$sql = "SELECT * FROM usuarios WHERE nome = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nome_usuario, $senha_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../votacao.php");
    exit();
} else {
    echo "<script>alert('Nome de usuário ou senha incorretos'); window.location.href='../index.html';</script>";
}

$stmt->close();
$conn->close();
?>
