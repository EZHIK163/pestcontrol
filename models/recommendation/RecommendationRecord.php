<?php

namespace app\models\recommendation;

use app\models\user\UserRecord;
use Yii;

/**
 * This is the model class for table "recommendations_for_customer".
 *
 * @property int $id
 * @property bool $is_active
 * @property string $name
 * @property int $id_file
 * @property int $id_customer
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property AuthUsers $createdBy
 * @property AuthUsers $updatedBy
 * @property FilesFiles $file
 */
class RecommendationRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recommendations_for_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_file', 'id_customer', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_file', 'id_customer', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => FilesFiles::className(), 'targetAttribute' => ['id_file' => 'id']],
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
            'name' => 'Name',
            'id_file' => 'Id File',
            'id_customer' => 'Id Customer',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(AuthUsers::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(AuthUsers::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(FilesFiles::className(), ['id' => 'id_file']);
    }
}
