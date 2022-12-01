<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\Contacts1Type;
use App\Repository\ContactsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contacts')]
class ContactsController extends AbstractController
{
    #[Route('/', name: 'app_contacts_index', methods: ['GET'])]
    public function index(ContactsRepository $contactsRepository): Response
    {
        return $this->render('contacts/index.html.twig', [
            'contacts' => $contactsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contacts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactsRepository $contactsRepository): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(Contacts1Type::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $contactsRepository->save($contact, true);

            return $this->redirectToRoute('app_contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacts_show', methods: ['GET'])]
    public function show(Contacts $contact): Response
    {
        return $this->render('contacts/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contacts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contacts $contact, ContactsRepository $contactsRepository): Response
    {
        $form = $this->createForm(Contacts1Type::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactsRepository->save($contact, true);

            return $this->redirectToRoute('app_contacts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacts/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacts_delete', methods: ['POST'])]
    public function delete(Request $request, Contacts $contact, ContactsRepository $contactsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactsRepository->remove($contact, true);
        }

        return $this->redirectToRoute('app_contacts_index', [], Response::HTTP_SEE_OTHER);
    }
}
