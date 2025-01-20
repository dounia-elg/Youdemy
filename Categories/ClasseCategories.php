<?php

class Categories {
    
    private int $id;
    private string $nom;
    private PDO $conn;

    
    public function __construct(PDO $conn, string $nom = '', int $id = 0) {
        $this->conn = $conn;
        $this->nom = $nom;
        $this->id = $id;
    }

    
    public function ajouterCategorie(): bool {
        try {
            $stmt = $this->conn->prepare("INSERT INTO categories (nom) VALUES (:nom)");
            $stmt->bindParam(':nom', $this->nom);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout de la catégorie: " . $e->getMessage();
            return false;
        }
    }

   
    public function modifierCategorie(): bool {
        try {
            $stmt = $this->conn->prepare("UPDATE categories SET nom = :nom WHERE id = :id");
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la modification de la catégorie: " . $e->getMessage();
            return false;
        }
    }

    
    public function supprimerCategorie(): bool {
        try {
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la suppression de la catégorie: " . $e->getMessage();
            return false;
        }
    }

    
    public function listeCategories(): array {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des catégories: " . $e->getMessage();
            return [];
        }
    }

    
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }
}
?>
