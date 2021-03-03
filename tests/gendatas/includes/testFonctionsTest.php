<?php
use PHPUnit\Framework\TestCase;
include 'C:\wamp64\www\GSB_AppliMVC\tests\testFonctions.php';
/**
 * Tests unitaire 
 */

class testTest extends PHPUnit\Framework\TestCase {

    /**
     * @var test
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp():void {
        $this->object = new test;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown():void {
        
    }

    /**
     * @covers test::creerListeNomPrenom
     * @todo   Implement testCreerListeNomPrenom().
     */
    public function testCreerListeNomPrenom() {
        for ($i = 0; $i < 3; $i++) {
            $tableau[$i] = ['idVisiteur'=>'a0' . $i, 'nom'=>'Fernandez' . $i, 'prenom'=>'Tony' . $i] ;
        }
        $objet = ['Fernandez0 Tony0', 'Fernandez1 Tony1', 'Fernandez2 Tony2'];
        $this->assertEquals($objet, $this->object->creerListeNomPrenom($tableau));
    }

    /**
     * @covers test::extraireListe
     * @todo   Implement testExtraireListe().
     */
    public function testExtraireListe() {
        for ($i = 0; $i < 3; $i++) {
            $tableau[$i] = ['idVisiteur'=>'a0' . $i, 'nom'=>['Fernandez' . $i, 'Tony' . $i]] ;
        }
        $cle = 'nom';
        $objet = [['Fernandez0','Tony0'],['Fernandez1','Tony1'],['Fernandez2','Tony2']];
        $this->assertEquals($objet, $this->object->extraireListe($tableau, $cle));
    }

    /**
     * @covers test::formatMois
     * @todo   Implement testFormatMois().
     */
    public function testFormatMois() {
        for ($i=1;$i<4;$i++) {
            $liste[$i - 1] = ['numMois' => '0' . $i,'numAnnee' => '2021'];
        }
        $objet = ['01 / 2021','02 / 2021','03 / 2021'];
        $this->assertEquals($objet, $this->object->formatMois($liste));
    }

    /**
     * @covers test::verificationLongueurChaine
     * @todo   Implement testVerificationLongueurChaine().
     */
    public function testVerificationLongueurChaine() {
        $chaine = 'foofoofoofoo';
        $longueur = 10;
        $objet = 'foofoofoof';
        $this->assertEquals($objet, $this->object->verificationLongueurChaine($chaine, $longueur));
    }

    /**
     * @covers test::moisSuivant
     * @todo   Implement testMoisSuivant().
     */
    public function testMoisSuivant() {
        $mois='202101';
        $objet='202102';
        $this->assertEquals($objet, $this->object->moisSuivant($mois));
    }

    /**
     * @covers test::rechercheBoutonUtilise
     * @todo   Implement testRechercheBoutonUtilise().
     */
    public function testRechercheBoutonUtilise() {
        $listeId = [1,2,3,4];
        $_POST[3] = 'foo';
        $objet = 2;
        $this->assertEquals($objet, $this->object->RechercheBoutonUtilise($listeId));  
    }

    /**
     * @covers test::verificationIndex
     * @todo   Implement testVerificationIndex().
     */
    public function testVerificationIndex() {
        $index = 6;
        $liste = [1,2,3,4,5];
        $objet = 0;
        $this->assertEquals($objet, $this->object->verificationIndex($liste,$index));
        
    }

}
