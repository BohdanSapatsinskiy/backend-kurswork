<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

use yii\filters\AccessControl;

use app\models\Comment;
use \app\models\Service;
use app\models\AboutUs;
use app\models\Project;
use app\models\PublicInfo;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'comments'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->is_admin == 1;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionComments()
    {
        $comments = Comment::find()->with('user')->all();
        return $this->render('comments', ['comments' => $comments]);
    }
    public function actionUpdateComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $value = Yii::$app->request->post('value');

        $comment = Comment::findOne($id);
        if (!$comment || !in_array($field, ['mark', 'text', 'is_correct'])) {
            return ['success' => false, 'message' => 'Невірні дані'];
        }

        $comment->$field = $value;
        if ($comment->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не вдалося зберегти'];
    }
    public function actionDeleteComment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $comment = Comment::findOne($id);

        if (!$comment) {
            return ['success' => false, 'message' => 'Коментар не знайдено'];
        }

        if ($comment->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при видаленні'];
    }


    

    public function actionServices()
    {
        $services = Service::find()->all();
        return $this->render('services', ['services' => $services]);
    }

    public function actionCreateService()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Service();
        $model->tittle = Yii::$app->request->post('tittle');
        $model->about = Yii::$app->request->post('about');
        $model->imageFile = \yii\web\UploadedFile::getInstanceByName('img');

        if (!$model->imageFile) {
            return ['success' => false, 'message' => 'Файл не було завантажено.'];
        }

        if ($model->imageFile->getHasError()) {
            return ['success' => false, 'message' => 'Помилка при завантаженні файлу.'];
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($model->imageFile->type, $allowedMimeTypes)) {
            return ['success' => false, 'message' => 'Непідтримуваний тип файлу.'];
        }

        $fileName = uniqid('service_', true) . '.' . $model->imageFile->extension;
        $filePath = Yii::getAlias('@webroot') . '/img/services/' . $fileName;

        if (!$model->imageFile->saveAs($filePath)) {
            return ['success' => false, 'message' => 'Не вдалося зберегти зображення.'];
        }

        $model->img = $fileName;

        if ($model->save()) {
            return ['success' => true];
        }

        return [
            'success' => false,
            'message' => 'Помилка при збереженні сервісу.',
            'errors' => $model->getErrors(),            
            'attributes' => $model->getAttributes(),    
        ];
    }



    public function actionUpdateService()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $value = Yii::$app->request->post('value');

        $service = Service::findOne($id);
        if (!$service || !in_array($field, ['tittle', 'about'])) {
            return ['success' => false, 'message' => 'Невірні дані'];
        }

        $service->$field = $value;
        if ($service->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не вдалося зберегти'];
    }

    public function actionDeleteService()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $service = Service::findOne($id);

        if (!$service) {
            return ['success' => false, 'message' => 'Сервіс не знайдено'];
        }

        // Видаляємо зображення, якщо воно є
        if ($service->img) {
            $imgPath = Yii::getAlias('@webroot') . '/img/services/' . $service->img;
            if (file_exists($imgPath)) {
                @unlink($imgPath);
            }
        }

        if ($service->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не вдалося видалити сервіс'];
    }



    public function actionAboutUs()
    {
        $items = AboutUs::find()->all();
        return $this->render('about-us', ['items' => $items]);
    }

    public function actionCreateAbout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new AboutUs();
        $model->tittle = Yii::$app->request->post('tittle');
        $model->text = Yii::$app->request->post('text');
        $model->imageFile = \yii\web\UploadedFile::getInstanceByName('img');

        if ($model->imageFile) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($model->imageFile->type, $allowed)) {
                return ['success' => false, 'message' => 'Непідтримуваний формат зображення.'];
            }

            $filename = uniqid('about_', true) . '.' . $model->imageFile->extension;
            $filepath = Yii::getAlias('@webroot/img/about/') . $filename;

            if (!$model->imageFile->saveAs($filepath)) {
                return ['success' => false, 'message' => 'Не вдалося зберегти зображення.'];
            }

            $model->img = $filename;
        }

        if ($model->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при збереженні.'];
    }

    public function actionUpdateAbout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $value = Yii::$app->request->post('value');

        $item = AboutUs::findOne($id);
        if (!$item || !in_array($field, ['tittle', 'text'])) {
            return ['success' => false, 'message' => 'Некоректні дані'];
        }

        $item->$field = $value;
        if ($item->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не вдалося зберегти'];
    }

    public function actionDeleteAbout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $item = AboutUs::findOne($id);

        if (!$item) {
            return ['success' => false, 'message' => 'Запис не знайдено'];
        }

        if ($item->img) {
            $path = Yii::getAlias('@webroot/img/about/') . $item->img;
            if (file_exists($path)) @unlink($path);
        }

        if ($item->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при видаленні'];
    }



    public function actionProject()
    {
        $items = Project::find()->all();
        return $this->render('project', ['items' => $items]);
    }

    public function actionCreateProject()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Project();
        $model->name = Yii::$app->request->post('name');
        $model->text = Yii::$app->request->post('text');
        $model->date = Yii::$app->request->post('date');
        $model->imageFile = \yii\web\UploadedFile::getInstanceByName('img');

        if ($model->imageFile) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($model->imageFile->type, $allowed)) {
                return ['success' => false, 'message' => 'Непідтримуваний формат зображення.'];
            }

            $filename = uniqid('project_', true) . '.' . $model->imageFile->extension;
            $filepath = Yii::getAlias('@webroot/img/project/') . $filename;

            if (!$model->imageFile->saveAs($filepath)) {
                return ['success' => false, 'message' => 'Не вдалося зберегти зображення.'];
            }

            $model->img = $filename;
        }

        if ($model->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при збереженні.'];
    }

    public function actionUpdateProject()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $value = Yii::$app->request->post('value');

        $item = Project::findOne($id);
        if (!$item || !in_array($field, ['name', 'text'])) {
            return ['success' => false, 'message' => 'Некоректні дані'];
        }

        $item->$field = $value;
        if ($item->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не вдалося зберегти'];
    }

    public function actionDeleteProject()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $item = Project::findOne($id);

        if (!$item) {
            return ['success' => false, 'message' => 'Запис не знайдено'];
        }

        if ($item->img) {
            $path = Yii::getAlias('@webroot/img/project/') . $item->img;
            if (file_exists($path)) @unlink($path);
        }

        if ($item->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при видаленні'];
    }






    public function actionPublicInfo()
    {
        $items = PublicInfo::find()->all();
        return $this->render('public-info', ['items' => $items]);
    }

    public function actionCreatePublicInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PublicInfo();
        $model->name = Yii::$app->request->post('name');
        $model->date = Yii::$app->request->post('date');

        $model->download_path = null;
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'zip']; // вкажіть потрібні розширення
            if (!in_array(strtolower($file->extension), $allowedExtensions)) {
                return ['success' => false, 'message' => 'Непідтримуваний формат файлу.'];
            }

            $filename = uniqid('publicinfo_', true) . '.' . $file->extension;
            $filepath = Yii::getAlias('@webroot/files/public_info/') . $filename;

            if (!$file->saveAs($filepath)) {
                return ['success' => false, 'message' => 'Не вдалося зберегти файл.'];
            }

            $model->download_path = $filename;
        } else {
            return ['success' => false, 'message' => 'Файл не вибрано.'];
        }

        if ($model->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при збереженні.'];
    }

    public function actionUpdatePublicInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $value = Yii::$app->request->post('value');

        $item = PublicInfo::findOne($id);
        if (!$item || !in_array($field, ['name', 'date'])) {
            return ['success' => false, 'message' => 'Некоректні дані'];
        }

        $item->$field = $value;
        if ($item->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Не вдалося зберегти'];
    }

    public function actionDeletePublicInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $item = PublicInfo::findOne($id);

        if (!$item) {
            return ['success' => false, 'message' => 'Запис не знайдено'];
        }

        if ($item->download_path) {
            $path = Yii::getAlias('@webroot/files/public_info/') . $item->download_path;
            if (file_exists($path)) @unlink($path);
        }

        if ($item->delete()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Помилка при видаленні'];
    }


}
