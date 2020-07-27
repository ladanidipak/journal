<?php

namespace console\controllers;

use backend\models\Contact;
use backend\models\EmailRequest;
use backend\models\PritMailer;
use yii\console\Controller;
use yii\console\Exception;

/**
 * Test controller
 */
class EmailController extends Controller {

    public function actionIndex() {

        $time_start = microtime(true);
        $now = date("Y-m-d H:i:s");

        $date = date("Y-m-d");
        echo PHP_EOL . '--- Cron started for adding in notification table at -- ' . date("Y-m-d H:i:s") . PHP_EOL;

        $requests = EmailRequest::find()->where(['and','send_status = 1 or send_status = 2',['is_deleted'=>0]])->all();
        $count = 0;
        if (!empty($requests)) {
            foreach ($requests as $req) {

                $message = $req->message;

                $users = null;
                if($req->send_status == 2){
                    $idGreater = "id > {$req->id_ended}";
                } else {
                    $idGreater = "1 = 1";
                }
                if($req->id_from && $req->id_to){
                    $users = Contact::find()->where(['and',$idGreater,['between','id',$req->id_from,$req->id_to],['is_deleted'=>0,'unsubscribed'=>0]])->orderBy('id ASC')->all();
                } elseif($req->send_to_ids){
                    $ids = explode(',',$req->send_to_ids);
                    $users = Contact::find()->where(['and', $idGreater, ['id'=>$ids,'is_deleted'=>0,'unsubscribed'=>0]])->orderBy('id ASC')->all();
                } elseif($req->list_id){
                    $users = Contact::find()->where(['and', $idGreater, ['list_id'=>$req->list_id,'is_deleted'=>0,'unsubscribed'=>0]])->orderBy('id ASC')->all();
                }
                $req->send_status = 2;
                $req->update();
                if ($users) {
                    foreach ($users as $user) {

                        try{
                            /*$subject = Notification::processContent($message->subject, array('user' => $user));
                        $body = Notification::processContent($message->email_content, array('user' => $user));*/
                            $subject = $message->subject;
                            $body = $message->content;
                            $data = [];
                            $data['body']=$body;
                            $data['subject']=$subject;
                            $data['email']=$user->email_id;
                            $data['from_name']=$message->from_name;
                            $data['from_email']=$message->from_email;
                            if(PritMailer::marketingEmail($data)){
                                $count ++;
                                echo $user->id.",";
                                $req->id_ended =$user->id;
                                $req->update();
                            }
                        }catch (\Exception $e){
                            echo $e->getTraceAsString();
                        }

                    }
                }
                $req->send_status = 3;
                $req->update();
            }
        }
        /* End */
        echo PHP_EOL."Notification sent to ".$count. ' users.';
        $time_end = microtime(true);
        $time = number_format(($time_end - $time_start) / 60, 3);
        /**/
        echo PHP_EOL."Process Time: {$time} minutes" . PHP_EOL;
        echo '--- Cron ended at -- ' . date("Y-m-d H:i:s") . ' .' . PHP_EOL;
    }

}