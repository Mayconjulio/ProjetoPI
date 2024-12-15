<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meubanco";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consultar os dados da tabela 'usuarios'
$sql = "SELECT id, nome, email, reg_date FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir os dados em uma tabela HTML
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Registro</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["nome"]. "</td>
                <td>" . $row["email"]. "</td>
                <td>" . $row["reg_date"]. "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

$conn->close();
?>
