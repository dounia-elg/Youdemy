<?php
class Utilisateur {
    protected int $id;
    protected string $nom;
    protected string $email;
    protected string $password;
    protected string $role;
    protected string $statut;

    
    public function login(PDO $conn) {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute([':email' => $this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {  
            $this->id = $user['id'];  
            echo "Utilisateur $this->email est connecté.\n";
        } else {
            echo "Échec de la connexion.\n";
        }
    }

    
    public function logout() {
        echo "Utilisateur $this->email est déconnecté.\n";
    }

   
    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setRole(string $role) {
        $this->role = $role;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function setStatut(string $statut) {
        $this->statut = $statut;
    }

    public function getStatut(): string {
        return $this->statut;
    }
}
?>
