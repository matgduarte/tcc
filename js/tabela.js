  // Lógica para carregar mais dados sem recarregar a página
  $('#loadMoreBtn').on('click', function() {
    var offset = $(this).data('offset');
    var button = $(this);
    $.ajax({
        url: window.location.href.split('?')[0] + '?ajax=true&offset=' + offset,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                // Adiciona os novos dados na tabela
                data.forEach(function(row) {
                    $('#tableBody').append(
                        '<tr><td>' + row[0] + '</td><td>' + row[1] + '</td><td>' + row[2] + '</td><td>' + row[3] + '</td><td>' + row[4] + '</td></tr>'
                    );
                });

                // Atualiza o offset no botão
                button.data('offset', offset + 15);
            } else {
                button.text('Não há mais dados');
                button.prop('disabled', true); // Desativa o botão quando não houver mais dados
            }
        }
    });
});

// Seleciona o botão pelo ID
const button = document.getElementById("mudarFonte");

// Adiciona o evento de clique
button.addEventListener("click", function () {
  document.body.style.fontFamily = "'MinecraftFont', cursive"; // Muda a fonte
});
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.querySelectorAll('tr[data-valor]');
    
    rows.forEach(row => {
        const valor = row.getAttribute('data-valor');
        const valorCell = row.querySelector('.valor-dados');
        
        let iconHTML = '';
        
        // Aqui você pode definir as condições baseadas no valor de "Valor_Dados" para mostrar os ícones
        if (valor.includes('sol')) {
            iconHTML = `<i class="fas fa-sun weather-icon"></i>`;
        } else if (valor.includes('chuva')) {
            iconHTML = `<i class="fas fa-cloud-rain weather-icon"></i>`;
        } else if (valor.includes('nuvem')) {
            iconHTML = `<i class="fas fa-cloud weather-icon"></i>`;
        } else if (valor.includes('nevoa')) {
            iconHTML = `<i class="fas fa-smog weather-icon"></i>`;
        } else {
            iconHTML = `<i class="fas fa-asterisk weather-icon"></i>`;
        }

        valorCell.innerHTML = iconHTML + valor; // Insere o ícone antes do valor
    });
});
