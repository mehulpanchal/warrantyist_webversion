angular.module('ngloginForm', ['ngAria', 'ngMessages', 'ngAnimate'])
        .controller('LoginController', function ($scope, $http,$window) {
            var ctrl = this,
            newCustomer = {email: '', password: ''};
            var signup = function () {
                if (ctrl.signupForm.$valid) {
                    $http({
                        method: 'POST',
                        url: site_url + "dologin",
                        data: newCustomer,
                    }).success(function (loginDetails) {
                       $scope.updLoginDetails = loginDetails;
                        if($scope.updLoginDetails.check == 'success') {
                           $window.location=site_url+'dashboard';
                        }
                        if($scope.updLoginDetails.check == 'fail') {
                            ctrl.showSubmittedPrompt = true;
                        }
                    });
                    //clearForm();
                }
            };

            var clearForm = function () {
                ctrl.newCustomer = {email: '', password: ''}
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
            ctrl.signup = signup;
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
