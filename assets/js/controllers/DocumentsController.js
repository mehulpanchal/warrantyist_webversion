'use strict';

WarrantyistApp.controller('DocumentsController', function ($rootScope, $state, $scope, $http, Documents, createDialog) { 
    
    $rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.itemsPerPage1 = 2;
    $scope.currentPage1 = 0;
   
    $scope.$on('$viewContentLoaded', function () {
        Documents.getDocumentWarranty().success(function(data){
        $scope.valueNew = data;
        //console.log("hgschge",$scope.valueNew);
/*
                $scope.newValueNew = [];
                $scope.newPassport = [];
                $scope.newp = [];

            angular.forEach($scope.valueNew, function (ab, keyab) {
                console.log("keyab::",keyab);
                console.log("ab::",ab);

                

                    angular.forEach(ab, function (a, key) {    
                        console.log("keyab::",keyab);
                        console.log("cat_name::",ab[key].cat_name);
                    if(keyab === ab[key].cat_name )       
                    {
                         $scope.newp.push(ab[key]);
                    }
                       $scope.newValueNew.push(ab[key]);
                       // a.checked = $scope.selectedAll;
                       if(ab[key].category == 20){
                            $scope.newPassport.push(ab[key]);
                       }
                       //console.log(keyab);
                    });
                   
//console.log($scope.newp);
                });
            */
 //console.log("newValueNew is::",$scope.newValueNew); 
        });
   
    });

    $scope.sortitems = [
        {label: 'Category', url: 'documents'},
        {label: 'Status', url: 'documents_category'},
        {label: 'Product', url: 'documents_product'},
    ];
    $scope.selected = $scope.sortitems[0];
    $scope.gotoSelected = function () {
//      $state.go("form." + $scope.selected.url);
        $state.go($scope.selected.url);
    };

    $scope.sortby = function(sortval) {
    
        if(sortval == "status"){
            alert("Inside status");
        }else if(sortval == "product"){
            alert("Inside product");
        }else{
            alert("Inside else");
        }

    }

    /****************pagination starts here****************/
    
    /*$scope.range1 = function () {
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
        return Math.ceil($scope.newPassport.length / $scope.itemsPerPage1) - 1;
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
    };*/
   
    /****************pagination ends here****************/

    //delete code starts 
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
        }
       
        $scope.b =[];
        angular.forEach($scope.valueNew, function (ab, keyab) {
            angular.forEach(ab, function (a, key) {                      
               $scope.chckedIndexs.push(ab[key].doc_id);
                a.checked = $scope.selectedAll;
            });
        });
       
        /*$scope.b=$scope.valueNew.Passport;
        angular.forEach($scope.b, function (a, key) {
                      
            $scope.chckedIndexs.push($scope.b[key].doc_id);
            a.checked = $scope.selectedAll;
        });*/

       
    };

    $scope.deleteLandingdoc = function ()
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
            title: 'You you like to delete documents?',
            backdrop: true,
            controller: 'DocAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    Documents.deleteDoc($scope.chckedIndexs).success(function (data) {
                        console.log(data);
                    });
                    $state.reload();
                }}

        }, {
            myVal: ''
        });

    };

    $scope.addDocumentView = function () {
        createDialog(BASE_URL + "/documents/adddocumentview", {
            id: 'addDocument',
            title: 'Add Document',
            backdrop: true,
            controller: 'AddDocController',
            //footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add document modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
    }
    , {
        myVal: 'cat',
        Edit:''
    }
    );
    };


    $scope.docViewDetails = function (id) {
        createDialog(BASE_URL + "/documents/docviewdetails", {
            id: 'documentdetails',
            title: 'Document Details',
            backdrop: true,
            controller: 'DocAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                 //   console.log('Document modal closed');
                }}
        }, {
            myVal: id
        });
    };


});

/*controller for select option category-starts*/
WarrantyistApp.controller('DocumentsCategoryController', function ($rootScope, $scope, $http, createDialog,DocumentsFactory, Documents, $state) {


$rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.itemsPerPage1 = 2;
    $scope.currentPage1 = 0;

    $scope.itemsPerPage2 = 2;
    $scope.currentPage2 = 0;

    $scope.itemsPerPage3 = 2;
    $scope.currentPage3 = 0;

    $scope.documentsexpired = [];
    $scope.documentsexpiring = [];
    $scope.documentsactive = [];

    $scope.$on('$viewContentLoaded', function () {
       // Documents.getDocumentsByCategory().success(function (data) {
         //   $scope.getdocumentsdydategory = data;
        $scope.documentsexpired = DocumentsFactory.data.expired;
        $scope.documentsexpiring = DocumentsFactory.data.expiring;
        $scope.documentsactive = DocumentsFactory.data.active;
        

        //});

    });

    $scope.sortitems = [
       
        {label: 'Category', url: 'documents'},
        {label: 'Status', url: 'documents_category'},
        {label: 'Product', url: 'documents_product'},
    ];
    $scope.selected = $scope.sortitems[1];
    $scope.gotoSelected = function () {
//      $state.go("form." + $scope.selected.url);
        $state.go($scope.selected.url);
    };

    //delete all for stats
    $scope.chckedIndexsStatus = [];
    $scope.checkedvaluesStatus = function (id) {
      // console.log("ID:::"+id);
        if ($scope.chckedIndexsStatus.indexOf(id) === -1) {
           // alert('single select ' + id);
            $scope.chckedIndexsStatus.push(id);
        }
        else {
           // alert('else select ' + id);
            $scope.chckedIndexsStatus.splice($scope.chckedIndexsStatus.indexOf(id), 1);
        }
    };
    $scope.checkAllStatus = function () {
 //console.log("HERE :::");
        if ($scope.selectedAllStatus) {

            $scope.selectedAllStatus = true;

        } else {
            $scope.selectedAllStatus = false;
        }
        //console.log("ljytg::",$scope.documentsexpired);
        angular.forEach($scope.documentsexpired, function (row, key) {
            $scope.chckedIndexsStatus.push($scope.documentsexpired[key].doc_id);
            row.checkedStatus = $scope.selectedAllStatus;
        });
        angular.forEach($scope.documentsexpiring, function (row, key) {
            $scope.chckedIndexsStatus.push($scope.documentsexpiring[key].doc_id);
            row.checkedStatus = $scope.selectedAllStatus;
        });
        angular.forEach($scope.documentsactive, function (row, key) {
            $scope.chckedIndexsStatus.push($scope.documentsactive[key].doc_id);
            row.checkedStatus = $scope.selectedAllStatus;
        });
    };


    $scope.deleteLandingdocStatus = function ()
    {
         //console.log("HERE ID:::");
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
            title: 'You you like to delete documents?',
            backdrop: true,
            controller: 'DocAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
               // console.log($scope.chckedIndexsStatus);
                    Documents.deleteDoc($scope.chckedIndexsStatus).success(function (data) {
                        $state.reload();
                        console.log(data);
                    });
                    
                }}

        }, {
            myVal: ''
        });

    };
   
    /****************pagination starts here****************/
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
        return Math.ceil($scope.documentsexpired.length / $scope.itemsPerPage1) - 1;
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
        return Math.ceil($scope.documentsexpiring.length / $scope.itemsPerPage2) - 1;
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
        return Math.ceil($scope.documentsactive.length / $scope.itemsPerPage3) - 1;
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

    $scope.docViewDetails = function (id) {
        createDialog(BASE_URL + "/documents/docviewdetails", {
            id: 'documentdetails',
            title: 'Document Details',
            backdrop: true,
            controller: 'DocAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                 //   console.log('Document modal closed');
                }}
        }, {
            myVal: id
        });
    };

    $scope.addDocumentView = function () {
        createDialog(BASE_URL + "/documents/adddocumentview", {
            id: 'addDocument',
            title: 'Add Document',
            backdrop: true,
            controller: 'AddDocController',
            //footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add document modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
    }
    , {
        myVal: 'cat',
        Edit:''
    }
    );
    };


});
/*controller for select option category-ends */
/*controller for select option product-starts*/
WarrantyistApp.controller('DocumentsProductController', function ($rootScope, $scope, $http, createDialog,DocumentsProductFactory, Documents, $state) {


$rootScope.settings.layout.pageAutoScrollOnLoad = 1500;
    $scope.itemsPerPage1 = 5;
    $scope.currentPage1 = 0;

     $scope.$on('$viewContentLoaded', function () {
       // Documents.getDocumentWarranty().success(function(data){ 
        Documents.getDocumentsByProduct().success(function(data){ 
        $scope.documentsProduct = DocumentsProductFactory.data;
        });
   
    });

    $scope.sortitems = [
        
        {label: 'Category', url: 'documents'},
        {label: 'Status', url: 'documents_category'},
        {label: 'Product', url: 'documents_product'},
    ];
    $scope.selected = $scope.sortitems[2];
    $scope.gotoSelected = function () {
//      $state.go("form." + $scope.selected.url);
        $state.go($scope.selected.url);
    };

   //delete all for stats
    $scope.chckedIndexsStatus = [];
    $scope.checkedvaluesStatus = function (id) {
        if ($scope.chckedIndexsStatus.indexOf(id) === -1) {
            $scope.chckedIndexsStatus.push(id);
        }
        else {
            $scope.chckedIndexsStatus.splice($scope.chckedIndexsStatus.indexOf(id), 1);
        }
    };
    $scope.checkAllStatus = function () {
        if ($scope.selectedAllStatus) {
            $scope.selectedAllStatus = true;
        } else {
            $scope.selectedAllStatus = false;
        }
        angular.forEach($scope.documentsProduct, function (row, key) {
            $scope.chckedIndexsStatus.push($scope.documentsProduct[key].doc_id);
            row.checkedStatus = $scope.selectedAllStatus;
        });
       
    };


    $scope.deleteLandingdocStatus = function ()
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
            title: 'You you like to delete documents?',
            backdrop: true,
            controller: 'DocAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
               // console.log($scope.chckedIndexsStatus);
                    Documents.deleteDoc($scope.chckedIndexsStatus).success(function (data) {
                        $state.reload();
                        console.log(data);
                    });
                    
                }}

        }, {
            myVal: ''
        });

    };
    //delete End    

    /****************pagination starts here****************/
    
    $scope.range1 = function () {
        var rangeSize1 = 5;
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
        return Math.ceil($scope.documentsProduct.length / $scope.itemsPerPage1) - 1;
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
   
    /****************pagination ends here****************/

    $scope.docViewDetails = function (id) {
        createDialog(BASE_URL + "/documents/docviewdetails", {
            id: 'documentdetails',
            title: 'Document Details',
            backdrop: true,
            controller: 'DocAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                 //   console.log('Document modal closed');
                }}
        }, {
            myVal: id
        });
    };

    $scope.addDocumentView = function () {
        createDialog(BASE_URL + "/documents/adddocumentview", {
            id: 'addDocument',
            title: 'Add Document',
            backdrop: true,
            controller: 'AddDocController',
            //footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            //footerTemplate:'',
            success: {label: 'Success', fn: function () {
                    console.log('Add document modal closed');
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }}
    }
    , {
        myVal: 'cat',
        Edit:''
    }
    );
    };


});
/*controller for select option product-ends */

WarrantyistApp.controller('DocAddController', function ($scope,  $http, myVal, Documents, createDialog, $state) {
    $scope.frm = {};
   
   if(myVal !== '')
    {       
        console.log(myVal);
        $http({
            method: 'POST',
            url: BASE_URL + '/documents/documentdetails',
            data: "doc_id=" + myVal,
            responseType: "JSON"
        }).success(function (data, headers, status, config) {
            $scope.doc = data;
        });
    }

   /* $scope.docdelete = function (pid)
    {                     
        Documents.deleteDoc(pid).success(function () {
            $scope.$modalClose();                
            $state.reload();
        });
    };*/

    $scope.docdelete = function (pid)
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
            title: 'You like to delete documents?',
            backdrop: true,
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    Documents.deleteDoc(pid).success(function (data) {
                        $scope.$modalClose();
                        $state.reload();

                    });
                }}

        });

    };

    $scope.editDocumentView = function (did) {
        
        $scope.$modalClose();     
        createDialog(BASE_URL + "/documents/editDocumentView", {
            id: 'editDocument',
            title: 'Edit Document',
            backdrop: true,
            controller: 'AddDocController',
            //footerTemplate: '<button type="submit" class="btn btn-primary">Save</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',            
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',            
            success: {label: 'Success', fn: function () {
                    console.log('Edit document modal closed');                   
                }}
            ,
            resolve: {FileUploader: function () {
                    return $scope;
                }
            }
        }
        , {
            myVal: 'cat',
            Edit : did
            
        }
        );
    };

  
});

WarrantyistApp.controller('AddDocController', function ($scope,$state,$rootScope,Edit, myVal, Documents, FileUploader, createDialog) {
       
    $scope.frm = {};   
    $scope.isError = false;
    $scope.isErrorpur = false;
    
     if (myVal === 'cat')
    {
        $scope.category = '';
        myVal = '';
        Documents.getDocCat().success(function (data) {
            $scope.category = data;
        });
    }
    if(Edit !== '')
    {       
        myVal = '';
        Documents.getdocumentedit(Edit).success(function (data) {    

            $scope.frm = data;
             console.log($scope.frm);
        });
    }
    
    $scope.editDoc = function ()
    {                
        Documents.editDocument($.param($scope.frm)).success(function (data) {
            $scope.$modalClose();                
            $state.reload();
        });
    };
    $scope.documentadd = function ()
    {                
        Documents.addDocument($.param($scope.frm)).success(function (data) {
            $scope.$modalClose();                
            $state.reload();
        });
    };

    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/documents/uploadimage'
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
        url: BASE_URL + '/documents/uploadimage'
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

});
