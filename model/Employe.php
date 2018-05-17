<?php

require_once '../frame/Modele.php';

/**
 * Services liés aux Employe
 */
class Employe extends Modele
{
    
    /**
     * Ajoute un nouveau employe
     * @param type $nom
     * @param type $prenom
     * @param type $dateNaissance
     * @param type $adresse
     * @param type $telephone
     * @param type $email
     * @param type $matricule
     * @param type $login
     * @param type $mdp
     * @param type $poste
     * @param type $specialite
     * @param type $dateEmbauche
     * @param type $dateDepart
     * @param type $idVille
     */
    public function ajouterEmploye($nom, $prenom, $dateNaissance, $adresse, $telephone, $email, $matricule, $login, $mdp, $poste, $specialite, $dateEmbauche, $dateDepart, $idVille)
    {
        $sql = "insert into employe(nomEmploye,  prenomEmploye,  dateNaissanceEmploye,  adresseEmploye,  telephoneEmploye,  emailEmploye,  matricule,  login,  mdp,  poste, specialite,  dateEmbauche,  dateDepart,  idVille)
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $hashed_password = password_hash($mdp, PASSWORD_BCRYPT);
        $this->executerRequete($sql,
            array($nom, $prenom, $dateNaissance, $adresse, $telephone, $email, $matricule, $login, $hashed_password, $poste, $specialite, $dateEmbauche, $dateDepart, $idVille));
    }

    /**
     * Renvoie les infos sur un employe
     * @param type $courriel
     * @param type $mdp
     * @return type
     * @throws Exception
     */
    public function getEmploye($login,$mdp)
    {
        $sql     = "select * from employe where login=?";
        $employe = $this->executerRequete($sql,array($login));
        if ($employe->rowCount() == 1){
            $user = $employe->fetch(PDO::FETCH_ASSOC);
            if (password_verify($mdp, $user['mdp']))
                return  $user;
            else
            throw new Exception("Aucun employe ne correspond aux infos fournies (mdp).");
        }
        else
            throw new Exception("Aucun client ne correspond aux identifiants fournis");
    }

    /**
     * Renvoie les infos sur un employe
     * @param type $idEmploye
     * @return type
     * @throws Exception
     */
    public function getEmployeParId($idEmploye)
    {
        $sql     = "select * from employe where idEmploye=?";
        $employe = $this->executerRequete($sql, array($idEmploye));
        if ($employe->rowCount() == 1) {
            return $employe->fetch(PDO::FETCH_ASSOC);
        }
        // Accès à la première ligne de résultat
        else {
            throw new Exception("Aucun employe ne correspond à l'identifiant fourni.");
        }

    }

    

    /**
     * Modifie un employe existant
     *
     * @param type $idEmploye
     * @param type $nom
     * @param type $prenom
     * @param type $adresse
     * @param type $codePostal
     * @param type $ville
     * @param type $courriel
     * @param type $mdp
     */
    public function modifierEmploye($idEmploye, $nom, $prenom, $adresse, $codePostal, $ville, $courriel, $mdp)
    {
        $sql = "update T_CLIENT set CLI_NOM=?, CLI_PRENOM=?, CLI_ADRESSE=?, CLI_CP=?,
            CLI_VILLE=?, CLI_COURRIEL=?, CLI_MDP=? where CLI_ID=?";
        $this->executerRequete($sql,
            array($nom, $prenom, $adresse, $codePostal, $ville, $courriel, $mdp, $idEmploye));
    }

}