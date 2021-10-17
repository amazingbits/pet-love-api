<?php

namespace App\Helper;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailHelper
{
    private static string $user = "petlove@guiandrade.com.br";
    private static string $pass = "Senac3229*";
    private static int $port = 587;
    private static string $host = "mail.guiandrade.com.br";
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = self::$host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = self::$user;
        $this->mailer->Password = self::$pass;
        $this->mailer->Port = self::$port;
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
        $this->setFrom();
    }

    public function setFrom(string $fromEmail = "petlove@guiandrade.com.br", string $fromName = "Pet Love"): void
    {
        try {
            $this->mailer->setFrom($fromEmail, $fromName);
        } catch (Exception $e) {
            echo json_encode([
                "message" => "Não foi possível configurar um e-mail de envio!"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function addAddress(string $address): void
    {
        try {
            $this->mailer->addAddress($address);
        } catch (Exception $e) {
            echo json_encode([
                "message" => "Não foi possível adicionar o e-mail {$address} para envio na lista!"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function send(string $body, string $subject = "E-mail de Pet Love"): void
    {
        try {
            $this->mailer->addEmbeddedImage(__DIR__ . "/../../public/media/img/emailheader.png", "logo");
            $html = "<img src='cid:logo' /><br><br>";
            $html .= $body;
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $html;
            $this->mailer->AltBody = strip_tags($body);
            $this->mailer->send();
        } catch (\Exception $e) {
            echo json_encode([
                "message" => "Não foi possível enviar o e-mail!"
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}