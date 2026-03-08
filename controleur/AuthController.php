<?php
require_once "modele/User.php";
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";

class AuthController {

    private $pdo;
    private $userModel;
    private $candidatModel;
    private $moniteurModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
    }

    public function login() {

    if (!isset($_POST['email'], $_POST['mdp'], $_POST['role'])) {
        require "vue/auth/login.php";
        return;
    }

    $email = $_POST['email'];
    $mdp   = $_POST['mdp'];
    $role  = $_POST['role'];

    // ===== ADMIN =====
    if ($role === 'admin') {
        $admin = $this->userModel->getByEmail($email);

        if ($admin && $admin['mdp'] === $mdp && $admin['droits'] === 'admin') {
            $_SESSION['admin'] = $admin;
            header("Location: index.php?page=admin");
            exit;
        }
    }

    // ===== CANDIDAT =====
    if ($role === 'candidat') {
        $candidat = $this->candidatModel->getByEmail($email);

        if ($candidat && $candidat['mdp'] === $mdp) {
            $_SESSION['candidat'] = $candidat;
            header("Location: index.php?page=candidat");
            exit;
        }
    }

    // ===== MONITEUR =====
    if ($role === 'moniteur') {
        $moniteur = $this->moniteurModel->getByEmail($email);

        if ($moniteur && $moniteur['mdp'] === $mdp) {
            $_SESSION['moniteur'] = $moniteur;
            header("Location: index.php?page=moniteur");
            exit;
        }
    }

    $erreur = "Identifiants ou rôle incorrects";
    require "vue/auth/login.php";
}


   public function register() {

    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp'], $_POST['role'])) {
        $pdo = $this->pdo;
        require "vue/auth/register.php";
        return;
    }

    $role = $_POST['role'];

    // ===== CANDIDAT =====
    if ($role === 'candidat') {
        if (!isset($_POST['idformule']) || empty($_POST['idformule'])) {
            $erreur = "Veuillez choisir une formule";
            $pdo = $this->pdo;
            require "vue/auth/register.php";
            return;
        }

        // Récupérer le statut étudiant (1 si coché, 0 sinon)
        $etudiant = isset($_POST['etudiant']) ? 1 : 0;

        $this->candidatModel->register(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['mdp'],
            $_POST['idformule'],
            $etudiant
        );
    }

    // ===== MONITEUR =====
    if ($role === 'moniteur') {
        $this->moniteurModel->register(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['mdp']
        );
    }

    header("Location: index.php?page=login");
    exit;
}
   
}

    





