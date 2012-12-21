'use strict';

jsSrcApp.controller('ProductCtrl', ['$scope', 'product', function($scope, product) {
    $scope.products = product.Product.query();
    $scope.product = Product.get({id: 69});
}]);
