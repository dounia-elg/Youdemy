<?php

class Cours {
    private PDO $conn;
    private string $titre;
    private string $description;
    private string $contenu;
    private int $idCategorie;
    private int $idEnseignant;

    public function __construct(PDO $conn, string $titre, string $description, string $contenu, int $idCategorie, int $idEnseignant) {
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

            if ($stmt->execute()) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Erreur SQL : " . $errorInfo[2];
                return false;
            }
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout du cours : " . $e->getMessage();
            return false;
        }
    }





    // Modifier un cours
    public function modifierCours(): bool {
        try {
            $stmt = $this->conn->prepare("UPDATE cours SET titre = :titre, description = :description, contenu = :contenu, categorie = :categorie WHERE id_cours = :id");
            $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':contenu', $this->contenu, PDO::PARAM_STR);
            $stmt->bindParam(':categorie', $this->categorie, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification du cours : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un cours
    public function supprimerCours(): bool {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cours WHERE id_cours = :id");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du cours : " . $e->getMessage());
            return false;
        }
    }

    // Rechercher un cours par titre
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

    // Consulter tous les cours
    public function consulterAllCours(): array {
        try {
            $stmt = $this->conn->query("SELECT * FROM cours");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des cours : " . $e->getMessage());
            return [];
        }
    }

    // Setters et Getters
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

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }
}

?>
