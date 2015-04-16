WarrantyistApp.controller('ServiceController', function (Service, $scope,$rootScope, $state, createDialog) {

    $scope.$on('$viewContentLoaded', function () {
        Service.getService().success(function (data) {
            $scope.services = data;
        });
    });
    $scope.chckedIndexs = [];
    $scope.checkedvalues = function (id) {
        $scope.selectedAll = false;
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
        angular.forEach($scope.services, function (a, key) {
            $scope.chckedIndexs.push($scope.services[key].service_id);
            a.checked = $scope.selectedAll;
        });
    };
    $scope.deleteservice = function ()
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
            title: 'You you like to delete Service?',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    Service.deleteservices($scope.chckedIndexs).success(function (data) {
                        console.log(data);
                    });
                    $state.reload();
                }}

        }, {
            myVal: '',
            Wrty_Id: '',
            Edit: ''
            
        });

    };
    
    $rootScope.serviceviewdetails = function (id) {
        
        createDialog(BASE_URL + "/service/serviceviewdetails", {
            id: 'servicedetails',
            title: 'Service Schedule Details',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Success', fn: function () {
                    console.log('Service modal closed');
                }}
        } , {
            myVal: '',
            Wrty_Id: '',
            Edit: id
        });
    };
    $rootScope.addServiceView = function ()
    {
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
            Wrty_Id: '',
            Edit: ''
        }
        );
    };    
    $rootScope.sortby = function (a)
    {
        //console.log(a);
        $state.go("service_" + a);
    };

});

WarrantyistApp.controller('ServiceAddController', function ($scope,$state, myVal, Wrty_Id, Edit, Category, Service, FileUploader,createDialog) {
        
    $scope.frm = {};   
    $scope.frm.reminder = 0;     
    $scope.frm.items = [{
          start_date: ''
      }];
    $scope.frm.s_images = [];
    if (myVal === 'cat')
    {
        Category.getservicecat().success(function (data) {
            $scope.category = data;
        });
    }
    if (Edit !== '')
    {
        Service.geteditService(Edit).success(function (data) {
            $scope.frm = data;                        
            $scope.frm.old_items = data.com;
            $scope.frm.items = [{
            start_date: ''
            }];
            $scope.frm.deletedtid=[];
        });
    }
    if(Wrty_Id !== '')
    {
        Service.bindService(Wrty_Id).success(function (data) {
           // console.log(data);
            $scope.frm = data; 
            $scope.frm.reminder = 0;     
            $scope.frm.items = [{
            start_date: ''
            }];
            $scope.frm.s_images = [];
        });
    }
    $scope.addItem = function () {
        $scope.frm.items.push({
            start_date: ''
        });
    };
    $scope.removeItem = function (index) {
        $scope.frm.items.splice(index,1);
    };   
    $scope.removeDate =function(id){
        delete $scope.frm.old_items[id];        
        $scope.frm.deletedtid.push(id);
    };
    
    var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/service/uploadimage'
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
        $scope.frm.s_images = [];
        for (var j = 0; j < addedFileItems.length; j++) {
            var img = addedFileItems[j].file.name;
            if (img)
                $scope.frm.s_images.push(img);
        };
        uploader.uploadAll();
    };

    $scope.proccesaddservice = function ()
    {
        $scope.frm.services_dates = [];
        for (var i = 0; i < $scope.frm.items.length; i++) {
            var address = $scope.frm.items[i].start_date;
            if (address) $scope.frm.services_dates.push(address);
        }        
        $scope.frm.items = '';        
        Service.addService($.param($scope.frm)).success(function (data) {
            $scope.$modalClose();
            $state.reload();
            
        });
    };
    $scope.procceseditservice = function ()
    {
        $scope.frm.services_dates = [];
        for (var i = 0; i < $scope.frm.items.length; i++) {
            var address = $scope.frm.items[i].start_date;
            if (address) $scope.frm.services_dates.push(address);
        }        
          $scope.frm.items='';    
        Service.editService($.param($scope.frm)).success(function (data) {
            $scope.$modalClose();
            $state.reload();           
        });
    };
    $scope.editServiceView = function (id)
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
            Edit: id
        }
        );
    };   
    
    $scope.deleteservice = function (id)
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
            title: 'You you like to delete Service?',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    Service.deleteservices(id).success(function (data) {
                        //console.log(data);
                    });
                    $scope.$modalClose();
                    $state.reload();
                }}

        }, {
            myVal: '',
            Wrty_Id: '',
            Edit: ''
            
        });

    };
    
});

WarrantyistApp.controller('ServiceSortController', function ($scope,$state, Service,createDialog,$timeout) {

    $scope.$on('$viewContentLoaded', function () {
        $scope.sortval='status';
        Service.statussort().success(function (data) {
            $scope.serviceexpired = data.expired;
            $scope.serviceexpiring = data.expiring;
            $scope.serviceactive = data.active;
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
        angular.forEach($scope.serviceexpired, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.serviceexpired[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
        angular.forEach($scope.serviceexpiring, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.serviceexpiring[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
        angular.forEach($scope.serviceactive, function (a, key) {
            if ($scope.selectedAll) {
                $scope.chckedIndexs.push($scope.serviceactive[key].product_id);
            }
            a.checked = $scope.selectedAll;
        });
    };
      $scope.deleteservice = function ()
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
            title: 'You you like to delete Service?',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    if($scope.chckedIndexs.length !== 0)
                     {
                        Service.deleteservices($scope.chckedIndexs).success(function (data) {
                            // console.log(data);
                        }).then(function () {
                        return $timeout(function () {
                            //$scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }          
                }}

        }, {
            myVal: '',
            Wrty_Id:'',
            Edit:''
            
        });

    };

});

WarrantyistApp.controller('ServiceSortCatController', function ($scope,$state, Service,createDialog,$timeout) {

    
    $scope.$on('$viewContentLoaded', function () {
        $scope.sortval='category';
        Service.categorysort().success(function (data) {
            $scope.servicecat = data;            
        });
    });

    $scope.deleteservice = function ()
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
            title: 'You you like to delete Service?',
            backdrop: true,
            controller: 'ServiceAddController',
            footerTemplate: '<button class="btn btn-primary" ng-click="$modalSuccess()">{{$modalSuccessLabel}}</button><button class="btn" ng-click="$modalCancel()">{{$modalCancelLabel}}</button>',
            success: {label: 'Save', fn: function () {
                    if($scope.chckedIndexs.length !== 0)
                     {
                        Service.deleteservices($scope.chckedIndexs).success(function (data) {
                            // console.log(data);
                        }).then(function () {
                        return $timeout(function () {
                            //$scope.$modalClose();
                            $state.reload();
                        }, 100);
                    });
                    }          
                }}

        }, {
            myVal: '',
            Wrty_Id:'',
            Edit:''
            
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
         
       angular.forEach($scope.servicecat, function (ab, keyab) {         
            angular.forEach(ab, function (pr, key) {                
               $scope.chckedIndexs.push(ab[key].product_id);
                pr.checked = $scope.selectedAll;
            });
            });
          };    
        
   
});
