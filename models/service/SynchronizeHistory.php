<?php

namespace app\models\service;

use Yii;

/**
 * This is the model class for table "public.synchronize_history".
 *
 * @property int $id
 * @property bool $is_active
 * @property int $count_sync_row
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class SynchronizeHistory extends \yii\db\ActiveRecord
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
            'id' => 'ID',
            'is_active' => 'Is Active',
            'count_sync_row' => 'Count Sync Row',
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

    static function getLastSynchronize() {
        $last_sync = self::find()->select('created_at')
            ->orderBy('created_at DESC')
            ->limit(1)
            ->asArray()
            ->all();

        $datetime = new \DateTime();

        if (!isset($last_sync[0]['created_at'])) {
            $last_sync['created_at'] = 0;
        }

        $datetime->setTimestamp($last_sync[0]['created_at']);

        return $datetime->format('Y-m-d H:i:s');
    }

    static function addSynchronize($count_sync_row) {

        $sync = new self();

        $sync->count_sync_row = $count_sync_row;

        $sync->save();
    }
}
