<?php
namespace app\forms;

use app\dto\Event;
use yii\base\Model;

/**
 * Class EventForm
 * @package app\forms
 */
class SchemeRenameForm extends Model
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title'], 'required'],
            [['id'], 'integer'],
            [['title'], 'string']
        ];
    }

    /**
     * @param $id
     * @param $title
     */
    public function fill($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'Уникальный идентификатор',
            'title' => 'Наименование схемы',
        ];
    }
}
