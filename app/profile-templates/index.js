var angular = require('angular');
angular.module('profileTemplatesModule',
  [
    require('angular-resource'),
    require('angular-ui-router')
  ]
);

module.exports = angular.module('profileTemplatesModule').name;

angular.module('profileTemplatesModule').factory('ProfileTemplate', require('./resource'));
angular.module('profileTemplatesModule').config(['$stateProvider',
  function ($stateProvider) {
    $stateProvider
      .state('profileTemplates', {
        url: '/templates',
        views: {
          content: {
            controller: require('./views/profile-templates'),
            template: require('./views/profile-templates/view.html'),
            resolve: {
              templates: ['ProfileTemplate',
                function (ProfileTemplate) {
                  return ProfileTemplate.query().$promise;
                }
              ]
            }
          }
        },
        label: 'Profile templates',
        description: 'Manage the templates for competence profiles'
      })
      .state('profileTemplates.new', {
        url: '/new',
        views: {
          template: {
            controller: require('./views/profile-template'),
            template: require('./views/profile-template/view.html'),
            resolve: {
              template: ['ProfileTemplate',
                function (ProfileTemplate) {
                  return new ProfileTemplate()
                }
              ]
            }
          }
        }
      })
      .state('profileTemplate', {
        parent: 'profileTemplates',
        url: '/:id',
        views: {
          template: {
            controller: require('./views/profile-template'),
            template: require('./views/profile-template/view.html')
          }
        },
        resolve: {
          template: ['ProfileTemplate', '$stateParams',
            function (ProfileTemplate, $stateParams) {
              return ProfileTemplate.get({template_id: $stateParams.id}).$promise;
            }
          ]
        }
      });
  }]);
