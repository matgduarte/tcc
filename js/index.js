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
window.addEventListener("load", function() {
  setTimeout(function () {
    document.querySelector("#popup_container-pix").style.display = "flex";
    document.querySelector("#popup_container-cadastro").style.display = "flex";
  }, 6000);
});

// Fecha o primeiro popup e verifica condição
document.querySelector("#close").addEventListener("click", function() {
  document.querySelector("#popup_container-pix").style.display = "none";
  func1Executed = true;
  checkAndExecuteFinalFunction();
});

// Fecha o segundo popup e verifica condição
document.querySelector("#close2").addEventListener("click", function() {
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
  const alturaConteudo = conteudoDiario.offsetHeight;

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
      elemento.style.marginTop = `-${fontSize * 0.25}px`;
    }
  });
}

// Aplica ajustes de fonte ao carregar e redimensionar a página
window.addEventListener('load', ajustarFonte);
window.addEventListener('resize', ajustarFonte);

// Rola a página suavemente ao clicar no botão
document.getElementById("btn_dados").addEventListener("click", function() {
  window.scrollTo({
      top: window.innerHeight - 10, // 100vh - 10px
      behavior: 'smooth' // Para um scroll suave
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
        dataPoints: generateHourlyDataPoints().map(function(point) {
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
