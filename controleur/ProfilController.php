<?php
require_once "modele/Candidat.php";
require_once "modele/Moniteur.php";
require_once "modele/User.php";
require_once "modele/Lecon.php";
require_once "modele/Formule.php";

class ProfilController {
    private $pdo;
    private $candidatModel;
    private $moniteurModel;
    private $userModel;
    private $leconModel;
    private $formuleModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->candidatModel = new Candidat($pdo);
        $this->moniteurModel = new Moniteur($pdo);
        $this->userModel = new User($pdo);
        $this->leconModel = new Lecon($pdo);
        $this->formuleModel = new Formule($pdo);
    }

    // Afficher le tableau de bord candidat
    public function dashboardCandidat() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $candidat = $_SESSION['candidat'];
        $candidatActuel = $this->candidatModel->getByEmail($candidat['email']);
        
        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$candidatActuel['idformule']]);
        $formule = $stmt->fetch();

        // Récupérer les statistiques
        $heuresConduite = $this->leconModel->getHeuresCandidat($candidatActuel['idcandidat']);
        $prochaines = $this->leconModel->getByCandidat($candidatActuel['idcandidat']);
        
        // Filtrer les prochaines leçons (futures)
        $prochainesLecons = array_filter($prochaines, function($lecon) {
            return strtotime($lecon['datedebut']) >= time();
        });
        
        $nbProchainesLecons = count($prochainesLecons);

        require "vue/candidat/dashboard.php";
    }

    // Afficher le profil candidat
    public function profilCandidat() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $candidat = $_SESSION['candidat'];
        $candidatActuel = $this->candidatModel->getByEmail($candidat['email']);
        
        $stmt = $this->pdo->prepare("SELECT * FROM formule WHERE idformule = ?");
        $stmt->execute([$candidatActuel['idformule']]);
        $formule = $stmt->fetch();

        require "vue/candidat/profil.php";
    }

    // Mettre à jour le profil candidat
    public function updateCandidat() {
        if (!isset($_SESSION['candidat'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['candidat']['idcandidat'];
            
            $data = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'datenaissance' => $_POST['datenaissance'] ?? null,
                'idformule' => $_POST['idformule']
            ];

            if (!empty($_POST['mdp'])) {
                $data['mdp'] = $_POST['mdp'];
            }

            $this->candidatModel->update($id, $data);
            $_SESSION['candidat'] = $this->candidatModel->getByEmail($data['email']);
            
            header("Location: index.php?page=profil-candidat&success=1");
            exit;
        }
    }

    // Afficher le tableau de bord moniteur
    public function dashboardMoniteur() {
        if (!isset($_SESSION['moniteur'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $moniteur = $_SESSION['moniteur'];
        $moniteurActuel = $this->moniteurModel->getByEmail($moniteur['email']);

        // Récupérer les statistiques
        $heuresMois = $this->leconModel->getHeuresMoniteurMois($moniteurActuel['idmoniteur']);
        $leconsAujourdhui = $this->leconModel->getAujourdhui();
        
        // Filtrer les leçons du moniteur aujourd'hui
        $mesLeconsAujourdhui = array_filter($leconsAujourdhui, function($lecon) use ($moniteurActuel) {
            return $lecon['idmoniteur'] == $moniteurActuel['idmoniteur'];
        });
        
        $nbLeconsAujourdhui = count($mesLeconsAujourdhui);

        // Compter les élèves du moniteur
        $stmt = $this->pdo->prepare("
            SELECT COUNT(DISTINCT idcandidat) as nb_eleves
            FROM lecon
            WHERE idmoniteur = ?
        ");
        $stmt->execute([$moniteurActuel['idmoniteur']]);
        $nbEleves = $stmt->fetch()['nb_eleves'] ?? 0;

        require "vue/moniteur/dashboard.php";
    }

    // Afficher le profil moniteur
    public function profilMoniteur() {
        if (!isset($_SESSION['moniteur'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $moniteur = $_SESSION['moniteur'];
        $moniteurActuel = $this->moniteurModel->getByEmail($moniteur['email']);

        require "vue/moniteur/profil.php";
    }

    // Mettre à jour le profil moniteur
    public function updateMoniteur() {
        if (!isset($_SESSION['moniteur'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['moniteur']['idmoniteur'];
            
            $data = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'telephone' => $_POST['telephone'] ?? null
            ];

            if (!empty($_POST['mdp'])) {
                $data['mdp'] = $_POST['mdp'];
            }

            $this->moniteurModel->update($id, $data);
            $_SESSION['moniteur'] = $this->moniteurModel->getByEmail($data['email']);
            
            header("Location: index.php?page=profil-moniteur&success=1");
            exit;
        }
    }

    // Afficher le tableau de bord admin
    public function dashboardAdmin() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $admin = $_SESSION['admin'];
        require "vue/admin/dashboard.php";
    }
}
?>