'use strict';

jsSrcApp.controller('ProductCtrl', ['$scope', 'product', function($scope, product) {
    var Product = product.Product;
    $scope.products = Product.query();
    $scope.product = Product.get({id: 69});
}]);
