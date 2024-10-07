<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancodedados";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consultar os dados da tabela 'gastos'
$sql = "SELECT valor, data_gasto, categoria, descricao, data_registro FROM gastos";
$result = $conn->query($sql);

echo "<h1>💼 Relatório de Gastos</h1>";

if ($result->num_rows > 0) {
    
    echo "<table>
            <tr>
                <th>Valor</th>
                <th>Data dos gastos</th>
                <th>Categoria</th>
                <th>Descrição</th>
                <th>Data de Registro</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='valor'>R$ " . number_format($row["valor"], 2, ',', '.') . "</td>
                <td class='data_gasto'>" . date('d/m/Y', strtotime($row["data_gasto"])) . "</td>
                <td class='categoria'>" . $row["categoria"]. "</td>
                <td class='descricao'>" . $row["descricao"]. "</td>
                <td class='data_registro'>" . date('d/m/Y H:i:s', strtotime($row["data_registro"])) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum resultado encontrado.</p>";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../php/pasta Dos CSS/pagina1.css">
    <title>Visualização dos gastos</title>
</head>
<body>
    <a href="pasta Dos HTML/paginaprincipal.html">Voltar para a página Principal</a>
</body>
</html>


