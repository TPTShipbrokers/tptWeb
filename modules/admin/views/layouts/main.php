<?php

use app\models\AppUser;
use app\models\Chartering;
use app\models\Company;
use app\models\Newsletter;
use app\models\Status;
use yii\helpers\Url;

$current_user = Yii::$app->getModule('admin')->user->identity;

$data = [
    'Users' => AppUser::find()->count(),
    'Chartering' => Chartering::find()->count(),
    'WAF Positions' => \app\models\WafPosition::find()->count(),
    'UKC Positions' => \app\models\AraPosition::find()->count(),
    'Statuses' => Status::find()->count(),
    'Companies' => Company::find()->count(),
    'Market Reports' => Newsletter::find()->count(),
];
?>

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 4.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>TPT | Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/font-awesome/css/font-awesome.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/simple-line-icons/simple-line-icons.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap/css/bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/uniform/css/uniform.default.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/kartik-fileupload/css/fileinput.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/typeahead/typeahead.css" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/datatables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/morris/morris.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/fullcalendar/fullcalendar.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-toastr/toastr.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
          rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->

    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-datetimepicker-2/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet" type="text/css"/>


    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/css/components.min.css" rel="stylesheet"
          id="style_components" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?= Yii::$app->request->baseUrl ?>/media/pages/css/profile-2.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/pages/css/invoice.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/pages/css/invoice-2.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?= Yii::$app->request->baseUrl ?>/media/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet"
          type="text/css" id="style_color"/>

    <link href="<?= Yii::$app->request->baseUrl ?>/media/layouts/layout/css/layout.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= Yii::$app->request->baseUrl ?>/media/layouts/layout/css/custom.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/layouts/templates/main.js" type="text/javascript"></script>


<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?= Url::base(); ?>/admin">
                <img src="<?= Url::base() ?>/media/layouts/layout/img/logo.png" alt="logo"
                     class="logo-default"/> </a>
            <div class="menu-toggler sidebar-toggler"></div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default unread-messages-general"> 0 </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>

                            </h3>

                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">

                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN INBOX DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                <!-- END INBOX DROPDOWN -->
                <!-- BEGIN TODO DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                <!-- END TODO DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <img alt="" class="img-circle"
                             src="<?= Yii::$app->request->baseUrl ?>/media/layouts/layout/img/avatar3_small.jpg"/>
                        <span class="username username-hide-on-mobile"> <?= Yii::$app->getModule('admin')->user->identity->first_name ?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?= Url::toRoute('users/view/' . $current_user->user_id) ?>">
                                <i class="icon-user"></i> My Profile </a>
                        </li>


                        <li>
                            <a href="<?= Url::toRoute('logout/') ?>">
                                <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper hide">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler"></div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                        <a href="javascript:" class="remove">
                            <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                        <a href="javascript:" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>


                <li class="nav-item start active open">

                    <a href="javascript:" class="nav-link nav-toggle">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>

                    <ul class="sub-menu">
                        <?php
                        $items = $this->context->module->params["dashboard_items"];
                        $icons = $this->context->module->params["menu_icons"];
                        ?>

                        <?php foreach ($items as $label => $url): ?>

                            <li class="nav-item start">
                                <a href="<?= Url::toRoute($url) ?>" class="nav-link ">
                                    <i class="<?= $icons[$label] ?>"></i>
                                    <span class="title"><?= $label ?></span>
                                    <span class="badge badge-danger"><?= $data[$label] ?></span>
                                </a>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php

                $menu_items = $this->context->module->params["menu_items"];
                $menu_icons = $this->context->module->params["menu_icons"];

                foreach ($menu_items as $label => $item):

                    if (is_array($item)):

                        ?>
                        <li class="nav-item">
                            <a href="javascript:" class="nav-link nav-toggle">
                                <i class="<?= $menu_icons[$label] ?>"></i>
                                <span class="title"><?= ucfirst($label) ?></span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">

                                <?php foreach ($item as $subitem_label => $subitem): ?>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="<?= Yii::$app->getUrlManager()->createUrl($this->context->module->id . "/" . $subitem) ?>">
                                            <?= ucfirst($subitem_label) ?>
                                        </a>
                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a href="<?= Yii::$app->getUrlManager()->createUrl($this->context->module->id . "/" . $item) ?>">
                                <i class="<?= $menu_icons[$label] ?>"></i>
                                <span class="title"><?php echo ucfirst($label); ?></span>
                                <span class="selected"></span>
                            </a>
                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>


            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <div class="theme-panel hidden-xs hidden-sm">
                <div class="toggler"></div>
                <div class="toggler-close"></div>
                <div class="theme-options">
                    <div class="theme-option theme-colors clearfix">
                        <span> THEME COLOR </span>
                        <ul>
                            <li class="color-default current tooltips" data-style="default" data-container="body"
                                data-original-title="Default"></li>
                            <li class="color-darkblue tooltips" data-style="darkblue" data-container="body"
                                data-original-title="Dark Blue"></li>
                            <li class="color-blue tooltips" data-style="blue" data-container="body"
                                data-original-title="Blue"></li>
                            <li class="color-grey tooltips" data-style="grey" data-container="body"
                                data-original-title="Grey"></li>
                            <li class="color-light tooltips" data-style="light" data-container="body"
                                data-original-title="Light"></li>
                            <li class="color-light2 tooltips" data-style="light2" data-container="body" data-html="true"
                                data-original-title="Light 2"></li>
                        </ul>
                    </div>
                    <div class="theme-option">
                        <span> Theme Style </span>
                        <select class="layout-style-option form-control input-sm">
                            <option value="square" selected="selected">Square corners</option>
                            <option value="rounded">Rounded corners</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Layout </span>
                        <select class="layout-option form-control input-sm">
                            <option value="fluid" selected="selected">Fluid</option>
                            <option value="boxed">Boxed</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Header </span>
                        <select class="page-header-option form-control input-sm">
                            <option value="fixed" selected="selected">Fixed</option>
                            <option value="default">Default</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Top Menu Dropdown</span>
                        <select class="page-header-top-dropdown-style-option form-control input-sm">
                            <option value="light" selected="selected">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Mode</span>
                        <select class="sidebar-option form-control input-sm">
                            <option value="fixed">Fixed</option>
                            <option value="default" selected="selected">Default</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Menu </span>
                        <select class="sidebar-menu-option form-control input-sm">
                            <option value="accordion" selected="selected">Accordion</option>
                            <option value="hover">Hover</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Style </span>
                        <select class="sidebar-style-option form-control input-sm">
                            <option value="default" selected="selected">Default</option>
                            <option value="light">Light</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Sidebar Position </span>
                        <select class="sidebar-pos-option form-control input-sm">
                            <option value="left" selected="selected">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                    <div class="theme-option">
                        <span> Footer </span>
                        <select class="page-footer-option form-control input-sm">
                            <option value="fixed">Fixed</option>
                            <option value="default" selected="selected">Default</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- END THEME PANEL -->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="<?= Url::to(['/admin']); ?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>
                            <?php

                            $controller = ucfirst(Yii::$app->controller->id);
                            $action = ucfirst(Yii::$app->controller->action->id);

                            if (Yii::$app->controller->id === 'ara-positions') {
                                $breadcrumb = 'UKC positions';
                            }
                            elseif (Yii::$app->controller->action->id !== 'index') {
                                $breadcrumb = $controller;
                            } else {
                                $breadcrumb = $controller;
                            }

                            echo $breadcrumb;
                            ?>
                        </span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>
            <!-- END PAGE BAR -->

            <!-- END PAGE HEADER-->
            <?php echo $content; ?>


        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->

    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> 2017 &copy; Borne Agency
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

<!-- END FOOTER -->
<!--[if lt IE 9]>
<script src="<?=Yii::$app->request->baseUrl?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=Yii::$app->request->baseUrl?>/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->


<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery.blockui.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-daterangepicker/moment.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-daterangepicker/daterangepicker.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/morris/morris.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/morris/raphael-min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/counterup/jquery.waypoints.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/counterup/jquery.counterup.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/amcharts.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/serial.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/pie.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/radar.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/themes/light.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/themes/patterns.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amcharts/themes/chalk.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/ammap/ammap.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/ammap/maps/js/worldLow.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/amcharts/amstockcharts/amstock.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/fullcalendar/fullcalendar.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/flot/jquery.flot.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/flot/jquery.flot.resize.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/flot/jquery.flot.categories.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery.sparkline.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/datatables.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/datatable-tools.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/table2CSV/table2CSV.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/select2/js/select2.full.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/jquery-validation/js/additional-methods.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/typeahead/handlebars.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/typeahead/typeahead.bundle.min.js"
        type="text/javascript"></script>


<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-daterangepicker/moment.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-daterangepicker/daterangepicker.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-datetimepicker-2/js/bootstrap-datetimepicker.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/clockface/js/clockface.js"
        type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= Yii::$app->request->baseUrl ?>/media/pages/scripts/dashboard.min.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-toastr/toastr.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-confirmation/bootstrap-confirmation.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/pages/scripts/form-wizard.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/datatables.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>

<script src="<?= Yii::$app->request->baseUrl ?>/media/pages/scripts/table-datatables-ajax.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= Yii::$app->request->baseUrl ?>/media/global/scripts/app.min.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/layouts/layout/scripts/layout.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/layouts/layout/scripts/demo.min.js"
        type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/media/layouts/global/scripts/quick-sidebar.custom.js"
        type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script type="text/javascript">

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        toastr.options.closeDuration = 50;
    });

    function windowPrint() {
        window.print();
    }
</script>
</body>

</html>