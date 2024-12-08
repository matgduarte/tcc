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
