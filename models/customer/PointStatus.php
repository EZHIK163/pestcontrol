<?php

namespace app\models\customer;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.point_status".
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
class PointStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.point_status';
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

    public static function getIdItemByCode($code) {
        return self::findOne(['code'    => $code])->id;
    }

    public function getPointStatuses() {
        $statuses = self::find()
            ->orderBy('id')
            ->asArray()
            ->all();
        return $statuses;
    }
    static function getPointStatusesForDropDownList() {
        $statuses = self::getPointStatuses();

        return ArrayHelper::map($statuses, 'id', 'description');
    }

    static function getStatusesForApplication() {
        $statuses = self::getPointStatuses();
        return $statuses;
    }
}
