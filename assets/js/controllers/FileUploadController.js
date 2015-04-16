'use strict';

    WarrantyistApp.controller('AppController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: 'upload.php'
        });

        // FILTERS

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        console.info('uploader', uploader);
    }]);

//WarrantyistApp.controller('WarrantiesController', function ($rootScope, $scope, $http, Product, createDialog) {
//
//    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
//    $scope.$on('$viewContentLoaded', function () {
//        $scope.warrantiesexpired = Product.data.expired;
//        $scope.warrantiesexpiring = Product.data.expiring;
//        $scope.warrantiesactive = Product.data.active;
//    });
//    $scope.launchObjectModal = function (id) {
//        createDialog(BASE_URL + "/warranties/modal", {
//            id: 'complexDialog',
//            title: 'Product Details',
//            backdrop: true,
//            controller: 'ModalController',
//            success: {label: 'Success', fn: function () {
//                    console.log('Complex modal closed');
//                }}
//        }, {
//            myVal: id
//        });
//    };
//
//
//    $scope.addWarrantyView = function () {
//
//        createDialog(BASE_URL + "/warranties/addwarrantyview", {
//            id: 'addWarranty',
//            title: 'Add Warranty',
//            backdrop: true,
//            controller: 'AddController',
//            footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
//            //footerTemplate:'',
//            success: {label: 'Success', fn: function () {
//                    console.log('Add warranty modal closed');
//                }}
//        }
//        , {
//            myVal: 'cat'
//        }
//        );
//    };
//
//});
//WarrantyistApp.controller('ModalController', function ($rootScope, $scope, $http, $timeout, myVal) {
//    $http({
//        method: 'POST',
//        url: BASE_URL + '/warranties/productdetails',
//        data: "pid=" + myVal,
//        responseType: "JSON"
//    }).success(function (data, headers, status, config) {
//        $scope.product = data;
//    });
//});
//
//WarrantyistApp.controller('AddController', function ($scope, myVal, Category, Warranty,$http) {
//    $scope.frm = {};
//    if (myVal === 'cat')
//    {
//        $scope.category = '';
//        myVal = '';
//        Category.getcat().success(function (data) {
//            $scope.category = data;
//        });
//    }
//    $scope.proccesadd = function ()
//    {
//        //console.log( $.param($scope.frm));             
//        Warranty.addWarranty($.param($scope.frm)).success(function(data){
//        
//        });        
//    };
//    
////    $scope.proccesadd = function() {
////        var url=BASE_URL+'/warranties/addWarranty';
////  $http({
////  method  : 'POST',
////  url     : url,
////  data    : $.param($scope.frm),  // pass in data as strings
////  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
//// })
////  .success(function(data) {
////    console.log(data);  
////  });
////    };
//});


