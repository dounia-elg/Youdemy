<?php
require_once 'classe_utilisateur.php';

class Etudiant extends Utilisateur {
    public array $listeCoursInscrits = [];

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

    public function inscrire_Cours(PDO $conn, $coursId) {
        $stmt = $conn->prepare("INSERT INTO etudiant_cours (id_etudiant, id_cours) VALUES (:id_etudiant, :id_cours)");
        $stmt->execute([
            ':id_etudiant' => $this->id,
            ':id_cours' => $coursId
        ]);
        echo "L'étudiant $this->nom est inscrit au cours ID $coursId.\n";
    }

    public function consulter_Cours(PDO $conn) {
        $stmt = $conn->prepare("SELECT c.titre FROM cours c JOIN etudiant_cours ec ON c.id_cour = ec.id_cours WHERE ec.id_etudiant = :id_etudiant");
        $stmt->execute([':id_etudiant' => $this->id]);
        $this->listeCoursInscrits = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "Cours inscrits pour $this->nom : ".implode(", ", $this->listeCoursInscrits)."\n";
    }

    public function voirMesCours(PDO $conn) {
        $stmt = $conn->prepare("
            SELECT c.id_cour, c.titre, c.description 
            FROM cours c 
            JOIN etudiant_cours ec ON c.id_cour = ec.id_cours 
            WHERE ec.id_etudiant = :id_etudiant
        ");
        $stmt->execute([':id_etudiant' => $this->id]);
        $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($cours)) {
            echo "Voici les cours auxquels $this->nom est inscrit :\n";
            foreach ($cours as $cour) {
                echo "ID: {$cour['id_cour']}, Titre: {$cour['titre']}, Description: {$cour['description']}\n";
            }
        } else {
            echo "$this->nom n'est inscrit à aucun cours pour le moment.\n";
        }
    }
}
?>
