function updateClock() {
    const now = new Date();
    
    // Formatação de horas
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    
    // Atualiza a hora
    const timeString = `${hours}:${minutes}`;
    document.getElementById('time').textContent = timeString;
    
    // Formatação de data
    const day = now.getDate();
    const month = now.getMonth() + 1; // Janeiro é 0
    const year = now.getFullYear();
    const dateString = `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}`;
    document.getElementById('date').textContent = dateString;
    
    // Dia da semana
    const daysOfWeek = ['Domingo', 'SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SAB'];
    const dayString = daysOfWeek[now.getDay()];
    document.getElementById('day').textContent = dayString;
  }
  
  setInterval(updateClock, 1000);
  updateClock(); // Chama a função imediatamente para não ter atraso inicial
  
  let func1Executed = false;
  let func2Executed = false;
  
  function checkAndExecuteFinalFunction() {
    if (func1Executed && func2Executed) {
        document.querySelector(".popup").style.display = "none";
    }
  }
  
  window.addEventListener("load", function() {
    setTimeout(function open(event) {
        document.querySelector("#popup_container-pix").style.display = "flex";
        document.querySelector("#popup_container-cadastro").style.display = "flex";
    }, 6000);
  });
  
  document.querySelector("#close").addEventListener("click", function() {
    document.querySelector("#popup_container-pix").style.display = "none";
    func1Executed = true;
    checkAndExecuteFinalFunction();
  });
  
  document.querySelector("#close2").addEventListener("click", function() {
    document.querySelector("#popup_container-cadastro").style.display = "none";
    func2Executed = true;
    checkAndExecuteFinalFunction();
  });
  
  /*API*/
  let forecastDay = document.createElement('div');
  forecastDay.className = 'forecast_day';
  forecastDay.innerHTML = `
      <div class="data">${new Date(date).toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'short' })}</div>
      <div class="icon_thermal">${icon}</div>
      <div class="temperaturas">Máx: ${Math.round(weatherData.daily.temperature_2m_max[index])}°C | Mín: ${Math.round(weatherData.daily.temperature_2m_min[index])}°C</div>
  `;
  forecastContainer.appendChild(forecastDay);
  async function enviarFormulario(event) {
      event.preventDefault();
  
      const nome_usuario = document.getElementById("nome_usuario").value;
      const email = document.getElementById("email").value;
      const telefone = document.getElementById("telefone").value;
  
      const response = await fetch("Cadastro/cadastro.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `nome_usuario=${nome_usuario}&email=${email}&telefone=${telefone}`,
      });
  
      const resultado = await response.text();
      document.getElementById("mensagem").innerHTML = resultado;
    }
  
    async function getWeatherData(lat, lon) {
      try {
        const weatherResponse = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum,weathercode&timezone=auto&lang=pt`);
  
        const weatherData = await weatherResponse.json();
  
        if (weatherResponse.status !== 200) {
          throw new Error(weatherData.error.message);
        }
  
        // Atualiza a interface com os dados do tempo
        document.getElementById('time').innerText = `Atualizado às: ${new Date().toLocaleTimeString('pt-BR')}`;
  
        let forecastContainer = document.getElementById('previsao_container');
        forecastContainer.innerHTML = '';
  
        // Limitar a exibição para 3 dias
        for (let index = 0; index < 3; index++) {
          let date = weatherData.daily.time[index];
          let weatherCode = weatherData.daily.weathercode[index];
          let forecastDay = document.createElement('div');
          forecastDay.className = 'forecast_day';
  
          let icon;
          switch (weatherCode) {
            case 0:
              icon = '<ion-icon name="sunny-outline"></ion-icon>';
              setBackground('sunny'); // Define o fundo para ensolarado
              break;
            case 1:
            case 2:
              icon = '<ion-icon name="partly-sunny-outline"></ion-icon>';
              setBackground('partly-sunny'); // Fundo parcialmente ensolarado
              break;
            case 3:
            case 4:
              icon = '<ion-icon name="cloud-outline"></ion-icon>';
              setBackground('cloudy'); // Fundo nublado
              break;
            case 5:
            case 6:
            case 7:
              icon = '<ion-icon name="rainy-outline"></ion-icon>';
              setBackground('rainy'); // Fundo chuvoso
              break;
            case 8:
              icon = '<ion-icon name="thunderstorm-outline"></ion-icon>';
              setBackground('stormy'); // Fundo tempestuoso
              break;
            case 9:
              icon = '<ion-icon name="snow-outline"></ion-icon>';
              setBackground('snowy'); // Fundo de frio
              break;
            default:
              icon = '<ion-icon name="help-outline"></ion-icon>';
              break;
          }
  
          forecastDay.innerHTML = `
            <div class="dia">
              <div class="data">${new Date(date).toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'short' })}</div>
              <div class="icon_thermal">${icon}</div>
              <div class="temperaturas">
                <div>Máx: ${Math.round(weatherData.daily.temperature_2m_max[index])}°C</div>
                <div>Mín: ${Math.round(weatherData.daily.temperature_2m_min[index])}°C</div>
                <div>Precipitação: ${weatherData.daily.precipitation_sum[index]} mm</div>
              </div>
            </div>
          `;
          forecastContainer.appendChild(forecastDay);
        }
  
      } catch (error) {
        console.error('Erro ao obter dados do tempo:', error);
      }
    }
  
    function setBackground(weather) {
      const hour = new Date().getHours();
      let backgroundColor;
  
      if (weather === 'sunny' || weather === 'partly-sunny') {
        backgroundColor = 'linear-gradient(to bottom, #87CEEB, #FFFFFF)'; // Gradiente ensolarado
      } else if (weather === 'cloudy') {
        backgroundColor = 'linear-gradient(to bottom, #B0C4DE, #FFFFFF)'; // Gradiente nublado
      } else if (weather === 'rainy') {
        backgroundColor = 'linear-gradient(to bottom, #A9A9A9, #FFFFFF)'; // Gradiente chuvoso
      } else if (weather === 'stormy') {
        backgroundColor = 'linear-gradient(to bottom, #808080, #FFFFFF)'; // Gradiente tempestuoso
      } else if (weather === 'snowy') {
        backgroundColor = 'linear-gradient(to bottom, #FFFFFF, #ADD8E6)'; // Gradiente de frio
      }
  
      // Se for noite, escurecer o fundo
      if (hour < 6 || hour > 18) {
        backgroundColor += ', rgba(0, 0, 0, 0.5)'; // Adiciona um filtro escuro
      }
  
      document.body.style.background = backgroundColor;
    }
  
    getWeatherData(-21.248833, -50.314750); // Substitua pelas coordenadas reais
    changeBackground(weatherData.daily.weathercode[0]);
    
  
  
  
    async function getWeatherData(lat, lon) {
      try {
        const weatherResponse = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum,weathercode&timezone=auto&lang=pt`);
        
        const weatherData = await weatherResponse.json();
        if (weatherResponse.status !== 200) {
          throw new Error(weatherData.error.message);
        }
  
        let forecastContainer = document.getElementById('previsao_container');
        forecastContainer.innerHTML = ''; // Limpa o conteúdo anterior
  
        // Obter o dia atual
        const today = new Date();
  
        // Limitar a exibição para 3 dias
        for (let index = 0; index < 3; index++) {
          const date = new Date(today);
          date.setDate(today.getDate() + index);
  
          let weatherCode = weatherData.daily.weathercode[index]; // Código do clima
          let forecastDay = document.createElement('div');
          forecastDay.className = 'forecast_day';
  
          // Determina o ícone com base no código do clima
          let icon;
          switch (weatherCode) {
            case 0:
              icon = '<ion-icon name="sunny-outline"></ion-icon>'; // Ensolarado
              break;
            case 1:
            case 2:
              icon = '<ion-icon name="partly-sunny-outline"></ion-icon>'; // Parcialmente Nublado
              break;
            case 3:
            case 4:
              icon = '<ion-icon name="cloud-outline"></ion-icon>'; // Nublado
              break;
            case 5:
            case 6:
            case 7:
              icon = '<ion-icon name="rainy-outline"></ion-icon>'; // Chuvoso
              break;
            case 8:
              icon = '<ion-icon name="thunderstorm-outline"></ion-icon>'; // Tempestade
              break;
            case 9:
              icon = '<ion-icon name="snow-outline"></ion-icon>'; // Frio
              break;
            default:
              icon = '<ion-icon name="help-outline"></ion-icon>'; // Ícone padrão
              break;
          }
  
          forecastDay.innerHTML = `
            <div class="dia">
              <div class="data">${date.toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'short' })}</div>
              <div class="icon_thermal" style="font-size: 48px;">${icon}</div>
              <div class="temperaturas">
                <div>Máx: ${Math.round(weatherData.daily.temperature_2m_max[index])}°C</div>
                <div>Mín: ${Math.round(weatherData.daily.temperature_2m_min[index])}°C</div>
                <div>Precipitação: ${weatherData.daily.precipitation_sum[index]} mm</div>
              </div>
            </div>
          `;
          forecastContainer.appendChild(forecastDay);
        }
  
        // Chamar a função para mudar o fundo com base no código do clima e na hora do dia
        const currentWeatherCode = weatherData.daily.weathercode[0]; // Pega o código do clima para o dia atual
        changeBackgroundByTime(currentWeatherCode);
  
      } catch (error) {
        console.error('Erro ao obter dados do tempo:', error);
      }
    }
  
  
  
  
  
  
  
  
  
    async function getWeatherData(lat, lon) {
      try {
        const weatherResponse = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum,weathercode&timezone=auto&lang=pt`);
        
        const weatherData = await weatherResponse.json();
        if (weatherResponse.status !== 200) {
          throw new Error(weatherData.error.message);
        }
  
        let forecastContainer = document.getElementById('previsao_container');
        forecastContainer.innerHTML = ''; // Limpa o conteúdo anterior
  
        // Obter o dia atual
        const today = new Date();
  
        // Limitar a exibição para 3 dias
        for (let index = 0; index < 3; index++) {
          const date = new Date(today);
          date.setDate(today.getDate() + index);
  
          let weatherCode = weatherData.daily.weathercode[index]; // Código do clima
          let forecastDay = document.createElement('div');
          forecastDay.className = 'forecast_day';
  
          // Determina o ícone com base no código do clima
          let icon;
          switch (weatherCode) {
            case 0:
              icon = '<ion-icon name="sunny-outline"></ion-icon>'; // Ensolarado
              break;
            case 1:
            case 2:
              icon = '<ion-icon name="partly-sunny-outline"></ion-icon>'; // Parcialmente Nublado
              break;
            case 3:
            case 4:
              icon = '<ion-icon name="cloud-outline"></ion-icon>'; // Nublado
              break;
            case 5:
            case 6:
            case 7:
              icon = '<ion-icon name="rainy-outline"></ion-icon>'; // Chuvoso
              break;
            case 8:
              icon = '<ion-icon name="thunderstorm-outline"></ion-icon>'; // Tempestade
              break;
            case 9:
              icon = '<ion-icon name="snow-outline"></ion-icon>'; // Neve
              break;
            default:
              icon = '<ion-icon name="help-outline"></ion-icon>'; // Ícone padrão
              break;
          }
  
          forecastDay.innerHTML = `
            <div class="dia">
              <div class="data">${date.toLocaleDateString('pt-BR', { weekday: 'long', day: 'numeric', month: 'short' })}</div>
              <div class="icon_thermal" style="font-size: 48px;">${icon}</div>
              <div class="temperaturas">
                <div>Máx: ${Math.round(weatherData.daily.temperature_2m_max[index])}°C</div>
                <div>Mín: ${Math.round(weatherData.daily.temperature_2m_min[index])}°C</div>
                <div>Precipitação: ${weatherData.daily.precipitation_sum[index]} mm</div>
              </div>
            </div>
          `;
          forecastContainer.appendChild(forecastDay);
        }
  
        // Chamar a função para mudar o fundo com base no código do clima e na hora do dia
        const currentWeatherCode = weatherData.daily.weathercode[0]; // Pega o código do clima para o dia atual
        changeBackgroundByTime(currentWeatherCode);
  
      } catch (error) {
        console.error('Erro ao obter dados do tempo:', error);
      }
    }
  
    function changeBackgroundByTime(weatherCode) {
      let body = document.body;
      const currentHour = new Date().getHours();
  
      let backgroundUrl = '';
  
      // Definir o fundo de acordo com o clima e a hora do dia
      if (weatherCode >= 0 && weatherCode <= 2) {
          // Clima ensolarado ou parcialmente nublado
          backgroundUrl = (currentHour >= 18 || currentHour < 6) 
              ? "url('')" // Noite clara
              : "url('')"; // Dia ensolarado
      } else if (weatherCode >= 3 && weatherCode <= 4) {
          // Clima nublado
          backgroundUrl = (currentHour >= 18 || currentHour < 6) 
              ? "url('')" // Noite nublada
              : "url('')"; // Dia nublado
      } else if (weatherCode >= 5 && weatherCode <= 7) {
          // Chuva ou tempestade
          backgroundUrl = (currentHour >= 18 || currentHour < 6) 
              ? "url('')" // Noite chuvosa
              : "url('')"; // Dia chuvoso
      } else {
          // Clima desconhecido ou outros casos
          backgroundUrl = "url('')"; // Fundo padrão
      }
  
      // Aplicar a imagem de fundo
  
  }
  
  //botao
  
  document.getElementById("btn_dados").addEventListener("click", function() {
    window.scrollTo({
        top: document.body.scrollHeight, // Rola até o final da página
        behavior: 'smooth' // Rolagem suave
    });
  });
  