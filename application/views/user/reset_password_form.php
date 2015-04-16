<html ng-app="ngResetKeyForm">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Warrantyist | Reset Password</title>
        <link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/style.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/animations.css') ?>" rel="stylesheet" type="text/css"/>  
    </head>
    <body  ng-controller="ResetPasswordController as ctrl">
        <div class="signup-wrapper">
            <div class="logo">
                <img src="<?php echo base_url('assets/admin/layout/img/logo_1.png') ?>" alt=""/>
            </div>
            <h3>Reset Password</h3>   
            <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.showSubmittedPrompt">
                {{message}}
            </div>

            <form name="ctrl.signupForm" ng-submit="ctrl.resetpassword()" novalidate>
                <div class="form-group">
                    <label for="password">New Password</label>

                    <div class="input-group" ng-class="{'has-error':ctrl.hasErrorClass('password')}">
                        <input id="password" name="password" class="form-control" required
                               type="{{ctrl.getPasswordType()}}"
                               ng-model-options="{ updateOn : 'default blur' }"
                               ng-model="ctrl.newCustomer.password" validate-password-characters />  <!-- -->
                        <span class="input-group-addon">
                            <input type="checkbox" ng-model="ctrl.signupForm.showPassword"> Show
                        </span>
                    </div>

                    <div class="my-messages" ng-messages="ctrl.signupForm.password.$error" ng-if="ctrl.showMessages('password')">
                        <div class="message-animation" ng-message="required">
                            <strong>This field is required.</strong>
                        </div>
                    </div>

                    <div class="password-requirements" ng-if="!ctrl.signupForm.password.$valid">
                        <ul class="float-left">
                            <li ng-class="{'completed':!ctrl.signupForm.password.$error.lowerCase}">One lowercase character</li>
                            <li ng-class="{'completed':!ctrl.signupForm.password.$error.upperCase}">One uppercase character</li>
                            <li ng-class="{'completed':!ctrl.signupForm.password.$error.number}">One number</li>
                        </ul>
                        <ul class="selfclear clearfix">
                            <li ng-class="{'completed':!ctrl.signupForm.password.$error.specialCharacter}">One special character</li>
                            <li ng-class="{'completed':!ctrl.signupForm.password.$error.eightCharacters}">Eight characters minimum</li>
                        </ul>
                    </div>

                    <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.signupForm.password.$valid">
                        Your password is secure and you are good to go!
                    </div>
                </div>

                <div class="form-group">
                    <label for="cpassword">Confirm Password</label>

                    <div class="input-group" ng-class="{'has-error':ctrl.hasErrorClass('cpassword')}">
                        <input id="cpassword" name="cpassword" class="form-control" required
                               type="{{ctrl.getCPasswordType()}}"
                               ng-model-options="{ updateOn : 'default blur' }"
                               ng-model="ctrl.newCustomer.cpassword" validate-password-characters />  <!-- -->
                        <span class="input-group-addon">
                            <input type="checkbox" ng-model="ctrl.signupForm.showCPassword"> Show
                        </span>
                    </div>

                    <div class="my-messages" ng-messages="ctrl.signupForm.cpassword.$error" ng-if="ctrl.showMessages('cpassword')">
                        <div class="message-animation" ng-message="required">
                            <strong>This field is required.</strong>
                        </div>
                    </div>

                    <div class="password-requirements" ng-if="!ctrl.signupForm.cpassword.$valid">
                        <ul class="float-left">
                            <li ng-class="{'completed':!ctrl.signupForm.cpassword.$error.lowerCase}">One lowercase character</li>
                            <li ng-class="{'completed':!ctrl.signupForm.cpassword.$error.upperCase}">One uppercase character</li>
                            <li ng-class="{'completed':!ctrl.signupForm.cpassword.$error.number}">One number</li>
                        </ul>
                        <ul class="selfclear clearfix">
                            <li ng-class="{'completed':!ctrl.signupForm.cpassword.$error.specialCharacter}">One special character</li>
                            <li ng-class="{'completed':!ctrl.signupForm.cpassword.$error.eightCharacters}">Eight characters minimum</li>
                        </ul>
                        
                    </div>
                    
                    <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.signupForm.cpassword.$valid">
                        Your password is secure and you are good to go!
                    </div>
                </div>
                <input type="hidden" ng-init="ctrl.newCustomer.paramsdata = '<?php echo $params; ?>'" />
                <button class="btn btn-primary" type="submit">Submit</button>

            </form>
        </div>

        <script type="text/javascript">
                    var base_url = "<?php echo base_url(); ?>";
                    var site_url = "<?php echo site_url(); ?>";        </script>
        <script src="<?php echo base_url('assets/global/scripts/angular.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-aria.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-messages.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-animate.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/scripts/resetkeyform.js') ?>"></script>
    </body>
</html>