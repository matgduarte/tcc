<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta content="" name="keywords" />

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/header_footer.css" />
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  <title>TCC</title>
</head>

<body>
    <!-- script para enviar o formulário sem sair da página -->
    <script>
      async function enviarFormulario(event) {
          event.preventDefault(); // Prevenir o envio do formulário padrão
  
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
  </script>

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
            <div id="umidade">
              <p>umildade: 50%</p>
            </div>
            <div id="time"></div>
            <div id="conteudo_menor">
              <div id="date"></div>
              <div id="day"></div>
              <div id="temperatura">35°C</div>
            </div>
          </div>
        </section>
        <!--section informação diario-->
        <section id="diario">
          <div class="section_dia">
            <div class="dia_titulo">
              <div class="icon_calendar">
                <ion-icon name="calendar-outline"></ion-icon>
              </div>
              <h2>Previsão para 3 dias</h2>
            </div>
          </div>
          <div class="section_dia">
            <div class="dia">
              <div>hoje</div>
              <div class="icon_thermal">
                <ion-icon name="thermometer-outline"></ion-icon>
              </div>
            </div>
          </div>
          <div class="barra_horizontal"></div>
          <div class="section_dia">
            <div class="dia">
              <div>hoje</div>
              <div class="icon_thermal">
                <ion-icon name="thermometer-outline"></ion-icon>
              </div>
            </div>
          </div>
          <div class="barra_horizontal"></div>
          <div class="section_dia">
            <div class="dia">
              <div>hoje</div>
              <div class="icon_thermal">
                <ion-icon name="thermometer-outline"></ion-icon>
              </div>
            </div>
          </div>
        </section>
      </div>
              <!--section botao mais informações-->
              <section id="sec_btn_dados">
                <div id="div_btn_dados">
                  <button id="btn_dados"></button>
                </div>
              </section>
      <div class="container_main_dados"></div>
    </main>
    <footer>
      <div>
        <div></div>
        <!--idiotas-->
        <div></div>
        <div></div>
      </div>
    </footer>
  </div>
  <script src="js/index.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>