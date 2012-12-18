'use strict';

jsSrcApp.factory('product', ['$resource', function($resource) {
    var Product = $resource('/product.json/:id', {id: '@id'});
    return {
        Product: Product
    };
}]);
