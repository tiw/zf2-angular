'use strict';

<<<<<<< HEAD
jsSrcApp.controller('ProductCtrl', ['$scope', '$routeParams', 'product', function($scope, $routeParams, product) {
    // $scope.products = product.Product.query();
    var p = product.Product;
    console.log(p);
    $scope.product = p.get({id: $routeParams.id});
    
=======
jsSrcApp.controller(
    'ProductCtrl', ['$scope', 'product', function($scope, product) {
    $scope.products = product.Product.query();
>>>>>>> 602c64d6e3b08b1fd3b47b887ac9a758555e8d42
}]);
