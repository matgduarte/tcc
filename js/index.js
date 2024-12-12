// Atualiza o relógio (hora, data e dia da semana) dinamicamente
function updateClock() {
  const now = new Date();

  // Formatação de horas
  let hours = now.getHours();
  let minutes = now.getMinutes();
  let seconds = now.getSeconds();
  hours = hours < 10 ? '0' + hours : hours;
  minutes = minutes < 10 ? '0' + minutes : minutes;
  seconds = seconds < 10 ? '0' + seconds : seconds;

  // Atualiza o elemento com o horário formatado
  const timeString = `${hours}:${minutes}`;
  document.getElementById('time').textContent = timeString;

  // Formatação de data
  const day = now.getDate();
  const month = now.getMonth() + 1; // Janeiro é 0
  const year = now.getFullYear();
  const dateString = `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}`;
  document.getElementById('date').textContent = dateString;

  // Atualiza o dia da semana
  const daysOfWeek = ['Domingo', 'SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SAB'];
  const dayString = daysOfWeek[now.getDay()];
  document.getElementById('day').textContent = dayString;
}

// Atualiza o relógio a cada segundo
setInterval(updateClock, 1000);
updateClock(); // Chamada inicial para evitar atraso

// Controle de execução para fechamento condicional de popups
let func1Executed = false;
let func2Executed = false;

function checkAndExecuteFinalFunction() {
  if (func1Executed && func2Executed) {
    document.querySelector(".popup").style.display = "none";
  }
}

// Exibe popups após o carregamento da página
window.addEventListener("load", function () {
  setTimeout(function () {
    document.querySelector("#popup_container-pix").style.display = "flex";
    document.querySelector("#popup_container-cadastro").style.display = "flex";
  }, 6000);
});

// Fecha o primeiro popup e verifica condição
document.querySelector("#close").addEventListener("click", function () {
  document.querySelector("#popup_container-pix").style.display = "none";
  func1Executed = true;
  checkAndExecuteFinalFunction();
});

// Fecha o segundo popup e verifica condição
document.querySelector("#close2").addEventListener("click", function () {
  document.querySelector("#popup_container-cadastro").style.display = "none";
  func2Executed = true;
  checkAndExecuteFinalFunction();
});

// Define altura do elemento diário como variável CSS
document.addEventListener('DOMContentLoaded', function () {
  const diario = document.querySelector('#diario');

  if (diario) {
    const diarioHeight = diario.offsetHeight;
    document.documentElement.style.setProperty('--diario-height', `${diarioHeight}px`);
  }
});

// Ajusta tamanhos de fonte com base na altura do conteúdo
function ajustarFonte() {
  const conteudoDiario = document.getElementById('conteudo_diario');
  if (!conteudoDiario) return;

  const larguraTela = window.innerWidth;
  let alturaConteudo;

    // Verifica se a largura é maior ou igual a 600px e ajusta a altura com base na proporção
    if (larguraTela < 600) {
      const info_diaria = document.getElementById('info_diaria');
      if (!info_diaria) return;
      const larguraConteudo = info_diaria.offsetWidth;
      const proporcao = 418 / 740; // Razão h/w
      alturaConteudo = larguraConteudo * proporcao;
  
       // Adiciona uma margem negativa em #time e #conteudo_menor
       const time = document.getElementById('time');
       if (time) {
        time.style.marginTop = `-${alturaConteudo * 0.25}px`;
        time.style.marginLeft = `-${alturaConteudo * 0.05}px`;
       }
   
       const conteudoMenor = document.getElementById('conteudo_menor');
       if (conteudoMenor) {
        conteudoMenor.style.paddingBottom = `${alturaConteudo * 0.15}px`;
       }
    } else {
      alturaConteudo = conteudoDiario.offsetHeight;
    }

  // Atualiza a altura do elemento #info_diaria
  const infoDiaria = document.getElementById('info_diaria');
  if (infoDiaria) {
    infoDiaria.style.height = `${alturaConteudo}px`;
  }

  // Cálculo de tamanhos de fontes para elementos
  const ajustes = [
    { id: 'time', fator: 0.6 },
    { id: 'date', fator: 0.1 },
    { id: 'day', fator: 0.08 },
    { id: 'temperatura_principal', fator: 0.1 },
    { id: 'umidade_principal', fator: 0.1 }
  ];

  ajustes.forEach(ajuste => {
    const elemento = document.getElementById(ajuste.id);
    if (elemento) {
      const fontSize = alturaConteudo * ajuste.fator;
      elemento.style.fontSize = `${fontSize * 1.2}px`;
      elemento.style.height = `${fontSize}px`;
      const larguraTela2 = window.innerWidth;
      if (larguraTela2 > 600) {
      elemento.style.marginTop = `-${fontSize * 0.25}px`;
      }
    }
  });
}

// Aplica ajustes de fonte ao carregar e redimensionar a página
window.addEventListener('load', ajustarFonte);
window.addEventListener('resize', ajustarFonte);


async function getWeatherData(lat, lon) {
  try {
    const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,weathercode&timezone=auto&lang=pt`);
    if (!response.ok) throw new Error('Erro ao buscar dados do clima');

    const { daily } = await response.json();

    const days = [0, 1, 2];
    days.forEach((day, index) => {
      const date = new Date();
      date.setDate(date.getDate() + day);

      // Atualiza data
      const dateLabel = index === 0 ? "Hoje" : index === 1 ? "Amanhã" : date.toLocaleDateString('pt-BR', { weekday: 'short' });
      document.querySelector(`#dia${index + 1} .data-dia`).textContent = dateLabel;

      // Atualiza temperaturas
      const minTemp = Math.round(daily.temperature_2m_min[day]);
      const maxTemp = Math.round(daily.temperature_2m_max[day]);
      const currentTemp = Math.round((minTemp + maxTemp) / 2); // Exemplo de temperatura atual para cálculo

      document.querySelector(`#dia${index + 1} .min-value`).textContent = `${minTemp}°`;
      document.querySelector(`#dia${index + 1} .max-value`).textContent = `${maxTemp}°`;

      // Atualiza ícone do clima
      const weatherCode = daily.weathercode[day];
      document.querySelector(`#dia${index + 1} .icon_thermal`).innerHTML = `<ion-icon name="${getWeatherIcon(weatherCode)}"></ion-icon>`;

      // Calcula a posição do ponto atual apenas no primeiro dia
      if (index === 0) {
        const position = ((currentTemp - minTemp) / (maxTemp - minTemp)) * 100; // Percentual baseado na escala da barra
        document.querySelector(`#dia${index + 1} .temp-atual-ponto`).style.left = `${position}%`;
      }
    });
  } catch (error) {
    console.error('Erro:', error.message);
  }
}

function getWeatherIcon(weatherCode) {
  const weatherIcons = {
    0: 'sunny-outline',
    1: 'partly-sunny-outline',
    2: 'cloudy-outline',
    3: 'cloudy-outline',
    45: 'cloud-outline',
    48: 'cloud-outline',
    51: 'rainy-outline',
    61: 'rainy-outline',
    63: 'rainy-outline',
    71: 'snow-outline',
    95: 'thunderstorm-outline',
    99: 'thunderstorm-outline'
  };
  return weatherIcons[weatherCode] || 'help-outline';
}

// Obtém dados do tempo para as coordenadas fornecidas
getWeatherData(-21.248833, -50.314750);


// Rola a página suavemente ao clicar no botão
document.getElementById("btn_dados").addEventListener("click", function () {
  window.scrollTo({
    top: window.innerHeight - 10, // 100vh
    behavior: 'smooth' // Para um scroll suave
  });
});

document.getElementById("btn_dados2").addEventListener("click", function () {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});



window.onload = function () {
  // Obtém a hora atual
  var now = new Date();
  var currentHour = now.getHours();
  var endHour = currentHour + 24; // Uma hora antes do próximo dia

  var chart = new CanvasJS.Chart("chartContainer", {
    backgroundColor: "transparent",
    axisX: {
      minimum: currentHour,
      maximum: endHour - 1,
      interval: 1,
      labelAlign: "center", // Alinha o texto do label no centro
      labelFormatter: function (e) {
        var hour = e.value;
        var windSpeed = generateHourlyDataPoints()[hour - currentHour].windSpeed;
        var weatherType = generateHourlyDataPoints()[hour - currentHour].name;
        var hourFormatted = (hour % 24).toString().padStart(2, '0');
        var icon = getWeatherIcon(weatherType);
        return icon + " " + windSpeed + " km/h\n" + hourFormatted + ":00";
      },
      margin: 20,
      fontColor: "white" // Cor do texto do eixo X
    },
    axisY: {
      maximum: 40,
      minimum: 0,
      title: "",
      tickLength: 0,
      lineThickness: 0,
      margin: 20, // Ajusta a margem para a visualização adequada
      gridThickness: 0,
      labelFormatter: function (e) {
        return "";
      },
      fontColor: "white" // Cor do texto do eixo Y
    },
    toolTip: {
      enabled: false,   // Habilita a visualização de tooltip
      fontColor: "white" // Cor do texto da tooltip
    },
    data: [
      {
        type: "spline", // Alterado para splineArea para representar a temperatura média
        fillOpacity: 0.1,
        color: "rgb(255, 174, 0)",
        indexLabel: "{y}°", // Exibe a temperatura diretamente
        indexLabelFontColor: "white", // Cor do texto do índice
        markerSize: 0,
        dataPoints: generateHourlyDataPoints().map(function (point) {
          return { x: point.x, y: point.y }; // Mantém a temperatura no gráfico
        }),
      },
    ]
  });

  chart.render();

  // Função para gerar dataPoints com temperatura média, vento e tipo de clima
  function generateHourlyDataPoints() {
    var data = [];
    for (var i = currentHour; i < endHour; i++) { // Começa no horário atual e vai até uma hora antes do próximo dia
      var avgTemp = Math.floor(15 + Math.random() * 10); // Temperatura média
      var windSpeed = Math.floor(10 + Math.random() * 30); // Velocidade do vento entre 10 e 40 Km/h
      var weatherType = i % 3 === 0 ? "sunny" : i % 2 === 0 ? "rainy" : "cloudy"; // Alterna tipos de clima
      data.push({ x: i, y: avgTemp, windSpeed: windSpeed, name: weatherType });
    }
    return data;
  }

  // Função para retornar o ícone de acordo com o tipo de clima
  function getWeatherIcon(weatherType) {
    var icon = "";
    switch (weatherType) {
      case "sunny":
        icon = "☀️"; // Ícone de sol
        break;
      case "rainy":
        icon = "🌧️"; // Ícone de chuva
        break;
      case "cloudy":
        icon = "☁️"; // Ícone de nublado
        break;
      default:
        icon = "🌤️"; // Ícone padrão
    }
    return icon;
  }
};


const graficoPrincipal = document.querySelector('.bloquinhos.grafico_principal');
let isMouseDown = false;
let startX;
let scrollLeft;

graficoPrincipal.addEventListener('mousedown', (e) => {
  isMouseDown = true;
  startX = e.pageX - graficoPrincipal.offsetLeft;  // Posição inicial do mouse
  scrollLeft = graficoPrincipal.scrollLeft;         // Posição inicial da rolagem
  graficoPrincipal.style.cursor = 'grabbing';       // Altera o cursor para "mão fechada"
});

graficoPrincipal.addEventListener('mouseleave', () => {
  isMouseDown = false;
  graficoPrincipal.style.cursor = 'grab';           // Retorna o cursor para "mão aberta"
});

graficoPrincipal.addEventListener('mouseup', () => {
  isMouseDown = false;
  graficoPrincipal.style.cursor = 'grab';           // Retorna o cursor para "mão aberta"
});

graficoPrincipal.addEventListener('mousemove', (e) => {
  if (!isMouseDown) return;
  e.preventDefault();
  const x = e.pageX - graficoPrincipal.offsetLeft;
  const walk = (x - startX) * 1;                     // Reduzindo o multiplicador para desacelerar o movimento
  graficoPrincipal.scrollLeft = scrollLeft - walk;     // Atualiza a rolagem horizontal
});


// Seleciona o botão pelo ID
const button = document.getElementById("mudarFonte");

// Adiciona o evento de clique
button.addEventListener("click", function () {
  document.body.style.fontFamily = "'MinecraftFont', cursive"; // Muda a fonte
});
