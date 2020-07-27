<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use app\components\HeaderWidget;
use app\components\FooterWidget;
use backend\vendors\Common;

/* @var $this \yii\web\View */
/* @var $content string */

//AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="p:domain_verify" content="3600a86eea5b8815b438bf033fc6447c"/>
        <?php echo Html::csrfMetaTags();?>
        <title><?php echo Html::encode($this->context->siteTitle) ?></title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?= BASEURL?>favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= BASEURL?>favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= BASEURL?>favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= BASEURL?>favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= BASEURL?>favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= BASEURL?>favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= BASEURL?>favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= BASEURL?>favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= BASEURL?>favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= BASEURL?>favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= BASEURL?>favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= BASEURL?>favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= BASEURL?>favicon/favicon-16x16.png">
        <link rel="manifest" href="<?= BASEURL?>favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= BASEURL?>favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <!-- Favicon -->

        <!--[if lt IE 9]>
        <script src="<?= BASEURL?>/js/html5shiv.js"></script>
        <script src="<?= BASEURL?>/js/respond.min.js"></script>
        <![endif]-->       
        
        <?php $this->head() ?>

    </head>
    <body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-70385735-1', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-W5DBCK"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W5DBCK');</script>
    <!-- End Google Tag Manager -->
    <?php $this->beginBody() ?>
        <?php echo HeaderWidget::widget(); ?>
        <?php echo $content; ?>
        <?php echo FooterWidget::widget(); ?>
        <script src="<?= BASEURL?>/js/jquery.js"></script>

        
        <script>
            $(document).ready(function () {
                $('.marquee').marquee();
                //$('.highlighttext').textillate({loop: true, minDisplayTime: 5000,});
                $('#vertical-ticker').totemticker({
                    row_height: '76px',
                    next: '#ticker-next',
                    previous: '#ticker-previous',
                    stop: '#stop',
                    start: '#start',
                    mousestop: true,
                });
                if($('img[id*="-verifycode-image"]').length > 0){
					$('img[id*="-verifycode-image"]').after('<a class="refresh-captcha" href="javascript:;"><img src="<?= BASEURL?>images/captcha-refresh.png" alt="Refresh Captcha"></a>');
					$('.refresh-captcha').on('click',function(){
					  $(this).prev().trigger('click');
					});	
				}
                
            });
            function otherOptions(obj){
                if(obj.val() == 'other'){
                    $()
                }
            }
        </script>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
