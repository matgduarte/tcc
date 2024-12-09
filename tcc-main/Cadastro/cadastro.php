<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .message {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: rgba(0, 0, 0, 0.8);
      color: #fff;
      padding: 10px 15px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      font-size: 14px;
      text-align: center;
      animation: fadeInOut 4s forwards;
    }
    .message.error {
      background-color: rgba(255, 0, 0, 0.8);
    }
    @keyframes fadeInOut {
      0% { opacity: 0; }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% { opacity: 0; }
    }
    .phone-input {
      width: 100%;
      max-width: 300px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
  </style>
  <script>
    function formatPhoneNumber(input) {
      let value = input.value.replace(/\D/g, '');
      value = value.substring(0, 11);
      
      if (value.length > 2) {
        value = `+55 (${value.substring(0, 2)}) ${value.substring(2, 7)}-${value.substring(7, 11)}`;
      } else if (value.length > 0) {
        value = `+55 (${value}`;
      }
      
      input.value = value;
    }
  </script>
</head>
<body>
<?php 
    include('../includes/conexao.php');

    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function checkEmailDomain($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, "MX");
    }

    function sanitizePhoneNumber($phone) {
        // Remove tudo que não é número
        return preg_replace('/\D/', '', $phone);
    }

    // Dados Pessoa
    $Nome_Usuario = $_POST['nome_usuario'] ?? '';
    $Email_Usuario = $_POST['email'] ?? '';
    $Telefone_Usuario = $_POST['telefone'] ?? '';

    // Variáveis de erro
    $emailError = false;
    $phoneError = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($Nome_Usuario) && !empty($Email_Usuario) && !empty($Telefone_Usuario)) {
            // Proteção contra SQL Injection
            $Nome_Usuario = mysqli_real_escape_string($con, $Nome_Usuario);
            $Email_Usuario = mysqli_real_escape_string($con, $Email_Usuario);
            $Telefone_Usuario = mysqli_real_escape_string($con, $Telefone_Usuario);

            // Validação de e-mail
            if (!validateEmail($Email_Usuario) || !checkEmailDomain($Email_Usuario)) {
                $emailError = true;
            }

            // Validação de telefone (removido o padrão de formato internacional)
            if (empty($Telefone_Usuario)) {
                $phoneError = true;
            }

            if ($emailError && $phoneError) {
                echo "<div class='message error'>Erro: E-mail e número de telefone são inválidos!</div>";
            } elseif ($emailError) {
                echo "<div class='message error'>Erro: E-mail inválido!</div>";
            } elseif ($phoneError) {
                echo "<div class='message error'>Erro: Número de telefone não pode estar vazio!</div>";
            } else {
                // Verificar se já existe um cadastro com os mesmos dados
                $sql_check = "SELECT * FROM Usuario WHERE Email_Usuario = '$Email_Usuario' OR Telefone_Usuario = '" . sanitizePhoneNumber($Telefone_Usuario) . "'";
                $result_check = mysqli_query($con, $sql_check);

                if (mysqli_num_rows($result_check) > 0) {
                    // Cadastro já existe
                    echo "<div class='message error'>Erro: Já existe um cadastro com este e-mail ou telefone!</div>";
                } else {
                    // Inserir novo cadastro
                    $sql = "INSERT INTO Usuario (Nome_Usuario, Email_Usuario, Telefone_Usuario) VALUES ('$Nome_Usuario', '$Email_Usuario', '" . sanitizePhoneNumber($Telefone_Usuario) . "')";
                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        echo "<div class='message'>Dados cadastrados com sucesso!</div>";
                    } else {
                        echo "<div class='message error'>Erro ao cadastrar: " . mysqli_error($con) . "</div>";
                    }
                }
            }
        } else {
            echo "<div class='message error'>Erro: Todos os campos são obrigatórios!</div>";
        }
    }
?>
</body>
</html>
