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
                    throw new Error('!!');
                }

                console.log(weatherData);

                // Atualizar a temperatura atual no seu HTML, se disponível
                let temperaturaDiv = document.getElementById('temperatura_principal');
                let tempAtual = weatherData.current_weather ? Math.round(weatherData.current_weather.temperature) : 'Indisponível';
                temperaturaDiv.innerHTML = `${tempAtual}°`;

                // Verifica se a umidade está disponível e atualiza, senão exibe 'Indisponível'
                let umidadeDiv = document.getElementById('umidade_principal');
                umidadeDiv.innerHTML = weatherData.current_weather && weatherData.current_weather.relative_humidity
                    ? `Umidade: ${weatherData.current_weather.relative_humidity}%`
                    : `Umidade: Indisponível`;

                const days = [0, 1, 2];
                days.forEach((day, index) => {
                    const date = new Date();
                    date.setDate(date.getDate() + day);

                    let dateLabel = index === 0 ? "Hoje" : index === 1 ? "Amanhã" : date.toLocaleDateString('pt-BR', { weekday: 'short' });
                    document.querySelector(`#dia${index + 1} .data-dia`).textContent = dateLabel;

                    // Atualiza apenas o primeiro dia com o ponto da temperatura atual
                    if (index === 0) {
                        const tempMax = Math.round(weatherData.daily.temperature_2m_max[day]);
                        const tempMin = Math.round(weatherData.daily.temperature_2m_min[day]);
                        const tempRange = tempMax - tempMin;
                        const tempPosition = ((tempAtual - tempMin) / tempRange) * 100;
                        document.querySelector(`#dia${index + 1} .temp-atual-ponto`).style.left = `${tempPosition}%`;
                    }

                    const tempMax = Math.round(weatherData.daily.temperature_2m_max[day]);
                    const tempMin = Math.round(weatherData.daily.temperature_2m_min[day]);

                    document.querySelector(`#dia${index + 1} .min-value`).textContent = `${tempMin}°`;
                    document.querySelector(`#dia${index + 1} .max-value`).textContent = `${tempMax}°`;
                });
            } catch (error) {
                console.error('!!');
            }
        }



        // Função auxiliar para obter o ícone do clima
        function getWeatherIcon(weatherCode) {
            switch (weatherCode) {
                case 0:
                    return '<ion-icon name="sunny-outline"></ion-icon>'; // Ensolarado
                case 1:
                case 2:
                    return '<ion-icon name="partly-sunny-outline"></ion-icon>'; // Parcialmente Nublado
                case 3:
                case 4:
                    return '<ion-icon name="cloud-outline"></ion-icon>'; // Nublado
                case 5:
                case 6:
                case 7:
                    return '<ion-icon name="rainy-outline"></ion-icon>'; // Chuvoso
                case 8:
                    return '<ion-icon name="thunderstorm-outline"></ion-icon>'; // Tempestade
                case 9:
                    return '<ion-icon name="snow-outline"></ion-icon>'; // Frio
                default:
                    return '<ion-icon name="help-outline"></ion-icon>'; // Condição desconhecida
            }
        }

        // Chamar a função para obter os dados do tempo
        getWeatherData(-21.248833, -50.314750); // Substitua pelas coordenadas reais
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
                    <div class="bloquinhos">
                        <div class="areatexto">
                            <h2>legenda</h2>
                            <h1>Principal</h1>
                        </div>
                        <div class="areainterativa">
                            Area interativa
                        </div>
                    </div>

<script>
    document.getElementById('btn_dados').addEventListener('click', function() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
});

</script>
    </main>

    <footer>
      <div class="footer_item">
      </div>
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Gerar dados fictícios
    function gerarDadosAleatorios() {
            const dias = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
            const temperaturas = [];
            const umidades = [];
            const ventos = [];

            for (let i = 0; i < dias.length; i++) {
                temperaturas.push(Math.floor(Math.random() * 35) + 15); // Temperaturas entre 15°C e 35°C
                umidades.push(Math.floor(Math.random() * 50) + 30); // Umidades entre 30% e 80%
                ventos.push(Math.floor(Math.random() * 20) + 5); // Ventos entre 5 km/h e 25 km/h
            }

            return { dias, temperaturas, umidades, ventos };
        }

        const dados = gerarDadosAleatorios();

        // Exibir os dados atuais (último dia)
        document.getElementById('temp_atual').textContent = dados.temperaturas[dados.temperaturas.length - 1];
        document.getElementById('umidade_atual').textContent = dados.umidades[dados.umidades.length - 1];
        document.getElementById('vento_atual').textContent = dados.ventos[dados.ventos.length - 1];

        // Configurar o gráfico
        const ctx = document.getElementById('graficoClima').getContext('2d');
        const graficoClima = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dados.dias,
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        data: dados.temperaturas,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2
                    },
                    {
                        label: 'Umidade (%)',
                        data: dados.umidades,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2
                    },
                    {
                        label: 'Vento (km/h)',
                        data: dados.ventos,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
  </script>
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
