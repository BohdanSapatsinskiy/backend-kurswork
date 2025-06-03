<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use app\models\LoginForm;
use app\models\RegisterForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['profile', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['user/profile']);
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Реєстрація успішна. Тепер увійдіть.');
            return $this->redirect(['login']);
        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->password)) {
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
            } else {
                $model->password = User::findOne($model->id)->password;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Дані оновлено.');
                return $this->refresh();
            }
        }

        return $this->render('profile', ['model' => $model]);
    }

}
