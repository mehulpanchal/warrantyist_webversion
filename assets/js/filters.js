/***
 WarrantyistApp filter
 ***/
// custom filters
WarrantyistApp.filter('getStatus', function getStatus($filter) {
    var st;
    return function (status) {
        if (status === 'E')
            st = 'Expired';
        else if (status === 'EX')
            st = 'Expiring';
        else if (status === 'A')
            st = 'Active';

        return st;
    };
});
//end 
/***********Pagination*** Mehul ************/
WarrantyistApp.filter('offset', function () {
    return function (input, start) {
        start = parseInt(start, 10);
        return input.slice(start);
    };
});

/********add month Date******** Mehul ***********/
WarrantyistApp.filter('expiringin', function ($filter) {
    return function (input, months) {
//        alert(input);
        var dt = new Date(input);
        //alert("month added" + dt.getMonth());
        dt.setMonth(dt.getMonth() + months);
        return dt;
    };
});
WarrantyistApp.filter('moment', function () {
  return function (input, momentFn /*, param1, param2, etc... */) {
    var args = Array.prototype.slice.call(arguments, 2),
        momentObj = moment(input);
    return momentObj[momentFn].apply(momentObj, args);
  };
});
/*********string uppercas********/
WarrantyistApp.filter('firstUpper', function() {
    return function(input, scope) {
        return input ? input.substring(0,1).toUpperCase()+input.substring(1).toLowerCase() : "";
    }
});

