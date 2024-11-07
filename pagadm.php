<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admvisual.css">
</head>
<body>

<?php
include("php/conectadb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    
    $stmt = $conn->prepare("SELECT email, senha FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Informações Adicionais</h2>";
        echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
        echo "<p>Senha: " . htmlspecialchars($row['senha']) . "</p>";
    } else {
        echo "<p>Usuário não encontrado.</p>";
    }
    
    $stmt->close();
    $conn->close();
    exit();
}

$query = "SELECT nome FROM usuarios";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erro ao executar a consulta: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='user-info'>";
    echo "<div class='nome'>" . htmlspecialchars($row['nome']) . "</div>";
    echo "<button onclick='mostrarInformacoes(\"" . htmlspecialchars($row['nome']) . "\")'>Ver Informações</button>";
    echo "</div>";
}
?>

<div id="popup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:#fff; padding:20px; border:1px solid #ddd; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
    <button onclick="fecharPopup()">Fechar</button>
</div>

<script>
    function mostrarInformacoes(nome) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('popup').innerHTML = xhr.responseText + '<button onclick="fecharPopup()">Fechar</button>';
                document.getElementById('popup').style.display = 'block';
            }
        };
        xhr.send('nome=' + encodeURIComponent(nome));
    }

    function fecharPopup() {
        document.getElementById('popup').style.display = 'none';
    }
</script>

</body>
</html>
