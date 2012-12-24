'use strict';

jsSrcApp.controller('MainCtrl', ['$scope', 'product', function($scope, product) {
  $scope.products = product.Product.query();
}]);
