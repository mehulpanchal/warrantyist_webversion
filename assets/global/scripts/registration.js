angular.module('ngsignupForm', ['ngAria', 'ngMessages', 'ngAnimate'])
        .controller('SignUpController', function ($scope, $http, $window) {
            
            var ctrl = this,
            newCustomer = {email: '', userName: '', password: ''};
            
            var signup = function () {
                if (ctrl.signupForm.$valid) {
                    $http({
                    method: 'POST',
                    url: site_url + "signup",
                    data: newCustomer,
                    }).success(function (registerDetails) {
                        $scope.updregDetails = registerDetails;
                        if($scope.updregDetails.check == 'success') {
                           $window.location=site_url+'thankyou';
                        }
                        if($scope.updregDetails.check == 'fail') {
                            ctrl.showUserAlreadyregistered = true;
                        }

                    });
                    //ctrl.showSubmittedmsg = true;
                    //ctrl.showSubmittedPrompt = true;
                    clearForm();
                }
            };

            var clearForm = function () {
                ctrl.newCustomer = {email: '', userName: '', password: ''}
                ctrl.signupForm.$setUntouched();
                ctrl.signupForm.$setPristine();
            };

            var getPasswordType = function () {
                return ctrl.signupForm.showPassword ? 'text' : 'password';
            };

            var toggleEmailPrompt = function (value) {
                ctrl.showEmailPrompt = value;
            };

            var toggleUsernamePrompt = function (value) {
                ctrl.showUsernamePrompt = value;
            };

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
            ctrl.toggleUsernamePrompt = toggleUsernamePrompt;
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

//        angular.module('project', ['projectApi']).
//  config(function($routeProvider) {
//    $routeProvider.
//      when('/', {controller:ListCtrl, templateUrl:BASE_URL+'projects/template_list'}).
//      when('/edit/:id', {controller:EditCtrl, templateUrl:BASE_URL+'projects/template_detail'}).
//      when('/new', {controller:CreateCtrl, templateUrl:BASE_URL+'projects/template_detail'}).
//      otherwise({redirectTo:'/'});
//  });
//
//function ListCtrl($scope, $location, Project) {
//
//  $scope.projects = Project.query();
//
//  $scope.destroy = function(Project) {
//    Project.destroy(function() {
//      $scope.projects.splice($scope.projects.indexOf(Project), 1);
//    });
//  };
//}
//
//function CreateCtrl($scope, $location, Project) {
//  $scope.save = function() {
//    Project.save($scope.project, function(project) {
//      $location.path('/edit/' + project.id);
//    });
//  };
//}
//
//function EditCtrl($scope, $location, $routeParams, Project) {
//  var self = this;
//
//  Project.get({id: $routeParams.id}, function(project) {
//    self.original = project;
//    $scope.project = new Project(self.original);
//  });
//
//  $scope.isClean = function() {
//    return angular.equals(self.original, $scope.project);
//  };
//
//  $scope.destroy = function() {
//    self.original.destroy(function() {
//      $location.path('/');
//    });
//  };
//
//  $scope.save = function() {
//    $scope.project.update(function() {
//      $location.path('/');
//    });
//  };
//}
//
//
//angular.module('projectApi', ['ngResource']).
//  factory('Project', function($resource) {
//    var Project = $resource(BASE_URL+'api/projects/:method/:id', {}, {
//      query: {method:'GET', params: {method:'index'}, isArray:true },
//      save: {method:'POST', params: {method:'save'} },
//      get: {method:'GET', params: {method:'edit'} },
//      remove: {method:'DELETE', params: {method:'remove'} }
//    });
//
//    Project.prototype.update = function(cb) {
//      return Project.save({id: this.id},
//          angular.extend({}, this, {id:undefined}), cb);
//    };
//
//    Project.prototype.destroy = function(cb) {
//      return Project.remove({id: this.id}, cb);
//    };
//
//    return Project;
//  });