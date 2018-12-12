<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "public.disinfectant".
 *
 * @property int $id
 * @property bool $is_active
 * @property string $description
 * @property string $code
 * @property string $value
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property string $form_of_facility
 * @property string $active_substance
 * @property string $concentration_of_substance
 * @property string $manufacturer
 * @property string $terms_of_use
 * @property string $place_of_application
 */
class DisinfectantRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.disinfectant';
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
            [['description', 'code', 'value'], 'string', 'max' => 255],
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
            'description'       => 'Description',
            'code'              => 'Code',
            'value'             => 'Value',
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
            'timestamp' =>  TimestampBehavior::class,
            'blame'     => BlameableBehavior::class
        ];
    }
}
