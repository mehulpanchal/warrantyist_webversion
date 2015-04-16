'use strict';

WarrantyistApp.controller('WarrantiesController', function ($rootScope, $scope, $state, $timeout, Product, createDialog, Warranty) {

    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;


//    $scope.$on('$viewContentLoaded', function () {
//        Product.getWarranty().success(function(data){
//        $scope.warrantiesexpired = data.expired;
//        $scope.warrantiesexpiring = data.expiring;
//        $scope.warrantiesactive = data.active;
//        });  
//    });
    $scope.$on('$viewContentLoaded', function () {
        Product.getWarranty().success(function (data) {
            $scope.warranties = data;
        });
    });   
    $rootScope.launchObjectModal = function (id) {
        createDialog(BASE_URL + "/warranties/productdetailsview", {
            id: 'productdetails',
            title: 'Product Details',
            backdrop: true,
            controller: 'ProductController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Product modal closed');
                }}
        }, {
            myVal: id
        });
    };

    $rootScope.addWarrantyView = function () {

        createDialog(BASE_URL + "/warranties/addwarrantyview", {
            id: 'addWarranty',
            title: 'Add Warranty',
            backdrop: true,
            controller: 'AddController',
            footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add warranty modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            myVal: 'cat',
            Edit: ''
        }
        );
    };
    $rootScope.sortby = function (a)
    {
        //console.log(a);
        $state.go("warranties_" + a);
    };


    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
            $scope.chckedIndexs.push(id);
        }
        else {
            $scope.chckedIndexs.splice($scope.chckedIndexs.indexOf(id), 1);
        }
    };
    $scope.checkAll = function () {
        if ($scope.selectedAll) {
            $scope.selectedAll = true;
        } else {
            $scope.selectedAll = false;
            $scope.chckedIndexs.length = 0;
        }
        angular.forEach($scope.warranties, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.warranties[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
    };
    $scope.deletewarranties = function ()
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Warranty?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    console.log($scope.chckedIndexs);

                    Warranty.deleteWarranty($scope.chckedIndexs).then(function () {
                    }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                }}

        });

    };
    

});

WarrantyistApp.controller('ProductController', function ($scope, $timeout, myVal, createDialog, Warranty, $state, Product) {

    if (myVal !== '')
    {
        Product.getproductdetails(myVal).success(function (data) {
            $scope.product = data.product;
            $scope.services = data.services;
            $scope.amc = data.amc;
        });

    }
    $scope.proccesdelete = function (pid)
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Warranty?',
            backdrop: true,
            controller: 'ProductController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    Warranty.deleteWarranty(pid).then(function () {
                    }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                }}

        }, {
            myVal: '',
            Wrty_Id: '',
            Edit: ''

        });

    };

    $scope.editWarrantyView = function (pid) {

        $scope.$modalClose();
        createDialog(BASE_URL + "/warranties/editWarrantyView", {
            id: 'editWarranty',
            title: 'Edit Warranty',
            backdrop: true,
            controller: 'AddController',
            footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Edit warranty modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }
            }
        }
        , {
            myVal: 'cat',
            Edit: pid

        }
        );
    };

    $scope.openamc = function (pid)
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/amc/addAmcView", {
            id: 'addAmc',
            title: 'Add Amc',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add Amc modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            Wrty_Id: pid,
            myVal: 'cat',
            Edit: ''

        }
        );
    };
    $scope.openservice = function (pid)
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/service/addServiceView", {
            id: 'addservice',
            title: 'Add Service Schedule',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add Service modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            myVal: 'cat',
            Wrty_Id: pid,
            Edit: ''
        }
        );
    };

    $scope.editamc = function (pid)
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/amc/editAmcView", {
            id: 'editAmc',
            title: 'Edit Amc',
            backdrop: true,
            controller: 'AmcEditController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Edit amc modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }
            }
        },
        {
            myVal: 'cat',
            Edit: pid,
            Wrty_Id: ''
        }
        );
    };
    $scope.editservice = function (pid)
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/service/editServiceView", {
            id: 'editservice',
            title: 'Edit Service Schedule',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Add Service modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            myVal: 'cat',
            Wrty_Id: '',
            Edit: pid
        }
        );
    };

});
WarrantyistApp.controller('AddController', function ($scope, $state, Edit, myVal, Category, Warranty, FileUploader, createDialog, Product, Amc) {

    $scope.frm = {};
    $scope.isError = false;
    $scope.isErrorpur = false;

    if (myVal === 'cat')
    {
        $scope.category = '';
        myVal = '';
        Category.getcat().success(function (data) {
            $scope.category = data;
        });
    }
    if (Edit !== '')
    {
        myVal = '';
        Product.getproductedit(Edit).success(function (data) {
            $scope.frm = data;
        });
    }

    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/warranties/uploadimage'
    });

    uploader.filters.push({
        name: 'imageFilter',
        fn: function (item /*{File|FileLikeObject}*/, options) {

            var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
            var typeofindex = '|jpg|png|jpeg|bmp|gif|'.indexOf(type);

            if (typeofindex !== -1)
                $scope.isError = false;
            else
                $scope.isError = true;

            return typeofindex !== -1;
        }
    });

    uploader.onAfterAddingAll = function (addedFileItems) {
        $scope.frm.warranty_card = addedFileItems[0].file.name;
        uploader.uploadAll();
    };
    var pur_uploader = $scope.pur_uploader = new FileUploader({
        url: BASE_URL + '/warranties/uploadimage'
    });
    pur_uploader.filters.push({
        name: 'imageFilter',
        fn: function (item /*{File|FileLikeObject}*/, options) {

            var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
            var typeofindex = '|jpg|png|jpeg|bmp|gif|'.indexOf(type);

            if (typeofindex !== -1)
                $scope.isErrorpur = false;
            else
                $scope.isErrorpur = true;

            return typeofindex !== -1;
        }
    });
    pur_uploader.onAfterAddingAll = function (addedFileItems) {
        //console.log(addedFileItems);
        $scope.frm.purchase_invoice = addedFileItems[0].file.name;
        pur_uploader.uploadAll();
    };
    $scope.proccesadd = function ()
    {
        Warranty.addWarranty($.param($scope.frm)).success(function (data) {
            $scope.$modalClose();
            $state.reload();
        });
    };
    $scope.proccesaddamcwty = function ()
    {
        Warranty.addWarranty($.param($scope.frm)).success(function (data) {
            console.log(data);
            $scope.warranty_idamc = data;
            $scope.openamc();
        });
    };
    $scope.proccesaddservicewty = function ()
    {
        Warranty.addWarranty($.param($scope.frm)).success(function (data) {
            console.log(data);
            $scope.warranty_idservice = data;
            $scope.openservice();
        });
    };
    $scope.proccesedit = function ()
    {
        Warranty.editWarranty($.param($scope.frm)).success(function (data) {
            $scope.$modalClose();
            $state.reload();
        });
    };

    $scope.savewarranty_ser = function ()
    {
        createDialog({
            id: 'confirmaddser',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to save warranty?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    $scope.proccesaddservicewty();
                }}
        });
    };
    $scope.savewarranty_amc = function ()
    {
        createDialog({
            id: 'confirmaddamc',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to save warranty?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    $scope.proccesaddamcwty();
                }}
        });
    };
    $scope.openamc = function ()
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/amc/addAmcView", {
            id: 'addAmc',
            title: 'Add Amc',
            backdrop: true,
            controller: 'AmcAddController',
            footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add Amc modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            Wrty_Id: $scope.warranty_idamc,
            myVal: 'cat',
            Edit: ''

        }
        );
    };
    $scope.openservice = function ()
    {
        $scope.$modalClose();
        createDialog(BASE_URL + "/service/addServiceView", {
            id: 'addservice',
            title: 'Add Service Schedule',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add Service modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
        }
        , {
            myVal: 'cat',
            Wrty_Id: $scope.warranty_idservice,
            Edit: ''
        }
        );
    };
});

WarrantyistApp.controller('WarrantiesSortController', function ($scope, $state, Warranty, createDialog,$timeout) {

    $scope.$on('$viewContentLoaded', function () {
        $scope.sortval = 'status';
        Warranty.statussort().success(function (data) {
            $scope.warrantiesexpired = data.expired;
            $scope.warrantiesexpiring = data.expiring;
            $scope.warrantiesactive = data.active;
        });
    });
    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
            $scope.chckedIndexs.push(id);
        }
        else {
            $scope.chckedIndexs.splice($scope.chckedIndexs.indexOf(id), 1);
        }
    };
    $scope.checkAll = function () {
        if ($scope.selectedAll) {
            $scope.selectedAll = true;
        } else {
            $scope.selectedAll = false;
            $scope.chckedIndexs.length = 0;
        }
        angular.forEach($scope.warrantiesexpired, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.warrantiesexpired[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
        angular.forEach($scope.warrantiesexpiring, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.warrantiesexpiring[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
        angular.forEach($scope.warrantiesactive, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.warrantiesactive[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
    };
        $scope.deletewarranties = function ()
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Warranty?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {                    
                    if($scope.chckedIndexs.length !== 0)
                     {
                        Warranty.deleteWarranty($scope.chckedIndexs).then(function () {
                        }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }                    
                }}
                
        });

    };
    
});

WarrantyistApp.controller('WarrantiesSortCatController', function ($scope, $state, Warranty, createDialog,$timeout) {
    $scope.$on('$viewContentLoaded', function () {
        $scope.sortval = 'category';
        Warranty.categorysort().success(function (data) {
            $scope.warrantiescat = data;
        });
    });
    $scope.deletewarranties = function ()
    {
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Please confirm   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'You you like to delete Warranty?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () { 
                    console.log($scope.chckedIndexs.length);
                     if($scope.chckedIndexs.length != 0)
                     {
                        Warranty.deleteWarranty($scope.chckedIndexs).then(function () {
                        }).then(function () {
                        return $timeout(function () {
                            $scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }
                }}
        });
    };
    
    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
            $scope.chckedIndexs.push(id);
        }
        else {
            $scope.chckedIndexs.splice($scope.chckedIndexs.indexOf(id), 1);
        }
    };
    $scope.checkAll = function () {
        if ($scope.selectedAll) {
            $scope.selectedAll = true;
        } else {
            $scope.selectedAll = false;
            $scope.chckedIndexs.length = 0;
        }

        angular.forEach($scope.warrantiescat, function (ab, keyab) {
            angular.forEach(ab, function (pr, key) {
                $scope.chckedIndexs.push(ab[key].product_id);
                pr.checked = $scope.selectedAll;
            });
        });
    };

    
});


