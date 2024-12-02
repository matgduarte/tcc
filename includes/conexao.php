<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ECO';
    $port = 3306;

    $con = mysqli_connect($hostname, $username, $password, $database, $port);

    if(mysqli_connect_errno()){
        printf("Erro Conexão: %s". mysqli_connect_errno());
        exit();
    }
    // Obtenha sua chave de API gratuitamente em http://hgbrasil.com/weather
        $apiKey = "069c62d3bba0d43d685b7fc48ee537ce";
        $city = "Birigui"; // Substitua pelo nome da cidade desejada
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric&lang=pt_br";

        // Fazendo a requisição para a API
        $response = file_get_contents($apiUrl);
        $weatherData = json_decode($response, true);

        if (isset($weatherData['main'])) {
            // Armazenar os dados meteorológicos
            $temperatura = $weatherData['main']['temp'];
            $umidade = $weatherData['main']['humidity'];
            $pressao = $weatherData['main']['pressure'];
            $vento = $weatherData['wind']['speed'];
            $direcao_vento = $weatherData['wind']['deg'];
            $descricao = isset($weatherData['weather'][0]['description']) ? $weatherData['weather'][0]['description'] : 'Sem descrição';

            // Data atual
            $data_dados = date('Y-m-d');
            $sensor_id = 0;

            // Inserir ou atualizar cada dado no banco de dados
            $dados = [
                ['id' => 1, 'valor' => $temperatura],
                ['id' => 2, 'valor' => $umidade],
                ['id' => 3, 'valor' => $pressao],
                ['id' => 4, 'valor' => $vento],
                ['id' => 5, 'valor' => $direcao_vento],
                ['id' => 6, 'valor' => $descricao]  // Alterado para temperatura máxima
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
            echo "Erro: Não foi possível obter os dados meteorológicos.<br>";
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
                            $valor_dado_6 = $row['Valor_Dados'];  // Agora será a temperatura máxima
                            break;
                    }
                }
            } else {
                echo "Nenhum dado encontrado.<br>";
            }
        } else {
            echo "Erro na consulta SQL: " . $con->error . "<br>";
        }

        $con->close();
?>