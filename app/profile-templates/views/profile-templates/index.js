module.exports = ProfileTemplatesController;
module.exports.$inject = ['$scope', 'templates'];

function ProfileTemplatesController ($scope, templates) {
  $scope.templates = templates;
}
