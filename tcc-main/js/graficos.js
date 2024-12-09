// humidade
// Função para criar o gráfico de índice UV
function createUVGauge(uvValue, containerId) {
    // Função para determinar o ícone baseado no valor do índice UV
    function getUVIcon(uv) {
        if (uv <= 3) {
            return "https://openweathermap.org/img/wn/01d.png"; // Baixo
        } else if (uv <= 6) {
            return "https://openweathermap.org/img/wn/02d.png"; // Moderado
        } else if (uv <= 8) {
            return "https://openweathermap.org/img/wn/03d.png"; // Alto
        } else {
            return "https://openweathermap.org/img/wn/04d.png"; // Muito alto
        }
    }

    // Ajustando o tamanho do gráfico baseado no contêiner
    const width = document.getElementById(containerId).offsetWidth;
    const height = document.getElementById(containerId).offsetHeight;
    const outerRadius = Math.min(width, height) / 2 - 10; // Raio externo
    const innerRadius = outerRadius * 0.75; // Raio interno

    // Criando o SVG
    const svg = d3.create("svg")
        .attr("viewBox", `0 0 ${width} ${height}`)
        .attr("width", "100%")
        .attr("height", "100%");

    // Centralizando o gráfico
    const g = svg.append("g")
        .attr("transform", `translate(${width / 2}, ${height / 2})`);

    // Definindo a função de arco
    const arc = d3.arc()
        .innerRadius(innerRadius)
        .outerRadius(outerRadius)
        .startAngle(0);

    // Fundo do gráfico
    const background = g.append("path")
        .datum({ endAngle: 2 * Math.PI }) // Todo o círculo
        .style("fill", "#ddd")
        .attr("d", arc);

    // Gráfico de UV (preenchendo de acordo com o valor de UV)
    const foreground = g.append("path")
        .datum({ endAngle: (uvValue / 10) * 2 * Math.PI }) // A porção baseada no valor de UV (0-10)
        .style("fill", uvValue <= 3 ? "green" : uvValue <= 6 ? "yellow" : uvValue <= 8 ? "orange" : "red") // Cor baseado no valor de UV
        .attr("d", arc);

    // Ícone no centro do gráfico, baseado no valor de UV
    const iconUrl = getUVIcon(uvValue);

    const icon = g.append("image")
        .attr("x", -24) // Centraliza horizontalmente
        .attr("y", -24) // Centraliza verticalmente
        .attr("width", 48) // Tamanho do ícone
        .attr("height", 48) // Tamanho do ícone
        .attr("xlink:href", iconUrl);

    // Adicionando o gráfico no contêiner
    document.getElementById(containerId).appendChild(svg.node());
}

// Função para criar o gráfico de umidade
function createHumidityGauge(humidityValue, containerId) {
    // Função para determinar o ícone baseado no valor de umidade
    function getHumidityIcon(humidity) {
        if (humidity <= 30) {
            return "https://openweathermap.org/img/wn/10d.png"; // Ícone para umidade baixa
        } else if (humidity <= 60) {
            return "https://openweathermap.org/img/wn/03d.png"; // Ícone para umidade moderada
        } else {
            return "https://openweathermap.org/img/wn/04d.png"; // Ícone para umidade alta
        }
    }

    // Ajustando o tamanho do gráfico baseado no contêiner
    const width = document.getElementById(containerId).offsetWidth;
    const height = document.getElementById(containerId).offsetHeight;
    const outerRadius = Math.min(width, height) / 2 - 10; // Raio externo
    const innerRadius = outerRadius * 0.75; // Raio interno

    // Criando o SVG
    const svg = d3.create("svg")
        .attr("viewBox", `0 0 ${width} ${height}`)
        .attr("width", "100%")
        .attr("height", "100%");

    // Centralizando o gráfico
    const g = svg.append("g")
        .attr("transform", `translate(${width / 2}, ${height / 2})`);

    // Definindo a função de arco
    const arc = d3.arc()
        .innerRadius(innerRadius)
        .outerRadius(outerRadius)
        .startAngle(0);

    // Fundo do gráfico
    const background = g.append("path")
        .datum({ endAngle: 2 * Math.PI }) // Todo o círculo
        .style("fill", "#ddd")
        .attr("d", arc);

    // Gráfico de Umidade (preenchendo de acordo com o valor de umidade)
    const foreground = g.append("path")
        .datum({ endAngle: (humidityValue / 100) * 2 * Math.PI }) // A porção baseada no valor de umidade (0-100)
        .style("fill", humidityValue <= 30 ? "blue" : humidityValue <= 60 ? "orange" : "green") // Cor baseado no valor de umidade
        .attr("d", arc);

    // Ícone no centro do gráfico, baseado no valor de umidade
    const iconUrl = getHumidityIcon(humidityValue);

    const icon = g.append("image")
        .attr("x", -24) // Centraliza horizontalmente
        .attr("y", -24) // Centraliza verticalmente
        .attr("width", 48) // Tamanho do ícone
        .attr("height", 48) // Tamanho do ícone
        .attr("xlink:href", iconUrl);

    // Adicionando o gráfico no contêiner
    document.getElementById(containerId).appendChild(svg.node());
}
//Pressao
function createEnhancedPressureGauge(pressureValue, containerId) {
    const maxPressure = 2; // Valor máximo de pressão
    const container = document.getElementById(containerId);
    const width = container.offsetWidth || 300; // Largura padrão
    const height = width; // Altura igual à largura para um medidor circular
    const outerRadius = width / 2 - 20; // Raio externo
    const innerRadius = outerRadius * 0.8; // Raio interno

    // Criando o SVG
    const svg = d3.create("svg")
        .attr("viewBox", `0 0 ${width} ${height}`)
        .attr("width", "100%")
        .attr("height", "100%");

    // Grupo centralizado
    const g = svg.append("g")
        .attr("transform", `translate(${width / 2}, ${height / 2})`);

    // Escala de cores para o fundo
    const gradient = svg.append("defs")
        .append("linearGradient")
        .attr("id", "gradient")
        .attr("x1", "0%")
        .attr("y1", "100%")
        .attr("x2", "0%")
        .attr("y2", "0%");

    gradient.append("stop")
        .attr("offset", "0%")
        .attr("stop-color", "#00c6ff");
    gradient.append("stop")
        .attr("offset", "100%")
        .attr("stop-color", "#0072ff");

    // Fundo do medidor (arco completo)
    g.append("path")
        .datum({ endAngle: Math.PI })
        .style("fill", "url(#gradient)")
        .attr("d", d3.arc()
            .innerRadius(innerRadius)
            .outerRadius(outerRadius)
            .startAngle(-Math.PI / 2)
        );

    // Ponteiro
    const pointerLength = outerRadius * 0.9;
    const pointerWidth = 6;

    const pointerGroup = g.append("g")
        .attr("class", "pointer");

    pointerGroup.append("line")
        .attr("x1", 0)
        .attr("y1", 0)
        .attr("x2", 0)
        .attr("y2", -pointerLength)
        .attr("stroke", "black")
        .attr("stroke-width", pointerWidth)
        .attr("stroke-linecap", "round")
        .attr("transform", `rotate(${-90 + (pressureValue / maxPressure) * 180})`);

    // Centro do ponteiro
    g.append("circle")
        .attr("r", 10)
        .attr("fill", "#333");

    // Texto indicando o valor de pressão
    g.append("text")
        .attr("y", height / 4)
        .attr("text-anchor", "middle")
        .style("font-family", "Arial, sans-serif")
        .style("font-size", "20px")
        .style("font-weight", "bold")
        .text(`${pressureValue.toFixed(2)} ATM`);

    // Adicionando o SVG ao contêiner
    container.appendChild(svg.node());
}
//Vento
function createWindCompass(windSpeed, windDirection, containerId) {
    const container = document.getElementById(containerId);
    const width = container.offsetWidth || 300;
    const height = width;
    const radius = Math.min(width, height) / 2 - 20;

    // Criando o SVG
    const svg = d3.create("svg")
        .attr("viewBox", `0 0 ${width} ${height}`)
        .attr("width", "100%")
        .attr("height", "100%");

    // Grupo centralizado
    const g = svg.append("g")
        .attr("transform", `translate(${width / 2}, ${height / 2})`);

    // Fundo do medidor (círculo externo para dar profundidade)
    g.append("circle")
        .attr("r", radius + 10)  // Círculo maior para a borda externa
        .attr("fill", "#e0f7fa")
        .attr("stroke", "#0097A7") // Borda externa mais escura
        .attr("stroke-width", 4);

    // Círculo interno da bússola
    g.append("circle")
        .attr("r", radius)
        .attr("fill", "#fff")
        .attr("stroke", "#0097A7")
        .attr("stroke-width", 2);

    // Indicadores de direção (N, S, L, O)
    const directions = ["N", "L", "S", "O"];
    const angleOffset = 90; // Ajuste de ângulo para as direções
    directions.forEach((dir, index) => {
        const angle = (index * 90) - angleOffset;
        g.append("text")
            .attr("x", Math.cos(Math.PI * (angle / 180)) * (radius - 20))
            .attr("y", Math.sin(Math.PI * (angle / 180)) * (radius - 20))
            .attr("text-anchor", "middle")
            .style("font-family", "Arial, sans-serif")
            .style("font-size", "18px")
            .style("font-weight", "bold")
            .style("fill", "#00796B")
            .text(dir);
    });

    // Texto da velocidade do vento
    g.append("text")
        .attr("y", 10)
        .attr("text-anchor", "middle")
        .style("font-family", "Arial, sans-serif")
        .style("font-size", "36px")
        .style("font-weight", "bold")
        .style("fill", "#333")
        .text(`${windSpeed.toFixed(1)} km/h`);

    // Setor de direção do vento (ícone da seta)
    const arrowSize = 40; // Tamanho da seta

    g.append("line")
        .attr("x1", 0)
        .attr("y1", 0)
        .attr("x2", 0)
        .attr("y2", -radius + arrowSize)
        .attr("stroke", "#00796B")
        .attr("stroke-width", 4)
        .attr("transform", `rotate(${windDirection})`)
        .transition()
        .duration(1000)
        .ease(d3.easeElastic); // Animação suave para a seta

    // Colocando o SVG no contêiner
    container.appendChild(svg.node());
}
//Direção
function createWindRose(windDirection, containerId) {
    const container = document.getElementById(containerId);
    const width = container.offsetWidth || 300;
    const height = width;
    const radius = Math.min(width, height) / 2;

    // Criando o SVG para a Rosa dos Ventos com fundo transparente
    const svg = d3.create("svg")
        .attr("viewBox", `0 0 ${width} ${height}`)
        .attr("width", "100%")
        .attr("height", "100%")
        .style("background", "transparent"); // Fundo transparente

    // Grupo centralizado
    const g = svg.append("g")
        .attr("transform", `translate(${width / 2}, ${height / 2})`);

    // Direções cardeais (N, S, E, W, NE, etc) com estilo cartoon
    const directions = [
        { angle: 0, label: 'N', icon: '⬆️' },
        { angle: 45, label: 'NE', icon: '↗️' },
        { angle: 90, label: 'E', icon: '➡️' },
        { angle: 135, label: 'SE', icon: '↘️' },
        { angle: 180, label: 'S', icon: '⬇️' },
        { angle: 225, label: 'SW', icon: '↙️' },
        { angle: 270, label: 'W', icon: '⬅️' },
        { angle: 315, label: 'NW', icon: '↖️' }
    ];

    // Adicionando as linhas das direções cardeais
    directions.forEach(dir => {
        g.append("line")
            .attr("x1", 0)
            .attr("y1", 0)
            .attr("x2", Math.cos(Math.PI * dir.angle / 180) * (radius - 20))
            .attr("y2", Math.sin(Math.PI * dir.angle / 180) * (radius - 20))
            .attr("stroke", "#00B0FF") // Cor do vento (azul claro)
            .attr("stroke-width", 3);

        // Ícones das direções (emojis)
        g.append("text")
            .attr("x", Math.cos(Math.PI * dir.angle / 180) * (radius - 35))
            .attr("y", Math.sin(Math.PI * dir.angle / 180) * (radius - 35))
            .attr("text-anchor", "middle")
            .attr("alignment-baseline", "middle")
            .attr("font-size", "30px")
            .attr("fill", "#00B0FF")
            .text(dir.icon); // Emojis das direções
    });

    // Adicionando a seta para indicar a direção do vento
    const arrow = g.append("line")
        .attr("x1", 0)
        .attr("y1", 0)
        .attr("x2", 0)
        .attr("y2", -radius + 40)
        .attr("stroke", "#FF4081") // Cor da seta (rosa vibrante)
        .attr("stroke-width", 6)
        .attr("stroke-linecap", "round") // Bordas arredondadas para a seta
        .attr("transform", `rotate(${windDirection})`)
        .transition()
        .duration(1000)
        .ease(d3.easeElastic); // Animação suave

    // Colocando o SVG no contêiner
    container.appendChild(svg.node());
}