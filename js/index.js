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