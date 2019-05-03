<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property bool $is_active
 * @property string $description
 * @property string $extension
 * @property int $id_type
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property ExtensionTypeRecord $type
 */
class FileExtensionRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files.extension';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description', 'extension'], 'string', 'max' => 255],
            [['id_type'], 'exist', 'skipOnError' => true, 'targetClass' => ExtensionTypeRecord::class, 'targetAttribute' => ['id_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'is_active'     => 'Is Active',
            'description'   => 'Description',
            'extension'     => 'Extension',
            'id_type'       => 'Id Type',
            'created_at'    => 'Created At',
            'created_by'    => 'Created By',
            'updated_at'    => 'Updated At',
            'updated_by'    => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'blame'     => BlameableBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ExtensionTypeRecord::class, ['id' => 'id_type']);
    }
}
