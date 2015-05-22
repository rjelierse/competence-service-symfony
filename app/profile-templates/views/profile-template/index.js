module.exports = ProfileTemplateController;
module.exports.$inject = ['$scope', 'template'];

function ProfileTemplateController ($scope, template) {
  $scope.template = template;
}
