'use strict';

jsSrcApp.controller('ProductsCtrl', ['$scope', 'products', function($scope, products) {
  console.log(products);
  
  $scope.products = products.Products.query();
}]);
