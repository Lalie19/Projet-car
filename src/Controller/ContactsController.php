<?php

namespace App\Controller;

class ContactsController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
    // $this->addFlash("color-success", "Coucou" );
        return $this->twig->render('Contacts/index.html.twig');
    }
}
