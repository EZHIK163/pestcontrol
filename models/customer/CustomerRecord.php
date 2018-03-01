<?php

namespace app\models\customer;

use yii\db\ActiveRecord;

class CustomerRecord extends ActiveRecord {

    public static function tableName()
    {
        return 'customers';
    }

    public function rules()
    {
        return [
            ['id', 'number'],
            ['name', 'required'],
            ['name', 'string', 'max' => 20],
            ['created_by', 'required'],
            ['created_by', 'integer'],
            ['updated_by', 'required'],
            ['updated_by', 'integer'],
            ['updated_at', 'required'],
            ['updated_at', 'integer'],
            ['created_at', 'required'],
            ['created_at', 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' =>  \yii\behaviors\TimestampBehavior::class,
            'blame'     => \yii\behaviors\BlameableBehavior::class
        ];
    }


}