<?php

namespace app\models\customer;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.file_customer_type".
 *
 * @property int $id
 * @property bool $is_active
 * @property string $description
 * @property string $code
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class FileCustomerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.file_customer_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description', 'code'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
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
            'description' => 'Description',
            'code' => 'Code',
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

    public static function getFileCustomerTypes() {
        return FileCustomerType::find()->all();
    }

    public static function getFileCustomerTypesForDropDownList() {
        $customers = self::getFileCustomerTypes();
        return ArrayHelper::map($customers,'id', 'description');
    }

    public function getFiles()
    {
        return $this->hasMany(FileCustomer::class, ['id_file_customer_type' => 'id'])->orderBy(['file_customer.created_at'=>SORT_DESC]);
    }

    public static function getCodeById($id) {
        return FileCustomerType::findOne($id)->code;
    }
}
