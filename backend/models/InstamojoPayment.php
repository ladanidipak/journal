<?php

namespace backend\models;

use backend\components\MYPDF;
use Yii;
use backend\vendors\Common;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "instamojo_payment".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $r_amount
 * @property string $payment_request_id
 * @property string $r_purpose
 * @property string $r_created_at
 * @property string $r_modified_at
 * @property string $payment_id
 * @property string $w_amount_recieved
 * @property string $w_buyer_name
 * @property string $w_buyer_phone
 * @property string $w_currency
 * @property string $w_fees
 * @property string $w_mac
 * @property string $w_status
 * @property string $created_dt
 * @property integer $created_by
 * @property string $updated_dt
 * @property integer $updated_by
 * @property string $request_log
 * @property string $redirect_log
 * @property string $webhook_log
 * @property integer $is_deleted
 */
class InstamojoPayment extends \yii\db\ActiveRecord
{

    public $item_list;
    public $additional;
    public $additional_amount;
    public $additional_desc;
    public static $items = [
        'manuscript'=>['price'=>'1200','description'=>'Standard manuscript charges <b>1200</b> (mendatory)'],
        'hard_copy'=>['price'=>'250','description'=>'Hardcopy of certificates <b>250</b>'],
        'plagiarism_report'=>['price'=>'150','description'=>'plagiarism report <b>150</b>'],
    ];
	public static $percentageCharges = "2.5";
	public static $staticCharges = "3";

    public static $progressArray = [0=>"Started", 2=>"Completed", 3=>"Verified"];

    public static function getPaymentItems(){
        return  self::$items;
    }

    public static function getSelectionItem(){
        $items = self::$items;
        unset($items['manuscript']);
        $data = [];
        foreach($items as $k => $v){
            $data[$k] = $v['description'];
        }
        return $data;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instamojo_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id', 'created_by', 'updated_by', 'is_deleted','progress_status'], 'integer'],
            [['r_amount', 'w_amount_recieved','additional_amount', 'w_fees'], 'number', 'min'=>1],
            [['created_dt', 'updated_dt','item_list', 'r_amount', 'payment_request_id', 'r_purpose', 'r_created_at', 'r_modified_at', 'payment_id', 'w_amount_recieved',
                'w_buyer_name', 'w_buyer_phone', 'w_currency', 'w_fees', 'w_mac', 'w_status', 'request_log', 'redirect_log', 'webhook_log','additional'], 'safe'],
            [['request_log', 'redirect_log', 'webhook_log'], 'string'],
            [['payment_request_id','additional_desc'], 'string', 'max' => 256],
            [['r_purpose', 'payment_id'], 'string', 'max' => 100],
            [['r_created_at', 'r_modified_at'], 'string', 'max' => 30],
            [['w_buyer_name'], 'string', 'max' => 25],
            [['w_buyer_phone'], 'string', 'max' => 15],
            [['w_currency', 'w_status'], 'string', 'max' => 10],
            [['w_mac'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'r_amount' => 'Requested Amount',
            'payment_request_id' => 'Payment Request ID',
            'r_purpose' => 'Requested Purpose',
            'r_created_at' => 'Requested Created At',
            'r_modified_at' => 'Requested Modified At',
            'payment_id' => 'Payment ID',
            'w_amount_recieved' => 'Web-hook Amount Recieved',
            'w_buyer_name' => 'Web-hook Buyer Name',
            'w_buyer_phone' => 'Web-hook Buyer Phone',
            'w_currency' => 'Web-hook Currency',
            'w_fees' => 'Web-hook Fees',
            'w_mac' => 'Web-hook Mac',
            'w_status' => 'Web-hook Status',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'request_log' => 'Request Log',
            'redirect_log' => 'Redirect Log',
            'webhook_log' => 'Web-hook Log',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function beforeSave($insert) {
        $loggedIn = \Yii::$app->user->isGuest;
        if (parent::beforeSave($insert)) {
            $this->updated_dt = date('Y-m-d H:i:s');
            $this->updated_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            if ($insert) {
                $this->created_dt = date('Y-m-d H:i:s');
                $this->created_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getArticle(){
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    public function getItems(){
        return $this->hasMany(PurchaseItems::className(), ['insta_pay_id' => 'id']);
    }


    public static function generatePaymentreport($instamojo,$output = 'F'){

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        /*
        require_once(dirname(__FILE__).'/../components/tcpdf/tcpdf.php');
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);*/
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('GRD Journals');
        $pdf->SetTitle('GRD Journals: Payment\'s Report');
        $pdf->SetSubject('GRD Journals');
        $pdf->SetKeywords('GRD Journals, Payment\'s Report');

        //echo PDF_HEADER_LOGO_WIDTH;exit;
        $pdf->SetHeaderData("logo.png", 30, "Global Research and Development Journal for Engineering (GRDJE)", "ISSN (online): 2455-5703",array(51, 173, 255),array(255,255,255));
        //$headerHtml = "<table><tr><td><img src='".K_PATH_IMAGES."logo.png'></td><td>test</td></tr></table>";
        //$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs=$headerHtml, $tc=array(0,0,0), $lc=array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $l = Array();
        $l['a_meta_charset'] = 'UTF-8';
        $l['a_meta_dir'] = 'ltr';
        $l['a_meta_language'] = 'en';
        $l['w_page'] = 'page';
        $pdf->setLanguageArray($l);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->AddPage();
        $pdf->Write(0, "Review Report", '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetLineStyle(array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(115, 115, 115)));
        //$pdf->Write(0, "Title: $article->article_title", '', 0, 'L', true, 0, false, false, 0);
        $pdf->SetFont('helvetica', '', 8);
        $article = $instamojo->article;
        $itemsObj = $instamojo->items;
        if($itemsObj){
            $items = ArrayHelper::map($itemsObj,'item_code','id');
        }else{
            $items = [];
        }
        if(isset($items['additional'])){
            $additional = PurchaseItems::findOne($items['additional']);
        }else{
            $additional = [];
        }

        $html  = \Yii::$app->view->renderFile('@frontend/views/open/payment_report.php',['instamojo'=>$instamojo, 'article'=>$article, 'items'=>$items, 'additional'=>$additional]);
        $pdf->writeHTML($html, true, false, false, false, '');

        if($output === 'F'){
            if($article->conf_id != 0){
                $fileDir = "conference";
            }else{
                $fileDir = "article";
            }
            $filepath = $article->file_path;
            $file_name = DOCPATH."/uploads/{$fileDir}/{$filepath}{$article->paper_id}_payment_report.pdf";
            $article->payment_file ="{$filepath}{$article->paper_id}_payment_report.pdf";
            if($instamojo->w_status == "Credit" ){
                $article->paid_online = 1;
            }
            $article->update(false);
            $pdf->Output($file_name, 'F');

            chmod($file_name,0777);
            return $file_name;
        }else{
            $file_name = "{$article->paper_id}_reviewer_report.pdf";
            $pdf->Output($file_name, 'D');
        }

    }
}
