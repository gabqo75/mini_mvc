<?php
namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class User
{
    private $id;
    private $nom;
    private $prenom; 
    private $email;
    private $password;
    private $adresse; 
    private $ville;   
    private $code_postal; 

    // Setters simples
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = password_hash($password, PASSWORD_BCRYPT); }
    public function setAdresse($adresse) { $this->adresse = $adresse; }
    public function setVille($ville) { $this->ville = $ville; }
    public function setCodePostal($cp) { $this->code_postal = $cp; }

    // Getters nécessaires
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getEmail() { return $this->email; }

    public static function findByEmail($email) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save() {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO user (nom, prenom, email, password, adresse, ville, code_postal) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->nom, 
            $this->prenom ?? '', 
            $this->email, 
            $this->password,
            $this->adresse ?? '',
            $this->ville ?? '',
            $this->code_postal ?? ''
        ]);
    }
}