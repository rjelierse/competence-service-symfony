var angular = require('angular');
angular.module('pageMenuModule',
  [
    require('angular-material'),
    require('angular-ui-router')
  ]
);

module.exports = angular.module('pageMenuModule').name;

angular.module('pageMenuModule').directive('pageMenu', PageMenu);

PageMenu.$inject = [];
function PageMenu () {
  return {
    controller: PageMenuController,
    restrict: 'E',
    template: require('./template.html')
  }
}

PageMenuController.$inject = ['$scope', '$state'];
function PageMenuController ($scope, $state) {
  $scope.pages = $state.get()
    .filter(function (state) {
      if (state.abstract)
        return false;
      
      return !!state.label;
    });
}
