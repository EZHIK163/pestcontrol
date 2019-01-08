<?php

namespace app\utilities;

use yii\db\Query;
use yii\rbac\DbManager;
use yii\rbac\Item;

/**
 * Class MyRbacManager
 * @package app\utilities
 */
class MyRbacManager extends DbManager
{
    public $itemTable = '{{%auth.item}}';
    public $itemChildTable = '{{%auth.item_child}}';
    public $assignmentTable = '{{%auth.assignment}}';
    public $ruleTable = '{{%auth.rule}}';

    /**
     * @param $userId
     * @return array|Item
     */
    public function getRoleByUser($userId)
    {
        $role = null;

        if (!isset($userId) || $userId === '') {
            return [];
        }

        $query = (new Query())->select('b.*')
            ->from(['a' => $this->assignmentTable, 'b' => $this->itemTable])
            ->where('{{a}}.[[item_name]]={{b}}.[[name]]')
            ->andWhere(['a.user_id' => (string) $userId])
            ->andWhere(['b.type' => Item::TYPE_ROLE])
            ->limit(1);

        foreach ($query->all($this->db) as $row) {
            $role = $this->populateItem($row);
        }

        return $role;
    }
}
