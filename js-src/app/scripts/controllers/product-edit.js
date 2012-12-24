'use strict';

jsSrcApp.controller(
    'Product-EditCtrl', ['$scope', 'product', function($scope, product) {
    var newProduct = {};
    $scope.title = 'Add product';
    $scope.product = newProduct;
    var Product = product.Product;
    var scope = $scope;
    $scope.save = function() {
        var p = new Product;
        p.name = newProduct.name;
        p.time = newProduct.time;
        p.price = newProduct.price;
        p.$save(function(p) {
            scope.title = 'Edit: ' + p.name;
        });
    };
}
]);
