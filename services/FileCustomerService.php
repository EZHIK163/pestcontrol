<?php
namespace app\services;
;
use app\dto\FileCustomer;
use app\dto\Point;
use app\repositories\CustomerRepositoryInterface;
use app\repositories\EventRepositoryInterface;
use app\repositories\FileCustomerRepositoryInterface;
use app\repositories\FileRepositoryInterface;
use app\repositories\PointRepositoryInterface;
use DateInterval;
use DateTime;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class FileCustomerService
 * @package app\services
 */
class FileCustomerService
{
    private $fileCustomerRepository;
    private $pointRepository;
    private $eventRepository;
    private $customerRepository;
    private $fileRepository;

    /**
     * FileCustomerService constructor.
     * @param FileCustomerRepositoryInterface $fileCustomerRepository
     * @param PointRepositoryInterface $pointRepository
     * @param EventRepositoryInterface $eventRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param FileRepositoryInterface $fileRepository
     */
    public function __construct(
        FileCustomerRepositoryInterface $fileCustomerRepository,
        PointRepositoryInterface $pointRepository,
        EventRepositoryInterface $eventRepository,
        CustomerRepositoryInterface $customerRepository,
        FileRepositoryInterface $fileRepository
    ) {
        $this->fileCustomerRepository = $fileCustomerRepository;
        $this->pointRepository = $pointRepository;
        $this->eventRepository = $eventRepository;
        $this->customerRepository = $customerRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @return array
     */
    public function getRecommendationsForAccount()
    {
        $search = '';
        return $this->getFiles('recommendations', $search, true);
    }

    /**
     * @param $search
     * @return array
     */
    public function getSchemePointControlForAdmin($search)
    {
        $scheme_point_control = $this->getFiles('scheme_point_control', $search, true);
        $result = ArrayHelper::index($scheme_point_control, null, 'customer');
        return $result;
    }

    /**
     * @param $idCustomer
     * @param $search
     * @return array
     */
    public function getSchemePointControlCustomer($idCustomer, $search)
    {
        $files = $this->getFiles('scheme_point_control', $search, false, $idCustomer);

        return $files;
    }

    /**
     * @param $id
     * @param bool $isAddFreePoints
     * @param null $dateFrom
     * @param null $dateTo
     * @return array
     * @throws \Exception
     */
    public function getSchemeForEdit($id, $isAddFreePoints = false, $dateFrom = null, $dateTo = null)
    {
        $fileCustomer = $this->fileCustomerRepository->get($id);
        $file = $fileCustomer->getFile();

        $actionDownload = Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';

        $allPoints = $this->pointRepository->all();
        $pointsCustomer = [];
        foreach ($allPoints as $pointCustomer) {
            if ($pointCustomer->getFileCustomer()->getId() == $fileCustomer->getId() && $pointCustomer->isEnable() === true) {
                $pointsCustomer [] = $pointCustomer;
            }
        }

        $idCustomer = $fileCustomer->getCustomer()->getId();

        $finishPoints = [];
        $maxIdInternal = $this->getMaxIdInternal($idCustomer);
        $idsPoints = [];

        $datetimeFrom = new DateTime($dateFrom);
        $datetimeTo = new DateTime($dateTo);

        $intervalDays = (int)$datetimeTo->diff($datetimeFrom)->format('%a');

        $mode = null;
        if ($intervalDays >= 0 && $intervalDays <= 31) {
            $mode = 'month';
        } elseif ($intervalDays >= 32 && $intervalDays <= 93) {
            $mode = 'quarter';
        } elseif ($intervalDays >= 94) {
            $mode = 'year';
        }

        $typeMarker = $this->getTypeMarker($idCustomer, $mode);

        /**
         * @var Point $pointCustomer
         */
        foreach ($pointsCustomer as $pointCustomer) {
            if (!$isAddFreePoints && ($pointCustomer->getXCoordinate() <= 0 or $pointCustomer->getYCoordinate() <= 0)) {
                continue;
            }

            $imgSrc = Yii::$app->urlManager->createAbsoluteUrl(['/']). $typeMarker.'.png';

            $finishPoints [] = [
                'x'                 => $pointCustomer->getXCoordinate(),
                'y'                 => $pointCustomer->getYCoordinate(),
                'img_src'           => $imgSrc,
                'id_internal'       => $pointCustomer->getIdInternal(),
                'is_new'            => false,
                'id'                => $pointCustomer->getId()
            ];
            $idsPoints [] = $pointCustomer->getId();
        }
        if ($isAddFreePoints) {
            $points = $this->pointRepository->all();

            $freePoints = [];
            foreach ($points as $point) {
                if ($point->getXCoordinate() <= 0 or $point->getYCoordinate() <= 0) {
                    $freePoints [] = $point;
                }
            }
            /**
             * @var Point $freePoint
             */
            foreach ($freePoints as $freePoint) {
                if (in_array($freePoint->getId(), $idsPoints)) {
                    continue;
                }
                $finishPoints [] = [
                    'x'             => $freePoint->getXCoordinate(),
                    'y'             => $freePoint->getYCoordinate(),
                    'img_src'       => Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'blue_marker.png',
                    'id_internal'   => $freePoint->getIdInternal(),
                    'is_new'        => false,
                    'id'            => $freePoint->getId()
                ];
            }
        }
        $result = [
            'img'                           => $actionDownload.$file->getId(),
            'img_src_new_point'             => Yii::$app->urlManager->createAbsoluteUrl(['/']). 'blue_marker.png',
            'max_id_internal_in_customer'   => $maxIdInternal,
            'id_file_customer'              => $fileCustomer->getId(),
            'points'                        => $finishPoints
        ];

        return $result;
    }

    /**
     * @param $idCustomer
     * @param $mode
     * @return string
     * @throws \Exception
     */
    public function getTypeMarker($idCustomer, $mode)
    {
        switch ($mode) {
            case 'month':
                $fromDate = (new DateTime())->sub(DateInterval::createFromDateString('1 month'));
                break;
            case 'quarter':
                $fromDate = (new DateTime())->sub(DateInterval::createFromDateString('3 month'));
                break;
            case 'year':
                $fromDate = (new DateTime())->sub(DateInterval::createFromDateString('12 month'));
                break;
            default:
                $fromDate = (new DateTime())->sub(DateInterval::createFromDateString('1 month'));
                break;
        }
        $toDate = new DateTime();
        $toDate = $toDate->add(DateInterval::createFromDateString('1 days'));
        $toTimestamp = $toDate->getTimestamp();
        $fromTimestamp = Yii::$app->formatter->asTimestamp($fromDate);

        $events = $this->eventRepository->getItemsByIdCustomerAndPeriod($idCustomer, $fromTimestamp, $toTimestamp);

        $count_red_events = 0;
        $count_green_events = 0;
        foreach ($events as $event) {
            switch ($event->getPointStatus()->getId()) {
                case 1:
                case 2:
                case 3:
                    $count_green_events++;
                    break;
                case 4:
                case 5:
                case 6:
                    $count_red_events++;
                    break;
            }
        }

        $marker = 'blue_marker';
        switch ($mode) {
            case 'month':
                if ($count_red_events > 3) {
                    $marker = 'red_marker';
                } elseif ($count_green_events > 3) {
                    $marker = 'green_marker';
                }
                break;
            case 'quarter':
                if ($count_red_events > 6) {
                    $marker = 'red_marker';
                } elseif ($count_green_events > 6) {
                    $marker = 'green_marker';
                }
                break;
            case 'year':
                if ($count_red_events > 20) {
                    $marker = 'red_marker';
                } elseif ($count_green_events > 20) {
                    $marker = 'green_marker';
                }
                break;
        }
        return $marker; //blue_marker, red_marker, green_marker
    }

    /**
     * @param $idCustomer
     * @return int
     */
    public function getMaxIdInternal($idCustomer)
    {
        $max = $this->pointRepository->getMaxIdInternal($idCustomer);

        if (is_null($max)) {
            return 1;
        }

        return $max + 1;
    }

    /**
     * @param $idCustomer
     * @return array
     */
    public function getSchemePointControlForDropDownList($idCustomer)
    {
        $scheme = $this->getSchemePointControlCustomer($idCustomer, '');

        return ArrayHelper::map($scheme, 'id_file_customer', 'title');
    }

    /**
     * @param $id
     * @return array
     */
    public function getSchemeForStat($id)
    {
        $fileCustomer = $this->fileCustomerRepository->get($id);

        $action_download = Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';

        $model = [
            'id_file_customer'  => $fileCustomer->getId(),
            'title'             => $fileCustomer->getTitle(),
            'customer'          => $fileCustomer->getCustomer()->getName(),
            'date_create'       => $fileCustomer->getCreatedAt()->format('d.m.y'),
            'url'               => $action_download.$fileCustomer->getFile()->getId()
        ];

        return $model;
    }

    /**
     * @param $idFile
     * @param $idCustomer
     * @param $title
     * @param $idFileCustomerType
     */
    public function addFileCustomer($idFile, $idCustomer, $title, $idFileCustomerType)
    {
        $customer = $this->customerRepository->get($idCustomer);
        $file = $this->fileRepository->get($idFile);

        $fileCustomer = (new FileCustomer())
            ->setTitle($title)
            ->setCustomer($customer)
            ->setFile($file)
            ->setTypeId($idFileCustomerType);

        $this->fileCustomerRepository->add($fileCustomer);
    }

    /**
     * @return array
     */
    public function getRecommendationsForAdmin()
    {
        $files = $this->fileCustomerRepository->getItemsByTypeCode('recommendations');

        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';

        $recommendations = [];
        foreach ($files as $file) {
            $recommendations [] = [
                'id_file_customer'  => $file->getId(),
                'title'             => $file->getTitle(),
                'customer'          => $file->getCustomer()->getName(),
                'date_create'       => $file->getCreatedAt()->format('d.m.y'),
                'url'               => $action_download.$file->getFile()->getId()
            ];
        }
        return $recommendations;
    }


    /**
     * @param $code
     * @param $search
     * @param bool $isAdmin
     * @param null $idCustomer
     * @return array
     */
    private function getFiles($code, $search, $isAdmin = false, $idCustomer = null)
    {
        /**
         * @var FileCustomer[] $files
         */
        $files = $this->fileCustomerRepository->getItemsByTypeCode($code);

        $customerFiles = $files;

        if (!$isAdmin) {
            $customerFiles = [];
            foreach ($files as &$file) {
                if ($file->getCustomer()->getId() == $idCustomer) {
                    $customerFiles [] = $file;
                }
            }
        }

        $files = $customerFiles;

        $preparedFiles = [];
        if (!empty($search)) {
            foreach ($files as $preparedFile) {
                $isSearch = false;
                $points = $this->pointRepository->getItemsByIdFileCustomer($preparedFile->getId());
                foreach ($points as $point) {
                    if ($point->getIdInternal() == $search) {
                        $isSearch = true;
                        break;
                    }
                }
                if ($isSearch or stripos($preparedFile->getTitle(), $search) !== false) {
                    $preparedFiles [] = $preparedFile;
                }
            }
        } else {
            $preparedFiles = $files;
        }

        $action_download = Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';
        $result = [];
        foreach ($preparedFiles as $preparedFile) {
            $result [] = [
                'id_file_customer'  => $preparedFile->getId(),
                'title'             => $preparedFile->getTitle(),
                'customer'          => $preparedFile->getCustomer()->getName(),
                'date_create'       => $preparedFile->getCreatedAt()->format('d.m.y'),
                'url'               => $action_download.$preparedFile->getFile()->getId()
            ];
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getFileCustomerTypesForDropDownList()
    {
        $types = $this->fileCustomerRepository->getTypes();
        foreach ($types as &$type) {
            $type = $type->toArray();
        }
        return ArrayHelper::map($types, 'id', 'description');
    }

    /**
     * @param $id
     * @return string
     */
    public function getCodeById($id)
    {
        $fileCustomerType = $this->fileCustomerRepository->getTypeById($id);
        return $fileCustomerType->getCode();
    }

    /**
     * @param $id
     */
    public function deleteFile($id)
    {
        $fileCustomer = $this->fileCustomerRepository->get($id);
        $this->fileCustomerRepository->remove($fileCustomer);
    }
}
