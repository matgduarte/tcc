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
    <link rel="stylesheet" href="css/diario.css" />
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>TCC</title>

    <link rel="shortcut icon" type="imagex/png" href="./img/porco_face.jpg">

    <!-- Incluindo a biblioteca Ionicons -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <script>
        async function getWeatherData(lat, lon) {
            try {
                const weatherResponse = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,temperature_2m_mean,weathercode&current_weather=true&timezone=auto&lang=pt`);
                const weatherData = await weatherResponse.json();

                if (weatherResponse.status !== 200) {
                    throw new Error('Erro ao buscar dados do clima');
                }

                // Atualiza a temperatura atual
                const temperaturaDiv = document.getElementById('temperatura_principal');
                const tempAtual = weatherData.current_weather ? Math.round(weatherData.current_weather.temperature) : 'Indisponível';
                temperaturaDiv.innerHTML = `${tempAtual}°`;

                // Atualiza a umidade atual
                const umidadeDiv = document.getElementById('umidade_principal');
                const umidadeAtual = weatherData.current_weather ? weatherData.current_weather.relative_humidity : 'Indisponível'; // Certifique-se de que a API retorna `relative_humidity`
                umidadeDiv.innerHTML = umidadeAtual !== 'Indisponível' ? `Umidade: ${umidadeAtual}%` : 'Umidade: Indisponível';


                // Atualiza os dados para os 3 dias
                const days = [0, 1, 2];
                days.forEach((day, index) => {
                    const date = new Date();
                    date.setDate(date.getDate() + day);

                    // Atualiza data
                    const dateLabel = index === 0 ? "Hoje" : index === 1 ? "Amanhã" : date.toLocaleDateString('pt-BR', {
                        weekday: 'short'
                    });
                    document.querySelector(`#dia${index + 1} .data-dia`).textContent = dateLabel;

                    // Atualiza temperaturas mínimas e máximas
                    const tempMax = Math.round(weatherData.daily.temperature_2m_max[day]);
                    const tempMin = Math.round(weatherData.daily.temperature_2m_min[day]);
                    document.querySelector(`#dia${index + 1} .min-value`).textContent = `${tempMin}°`;
                    document.querySelector(`#dia${index + 1} .max-value`).textContent = `${tempMax}°`;

                    // Atualiza ícone de clima
                    const weatherCode = weatherData.daily.weathercode[day];
                    const iconDiv = document.querySelector(`#dia${index + 1} .icon_thermal`);
                    const icon = getWeatherIcon(weatherCode);
                    iconDiv.innerHTML = `<ion-icon name="${icon}"></ion-icon>`;
                });
            } catch (error) {
                console.error('Erro:', error.message);
            }
        }

        // Função para retornar o ícone com base no código do clima
        function getWeatherIcon(weatherCode) {
            const weatherIcons = {
                0: 'sunny-outline', // Céu limpo
                1: 'partly-sunny-outline', // Parcialmente nublado
                2: 'cloudy-outline', // Nublado
                3: 'cloudy-outline', // Muito nublado
                45: 'cloud-outline', // Névoa
                48: 'cloud-outline', // Névoa densa
                51: 'rainy-outline', // Chuvisco
                61: 'rainy-outline', // Chuva leve
                63: 'rainy-outline', // Chuva moderada
                71: 'snow-outline', // Neve leve
                95: 'thunderstorm-outline', // Tempestade
                99: 'thunderstorm-outline' // Tempestade severa
            };

            return weatherIcons[weatherCode] || 'help-outline'; // Ícone padrão para códigos desconhecidos
        }


        // Chamar a função para obter os dados do tempo
        getWeatherData(-21.248833, -50.314750); // Substitua pelas coordenadas reais

        function ajustarFonte() {
    // Pega a altura do elemento com id "conteudo_diario"
    const conteudoDiario = document.getElementById('conteudo_diario');
    const alturaConteudo = conteudoDiario.offsetHeight;

    // Calcula as porcentagens para cada elemento
    const fontSizeTime = alturaConteudo * 0.6; // 60% para #time
    const fontSizeDate = alturaConteudo * 0.1; // 10% para #date
    const fontSizeDay = alturaConteudo * 0.08; // 8% para #day
    const fontSizeTemperatura = alturaConteudo * 0.1; // 10% para #temperatura_principal
    const fontSizeUmidade = alturaConteudo * 0.1; // 10% para #umidade_principal

    // Ajusta o font-size (aumentando 20% para todos), a altura e o padding-top para cada elemento
    const time = document.getElementById('time');
    time.style.fontSize = (fontSizeTime * 1.2) + 'px'; // Aumenta 20% para #time
    time.style.height = fontSizeTime + 'px';
    time.style.marginTop = -(fontSizeTime * 0.25) + 'px'; // 25% a menos no padding-top para #time

    const date = document.getElementById('date');
    date.style.fontSize = (fontSizeDate * 1.2) + 'px'; // Aumenta 20% para #date
    date.style.height = fontSizeDate + 'px';
    date.style.marginTop = -(fontSizeDate * 0.25) + 'px'; // 25% a menos no padding-top para #date

    const day = document.getElementById('day');
    day.style.fontSize = (fontSizeDay * 1.2) + 'px'; // Aumenta 20% para #day
    day.style.height = fontSizeDay + 'px';
    day.style.marginTop = -(fontSizeDay * 0.25) + 'px'; // 25% a menos no padding-top para #day

    const temperatura = document.getElementById('temperatura_principal');
    temperatura.style.fontSize = (fontSizeTemperatura * 1.2) + 'px'; // Aumenta 20% para #temperatura_principal
    temperatura.style.height = fontSizeTemperatura + 'px';
    temperatura.style.marginTop = -(fontSizeTemperatura * 0.25) + 'px'; // 25% a menos no padding-top para #temperatura_principal

    const umidade = document.getElementById('umidade_principal');
    umidade.style.fontSize = (fontSizeUmidade * 1.2) + 'px'; // Aumenta 20% para #umidade_principal
    umidade.style.height = fontSizeUmidade + 'px';
    umidade.style.marginTop = -(fontSizeUmidade * 0.25) + 'px'; // 25% a menos no padding-top para #umidade_principal
}

// Chama a função sempre que necessário (por exemplo, ao carregar a página)
window.addEventListener('load', ajustarFonte);

// Você também pode chamar essa função caso haja algum redimensionamento de tela
window.addEventListener('resize', ajustarFonte);

    </script>

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
            <div class="logo">
                <h1>ECO</h1>
            </div>
        </header>
        <main>
            <div class="container_main_principal">
                <!--section informação relogio-->
                <section id="info_diaria">
                    <div id="barra_lateral"></div>
                    <div id="conteudo_diario">
                        <div id="umidade_principal"></div> <!-- Esta div será atualizada com a umidade -->
                        <div id="time"></div>
                        <div id="conteudo_menor">
                            <div class="conteudo_menor_principal">
                                <div id="date"></div>
                                <div id="day"></div>
                            </div>
                            <div id="temperatura_principal"></div>
                            <!-- Esta div será atualizada com a temperatura atual -->
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
                                <div class="barra"></div>
                                <div class="temp-atual-ponto"></div>
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
                <!--aqui victor aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa-->
                <!--           botao de descer             -->
                <section id="sec_btn_dados">
                    <button id="btn_dados">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </section>
                <section id="bloco">
                    <div class="bloquinhos grafico_principal">
                        <div class="areatexto">
                            <h2>123</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>


        </main>

        <footer>
            <div class="footer_item">
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="js/index.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        /* Exemplo de como mudar a classe com base na temperatura */
        function updateTemperature(temp) {
            const temperatureDisplay = document.getElementById('temperature-display');
            const temperatureValue = document.getElementById('temperature');

            // Atualiza o valor mostrado
            temperatureValue.textContent = `${temp}°C`;

            // Remove as classes anteriores
            temperatureDisplay.classList.remove('temperature-hot', 'temperature-warm', 'temperature-cool', 'temperature-cold');

            // Aplica classes baseadas na temperatura
            if (temp >= 30) {
                temperatureDisplay.classList.add('temperature-hot');
            } else if (temp >= 20) {
                temperatureDisplay.classList.add('temperature-warm');
            } else if (temp >= 10) {
                temperatureDisplay.classList.add('temperature-cool');
            } else {
                temperatureDisplay.classList.add('temperature-cold');
            }
        }

        function updateUV(uvIndex) {
            const uvIcon = document.getElementById('uv-icon');
            const uvValue = document.getElementById('uv-value');

            // Atualiza o valor de UV no HTML
            uvValue.textContent = uvIndex;

            // Remove classes anteriores
            uvIcon.className = 'uv-icon';

            // Adiciona classes com base no valor de UV
            if (uvIndex <= 2) {
                uvIcon.classList.add('uv-low');
                uvIcon.innerHTML = '☀️'; // Ícone de sol leve
            } else if (uvIndex <= 5) {
                uvIcon.classList.add('uv-moderate');
                uvIcon.innerHTML = '🌤️'; // Ícone moderado
            } else if (uvIndex <= 7) {
                uvIcon.classList.add('uv-high');
                uvIcon.innerHTML = '🌞'; // Ícone sol forte
            } else if (uvIndex <= 10) {
                uvIcon.classList.add('uv-very-high');
                uvIcon.innerHTML = '🔥'; // Ícone de calor intenso
            } else {
                uvIcon.classList.add('uv-extreme');
                uvIcon.innerHTML = '☠️'; // Ícone extremo
            }
        }

        function updateWind(windSpeed) {
            const windIcon = document.getElementById('wind-icon');
            const windValue = document.getElementById('wind-value');

            // Atualiza o valor de vento no HTML
            windValue.textContent = windSpeed;

            // Remove classes anteriores
            windIcon.className = 'wind-icon';

            // Adiciona classes com base na velocidade do vento
            if (windSpeed <= 10) {
                windIcon.classList.add('wind-low');
                windIcon.innerHTML = '🍃'; // Ícone de vento fraco
            } else if (windSpeed <= 20) {
                windIcon.classList.add('wind-moderate');
                windIcon.innerHTML = '💨'; // Ícone de vento moderado
            } else if (windSpeed <= 30) {
                windIcon.classList.add('wind-strong');
                windIcon.innerHTML = '🌬️'; // Ícone de vento forte
            } else {
                windIcon.classList.add('wind-very-strong');
                windIcon.innerHTML = '🌪️'; // Ícone de vento muito forte
            }
        }

        // Exemplo de uso com valores dinâmicos:
        updateUV(2); // Exemplo: índice UV alto
        updateWind(300); // Exemplo: vento forte

        // Exemplo de atualização de temperatura
        updateTemperature(500); // Testando com 30°C
    </script>

</body>

</html>
