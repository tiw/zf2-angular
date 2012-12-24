'use strict';

jsSrcApp.controller(
    'Product-EditCtrl', ['$scope', 'product', function($scope, product) {
    $scope.title = 'Add product';
    $scope.product = new product.Product;
    var scope = $scope;
    $scope.save = function() {
        var product = scope.product;
        if (product.id) {
            //update it
            product.$update(function(product) {
                console.log(product);
                scope.title = 'Edit: ' + product.name;
                scope.product = product;
            });
        } else {
            product.$save(function(product) {
                console.log(product);
                scope.title = 'Edit: ' + product.name;
                scope.product = product;
            });
        }
    };
}
]);
