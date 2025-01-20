<?php
abstract class Utilisateur {
    protected int $id;
    protected string $nom;
    protected string $email;
    protected string $password;
    protected string $role;
    protected string $statut;

    
    public function __construct(string $nom, string $email, string $password, string $role = 'user', string $statut = 'actif') {
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->statut = $statut;
    }

    
    public function login(PDO $conn) {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute([':email' => $this->email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($this->password, $user['password'])) {  
            $this->id = $user['id'];  
            $_SESSION['role'] = $user['role'];  
            return true; 
        } else {
            return false;  
        }
    }

    
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: login.php'); 
        exit();
    }

    abstract public function afficherInformations(): void;

    
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
