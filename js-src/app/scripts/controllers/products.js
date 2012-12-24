'use strict';

jsSrcApp.controller('ProductsCtrl', ['$scope', 'products', function($scope, products) {
  $scope.products = products.Products.query();
}]);
