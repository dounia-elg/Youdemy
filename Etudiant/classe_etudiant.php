<?php
require_once '../classe_utilisateur.php';

class Etudiant extends Utilisateur {
    private array $listeCoursInscrits = [];

    public function __construct(string $nom, string $email, string $password, string $status = 'active') {
        parent::__construct($nom, $email, $password, 'etudiant', $status);
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

    public function inscrire_Cours(PDO $conn, int $coursId) {
        $stmt = $conn->prepare("INSERT INTO etudiant_cours (id_etudiant, id_cours) VALUES (:id_etudiant, :id_cours)");
        $stmt->execute([
            ':id_etudiant' => $this->getId(),
            ':id_cours' => $coursId
        ]);
        echo "L'étudiant {$this->getNom()} est inscrit au cours ID $coursId.\n";
    }

    public function consulter_Cours(PDO $conn) {
        $stmt = $conn->prepare("
            SELECT c.titre 
            FROM cours c 
            JOIN etudiant_cours ec ON c.id_cour = ec.id_cours 
            WHERE ec.id_etudiant = :id_etudiant
        ");
        $stmt->execute([':id_etudiant' => $this->getId()]);
        $this->listeCoursInscrits = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (!empty($this->listeCoursInscrits)) {
            echo "Cours inscrits pour {$this->getNom()}: " . implode(", ", $this->listeCoursInscrits) . "\n";
        } else {
            echo "{$this->getNom()} n'est inscrit à aucun cours.\n";
        }
    }

    public function voirMesCours(PDO $conn) {
        $stmt = $conn->prepare("
            SELECT c.id_cour, c.titre, c.description 
            FROM cours c 
            JOIN etudiant_cours ec ON c.id_cour = ec.id_cours 
            WHERE ec.id_etudiant = :id_etudiant
        ");
        $stmt->execute([':id_etudiant' => $this->getId()]);
        $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($cours)) {
            echo "Voici les cours auxquels {$this->getNom()} est inscrit :\n";
            foreach ($cours as $cour) {
                echo "ID: {$cour['id_cour']}, Titre: {$cour['titre']}, Description: {$cour['description']}\n";
            }
        } else {
            echo "{$this->getNom()} n'est inscrit à aucun cours pour le moment.\n";
        }
    }
}
?>
