<?php

namespace app\models\file;

use app\models\customer\FileCustomer;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "files.files".
 *
 * @property int $id
 * @property bool $is_active
 * @property string $original_name
 * @property string $hash
 * @property string $size
 * @property int $id_extension
 * @property string $mime_type
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files.files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_extension', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_extension', 'created_at', 'created_by', 'updated_at', 'updated_by', 'size'], 'integer'],
            [['original_name', 'hash', 'mime_type'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_extension'], 'exist', 'skipOnError' => true, 'targetClass' => Extension::class, 'targetAttribute' => ['id_extension' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'original_name' => 'Original Name',
            'hash' => 'Hash',
            'size' => 'Size',
            'id_extension' => 'Id Extension',
            'mime_type' => 'Mime Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' =>  \yii\behaviors\TimestampBehavior::class,
            'blame'     => \yii\behaviors\BlameableBehavior::class
        ];
    }

    public static function saveFilesFromUpload($uploadedFiles, $id_customer, $id_file_customer_type) {
        foreach ($uploadedFiles as $uploadedFile) {
            $extension = Extension::findOne(['extension'    => $uploadedFile->extension]);
            $folder = $extension->type->path_to_folder;

            $hash = md5(microtime() . $uploadedFile->baseName . $uploadedFile->extension);

            $file = new Files();

            $file->original_name = $uploadedFile->baseName;
            $file->size = $uploadedFile->size;
            $file->id_extension = $extension->id;
            $file->mime_type = $uploadedFile->type;
            $file->hash = $hash;

            $file->save();

            FileCustomer::addFileCustomer($file->id, $id_customer, $uploadedFile->baseName, $id_file_customer_type);

            if (!file_exists(self::getRootPath() . $folder )) {
                mkdir(self::getRootPath() . $folder , 0777);
            }
            $uploadedFile->saveAs(self::getRootPath() . $folder . $hash . '.' . $uploadedFile->extension);
            return true;
        }
    }

    public static function getSupportExtensions() {
        return Extension::find(['is_active' => true])->all();
    }

    public static function getRootPath() {
        return 'uploads/';
    }

    public function getUrl() {
        return  \Yii::$app->urlManager->createAbsoluteUrl(['/']) .
            self::getRootPath() .
            $this->extension->type->path_to_folder .
            $this->hash . '.' .
            $this->extension->extension;
    }

    public function getFullPath() {
        return  self::getRootPath() .
            $this->extension->type->path_to_folder .
            $this->hash . '.' .
            $this->extension->extension;
    }

    public function getExtension() {
        return $this->hasOne(Extension::class, ['id' => 'id_extension']);
    }

    public static function getInfoForDownloadById($id) {
        $file = Files::findOne(['id'    => $id]);
        if (!$file) {
            throw new NotFoundHttpException();
        }
        $url = $file->getFullPath();
        $name = $file->original_name . '.' . $file->extension->extension;
        return compact('url', 'name');
    }

    public static function deleteFile($id) {
        $file_customer = FileCustomer::findOne($id);
        $id_file = $file_customer->id_file;
        $file_customer->is_active = false;
        $file_customer->save();

        $file = Files::findOne($id_file);
        $file->is_active = false;
        $file->save();
    }


}
