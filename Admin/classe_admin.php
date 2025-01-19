<?php
require_once '../classe_utilisateur.php';

class Admin extends Utilisateur {
    public function __construct(string $nom, string $email, string $password, string $status = 'active') {
        parent::__construct($nom, $email, $password, 'admin', $status);
    }

    
    public function ValiderComptesEnseignants(PDO $conn, int $idEnseignant): void {
        $stmt = $conn->prepare("UPDATE utilisateur SET est_valide = TRUE WHERE id = :id AND role = 'enseignant'");
        $stmt->execute([':id' => $idEnseignant]);
        echo "Compte enseignant ID $idEnseignant validé avec succès.\n";
    }

    
    public function ActiverUtilisateurs(PDO $conn, int $idUtilisateur): void {
        $stmt = $conn->prepare("UPDATE utilisateur SET status = 'active' WHERE id = :id");
        $stmt->execute([':id' => $idUtilisateur]);
        echo "Utilisateur ID $idUtilisateur activé avec succès.\n";
    }

    
    public function SuspenserUtilisateurs(PDO $conn, int $idUtilisateur): void {
        $stmt = $conn->prepare("UPDATE utilisateur SET status = 'suspended' WHERE id = :id");
        $stmt->execute([':id' => $idUtilisateur]);
        echo "Utilisateur ID $idUtilisateur suspendu avec succès.\n";
    }

    
    public function SupprimerUtilisateurs(PDO $conn, int $idUtilisateur): void {
        $stmt = $conn->prepare("DELETE FROM utilisateur WHERE id = :id");
        $stmt->execute([':id' => $idUtilisateur]);
        echo "Utilisateur ID $idUtilisateur supprimé avec succès.\n";
    }

   
    public function NombreTotalCours(PDO $conn): int {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_cours FROM cours");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_cours'];
    }

    
    public function RepartirParCategorie(PDO $conn): array {
        $stmt = $conn->prepare("
            SELECT c.nom AS categorie, COUNT(cr.id_cour) AS nombre_cours 
            FROM categories c 
            LEFT JOIN cours cr ON c.id_categorie = cr.id_categorie 
            GROUP BY c.id_categorie
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function CourAvecPlusEtudiants(PDO $conn): array {
        $stmt = $conn->prepare("
            SELECT cr.titre, COUNT(e.id) AS nombre_etudiants 
            FROM cours cr 
            JOIN inscriptions i ON cr.id_cour = i.id_cour
            JOIN utilisateur e ON i.id_etudiant = e.id
            GROUP BY cr.id_cour 
            ORDER BY nombre_etudiants DESC 
            LIMIT 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function Top3Enseignants(PDO $conn): array {
        $stmt = $conn->prepare("
            SELECT u.nom AS enseignant, COUNT(cr.id_cour) AS nombre_cours 
            FROM utilisateur u 
            JOIN cours cr ON u.id = cr.id_enseignant
            WHERE u.role = 'enseignant'
            GROUP BY u.id 
            ORDER BY nombre_cours DESC 
            LIMIT 3
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
