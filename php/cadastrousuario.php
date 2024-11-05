
<?php
$host="localhost";
$user="admin";
$password="admin";
$dbname= "avaliajogos";

$conn = new mysqli($host,$user,$password,$dbname);  
$email = $_POST['email'];
$senha = $_POST['senha'];
 if($email == '' || $senha == ''){
     echo "Preencha todos os campos";
 }else{
     $sql = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senha')";
     if ($conn->query($sql) === TRUE) {
         echo "Usuário cadastrado com sucesso";
     } else {
         echo "Error: " . $sql . "<br>" . $conn->error;
     }
 }

?>