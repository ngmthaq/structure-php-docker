<?php

namespace Src\Mails;

use eftec\bladeone\BladeOne;
use PHPMailer\PHPMailer\PHPMailer;
use Src\Helpers\DateTime;
use Src\Helpers\Dir;
use stdClass;

abstract class BaseMail extends stdClass
{
    /**
     * PHPMailer instance
     */
    protected PHPMailer $mailer;

    /**
     * Add addresses
     * 
     * @return array
     */
    abstract protected function addAddresses(): array;

    /**
     * Add subject
     * 
     * @return string
     */
    abstract protected function addSubject(): string;

    /**
     * Add body template
     * 
     * @return string
     */
    abstract protected function addBody(): string;

    /**
     * Add body data
     * 
     * @return array
     */
    protected function addBodyData(): array
    {
        return [];
    }

    /**
     * Add addresses
     * 
     * @return array
     */
    protected function addReplyToAddresses(): array
    {
        return [];
    }

    /**
     * Add addresses
     * 
     * @return array
     */
    protected function addCCAddresses(): array
    {
        return [];
    }

    /**
     * Add addresses
     * 
     * @return array
     */
    protected function addBCCAddresses(): array
    {
        return [];
    }

    /**
     * Add attachments
     * 
     * @return array
     */
    protected function addAttachments(): array
    {
        return [];
    }

    /**
     * Get mail body html
     * 
     * @param string $name
     * @param array $data
     * @return string
     */
    protected function getMailBodyHtml(string $name, array $data): string
    {
        $cached_view_dir = Dir::getDirFromSrc("/Cached/Views");
        if (!file_exists($cached_view_dir)) mkdir($cached_view_dir);
        $view_dir = Dir::getDirFromSrc("/Views");
        $blade = new BladeOne($view_dir, $cached_view_dir, BladeOne::MODE_DEBUG);
        $blade->pipeEnable = true;
        $blade->addAliasClasses("Auth", Auth::class);
        $blade->addAliasClasses("Common", Common::class);
        $blade->addAliasClasses("Cookies", Cookies::class);
        $blade->addAliasClasses("Dev", Dev::class);
        $blade->addAliasClasses("Dir", Dir::class);
        $blade->addAliasClasses("Hash", Hash::class);
        $blade->addAliasClasses("Header", Header::class);
        $blade->addAliasClasses("Lang", Lang::class);
        $blade->addAliasClasses("Number", Number::class);
        $blade->addAliasClasses("Session", Session::class);
        $blade->addAliasClasses("Str", Str::class);
        $blade->addAliasClasses("DateTime", DateTime::class);
        return $blade->run($name, $data);
    }

    /**
     * Send mail
     * 
     * @return void
     */
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
