'use strict';

// jsSrcApp.controller('MainCtrl', ['$scope', function($scope) {
//   $scope.awesomeThings = [
//     'HTML5 Boilerplate',
//     'AngularJS',
//     'Testacular'
//   ];
// }]);

jsSrcApp.controller('MainCtrl', ['$scope', 'products', function($scope, products) {
  $scope.products = products.Products.query();
}]);
