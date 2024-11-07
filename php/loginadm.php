<?php
$conn = mysqli_connect("localhost", "admin", "admin", "avaliajogos");


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$senha = $_POST['senha'];

if (empty($nome) || empty($senha)) {
    $_SESSION['erro'] = "Preencha todos os campos!";
    header("Location: ../index.html");
} else {
    $sql = "SELECT * FROM admin WHERE nome='$nome' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: ../pagadm.php");
    } else {
        $_SESSION['erro'] = "E-mail ou senha incorretos!";
        header("Location: ../index.html");
    }
}
$conn->close();
?>