<?php

namespace app\commands;

use app\models\tables\Tasks;
use app\models\tables\Users;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class TaskController extends Controller
{

    public $message = "Hello";

    /**
     * Display "test"
     */
    public function actionTest($id)
    {

        if ($user = Users::findOne($id)) {
            echo "{$this->message}, mr {$user->login}!!!";
            return ExitCode::OK;
        }
        return ExitCode::UNSPECIFIED_ERROR;
//     var_dump($user->login);
    }

    public function options($actionID)
    {
        return [
            'message'
        ];
    }

    public function actionDeadline()
    {

        $dateNow = date('Y-m-d');
        $date = date('Y-m-d', strtotime('+1 days'));

        $dateDeadline = Tasks::find()
            ->where(['date' => $date])
            ->all();

        foreach ($dateDeadline as $value) {
            $userEmail = Tasks::getUserEmail2($value['user_id']);

            \Yii::$app->mailer->compose()
                ->setTo($userEmail->user->email)
                ->setFrom(\Yii::$app->params['adminEmail'])
                ->setSubject('test')
                ->setTextBody('123')
                ->send();
//            var_dump($userEmail->user->email);

        }

//        var_dump($user);
    }


    public function actionHandle()
    {
        $count = 30;
        Console::startProgress(1, $count);
        for ($i = 1; $i <= 30; $i++) {
            sleep(1);
            Console::updateProgress($i, $count);
        }
        Console::endProgress(0);
        echo 'complete!!!';
    }

    public function optionAliases()
    {
        return [
            'm' => 'message'
        ];
    }


}