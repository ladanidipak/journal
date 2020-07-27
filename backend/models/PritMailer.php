<?php
/**
 * User: pritesh
 * Date: 2/12/15
 * Time: 10:23 PM
 */

namespace backend\models;


use yii\web\View;
use Yii;

class PritMailer
{
    public static function replace(&$content,$find,$replace){
        $content =  str_replace("{{{$find}}}",$replace,$content);
    }

    public static function subject($subject, $prepend = "", $branding = "GRD journals: "){
        return $branding . $prepend . $subject;
    }

    /**
     * @param $data
     * $data[
     *  'from' => mail from
     *  'to => mail to
     *  'subject' => mail subject
     *  'body' => mail body
     *  'attachment' => file path if any mail attachment
     * ]
     * @return bool True OR false
     *
     */
    public static function mailer($data){
        if(is_array($data['from'])){
            $from = $data['from'];
        }else{
            $from = [$data['from']=>'GRD Journals'];
        }
        if(!empty($data['to'])){
            $message = Yii::$app->mailer->compose()
                ->setFrom($from)
                ->setTo($data['to'])
                ->setSubject($data['subject'])
                ->setHtmlBody($data['body']);
            if(isset($data['attachment'])){
                if(is_array($data['attachment'])){
                    $message->attach($data['attachment']['fileName'],$data['attachment']['options']);
                } else {
                    $message->attach($data['attachment']);
                }
            }
            return $message->send();
        }else{
            return true;
        }
    }

    /**
     * This is sample for sending mail.
     * Remove comments added when you copy this function.
     * $data['model'] => required data to be used in sending mail.
     * This can be multiple like $data = ['model'=>$model,'user'=>$user];
     * Find your mail template using UNIQUE keyword. Create one if none.
     * add 'attachment' => 'file_path' to array if you want to send attachemnt.
     * Replace {{dynamic_data}} with appropriate value.
     */
    /*public static function inquiryReplyToCustomer($data){
        $model = $data['model'];
        $template = EmailTemplate::findMailByKeyword("INQUIRY_REPLIED");
        $subject = $template->subject;
        $body = $template->content;

        self::replace($subject,'SENDER_NAME',"WOWmyevent");
        self::replace($body,'RECEIVER_NAME',$model->inquiry->name);

        $mailData = ['from'=>$template->email_from, 'to'=>$model->inquiry->email, 'subject'=>$subject,'body'=>$body];
        return self::mailer($mailData);
    }*/


    public static function submitArticle($data){
        //'@backend/views/mail/payment_uploaded'
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/article_submit',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['coa'] as $coa){
            if($coa->email)
            $to[] = $coa->email;
        }*/
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Submission‏',"{$data['model']->paper_id} - "),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function articleAccepted($data){

        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/article_accepted',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['model']->coauthors as $coa){
            if($coa->email)
                $to[] = $coa->email;
        }*/
        $data['pdf'] = EditorialBoard::generateReviewReportPdf($data['model']);
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Accepted‏',"{$data['model']->paper_id} - "),'body'=>$body, 'attachment'=>$data['pdf']];
        return self::mailer($mailData);
    }

    public static function articleReminder($data){

        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/article_reminder',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['model']->coauthors as $coa){
            if($coa->email)
                $to[] = $coa->email;
        }*/
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Reminder',"{$data['model']->paper_id} - "),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function articleRejected($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/article_rejected',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['model']->coauthors as $coa){
            if($coa->email)
                $to[] = $coa->email;
        }*/
        $data['pdf'] = EditorialBoard::generateReviewReportPdf($data['model']);
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Rejection Letter',"{$data['model']->paper_id} - "),'body'=>$body, 'attachment'=>$data['pdf']];
        return self::mailer($mailData);
    }

    public static function paymentReceived($data){

        //Mail to GRD
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/payment_uploaded',$data);
        $to = [];
        $to[] = Yii::$app->params['paymentEmail'];
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('A New Payment Uploaded',Yii::$app->params['paymentEmail']." - "),'body'=>$body];
        $grd =  self::mailer($mailData);

        // Mail to author
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/payment_received',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['model']->coauthors as $coa){
            if($coa->email)
                $to[] = $coa->email;
        }*/
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Payment Received',"{$data['model']->paper_id} - "),'body'=>$body];
        return self::mailer($mailData);
    }
    
    public static function contactus($model){

        //Mail to GRD
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/contactus',$model);
        $to = [];
        $to[] = Yii::$app->params['fromEmail'];
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('A New Contact Request',''),'body'=>$body];
        return self::mailer($mailData);
    }
    public static function confproposal($model){

        //Mail to GRD
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/confproposal',$model);
        $to = [];
        $to[] = Yii::$app->params['fromEmail'];
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('A New Conference proposal',''),'body'=>$body];
        return self::mailer($mailData);
    }


    public static function paymentAccepted($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/payment_accepted',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['model']->coauthors as $coa){
            if($coa->email)
                $to[] = $coa->email;
        }*/
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Certificate',"{$data['model']->paper_id} - ")
            ,'body'=>$body, 'attachment'=>$data['zip']];
        return self::mailer($mailData);
    }

    public static function sendConfCerti($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/send_conf_certi',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Certificate',"{$data['model']->paper_id} - ")
            ,'body'=>$body, 'attachment'=>$data['zip']];
        return self::mailer($mailData);
    }

    public static function articlePublished($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/article_published',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        /*foreach($data['model']->coauthors as $coa){
            if($coa->email)
                $to[] = $coa->email;
        }*/
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Published',"{$data['model']->paper_id} - "),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function reviewerApproved($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/reviewer_approved',$data);
        $to = [];
        $to[] = $data['model']->email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Confirmation Letter'),'body'=>$body, 'attachment'=>$data['zip']];
        return self::mailer($mailData);
    }

    public static function reviewerRejected($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/reviewer_rejected',$data);
        $to = [];
        $to[] = $data['model']->email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Reviewer Status'),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function requestReview($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/review_request',$data);
        $to = [];
        $to[] = $data['reviewer']->email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject("Request to review - {$data['article']->article_title}"),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function sendToReview($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/send_to_reviewer',$data);
        $to = [];
        $to[] = $data['reviewer']->email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject("Review - {$data['article']->article_title}"),'body'=>$body, 'attachment'=>$data['file']];
        return self::mailer($mailData);
    }

    public static function sendToFormatter($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@app/views/mail/send_to_formatter',$data);
        $to = [];
        $to[] = $data['formatter']->email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject("Format Paper - {$data['article']->article_title}"),'body'=>$body, 'attachment'=>$data['file']];
        return self::mailer($mailData);
    }

    public static function dispatchEmail($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/hardcopy_dispatch',$data);
        $to = [];
        $to[] = $data['article']->a_email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('certificate dispatch detail',"{$data['article']->paper_id} - "),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function arCertificate($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/review_certificate',$data);
        $to = [];
        $to[] = $data['model']->email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Certificate for your review on article'),'body'=>$body, 'attachment'=>$data['zip']];
        return self::mailer($mailData);
    }

    public static function marketingEmail($data){
        $body = $data['body'];
        $to = [];
        $to[] = $data['email'];
        $mailData = ['from'=>[$data['from_email']=>$data['from_name']], 'to'=>$to, 'subject'=>$data['subject'],'body'=>$body];
        return self::mailer($mailData);
    }

    public static function plagiarismRejected($data){
        $body = \Yii::createObject(['class'=>View::className()])->render('@backend/views/mail/plagiarism_rejected',$data);
        $to = [];
        $to[] = $data['model']->a_email;
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>self::subject('Article Rejection Letter',"{$data['model']->paper_id} - "),'body'=>$body];
        return self::mailer($mailData);
    }

    public static function authorMail($data){
        $body = $data['body'];
        $subject = $data['subject'];
        $to = [];
        $to[] = $data['email'];
        $mailData = ['from'=>\Yii::$app->params['fromEmail'], 'to'=>$to, 'subject'=>$subject,'body'=>$body];
        return self::mailer($mailData);
    }
}