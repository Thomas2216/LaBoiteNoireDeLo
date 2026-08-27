<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    private const RECIPIENT = 'laboitenoire@laurajoly.fr';

    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function show(): Response
    {
        $form = $this->createForm(ContactType::class);

        return $this->render('contact/show.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/contact', name: 'contact_send', methods: ['POST'])]
    public function send(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from('no-reply@laboitenoiredelo.fr')
                ->to(self::RECIPIENT)
                ->replyTo($data['email'])
                ->subject(sprintf('[Site] Nouvelle demande - %s', $data['prestation']))
                ->text(sprintf(
                    "Nom : %s\nEmail : %s\nPrestation : %s\n\nMessage :\n%s",
                    $data['nom'],
                    $data['email'],
                    $data['prestation'],
                    $data['message'],
                ));

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien ete envoye, je reviens vers vous rapidement.');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/show.html.twig', [
            'form' => $form,
        ]);
    }
}
