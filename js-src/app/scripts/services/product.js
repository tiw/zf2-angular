'use strict';

jsSrcApp.factory('product', ['$resource', function($resource) {
  var dummyProducts = [{name: "ting", id: 1}, {name: "wang", id: 2}];
  return {
    get: function() {
      return $resource('product.json');
    }
  };
}]);
