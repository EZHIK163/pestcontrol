<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
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
 *
 * @property FileExtensionRecord $extension
 */
class FileRecord extends ActiveRecord
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
            [['id_extension'], 'exist', 'skipOnError' => true, 'targetClass' => FileExtensionRecord::class, 'targetAttribute' => ['id_extension' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'is_active'         => 'Is Active',
            'original_name'     => 'Original Name',
            'hash'              => 'Hash',
            'size'              => 'Size',
            'id_extension'      => 'Id Extension',
            'mime_type'         => 'Mime Type',
            'created_at'        => 'Created At',
            'created_by'        => 'Created By',
            'updated_at'        => 'Updated At',
            'updated_by'        => 'Updated By',
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
    public function getExtension()
    {
        return $this->hasOne(FileExtensionRecord::class, ['id' => 'id_extension']);
    }
}
