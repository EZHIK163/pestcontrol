<?php
namespace app\models\file;

use app\entities\FileCustomerTypeRecord;
use app\services\FileCustomerService;
use app\services\FileService;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @package app\models\file
 */
class UploadForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $uploadedFiles;

    public $id_customer;

    public $id_file_customer_type;

    private $fileService;
    private $fileCustomerService;

    /**
     * UploadForm constructor.
     * @param FileService $fileService
     * @param FileCustomerService $fileCustomerService
     * @param array $config
     */
    public function __construct(
        FileService $fileService,
        FileCustomerService $fileCustomerService,
        array $config = []
    ) {
        $this->fileCustomerService = $fileCustomerService;
        $this->fileService = $fileService;
        parent::__construct($config);
    }

    public function rules()
    {
        $support_extensions = $this->fileService->getSupportExtensions();
        $extensions_s = implode($support_extensions, ',');
        return [
            [['uploadedFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => $extensions_s, 'maxFiles'  => 0],
            [['id_customer', 'id_file_customer_type'], 'required']
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $result = $this->fileService->saveFilesFromUpload($this->uploadedFiles, $this->id_customer, $this->id_file_customer_type);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getViewAfterUpload()
    {
        $code = $this->fileCustomerService->getCodeById($this->id_file_customer_type);
        switch ($code) {
            case 'recommendations':
                $action = 'recommendations';
                break;
            case 'scheme_point_control':
                $action = 'scheme-point-control';
                break;
        }
        return $action;
    }
}
