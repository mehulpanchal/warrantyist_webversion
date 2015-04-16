angular.module('ngForgotForm', ['ngAria', 'ngMessages', 'ngAnimate'])
        .controller('ForgotPasswordController', function ($scope, $http, $window) {
            var ctrl = this,
                    newCustomer = {email: ''};
            var forgotpassword = function () {
                if (ctrl.signupForm.$valid) {
                    $http({
                        method: 'POST',
                        url: site_url + "resetpassword",
                        data: newCustomer,
                    }).success(function (loginDetails) {
                        $scope.updLoginDetails = loginDetails;
                        if ($scope.updLoginDetails.status == true) {
                            ctrl.showSubmittedPrompt = true;
                            $scope.message = loginDetails.message;
                        } else {
                            ctrl.showSubmittedPrompt = true;
                            $scope.message = loginDetails.message;
                        }
                    });
                    //clearForm();
                }
            };

            var clearForm = function () {
                ctrl.newCustomer = {email: ''}
                ctrl.signupForm.$setUntouched();
                ctrl.signupForm.$setPristine();
            };

            var getPasswordType = function () {
                return ctrl.signupForm.showPassword ? 'text' : 'password';
            };

            var toggleEmailPrompt = function (value) {
                ctrl.showEmailPrompt = value;
            };

//            var toggleUsernamePrompt = function (value) {
//                ctrl.showUsernamePrompt = value;
//            };

            var hasErrorClass = function (field) {
                return ctrl.signupForm[field].$touched && ctrl.signupForm[field].$invalid;
            };

            var showMessages = function (field) {
                return ctrl.signupForm[field].$touched || ctrl.signupForm.$submitted
            };

            ctrl.showEmailPrompt = false;
            ctrl.showUsernamePrompt = false;
            ctrl.showSubmittedPrompt = false;
            ctrl.showSubmittedmsg = false;
            ctrl.toggleEmailPrompt = toggleEmailPrompt;
            //ctrl.toggleUsernamePrompt = toggleUsernamePrompt;
            ctrl.getPasswordType = getPasswordType;
            ctrl.hasErrorClass = hasErrorClass;
            ctrl.showMessages = showMessages;
            ctrl.newCustomer = newCustomer;
            ctrl.forgotpassword = forgotpassword;
            ctrl.clearForm = clearForm;
        })
        ;
