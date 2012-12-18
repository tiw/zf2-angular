'use strict';

jsSrcApp.controller('Product-EditCtrl', ['$scope', 'product', function($scope, product) {
    var newProduct = {};
    $scope.product = newProduct;
    var Product = product.Product;
    $scope.save = function() {
        var p = Product.get();
        p.name = newProduct.name;
        p.time = newProduct.time;
        p.price = newProduct.price;
        p.$save();
    }
    }
]);
