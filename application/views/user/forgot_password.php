<html ng-app="ngForgotForm">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Warrantyist | Forgot Password</title>
        <link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/style.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/animations.css') ?>" rel="stylesheet" type="text/css"/>  
    </head>
    <body  ng-controller="ForgotPasswordController as ctrl">
        <div class="signup-wrapper">
            <div class="logo">
                <img src="<?php echo base_url('assets/admin/layout/img/logo_1.png') ?>" alt=""/>
            </div>
            <h3>Forgot Password</h3>   
            <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.showSubmittedPrompt">
                {{message}}
            </div>
            
            <form name="ctrl.signupForm" ng-submit="ctrl.forgotpassword()" novalidate>
                <div class="form-group" ng-class="{'has-error':ctrl.hasErrorClass('email')}">
                    <label for="email">Email</label>
                    <input id="email" name="email" class="form-control" type="email" required
                           ng-model="ctrl.newCustomer.email" ng-model-options="{ updateOn : 'default blur' }"
                           ng-focus="ctrl.toggleEmailPrompt(true)" ng-blur="ctrl.toggleEmailPrompt(false)"/>
                    
                    <div class="my-messages" ng-messages="ctrl.signupForm.email.$error" ng-if="ctrl.showMessages('email')">
                        <div class="message-animation" ng-message="required">
                            <strong>This field is required.</strong>
                        </div>
                        <div class="message-animation" ng-message="email">
                            <strong>Please format your email correctly.</strong>
                        </div>
                    </div>

                </div>
                
                <button class="btn btn-primary" type="submit">Submit</button>
                
            </form>
        </div>
        
        <script type="text/javascript">
                    var base_url = "<?php echo base_url(); ?>";
                    var site_url = "<?php echo site_url(); ?>";
        </script>
        <script src="<?php echo base_url('assets/global/scripts/angular.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-aria.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-messages.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-animate.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/scripts/forgotpassword.js') ?>"></script>
    </body>
</html>