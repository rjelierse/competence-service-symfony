var angular = require('angular');
angular.module('app',
  [
    require('angular-material'),
    require('./components/page-menu'),
    require('./profile-templates')
  ]
);

module.exports = angular.module('app').name;

angular.module('app').config(['$mdThemingProvider',
  function ($mdThemingProvider) {
    $mdThemingProvider.theme('default')
      .primaryPalette('cyan')
      .accentPalette('pink')
      .warnPalette('red')
      .backgroundPalette('grey');
  }
]);

angular.module('app').config(['$stateProvider',
  function ($stateProvider) {
    $stateProvider.state('home', {
      url: '/'
    })
  }
]);
