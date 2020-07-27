<?php

/**
 * This script is developed by Alpesh Vaghela to send mail from system
 * @name 	SendMail.php
 * @uses	mail send  function class
 * @package vendors
 * @author 	Alpesh Vaghela
 * @since 	23-05-2013
 */
class SendMail {

    public $DRAFT_ID	    = ""; //Template id
    public $SUBJECT	    = "";
    public $FROM	    = "";
    public $REPLYTO	    = "";
    public $EMAILTO	    = "";
    public $HEADER	    = "";
    public $EMAILBODY	    = "";
    public $EMAIL_KEYWORD   = "";
    public $EMAIL_LOG_ID    = 0;
    public $UN_SUBSCRIBE_LINK	    = "";
    public $SEND_EMAIL_MASTER_USER  = true;
    public $RECIPIENT		    = array();
    public $TAG_ARRAY		    = array();
    public $TAG_FIND		    = array();
    public $ATTACHMENT		    = array();
    public $EMAIL_CC		    = array();
    public $EMAIL_BCC		    = array();

    /**
     * Function Name : MailSend
     * @author 	Alpesh Vaghela
     * @since 	23-05-2013
     */
    public function MailSend() {
	if ($this->DRAFT_ID > 0) {
	    $Draft_Details = EmailMaster::model()->findByPk($this->DRAFT_ID);
	    $EMAIL_STATIONARY = "";

	    if ($this->FROM == "") {
		preg_match("/(.*)<(.*)>/", $Draft_Details->email_from, $array);
		if (isset($array[1]) && isset($array[2])) {
		    $this->FROM = array($array[2] => $array[1]);
		} else {
		    $this->FROM = $Draft_Details->email_from;
		}
	    }

	    /** IF SUBJECT IS NOT PROVIDED TAKE FROM EMAIL TEMPLATE */
	    if ($this->SUBJECT == "") {
		$this->SUBJECT = $Draft_Details->subject;
	    }
	    /** IF SUBJECT IS NOT PROVIDED TAKE FROM EMAIL TEMPLATE */
	    /** GET EMAIL BODY */
	    if ($this->EMAILBODY == "") {
		$this->EMAILBODY = $Draft_Details->content;
	    }
	    /** GET EMAIL BODY */
	    /** FIND AND REPLACE TAGS */
	    if (count($this->TAG_ARRAY) > 0) {
		$Tag_Find = array_keys($this->TAG_ARRAY);
		$Tag_Find[] = "[PROFILE_EMAIL_STATIONARY]";
		$Tag_Replace = array();
		foreach ($this->TAG_ARRAY as $Replace) {
		    $Tag_Replace[] = $Replace;
		}
		$Tag_Replace[] = $EMAIL_STATIONARY;
		$this->EMAILBODY = str_replace($Tag_Find, $Tag_Replace, $this->EMAILBODY);
		$this->SUBJECT = str_replace($Tag_Find, $Tag_Replace, $this->SUBJECT);
	    }
	    /** FIND AND REPLACE TAGS */
	    /** SEND EMAIL */
	    $message = new YiiMailMessage;
	    $message->subject = $this->SUBJECT;

	    if (!empty($this->FROM) && is_array($this->FROM)) {
		$message->setFrom($this->FROM);
	    } else {
		preg_match("/(.*)<(.*)>/", $this->FROM, $array);
		if (isset($array[1]) && isset($array[2])) {
		    $message->setFrom(array($array[2] => $array[1]));
		} else {
		    $message->from = $this->FROM;
		}
	    }
	    $message->setBody($this->EMAILBODY, 'text/html', 'utf-8');

	    if (count($this->RECIPIENT) > 0) {
		$message->addTo($this->EMAILTO . "," . join(",", $this->RECIPIENT));
	    } else {
		$message->addTo($this->EMAILTO);
	    }
	    if (count($this->EMAIL_BCC) > 0) {
		$message->addBcc(join(",", $this->EMAIL_BCC));
	    }
	    if (count($this->ATTACHMENT) > 0) {
		foreach ($this->ATTACHMENT as $Attachement_Array) {
		    if (isset($Attachement_Array['filepath']) && $Attachement_Array['filename'] && $Attachement_Array['mimetype'] && file_exists($Attachement_Array['filepath'])) {
			$message->attach(Swift_Attachment::fromPath($Attachement_Array['filepath'] . $Attachement_Array['filename']));
		    }
		}
	    }
	    $this->SaveEmailLog();
	}
    }

    /**
     * Function Name : SaveEmailLog
     * @author 	Alpesh Vaghela
     * @since 	23-05-2013
     */
    public function SaveEmailLog($is_send = 0) {
	if (is_array($this->FROM)) {
	    $this->FROM = key($this->FROM);
	}
	$modelMailArchive		    = New EmailArchive;
	$modelMailArchive->from_email	    = $this->FROM;
	$modelMailArchive->to_email	    = $this->EMAILTO;
	$modelMailArchive->cc_email	    = !empty($this->EMAIL_CC)?$this->EMAIL_CC:"";
	$modelMailArchive->bcc_email	    = !empty($this->EMAIL_BCC)?$this->EMAIL_BCC:"";
	$modelMailArchive->subject	    = $this->SUBJECT;
	$modelMailArchive->email_id	    = $this->DRAFT_ID;
	$modelMailArchive->email_contents   = $this->EMAILBODY;
	$modelMailArchive->attachement	    = serialize($this->ATTACHMENT);
	$modelMailArchive->is_send	    = $is_send;
	$modelMailArchive->created_dt	    = common::getTimeStamp("", "Y-m-d H:i:s"); // With Date and time
	$modelMailArchive->created_by	    = 1;
	$modelMailArchive->save();
    }

    /**
     * Function Name : MailSendFromCron
     * @author 	Alpesh Vaghela
     * @since 	30-09-2013
     */
    public function MailSendFromCron() {
	if (!empty($this->EMAIL_LOG_ID)) {
	    $emailLogModel	= EmailArchive::model()->findByPk($this->EMAIL_LOG_ID);
	    $this->FROM		= $emailLogModel->from_email;
	    $this->EMAILTO	= $emailLogModel->to_email;
	    $this->EMAIL_CC	= !empty($emailLogModel->cc_email)?$emailLogModel->cc_email:"";
	    $this->EMAIL_BCC	= !empty($emailLogModel->bcc_email)?$emailLogModel->bcc_email:"";
	    $this->SUBJECT	= $emailLogModel->subject;
	    $this->EMAILBODY	= $emailLogModel->email_contents;
	    $this->ATTACHMENT	= !empty($emailLogModel->attachement) ? unserialize($emailLogModel->attachement) : "";

	    $message = new YiiMailMessage;
	    $message->subject = $this->SUBJECT;

	    if (!empty($this->FROM) && is_array($this->FROM)) {
		$message->setFrom($this->FROM);
	    } else {
		preg_match("/(.*)<(.*)>/", $this->FROM, $array);
		if (isset($array[1]) && isset($array[2])) {
		    $message->setFrom(array($array[2] => $array[1]));
		} else {
		    $message->from = $this->FROM;
		}
	    }
	    $message->setBody($this->EMAILBODY, 'text/html', 'utf-8');
	    $message->addTo($this->EMAILTO);

	    if(!empty($this->EMAIL_CC)){
		$message->addCC($this->EMAIL_CC);
	    }
	    if(!empty($this->EMAIL_BCC)){
		$message->addBCC($this->EMAIL_BCC);
	    }

	    if (!empty($this->ATTACHMENT)) {
		foreach ($this->ATTACHMENT as $Attachement_Array) {
		    if (isset($Attachement_Array['filepath']) && $Attachement_Array['filename'] && $Attachement_Array['mimetype'] && file_exists($Attachement_Array['filepath'])) {
			$message->attach(Swift_Attachment::fromPath($Attachement_Array['filepath'] . $Attachement_Array['filename']));
		    }
		}
	    }
	    //echo $this->EMAILTO."---".$this->EMAIL_CC."---".$this->EMAIL_BCC; exit;
	    //echo "<pre>"; print_r($message);exit;
	    if (Yii::app()->mail->send($message)) {
		$emailLogModel->is_send = 1;
		$emailLogModel->update();
	    }
	}
    }

}