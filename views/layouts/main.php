<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php if (!Yii::$app->user->isGuest) {?>
        <style>
            html, body, #map-canvas {
                height: 100%;
                margin: 0;
                padding: 0
            }
            #map-canvas {
                height: 600px;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
        <script src="http://pontorez.com/_/map2/linkToYandexMaps.js"></script>
        <script>
            function initialize() {
                var moskvabad = new google.maps.LatLng(55.041666676667,37.617777787778);
                var mapOptions = {
                    zoom: 4,
                    center: moskvabad,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scaleControl: true,
                    mapTypeControl: true
                };

                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                var ctaLayer = new google.maps.KmlLayer({
                    url: 'http://pontorez.com/_/map2/00-map.kml?1441212250'
                });
                ctaLayer.setMap(map);

                ctaLayer = new google.maps.KmlLayer({
                    url: 'http://pontorez.com/_/map/00-map.kml?1414489510'
                });
                ctaLayer.setMap(map);

                var homeControlDiv = document.createElement('div');
                new HomeControl(homeControlDiv);
                homeControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
            }

            google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    <?php } ?>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Summer',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Register', 'url' => ['/site/signup']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
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
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
