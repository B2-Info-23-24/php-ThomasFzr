<?php
class DetailsAccommodationController
{
    private $twig;


    public function __construct($twig)
    {
        $this->twig = $twig;
    }



    public function getDetailsAccommodation($accommodationID)
    {
        require_once __DIR__ . '/../models/Database.php';
        require_once __DIR__ . '/../models/Favorite.php';
        require_once __DIR__ . '/../models/Review.php';
        require_once __DIR__ . '/../models/Accommodation.php';
        require_once __DIR__ . '/../models/Service.php';
        require_once __DIR__ . '/../models/Equipment.php';
        require_once __DIR__ . '/../models/AccommodationType.php';

        $database = new Database();
        $favorite = new Favorite();
        $review = new Review();
        $accommodation = new Accommodation();
        $service = new Service();
        $equipment = new Equipment();
        $accoType = new AccommodationType();

        $infoAccommodation = $accommodation->getDetailsAccommodation($accommodationID);
        $tabService = $service->getServiceFromAccommodation($accommodationID);
        $tabEquipment = $equipment->getEquipmentFromAccommodation($accommodationID);
        $tabReview = $review->getReviewFromAccommodation($accommodationID);
        $averageGrade = $this->calculateAverageGrade($tabReview);
        $allEquipments = $equipment->getEquipment();
        $allServices = $service->getService();
        $allAccommodationTypes = $accoType->getAccommodationType();
        $allImages = $database->getImage();
        $allCities = $database->getCity();

        $userID = null;
        $isInFavorite = null;

        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $isInFavorite = $favorite->isInFavorite($accommodationID);
        }
        echo $this->twig->render('detailsAccommodationView.twig', [
            'infoAccommodation' => $infoAccommodation,
            'services' => $tabService,
            'equipments' => $tabEquipment,
            'isInFavorite' => $isInFavorite,
            'tabReview' => $tabReview,
            'averageGrade' => $averageGrade,
            'userID' => $userID,
            'allEquipments' => $allEquipments,
            'allServices' => $allServices,
            'allAccommodationTypes' => $allAccommodationTypes,
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
