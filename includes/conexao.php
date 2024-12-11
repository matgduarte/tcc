<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'ECO';
$port = 3307;

$con = mysqli_connect($hostname, $username, $password, $database, $port);

if (mysqli_connect_errno()) {
    printf("Erro Conexão: %s" . mysqli_connect_errno());
    exit();
}

// Configurações da OpenWeatherMap (para os outros dados)
$apiKey = "069c62d3bba0d43d685b7fc48ee537ce";
$city = "Birigui"; // Substitua pelo nome da cidade desejada
$apiUrlWeather = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric&lang=pt_br";

// Configurações da Open-Meteo (apenas para o índice UV)
$latitude = -21.2721; // Latitude de Birigui
$longitude = -50.2904; // Longitude de Birigui
$apiUrlUV = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&daily=uv_index_max,sunrise,sunset&timezone=auto";

// Fazendo as requisições para as APIs
$responseWeather = file_get_contents($apiUrlWeather);
$responseUV = file_get_contents($apiUrlUV);

$weatherData = json_decode($responseWeather, true);
$uvData = json_decode($responseUV, true);

if (isset($weatherData['main']) && isset($uvData['daily']['uv_index_max'][0])) {
    // Dados meteorológicos básicos da OpenWeatherMap
    $nuvens = $weatherData['clouds']['all']; // Cobertura de nuvens (%)
    $nascer_sol = $weatherData['sys']['sunrise']; // Timestamp do nascer do sol
    $por_sol = $weatherData['sys']['sunset']; // Timestamp do pôr do sol
    $umidade = $weatherData['main']['humidity'];
    $pressao = $weatherData['main']['pressure'];
    $vento = $weatherData['wind']['speed'] * 3.6; // Converter de m/s para km/h
    $direcao_vento = $weatherData['wind']['deg'];
    $descricao = isset($weatherData['weather'][0]['description']) ? $weatherData['weather'][0]['description'] : 'Sem descrição';

    // Dados do índice UV da Open-Meteo
    $indice_uv = $uvData['daily']['uv_index_max'][0]; // UV máximo do dia

    // Dados do nascer e pôr do sol
    $sunrise = $uvData['daily']['sunrise'][0]; // Timestamp do nascer do sol
    $sunset = $uvData['daily']['sunset'][0]; // Timestamp do pôr do sol

    // Hora atual (em formato UNIX timestamp)
    $currentTime = time();

    // Verifica se a hora atual está entre o nascer e o pôr do sol
    if ($currentTime < $sunrise || $currentTime > $sunset) {
        // Se estiver de noite, o índice UV é 0
        $indice_uv = 0;
    }

    // Data atual
    $data_dados = date('Y-m-d');
    $sensor_id = 0;

    // Inserir ou atualizar cada dado no banco de dados
    $dados = [
        ['id' => 1, 'valor' => number_format($indice_uv, 1)], // Índice UV
        ['id' => 2, 'valor' => $umidade],
        ['id' => 3, 'valor' => $pressao],
        ['id' => 4, 'valor' => number_format($vento, 1)], // Velocidade do vento (km/h)
        ['id' => 5, 'valor' => $direcao_vento],
        ['id' => 6, 'valor' => $descricao]
    ];

    foreach ($dados as $dado) {
        $id = $dado['id'];
        $valor = $dado['valor'];

        $sql = "INSERT INTO Dados (ID_Dados, ID_Sensor, Valor_Dados, Data_Dados)
                VALUES ('$id', '$sensor_id', '$valor', '$data_dados')
                ON DUPLICATE KEY UPDATE Valor_Dados = '$valor', Data_Dados = '$data_dados'";

        if (!$con->query($sql)) {
            echo "Erro ao inserir ID $id: " . $con->error . "<br>";
        }
    }
} else {
    echo "Erro: Não foi possível obter os dados meteorológicos ou índice UV.<br>";
}

// Consulta para buscar os valores
$sql = "
    SELECT ID_Dados, Valor_Dados
    FROM Dados
    WHERE ID_Sensor = 0
    ORDER BY ID_Dados ASC
    LIMIT 6";
$result = $con->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        $dados = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($dados as $row) {
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
        echo "Nenhum dado encontrado.<br>";
    }
} else {
    echo "Erro na consulta SQL: " . $con->error . "<br>";
}


?>
