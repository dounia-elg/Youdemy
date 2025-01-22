<?php

class Cours {
    private PDO $conn;
    private ?string $titre;
    private ?string $description;
    private ?string $contenu;
    private ?int $idCategorie;
    private ?int $idEnseignant;
    private ?string $categorie;
    private ?int $id;

    public function __construct(PDO $conn, ?string $titre = null, ?string $description = null, ?string $contenu = null, ?int $idCategorie = null, ?int $idEnseignant = null) {
        $this->conn = $conn;
        $this->titre = $titre;
        $this->description = $description;
        $this->contenu = $contenu;
        $this->idCategorie = $idCategorie;
        $this->idEnseignant = $idEnseignant;
       
    }

    
    public function ajouterCours(): bool {
        try {
            $stmt = $this->conn->prepare("INSERT INTO cours (titre, description, contenu, id_categorie, id_enseignant) 
                                          VALUES (:titre, :description, :contenu, :idCategorie, :idEnseignant)");
            $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
            $stmt->bindParam(':idCategorie', $this->idCategorie, PDO::PARAM_INT);
            $stmt->bindParam(':idEnseignant', $this->idEnseignant, PDO::PARAM_INT);

            return $stmt->execute(); 
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout du cours : " . $e->getMessage();
            return false;
        }
    }

    
    public static function getCoursById($conn, $id_cour) {
        $stmt = $conn->prepare("SELECT * FROM cours WHERE id_cour = :id_cour");
        $stmt->bindParam(':id_cour', $id_cour, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($data) {
            $cours = new Cours(
                $conn,
                $data['titre'],
                $data['description'],
                $data['contenu'],
                $data['id_categorie'],
                $data['id_enseignant']
            );
            $cours->setId($data['id_cour']);
            return $cours;
        }
        return null; 
    }

    public static function getCoursByEnseignant(PDO $conn, $enseignant_id) {
        $query = "
            SELECT 
                cours.id_cour, 
                cours.titre, 
                cours.description, 
                cours.contenu, 
                categories.nom AS categorie_nom, 
                utilisateur.nom AS enseignant_nom 
            FROM 
                cours
            LEFT JOIN 
                categories ON cours.id_categorie = categories.id_categorie
            LEFT JOIN 
                utilisateur ON cours.id_enseignant = utilisateur.id
            WHERE 
                cours.id_enseignant = :id_enseignant
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_enseignant', $enseignant_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

   
    public static function getCategories($conn) {
        $stmt = $conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inscrireCours(int $idEtudiant, int $idCours): bool {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM inscription WHERE id_etudiant = :id_etudiant AND id_cours = :id_cours");
            $stmt->bindParam(':id_etudiant', $idEtudiant, PDO::PARAM_INT);
            $stmt->bindParam(':id_cours', $idCours, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return false;
            }


            $stmt = $this->conn->prepare("INSERT INTO inscription (id_etudiant, id_cours) VALUES (:id_etudiant, :id_cours)");
            $stmt->bindParam(':id_etudiant', $idEtudiant, PDO::PARAM_INT);
            $stmt->bindParam(':id_cours', $idCours, PDO::PARAM_INT);
            return $stmt->execute(); 
        } catch (Exception $e) {
            echo "Erreur lors de l'inscription de l'étudiant : " . $e->getMessage();
            return false;
        }
    }

    
    public function modifierCours(): bool {
        try {
            $stmt = $this->conn->prepare("UPDATE cours 
                                          SET titre = :titre, description = :description, contenu = :contenu, id_categorie = :id_categorie 
                                          WHERE id_cour = :id_cour");
            $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
            $stmt->bindParam(':id_categorie', $this->idCategorie, PDO::PARAM_INT);
            $stmt->bindParam(':id_cour', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur SQL lors de la mise à jour du cours : " . $e->getMessage());
            return false;
        }
    }

    
    public function supprimerCours(PDO $conn): bool {
        $sql = "DELETE FROM cours WHERE id_cour = :id_cour";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cour', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

   
    public function rechercherCours(string $motCle): array {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM cours WHERE titre LIKE :motCle");
            $motCle = '%' . $motCle . '%';
            $stmt->bindParam(':motCle', $motCle, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche de cours : " . $e->getMessage());
            return [];
        }
    }

    
    public function consulterAllCoursPagines(int $page, int $limit): array {
        try {
            $offset = ($page - 1) * $limit;
            $stmt = $this->conn->prepare("SELECT * FROM cours LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours avec pagination : " . $e->getMessage());
            return [];
        }
    }
    
    public function countAllCours(): int {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM cours");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Erreur lors du comptage des cours : " . $e->getMessage());
            return 0;
        }
    }
    

    
    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setContenu(string $contenu): void {
        $this->contenu = $contenu;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

    public function setCategorie(string $categorie): void {
        $this->categorie = $categorie;
    }

    public function getCategorie(): string {
        return $this->categorie;
    }

    
    public function setIdCategorie(int $idCategorie): void {
        $this->idCategorie = $idCategorie;
    }

    public function getIdCategorie(): int {
        return $this->idCategorie;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }
}
?>
