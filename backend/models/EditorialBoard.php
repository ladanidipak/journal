<?php

namespace backend\models;

use backend\components\MYPDF;
use backend\components\PritWriteImage;
use backend\components\PritWriteImagick;
use Yii;
use backend\vendors\Common;

/**
 * This is the model class for table "editorial_board".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $qualification
 * @property string $designation
 * @property string $email
 * @property string $phone
 * @property string $institute_name
 * @property integer $branch_id
 * @property string $branch_name
 * @property string $specialization
 * @property string $address
 * @property string $city
 * @property string $country
 * @property string $state
 * @property string $cv
 * @property string $profile_pic
 * @property integer $status
 * @property integer $priority
 * @property integer $show_in_front
 * @property string $max_article
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $hide_in_list
 */
class EditorialBoard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $verifyCode;
    public $qualiDrop;
    public $qualiInput;
    public $desigDrop;
    public $desigInput;
    public $CertificateText;
    public static $statusArray = [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected'];
    public static $statusClass = [0 => 'default', 1 => 'primary', 2 => 'danger'];
    public static $maxArticleArray = ['Upto 5' => 'Upto 5', '5 to10' => '5 to10', '10 to 15' => '10 to 15'];
    public static function tableName()
    {
        return 'editorial_board';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'qualification', 'designation', 'email', 'phone', 'institute_name', 'country', 'state', 'branch_id'], 'required'],
            ['branch_name', 'required', 'whenClient' => "function (attribute, value) {return $('#editorial_board-branch_id option:selected').text() == 'Other';}", 'when' => function ($model) {
                return false;
            }],
            [['email'], 'email'],
            //['email', 'unique', 'targetAttribute' => 'email'],
            [['desigDrop', 'qualiDrop'], 'required', 'on' => ['back_create', 'create', 'update']],
            ['desigInput', 'required', 'when' => function ($model) {
                return $model->desigDrop == 'Other';
            }, 'whenClient' => "function (attribute, value) {return $('#editorialboard-desigdrop').val() == 'Other';}"],
            [['status', 'created_dt', 'created_by', 'updated_dt', 'updated_by', 'is_deleted', 'priority', 'show_in_front', 'branch_id', 'hide_in_list', 'show_in_reviewer', 'show_in_editor'], 'integer'],
            [['max_article'], 'string', 'max' => 50],
            [['full_name', 'qualification', 'designation', 'email', 'country', 'state'], 'string', 'max' => 100],
            [['cv'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, pdf', 'maxSize' => 1024 * 1024 * 5, 'on' => ['back_create', 'create']],
            [['cv'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, pdf', 'maxSize' => 1024 * 1024 * 5, 'on' => 'update'],
            [['profile_pic'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png, svg', 'maxSize' => 1024 * 1024 * 5, 'on' => ['back_create', 'create']],
            [['profile_pic'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png, svg', 'maxSize' => 1024 * 1024 * 5, 'on' => 'update'],
            [['phone'], 'string', 'max' => 10],
            [['institute_name'], 'string', 'max' => 150],
            [['note', 'specialization', 'address'], 'string', 'max' => 255],
            [['branch_name'], 'string', 'max' => 100],
            [['city'], 'string', 'max' => 50],
            ['verifyCode', 'required', 'on' => "create"],
            ['verifyCode', 'captcha', 'captchaAction' => 'page/captcha', 'on' => "create"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'qualiDrop' => 'Qualification',
            'qualification' => 'Qualification',
            'designation' => 'Designation',
            'branch_id' => 'Branch',
            'email' => 'Email',
            'phone' => 'Phone',
            'institute_name' => 'Institute Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'cv' => 'CV',
            'status' => 'Status',
            'priority' => 'Priority',
            'show_in_front' => 'Show In Front',
            'max_article' => 'Maximum Article to Send',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
            'desigDrop'  => 'Designation',
            'desigInput'  => 'Designation (Other)',
            'hide_in_list'  => 'Hide in Listing',
        ];
    }
    public function beforeSave($insert)
    {
        $loggedIn = \Yii::$app->user->isGuest;
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::datetimeTimestamp();
            $this->updated_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            if ($insert) {
                $this->created_dt = Common::datetimeTimestamp();
                $this->created_by = ($loggedIn) ? 0 : Yii::$app->user->identity->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function generateCertificates($reviewer, $url = false, $certificateText = '')
    {
        $name = $reviewer->full_name;
        $root_path = DOCPATH . "/uploads/reviewer_certi/";
        $rool_url = DOCURL . "uploads/reviewer_certi/";
        $file_path = $root_path . "{$reviewer->id}";
        if (is_dir($file_path)) {
            Common::removeDir($file_path);
            @unlink($file_path . ".zip");
        }
        $reviewer_id = sprintf("GRDRW%04d", $reviewer->id);
        Common::checkAndCreateDirectory($file_path);
        $count = 1;
        $textArray = [
            //['name' => 'ISSN [ONLINE] : 2455 - 5703', 'x' => 4400, 'y' => 460, 'font_size' => 55, 'font' => DOCPATH . '/uploads/certificate/times_bold.ttf'],
            ['name' => $reviewer_id, 'x' => 4400, 'y' => 700, 'font_size' => 195, 'font' => DOCPATH . '/uploads/certificate/barcode.ttf'],
            ['name' => $name, 'x' => 2800, 'y' => 1850, 'font_size' => 110, 'font' => DOCPATH . '/uploads/certificate/times_bold.ttf'],
            ['name' => $certificateText, 'x' => 2800, 'y' => 2300, 'font_size' => 105, 'font' => DOCPATH . '/uploads/certificate/times_bold_italic.ttf'],
            ['name' => date("d/m/Y"), 'x' => 4150, 'y' => 2820, 'font_size' => 105, 'font' => DOCPATH . '/uploads/certificate/times.ttf']
        ];
        //reviewer_feb_2_remove
        $data = [
            'inputPath' => DOCPATH . "/uploads/certificate/reviewer_certificate.jpg", 'outputPath' => $file_path . "/" . Common::clean($name) . ".jpg",
            'text' => $textArray
        ];
        $image = new PritWriteImagick($data);
        $image->create_image();
        /*$fpath = $rool_url."{$reviewer->id}/".Common::clean($name).".jpg";
        echo "<img src='$fpath'>";exit;*/

        Common::directoryToZip($root_path . "{$reviewer->id}/certificates.zip", $file_path);
        if ($url) {
            return $rool_url . "{$reviewer->id}/certificates.zip";
        } else {
            return $root_path . "{$reviewer->id}/certificates.zip";
        }
    }

    public static function generateReviewReportPdf($article, $output = 'F')
    {

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


        /*
        require_once(dirname(__FILE__).'/../components/tcpdf/tcpdf.php');
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);*/
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('GRD Journals');
        $pdf->SetTitle('GRD Journals: Reviewer\'s Report');
        $pdf->SetSubject('GRD Journals');
        $pdf->SetKeywords('GRD Journals, Reviewer\'s Report');

        //echo PDF_HEADER_LOGO_WIDTH;exit;
        $pdf->SetHeaderData("logo.png", 30, "Global Research and Development Journal for Engineering (GRDJE)", "ISSN (online): 2455-5703", array(51, 173, 255), array(255, 255, 255));
        //$headerHtml = "<table><tr><td><img src='".K_PATH_IMAGES."logo.png'></td><td>test</td></tr></table>";
        //$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs=$headerHtml, $tc=array(0,0,0), $lc=array(0,0,0));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $l = array();
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
        $html  = \Yii::$app->view->renderFile('@frontend/views/open/review_report_pdf.php', ['article' => $article]);
        $pdf->writeHTML($html, true, false, false, false, '');
        if ($output === 'F') {
            $filepath = $article->file_path;
            $file_name = DOCPATH . "/uploads/article/{$filepath}{$article->paper_id}_reviewer_report.pdf";
            $pdf->Output($file_name, 'F');
            chmod($file_name, 0777);
            return $file_name;
        } else {
            $file_name = "{$article->paper_id}_reviewer_report.pdf";
            $pdf->Output($file_name, 'D');
        }
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public function getLastReviewedDate()
    {
        return ArticleReview::find()->select('reviewed_date')->where(['reviewer_id' => $this->id])->limit(1)->orderBy('reviewed_date DESC')->scalar();
    }

    public function getReviewsPending()
    {
        return ArticleReview::find()->where(['reviewer_id' => $this->id, 'reviewed_date' => null])->count();
    }

    public function getArticleReviewedInMonth()
    {
        $start_date = date('Y-m-01 00:00:00');
        $end_date = date('Y-m-t  23:59:59');
        return ArticleReview::find()->where(['and', ['reviewer_id' => $this->id], ['between', 'reviewed_date', $start_date, $end_date]])->count();
    }

    public static function getListWithInfo()
    {
        $reviewers = self::find()->where(['priority' => 1, 'status' => 1, 'is_deleted' => 0])->all();
        $reviewers = \yii\helpers\ArrayHelper::map(
            $reviewers,
            'id',
            function ($data) {
                $branch = $spec = $note = "";
                if ($data->branch_id != 13 && $data->branch_id != 0) {
                    $branch = "(Branch : {$data->branch->name})";
                } elseif (!empty($data->branch_name)) {
                    $branch = " (Branch : {$data->branch_name})";
                }
                if ($data->specialization) {
                    $spec = " (Specialization : {$data->specialization})";
                }
                if ($data->note) {
                    $note = " (Note : {$data->note})";
                }
                //return $data->full_name. $branch . $spec . $note;
                return "<b>$data->full_name</b> <i>$branch $spec $note</i>";
            }
        );
        return $reviewers;
    }
}
