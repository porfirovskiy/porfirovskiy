<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <?php if (Yii::$app->user->isGuest): ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151965973-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-151965973-2');
        </script>

    <?php endif; ?>

    <script data-ad-client="ca-pub-8218926731618294" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/favicon.ico'])]);?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    $menuItems[] = ['label' => \Yii::t('common', 'Home'), 'url' => ['/']];
    if (!Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => \Yii::t('common', 'Upload'), 'url' => ['/image/upload']];
        $menuItems[] = ['label' => \Yii::t('common', 'Upload By Url'), 'url' => ['/image/upload-by-url']];
        $menuItems[] = ['label' => \Yii::t('common', 'MultipleUpload'), 'url' => ['/image/multiple-upload']];
        $menuItems[] = ['label' => \Yii::t('common', 'Create Page'), 'url' => ['/pages/create']];
    }
    $menuItems[] = ['label' => \Yii::t('common', 'Tags'), 'url' => ['/tags']];
    $menuItems[] = ['label' => \Yii::t('common', 'Pages'), 'url' => ['/pages']];
    $menuItems[] = ['label' => \Yii::t('common', 'About'), 'url' => ['/site/about']];
    $menuItems[] = ['label' => \Yii::t('common', 'Contact'), 'url' => ['/site/contact']];

    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => \Yii::t('common', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => \Yii::t('common', 'Login'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode('porfirovskiy.name') ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= '' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
