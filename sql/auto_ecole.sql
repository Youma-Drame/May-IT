drop database if exists auto_ecole_may_it;
create database auto_ecole_may_it;
use auto_ecole_may_it;

-- table formule
create table formule (
    idformule int(4) not null,
    libelle varchar(50) not null,
    prix decimal(6,2) not null,
    duree int(3),
    typepublic varchar(20),
    constraint pk_formule primary key (idformule)
);

-- table candidat
create table candidat (
    idcandidat int(5) not null AUTO_INCREMENT,
    nom varchar(30) not null,
    prenom varchar(30) not null,
    email varchar(50),
    mdp VARCHAR(50) not null,
    datenaissance date,
    etudiant boolean,
    sexe ENUM ("Femme", "Homme","Autre"),
    idformule int(4) not null,
    constraint pk_candidat primary key (idcandidat),
    constraint fk_formule foreign key (idformule) references formule(idformule)
);

-- table moniteur
create table moniteur (
    idmoniteur int(4) not null,
    nom varchar(30) not null,
    prenom varchar(30) not null,
    telephone varchar(15),
    email varchar(50),
    mdp VARCHAR(50) not null,
    date_embauche date,
    type_permis ENUM ("permis A","permis B"),
    sexe ENUM ("Femme", "Homme","Autre"),
    constraint pk_moniteur primary key (idmoniteur)
);

-- table modele
create table modele (
    idmodele int(4) not null,
    marque varchar(30) not null,
    nommodele varchar(30) not null,
    typeboite enum('auto','manuelle'),
    constraint pk_modele primary key (idmodele)
);

-- table vehicule
create table vehicule (
    idvehicule int(4) not null,
    immatriculation varchar(15) not null,
    etat varchar(20),
    idmoniteur int(4),
    idmodele int(4) not null,
    constraint pk_vehicule primary key (idvehicule),
    constraint fk_moniteur foreign key (idmoniteur) references moniteur(idmoniteur),
    constraint fk_modele foreign key (idmodele) references modele(idmodele)
);

-- table lecon
create table lecon (
    idlecon int(5) not null,
    datedebut datetime not null,
    datefin datetime not null,
    idcandidat int(5) not null,
    idmoniteur int(4) not null,
    idvehicule int(4) not null,
    constraint pk_lecon primary key (idlecon),
    constraint fk_candidat foreign key (idcandidat) references candidat(idcandidat),
    constraint fk_lecon_moniteur foreign key (idmoniteur) references moniteur(idmoniteur),
    constraint fk_lecon_vehicule foreign key (idvehicule) references vehicule(idvehicule)
);

 

create table user (
    iduser int (3) not null auto_increment, 
    nom varchar(50), 
    prenom varchar(50), 
    email varchar(50), 
    mdp varchar(255), 
    droits enum ("user", "admin"), 
    primary key (iduser)
);

-- Table pour les questions du code
CREATE TABLE question_code (
    idquestion INT(5) NOT NULL AUTO_INCREMENT,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    bonne_reponse ENUM('A', 'B', 'C', 'D') NOT NULL,
    categorie VARCHAR(50),
    image VARCHAR(255),
    PRIMARY KEY (idquestion)
);

-- Table pour les résultats des quiz
CREATE TABLE resultat_quiz (
    idresultat INT(5) NOT NULL AUTO_INCREMENT,
    idcandidat INT(5) NOT NULL,
    date_quiz DATETIME NOT NULL,
    score INT(3) NOT NULL,
    total_questions INT(3) NOT NULL,
    temps_total INT(5),
    PRIMARY KEY (idresultat),
    FOREIGN KEY (idcandidat) REFERENCES candidat(idcandidat)
);

-- Insérer des questions de test
INSERT INTO question_code (question, option_a, option_b, option_c, option_d, bonne_reponse, categorie) VALUES
('À un feu orange clignotant, vous devez :', 'Vous arrêter obligatoirement', 'Ralentir et céder le passage', 'Passer normalement', 'Accélérer pour passer', 'B', 'Signalisation'),
('La limitation de vitesse en agglomération est de :', '30 km/h', '50 km/h', '70 km/h', '90 km/h', 'B', 'Vitesse'),
('Le triangle de signalisation doit être placé à quelle distance minimum du véhicule en panne ?', '10 mètres', '30 mètres', '50 mètres', '100 mètres', 'B', 'Sécurité'),
('Sur autoroute, la distance de sécurité est de :', '1 seconde', '2 secondes', '3 secondes', '5 secondes', 'B', 'Sécurité'),
('Le taux d''alcoolémie maximum autorisé pour un conducteur expérimenté est de :', '0,2 g/L', '0,5 g/L', '0,8 g/L', '1,0 g/L', 'B', 'Alcool'),
('Vous devez contrôler la pression de vos pneus :', 'À chaud', 'À froid', 'Peu importe', 'Jamais', 'B', 'Mécanique'),
('Le port de la ceinture de sécurité est obligatoire :', 'Seulement à l''avant', 'Seulement sur autoroute', 'Partout', 'Nulle part', 'C', 'Sécurité'),
('En cas de pluie, la distance de freinage est :', 'Divisée par 2', 'Inchangée', 'Multipliée par 2', 'Multipliée par 4', 'C', 'Sécurité'),
('Un panneau triangulaire rouge et blanc indique :', 'Une interdiction', 'Un danger', 'Une obligation', 'Une indication', 'B', 'Signalisation'),
('La durée de validité du permis probatoire est de :', '1 an', '2 ans', '3 ans', '5 ans', 'C', 'Permis');
 

 

/***********Heritage*********/

create database testheritage ;
use testheritage ;
DROP  Table IF EXISTS Candidat; ;
CREATE TABLE CANDIDAT
 (
   IDU INTEGER  NOT NULL  ,
   DATE_NAISSANCE date  ,
   ETUDIANT BOOLEAN NOT NULL  ,
   NOM VARCHAR (50) NOT NULL  ,
   PRENOM VARCHAR (50) NOT NULL  ,
   sexe ENUM ('Femme', 'Homme', 'Autre'),
   EMAIL VARCHAR (50) NOT NULL  ,
   MDP VARCHAR (30) NOT NULL  ,
   TELEPHONE VARCHAR (15) NOT NULL , 
   
    PRIMARY KEY (IDU) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : UTILISATEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS UTILISATEUR
 (
   IDU INTEGER  NOT NULL  ,
   NOM VARCHAR (50)NOT NULL  ,
   PRENOM VARCHAR (50) NOT NULL  ,
    sexe ENUM ("Femme", "Homme","Autre"),
   EMAIL VARCHAR (50) NOT NULL  ,
   MDP VARCHAR (50) NOT NULL  ,
   TELEPHONE VARCHAR (15) NOT NULL  
   , PRIMARY KEY (IDU) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : MONITEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS MONITEUR
 (
   IDU INTEGER  NOT NULL  ,
   DATE_EMBAUCHE DATE NOT NULL  ,
   TYPE_PERMIS ENUM ("permis A","permis B"),
   NOM VARCHAR (50) NOT NULL  ,
   PRENOM VARCHAR (50) NOT NULL  ,
   sexe ENUM ("Femme", "Homme","Autre"),
   EMAIL VARCHAR (50) NOT NULL  ,
   MDP VARCHAR (30) NOT NULL  ,
   TELEPHONE VARCHAR (15) NOT NULL  
   ,
    PRIMARY KEY (IDU) 
 ) 
 comment = "";


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------





      /********trigers**************/

      /******insert update et delete du Candidat**********/
  drop TRIGGER    
delimiter //
create trigger insert_candidat
before insert on candidat
for each row
 BEGIN
    if new.idu is null or new.idu 
    in (select idu from utilisateur) or new.idu = 0 
    then
set new.idu = ifnull((select idu from utilisateur where idu >= all(select idu from utilisateur)), 0) +1 ;
end if;
insert into utilisateur values(new.idu, new.nom, new.prenom, new.sexe, new.email, new.mdp, new.telephone);
end //
delimiter ;

drop trigger if exists update_candidat;
delimiter //
create trigger update_candidat
before 
update on candidat
 for each row 

 BEGIN
    update utilisateur 
        set idu=new.idu,
         nom=new.nom , prenom=new.prenom, sexe= new.sexe, email= new.email, mdp=new.mdp, telephone=new.telephone, where 
         utilisateur.idu=old.idu;
end //
delimiter ;

drop trigger if exists delete_candidat;
delimiter //
create trigger delete_candidat
before delete on candidat
for each row 
BEGIN
    delete from utilisateur
     where utilisateur.idu=old.idu;
end //
delimiter ;


/*******insert update et delete du Moniteur *********/
drop trigger if exists insert_moniteur
delimiter //
create trigger insert_moniteur
before insert on moniteur
for each row
 BEGIN
    if new.idu is null or new.idu 
    in (select idu from utilisateur) or new.idu = 0 
    then
set new.idu = ifnull((select idu from utilisateur where idu >= all(select idu from utilisateur)), 0) +1 ;
end if;
insert into utilisateur values(new.idu, new.nom, new.prenom, new.sexe, new.email, new.mdp, new.telephone);
end //
delimiter ;

drop trigger if exists update_moniteur;
delimiter //
create trigger update_moniteur
before 
update on moniteur
 for each row 

 BEGIN
    update utilisateur 
        set idu=new.idu,
         nom=new.nom , prenom=new.prenom, sexe= new.sexe, email= new.email, mdp=new.mdp, telephone=new.telephone, where 
         utilisateur.idu=old.idu;
end //
delimiter ;

drop trigger if exists delete_moniteur;
delimiter //
create trigger delete_moniteur
before delete on moniteur
for each row 
BEGIN
    delete from utilisateur
     where utilisateur.idu=old.idu;
end //
delimiter ;

insert into candidat values (1,"2000/01/01","etudiant","Drame",
"Youma","feminin","a@gmail.com","123","07 59 65 58 33");

