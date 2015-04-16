'use strict';
/* License Main Controller end */
WarrantyistApp.controller('LicensesController', function ($rootScope, $scope, $http, createDialog, Licenses, LicenseFactory, $state) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;

    $scope.itemsPerPage1 = 2;
    $scope.currentPage1 = 0;

    $scope.itemsPerPage2 = 2;
    $scope.currentPage2 = 0;

    $scope.itemsPerPage3 = 2;
    $scope.currentPage3 = 0;

    $scope.licensesexpired = [];
    $scope.licensesexpiring = [];
    $scope.licensesactive = [];
    
    $scope.suggestionselected = undefined;

    $scope.$on('$viewContentLoaded', function () {
        $scope.licensesexpired = Licenses.data.expired;
        $scope.licensesexpiring = Licenses.data.expiring;
        $scope.licensesactive = Licenses.data.active;
        LicenseFactory.autosuggest().success(function (data) {
            $scope.states = data.suggest;
        });

    });




    $scope.sortitems = [
        {label: 'Status', url: 'licenses'},
        {label: 'Category', url: 'licenses_category'},
    ];
    $scope.selected = $scope.sortitems[0];
    $scope.gotoSelected = function () {
//      $state.go("form." + $scope.selected.url);
        $state.go($scope.selected.url);
    };

    /********** for expired******************/
    $scope.range1 = function () {
        var rangeSize1 = 2;
        var ret1 = [];
        var start1 = 1;

        start1 = $scope.currentPage1;
        if (start1 > $scope.pageCount1() - rangeSize1) {
            start1 = $scope.pageCount1() - rangeSize1 + 1;
        }

        for (var i = 0; i < start1 + rangeSize1; i++) {
            ret1.push(i);
        }
        return ret1;
    };
    $scope.prevPage1 = function () {
        if ($scope.currentPage1 > 0) {
            $scope.currentPage1--;
        }
    };
    $scope.prevPageDisabled1 = function () {
        return $scope.currentPage1 === 0 ? "disabled" : "";
    };
    $scope.pageCount1 = function () {
        return Math.ceil($scope.licensesexpired.length / $scope.itemsPerPage1) - 1;
    };
    $scope.nextPage1 = function () {
        if ($scope.currentPage1 < $scope.pageCount1()) {
            $scope.currentPage1++;
        }
    };
    $scope.nextPageDisabled1 = function () {
        return $scope.currentPage1 === $scope.pageCount1() ? "disabled" : "";
    };
    $scope.setPage1 = function (aa) {
        $scope.currentPage1 = aa;
    };
    /********** for Expiring******************/
    $scope.range2 = function () {
        var rangeSize = 2;
        var ret = [];
        var start = 1;

        start = $scope.currentPage2;
        if (start > $scope.pageCount2() - rangeSize) {
            start = $scope.pageCount2() - rangeSize + 1;
        }

        for (var i = 0; i < start + rangeSize; i++) {
            ret.push(i);
        }
        return ret;
    };
    $scope.prevPage2 = function () {
        if ($scope.currentPage2 > 0) {
            $scope.currentPage2--;
        }
    };
    $scope.prevPageDisabled2 = function () {
        return $scope.currentPage2 === 0 ? "disabled" : "";
    };
    $scope.pageCount2 = function () {
        return Math.ceil($scope.licensesexpiring.length / $scope.itemsPerPage2) - 1;
    };
    $scope.nextPage2 = function () {
        if ($scope.currentPage2 < $scope.pageCount2()) {
            $scope.currentPage2++;
        }
    };
    $scope.nextPageDisabled2 = function () {
        return $scope.currentPage2 === $scope.pageCount2() ? "disabled" : "";
    };
    $scope.setPage2 = function (n) {
        $scope.currentPage2 = n;
    };
    /********** for Active******************/
    $scope.range3 = function () {
        var rangeSize = 2;
        var ret = [];
        var start = 1;

        start = $scope.currentPage3;
        if (start > $scope.pageCount3() - rangeSize) {
            start = $scope.pageCount3() - rangeSize + 1;
        }

        for (var i = 0; i < start + rangeSize; i++) {
            ret.push(i);
        }
        return ret;
    };
    $scope.prevPage3 = function () {
        if ($scope.currentPage3 > 0) {
            $scope.currentPage3--;
        }
    };
    $scope.prevPageDisabled3 = function () {
        return $scope.currentPage3 === 0 ? "disabled" : "";
    };
    $scope.pageCount3 = function () {
        return Math.ceil($scope.licensesactive.length / $scope.itemsPerPage3) - 1;
    };
    $scope.nextPage3 = function () {
        if ($scope.currentPage3 < $scope.pageCount3()) {
            $scope.currentPage3++;
        }
    };
    $scope.nextPageDisabled3 = function () {
        return $scope.currentPage3 === $scope.pageCount3() ? "disabled" : "";
    };
    $scope.setPage3 = function (n) {
        $scope.currentPage3 = n;
    };
    /****************pagination ends here****************/



    $scope.launchObjectModal = function (id) {
        createDialog(BASE_URL + "/licenses/licensedetailsview", {
            id: 'ViewcomplexDialog',
            title: 'License Details',
            backdrop: true,
            controller: 'LicenseActionController',
            footerTemplate: false,
            success: {label: 'Success', fn: function () {
                    console.log('Complex modal closed');
                }}
        }, {
            myVal: id,
            Edit: ''
        });
    };

    $scope.launchAddLicenseObjectModal = function () {
        //alert('i m caling');
        createDialog(BASE_URL + "/licenses/addlicenseview", {
            id: 'AddLicense',
            title: 'Add License',
            backdrop: true,
//            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            footerTemplate: false,
            controller: 'LicensesAddController',
            success: {label: 'Success', fn: function () {
                    console.log('Add License Model Closed');
                }},
            resolve: {FileUploader: function () {
                    return $scope;
                }}

        }, {
            myVal: 'cat',
            Edit: ''
        });
    };

    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
            //alert('single select ' + id);
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
        }
        angular.forEach($scope.licensesexpired, function (row, key) {
            $scope.chckedIndexs.push($scope.licensesexpired[key].id);
            row.checked = $scope.selectedAll;
        });
        angular.forEach($scope.licensesexpiring, function (row, key) {
            $scope.chckedIndexs.push($scope.licensesexpiring[key].id);
            row.checked = $scope.selectedAll;
        });
        angular.forEach($scope.licensesactive, function (row, key) {
            $scope.chckedIndexs.push($scope.licensesactive[key].id);
            row.checked = $scope.selectedAll;
        });
    };
    $scope.delete_licenses = function ()
    {
        //alert('alsdjfklajlk');
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Do you like to Delete Selected License(s)?   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'Delete!',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">Delete</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    console.log($scope.chckedIndexs);
                    LicenseFactory.deletemultiple($scope.chckedIndexs).success(function (data) {
                        //$scope.$modalClose();
                        $state.reload();
                    });
                    //$scope.$modalClose();
                }}

        }, {
            myVal: ''
        });

    };
});
/* License Main Controller end */
/* License Category Controller end */
WarrantyistApp.controller('LicensesCategoryController', function ($rootScope, $scope, $http, createDialog, LicenseFactory, $state) {
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;

    $scope.$on('$viewContentLoaded', function () {
        LicenseFactory.getLicensesByCategory().success(function (data) {
            $scope.getlicensesbycategory = data;
        });

    });

    $scope.sortitems = [
        {label: 'Status', url: 'licenses'},
        {label: 'Category', url: 'licenses_category'},
    ];
    $scope.selected = $scope.sortitems[1];
    $scope.gotoSelected = function () {
//      $state.go("form." + $scope.selected.url);
        $state.go($scope.selected.url);
    };
    $scope.launchObjectModal = function (id) {
        createDialog(BASE_URL + "/licenses/licensedetailsview", {
            id: 'ViewcomplexDialog',
            title: 'License Details',
            backdrop: true,
            controller: 'LicenseActionController',
            footerTemplate: false,
            success: {label: 'Success', fn: function () {
                    console.log('Complex modal closed');
                }}
        }, {
            myVal: id,
            Edit: ''
        });
    };
    $scope.launchAddLicenseObjectModal = function () {
        //alert('i m caling');
        createDialog(BASE_URL + "/licenses/addlicenseview", {
            id: 'AddLicense',
            title: 'Add License',
            backdrop: true,
            footerTemplate: false,
            controller: 'LicensesAddController',
            success: {label: 'Success', fn: function () {
                    console.log('Add License Model Closed');
                }},
            resolve: {FileUploader: function () {
                    return $scope;
                }}

        }, {
            myVal: 'cat',
            Edit: ''
        });
    };

    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        if ($scope.chckedIndexs.indexOf(id) === -1) {
            alert('single select ' + id);
            $scope.chckedIndexs.push(id);
        }
        else {
            $scope.chckedIndexs.splice($scope.chckedIndexs.indexOf(id), 1);
        }
    };
    $scope.checkAll = function () {

        if ($scope.selectedAll) {
            $scope.selectedAll = true;
            //alert('selectedAll set tp true');
        } else {
            $scope.selectedAll = false;
        }
        angular.forEach($scope.getlicensesbycategory, function (row, key) {
            $scope.chckedIndexs.push($scope.getlicensesbycategory[key].id);
            row.checked = $scope.selectedAll;
        });
    };
    $scope.delete_licenses = function ()
    {
        //alert('alsdjfklajlk');
        createDialog({
            id: 'confirmdelete',
            template: angular.element(
                    '<div class="row-fluid">' +
                    ' <div>' +
                    '   <div class="codebox">' +
                    '    Do you like to Delete Selected License(s)?   ' +
                    '   </div>\n' +
                    ' </div>\n' +
                    '</div>'),
            title: 'Delete!',
            backdrop: true,
            footerTemplate: false,
            success: {label: 'Save', fn: function () {

                    LicenseFactory.deletemultiple($scope.chckedIndexs).success(function (data) {
                        $scope.$modalClose();
                        $state.reload();
                        console.log(data);
                    });
                    //$scope.$modalClose();
                }}
        }, {
            myVal: ''
        });

    };
});
/* License Main Controller end */

/* License Action Controller start */
WarrantyistApp.controller('LicenseActionController', function ($scope, $http, $timeout, myVal, createDialog, LicenseFactory, $state) {

    if (myVal !== '')
    {
        $http({
            method: 'POST',
            url: BASE_URL + '/licenses/license_details',
            data: "id=" + myVal,
            responseType: "JSON"
        }).success(function (data, headers, status, config) {
            $scope.binddata = data;
        });
    }
    $scope.proccesdelete = function (pid)
    {
        // alert(pid);
        LicenseFactory.deleteLicense(pid).success(function () {
            $scope.$modalClose();
            $state.reload();
        });
    };

//    $scope.procces_multiple_delete = function (pids)
//    {
//        // alert(pid);
//        LicenseFactory.deleteMultipleLicense(pids).success(function () {
//            $scope.$modalClose();
//            $state.reload();
//        });
//    };


    $scope.editLicenseView = function (pid) {
        //alert(pid);
        $scope.$modalClose();
        createDialog(BASE_URL + "/licenses/editlicenseview", {
            id: 'EditLicense',
            title: 'Edit License',
            backdrop: true,
            controller: 'LicensesAddController',
            //footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            footerTemplate: false,
            success: {label: 'Success', fn: function () {
                    console.log('Edit License modal closed');
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

    $scope.editRenewalView = function (pid) {
        //alert(pid);
        $scope.$modalClose();
        createDialog(BASE_URL + "/licenses/editrenewallicenseview", {
            id: 'EditRenewalLicense',
            title: 'Renewal License',
            backdrop: true,
            controller: 'LicensesAddController',
            //footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            footerTemplate: false,
            success: {label: 'Success', fn: function () {
                    console.log('Edit License modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }
            }
        }
        , {
            myVal: '',
            Edit: pid

        }
        );
    };

});
/* License Action Controller end */

/* License Add Controller Start */
WarrantyistApp.controller('LicensesAddController', function ($scope, $state, $rootScope, Edit, myVal, FileUploader, createDialog, LicenseFactory) {
    $scope.formData = {};
    $scope.isError = false;
    $scope.isErrorpur = false;

    if (myVal === 'cat')
    {
        $scope.category = '';
        myVal = '';
        LicenseFactory.getcat().success(function (data) {
            $scope.category = data;
        });
    }
    if (Edit !== '')
    {
        myVal = '';
        LicenseFactory.getproductedit(Edit).success(function (data) {
            console.log(" my data comes fr : " + data);
            $scope.formData = data;
        });
    }

    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/licenses/uploadimage'
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
        $scope.formData.image_url = addedFileItems[0].file.name;
        uploader.uploadAll();
    };
    $scope.proccesadd = function ()
    {
        LicenseFactory.addLicense($.param($scope.formData)).success(function (data) {
            $scope.$modalClose();
            $state.reload();
        });
    };
    $scope.proccesedit = function ()
    {
        LicenseFactory.editLicense($.param($scope.formData)).success(function (data) {
            $scope.$modalClose();
            $state.reload();
        });
    };
    $scope.proccesrenewaledit = function ()
    {
        LicenseFactory.editRenewalLicense($.param($scope.formData)).success(function (data) {
            $scope.message = data.message;
            // $scope.$modalClose();
            // $state.reload();
        });
    };

    /* $scope.savewarranty_ser = function ()
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
     title: 'You like to save warranty?',
     backdrop: true,
     footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
     success: {label: 'Save', fn: function () {
     $scope.proccesadd();
     $scope.$modalClose();
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
     title: 'You like to save warranty?',
     backdrop: true,
     footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
     success: {label: 'Save', fn: function () {
     $scope.proccesadd();
     $scope.$modalClose();
     }}
     });
     };*/
});
/* License Add Controller end */
