<?php
namespace app\models\file;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $uploadedFiles;

    public $id_customer;

    public $id_file_customer_type;

    public function rules()
    {
        $support_extensions = Files::getSupportExtensions();
        $extensions = [];
        foreach ($support_extensions as $support_extension) {
            $extensions [] = $support_extension->extension;
        }
        $extensions_s = implode($extensions, ',');
        return [
            [['uploadedFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => $extensions_s, 'maxFiles'  => 0],
            [['id_customer', 'id_file_customer_type'], 'required']
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $result = Files::saveFilesFromUpload($this->uploadedFiles, $this->id_customer, $this->id_file_customer_type);
            return $result;
        } else {
            return false;
        }
    }
}