<?php
/**
 * Fonctions pour l'application GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author    Tony FERNANDEZ <it.fernandeztony@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

/**
 * Teste si un quelconque utilisateur est connecté
 *
 * @return vrai ou faux
 */
function estConnecte()
{
    return isset($_SESSION['idVisiteur']);
}

/**
 * Enregistre dans une variable session les infos d'un visiteur
 *
 * @param String $idVisiteur        ID de l'utilisateur
 * @param String $nom               Nom de l'utilisateur
 * @param String $prenom            Prénom de l'utilisateur
 * @param String $typeUtilisateur   Type de l'utilisateur
 *
 * @return null
 */
function connecter($idVisiteur, $nom, $prenom, $typeUtilisateur)
{
    $_SESSION['idVisiteur'] = $idVisiteur;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['utilisateur'] = $typeUtilisateur;
}

/**
 * Détruit la session active
 *
 * @return null
 */
function deconnecter()
{
    session_destroy();
}

/**
 * Transforme une date au format français jj/mm/aaaa vers le format anglais
 * aaaa-mm-jj
 *
 * @param String $maDate au format  jj/mm/aaaa
 *
 * @return Date au format anglais aaaa-mm-jj
 */
function dateFrancaisVersAnglais($maDate)
{
    @list($jour, $mois, $annee) = explode('/', $maDate);
    return date('Y-m-d', mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format
 * français jj/mm/aaaa
 *
 * @param String $maDate au format  aaaa-mm-jj
 *
 * @return Date au format format français jj/mm/aaaa
 */
function dateAnglaisVersFrancais($maDate)
{
    @list($annee, $mois, $jour) = explode('-', $maDate);
    $date = $jour . '/' . $mois . '/' . $annee;
    return $date;
}

/**
 * Retourne le mois au format aaaamm selon le jour dans le mois
 *
 * @param String $date au format  jj/mm/aaaa
 *
 * @return String Mois au format aaaamm
 */
function getMois($date)
{
    @list($jour, $mois, $annee) = explode('/', $date);
    unset($jour);
    if (strlen($mois) == 1) {
        $mois = '0' . $mois;
    }
    return $annee . $mois;
}

/* gestion des erreurs */

/**
 * Indique si une valeur est un entier positif ou nul
 *
 * @param Integer $valeur Valeur
 *
 * @return Boolean vrai ou faux
 */
function estEntierPositif($valeur)
{
    return preg_match('/[^0-9]/', $valeur) == 0;
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 *
 * @param Array $tabEntiers Un tableau d'entier
 *
 * @return Boolean vrai ou faux
 */
function estTableauEntiers($tabEntiers)
{
    $boolReturn = true;
    foreach ($tabEntiers as $unEntier) {
        if (!estEntierPositif($unEntier)) {
            $boolReturn = false;
        }
    }
    return $boolReturn;
}

/**
 * Vérifie si une date est inférieure d'un an à la date actuelle
 *
 * @param String $dateTestee Date à tester
 *
 * @return Boolean vrai ou faux
 */
function estDateDepassee($dateTestee)
{
    $dateActuelle = date('d/m/Y');
    @list($jour, $mois, $annee) = explode('/', $dateActuelle);
    $annee--;
    $anPasse = $annee . $mois . $jour;
    @list($jourTeste, $moisTeste, $anneeTeste) = explode('/', $dateTestee);
    return ($anneeTeste . $moisTeste . $jourTeste < $anPasse);
}

/**
 * Vérifie la validité du format d'une date française jj/mm/aaaa
 *
 * @param String $date Date à tester
 *
 * @return Boolean vrai ou faux
 */
function estDateValide($date)
{
    $tabDate = explode('/', $date);
    $dateOK = true;
    if (count($tabDate) != 3) {
        $dateOK = false;
    } else {
        if (!estTableauEntiers($tabDate)) {
            $dateOK = false;
        } else {
            if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
                $dateOK = false;
            }
        }
    }
    return $dateOK;
}

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques
 *
 * @param Array $lesFrais Tableau d'entier
 *
 * @return Boolean vrai ou faux
 */
function lesQteFraisValides($lesFrais)
{
    return estTableauEntiers($lesFrais);
}

/**
 * Vérifie la validité des trois arguments : la date, le libellé du frais
 * et le montant
 *
 * Des message d'erreurs sont ajoutés au tableau des erreurs
 *
 * @param String $dateFrais Date des frais
 * @param String $libelle   Libellé des frais
 * @param Float  $montant   Montant des frais
 *
 * @return null
 */
function valideInfosFrais($dateFrais, $libelle, $montant)
{
    if ($dateFrais == '') {
        ajouterErreur('Le champ date ne doit pas être vide');
    } else {
        if (!estDatevalide($dateFrais)) {
            ajouterErreur('Date invalide');
        } else {
            if (estDateDepassee($dateFrais)) {
                ajouterErreur(
                    "date d'enregistrement du frais dépassé, plus de 1 an"
                );
            }
        }
    }
    if ($libelle == '') {
        ajouterErreur('Le champ description ne peut pas être vide');
    }
    if ($montant == '') {
        ajouterErreur('Le champ montant ne peut pas être vide');
    } elseif (!is_numeric($montant)) {
        ajouterErreur('Le champ montant doit être numérique');
    }
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs
 *
 * @param String $msg Libellé de l'erreur
 *
 * @return null
 */
function ajouterErreur($msg)
{
    if (!isset($_REQUEST['erreurs'])) {
        $_REQUEST['erreurs'] = array();
    }
    $_REQUEST['erreurs'][] = $msg;
}

/**
 * Retoune le nombre de lignes du tableau des erreurs
 *
 * @return Integer le nombre d'erreurs
 */
function nbErreurs()
{
    if (!isset($_REQUEST['erreurs'])) {
        return 0;
    } else {
        return count($_REQUEST['erreurs']);
    }
}

/**
 * Retourne un tableau associatif contenant nom et prénom de visiteur.
 * 
 * @param Array $liste tableau associatif contenant id, nom et prénom 
 * de visiteur.
 * @return Array liste de nom et prénom sous la forme Nom Prénom
 */
function creerListeNomPrenom($liste) 
{
    for ($i=0;$i<count($liste);$i++) { 
    $array = $liste[$i];
    $listeNomPrenom[] = $array['nom'] . ' ' . $array['prenom'];
    }
    return $listeNomPrenom;
}

/**
 * Extrait une liste d'un tableau associatif.
 * 
 * @param Array $array tableau associatif.
 * @param String $cle clé du tableau associatif.
 * @return Array retourne une liste.
 */
function extraireListe($array, $cle) 
{
    foreach($array as $element) {
        $liste = null;
        if (is_array($element[$cle])) {
            $fin = count($element[$cle]);
            for($i=0;$i<$fin;$i++) {
               $liste[] = $element[$cle][$i];
            }
            $listeFinale[] = $liste;
        } else {
            $listeFinale[] = $element[$cle];
        }
    }
    return $listeFinale;
}

/**
 * Réorganise dans une liste les dates de type -aaaamm- en type -mm / aaaa-.
 * 
 * @param Array $liste liste de date à formater.
 * @return Array liste date formatées.
 */
function formatMois($liste) 
{
    foreach ($liste as $value) {
        $listeFormate[] = $value['numMois'] . ' / ' . $value['numAnnee'];
    }
    return $listeFormate;
}

/**
 * Ajoute le libellé d'une réussite au tableau des réussites
 *
 * @param String $msg Libellé de la réussite
 *
 * @return null
 */
function ajouterReussite($msg)
{
    if (!isset($_REQUEST['reussites'])) {
        $_REQUEST['reussites'] = array();
    }
    $_REQUEST['reussites'][] = $msg;
}

/**
 * Vérifie la longueur d'une chaine et tronque si celle-ci dépasse la longueur
 * voulu.
 * 
 * @param String $chaine chaine à contrôler.
 * @param Integer $longueur longueur de la chaine souhaité.
 * @return String retourne la chaine.
 */
function verificationLongueurChaine($chaine, $longueur) 
{
    if (strlen($chaine) > $longueur) {
        $chaine = substr($chaine, 0, $longueur);
    }
    return $chaine;
}

/**
 * Recherche le mois suivant.
 * 
 * @param String $mois le mois précédent.
 * @return string le mois suivant.
 */
function moisSuivant($mois) 
{
    $numAnnee = intval(substr($mois,0,4));
    $numMois = intval(substr($mois, 5));
    if ($numMois + 1 > 12) {
        $moisSuivant = strval($numAnnee + 1) . '01';
    } else if (strlen($numMois + 1) < 2) {
        $moisSuivant = strval($numAnnee) . '0' . strval($numMois + 1);
    } else {
        $moisSuivant = strval($numAnnee) . strval($numMois + 1);
    }
    return $moisSuivant;
}

/**
 * Valide que le nombre de justificatifs n'est pas nul et bien numérique.
 * 
 * @param Integer $justificatif
 * 
 * @return null
 */
function valideJustificatifs($justificatif) 
{
    if (!is_numeric($justificatif)) {
        ajouterErreur('Le champ nombre de justificatif doit être numérique.');
    }
}

/**
 * Recherche le bouton sur lequel l'utilisateur a appuyé.
 * 
 * @param Array $listeId liste d'id des frais hors forfait.
 * 
 * @return Integer index de la liste correspondant au bouton appuyé.
 */
function rechercheBoutonUtilise($listeId) 
{
    $i = 0;
    while (!isset($_POST[$listeId[$i]])) {
        $i++;
    }
    return $i;
}

/**
 * Vérifie si l'index ne dépasse pas le nombre d'élement d'une liste.
 * 
 * @param array $liste liste dont on doit vérifier le nombre d'élément
 * @param int $index index à vérifier
 * 
 * @return int l'index si sa valeur ne dépasse pas le nombre d'élément 
 * de la liste sinon retourne 0.
 */
function verificationIndex($liste, $index) 
{
     if ($index >= count($liste)) {
        $index = 0;
    }
    return $index;
}