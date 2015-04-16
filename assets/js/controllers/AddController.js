WarrantyistApp.controller('AddController', function ($scope, myVal, Category, Warranty,$http) {
    $scope.frm = {};    
    if (myVal === 'cat')
    {
        $scope.category = '';
        myVal = '';
        Category.getcat().success(function (data) {
            $scope.category = data;
        });
    }
    $scope.proccesadd = function ()
    {
        //console.log( $.param($scope.frm));             
        Warranty.addWarranty($.param($scope.frm)).success(function(data){
        
        });        
    };
    
//    $scope.proccesadd = function() {
//        var url=BASE_URL+'/warranties/addWarranty';
//  $http({
//  method  : 'POST',
//  url     : url,
//  data    : $.param($scope.frm),  // pass in data as strings
//  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
// })
//  .success(function(data) {
//    console.log(data);  
//  });
//    };
});