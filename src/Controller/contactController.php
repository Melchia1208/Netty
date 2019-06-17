<?php

namespace Controller;
use Model\contactManager;
use Model\Contact;

class ContactController extends AbstractController
{
    protected $twig;

//    FONCTION POUR CREER LA VUE DE BASE
    public function home()
    {
        $contactManager = new contactManager($this->pdo);
        $contacts = $contactManager->selectAll();

        return $this->twig->render('home.html.twig', ['contacts' => $contacts]);
    }

//    FONCTION POUR CREER UN NOUVEAU CONTACT
    public function add() {

        if ($_POST) {
            $contact = new Contact();
            $contact->setNom(strtoupper($_POST['lastname']));
            $contact->setPrenom($_POST['firstname']);
            $contact->setTel($_POST['number']);
            $contact->setEmail($_POST['email']);
            $contact->setVille($_POST['town']);
            $contactManager = new contactManager($this->pdo);
            echo $contactManager->insert($contact);
        }
    }

//    FONCTION DE RECUPERATION DES DONNEES D'UN CONTACT
    public function update($id) {

        $contactManager = new contactManager($this->pdo);
        $contact = $contactManager->selectOneById($id);
        $tableau['id'] = $contact->getId();
        $tableau['nom'] = $contact->getNom();
        $tableau['prenom'] = $contact->getPrenom();
        $tableau['tel'] = $contact->getTel();
        $tableau['email'] = $contact->getEmail();
        $tableau['ville'] = $contact->getVille();
        echo json_encode($tableau);
    }

//    FONCTION POUR MODIFIER LES DONNEES D'UN CONTACT
    public function change($id) {

        if ($_POST) {

            $contactManager = new contactManager($this->pdo);
            $contact = $contactManager->selectOneById($id);
            $contact->setNom(strtoupper($_POST['lastname']));
            $contact->setPrenom($_POST['firstname']);
            $contact->setTel($_POST['number']);
            $contact->setEmail($_POST['email']);
            $contact->setVille($_POST['town']);
            $contactManager->update($contact);
        }
    }
}
