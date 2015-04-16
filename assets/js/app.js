/***
 WarrantyistApp AngularJS App Main Script
 ***/
//BASE_URL = 'http://192.168.2.18/warrantyist';
var WarrantyistApp = angular.module("WarrantyistApp", [
    "ui.router",
    "ui.bootstrap",
    "oc.lazyLoad",
    "ngSanitize",
    "createDialog",
    "angularFileUpload"
            //"ngMessages"
]);

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
WarrantyistApp.config(['$ocLazyLoadProvider', function ($ocLazyLoadProvider) {
        $ocLazyLoadProvider.config({
            cssFilesInsertBefore: 'ng_load_plugins_before' // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
        });
    }]);

/* Setup App Main Controller */
WarrantyistApp.controller('AppController', ['$scope', '$rootScope', function ($scope, $rootScope) {
        $scope.$on('$viewContentLoaded', function () {
            // Metronic.initComponents(); // init core components
            Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials included in server side instead of loading with ng-include directive 
        });
    }]);

/* Setup Rounting For All Pages */
WarrantyistApp.config(['$stateProvider', '$urlRouterProvider', '$httpProvider', function ($stateProvider, $urlRouterProvider, $httpProvider) {


        // Redirect any unmatchmodeed url
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
        $urlRouterProvider.otherwise("/dashboard");

        $stateProvider
                // Dashboard
                .state('dashboard', {
                    url: "/dashboard",
                    templateUrl: BASE_URL + "/dashboard/home",
                    data: {pageTitle: 'Dashboard', pageSubTitle: 'statistics & reports'},
                    controller: "DashboardController",
                    resolve:
                            {
                                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                        return $ocLazyLoad.load({
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/DashboardController.js'
                                            ]
                                        });
                                    }],
                                Service: 'Service',
                                Amc: 'Amc',
                                Warranty: 'Warranty',
                                LicenseFactory: 'LicenseFactory'
                            }
                })
                // User Profile
                .state("profile", {
                    url: "/profile",
                    templateUrl: BASE_URL + "/profile/main",
                    //templateUrl: "views/profile/main",
                    data: {pageTitle: 'Profile', pageSubTitle: 'Account and Profile'},
                    controller: "UserProfileController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
                                        BASE_URL + '/assets/admin/pages/css/profile.css',
                                        BASE_URL + '/assets/admin/pages/css/tasks.css',
                                        BASE_URL + '/assets/global/plugins/jquery.sparkline.min.js',
                                        BASE_URL + '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
                                        BASE_URL + '/assets/admin/pages/scripts/profile.js',
                                        BASE_URL + '/assets/js/controllers/UserProfileController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: "ProfileAccount",
                    }
                })

                // User Profile Dashboard
                .state("profile.changeprofile", {
                    url: "/changeprofile",
                    templateUrl: BASE_URL + "/profile/change_profile",
                    data: {pageTitle: 'Profile'},
                    controller: "UserChangeProfileController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/css/style.css',
                                        BASE_URL + '/assets/js/controllers/UserChangeProfileController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: 'ProfileAccount'
                    }
                })

                // User Profile Account details
                .state("profile.manageaccount", {
                    url: "/manageaccount",
                    templateUrl: BASE_URL + "/profile/manage_account",
                    //controller:'UseraccountController',
                    data: {pageTitle: 'Account Details'},
                    controller: "UserAccountDetailsController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/css/style.css',
                                        BASE_URL + '/assets/js/controllers/UserAccountDetailsController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: 'ProfileAccount'
                    }
                })

                // User Management
                .state("profile.usermanagement", {
                    url: "/usermanagement",
                    templateUrl: BASE_URL + "/profile/user_management",
                    //controller:'UseraccountController',
                    data: {pageTitle: 'User Management'},
                    controller: "UserManagementController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/css/style.css',
                                        BASE_URL + '/assets/js/controllers/UserManagementController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: 'ProfileAccount'
                    }
                })

                // User device Management
                .state("profile.devicemanagement", {
                    url: "/devicemanagement",
                    templateUrl: BASE_URL + "/profile/manage_devices",
                    //controller:'UseraccountController',
                    data: {pageTitle: 'Device Management'},
                    controller: "UserDeviceManagementController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/css/style.css',
                                        BASE_URL + '/assets/js/controllers/UserDeviceManagementController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: 'ProfileAccount'
                    }
                })
                // User Export Data
                .state("profile.exportdata", {
                    url: "/exportdata",
                    templateUrl: BASE_URL + "/profile/export_data",
                    //controller:'UseraccountController',
                    data: {pageTitle: 'Export Data'},
                    controller: "UserExportDataController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/css/style.css',
                                        BASE_URL + '/assets/js/controllers/UserExportDataController.js'
                                    ]
                                });
                            }],
                       // ProfileAccount: 'ProfileAccount'
                    }
                })
                // User Export Data
                .state("profile.deactivateaccount", {
                    url: "/deactivateaccount",
                    templateUrl: BASE_URL + "/profile/deactivate_account",
                    //controller:'UseraccountController',
                    data: {pageTitle: 'Deactivate Account'},
                    controller: "UserDeactivateAccountController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/global/css/style.css',
                                        BASE_URL + '/assets/js/controllers/UserDeactivateAccountController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: 'ProfileAccount'
                    }
                })
                // User Export Data
                .state("profile.contactinformation", {
                    url: "/contactinformation",
                    templateUrl: BASE_URL + "/profile/contact_information",
                    //controller:'UseraccountController',
                    data: {pageTitle: 'Contact Information'},
                    controller: "UserContactInformationController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/UserContactInformationController.js'
                                    ]
                                });
                            }],
                        ProfileAccount: 'ProfileAccount'
                    }
                })
                
                .state('warranties', {
                    url: "/warranties",
                    templateUrl: BASE_URL + "/warranties",
                    data: {pageTitle: 'Warranty ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "WarrantiesController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/WarrantiesController.js',
                                                BASE_URL + '/assets/js/controllers/AmcController.js',
                                                BASE_URL + '/assets/js/controllers/ServiceController.js'
                                            ]
                                        });
                            }],
                        Product: 'Product'
                    }
                })
                
                .state('warranties_status', {
                    url: "/warranties",
                    templateUrl: BASE_URL + "/warranties/statusview",
                    data: {pageTitle: 'Warranty ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "WarrantiesSortController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/WarrantiesController.js',
                                                BASE_URL + '/assets/js/controllers/AmcController.js',
                                                BASE_URL + '/assets/js/controllers/ServiceController.js'
                                            ]
                                        });
                            }]
                       
                    }
                })
                
                .state('warranties_category', {
                    url: "/warranties",
                    templateUrl: BASE_URL + "/warranties/categoryview",
                    data: {pageTitle: 'Warranty ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "WarrantiesSortCatController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/WarrantiesController.js',
                                                BASE_URL + '/assets/js/controllers/AmcController.js',
                                                BASE_URL + '/assets/js/controllers/ServiceController.js'
                                            ]
                                        });
                            }]
                       
                    }
                })
                
                .state('warranties_import', {// import warraties csv file code by mehul as on 9-3-15
                    url: "/warranties_import",
                    templateUrl: BASE_URL + "/warranties/warranties_import",
                    data: {pageTitle: 'Warranties Import ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "WarrantiesController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/WarrantiesController.js'
                                    ]
                                });
                            }]
                    }
                })
                
                .state('amc', {
                    url: "/amc",
                    templateUrl: BASE_URL + "/amc",
                    data: {pageTitle: 'Amc\'s & Renewals'},
                    controller: "AmcController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/AmcController.js'
                                            ]
                                        });
                            }],
                        Amc: 'Amc'
                    }
                })
                
                .state('amc_status', {
                    url: "/amc",
                    templateUrl: BASE_URL + "/amc/statusview",
                    data: {pageTitle: 'Amc\'s & Renewals'},
                    controller: "AmcSortController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/AmcController.js'
                                            ]
                                        });
                            }],
                        Amc: 'Amc'
                    }
                })
                
                .state('amc_category', {
                    url: "/amc",
                    templateUrl: BASE_URL + "/amc/categoryview",
                    data: {pageTitle: 'Amc\'s & Renewals'},
                    controller: "AmcSortCatController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/AmcController.js'
                                            ]
                                        });
                            }],
                        Amc: 'Amc'
                    }
                })
                
                .state('service', {
                    url: "/service",
                    templateUrl: BASE_URL + "/service",
                    data: {pageTitle: 'Service Schedule'},
                    controller: "ServiceController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/ServiceController.js'
                                            ]
                                        });
                            }],
                        Service:'Service'
                        
                    }
                })
                
                .state('service_status', {
                    url: "/service",
                    templateUrl: BASE_URL + "/service/statusview",
                    data: {pageTitle: 'Service Schedule'},
                    controller: "ServiceSortController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/ServiceController.js'
                                            ]
                                        });
                            }],
                       Service:'Service'
                    }
                })
                
                .state('service_category', {
                    url: "/service",
                    templateUrl: BASE_URL + "/service/categoryview",
                    data: {pageTitle: 'Service Schedule'},
                    controller: "ServiceSortCatController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/ServiceController.js'
                                            ]
                                        });
                            }],
                       Service:'Service'
                    }
                })
                
                // LicensesApplication State define here code by mehul as on 12315
                .state('licenses', {
                    url: "/licenses",
                    templateUrl: BASE_URL + "/licenses",
                    data: {pageTitle: 'Licenses ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "LicensesController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/LicensesController.js'
                                    ]
                                });
                            }],
                        Licenses: function (LicenseFactory) {
                            return LicenseFactory.getLicenses();
                        }
                    }
                })
                
                .state('licenses_category', {
                    url: "/licenses-category",
                    templateUrl: BASE_URL + "/licenses/licenses_by_category",
                    data: {pageTitle: 'Licenses ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "LicensesCategoryController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/LicensesController.js'
                                    ]
                                });
                            }],
                        LicenseFactory: 'LicenseFactory'
                    }
                })
                
                .state('licenses_import', {// import warraties csv file code by mehul as on 9-3-15
                    url: "/licenses_import",
                    templateUrl: BASE_URL + "/licenses/licenses_import",
                    data: {pageTitle: 'Licenses ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "LicensesController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/LicensesController.js'
                                    ]
                                });
                            }]
                    }
                })
                
                .state('documents', {
                    url: "/documents",
                    templateUrl: BASE_URL + "/documents",
                    data: {pageTitle: 'documents ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "DocumentsController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load(
                                        {
                                            name: 'WarrantyistApp',
                                            insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                            files: [
                                                BASE_URL + '/assets/js/controllers/DocumentsController.js'
                                            ]
                                        });
                            }],
                        Documents: 'Documents'
                    }
                })

                .state('documents_category', {
                    url: "/documents_category",
                    templateUrl: BASE_URL + "/documents/documents_by_category",
                    data: {pageTitle: 'documents ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "DocumentsCategoryController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/DocumentsController.js'
                                    ]
                                });
                            }],
                        DocumentsFactory: function (Documents) {
                            return Documents.getDocumentsByCategory();
                        }
                    }
                })

                .state('documents_product', {
                    url: "/documents_product",
                    templateUrl: BASE_URL + "/documents/documents_by_product",
                    data: {pageTitle: 'documents ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "DocumentsProductController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/DocumentsController.js'
                                    ]
                                });
                            }],
                        DocumentsProductFactory: function (Documents) {
                            return Documents.getDocumentsByProduct();
                        }
                    }
                })
                
                .state('documents_import', {// import warraties csv file code by mehul as on 9-3-15
                    url: "/documents_import",
                    templateUrl: BASE_URL + "/documents/documents_import",
                    data: {pageTitle: 'documents ', pageSubTitle: 'ADD, UPDATE & DELETE'},
                    controller: "DocumentsController",
                    resolve: {
                        deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                                return $ocLazyLoad.load({
                                    name: 'WarrantyistApp',
                                    insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                                    files: [
                                        BASE_URL + '/assets/js/controllers/DocumentsController.js'
                                    ]
                                });
                            }]
                    }
                })
                ;
        //$locationProvider.html5Mode(true);		
    }]);

/* Datepicker controller */
WarrantyistApp.controller('DatepickerCtrl', function ($scope) {

    $scope.opened = {};
    $scope.opened.openedStart = false;
    $scope.opened.openedEnd = false;
    $scope.today = function () {
        $scope.frm.max_date = new Date();
    };
    $scope.today();

    $scope.toggleMin = function () {
        $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function ($event, pick) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened[pick] = true;
    };
    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1,
        class: 'warrentiesDate'
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
});
/*Datepicker */

/* Init global settings and run the app */
//$rootScope, $window, $route, $location, $timeout, $templateCache
WarrantyistApp.run(["$rootScope", "settings", "$state", function ($rootScope, settings, $state) {
        $rootScope.$state = $state; // state to be accessed from view
    }]);
