<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $telefone = trim($_POST['phone']);
  $mensagem = trim($_POST['message']);

  $mail = new PHPMailer(true);
  try {
    // **debug de SMTP – remove em produção**
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    // configurações SMTP
    $mail->isSMTP();                                  // <— **IMPORTANTE**
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'seu.usuario@gmail.com';     // seu Gmail
    $mail->Password   = 'sua_app_password';          // senha de app
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // remetente e destinatário
    $mail->setFrom('seu.usuario@gmail.com', 'Clínica Dental');
    $mail->addAddress('destino@provedor.com', 'Recepção Clínica');

    // conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Formulário de Contato — Clínica Dental';
    $mail->Body    = "
      <p><strong>Nome:</strong> {$nome}</p>
      <p><strong>Email:</strong> {$email}</p>
      <p><strong>Telefone:</strong> {$telefone}</p>
      <p><strong>Mensagem:</strong><br>" 
        . nl2br(htmlspecialchars($mensagem)) . 
      "</p>
    ";

    $mail->send();
    echo '<p>👍 Mensagem enviada com sucesso!</p>';
  } catch (Exception $e) {
    echo "<p>❌ Houve um erro ao enviar sua mensagem: {$mail->ErrorInfo}</p>";
  }
}
