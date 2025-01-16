<?php
class Utilisateur {
    public int $id;
    public string $nom;
    public string $email;
    public string $password;
    public string $role;
    public string $statut;

    // public function signup(PDO $conn) {
    //     $stmt = $conn->prepare("INSERT INTO utilisateur (nom, email, password, role, statut) VALUES (:nom, :email, :password, :role, :statut)");
    //     $stmt->execute([
    //         ':nom' => $this->nom,
    //         ':email' => $this->email,
    //         ':password' => password_hash($this->password, PASSWORD_BCRYPT),
    //         ':role' => $this->role,
    //         ':statut' => $this->statut
    //     ]);
    //     echo "Utilisateur $this->nom a été inscrit avec succès.\n";
    // }

    public function login(PDO $conn) {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute([':email' => $this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            echo "Utilisateur $this->email est connecté.\n";
        } else {
            echo "Échec de la connexion.\n";
        }
    }

    public function logout() {
        echo "Utilisateur $this->email est déconnecté.\n";
    }
}

?>