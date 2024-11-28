<?php
// Definir as credenciais de conexão com o banco de dados
$hostname = 'localhost';     // Nome do host do banco de dados
$username = 'root';          // Nome de usuário do banco de dados
$password = '';              // Senha do banco de dados
$database = 'ECO';           // Nome do banco de dados
$port = 3307;                // Porta do banco de dados (caso necessário)

// Estabelecer a conexão com o banco de dados
$con = mysqli_connect($hostname, $username, $password, $database, $port);

// Verificar se a conexão falhou
if (mysqli_connect_errno()) {
    printf("Erro Conexão: %s", mysqli_connect_error());
    exit();
}

// Obtenha sua chave de API gratuitamente em http://hgbrasil.com/weather
$chave = '8ef376b8'; 

// Resgata o IP do usuário ou define um padrão
$ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';

// Realiza a requisição à API HG Weather
$dados = hg_request(array(
    'user_ip' => $ip,
    'lat' => '-21.2892', 
    'lon' => '-50.3411'  
), $chave);

// Verifica se os dados foram obtidos
if (!isset($dados)) {
    echo 'Erro ao obter dados da API.';
    die();
}

// Função para realizar a requisição à API
function hg_request($parametros, $chave = null, $endpoint = 'weather') {
    $url = 'http://api.hgbrasil.com/' . $endpoint . '/?format=json&';
    
    if (is_array($parametros)) {
        // Insere a chave nos parâmetros
        if (!empty($chave)) $parametros = array_merge($parametros, array('key' => $chave));
        
        // Transforma os parâmetros em URL
        foreach ($parametros as $key => $value) {
            if (empty($value)) continue;
            $url .= $key . '=' . urlencode($value) . '&';
        }
        
        // Obtém os dados da API
        $resposta = file_get_contents(substr($url, 0, -1));
        
        return json_decode($resposta, true);
    } else {
        return false;
    }
}

// Verificar se os dados de clima foram recebidos corretamente
if (isset($dados['results'])) {
    $current = $dados['results']; // Armazenar os dados meteorológicos atuais

    // Definir a data atual
    $data_dados = date('Y-m-d');
    // Definir o ID do sensor (substitua pelo ID correto do seu banco de dados)
    $sensor_id = 0;

    // Inserir ou atualizar a temperatura (ID_Dados = 1)
    $temperatura = isset($current['temp']) ? $current['temp'] : 'Indisponível'; // Verifica se o valor está disponível
    $sql_temp = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                 VALUES (1, '$sensor_id', '$temperatura', '$data_dados')
                 ON DUPLICATE KEY UPDATE Valor_Dados = '$temperatura', Data_Dados = '$data_dados'";
    $con->query($sql_temp); // Executar a consulta

    // Inserir ou atualizar a umidade (ID_Dados = 2)
    $umidade = isset($current['humidity']) ? $current['humidity'] : 'Indisponível'; // Verifica se o valor está disponível
    $sql_umidade = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                    VALUES (2, '$sensor_id', '$umidade', '$data_dados')
                    ON DUPLICATE KEY UPDATE Valor_Dados = '$umidade', Data_Dados = '$data_dados'";
    $con->query($sql_umidade); // Executar a consulta

    // Inserir ou atualizar a direção do vento (ID_Dados = 3)
    $direcao_vento = isset($current['wind_direction']) ? $current['wind_direction'] : 'Indisponível'; // Verifica se o valor está disponível
    $sql_direcao_vento = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                      VALUES (3, '$sensor_id', '$direcao_vento', '$data_dados')
                      ON DUPLICATE KEY UPDATE Valor_Dados = '$direcao_vento', Data_Dados = '$data_dados'";
    $con->query($sql_direcao_vento); // Executar a consulta

    // Inserir ou atualizar a condição climática com código numérico (ID_Dados = 4)
$condicao_climatica_codigo = isset($current['weather'][0]['id']) ? $current['weather'][0]['id'] : 'Indisponível'; // Verifica se o valor está disponível
$sql_condicao_climatica = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                           VALUES (4, '$sensor_id', '$condicao_climatica_codigo', '$data_dados')
                           ON DUPLICATE KEY UPDATE Valor_Dados = '$condicao_climatica_codigo', Data_Dados = '$data_dados'";
$con->query($sql_condicao_climatica); // Executar a consulta



    // Inserir ou atualizar a pressão atmosférica (ID_Dados = 5)
    $pressao = isset($current['pressure']) ? $current['pressure'] : 'Indisponível'; // Verifica se o valor está disponível
    $sql_pressao = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                    VALUES (5, '$sensor_id', '$pressao', '$data_dados')
                    ON DUPLICATE KEY UPDATE Valor_Dados = '$pressao', Data_Dados = '$data_dados'";
    $con->query($sql_pressao); // Executar a consulta

    // Inserir ou atualizar a velocidade do vento (ID_Dados = 6)
    $vento = isset($current['wind_speed']) ? $current['wind_speed'] : 'Indisponível'; // Verifica se o valor está disponível
    $sql_vento = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                  VALUES (6, '$sensor_id', '$vento', '$data_dados')
                  ON DUPLICATE KEY UPDATE Valor_Dados = '$vento', Data_Dados = '$data_dados'";
    $con->query($sql_vento); // Executar a consulta

    
} else {
    echo "Erro: Dados não encontrados na API."; // Mensagem de erro caso os dados não sejam encontrados
}// Inicializando o array de dados
$valor_dado_1 = null;
$valor_dado_2 = null;
$valor_dado_3 = null;
$valor_dado_4 = null;
$valor_dado_5 = null;
$valor_dado_6 = null;

// Consulta para buscar os valores dos dados onde ID_Sensor = 0
$sql = "
    SELECT ID_Dados, Valor_Dados
    FROM Dados
    WHERE ID_Sensor = 0
    ORDER BY ID_Dados ASC
    LIMIT 6"; // Trazendo 6 registros

// Executa a consulta e armazena os resultados
$result = $con->query($sql);

// Verifica se a consulta retornou algum dado
if ($result) {
    if ($result->num_rows > 0) {
        // Armazenar os dados em um array associativo
        $dados = $result->fetch_all(MYSQLI_ASSOC);
        
        // Atribuir os valores às variáveis correspondentes
        foreach ($dados as $row) {
            // Dependendo do ID_Dados, atribui o valor à variável correspondente
            switch ($row['ID_Dados']) {
                case 1:
                    $valor_dado_1 = $row['Valor_Dados'];
                    break;
                case 2:
                    $valor_dado_2 = $row['Valor_Dados'];
                    break;
                case 3:
                    $valor_dado_3 = $row['Valor_Dados'];
                    break;
                case 4:
                    $valor_dado_4 = $row['Valor_Dados'];
                    break;
                case 5:
                    $valor_dado_5 = $row['Valor_Dados'];
                    break;
                case 6:
                    $valor_dado_6 = $row['Valor_Dados'];
                    break;
            }
        }
    } else {
        echo "Nenhum dado encontrado com ID_Sensor = 0.<br>";
    }
} else {
    echo "Erro na consulta SQL: " . $con->error . "<br>";
}

// Fechando a conexão após o uso
$con->close();
?>