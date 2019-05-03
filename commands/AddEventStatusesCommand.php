<?php
namespace app\commands;

use app\entities\ExtensionTypeRecord;
use app\entities\FileExtensionRecord;
use app\entities\UserRecord;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда добавления статусов пойман грызун и поймано насекомое
 */
class AddEventStatusesCommand extends Controller
{
    public function actionIndex()
    {
        $sql = "
        INSERT INTO public.point_status 
        (description, code, created_at, created_by, updated_at, updated_by)
        VALUES 
        (:description, :code, :created_at, :created_by, :updated_at, :updated_by)";

        $updated_at = $created_at = \Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));

        $updated_by = $created_by = UserRecord::findOne(['username'    => 'admin'])->id;

        $code = 'caught_nagetier';
        $description = 'Пойман вредитель: грызун';

        \Yii::$app->db->createCommand($sql)
            ->bindValue(':description', $description)
            ->bindValue(':code', $code)
            ->bindValue(':created_at', $created_at)
            ->bindValue(':created_by', $created_by)
            ->bindValue(':updated_at', $updated_at)
            ->bindValue(':updated_by', $updated_by)
            ->query();

        $code = 'caught_insekt';
        $description = 'Пойман вредитель: насекомое';

        \Yii::$app->db->createCommand($sql)
            ->bindValue(':description', $description)
            ->bindValue(':code', $code)
            ->bindValue(':created_at', $created_at)
            ->bindValue(':created_by', $created_by)
            ->bindValue(':updated_at', $updated_at)
            ->bindValue(':updated_by', $updated_by)
            ->query();

        $this->stdout('Новые статусы добавлены' . PHP_EOL, Console::FG_GREEN);
    }
}
