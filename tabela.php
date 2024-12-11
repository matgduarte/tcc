<?php
require_once 'includes/conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// Definindo parâmetros de paginação
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 15; // Inicialmente 15 itens

// Consulta SQL para buscar os dados
$sql = "SELECT ID_Dados, ID_Sensor, Valor_Dados, Data_Dados FROM Dados LIMIT ?, ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Obtendo os dados
$dadosExibidos = [];
while ($row = $result->fetch_assoc()) {
    $dadosExibidos[] = $row;
}

// Retorna os dados em formato JSON (para a requisição AJAX)
if (isset($_GET['ajax'])) {
    echo json_encode($dadosExibidos);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Página de tabela para exibição de dados dinâmicos" />
    <meta name="keywords" content="tabela, dados, paginação, PHP, SQL" />

    <link rel="stylesheet" href="css/header_footer.css" />
    <link rel="stylesheet" href="css/tabela.css" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Tabela Dinâmica</title>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="container">
        <header>
            <div class="a_pagina_tabela"></div>
            <div class="logo">
                <h1>ECO</h1>
            </div>
            <div class="a_pagina_tabela">
                <a href="index.php">INÍCIO</a>
            </div>
        </header>
        <main>
            <div class="table-container">
                <h2 class="table-title">Dados Climáticos</h2>
                <table id="dynamicTable">
                    <thead>
                        <tr>
                            <th>ID Dados</th>
                            <th>ID Sensor</th>
                            <th>Valor Dados</th>
                            <th>Data Dados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dadosExibidos as $linha) {
                            echo "<tr data-valor='{$linha['Valor_Dados']}'>";
                            echo "<td>{$linha['ID_Dados']}</td>";
                            echo "<td>{$linha['ID_Sensor']}</td>";
                            echo "<td class='valor-dados'>{$linha['Valor_Dados']}</td>";
                            echo "<td>{$linha['Data_Dados']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button id="loadMoreBtn" data-offset="<?= $offset + $limit ?>">Carregar mais</button>
            </div>
        </main>
    </div>

    <script src="js/tabela.js"></script>
</body>

</html>


