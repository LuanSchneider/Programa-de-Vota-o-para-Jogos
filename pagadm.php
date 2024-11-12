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
</div>

<button id="botaoAdicionarImagem" onclick="abrirPopupImagem()">Criar uma postagem</button>


<div id="popup-imagem" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:#fff; padding:20px; border:1px solid #ddd; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
    <h2>Adicionar Imagem</h2>
    <form id="formImagem" enctype="multipart/form-data">
        <input type="file" id="imagemInput" name="imagem" accept="image/*" onchange="previewImagem()"><br><br>
        <input type="text" id="descricaoInput" name="descricao" placeholder="Descrição"><br><br>
        <div id="imagePreview" class="image-preview"></div>
        <button type="button" onclick="abrirPopupImagem()">salvar</button>
        <button type="button" onclick="postarImagem()">Postar</button>
        <button type="button" onclick="fecharPopupImagem()">Fechar</button>
    </form>
</div>

<script>
    function mostrarInformacoes(nome) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var popup = document.getElementById('popup');
                popup.innerHTML = xhr.responseText + '<button onclick="fecharPopup()">Fechar</button>';
                popup.style.display = 'block';
            }
        };
        xhr.send('nome=' + encodeURIComponent(nome));
    }

    function fecharPopup() {
        document.getElementById('popup').style.display = 'none';
    }

    function abrirPopupImagem() {
        document.getElementById('popup-imagem').style.display = 'block';
    }

    function fecharPopupImagem() {
        document.getElementById('popup-imagem').style.display = 'none';
        document.getElementById('imagePreview').innerHTML = '';
    }

    function previewImagem() {
        var imagemInput = document.getElementById('imagemInput').files[0];
        var descricaoInput = document.getElementById('descricaoInput').value;
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = '';

        if (imagemInput) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var card = document.createElement('div');
                card.classList.add('card');
                
                var img = document.createElement('img');
                img.src = e.target.result;
                card.appendChild(img);
                
                var description = document.createElement('div');
                description.classList.add('description');
                description.textContent = descricaoInput || 'Sem descrição';
                card.appendChild(description);
                
                imagePreview.appendChild(card);
            };
            reader.readAsDataURL(imagemInput);
        }
    }

    function postarImagem() {
        var formData = new FormData(document.getElementById('formImagem'));
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/salvar_imagem.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Imagem postada com sucesso!');
                fecharPopupImagem();
            }
        };
        xhr.send(formData);
    }
</script>

</body>
</html>
