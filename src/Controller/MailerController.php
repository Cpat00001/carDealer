<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
        ->from('symfony@cardealer.com')
        ->to('p171982@gmail.com')
        ->subject('Order confirmation')
        // ->text('some information about your car');
        ->htmlTemplate('mailer/email.html.twig')

        //pass variables to the template
        ->context([
            'expiration_date' => new \DateTime('+7days'),
            'dealer' => 'Car Dealer Admin',
            'text' => 'thanks for being our customer we value every your opinion...'
        ]);

        // $mailer->send($email);

       return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }
}
