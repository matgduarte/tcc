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

window.addEventListener("load", function() {
    setTimeout(function open(event) {
        document.querySelector(".olha_o_pix").style.display = "flex";
        document.querySelector(".olha_o_pix").style.filter = "none";
        document.querySelector(".cadastro").style.display = "flex";
        document.querySelector(".cadastro").style.filter = "none";
    }, 1000);
});

document.querySelector("#close").addEventListener("click", function() {
    document.querySelector(".olha_o_pix").style.display = "none";
    document.querySelector(".olha_o_pix").style.filter = "none";
});
document.querySelector("#close2").addEventListener("click", function() {
    document.querySelector(".cadastro").style.display = "none";
    document.querySelector(".cadastro").style.filter = "none";
});
