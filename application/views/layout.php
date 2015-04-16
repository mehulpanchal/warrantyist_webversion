<?php if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        } ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js" data-ng-app="WarrantyistApp"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js" data-ng-app="WarrantyistApp"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" data-ng-app="WarrantyistApp">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <title data-ng-bind="'Warrantyist | ' + $state.current.data.pageTitle"></title>

        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/global/plugins/uniform/css/uniform.default.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <link href="<?php echo base_url('assets/global/css/style.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/animations.css') ?>" rel="stylesheet" type="text/css"/>  
        <!-- BEGIN DYMANICLY LOADED CSS FILES(all plugin and page related styles must be loaded between GLOBAL and THEME css files ) -->
        <link id="ng_load_plugins_before"/>
        <!-- END DYMANICLY LOADED CSS FILES -->

        <!-- BEGIN THEME STYLES -->
        <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
        <link href="<?php echo base_url('assets/global/css/components.css') ?>" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/global/css/plugins.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/admin/layout3/css/layout.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/admin/layout3/css/themes/default.css') ?>" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url('assets/admin/layout3/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->

        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
    <!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
    <body ng-controller="AppController" class="page-on-load">

        <!-- BEGIN PAGE SPINNER -->
        <div ng-spinner-bar class="page-spinner-bar">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
        <!-- END PAGE SPINNER -->

        <!-- BEGIN HEADER -->
        <div class="page-header">
            <?php include_once 'include/header.php'; ?>
        </div>    
        <!-- END HEADER -->

        <div class="clearfix">
        </div>

        <!-- BEGIN CONTAINER -->
        <div class="page-container">

            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">		
                <?php include_once 'include/page-head.html'; ?>
            </div>
            <!-- END PAGE HEAD -->

            <!-- BEGIN PAGE CONTENT -->
            <div class="page-content">
                <div class="container">
                    <!-- BEGIN ACTUAL CONTENT -->
                    <div ui-view class="fade-in-up">
                    </div>
                    <!-- END ACTUAL CONTENT -->
                </div>
            </div>
            <!-- END PAGE CONTENT -->

        </div>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <div><?php include_once 'include/footer.html';
                ''; ?></div>
        <!-- END FOOTER -->

        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        <!-- BEGIN CORE JQUERY PLUGINS -->
        <!--[if lt IE 9]>
        <script src="<?php echo base_url('assets/global/plugins/respond.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/excanvas.min.js') ?>"></script> 
        <![endif]-->
        <script src="<?php echo base_url('assets/global/plugins/jquery.min.js') ?>" type="text/javascript"></script>                
        <script src="<?php echo base_url('assets/global/plugins/jquery-migrate.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/jquery.blockui.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/jquery.cokie.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/uniform/jquery.uniform.min.js') ?>" type="text/javascript"></script>
        <!-- END CORE JQUERY PLUGINS -->

        <!-- BEGIN CORE ANGULARJS PLUGINS -->
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular.min.js') ?>" type="text/javascript"></script>	
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-sanitize.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-touch.min.js') ?>" type="text/javascript"></script>	
        <script src="<?php echo base_url('assets/global/plugins/angularjs/plugins/angular-ui-router.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/plugins/ocLazyLoad.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/plugins/ui-bootstrap-tpls.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/plugins/angular-file-upload/angular-file-upload.min.js') ?>" type="text/javascript"></script>
  <!--            <script src="http://code.angularjs.org/1.2.0-rc.3/angular-resource.js"></script>-->
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-aria.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-messages.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-animate.min.js') ?>"></script>
        <!-- END CORE ANGULARJS PLUGINS -->

        <!-- BEGIN APP LEVEL ANGULARJS SCRIPTS -->
        <script type="text/javascript"> var str = '<?php echo base_url(); ?>';
                BASE_URL = str.substring(0, str.length - 1);</script>
        <script src="<?php echo base_url('assets/js/app.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/factories.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/filters.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/directives.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/createDialog.js') ?>" type="text/javascript"></script>
        <!-- END APP LEVEL ANGULARJS SCRIPTS -->

        <!-- BEGIN APP LEVEL JQUERY SCRIPTS -->
        <script src="<?php echo base_url('assets/global/scripts/metronic.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin/layout3/scripts/layout.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/admin/layout3/scripts/demo.js') ?>" type="text/javascript"></script>          
        <!-- END APP LEVEL JQUERY SCRIPTS -->

        <script type="text/javascript">
                /* Init Metronic's core jquery plugins and layout scripts */
                $(document).ready(function () {
                    Metronic.init(); // Run metronic theme
                    Metronic.setAssetsPath('<?php echo base_url('assets') ?>/'); // Set the assets folder path			
                });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>