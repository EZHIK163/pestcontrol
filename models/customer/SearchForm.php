<?php
namespace app\models\customer;

use yii\base\Model;
use yii\web\UploadedFile;

class SearchForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $query;

    public function rules()
    {
        return [
            [['query'], 'safe']
        ];
    }

    /**
     * @return array|bool
     */
    public function getResultsForAdmin()
    {
        if (!$this->validate()) {
            return [];
        }

        $scheme_point_control = FileCustomer::getSchemePointControlForAdmin($this->query);
        return $scheme_point_control;
    }

    public function getResultsForAccount($id_customer)
    {
        if (!$this->validate()) {
            return [];
        }

        $scheme_point_control = FileCustomer::getSchemePointControlCustomer($id_customer, $this->query);
        return $scheme_point_control;
    }

}