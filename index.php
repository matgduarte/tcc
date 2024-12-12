        <!DOCTYPE html>
        <html lang="pt-BR">

        <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <meta name="description" content="" />
            <meta content="" name="keywords" />

            <link rel="stylesheet" href="css/header_footer.css" />
            <link rel="stylesheet" href="css/style.css" />
            <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

            <title>TCC</title>

            <link rel="shortcut icon" type="imagex/png" href="./img/porco_face.jpg">

            <!-- Incluindo a biblioteca Ionicons -->
            <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        </head>

        <body>

            <!--   popup aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii -->
            <section class="popup">
                <!--Pix-->
                <div class="popup_container" id="popup_container-pix">
                    <div class="container_pix">
                        <div class="pix_texto">
                            <button class="fechar" id="close">&times;</button>
                            <h2>OLHA O PIX</h2>
                            <p>Nos apoie, aceitamos doação de qualquer valor</p>
                        </div>
                        <img src="img/pix.png" alt="" />
                    </div>
                </div>
                <!--cadastro-->
                <div class="popup_container" id="popup_container-cadastro">
                    <div class="container_cadastro">
                        <div class="pix_texto">
                            <button class="fechar" id="close2">&times;</button>
                            <h2>Cadastre-se e Receba Atualizações</h2>
                        </div>
                        <fieldset class="fieldset_form">
                            <form action="" method="post" class="form_cadastro" onsubmit="enviarFormulario(event);">
                                <div class="form-group">
                                    <ion-icon name="person-circle-outline"></ion-icon>
                                    <input type="text" name="nome_usuario" id="nome_usuario" required>
                                    <label for="nome">Nome Completo</label>
                                </div>
                                <div class="form-group">
                                    <ion-icon name="mail-outline"></ion-icon>
                                    <input type="email" name="email" id="email" required>
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-group">
                                    <ion-icon name="call-outline"></ion-icon>
                                    <input type="text" name="telefone" id="telefone" required>
                                    <label for="telefone">Telefone</label>
                                </div>
                                <input type="submit" class="btn" value="Enviar"></input>

                            </form>
                            <div id="mensagem"></div>
                        </fieldset>

                    </div>
                </div>
                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            </section>
            <!--   site aquiiiiiiiiiiiiiiiiiiiiiiiiii -->
            <div class="container">
                <header>
                    <div class="a_pagina_tabela"></div>
                    <div class="logo">
                        <h1>ECO</h1>
                    </div>
                    <div class="a_pagina_tabela">
                        <a href="tabela.php" class="link-clima">
                            <ion-icon name="menu-outline" class="icon-clima"></ion-icon>
                        </a>
                    </div>
                </header>
                <main>
                    <?php
                    require_once 'includes/conexao.php'; // Inclui o arquivo de conexão com o banco de dados
                    ?>

                    <div class="container_main_principal">
                        <!--section informação relogio-->
                        <section id="info_diaria_section">
                            <div id="info_diaria">
                                <div id="barra_lateral"></div>
                                <div id="conteudo_diario">
                                    <!-- Exibe a umidade recuperada do banco de dados -->
                                    <div id="umidade_principal">
                                        <?php
                                        // Consulta para obter o valor da umidade
                                        $query = "SELECT Valor_Dados FROM Dados WHERE ID_Dados = 7 AND ID_Sensor = 1";
                                        $result = $con->query($query);

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            echo "<p>Umidade: " . htmlspecialchars($row['Valor_Dados']) . "%</p>";
                                        } else {
                                            echo "<p>Umidade: 0%</p>";
                                        }
                                        ?>
                                    </div>

                                    <div id="time">
                                        <?php
                                        // Exibir hora atual
                                        echo "<p>Hora Atual: " . date('H:i:s') . "</p>";
                                        ?>
                                    </div>

                                    <div id="conteudo_menor">
                                        <div class="conteudo_menor_principal">
                                            <div id="date">
                                                <?php
                                                // Exibir data atual
                                                echo "<p>Data: " . date('d/m/Y') . "</p>";
                                                ?>
                                            </div>
                                            <div id="day">
                                                <?php
                                                // Exibir dia da semana
                                                echo "<p>Dia: " . date('l') . "</p>";
                                                ?>
                                            </div>
                                        </div>

                                        <!-- Exibe a temperatura recuperada do banco de dados -->
                                        <div id="temperatura_principal">
                                            <?php
                                            // Consulta para obter o valor da temperatura
                                            $query = "SELECT Valor_Dados FROM Dados WHERE ID_Dados = 8 AND ID_Sensor = 2";
                                            $result = $con->query($query);

                                            if ($result && $result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                echo "" . htmlspecialchars($row['Valor_Dados']) . "°C</p>";
                                            } else {
                                                echo "<p>0°C</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--section informação diario-->
                    <section id="diario">
                        <div class="dia" id="dia1">
                            <div class="data-dia"></div>
                            <div class="icon_thermal"></div>
                            <div class="temperaturas">
                                <div class="temp-min">
                                    <span class="min-value"></span>
                                </div>
                                <div class="temp-barra">
                                    <div class="barra">
                                        <div class="temp-atual-ponto"></div>
                                    </div>
                                </div>
                                <div class="temp-max">
                                    <span class="max-value"></span>
                                </div>
                            </div>
                        </div>

                        <div class="barra_horizontal"></div>

                        <div class="dia" id="dia2">
                            <div class="data-dia"></div>
                            <div class="icon_thermal"></div>
                            <div class="temperaturas">
                                <div class="temp-min">
                                    <span class="min-value"></span>
                                </div>
                                <div class="temp-barra">
                                    <div class="barra"></div>
                                </div>
                                <div class="temp-max">
                                    <span class="max-value"></span>
                                </div>
                            </div>
                        </div>

                        <div class="barra_horizontal"></div>

                        <div class="dia" id="dia3">
                            <div class="data-dia"></div>
                            <div class="icon_thermal"></div>
                            <div class="temperaturas">
                                <div class="temp-min">
                                    <span class="min-value"></span>
                                </div>
                                <div class="temp-barra">
                                    <div class="barra"></div>
                                </div>
                                <div class="temp-max">
                                    <span class="max-value"></span>
                                </div>
                            </div>
                        </div>
                    </section>
                    </div>

                    
                    <!--aqui victor aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-->
                    <!--           botao de descer             -->
                    <section id="sec_btn_dados">
                        <button id="btn_dados" class="btn_dados">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </section>
                    <section id="bloco">
                        <?php include('includes/conexao.php'); ?>
                        <div class="bloquinhos grafico_principal">
                            <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
                            <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
                            <div id="chartContainer" style="height: 370px; width: 1600px;"></div>
                        </div>

                        <div class="bloquinhos">
                            <div class="areatexto">
                                <h2>Índice UV</h2>
                                <h1><?php echo $valor_dado_1; ?></h1>
                            </div>
                            <div class="areainterativa">
                                <div id="gaugeContainerUV"></div>
                            </div>
                        </div>

                        <div class="bloquinhos">
                            <div class="areatexto">
                                <h2>Umidade</h2>
                                <h1><?php echo $valor_dado_2; ?>%</h1>
                            </div>
                            <div class="areainterativa">
                                <div id="gaugeContainerHumidity"></div>
                            </div>
                        </div>

                        <div class="bloquinhos">
                            <div class="areatexto">
                                <h2>Pressão</h2>
                                <h1><?php echo $valor_dado_3; ?> mbar</h1>
                            </div>
                            <div class="areainterativa">
                                <div id="pressureGaugeContainer"></div>
                            </div>
                        </div>

                        <div class="bloquinhos">
                            <div class="areatexto">
                                <h2>Vento</h2>
                                <h1 id="windSpeedDisplay"><?php echo $valor_dado_4; ?> km/h</h1>
                                <!-- Retiramos os graus do gráfico, mas ainda podemos mostrar o valor da velocidade do vento -->
                            </div>
                            <div class="areainterativa">
                                <div id=""></div>
                            </div>
                        </div>

                        <div class="bloquinhos">
                            <div class="areatexto">
                                <h2><?php require_once('includes/funcoes.php');
                                    echo $direcao;
                                    ?></h2>
                                <h1><?php echo $valor_dado_5; ?>°</h1>
                            </div>
                            <div class="areainterativa">
                                <div id="windGaugeContainer"></div>
                            </div>
                        </div>

                        <div class="bloquinhos">
                            <div class="areatexto">
                                <h2>Condição Climática</h2>
                                <h1><?php echo $valor_dado_6; ?></h1>
                            </div>
                            <div class="areainterativa">
                                <?php
                                // Supondo que $weather seja o array retornado pela sua API
                                // Exemplo: $weather = json_decode($json_response, true);

                                // O código de ícone virá do array de resposta da API, algo como:
                                // $weather['weather'][0]['icon']; // O ícone que você quer mostrar

                                // Vamos simular a condição com um exemplo de ícone retornado pela API
                                // Substitua isso pela variável real que você tem de acordo com a API
                                $iconCode = "10d"; // Exemplo de código de ícone, como "10d" (chuva moderada durante o dia)

                                // A URL base para o ícone da API do OpenWeatherMap
                                $iconUrl = "http://openweathermap.org/img/wn/{$iconCode}@2x.png";

                                // Exibe o ícone da condição climática com o estilo desejado
                                echo "<img src='{$iconUrl}' alt='Condição Climática' style='width: 100%; height: 100%; min-height: 100%; overflow: hidden;' />";
                                ?>
                            </div>
                        </div>
                    </section>
                </main>

                <footer>
                    <div class="footer_item_hide">
                    </div>
                    <section id="sec_btn_dados2">
                        <button id="btn_dados2" class="btn_footer">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </section>
                    <div class="footer_item_hide">
                        <button id="mudarFonte"></button>
                    </div>
                </footer>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script src="js/index.js"></script>
            <script src="js/graficos.js"></script>
            <script src="https://d3js.org/d3.v7.min.js"></script>
            <script>
                // Usando o valor do índice UV vindo do PHP
                const uvValue = <?php echo $valor_dado_1; ?>; // Valor do índice UV passado pelo PHP
                createUVGauge(uvValue, "gaugeContainerUV");
            </script>
            <script>
                // Usando o valor da umidade vindo do PHP
                const humidityValue = <?php echo $valor_dado_2; ?>; // A variável PHP passa o valor da umidade
                createHumidityGauge(humidityValue, "gaugeContainerHumidity");
            </script>
            <script>
                const pressureValue = <?php echo $valor_dado_3; ?>; // Valor de pressão do PHP
                createEnhancedPressureGauge(pressureValue, "pressureGaugeContainer");
            </script>
            <script>
                const windSpeed = <?php echo $valor_dado_4; ?>; // Exemplo: 45
                const windDirection = <?php echo $valor_dado_5; ?>; // Exemplo: 90

                createWindCompass(windSpeed, windDirection, 'windGaugeContainer');
                createWindRose(windDirection, 'windRose');
            </script>


        </body>

        </html>
