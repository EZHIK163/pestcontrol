<?php
namespace app\forms;

use app\dto\Disinfectant;
use app\dto\DisinfectantSelect;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ManageDisinfectantsForm
 * @package app\forms
 */
class DisinfectantsForm extends Model
{
    public $disinfectants;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disinfectants',], 'required']
        ];
    }

    /**
     * @param Disinfectant[] $disinfectantsCustomer
     * @param Disinfectant[] $disinfectantsAll
     */
    public function fetchDisinfectants($disinfectantsCustomer, $disinfectantsAll)
    {
        foreach ($disinfectantsCustomer as &$disinfectantCustomer) {
            $disinfectantCustomer = $disinfectantCustomer->toArray();
        }

        $disinfectantsCustomer = ArrayHelper::index($disinfectantsCustomer, 'id');

        foreach ($disinfectantsAll as &$disinfectant) {
            $is_set = isset($disinfectantsCustomer[$disinfectant['id']]);
            $disinfectant['disinfectant'] = $disinfectant['description'];
            $disinfectant['is_set'] = $is_set;
            unset($disinfectant['description'], $disinfectant['value']);
        }

        $this->disinfectants = $disinfectantsAll;
    }

    /**
     * @return DisinfectantSelect[]
     */
    public function fillDisinfectants()
    {
        $disinfectants = [];
        foreach ($this->disinfectants as $disinfectant) {
            $disinfectants [] = (new DisinfectantSelect())
                ->setId($disinfectant['id'])
                ->setIsSelect($disinfectant['is_set']);
        }

        return $disinfectants;
    }
}
