<?php
session_start();

require_once "config/database.php";
require_once "controleur/HomeController.php";
require_once "controleur/AuthController.php";
require_once "controleur/AdminController.php";
require_once "controleur/LeconController.php";
require_once "controleur/ProfilController.php";
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";


$page = $_GET['page'] ?? 'home';

switch ($page) {
    
    // ========== AUTHENTIFICATION ==========
    case 'login':
        (new AuthController($pdo))->login();
        break;

    case 'register':
        (new AuthController($pdo))->register();
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?page=login");
        exit;

    // ========== DASHBOARDS ==========
    case 'admin':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new ProfilController($pdo))->dashboardAdmin();
        break;

    case 'candidat':
        if (!isset($_SESSION['candidat'])) die("Accès refusé");
        (new ProfilController($pdo))->dashboardCandidat();
        break;

    case 'moniteur':
        if (!isset($_SESSION['moniteur'])) die("Accès refusé");
        (new ProfilController($pdo))->dashboardMoniteur();
        break;

    // ========== PROFILS ==========
    case 'profil-candidat':
        if (!isset($_SESSION['candidat'])) die("Accès refusé");
        (new ProfilController($pdo))->profilCandidat();
        break;

    case 'profil-moniteur':
        if (!isset($_SESSION['moniteur'])) die("Accès refusé");
        (new ProfilController($pdo))->profilMoniteur();
        break;

    case 'update-candidat':
        if (!isset($_SESSION['candidat'])) die("Accès refusé");
        (new ProfilController($pdo))->updateCandidat();
        break;

    case 'update-moniteur':
        if (!isset($_SESSION['moniteur'])) die("Accès refusé");
        (new ProfilController($pdo))->updateMoniteur();
        break;

    // ========== GESTION CANDIDATS (ADMIN) ==========
    case 'candidats':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->candidats();
        break;

    case 'edit-candidat':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->editCandidat();
        break;

    case 'delete-candidat':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->deleteCandidat();
        break;

    // ========== GESTION MONITEURS (ADMIN) ==========
    case 'moniteurs-admin':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->moniteurs();
        break;

    case 'add-moniteur':
    case 'edit-moniteur':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->editMoniteur();
        break;

    case 'delete-moniteur':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->deleteMoniteur();
        break;

    // ========== GESTION FORMULES (ADMIN) ==========
    case 'formules':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->formules();
        break;

    case 'add-formule':
    case 'edit-formule':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->editFormule();
        break;

    case 'delete-formule':
        if (!isset($_SESSION['admin'])) die("Accès refusé");
        (new AdminController($pdo))->deleteFormule();
        break;

    // ========== PLANNING & LEÇONS ==========
    case 'planning':
        (new LeconController($pdo))->planning();
        break;

    case 'ajouter-lecon':
        (new LeconController($pdo))->ajouterLecon();
        break;

    case 'supprimer-lecon':
        (new LeconController($pdo))->supprimerLecon();
        break;

    case 'mes-lecons':
        if (!isset($_SESSION['candidat'])) die("Accès refusé");
        (new LeconController($pdo))->mesLecons();
        break;

    // ========== QUIZ CODE ==========
    case 'quiz-code':
        if (file_exists('modele/quiz-code.php')) {
            include 'modele/quiz-code.php';
        } else {
            echo "Page quiz non disponible";
        }
        break;

    // ========== AUTRES ==========
    case 'home':
        (new HomeController())->index();
        break;

    // ========== PAGE PAR DÉFAUT ==========
    default:
        echo "Page introuvable";
        break;

        case 'statistiques':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    (new AdminController($pdo))->statistiques();
    break;

    // ========== GESTION VÉHICULES ==========
case 'vehicules':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/VehiculeController.php";
    (new VehiculeController($pdo))->vehicules();
    break;

case 'edit-vehicule':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/VehiculeController.php";
    (new VehiculeController($pdo))->editVehicule();
    break;

case 'delete-vehicule':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/VehiculeController.php";
    (new VehiculeController($pdo))->deleteVehicule();
    break;

case 'modeles':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/VehiculeController.php";
    (new VehiculeController($pdo))->modeles();
    break;

case 'edit-modele':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/VehiculeController.php";
    (new VehiculeController($pdo))->editModele();
    break;

case 'delete-modele':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/VehiculeController.php";
    (new VehiculeController($pdo))->deleteModele();
    break;

    // ========== QUIZ CODE ==========
case 'quiz-code':
    if (!isset($_SESSION['candidat'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->index();
    break;

case 'quiz-nouveau':
    if (!isset($_SESSION['candidat'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->nouveau();
    break;

case 'quiz-soumettre':
    if (!isset($_SESSION['candidat'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->soumettre();
    break;

case 'quiz-resultat':
    if (!isset($_SESSION['candidat'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->resultat();
    break;

// Admin - Questions
case 'questions-code':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->gestionQuestions();
    break;

case 'edit-question':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->editQuestion();
    break;

case 'delete-question':
    if (!isset($_SESSION['admin'])) die("Accès refusé");
    require_once "controleur/QuizController.php";
    (new QuizController($pdo))->deleteQuestion();
    break;
}
?>