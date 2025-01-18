<?php
require_once '../classe_utilisateur.php';

class Enseignant extends Utilisateur {
    private array $listeCoursCrees = [];

    public function __construct(string $nom, string $email, string $password, string $status = 'active') {
        parent::__construct($nom, $email, $password, 'enseignant', $status);
    }

    public function afficherInformations(): void {
        echo "Nom: {$this->getNom()}<br>";
        echo "Email: {$this->getEmail()}<br>";
        echo "Rôle: {$this->getRole()}<br>";
        echo "Statut: {$this->getStatut()}<br>";
    }

    public function signup(PDO $conn) {
        $stmt = $conn->prepare("INSERT INTO utilisateur (nom, email, password, role, status) VALUES (:nom, :email, :password, :role, :status)");
        $stmt->execute([
            ':nom' => $this->getNom(),
            ':email' => $this->getEmail(),
            ':password' => password_hash($this->getPassword(), PASSWORD_BCRYPT),
            ':role' => $this->getRole(),
            ':status' => $this->getStatut()  
        ]);
        echo "Utilisateur {$this->getNom()} a été inscrit avec succès.\n";
    }

    public function ajouter_Cours(PDO $conn, string $titre, string $description, string $contenu, int $categorie, int $tag) {
        $stmt = $conn->prepare("INSERT INTO cours (titre, description, contenu, id_categorie, id_tag, id_enseignant) VALUES (:titre, :description, :contenu, :id_categorie, :id_tag, :id_enseignant)");
        $stmt->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':contenu' => $contenu,
            ':id_categorie' => $categorie,
            ':id_tag' => $tag,
            ':id_enseignant' => $this->getId()
        ]);
        echo "Cours '$titre' ajouté par l'enseignant {$this->getNom()}.\n";
    }

    public function modifier_Cours(PDO $conn, int $idCours, string $nouveauTitre, string $nouvelleDescription, string $nouveauContenu, int $nouvelleCategorie, int $nouveauTag) {
        $stmt = $conn->prepare("
            UPDATE cours 
            SET titre = :titre, description = :description, contenu = :contenu, id_categorie = :id_categorie, id_tag = :id_tag 
            WHERE id_cour = :id_cour AND id_enseignant = :id_enseignant
        ");
        $stmt->execute([
            ':titre' => $nouveauTitre,
            ':description' => $nouvelleDescription,
            ':contenu' => $nouveauContenu,
            ':id_categorie' => $nouvelleCategorie,
            ':id_tag' => $nouveauTag,
            ':id_cour' => $idCours,
            ':id_enseignant' => $this->getId()
        ]);

        if ($stmt->rowCount() > 0) {
            echo "Le cours ID $idCours a été modifié avec succès par l'enseignant {$this->getNom()}.\n";
        } else {
            echo "Échec de la modification du cours ou cours introuvable.\n";
        }
    }

    public function supprimer_Cours(PDO $conn, int $idCours) {
        $stmt = $conn->prepare("DELETE FROM cours WHERE id_cour = :id_cour AND id_enseignant = :id_enseignant");
        $stmt->execute([
            ':id_cour' => $idCours,
            ':id_enseignant' => $this->getId()
        ]);

        if ($stmt->rowCount() > 0) {
            echo "Le cours ID $idCours a été supprimé par l'enseignant {$this->getNom()}.\n";
        } else {
            echo "Échec de la suppression du cours ou cours introuvable.\n";
        }
    }

    public function afficher_Statistiques(PDO $conn) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cours WHERE id_enseignant = :id_enseignant");
        $stmt->execute([':id_enseignant' => $this->getId()]);
        $nombreCours = $stmt->fetchColumn();
        echo "Statistiques pour l'enseignant {$this->getNom()} : $nombreCours cours créés.\n";
    }
}
?>
