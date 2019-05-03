<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property bool $is_active
 * @property int $count_sync_row
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class SynchronizeRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.synchronize_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['count_sync_row', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['count_sync_row', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'is_active'      => 'Is Active',
            'count_sync_row' => 'Count Sync Row',
            'created_at'     => 'Created At',
            'created_by'     => 'Created By',
            'updated_at'     => 'Updated At',
            'updated_by'     => 'Updated By',
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
}
