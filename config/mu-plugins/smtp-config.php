<?php
/**
 * Plugin Name: SMTP Configuration
 * Description: Configure WordPress to use SMTP for emails
 * Version: 0.1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Переопределяем функцию wp_mail
if (!function_exists('wp_mail')) {
    function wp_mail($to, $subject, $message, $headers = '', $attachments = array()) {
        // Создаем глобальный объект PHPMailer
        global $phpmailer;

        // Убеждаемся что PHPMailer инициализирован
        if (!($phpmailer instanceof PHPMailer\PHPMailer\PHPMailer)) {
            require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
            require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
            require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
            $phpmailer = new PHPMailer\PHPMailer\PHPMailer(true);
        }

        try {
            // Очищаем все предыдущие настройки
            $phpmailer->clearAllRecipients();
            $phpmailer->clearAttachments();
            $phpmailer->clearCustomHeaders();
            $phpmailer->clearReplyTos();

            // Настройка SMTP
            $phpmailer->isSMTP();
            $phpmailer->Host = 'mailpit';
            $phpmailer->Port = 1025;
            $phpmailer->SMTPAuth = false;
            $phpmailer->SMTPAutoTLS = false;
            $phpmailer->SMTPSecure = '';

            // Установка отправителя
            $phpmailer->From = 'wordpress@example.com';
            $phpmailer->FromName = 'WordPress Site';

            // Добавление получателя
            if (is_array($to)) {
                foreach ($to as $recipient) {
                    $phpmailer->addAddress($recipient);
                }
            } else {
                $phpmailer->addAddress($to);
            }

            // Установка темы и сообщения
            $phpmailer->Subject = $subject;
            $phpmailer->Body = $message;
            $phpmailer->isHTML(false);

            // Отправка
            return $phpmailer->send();
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $e->getMessage());
            return false;
        }
    }
}