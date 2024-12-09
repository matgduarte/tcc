<?php
// Valores de teste
$valoresTeste = [
    ['Teste 1', 'Valor 1', 'Exemplo 1', 'Simulação 1', 'Dados 1'],
    ['Teste 2', 'Valor 2', 'Exemplo 2', 'Simulação 2', 'Dados 2'],
    ['Teste 3', 'Valor 3', 'Exemplo 3', 'Simulação 3', 'Dados 3'],
    ['Teste 4', 'Valor 4', 'Exemplo 4', 'Simulação 4', 'Dados 4'],
    ['Teste 5', 'Valor 5', 'Exemplo 5', 'Simulação 5', 'Dados 5'],
    ['Teste 6', 'Valor 6', 'Exemplo 6', 'Simulação 6', 'Dados 6'],
    ['Teste 7', 'Valor 7', 'Exemplo 7', 'Simulação 7', 'Dados 7'],
    ['Teste 8', 'Valor 8', 'Exemplo 8', 'Simulação 8', 'Dados 8'],
    ['Teste 9', 'Valor 9', 'Exemplo 9', 'Simulação 9', 'Dados 9'],
    ['Teste 10', 'Valor 10', 'Exemplo 10', 'Simulação 10', 'Dados 10'],
    ['Teste 11', 'Valor 11', 'Exemplo 11', 'Simulação 11', 'Dados 11'],
    ['Teste 12', 'Valor 12', 'Exemplo 12', 'Simulação 12', 'Dados 12'],
    ['Teste 13', 'Valor 13', 'Exemplo 13', 'Simulação 13', 'Dados 13'],
    ['Teste 14', 'Valor 14', 'Exemplo 14', 'Simulação 14', 'Dados 14'],
    ['Teste 15', 'Valor 15', 'Exemplo 15', 'Simulação 15', 'Dados 15'],
    ['Teste 16', 'Valor 16', 'Exemplo 16', 'Simulação 16', 'Dados 16'],
    ['Teste 17', 'Valor 17', 'Exemplo 17', 'Simulação 17', 'Dados 17'],
    ['Teste 18', 'Valor 18', 'Exemplo 18', 'Simulação 18', 'Dados 18'],
    ['Teste 19', 'Valor 19', 'Exemplo 19', 'Simulação 19', 'Dados 19'],
    ['Teste 20', 'Valor 20', 'Exemplo 20', 'Simulação 20', 'Dados 20'],
    ['Teste 21', 'Valor 21', 'Exemplo 21', 'Simulação 21', 'Dados 21'],
    ['Teste 22', 'Valor 22', 'Exemplo 22', 'Simulação 22', 'Dados 22'],
    ['Teste 23', 'Valor 23', 'Exemplo 23', 'Simulação 23', 'Dados 23'],
    ['Teste 24', 'Valor 24', 'Exemplo 24', 'Simulação 24', 'Dados 24'],
    ['Teste 25', 'Valor 25', 'Exemplo 25', 'Simulação 25', 'Dados 25'],
];

// Definindo parâmetros de paginação
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 15; // Inicialmente 15 itens

// Pega uma parte dos valores de teste com base no offset e limite
$dadosExibidos = array_slice($valoresTeste, $offset, $limit);

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
    <!-- Incluindo a biblioteca Ionicons -->
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
                <table id="dynamicTable">
                    <thead>
                        <tr>
                            <th>Coluna 1</th>
                            <th>Coluna 2</th>
                            <th>Coluna 3</th>
                            <th>Coluna 4</th>
                            <th>Coluna 5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dadosExibidos as $linha) {
                            echo "<tr>";
                            echo "<td>{$linha[0]}</td>";
                            echo "<td>{$linha[1]}</td>";
                            echo "<td>{$linha[2]}</td>";
                            echo "<td>{$linha[3]}</td>";
                            echo "<td>{$linha[4]}</td>";
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

<?php
$conn->close();
?>
