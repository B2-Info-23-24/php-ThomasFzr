<?php
class AvisController
{

    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }


    function getAvis()
    {
        if (isset($_SESSION['userID'])) {
            require_once __DIR__ . '/../models/Database.php';
            $db = new Database();
            $tabAvis = $db->getCommentGradeFromUser();

            if (is_array($tabAvis) && !empty($tabAvis)) {
                $annonceIDs = array_column($tabAvis, 'annonceID');
                $tabAnnonce = [];

                foreach ($annonceIDs as $annonceID) {
                    $detailsAnnonce = $db->getDetailsAnnonce($annonceID);
                    $tabAnnonce[$annonceID] = $detailsAnnonce[0];
                }

                echo $this->twig->render('avisView.php', [
                    'tabAvis' => $tabAvis,
                    'tabAnnonce' => $tabAnnonce
                ]);
            } else {
                echo $this->twig->render('avisView.php');
            }
        } else {
            header('Location: /connection');
        }
    }
}
