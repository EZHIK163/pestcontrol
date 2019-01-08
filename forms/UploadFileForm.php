<?php
namespace app\forms;

use app\dto\FileExtension;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @package app\models\file
 */
class UploadFileForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $uploadedFiles;

    /**
     * @var int
     */
    public $idCustomer;

    /**
     * @var int
     */
    public $idFileCustomerType;

    /**
     * @var
     */
    private $supportExtensions;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $strExtensions = implode($this->supportExtensions, ',');
        return [
            [['uploadedFiles'], 'file',
                'skipOnEmpty' => false,
                'extensions' => $strExtensions,
                'maxFiles'  => 0, 'maxSize' => 1024000,
                'tooBig' => 'Превышен лимит файла 1МБ'],
            [['idCustomer', 'idFileCustomerType'], 'required']
        ];
    }

    /**
     * @param FileExtension[] $supportExtensions
     */
    public function setSupportExtension($supportExtensions)
    {
        $ext = [];
        foreach ($supportExtensions as $support_extension) {
            $ext [] = $support_extension->getExtension();
        }

        $this->supportExtensions = $ext;
    }
}
