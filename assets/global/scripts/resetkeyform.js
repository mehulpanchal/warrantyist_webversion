angular.module('ngResetKeyForm', ['ngAria', 'ngMessages', 'ngAnimate'])
        .controller('ResetPasswordController', function ($scope, $http,$window) {
            var ctrl = this,
            newCustomer = {password: '', cpassword: '', paramsdata: ''};
            var resetpassword = function () {
                if (ctrl.signupForm.$valid) {
                    $http({
                        method: 'POST',
                        url: site_url + "user/user_password_update",
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
                ctrl.newCustomer = {password: '', cpassword: '', paramsdata: ''};
                ctrl.signupForm.$setUntouched();
                ctrl.signupForm.$setPristine();
            };

            var getPasswordType = function () {
                return ctrl.signupForm.showPassword ? 'text' : 'password';
            };
            var getCPasswordType = function () {
                return ctrl.signupForm.showCPassword ? 'text' : 'password';
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
            ctrl.getCPasswordType = getCPasswordType;
            ctrl.hasErrorClass = hasErrorClass;
            ctrl.showMessages = showMessages;
            ctrl.newCustomer = newCustomer;
            ctrl.resetpassword = resetpassword;
            ctrl.clearForm = clearForm;
        })
        .directive('validatePasswordCharacters', function () {
            return {
                require: 'ngModel',
                link: function ($scope, element, attrs, ngModel) {
                    ngModel.$validators.lowerCase = function (value) {
                        var pattern = /[a-z]+/;
                        return (typeof value !== 'undefined') && pattern.test(value);
                    };
                    ngModel.$validators.upperCase = function (value) {
                        var pattern = /[A-Z]+/;
                        return (typeof value !== 'undefined') && pattern.test(value);
                    };
                    ngModel.$validators.number = function (value) {
                        var pattern = /\d+/;
                        return (typeof value !== 'undefined') && pattern.test(value);
                    };
                    ngModel.$validators.specialCharacter = function (value) {
                        var pattern = /\W+/;
                        return (typeof value !== 'undefined') && pattern.test(value);
                    };
                    ngModel.$validators.eightCharacters = function (value) {
                        return (typeof value !== 'undefined') && value.length >= 8;
                    };
                }
            }
        })
        ;
