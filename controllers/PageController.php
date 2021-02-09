<?php

namespace app\controllers;

use backend\models\Article;
use backend\models\Conference;
use backend\models\ConfPro;
use backend\models\ContactUs;
use backend\models\EditorialBoard;
use backend\models\InstamojoPayment;
use backend\models\PritMailer;
use backend\models\Published;
use backend\models\PurchaseItems;
use backend\models\search\ArticleSearch;
use backend\models\search\PublishedSearch;
use backend\models\VolIss;
use Instamojo\Instamojo;
use Yii;
//use app\models\Cms;
//use app\models\search\CmsSearch;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use yii\base\Model;
use \backend\models\Cms;
use yii\web\UploadedFile;

/**
 * CmsController implements the CRUD actions for Cms model.
 */
class PageController extends BaseController
{

    /**
     * Lists all Cms models.
     * @return mixed
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'height' => 70,
                'width' => 200,
            ],
        ];
    }

    public function actionIndex()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $this->sliderVisible = true;
        return $this->render('index', ['content' => $content]);
    }

    public function actionAuthorguideline()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('authorguideline', ['content' => $content]);
    }

    public function actionPaperformat()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('paperformat', ['content' => $content]);
    }

    public function actionPayment()
    {
        $this->redirect(['getpaydetail']);
    }

    public function actionGetpaydetail()
    {
        $model = new \backend\models\Article();
        $model->scenario = 'getpaydetail';
        if ($model->load(\Yii::$app->request->post())) {
            $article = \backend\models\Article::findOne(['paper_id' => $model->paper_id, 'a_email' => $model->a_email, 'is_deleted' => 0]);
            if ($article) {
                if (!in_array($article->status, [5, 7])) {
                    if ($article->status < 5) {
                        Yii::$app->session->setFlash('danger', "Your paper is still under review. We will mail you once it is accepted.");
                    } else {
                        Yii::$app->session->setFlash('danger', "Copyright and Payment already uploaded and accepted.<br>If you want to update it then send new documents to info@grdjournals.com with paper id mentioned in email.");
                    }
                    return $this->refresh();
                }
                Yii::$app->session->open();
                $_SESSION['get_pay_detail'] = [];
                $_SESSION['get_pay_detail']['paper_id'] = $article->paper_id;
                $_SESSION['get_pay_detail']['a_email'] = $article->a_email;
                $_SESSION['get_pay_detail']['id'] = $article->id;

                return $this->redirect(['choosepay']);
            } else {
                Yii::$app->session->setFlash('danger', "Paper id or Email is not valid. Please enter valid Email and Paper Id.");
            }
        }
        return $this->render('getpaydetail', ['model' => $model]);
    }

    public function actionChoosepay()
    {
        Yii::$app->session->open();
        if (!empty($_SESSION['get_pay_detail'])) {
            $pay_detail = $_SESSION['get_pay_detail'];
            $article = Article::findOne($pay_detail['id']);
            //$insta = InstamojoPayment::findOne(['article_id'=>$article->id, 'progress_status'=>3, 'w_status'=>'Credit', 'is_deleted'=>0]);
            if ($article->paid_online == 1) {
                if (!empty($article->copyright_file) && $article->status == 7) {
                    Yii::$app->session->setFlash('success', "You have already paid online and uploaded copyright. You can still upload updated copyright if you want.");
                } else {
                    Yii::$app->session->setFlash('success', "You have already paid online. Just upload copyright now.");
                }

                return $this->redirect(['uploadcopyright']);
            } elseif ($article->status == 7) {
                Yii::$app->session->setFlash('success', "You have already uploaded copyright and payment. However you can update it.");
                return $this->redirect(['uploadpay']);
            }
            return $this->render('choosepay', ['model' => $article]);
        } else {
            return $this->redirect(['getpaydetail']);
        }
    }

    public function actionUploadcopyright()
    {
        Yii::$app->session->open();
        if (!empty($_SESSION['get_pay_detail'])) {
            $pay_detail = $_SESSION['get_pay_detail'];
            $article = Article::findOne($pay_detail['id']);
            if ($article->paid_online != 1) {
                return $this->redirect(['uploadpay']);
            }
        } else {
            return $this->redirect(['getpaydetail']);
        }
        $model = new \backend\models\Article();
        $model->scenario = 'copyright_only';
        if ($model->load(\Yii::$app->request->post())) {
            //verify captcha
            if ($article) {
                if (!in_array($article->status, [5, 7])) {
                    if ($article->status < 5) {
                        Yii::$app->session->setFlash('danger', "Your paper is still under review. We will mail you once it accepted.");
                    } else {
                        Yii::$app->session->setFlash('danger', "Copyright and Payment already uploaded and accepted.<br>If you want to update it then send new documents to info@grdjournals.com with paper id mentioned in email.");
                    }

                    return $this->refresh();
                }
                if ($article->conf_id != 0) {
                    $fileDir = "conference";
                } else {
                    $fileDir = "article";
                }
                $article->status = 7;
                $filepath = $article->file_path;

                //Upload Copyright Form
                $article->copyright_file = \yii\web\UploadedFile::getInstance($article, 'copyright_file');
                $article->copyright_file->name = $filepath . "{$article->paper_id}_copyright_file_" . time() . "." . $article->copyright_file->extension;
                $copyright = $article->copyright_file->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $article->copyright_file->baseName . '.' . $article->copyright_file->extension);

                //Mail to GRD
                $message = PritMailer::paymentReceived(['model' => $article]);

                if ($copyright && $article->update()) {
                    Yii::$app->session->setFlash('success', "Copyright Successfully Uploaded.");
                    return $this->redirect(['getpaydetail']);
                }
            } else {
                Yii::$app->session->setFlash('danger', "Paper id or Email is not valid. Please enter valid Email and Paper Id.");
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('uploadcopyright', ['model' => $model]);
        } else {
            return $this->render('uploadcopyright', ['model' => $model]);
        }
    }

    public function actionPayonline()
    {
        Yii::$app->session->open();
        if (!empty($_SESSION['get_pay_detail'])) {
            $pay_detail = $_SESSION['get_pay_detail'];
            $article = Article::findOne($pay_detail['id']);
            if ($article->paid_online == 1) {
                Yii::$app->session->setFlash('success', "You have already paid online. Just upload copyright now.");
                return $this->redirect(['uploadcopyright']);
            }
        } else {
            return $this->redirect(['getpaydetail']);
        }


        $instamojo = new InstamojoPayment();
        $instamojo->article_id = $article->id;
        $items = $instamojo::$items;
        $perceCharges = $instamojo::$percentageCharges;
        $staCharge = $instamojo::$staticCharges;

        if ($instamojo->load(Yii::$app->request->post()) && $instamojo->validate()) {
            $post = [];
            $p_items = [];
            $p_items['manuscript'] = $items['manuscript'];
            $instamojo->article_id = $article->id;
            $instamojo->save();

            if ($instamojo->item_list) {
                foreach ($instamojo->item_list as $val) {
                    if (isset($items[$val])) {
                        $p_items[$val] = $items[$val];
                    }
                }
            }


            if ($instamojo->additional && !empty($instamojo->additional_amount)) {
                $p_items['additional'] = ['price' => $instamojo->additional_amount, 'description' => $instamojo->additional_desc];
            }
            foreach ($p_items as $key => $val) {
                $purchase = new PurchaseItems();
                $purchase->article_id = $article->id;
                $purchase->insta_pay_id = $instamojo->id;
                $purchase->item_code = $key;
                $purchase->item_price = $val['price'];
                $purchase->item_desc = $val['description'];
                $purchase->save();
            }

            $total = 0.00;
            foreach ($p_items as $key => $value) {
                $total += floatval($value['price']);
            }

            $amountToPay = $total;
            $processingFee = 0;
            if ($perceCharges != "" && $perceCharges > 0) {
                $processingFee = ($amountToPay * $perceCharges) / 100;
            }
            if ($staCharge != "" && $staCharge > 0) {
                $processingFee = $processingFee + $staCharge;
            }

            $total = $amountToPay + $processingFee;


            $api = new Instamojo(Yii::$app->params['insta_key'], Yii::$app->params['insta_token'], Yii::$app->params['insta_end_point']);
            try {
                $response = $api->paymentRequestCreate(array(
                    "purpose" => "Payment for " . $article->paper_id,
                    "amount" => $total,
                    "buyer_name" => $article->author_name,
                    "email" => $article->a_email,
                    "phone" => $article->a_phone,
                    "redirect_url" => Url::to(['paidonline'], true),
                    //"webhook" => Url::to(['open/postpaydetail'],true)
                ));
                if (!empty($response['longurl'])) {
                    $instamojo->r_amount = $response['amount'];
                    $instamojo->payment_request_id = $response['id'];
                    $instamojo->r_purpose = $response['purpose'];
                    $instamojo->r_created_at = $response['created_at'];
                    $instamojo->r_modified_at = $response['modified_at'];
                    $instamojo->request_log = Json::encode($response);
                    if ($instamojo->update() !== false) {
                        return $this->redirect($response['longurl']);
                    } else {
                        Yii::$app->session->setFlash('danger', "Unable to process payment.");
                        return $this->refresh();
                    }
                }
            } catch (Exception $e) {
                //print('Error: ' . $e->getMessage());
                Yii::$app->session->setFlash('danger', "Unable to process payment.");
                return $this->refresh();
            }
            Yii::$app->end();
        }

        $mainPrice = $items['manuscript']['price'];
        $processingFee = 0;
        if ($perceCharges != "" && $perceCharges > 0) {
            $processingFee = ($mainPrice * $perceCharges) / 100;
        }
        if ($staCharge != "" && $staCharge > 0) {
            $processingFee = $processingFee + $staCharge;
        }

        $mainPrice = $mainPrice + $processingFee;

        $render_data = ['model' => $article, 'instamojo' => $instamojo, 'items' => $items, 'mainPrice' => $mainPrice, 'processingFee' => $processingFee];
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('payonline', $render_data);
        } else {
            return $this->render('payonline', $render_data);
        }
    }

    public function actionPaidonline()
    {
        if (isset($_GET['payment_request_id'])) {
            $pr_id = $_GET['payment_request_id'];
            $insta = InstamojoPayment::findOne(['payment_request_id' => $pr_id, 'is_deleted' => 0]);
            if ($insta) {
                $insta->redirect_log = Json::encode($_GET);
                $insta->progress_status = 2;
                $insta->update();

                $api = new Instamojo(Yii::$app->params['insta_key'], Yii::$app->params['insta_token'], Yii::$app->params['insta_end_point']);
                try {
                    $response = $api->paymentRequestPaymentStatus($_GET['payment_request_id'], $_GET['payment_id']);
                    if ($response && !empty($response['payment'])) {
                        $payment = $response['payment'];
                        $insta->redirect_log = Json::encode($response);
                        $insta->payment_id = $payment['payment_id'];
                        $insta->w_status = $payment['status'];
                        $insta->w_buyer_name = $payment['buyer_name'];
                        $insta->w_buyer_phone = $payment['buyer_phone'];
                        $insta->w_currency = $payment['currency'];
                        $insta->w_amount_recieved = $payment['amount'];
                        $insta->w_fees = $payment['fees'];
                        $insta->progress_status = 3;
                        if ($insta->update()) {
                            $payment_file = $insta::generatePaymentreport($insta);
                            if ($insta->w_status == "Credit" && $payment_file) {
                                Yii::$app->session->setFlash('success', "We have successfully received your payment. Please Upload copyright to complete your payment.");
                                return $this->redirect(['payonline']);
                            } else {
                                Yii::$app->session->setFlash('danger', "Payment Failed. Please try again or contact us.");
                                return $this->redirect(['payonline']);
                            }
                        }
                    }
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('danger', "We are unable to verify your payment. Don't Worry! Please email/call us by mentioning your Manuscript id.");
                    return $this->refresh();
                }
            }
            Yii::$app->session->setFlash('danger', "We are unable to verify your payment. Don't Worry! Please email/call us by mentioning your Manuscript id.");
            return $this->refresh();
        }
    }

    public function actionUploadpay()
    {
        Yii::$app->session->open();
        if (!empty($_SESSION['get_pay_detail'])) {
            $pay_detail = $_SESSION['get_pay_detail'];
            $article = Article::findOne($pay_detail['id']);
        } else {
            return $this->redirect(['getpaydetail']);
        }
        $model = new \backend\models\Article();
        $model->scenario = 'copyright';
        $model->paid_online = 0;
        if ($model->load(\Yii::$app->request->post())) {
            //verify captcha
            if ($article) {
                if (!in_array($article->status, [5, 7])) {
                    if ($article->status < 5) {
                        Yii::$app->session->setFlash('danger', "Your paper is still under review. We will mail you once it accepted.");
                    } else {
                        Yii::$app->session->setFlash('danger', "Copyright and Payment already uploaded and accepted.<br>If you want to update it then send new documents to info@grdjournals.com with paper id mentioned in email.");
                    }
                    return $this->refresh();
                }
                if ($article->conf_id != 0) {
                    $fileDir = "conference";
                } else {
                    $fileDir = "article";
                }
                $article->paid_online = $model->paid_online;
                $article->status = 7;
                $filepath = $article->file_path;

                //Upload Copyright Form
                $article->copyright_file = \yii\web\UploadedFile::getInstance($article, 'copyright_file');

                $article->copyright_file->name = $filepath . "{$article->paper_id}_copyright_file_" . time() . "." . $article->copyright_file->extension;
                $copyright = $article->copyright_file->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $article->copyright_file->baseName . '.' . $article->copyright_file->extension);
                //Upload Payment Form
                $article->payment_file = \yii\web\UploadedFile::getInstance($article, 'payment_file');
                $article->payment_file->name = $filepath . "{$article->paper_id}_payment_file_" . time() . "." . $article->payment_file->extension;
                $payment = $article->payment_file->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $article->payment_file->baseName . '.' . $article->payment_file->extension);

                //Mail to GRD
                $message = PritMailer::paymentReceived(['model' => $article]);

                if ($copyright && $payment && $article->update()) {
                    Yii::$app->session->setFlash('success', "Copyright and Payment Successfully Uploaded.");
                    return $this->redirect(['getpaydetail']);
                }
            } else {
                Yii::$app->session->setFlash('danger', "Paper id or Email is not valid. Please enter valid Email and Paper Id.");
            }
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('uploadpay', ['model' => $model]);
        } else {
            return $this->render('uploadpay', ['model' => $model]);
        }
    }

    public function actionSearchmanuscript()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;

        $searchModel = new PublishedSearch();
        $searchModel->is_deleted = 0;
        $searchModel->status = 1;

        $dataProvider = $searchModel->frontsearch(Yii::$app->request->queryParams);

        return $this->render('searchmenuscript', ['content' => $content, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionConfproposal()
    {
        $model = new ConfPro();
        $model->scenario = "create";
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        if ($model->load(Yii::$app->request->post())) {

            $path_suffix = date('Y') . "/";
            $model->brochure = UploadedFile::getInstance($model, 'brochure');
            $model->brochure->name = $path_suffix . time() . "_" . Common::clean($model->brochure->name);
            $model->college_logo = UploadedFile::getInstance($model, 'college_logo');
            $model->college_logo->name = $path_suffix . time() . "_" . Common::clean($model->college_logo->name);
            if ($model->save()) {
                $message = PritMailer::confproposal(['model' => $model]);
                $b_path = DOCPATH . "/uploads/brochure/$path_suffix";
                $c_path = DOCPATH . "/uploads/college_logo/$path_suffix";
                Common::checkAndCreateDirectory($b_path);
                Common::checkAndCreateDirectory($c_path);
                $model->brochure->saveAs($b_path . $model->brochure->baseName . '.' . $model->brochure->extension);
                $model->college_logo->saveAs($c_path . $model->college_logo->baseName . '.' . $model->college_logo->extension);
                chmod($b_path . $model->brochure->baseName . '.' . $model->brochure->extension, 0777);
                chmod($c_path . $model->college_logo->baseName . '.' . $model->college_logo->extension, 0777);

                Yii::$app->session->setFlash('success', 'You have successfully created a Conference Proposal.');
                return $this->refresh();
            }
        }
        return $this->render('confproposal', ['content' => $content, 'model' => $model]);
    }


    public function actionEditorialboard()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $reviewers = EditorialBoard::find()->where(['status' => 1, 'is_deleted' => 0, 'show_in_editor' => 1])->all();
        $Phd_Completed = [];
        $Phd_Persuing = [];
        $Me_Completed = [];
        $ME_Pursuing = [];
        $M_sc = [];
        $M_pharm = [];
        $M_Tech = [];
        $Others = [];
        foreach ($reviewers as $reviewer) {
            if ($reviewer->qualification == 'Phd Completed')
                $Phd_Completed[] = $reviewer;
            else if ($reviewer->qualification == 'Phd Persuing' || $reviewer->qualification == 'PhD Pursuing')
                $Phd_Persuing[] = $reviewer;
            else if ($reviewer->qualification == 'Me Completed')
                $Me_Completed[] = $reviewer;
            else if ($reviewer->qualification == 'ME Pursuing')
                $ME_Pursuing[] = $reviewer;
            else if ($reviewer->qualification == 'M.sc')
                $M_sc[] = $reviewer;
            else if ($reviewer->qualification == 'M.pharm')
                $M_pharm[] = $reviewer;
            else if ($reviewer->qualification == 'M.Tech')
                $M_Tech[] = $reviewer;
            else
                $Others[] = $reviewer;
        }
        $reviewerss = array_merge($Phd_Completed, $Phd_Persuing, $Me_Completed, $ME_Pursuing, $M_sc, $M_pharm, $M_Tech, $Others);
        return $this->render('editorialboard', ['content' => $content, 'reviewers' => $reviewerss]);
    }

    public function actionReviewerboard()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $reviewers = EditorialBoard::find()->where(['status' => 1, 'is_deleted' => 0, 'show_in_reviewer' => 1])->all();
        $Phd_Completed = [];
        $Phd_Persuing = [];
        $Me_Completed = [];
        $ME_Pursuing = [];
        $M_sc = [];
        $M_pharm = [];
        $M_Tech = [];
        $Others = [];
        foreach ($reviewers as $reviewer) {
            if ($reviewer->qualification == 'Phd Completed')
                $Phd_Completed[] = $reviewer;
            else if ($reviewer->qualification == 'Phd Persuing' || $reviewer->qualification == 'PhD Pursuing')
                $Phd_Persuing[] = $reviewer;
            else if ($reviewer->qualification == 'Me Completed')
                $Me_Completed[] = $reviewer;
            else if ($reviewer->qualification == 'ME Pursuing')
                $ME_Pursuing[] = $reviewer;
            else if ($reviewer->qualification == 'M.sc')
                $M_sc[] = $reviewer;
            else if ($reviewer->qualification == 'M.pharm')
                $M_pharm[] = $reviewer;
            else if ($reviewer->qualification == 'M.Tech')
                $M_Tech[] = $reviewer;
            else
                $Others[] = $reviewer;
        }
        $reviewerss = array_merge($Phd_Completed, $Phd_Persuing, $Me_Completed, $ME_Pursuing, $M_sc, $M_pharm, $M_Tech, $Others);
        return $this->render('editorialboard', ['content' => $content, 'reviewers' => $reviewerss]);
    }

    public function actionJoinboard()
    {

        $model = new \backend\models\EditorialBoard();
        $model->scenario = "create";

        if ($model->load(Yii::$app->request->post())) {

            $model->cv = \yii\web\UploadedFile::getInstance($model, 'cv');
            $model->cv->name = time() . "_" . Common::clean($model->cv->name);
            $profile_pic = \yii\web\UploadedFile::getInstance($model, 'profile_pic');
            if ($profile_pic) {
                $model->profile_pic = $profile_pic;
                $model->profile_pic->name = time() . "_" . Common::clean($model->profile_pic->name);
            }
            $model->status = 0;
            if ($model->save()) {
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/cv");
                Common::checkAndCreateDirectory(DOCPATH . "/uploads/reviewer_pic");
                $model->cv->saveAs(DOCPATH . "/uploads/cv/" . $model->cv->baseName . '.' . $model->cv->extension);
                if ($profile_pic) {
                    $model->profile_pic->saveAs(DOCPATH . "/uploads/reviewer_pic/" . $model->profile_pic->baseName . '.' . $model->profile_pic->extension);
                }

                Yii::$app->session->setFlash('success', 'You have been successfully registerd with us.');
                return $this->redirect(['joinboard']);
            }
        }
        return $this->render('joinboard', [
            'model' => $model,
        ]);
    }

    public function actionPastissue()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $issues = VolIss::find()->where(['is_deleted' => 0])->orderBy('id Desc')->asArray()->all();
        return $this->render('pastissue', ['content' => $content, 'issues' => $issues]);
    }

    public function getpubquery($currentIssue)
    {
        if (is_object($currentIssue)) {
            if ($currentIssue->tableName() == 'conference') {
                $condition = ['published.status' => 1, 'published.is_deleted' => 0, 'article.conf_id' => $currentIssue->id];
            } else {
                $condition = ['published.status' => 1, 'published.is_deleted' => 0, 'article.voliss_id' => $currentIssue->id];
            }
        } else {
            if ($currentIssue == 'conference') {
                $condition = ['and', 'article.conf_id > 0', ['published.status' => 1, 'published.is_deleted' => 0]];
            } else {
                $condition = ['and', 'article.voliss_id > 0', ['published.status' => 1, 'published.is_deleted' => 0]];
            }
        }

        $query = Published::find()->joinWith('article')->where($condition);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 25;
        $published = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return ['published' => $published, 'currentIssue' => $currentIssue, 'pages' => $pages];
    }

    public function actionArchive($id)
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $currentIssue = VolIss::findOne($id);
        $viewData = $this->getpubquery($currentIssue);
        return $this->render('currentissue', ['content' => $content, 'published' => $viewData['published'], 'currentIssue' => $viewData['currentIssue'], 'pages' => $viewData['pages']]);
    }

    public function actionArchiveajax($id)
    {
        $this->layout = false;
        $content = Cms::getContent('Archive');
        $this->siteTitle = $content->page_title;
        $currentIssue = VolIss::findOne($id);
        $viewData = $this->getpubquery($currentIssue);
        echo $this->renderAjax('currentissue', ['content' => $content, 'published' => $viewData['published'], 'currentIssue' => $viewData['currentIssue'], 'pages' => $viewData['pages']]);
    }

    public function actionCurrentissue()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $currentIssue = VolIss::find()->where(['is_deleted' => 0])->orderBy('id DESC')->one();
        $viewData = $this->getpubquery($currentIssue);
        return $this->render('currentissue', ['content' => $content, 'published' => $viewData['published'], 'currentIssue' => $viewData['currentIssue'], 'pages' => $viewData['pages']]);
    }

    public function actionSearcharticle()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $currentIssue = VolIss::find()->where(['is_deleted' => 0])->orderBy('id DESC')->one();
        $viewData = $this->getpubquery($currentIssue);
        return $this->render('currentissue', ['content' => $content, 'published' => $viewData['published'], 'currentIssue' => $viewData['currentIssue'], 'pages' => $viewData['pages']]);
    }

    public function actionDownload()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('download', ['content' => $content]);
    }

    public function actionResearcharea()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('researcharea', ['content' => $content]);
    }

    public function actionFaq()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('faq', ['content' => $content]);
    }

    public function actionPublicationpolicies()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('publicationpolicies', ['content' => $content]);
    }

    public function actionEthicsdocument()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('ethicsdocument', ['content' => $content]);
    }

    public function actionAboutus()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('aboutus', ['content' => $content]);
    }

    public function actionContactus()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $model = new ContactUs();
        $model->scenario = "create";
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $message = PritMailer::contactus(['model' => $model]);
                Yii::$app->session->setFlash('success', "You have successfully submitted contact request.");
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('danger', "Failed to send request. Please try again.");
            }
        }
        return $this->render('contactus', ['content' => $content, 'model' => $model]);
    }

    public function actionGrdjeabout()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('grdje_about', ['content' => $content]);
    }

    public function actionGrdjeresearcharea()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('research_area', ['content' => $content]);
    }

    public function actionGrdjesubmit()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;

        $viewData = Article::createArticle();
        if ($viewData === true) {
            return $this->redirect(['grdjesubmit']);
        }
        $content->content = $this->renderPartial('submitmenuscript', $viewData);
        return $this->render('grdje', ['content' => $content]);
    }

    public function actionGrdjecharges()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('charges', ['content' => $content]);
    }

    public function actionGrdjeimpactfactor()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('grdje', ['content' => $content]);
    }

    public function actionGrdjeindexing()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('grdje', ['content' => $content]);
    }

    public function actionRefundpolicy()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('refund_policy', ['content' => $content]);
    }

    public function actionReporting()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('reporting', ['content' => $content]);
    }

    public function actionReviewerguideline()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('reviewerguideline', ['content' => $content]);
    }

    public function actionGrdjecallforpaper()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        return $this->render('grdje', ['content' => $content]);
    }

    public function actionPaperstatus()
    {
        $content = Cms::getContent($this->action->id, 1);
        $this->siteTitle = $content->page_title;
        $model = new \backend\models\Article();
        $model->scenario = "paper_status";
        $p_status = null;
        $p_step = null;
        if ($model->load(\Yii::$app->request->post())) {
            $status = \backend\models\Article::findone(['a_email' => $model->a_email, 'paper_id' => $model->paper_id]);
            if ($status) {
                if ($status->published) {
                    $p_step = 5;
                    $p_status = "published";
                } elseif ($status->status >= 13) {
                    $p_step = 4;
                    $p_status = "sent_for_publication";
                } elseif ($status->status == 5) {
                    $p_step = 3;
                    $p_status = "accepted";
                } elseif ($status->status == 6) {
                    $p_step = 3;
                    $p_status = "rejected";
                } elseif ($status->sent_for_review == 1) {
                    $p_step = 2;
                    $p_status = "under_review";
                } elseif ($status->status == 1) {
                    $p_step = 1;
                    $p_status = "received";
                }
                //Yii::$app->session->setFlash('success', 'Your paper status:: <strong>'.$status::$statusArrayToAuthor[$status->status].'</strong>');
            } else {
                Yii::$app->session->setFlash('danger', 'We do not have such record. Please do not try again with same.');
            }
        }
        return $this->render('paperstatus', ['model' => $model, 'p_status' => $p_status, 'p_step' => $p_step]);
    }

    public function actionArticle($paper_id)
    {
        $published = Published::findOne(['paper_id' => $paper_id, 'is_deleted' => 0, 'status' => 1]);
        if ($published) {
            $this->siteTitle = $published->title;
            return $this->render('article', ['published' => $published]);
        } else {
            throw new NotFoundHttpException('Sorry, this article is not available or temporary unavailable, In case of any problems regarding this article please contact us.');
        }
    }

    public function actionHowtopublish()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        return $this->render('howtopublish', ['content' => $content]);
    }

    public function actionConferences()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $today = date('Y-m-d');
        $prev_conf = Conference::find()->where(['and', ['<', 'pub_date', $today], ['is_deleted' => 0]])->orderBy('id Desc')->asArray()->all();
        $upcoming_conf = Conference::find()->where(['and', ['>=', 'pub_date', $today], ['is_deleted' => 0]])->orderBy('id Desc')->asArray()->all();
        return $this->render('conferences', ['content' => $content, 'prev_conf' => $prev_conf, 'upcoming_conf' => $upcoming_conf]);
    }

    public function actionProceedings($id)
    {
        $id = str_replace('GRDCF', "", $id);
        $id = (int) $id;
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $currentIssue = Conference::findOne($id);
        $viewData = $this->getpubquery($currentIssue);
        return $this->render('currentissue', ['content' => $content, 'published' => $viewData['published'], 'currentIssue' => $viewData['currentIssue'], 'pages' => $viewData['pages']]);
    }

    /* public function actionSpecialissue(){
      $content = Cms::getContent($this->action->id);
      $this->siteTitle = $content->page_title;
      $currentIssue = 'conference';
      $viewData = $this->getpubquery($currentIssue);
      $specialIssue = true;
      return $this->render('currentissue', ['content' => $content, 'published'=>$viewData['published'],'currentIssue'=>$viewData['currentIssue'],'pages' => $viewData['pages'], 'specialIssue'=>$specialIssue]);
      } */

    public function actionSpecialissue()
    {
        $content = Cms::getContent($this->action->id);
        $this->siteTitle = $content->page_title;
        $conferences = Conference::find()->where(['is_deleted' => 0])->orderBy('id Desc')->asArray()->all();
        return $this->render('specialissue', ['content' => $content, 'conferences' => $conferences]);
    }

    public function actionFolder()
    {
        $query = "SELECT DISTINCT(file_path) as path FROM `article`  where conf_id = 0";
        $result = Yii::$app->db->createCommand($query)->queryAll();
        foreach ($result as $res) {
            $createDir = Common::checkAndCreateDirectory(DOCPATH . "/uploads/article/" . $res['path']);
        }


        $query = "SELECT DISTINCT(file_path) as path FROM `article`  where conf_id != 0";
        $result = Yii::$app->db->createCommand($query)->queryAll();
        foreach ($result as $res) {
            $createDir = Common::checkAndCreateDirectory(DOCPATH . "/uploads/conference/" . $res['path']);
        }

        exit("Done");
    }
}
