<?php

/* 
 * Classe teste de fonctions
 * 
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Tony FERNANDEZ <it.fernandeztony.gmail>
 * @version   GIT: <0>
 */

class test {
    
    public function __construct(){
    
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
}
