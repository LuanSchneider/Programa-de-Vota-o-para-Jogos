<?php
include("conectadb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se há arquivo de imagem enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $comentario = $_POST['descricao'];
        $imagem = $_FILES['imagem'];

        // Diretório onde as imagens serão armazenadas
        $diretorioDestino = '../uploads/';
        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true);
        }

        // Gerar nome único para a imagem
        $nomeImagem = uniqid() . '-' . basename($imagem['name']);
        $caminhoCompleto = $diretorioDestino . $nomeImagem;

        // Fazer upload da imagem
        if (move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
            // Caminho da imagem a ser salvo no banco de dados
            $caminhoBD = 'uploads/' . $nomeImagem;

            // Inserir os dados no banco de dados
            $stmt = $conn->prepare("INSERT INTO avaliacoes (imagem, comentario) VALUES (?, ?)");
            $stmt->bind_param("ss", $caminhoBD, $comentario);

            if ($stmt->execute()) {
                echo "Imagem e descrição salvas com sucesso!";
            } else {
                echo "Erro ao salvar no banco de dados: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Erro ao fazer o upload da imagem.";
        }
    } else {
        echo "Erro: Nenhuma imagem foi enviada.";
    }
}
?>
