<?php

namespace app\controllers;

use backend\components\PritSms;
use backend\models\ArticleFormat;
use backend\models\ArticleReview;
use backend\models\ArticleRevision;
use backend\models\Conference;
use backend\models\EditorialBoard;
use backend\models\Formatter;
use backend\models\PritMailer;
use backend\models\ReviewRequest;
use backend\models\search\EditorialBoardSearch;
use backend\models\VolIss;
use Yii;
use backend\models\Article;
use backend\models\search\ArticleSearch;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\vendors\Common;
use app\components\BaseController;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BaseController {

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ArticleSearch();
        $searchModel->is_deleted = 0;
        $searchModel->conf_id = 0;
        $searchModel->notStatus = 6;
        $searchModel->voliss_id = VolIss::find()->select('id')->where(['is_deleted' => 0])->orderBy('id DESC')->scalar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConference() {
        $searchModel = new ArticleSearch();
        if (IS_GRD_ADMIN) {
            $searchModel->scenario = 'admin';
            $searchModel->conf_id = Conference::find()->select('id')->where(['is_deleted' => 0])->orderBy('id DESC')->scalar();
            /* $searchModel->is_submitted = 1; */
        } else {
            $searchModel->scenario = 'conference';
            $searchModel->conf_id = ACTIVE_CONF;
        }

        $searchModel->is_deleted = 0;
        $searchModel->notStatus = 6;
        $searchModel->voliss_id = 0;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionArchived() {
        $searchModel = new ArticleSearch();
        $searchModel->is_deleted = 1;
        $searchModel->conf_id = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('archived', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUndodelete($id) {
        $model = $this->findModel($id);
        $model->is_deleted = 0;

        if ($model->update()) {
            Yii::$app->session->setFlash('success', common::translateText("DELETE_SUCCESS"));
        } else {
            Yii::$app->session->setFlash('error', common::translateText("DELETE_FAIL"));
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionArchivedproceeding() {
        $searchModel = new ArticleSearch();
        $searchModel->is_deleted = 1;
        $searchModel->voliss_id = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('archived', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRejected() {
        $searchModel = new ArticleSearch();
        $searchModel->is_deleted = 0;
        $searchModel->conf_id = 0;
        $searchModel->status = 6;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rejected', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $viewData = Article::createArticle();
        if ($viewData === true) {
            return $this->redirect(['index']);
        }
        return $this->render('_form', $viewData);
    }

    public function actionCreateproceeding() {
        $viewData = Article::createArticle(null, 'conf');
        if ($viewData === true) {
            return $this->redirect(['conference']);
        }
        return $this->render('_form', $viewData);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $viewData = Article::createArticle($id);
        if ($viewData === true) {
            return $this->redirectReferer(['index'], -2);
        }
        return $this->render('_form', $viewData);
    }

    public function actionUpdateproceeding($id) {
        if (IS_CONF_USER) {
            $model = $this->findModel($id);
            if ($model->is_submitted == 1) {
                throw new NotFoundHttpException('To update this proceeding please contact us.');
            }
        }
        $viewData = Article::createArticle($id, 'conf');
        if ($viewData === true) {
            return $this->redirectReferer(['conference'], -2);
        }
        return $this->render('_form', $viewData);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->is_deleted = 1;

        if ($model->update()) {
            Yii::$app->session->setFlash('success', common::translateText("DELETE_SUCCESS"));
        } else {
            Yii::$app->session->setFlash('error', common::translateText("DELETE_FAIL"));
        }
        return $this->redirectReferer(['index'], -1);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Article::findOne($id)) !== null) {
            $this->checkAuthority($model);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function checkAuthority($model) {
        if (IS_CONF_USER) {
            if ($model->conf_id == 0 || !in_array($model->conf_id, $_SESSION['authorized_conf'])) {
                throw new NotFoundHttpException('The requested page does not exist. Contact us in case of any problem.');
            }
        }
    }

    public function actionSendtoreviewer($id) {
        $article = $this->findModel($id);
        $searchModel = new EditorialBoardSearch();
        $searchModel->is_deleted = 0;
        $searchModel->status = 1;
        $searchModel->priority = 1;
        $reviewersList = $searchModel->search(Yii::$app->request->queryParams);
        $article->scenario = "review_email";
        $old_r_copy = $article->reviewer_copy;
        if ($article->load(Yii::$app->request->post())) {
            $article->reviewer_sent_ids = isset($_POST['selection']) ? $_POST['selection'] : null;
            $rIds = $article->reviewer_sent_ids;
            if ($rIds) {
                /**
                 * upload file
                 */
                $r_copy = false;
                $filepath = $article->file_path;
                $r_file = UploadedFile::getInstance($article, 'reviewer_copy');
                if ($r_file) {
                    $article->reviewer_copy = $r_file;
                    $article->reviewer_copy->name = Common::clean($article->reviewer_copy->name);
                    $article->reviewer_copy->name = $filepath . $article->reviewer_copy->baseName . "_" . time() . '.' . $article->reviewer_copy->extension;
                    $r_copy = $article->reviewer_copy->saveAs(DOCPATH . "/uploads/article/" . $filepath . $article->reviewer_copy->baseName . '.' . $article->reviewer_copy->extension);
                    if (!$r_copy) {
                        Yii::$app->session->setFlash('danger', "Unable to upload file. Please try with valid extensions.");
                        return $this->redirectReferer(['index'], -1);
                    }
                } else {
                    $article->reviewer_copy = $old_r_copy;
                }

                if ($r_copy || !empty($article->reviewer_copy)) {
                    $file = DOCPATH . "/uploads/article/" . $article->reviewer_copy;
                } else {
                    $file = DOCPATH . "/uploads/article/" . $article->article_file;
                }

                $reviewers = \backend\models\EditorialBoard::findAll($rIds);
                $successIds = [];
                $successNames = [];

                foreach ($reviewers as $reviewer) {
                    $r_request = new ArticleReview();
                    $r_request->scenario = 'create';
                    $r_request->article_id = $id;
                    $r_request->reviewer_id = $reviewer->id;
                    if ($r_request->save()) {
                        $message = PritMailer::sendToReview(['reviewer' => $reviewer, 'article' => $article, 'file' => $file, 'rid' => $r_request->id]);
                        @PritSms::review_request(['model' => $reviewer]);
                        if ($message) {
                            $successIds[] = $reviewer->id;
                            $successNames[] = $reviewer->full_name;
                        } else {
                            $r_request->delete();
                        }
                    }
                }

                if (!empty($successIds)) {
                    $article->sent_for_review = 1;
                    $article->update(false, ['sent_for_review', 'reviewer_copy']);
                    $successNames = implode(', ', $successNames);
                    Yii::$app->session->setFlash('success', 'Request successfully sent to ' . $successNames);
                    return $this->redirectReferer(['index'], -1);
                }
                Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
                return $this->redirectReferer(['index'], -1);
            } else {
                Yii::$app->session->setFlash('danger', "Select at least one reviewer to send request.");
                return $this->redirectReferer(['index'], -1);
            }
        }
        return $this->renderAjax('_reviewer', ['id' => $id, 'reviewersList' => $reviewersList, 'article' => $article]);
    }

    public function actionReviewrequest($id) {
        $article = $this->findModel($id);
        $article->scenario = "review_request_file";

        //$reviewersList = EditorialBoard::getListWithInfo();
        $searchModel = new EditorialBoardSearch();
        $searchModel->is_deleted = 0;
        $searchModel->status = 1;
        $searchModel->priority = 1;
        $reviewersList = $searchModel->search(Yii::$app->request->queryParams);

        if ($article->load(Yii::$app->request->post())) {
            $filepath = $article->file_path;
            $r_file = UploadedFile::getInstance($article, 'reviewer_copy');
            if ($r_file) {
                $article->reviewer_copy = $r_file;
                $article->reviewer_copy->name = Common::clean($article->reviewer_copy->name);
                $article->reviewer_copy->name = $filepath . $article->reviewer_copy->baseName . "_" . time() . '.' . $article->reviewer_copy->extension;
                $r_copy = $article->reviewer_copy->saveAs(DOCPATH . "/uploads/article/" . $filepath . $article->reviewer_copy->baseName . '.' . $article->reviewer_copy->extension);
                if ($r_copy) {
                    if ($article->update(false, ['reviewer_copy']) !== false) {
                        Yii::$app->session->setFlash('success', "Reviewer copy successfully uploaded.");
                        return $this->redirectReferer(['index'], -1);
                    }
                }
                Yii::$app->session->setFlash('danger', "Unable to upload file. Please try with valid extensions.");
                return $this->redirectReferer(['index'], -1);
            }
        }
        //if($reviewRequest->load(Yii::$app->request->post())){
        if (Yii::$app->request->isPost) {
            if (!empty($_POST['selection'])) {
                $rIds = $_POST['selection'];
                if ($rIds) {
                    $article = $this->findModel($id);
                    $article->scenario = "review_request";

                    $reviewers = \backend\models\EditorialBoard::findAll($rIds);
                    $successIds = [];
                    $successNames = [];

                    foreach ($reviewers as $reviewer) {
                        $r_request = new ReviewRequest();
                        $r_request->article_id = $id;
                        $r_request->reviewer_id = $reviewer->id;
                        if ($r_request->save()) {
                            $message = PritMailer::requestReview(['reviewer' => $reviewer, 'article' => $article, 'rid' => $r_request->id]);
                            @PritSms::review_reminder(['model' => $reviewer]);
                            if ($message) {
                                $successIds[] = $reviewer->id;
                                $successNames[] = $reviewer->full_name;
                            } else {
                                $r_request->delete();
                            }
                        }
                    }
                    if (!empty($successIds)) {
                        $article->r_request_sent = 1;
                        $article->update(false, ['r_request_sent']);
                        $successNames = implode(', ', $successNames);
                        Yii::$app->session->setFlash('success', 'Request successfully sent to ' . $successNames);
                        return $this->redirectReferer(['index'], -1);
                    }

                    Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
                    return $this->redirectReferer(['index'], -1);
                } else {
                    Yii::$app->session->setFlash('danger', "Select at least one reviewer to send request.");
                    return $this->redirectReferer(['index'], -1);
                }
            } else {
                Yii::$app->session->setFlash('danger', "Select at least one reviewer to send request.");
                return $this->redirectReferer(['index'], -1);
            }
        }

        return $this->renderAjax('_review_request', ['id' => $id, 'reviewersList' => $reviewersList, 'article' => $article]);
    }

    public function actionShowreview($id) {
        $article = Article::findOne(['id' => $id]);
        return $this->renderPartial('_showreview', ['article' => $article]);
    }

    public function actionAccept($id) {
        $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['page/payment']);
        $article = Article::findOne(['id' => $id]);
        $article->status = 5;

        if (isset($_POST['accept_type'])) {
            $accept_type = ArticleRevision::$accept_type[$_POST['accept_type']];
        } else {
            $accept_type = "Accepted";
        }
        $message = PritMailer::articleAccepted(['model' => $article, 'payUrl' => $url, 'copyrightUrl' => 'http://grdjournals.com/uploads/files/GRD-copyright.pdf', 'accept_type' => $accept_type]);
        @PritSms::accepted(['model' => $article]);
        if ($message && $article->update()) {
            if (isset($_POST['accept_type'])) {
                $article_revision = new ArticleRevision();
                $article_revision->article_id = $id;
                $article_revision->accept_type = $_POST['accept_type'];
                $article_revision->save();
            }
            Yii::$app->session->setFlash('success', 'Article has been accepted.');
        } else {
            Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionReminder($id) {
        $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['page/payment']);
        $article = Article::findOne(['id' => $id]);

        $message = PritMailer::articleReminder(['model' => $article, 'payUrl' => $url, 'copyrightUrl' => 'http://grdjournals.com/uploads/files/GRD-copyright.pdf']);
        @PritSms::reminder(['model' => $article]);
        if ($message) {
            Yii::$app->session->setFlash('success', 'Reminder Mail sent successfully.');
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionMultireminder() {
        if (!empty($_POST['id'])) {
            $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['page/payment']);
            $ids = explode(',', $_POST['id']);
            $success = [];
            if ($ids) {
                $articles = Article::findAll(['id' => $ids, 'status' => 5]);
                foreach ($articles as $article) {
                    $message = PritMailer::articleReminder(['model' => $article, 'payUrl' => $url, 'copyrightUrl' => 'http://grdjournals.com/uploads/files/GRD-copyright.pdf']);
                    if ($message) {
                        $success[] = $article->paper_id;
                    }
                }
                $success = implode(", ", $success);
                Yii::$app->session->setFlash('success', "Reminder Mail sent successfully to $success.");
            }
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionReject($id) {
        $article = Article::findOne(['id' => $id]);
        $article->status = 6;

        $message = PritMailer::articleRejected(['model' => $article]);
        @PritSms::rejected(['model' => $article]);
        if ($message && $article->update()) {
            Yii::$app->session->setFlash('success', 'Article has been rejected.');
        } else {
            Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionAcceptpay($id) {

        $article = Article::findOne(['id' => $id]);
        $article->hardcopy = $_POST['hardcopy'];
        $article->status = 10;

        if ($article->update()) {
            Yii::$app->session->setFlash('success', 'Payment has been accepted.');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to accept Payment.');
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionSendcertificate($id) {
        $article = $this->findModel(['id' => $id]);
        if (IS_CONF_USER) {
            if ($article->is_submitted == 0)
                throw new NotFoundHttpException('Please Submit this proceeding to GRD first.');
            if (!$article->copyright_file)
                throw new NotFoundHttpException('Please Upload copyright file first.');
            if ($article->allow_certi == 0)
                throw new NotFoundHttpException('You are not allowed to send certificate. Contact GRD if any issue.');
        }
        if ($article->conf_id != 0) {
            $zip = Article::generateConfCertificates($article);
            $redirect = 'conference';
            $message = PritMailer::sendConfCerti(['model' => $article, 'zip' => $zip]);
        } else {
            $zip = Article::generateCertificates($article);
            $redirect = 'index';
            $message = PritMailer::paymentAccepted(['model' => $article, 'zip' => $zip]);
        }

        if ($message) {
            Yii::$app->session->setFlash('success', 'Certificate Sent Successfully.');
        } else {
            Yii::$app->session->setFlash('danger', 'Error Sending Certificate. Contact Developer.');
        }
        return $this->redirectReferer([$redirect], -1);
    }

    public function actionCheckcertificate($id) {
        $article = $this->findModel($id);
        if (IS_CONF_USER) {
            if ($article->is_submitted == 0)
                throw new NotFoundHttpException('Please Submit this proceeding to GRD first.');
            if (!$article->copyright_file)
                throw new NotFoundHttpException('Please Upload copyright file first.');
            if ($article->allow_certi == 0)
                throw new NotFoundHttpException('You are not allowed to download certificate. Contact GRD if any issue.');
        }
        if ($article->conf_id != 0) {
            $zip = Article::generateConfCertificates($article, true);
        } else {
            $zip = Article::generateCertificates($article, true);
        }
        return $this->redirect($zip);
    }

    public function actionSendtoformatter($id) {
        $article = Article::findOne(['id' => $id]);
        //$article->scenario = 'format';

        $formatters = \backend\models\Formatter::find()->where(['status' => 1, 'is_deleted' => 0])->all();
        $formatters = \yii\helpers\ArrayHelper::map($formatters, 'id', 'name');

        if ($article->load(Yii::$app->request->post())) {
            if ($article->conf_id != 0) {
                $fileDir = "conference";
                $redirect = 'conference';
            } else {
                $fileDir = "article";
                $redirect = 'index';
            }
            if (isset($_POST['Article']['formatted_file'])) {
                $article->scenario = 'fupload';
                $article->formatter_id = Yii::$app->user->id;
                $article->formatted_date = date('Y-m-d H:i:s');
                $article->status = 15;
                $filepath = $article->file_path;
                $article->formatted_file = \yii\web\UploadedFile::getInstance($article, 'formatted_file');
                $article->formatted_file->name = $filepath . "{$article->paper_id}_formatted_file_" . time() . "." . $article->formatted_file->extension;
                if ($article->update()) {

                    $formatted = $article->formatted_file->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $article->formatted_file->baseName . '.' . $article->formatted_file->extension);
                    Yii::$app->session->setFlash('success', 'File Submitted Successfully');
                } else {
                    Yii::$app->session->setFlash('danger', 'Failed to upload file. Please contact us about the issue.');
                }
                return $this->redirectReferer([$redirect], -1);
            } elseif (!empty($_POST['Article']['formatter_sent_ids'])) {
                $article->scenario = 'format_email';
                $fIds = $article->formatter_sent_ids;
                if ($fIds) {
                    $formatters = Formatter::findAll($fIds);
                    $successIds = [];
                    $successNames = [];
                    $file = DOCPATH . "/uploads/$fileDir/" . $article->article_file;
                    foreach ($formatters as $formatter) {
                        $f_request = new ArticleFormat();
                        $f_request->scenario = 'create';
                        $f_request->article_id = $id;
                        $f_request->formatter_id = $formatter->id;
                        if ($f_request->save()) {
                            $message = PritMailer::sendToFormatter(['formatter' => $formatter, 'article' => $article, 'file' => $file, 'fid' => $f_request->id]);
                            if (!$message) {
                                $f_request->delete();
                            } else {
                                $successIds[] = $formatter->id;
                                $successNames[] = $formatter->name;
                            }
                        }
                    }
                    if (!empty($successIds)) {
                        $article->status = 13;
                        $article->update(false, ['status']);
                        $successNames = implode(', ', $successNames);
                        Yii::$app->session->setFlash('success', 'Format Request successfully sent to ' . $successNames);
                        return $this->redirectReferer([$redirect], -1);
                    }
                    Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
                    return $this->redirectReferer([$redirect], -1);
                } else {
                    Yii::$app->session->setFlash('danger', "Select at least one formatter to send request.");
                    return $this->redirectReferer([$redirect], -1);
                }
            }
        }
        return $this->renderAjax('_formatter', ['formatters' => $formatters, 'article' => $article]);
    }

    public function actionEditreview($id) {
        $article = Article::findOne(['id' => $id]);
        $article->scenario = 'review';
        if ($article->load(Yii::$app->request->post())) {
            $comment = $article->article_review;
            if (isset($_POST['que_2'])) {
                $review = [];
                $review['que_1'] = $_POST['review_q'];
                $review['que_2'] = $_POST['que_2'];
            } else {
                $review = $_POST['review_q'];
            }

            $review['comment'] = $comment;
            $review['editor_comment'] = isset($_POST['editor_comment']) ? $_POST['editor_comment'] : "";
            $article->article_review = Json::encode($review);
            if ($article->update()) {
                Yii::$app->session->set('aid_highlight', $article->id);
                Yii::$app->session->setFlash('success', 'Review Edited Successfully');
                return $this->redirectReferer(['index'], -1);
            }
        }
        return $this->renderAjax('_edit_review', ['article' => $article]);
    }

    public function actionDownloadreport($id) {
        $article = $this->findModel($id);
        EditorialBoard::generateReviewReportPdf($article, 'D');
    }

    public function actionSubmit($id) {
        $article = $this->findModel($id);
        $article->is_submitted = 1;

        //$message = PritMailer::articleAccepted(['model'=>$article,'payUrl'=>$url, 'copyrightUrl'=>'http://grdjournals.com/uploads/files/GRD-copyright.pdf']);
        if ($article->update()) {
            Yii::$app->session->setFlash('success', 'Article successfully submitted.');
        } else {
            Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
        }
        Yii::$app->session->set('aid_highlight', $article->id);
        return $this->redirectReferer(['index'], -1);
    }

    public function actionUnlock($id) {
        $article = $this->findModel($id);
        $article->is_submitted = 0;

        //$message = PritMailer::articleAccepted(['model'=>$article,'payUrl'=>$url, 'copyrightUrl'=>'http://grdjournals.com/uploads/files/GRD-copyright.pdf']);
        if ($article->update()) {
            Yii::$app->session->setFlash('success', 'Article successfully unlocked.');
        } else {
            Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
        }
        Yii::$app->session->set('aid_highlight', $article->id);
        return $this->redirectReferer(['index'], -1);
    }

    public function actionUploadcopyright($id) {
        $article = $this->findModel($id);
        $article->scenario = 'copyright_backend';
        if ($article->conf_id != 0) {
            $fileDir = "conference";
            $redirect = 'conference';
        } else {
            $fileDir = "article";
            $redirect = 'index';
        }
        if ($article->load(\Yii::$app->request->post())) {
            $filepath = $article->file_path;
            //Upload Copyright Form
            $article->copyright_file = UploadedFile::getInstance($article, 'copyright_file');
            $article->copyright_file->name = $filepath . $article->paper_id . '_copyright_file_' . time() . '.' . $article->copyright_file->extension;

            if ($article->update()) {
                $copyright = $article->copyright_file->saveAs(DOCPATH . "/uploads/$fileDir/" . $filepath . $article->copyright_file->baseName . '.' . $article->copyright_file->extension);
                if (!$copyright) {
                    Yii::$app->session->setFlash('danger', Html::errorSummary($article));
                    return $this->redirectReferer([$redirect], -1);
                }
                Yii::$app->session->setFlash('success', "Copyright Document Successfully Uploaded.");
                return $this->redirectReferer([$redirect], -1);
            } else {
                Yii::$app->session->setFlash('danger', Html::errorSummary($article));
                return $this->redirectReferer([$redirect], -1);
            }
        }
        return $this->renderAjax('_copyright', ['article' => $article]);
    }

    public function actionAllowcerti() {
        $response = ['result' => false, 'text' => 'Failed to Update.'];
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($_POST['id']);
            $model->allow_certi = $_POST['value'];
            if ($model->update() !== false) {
                $response['result'] = true;
                $response['text'] = '';
            }
            return $response;
        }
    }

    public function actionNote() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['pk'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $model->note = $_POST['value'];
            $response = [];
            if ($model->update() == false) {
                $response['success'] = false;
                $response['msg'] = "Unable to update value";
            } else {
                $response['success'] = true;
                $response['msg'] = $model->note;
            }
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRollbackreject($id) {
        $article = $this->findModel($id);
        $article->status = 3;

        if ($article->update()) {
            Yii::$app->session->setFlash('success', 'Article updated successfully.');
        } else {
            Yii::$app->session->setFlash('danger', common::translateText("UPDATE_FAIL"));
        }
        return $this->redirectReferer(['index'], -1);
    }

    public function actionPlagiarism($id) {
        $article = $this->findModel($id);
        $data = [];
        $data['article'] = $article;
        if ($article->plagiarism) {
            $data['title'] = "Plagiarism Note";
            $data['type'] = "detail";
        } else {
            $data['title'] = "Plagiarism - Reject Article";
            $data['type'] = "form";
            $article->scenario = "add_plagiarism";
            if ($article->load(Yii::$app->request->post())) {
                if ($article->update() !== false) {
                    $article->status = 6;
                    $message = PritMailer::plagiarismRejected(['model' => $article]);
                    @PritSms::rejected(['model' => $article]);
                    if ($message && $article->update() !== false) {
                        Yii::$app->session->setFlash('success', "Article Rejected Successfully.");
                        return $this->redirectReferer(['index'], -1);
                    } else {
                        Yii::$app->session->setFlash('danger', "Failed to update data.");
                        return $this->redirectReferer(['index'], -1);
                    }
                } else {
                    Yii::$app->session->setFlash('danger', "Failed to update data.");
                    return $this->redirectReferer(['index'], -1);
                }
            }
        }
        return $this->renderAjax('_plagiarism', $data);
    }

    public function actionAuthormail($id) {
        $article = $this->findModel($id);
        $mail = new \backend\models\EmailMaster();
        $mail->scenario = "author_mail";
        if ($mail->load(Yii::$app->request->post())) {
            if (PritMailer::authorMail(['subject' => $mail->temp_subject, 'body' => $_POST['author-mail-html'], 'email' => $article->a_email])) {
                Yii::$app->session->setFlash('success', "Mail successfully sent.");
                return $this->redirectReferer(['index'], -2);
            } else {
                Yii::$app->session->setFlash('danger', "Failed to Send Email.");
                return $this->refresh();
            }
        }

        $data['mail'] = $mail;
        $data['article'] = $article;
        return $this->render('authormail', $data);
    }

    public function redirectReferer($data, $level) {
        return "<script>history.go($level);</script>";
    }

}
