<?php
class Lecon {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les leçons
    public function getAll() {
        return $this->pdo->query("
            SELECT l.*, 
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            ORDER BY l.datedebut DESC
        ")->fetchAll();
    }

    // Récupérer les leçons d'un candidat
    public function getByCandidat($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT l.*, 
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            WHERE l.idcandidat = ?
            ORDER BY l.datedebut DESC
        ");
        $stmt->execute([$idcandidat]);
        return $stmt->fetchAll();
    }

    // Récupérer les leçons d'un moniteur
    public function getByMoniteur($idmoniteur) {
        $stmt = $this->pdo->prepare("
            SELECT l.*, 
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            WHERE l.idmoniteur = ?
            ORDER BY l.datedebut DESC
        ");
        $stmt->execute([$idmoniteur]);
        return $stmt->fetchAll();
    }

    // Récupérer les prochaines leçons
    public function getProchaines($limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT l.*, 
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            WHERE l.datedebut >= NOW()
            ORDER BY l.datedebut ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    // Récupérer les leçons du jour
    public function getAujourdhui() {
        return $this->pdo->query("
            SELECT l.*, 
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            WHERE DATE(l.datedebut) = CURDATE()
            ORDER BY l.datedebut ASC
        ")->fetchAll();
    }

    // Ajouter une leçon
    public function add($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO lecon (idlecon, datedebut, datefin, idcandidat, idmoniteur, idvehicule)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['idlecon'],
            $data['datedebut'],
            $data['datefin'],
            $data['idcandidat'],
            $data['idmoniteur'],
            $data['idvehicule']
        ]);
    }

    // Supprimer une leçon
    public function delete($idlecon) {
        $stmt = $this->pdo->prepare("DELETE FROM lecon WHERE idlecon = ?");
        return $stmt->execute([$idlecon]);
    }

    // Compter les heures de conduite d'un candidat
    public function getHeuresCandidat($idcandidat) {
        $stmt = $this->pdo->prepare("
            SELECT SUM(TIMESTAMPDIFF(HOUR, datedebut, datefin)) as total_heures
            FROM lecon
            WHERE idcandidat = ? AND datefin <= NOW()
        ");
        $stmt->execute([$idcandidat]);
        $result = $stmt->fetch();
        return $result['total_heures'] ?? 0;
    }

    // Compter les heures d'un moniteur ce mois
    public function getHeuresMoniteurMois($idmoniteur) {
        $stmt = $this->pdo->prepare("
            SELECT SUM(TIMESTAMPDIFF(HOUR, datedebut, datefin)) as total_heures
            FROM lecon
            WHERE idmoniteur = ? 
            AND MONTH(datedebut) = MONTH(NOW())
            AND YEAR(datedebut) = YEAR(NOW())
        ");
        $stmt->execute([$idmoniteur]);
        $result = $stmt->fetch();
        return $result['total_heures'] ?? 0;
    }

    // Générer un nouvel ID
    public function getNewId() {
        $result = $this->pdo->query("SELECT MAX(idlecon) as max_id FROM lecon")->fetch();
        return ($result['max_id'] ?? 0) + 1;
    }

    // Récupérer le planning complet
    public function getPlanning() {
        return $this->pdo->query("
            SELECT l.*, 
                   c.nom as candidat_nom, c.prenom as candidat_prenom,
                   m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                   v.immatriculation,
                   mo.marque, mo.nommodele
            FROM lecon l
            JOIN candidat c ON l.idcandidat = c.idcandidat
            JOIN moniteur m ON l.idmoniteur = m.idmoniteur
            JOIN vehicule v ON l.idvehicule = v.idvehicule
            JOIN modele mo ON v.idmodele = mo.idmodele
            ORDER BY l.datedebut ASC
        ")->fetchAll();
    }
}
?>