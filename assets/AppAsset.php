<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',

//        <!-- DataTables CSS -->
        "css/dataTables/bootstrap.css",
//        <!-- DataTables Responsive CSS -->
        "css/dataTables/responsive.css",

        "css/font-awesome.min.css"

    ];
    public $js = [

//        <!-- DataTables JavaScript -->
        "js/dataTables/jquery.dataTables.min.js",
        "js/dataTables/dataTables.bootstrap.min.js",

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
