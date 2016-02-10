<?php

namespace AppBundle\Manager;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

/**
 * Notification Manager
 */
class NotificationManager extends BaseManager
{
    protected $securityContext;
    protected $em;
    protected $mailer;
    private   $templating;

    public function __construct(SecurityContextInterface $securityContext, EntityManager $em, \Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->em               = $em; // récupération de l'entityManager
        $this->mailer           = $mailer;
    }

    /**
     * send function
     *
     * @param  [type] $subject   [description]
     * @param  [type] $body      [description]
     * @param  [type] $sender    [description]
     * @param  [type] $recipient [description]
     * @param  [type] $copy      [description]
     * @param  [type] $cc        [description]
     * @return [type]            [description]
     */
    public function send($subject, $body, $sender, $recipient, $copy = null, $cc = null)
    {
        $message = \Swift_Message::newInstance()
        ->setSubject($subject)
        ->setFrom($sender)
        ->setBcc($copy)
        ->setto($recipient)
        ->setBody($body, 'text/html');
        if ($cc != null) {
            $message->addCc($cc);
        }

        $this->mailer->send($message);
    }
}
