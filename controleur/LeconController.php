<?php
require_once "modele/Lecon.php";
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";
require_once "modele/Vehicule.php";

class LeconController {
    private $pdo;
    private $leconModel;
    private $candidatModel;
    private $moniteurModel;
    private $vehiculeModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->leconModel = new Lecon($pdo);
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
        $this->vehiculeModel = new Vehicule($pdo);
    }

    // Afficher le planning
    public function planning() {
        $lecons = $this->leconModel->getPlanning();
        require "vue/planning/planning.php";
    }

    // Afficher le formulaire d'ajout de leçon
    public function ajouterLecon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traitement du formulaire
            $idlecon = $this->leconModel->getNewId();
            
            $data = [
                'idlecon' => $idlecon,
                'datedebut' => $_POST['datedebut'],
                'datefin' => $_POST['datefin'],
                'idcandidat' => $_POST['idcandidat'],
                'idmoniteur' => $_POST['idmoniteur'],
                'idvehicule' => $_POST['idvehicule']
            ];

            if ($this->leconModel->add($data)) {
                header("Location: index.php?page=planning&success=1");
                exit;
            } else {
                $error = "Erreur lors de l'ajout de la leçon";
            }
        }

        // Récupérer les données pour les selects
        $candidats = $this->candidatModel->all();
        $moniteurs = $this->pdo->query("SELECT * FROM moniteur")->fetchAll();
        $vehicules = $this->vehiculeModel->getAll();

        require "vue/planning/ajouter.php";
    }

    // Supprimer une leçon
    public function supprimerLecon() {
        if (isset($_GET['id'])) {
            $this->leconModel->delete($_GET['id']);
        }
        header("Location: index.php?page=planning");
        exit;
    }

    // Mes leçons (pour candidat)
    public function mesLecons() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $idcandidat = $_SESSION['candidat']['idcandidat'];
        $lecons = $this->leconModel->getByCandidat($idcandidat);

        require "vue/candidat/mes-lecons.php";
    }
}
?>