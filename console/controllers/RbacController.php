<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RbacController
 *
 * @author porfirovskiy
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $downloadImage = $auth->createPermission('downloadImage');
        $downloadImage->description = 'Download image';
        $auth->add($downloadImage);

        // добавляем разрешение "updatePost"
        $deleteImage = $auth->createPermission('deleteImage');
        $deleteImage->description = 'Delete image';
        $auth->add($deleteImage);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $downloadImage);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $deleteImage);
        $auth->addChild($admin, $user);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        //$auth->assign($author, 2);
        //$auth->assign($admin, 1);
    }
}

