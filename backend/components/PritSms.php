<?php

/**
 * User: pritesh
 * Date: 21/10/15
 * Time: 5:53 PM
 */

namespace backend\components;

use backend\models\SmsReport;
use yii\helpers\Json;

/**
 * Class WowEmail
 * @package backend\components
 * Email functions to send email to customer.
 */
Class PritSms {

    /**
     * @var $type "Individual"; //Can be "Bulk/Group”
     */
    public $sendsms, $to, $message, $user_name, $password, $mask, $version, $type;
    public $sendData;
    public $response;
    public $report;
    public $testMode = false;
    public $article_id = 0;
    public static $templates = [
        'submitted' => "Hello {{NAME}}\n Your Manuscript with ID {{PAPER_ID}} submitted successfully. Check status:goo.gl/wzezrB E:info@grdjournals.com M:07405407107 grdjournals.com",
        'rejected' => "Dear {{NAME}}\n Your manuscript with ID {{PAPER_ID}} is rejected. Plz check your email for details. E:info@grdjournals.com M:07405407107 www.grdjournals.com",
        'accepted' => "Dear {{NAME}}\n Article with ID {{PAPER_ID}} is accepted. for next step click:goo.gl/GOr7n4 or Check mail E:info@grdjournals.com M:07405407107 grdjournals.com",
        'reminder' => "Dear {{NAME}}\n Article with ID {{PAPER_ID}} is accepted. for next step click:goo.gl/GOr7n4 or Check mail E:info@grdjournals.com M:07405407107 grdjournals.com", //send reminder button
        'published' => "Dear {{NAME}}\n Article {{PAPER_ID}} is published in vol {{VOLUME}} is {{ISSUE}} of GRDJE. Click here to check:goo.gl/xdPfB9 info@grdjournals.com 07405407107 grdjournals.com",
        'confpublished' => "Dear {{NAME}}\n Article {{PAPER_ID}} is published in special issue of GRDJE conference {{CONFNO}}. Click here to check:goo.gl/xdPfB9 info@grdjournals.com 07405407107",
        'reviewreminder' => "Dear {{NAME}}\n We have sent you a request to review an article. Plz check your email to respond. Check spam mail if not found. info@grdjournals.com 07405407107", /// send to reviewer button /// send to reviewer button //review request
        'reviewrequest' => "Dear {{NAME}}\n A review is pending from you. Please check your email to submit the review. Check spam mail if not found. E:info@grdjournals.com M:07405407107", // review ewquest button //send to reviewer button
    ];

    function __construct($params) {
        $this->sendsms = "";
        $this->to = $this->checkEmpty($params, 'to');
        $this->message = $this->checkEmpty($params, 'message');
        $this->user_name = \Yii::$app->params['smsUser'];
        $this->password = \Yii::$app->params['smsPassword'];
        $this->mask = \Yii::$app->params['smsMask'];
        $countNumbers = explode(",", $this->to);
        $numbers = [];
        if (count($countNumbers) > 1) {
            foreach ($countNumbers as $number) {
                $fNum = preg_replace("/[^0-9]/", "", $number);
                if (strlen($fNum) > 10) {
                    continue;
                }
                $numbers[] = $fNum;
            }
            $this->to = implode(",", $numbers);
            //$this->type = isset($params['type']) ? $params['type'] : "Bulk";
        } else {
            $this->to = preg_replace("/[^0-9]/", "", $this->to);
            //$this->type = isset($params['type']) ? $params['type'] : "Individual";
        }

        $this->report = ['data' => ['mobile' => $this->to, 'message' => $this->message, 'sender' => $this->mask]];
        $this->sendData = ['mobile' => $this->to, 'message' => $this->message, 'username' => $this->user_name, 'password' => $this->password, 'sender' => $this->mask];
    }

    function checkEmpty($var, $key) {
        if (empty($var[$key])) {
            throw new NotFoundHttpException("Sms Class error: please define variable '$key''");
        } else {
            return $var[$key];
        }
    }

    public function send() {
        foreach ($this->sendData as $key => $val) {
            $this->sendsms .= $key . "=" . urlencode($val);
            $this->sendsms .= "&"; //append the ampersand (&) sign after each parameter/value
        }
        $this->sendsms = substr($this->sendsms, 0, strlen($this->sendsms) - 1); //remove last ampersand (&) sign from the sendsms
        $url = "http://smscgateway.com/messageapi.asp?" . $this->sendsms;
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->testMode) {
            $curl_scraped_page = "Sent Successfully";
            //\Yii::$app->session->setFlash('success', $this->message);
        } else {
            $curl_scraped_page = file_get_contents("$url");
            // $curl_scraped_page = curl_exec($ch);
        }

        $this->report['response'] = $curl_scraped_page;
        $this->response = $this->getResponse($curl_scraped_page);
        $this->report['status'] = $this->response['status'] ? "success" : "fail";
        $this->report['message'] = substr($this->response['message'], 0, 250);
        $this->report['ip'] = \Yii::$app->request->userIP;
        $this->report['article_id'] = $this->article_id;
        $this->report['data'] = Json::encode($this->report['data']);
        $report = new SmsReport();
        $report->attributes = $this->report;
        $report->save();
//        curl_close($ch);
        return $this->response;
    }

    public function getResponse($res) {
        if ($res) {
            if (strpos($res, "Sent Successfully")) {
                return ['status' => true, 'message' => 'Sms successfully Sent.'];
            } else {
                return ['status' => false, 'message' => $res];
            }
        }
        return ['status' => false, 'message' => 'No data received from sms gateway.'];
    }

    public static function replace(&$content, $find, $replace) {
        $content = str_replace("{{{$find}}}", $replace, $content);
    }

    /*     * **********Templates*********** */

    public static function submitted($data) {
        $model = $data['model'];
        if (trim($model->a_phone)) {
            $message = self::$templates['submitted'];
            self::replace($message, 'PAPER_ID', $model->paper_id);
            self::replace($message, 'NAME', substr($model->author_name, 0, 6));
            $sms = new PritSms(['to' => $model->a_phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

    public static function rejected($data) {
        $model = $data['model'];
        if (trim($model->a_phone)) {
            $message = self::$templates['rejected'];
            self::replace($message, 'PAPER_ID', $model->paper_id);
            self::replace($message, 'NAME', substr($model->author_name, 0, 6));
            $sms = new PritSms(['to' => $model->a_phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

    public static function accepted($data) {
        $model = $data['model'];
        if (trim($model->a_phone)) {
            $message = self::$templates['accepted'];
            self::replace($message, 'PAPER_ID', $model->paper_id);
            self::replace($message, 'NAME', substr($model->author_name, 0, 6));
            $sms = new PritSms(['to' => $model->a_phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

    public static function reminder($data) {
        $model = $data['model'];
        if (trim($model->a_phone)) {
            $message = self::$templates['reminder'];
            self::replace($message, 'PAPER_ID', $model->paper_id);
            self::replace($message, 'NAME', substr($model->author_name, 0, 6));
            $sms = new PritSms(['to' => $model->a_phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

    public static function published($data) {
        $model = $data['model'];
        if (trim($model->a_phone)) {
            $message = self::$templates['published'];
            self::replace($message, 'PAPER_ID', $model->paper_id);
            self::replace($message, 'VOLUME', sprintf("%02d", $model->voliss->volume));
            self::replace($message, 'ISSUE', sprintf("%02d", $model->voliss->issue));
            self::replace($message, 'NAME', substr($model->author_name, 0, 6));
            $sms = new PritSms(['to' => $model->a_phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }
    public static function confpublished($data) {
        $model = $data['model'];
        if (trim($model->a_phone)) {
            $message = self::$templates['confpublished'];
            self::replace($message, 'PAPER_ID', $model->paper_id);
            self::replace($message, 'NAME', substr($model->author_name, 0, 6));
            self::replace($message, 'CONFNO', substr($model->conf_id, 0, 6));
            $sms = new PritSms(['to' => $model->a_phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

    public static function review_reminder($data) {
        $model = $data['model'];
        if (trim($model->phone)) {
            $message = self::$templates['reviewreminder'];
            self::replace($message, 'NAME', substr($model->full_name, 0, 6));
            $sms = new PritSms(['to' => $model->phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

    public static function review_request($data) {
        $model = $data['model'];
        if (trim($model->phone)) {
            $message = self::$templates['reviewrequest'];
            self::replace($message, 'NAME', substr($model->full_name, 0, 6));
            $sms = new PritSms(['to' => $model->phone, 'message' => $message]);
            $sms->article_id = $model->id;
            return $sms->send();
        }
        return true;
    }

}
