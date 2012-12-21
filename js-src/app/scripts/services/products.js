'use strict';

jsSrcApp.factory('products', ['$resource', function($resource) {
    var Products = $resource('/products.json');
    return {
        Products: Products
    };
}]);
