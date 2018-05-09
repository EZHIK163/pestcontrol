<?php

namespace app\models\customer;

use Yii;

/**
 * This is the model class for table "public.points".
 *
 * @property int $id
 * @property bool $is_active
 * @property int $id_point_status
 * @property string $title
 * @property double $x_coordinate
 * @property double $y_coordinate
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $id_file_customer
 * @property int $id_internal
 */
class Points extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_point_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'id_file_customer', 'id_internal'], 'default', 'value' => null],
            [['id_point_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'id_file_customer', 'id_internal'], 'integer'],
            [['x_coordinate', 'y_coordinate'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_file_customer'], 'exist', 'skipOnError' => true, 'targetClass' => FileCustomer::class, 'targetAttribute' => ['id_file_customer' => 'id']],
            [['id_point_status'], 'exist', 'skipOnError' => true, 'targetClass' => PointStatus::class, 'targetAttribute' => ['id_point_status' => 'id']],
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
            'id_point_status' => 'Id Point Status',
            'title' => 'Title',
            'x_coordinate' => 'X Coordinate',
            'y_coordinate' => 'Y Coordinate',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'id_file_customer' => 'Id File Customer',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' =>  \yii\behaviors\TimestampBehavior::class,
            'blame'     => \yii\behaviors\BlameableBehavior::class
        ];
    }

    public static function savePoint($id_internal, $id_customer, $x, $y) {

        $sql = "
        SELECT p.id 
        FROM public.points as p
        JOIN public.file_customer as fc ON fc.id = p.id_file_customer
        WHERE fc.id_customer = :id_customer AND p.id_internal = :id_internal";
        $point = Yii::$app->db->createCommand($sql)
            ->bindValue(':id_customer', $id_customer)
            ->bindValue(':id_internal', $id_internal)
            ->queryOne();

        $sql = "UPDATE public.points
        SET x_coordinate = :x_coordinate, y_coordinate = :y_coordinate
        WHERE id = :id";
        \Yii::$app->db->createCommand($sql)
            ->bindValue(':x_coordinate', $x)
            ->bindValue(':y_coordinate', $y)
            ->bindValue(':id', $point['id'])
            ->query();
        return true;
    }

    static function getPointsForManager($id_customer) {

        $points = self::find()
            ->select('points.id, file_customer.title, points.id_internal')
            ->join('inner join', 'public.file_customer', 'file_customer.id = points.id_file_customer')
            ->andWhere(['points.is_active' => true])
            ->andWhere(['file_customer.is_active' => true]);


        if (!is_null($id_customer)) {
            $points = $points->andWhere(['file_customer.id_customer'    => $id_customer]);
        }
        $points = $points
            ->orderBy('points.id_internal ASC')
            ->asArray()
            ->all();
        return $points;
    }
}
