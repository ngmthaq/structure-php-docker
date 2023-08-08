<?php

namespace Src\Mails;

use PHPMailer\PHPMailer\PHPMailer;
use Src\Helpers\Response;

abstract class BaseMail
{
    protected PHPMailer $mailer;

    abstract protected function addAddresses(): array;

    abstract protected function addSubject(): string;

    abstract protected function addBody(): string;

    protected function addBodyData(): array
    {
        return [];
    }

    protected function addReplyToAddresses(): array
    {
        return [];
    }

    protected function addCCAddresses(): array
    {
        return [];
    }

    protected function addBCCAddresses(): array
    {
        return [];
    }

    protected function addAttachments(): array
    {
        return [];
    }

    protected function getMailBodyHtml(string $name, array $data): string
    {
        $res = new Response();
        return $res->getViewHtml($name, $data);
    }

    public function send(): void
    {
        // Config PHPMailer
        $this->mailer = new PHPMailer(true);
        $this->mailer->isHTML(true);
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->CharSet = "UTF-8";
        $this->mailer->Host = $_ENV["MAIL_HOST"];
        $this->mailer->Port = $_ENV["MAIL_PORT"];
        $this->mailer->Username = $_ENV["MAIL_USERNAME"];
        $this->mailer->Password = $_ENV["MAIL_PASSWORD"];
        $this->mailer->setFrom($_ENV["MAIL_ADDRESS"], $_ENV["MAIL_NAME"]);

        // Add addresses
        foreach ($this->addAddresses() as $mail_address) {
            $this->mailer->addAddress($mail_address);
        }

        // Add reply to address
        foreach ($this->addReplyToAddresses() as $mail_address) {
            $this->mailer->addReplyTo($mail_address);
        }

        // Add CC
        foreach ($this->addCCAddresses() as $mail_address) {
            $this->mailer->addCC($mail_address);
        }

        // Add BCC
        foreach ($this->addBCCAddresses() as $mail_address) {
            $this->mailer->addBCC($mail_address);
        }

        // Attachments
        foreach ($this->addAttachments() as $atm) {
            $this->mailer->addAttachment($atm);
        }

        // Subject
        $this->mailer->Subject = $this->addSubject();

        // Body
        $this->mailer->Body = $this->getMailBodyHtml($this->addBody(), $this->addBodyData());

        // Send mail
        $this->mailer->send();
    }
}
