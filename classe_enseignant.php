<?php
require_once 'classe_utilisateur.php';

class Enseignant extends Utilisateur {
    public array $listeCoursCrees = [];

    public function signup(PDO $conn) {
        $stmt = $conn->prepare("INSERT INTO utilisateur (nom, email, password, role, statut) VALUES (:nom, :email, :password, :role, :statut)");
        $stmt->execute([
            ':nom' => $this->nom,
            ':email' => $this->email,
            ':password' => password_hash($this->password, PASSWORD_BCRYPT),
            ':role' => $this->role,
            ':statut' => $this->statut
        ]);
        echo "Utilisateur $this->nom a été inscrit avec succès.\n";
    }

    public function ajouter_Cours(PDO $conn, $titre, $description, $contenu, $categorie, $tag) {
        $stmt = $conn->prepare("INSERT INTO cours (titre, description, contenu, id_categorie, id_tag, id_enseignant) VALUES (:titre, :description, :contenu, :id_categorie, :id_tag, :id_enseignant)");
        $stmt->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':contenu' => $contenu,
            ':id_categorie' => $categorie,
            ':id_tag' => $tag,
            ':id_enseignant' => $this->id
        ]);
        echo "Cours '$titre' ajouté par l'enseignant $this->nom.\n";
    }

    public function modifier_Cours(PDO $conn, $idCours, $nouveauTitre, $nouvelleDescription, $nouveauContenu, $nouvelleCategorie, $nouveauTag) {
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
            ':id_enseignant' => $this->id
        ]);

        if ($stmt->rowCount() > 0) {
            echo "Le cours ID $idCours a été modifié avec succès par l'enseignant $this->nom.\n";
        } else {
            echo "Échec de la modification du cours ou cours introuvable.\n";
        }
    }

    public function supprimer_Cours(PDO $conn, $idCours) {
        $stmt = $conn->prepare("DELETE FROM cours WHERE id_cour = :id_cour AND id_enseignant = :id_enseignant");
        $stmt->execute([
            ':id_cour' => $idCours,
            ':id_enseignant' => $this->id
        ]);

        if ($stmt->rowCount() > 0) {
            echo "Le cours ID $idCours a été supprimé par l'enseignant $this->nom.\n";
        } else {
            echo "Échec de la suppression du cours ou cours introuvable.\n";
        }
    }

    public function afficher_Statistiques(PDO $conn) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cours WHERE id_enseignant = :id_enseignant");
        $stmt->execute([':id_enseignant' => $this->id]);
        $nombreCours = $stmt->fetchColumn();
        echo "Statistiques pour l'enseignant $this->nom : $nombreCours cours créés.\n";
    }
}

?>
