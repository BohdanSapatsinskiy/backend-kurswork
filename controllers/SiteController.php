<?php

namespace app\controllers;
use Yii;
use yii\helpers\Html;
use yii\web\Response;

use yii\web\Controller;
use \yii\data\Pagination;

use app\models\Service;
use app\models\Comment;
use app\models\AboutUs;
use app\models\Project;
use app\models\PublicInfo;

class SiteController extends Controller
{
    private function cachePage($cacheKey, $renderCallback)
    {
        $html = Yii::$app->cache->get($cacheKey);

        if ($html === false) {
            $html = call_user_func($renderCallback);

            if (Yii::$app->response->statusCode === 200) {
                Yii::$app->cache->set($cacheKey, $html, 3600); // на 1 годину
            }
        }

        return $html;
    }

    public function actionIndex()
    {
        $cacheKey = 'page_index';

        return $this->cachePage($cacheKey, function () {
            $services = Service::find()->all();
            $comments = Comment::find()
                ->where(['is_correct' => 1])
                ->orderBy(['date' => SORT_DESC])
                ->all();

            return $this->render('index', [
                'services' => $services,
                'comments' => $comments,
            ]);
        });
    }



    public function actionAddComment()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'redirect' => Yii::$app->urlManager->createUrl(['user/login'])];
        }

        $model = new Comment();
        $model->user_id = Yii::$app->user->id;
        $model->mark = Yii::$app->request->post('Mark');
        $model->text = Yii::$app->request->post('Text');
        $model->date = date('Y-m-d');

        if ($model->validate() && $model->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }


    public function actionAbout()
    {
        $cacheKey = 'page_about';

        return $this->cachePage($cacheKey, function () {
            $about = AboutUs::find()->all();

            return $this->render('about', [
                'about' => $about,
            ]);
        });
    }



    public function actionPublic()
    {
        $sortParam = Yii::$app->request->get('sort', 'date-desc');
        $cacheKey = 'page_public_' . $sortParam;

        return $this->cachePage($cacheKey, function () use ($sortParam) {
            $query = PublicInfo::find()->orderBy($this->getSortOrder($sortParam));
            list($files, $pagination) = $this->getPaginatedData($query, 10);

            return $this->render('public', [
                'files' => $files,
                'pagination' => $pagination,
                'currentSort' => $sortParam,
            ]);
        });
    }


    public function actionProjects()
    {
        $sortParam = Yii::$app->request->get('sort', 'date-desc');
        $cacheKey = 'page_projects_' . $sortParam;

        return $this->cachePage($cacheKey, function () use ($sortParam) {
            $query = Project::find()->orderBy($this->getSortOrder($sortParam));
            list($projects, $pagination) = $this->getPaginatedData($query, 10);

            return $this->render('projects', [
                'projects' => $projects,
                'pagination' => $pagination,
                'currentSort' => $sortParam,
            ]);
        });
    }


    protected function getSortOrder($sort)
    {
        switch ($sort) {
            case 'date-asc':
                return ['date' => SORT_ASC];
            case 'title-asc':
                return ['name' => SORT_ASC];
            case 'title-desc':
                return ['name' => SORT_DESC];
            case 'date-desc':
            default:
                return ['date' => SORT_DESC];
        }
    }

    protected function getPaginatedData($query, $pageSize = 10)
    {
        $countQuery = clone $query;

        $params = Yii::$app->request->getQueryParams();
        unset($params['page']);

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $pageSize,
            'params' => $params,
        ]);
        $models = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [$models, $pagination];
    }



    public function actionContacts()
    {
        if (Yii::$app->request->isPost) {
            $emailTo = Yii::$app->request->post('admin_email');
            $projectName = Yii::$app->request->post('project_name');
            $formSubject = Yii::$app->request->post('form_subject');
            $email = Yii::$app->request->post('E-mail');
            $phone = Yii::$app->request->post('Phone');
            $name = Yii::$app->request->post('Name');
            $text = Yii::$app->request->post('Text');

            $body = "
                <strong>Ім’я:</strong> " . Html::encode($name) . "<br>
                <strong>Email:</strong> " . Html::encode($email) . "<br>
                <strong>Телефон:</strong> " . Html::encode($phone) . "<br>
                <strong>Повідомлення:</strong><br>" . nl2br(Html::encode($text));

            try {
                Yii::$app->mailer->compose()
                    ->setTo($emailTo)
                    ->setFrom([$emailTo => $projectName])
                    ->setReplyTo($email)
                    ->setSubject($formSubject)
                    ->setHtmlBody($body)
                    ->send();

                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => true, 'message' => 'Ваше повідомлення успішно надіслано!'];
                }

                Yii::$app->session->setFlash('success', 'Ваше повідомлення успішно надіслано!');
                return $this->refresh();

            } catch (\Exception $e) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => false, 'message' => 'Не вдалося надіслати повідомлення.'];
                }
                Yii::$app->session->setFlash('error', 'Не вдалося надіслати повідомлення.');
            }
        }

        return $this->render('contacts');
    }


    /**
     * Обробка помилок.
     *
     * @return array|string
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
