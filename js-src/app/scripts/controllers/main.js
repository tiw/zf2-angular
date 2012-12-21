'use strict';

jsSrcApp.controller('MainCtrl', ['$scope', function($scope) {
  $scope.awesomeThings = [
    'HTML5 Boilerplate',
    'AngularJS',
    'Testacular'
  ];
}]);

jsSrcApp.controller('MainCtrl', ['$scope', 'products', function($scope, products) {
    var Products = products.Products;
    $scope.products = Products.query();
    $scope.product = Products.get({id: 69});
}]);
