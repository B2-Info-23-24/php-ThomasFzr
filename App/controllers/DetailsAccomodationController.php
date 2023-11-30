<?php
class DetailsAccomodationController
{
    private $twig;


    public function __construct($twig)
    {
        $this->twig = $twig;
    }



    public function getDetailsAccomodation($accomodationID)
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/Favorite.php';
        require_once __DIR__ . '/../models/Review.php';
        require_once __DIR__ . '/../models/Accomodation.php';
        require_once __DIR__ . '/../models/Service.php';
        require_once __DIR__ . '/../models/Equipment.php';
        require_once __DIR__ . '/../models/AccomodationType.php';

        $database = new Database();
        $favorite = new Favorite();
        $review = new Review();
        $accomodation = new Accomodation();
        $service = new Service();
        $equipment = new Equipment();
        $accoType = new AccomodationType();

        $infoAccomodation = $accomodation->getDetailsAccomodation($accomodationID);
        $tabService = $service->getServiceFromAccomodation($accomodationID);
        $tabEquipment = $equipment->getEquipmentFromAccomodation($accomodationID);
        $tabReview = $review->getReviewFromAccomodation($accomodationID);
        $averageGrade = $this->calculateAverageGrade($tabReview);
        $allEquipments = $equipment->getEquipment();
        $allServices = $service->getService();
        $allAccomodationTypes = $accoType->getAccomodationType();
        $allImages = $database->getImage();
        $allCities = $database->getCity();

        $userID = null;
        $isInFavorite = null;

        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $isInFavorite = $favorite->isInFavorite($accomodationID);
        }
        echo $this->twig->render('detailsAccomodationView.php', [
            'infoAccomodation' => $infoAccomodation,
            'services' => $tabService,
            'equipments' => $tabEquipment,
            'isInFavorite' => $isInFavorite,
            'tabReview' => $tabReview,
            'averageGrade' => $averageGrade,
            'userID' => $userID,
            'allEquipments' => $allEquipments,
            'allServices' => $allServices,
            'allAccomodationTypes' => $allAccomodationTypes,
            'allImages' => $allImages,
            'allCities' => $allCities

        ]);
    }

    private function calculateAverageGrade($tabReview)
    {
        if (empty($tabReview)) {
            return null;
        }
        $totalGrade = 0;
        foreach ($tabReview as $review) {
            $totalGrade += $review['grade'];
        }
        $averageGrade = $totalGrade / count($tabReview);
        return number_format($averageGrade, 1);
    }
}
