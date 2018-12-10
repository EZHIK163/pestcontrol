<?php

namespace app\entities;

use Yii;
use yii\base\ErrorException;

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

    public static function savePoint($id_internal, $id_customer, $x, $y, $id_file_customer) {

        $sql = "
        SELECT p.id 
        FROM public.points as p
        JOIN public.file_customer as fc ON fc.id = p.id_file_customer
        WHERE fc.id_customer = :id_customer AND p.id_internal = :id_internal";
        $point = Yii::$app->db->createCommand($sql)
            ->bindValue(':id_customer', $id_customer)
            ->bindValue(':id_internal', $id_internal)
            ->queryOne();

        $sql = "
        UPDATE public.points
        SET x_coordinate = :x_coordinate, y_coordinate = :y_coordinate, id_file_customer = :id_file_customer
        WHERE id = :id";
        \Yii::$app->db->createCommand($sql)
            ->bindValue(':x_coordinate', $x)
            ->bindValue(':y_coordinate', $y)
            ->bindValue(':id_file_customer', $id_file_customer)
            ->bindValue(':id', $point['id'])
            ->query();
        return true;
    }

    static function getPointsForManager($id_customer) {

        $points = self::find()
            ->select('
            points.id, 
            file_customer.title, 
            points.id_internal, 
            points.x_coordinate, 
            points.y_coordinate,
            points.is_active')
            ->join('inner join', 'public.file_customer', 'file_customer.id = points.id_file_customer')
            //->andWhere(['points.is_active' => true])
            ->andWhere(['file_customer.is_active' => true]);


        if (!is_null($id_customer)) {
            $points = $points->andWhere(['file_customer.id_customer'    => $id_customer]);
        }
        $points = $points
            ->orderBy('points.id_internal ASC')
            ->asArray()
            ->all();

        foreach ($points as &$point) {
            if ($point['is_active'] == false) {
                $point['status'] = 'Удалена';
            } else if ($point['x_coordinate'] <= 0 or $point['y_coordinate'] <= 0) {
                $point['status'] = 'Не прикреплена';
                $point['title'] = '';
            } else {
                $point['status'] = 'Прикреплена';
            }
        }

        return $points;
    }

    static function getFreePoints() {
        $points = self::find()
            ->where(['<=', 'x_coordinate', 0])
            ->orWhere(['<=', 'y_coordinate', 0])
            ->asArray()
            ->all();
        return $points;
    }

    static function getItemForEditing($id) {
        $point = self::find()
            ->select('
            points.x_coordinate, 
            points.y_coordinate, 
            file_customer.title, 
            points.id_file_customer,
            points.title')
            ->join('inner join', 'file_customer', 'file_customer.id = points.id_file_customer')
            ->where(['points.id'  => $id])
            ->asArray()
            ->all();

        if (!isset($point[0])) {
            throw new ErrorException("Точка не найдена");
        }
        return $point[0];
    }


    static function getIdCustomerPoint($id) {

        $point = self::find()
            ->select('file_customer.id_customer')
            ->join('inner join', 'file_customer', 'file_customer.id = points.id_file_customer')
            ->where(['points.id'  => $id])
            ->asArray()
            ->all();

        if (!isset($point[0])) {
            throw new ErrorException("Точка не найдена");
        }

        return $point[0]['id_customer'];
    }

    static function saveItem($id, $x_coordinate, $y_coordinate, $title, $id_file_customer) {

        $point = self::findOne($id);

        if ($point->id_file_customer != $id_file_customer) {
            $x_coordinate = 0;
            $y_coordinate = 0;
        }

        $point->y_coordinate = $y_coordinate;
        $point->x_coordinate = $x_coordinate;
        $point->title = $title;
        $point->id_file_customer = $id_file_customer;
        $point->is_active = true;

        $point->save();

        return true;
    }

    static function deletePoint($id) {
        $point = self::findOne($id);
        $point->is_active = false;

        $point->save();
    }

    static function getPointByIdInternal($id_internal, $id_customer) {
        $point = self::find()
            ->select('points.id')
            ->join('inner join', 'file_customer', 'file_customer.id = points.id_file_customer')
            ->where(['points.id_internal'  => $id_internal])
            ->andWhere(['file_customer.id_customer' => $id_customer])
            ->asArray()
            ->all()
        ;

        if (count($point) != 0) {
            return $point[0]['id'];
        } else {
            return null;
        }
    }

    public function getEvents()
    {
        return $this->hasMany(Events::class, ['id_point' => 'id'])->where(['is_active'  => true]);
    }
}
