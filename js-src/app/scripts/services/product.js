'use strict';

jsSrcApp.factory('product', ['$resource', function($resource) {
<<<<<<< HEAD
    var Product = $resource('/products.json/:id', {id: '@id'});
=======
    var Product = $resource('/product.json/:id', {id: '@id'}, {
        update: {method: 'PUT'}
    });
>>>>>>> 602c64d6e3b08b1fd3b47b887ac9a758555e8d42
    return {
        Product: Product
    };
}]);
