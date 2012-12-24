'use strict';

jsSrcApp.factory('product', ['$resource', function($resource) {
    var Product = $resource('/products.json/:id', {id: '@id'});
    return {
        Product: Product
    };
}]);
