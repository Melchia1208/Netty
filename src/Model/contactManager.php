<?php
namespace Model;

class contactManager extends AbstractManager {

    const TABLE = 'contact';

    public function __construct($pdo) {
        parent::__construct(self::TABLE, $pdo);
    }

//    INSERER UN NOUVEAU CONTACT DANS LA BASE DE DONNEES
    public function insert(Contact $contact): int {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (nom, prenom, tel, email, ville) VALUES (:lastname, :firstname, :number, :email, :town)");
        $statement->bindValue('lastname', $contact->getNom(), \PDO::PARAM_STR);
        $statement->bindValue('firstname', $contact->getPrenom(), \PDO::PARAM_STR);
        $statement->bindValue('number', $contact->getTel(), \PDO::PARAM_STR);
        $statement->bindValue('email', $contact->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue('town', $contact->getVille(), \PDO::PARAM_STR);

        if ($statement->execute()) {
            return $this->pdo->lastInsertId();
        }
    }

//    MODIFIER LES DONNEES D'UN CONTACT DANS LA BASE DE DONNEES
    public function update(Contact $contact)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET nom = :lastname, prenom = :firstname, tel = :number, email = :email, ville = :town WHERE id=:id");
        $statement->bindValue('id', $contact->getId(), \PDO::PARAM_INT);
        $statement->bindValue('lastname', $contact->getNom(), \PDO::PARAM_STR);
        $statement->bindValue('firstname', $contact->getPrenom(), \PDO::PARAM_STR);
        $statement->bindValue('number', $contact->getTel(), \PDO::PARAM_STR);
        $statement->bindValue('email', $contact->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue('town', $contact->getVille(), \PDO::PARAM_STR);

        return $statement->execute();
    }
}
