<?php
namespace app\models\customer;

use app\services\FileCustomerService;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class SearchForm
 * @package app\models\customer
 */
class SearchForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $query;

    private $fileCustomerService;

    /**
     * SearchForm constructor.
     * @param FileCustomerService $fileCustomerService
     * @param array $config
     */
    public function __construct(FileCustomerService $fileCustomerService, array $config = [])
    {
        $this->fileCustomerService = $fileCustomerService;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['query'], 'safe']
        ];
    }

    /**
     * @return array|bool
     */
    public function getResultsForAdmin()
    {
        if (!$this->validate()) {
            return [];
        }

        $scheme_point_control = $this->fileCustomerService->getSchemePointControlForAdmin($this->query);
        return $scheme_point_control;
    }

    public function getResultsForAccount($id_customer)
    {
        if (!$this->validate()) {
            return [];
        }

        $scheme_point_control = $this->fileCustomerService->getSchemePointControlCustomer($id_customer, $this->query);
        return $scheme_point_control;
    }
}
