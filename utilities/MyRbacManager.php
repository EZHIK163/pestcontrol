<?php

namespace app\utilities;

use yii\db\Query;
use yii\rbac\Assignment;
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

    /**
     * {@inheritdoc}
     */
    public function assign($role, $userId)
    {
        $assignment = new Assignment([
            'userId' => $userId,
            'roleName' => $role->name,
            'createdAt' => time(),
        ]);

        $this->db->createCommand()
            ->insert($this->assignmentTable, [
                'user_id' => $assignment->userId,
                'item_name' => $assignment->roleName,
                'created_at' => $assignment->createdAt,
            ])->execute();

        return $assignment;
    }


    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function revoke($role, $userId)
    {
        if (!isset($userId) || $userId === '') {
            return false;
        }

        return $this->db->createCommand()
                ->delete($this->assignmentTable, ['user_id' => (string) $userId, 'item_name' => $role->name])
                ->execute() > 0;
    }

}
