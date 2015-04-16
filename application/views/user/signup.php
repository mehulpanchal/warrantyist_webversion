<html ng-app="ngsignupForm">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Warrantyist | Sign Up</title>
        <link href="<?php echo base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/style.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('assets/global/css/animations.css') ?>" rel="stylesheet" type="text/css"/>  
    </head>
    <body  ng-controller="SignUpController as ctrl">
        <div class="signup-wrapper">
            <div class="logo">
                <img src="<?php echo base_url('assets/admin/layout/img/logo_1.png') ?>" alt=""/>
            </div>
            <h2>Get started with a Free Account</h2>
            <p class="nomargin alignc">Sign up in 30 seconds. No credit card required.</p>
            <p class="below36 alignc">Already have a Warrantyist account? <a href="<?php echo base_url() ?>">Log in here</a>.</p>
            <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.showSubmittedPrompt">
                Thank you! Your account has been created.
            </div>
            <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.showUserAlreadyregistered">
                Sorry! User Already Exist. Please Try with another email, Thank You.
            </div>
            <div class="alert alert-success message-animation" role="alert" ng-if="ctrl.showSubmittedmsg">
                User has Already Register.
            </div>
            <form name="ctrl.signupForm" ng-submit="ctrl.signup()" novalidate method="post">
                <div class="form-group" ng-class="{'has-error':ctrl.hasErrorClass('email')}">
                    <label for="email">Email</label>
                    <input id="email" name="email" class="form-control" type="email" required
                           ng-model="ctrl.newCustomer.email" ng-model-options="{ updateOn : 'default blur' }"
                           ng-focus="ctrl.toggleEmailPrompt(true)" ng-blur="ctrl.toggleEmailPrompt(false)"/>

                    <div class="my-messages">
                        <div class="prompt message-animation" ng-if="ctrl.showEmailPrompt">
                            What's your email address?
                        </div>
                    </div>

                    <div class="my-messages" ng-messages="ctrl.signupForm.email.$error" ng-if="ctrl.showMessages('email')">
                        <div class="message-animation" ng-message="required">
                            <strong>This field is required.</strong>
                        </div>
                        <div class="message-animation" ng-message="email">
                            <strong>Please format your email correctly.</strong>
                        </div>
                    </div>

                </div>
                <div class="form-group" ng-class="{'has-error':ctrl.hasErrorClass('userName')}">
                    <label for="userName">Username</label>
                    <input id="userName" name="userName" class="form-control" type="text" required
                           ng-model="ctrl.newCustomer.userName" ng-model-options="{ updateOn : 'default blur' }"
                           ng-focus="ctrl.toggleUsernamePrompt(true)" ng-blur="ctrl.toggleUsernamePrompt(false)"/>

                    <div class="my-messages">
                        <div class="prompt message-animation" ng-if="ctrl.showUsernamePrompt">
                            Choose a username that contains only letters and numbers, or use your email address.
                        </div>
                    </div>

                    <div class="my-messages" ng-messages="ctrl.signupForm.userName.$error" ng-if="ctrl.showMessages('userName')">
                        <div class="message-animation" ng-message="required">
                            <strong>This field is required.</strong>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="input-group" ng-class="{'has-error':ctrl.hasErrorClass('password')}">
                        <input id="password" name="password" class="form-control" required
                               type="{{ctrl.getPasswordType()}}"
                               ng-model-options="{ updateOn : 'default blur' }"
                               ng-model="ctrl.newCustomer.password"
                               validate-password-characters/>
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
                <button class="btn btn-primary" type="submit">Create My Account</button>
            </form>
        </div>

        <script type="text/javascript">
                    var base_url = "<?php echo base_url(); ?>";
                    var site_url = "<?php echo site_url(); ?>";        
        </script>
        <script src="<?php echo base_url('assets/global/plugins/jquery.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/jquery-migrate.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/scripts/angular.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-aria.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-messages.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/plugins/angularjs/angular-animate.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/global/scripts/registration.js') ?>"></script>
    </body>
</html>