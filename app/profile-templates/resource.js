module.exports = ProfileTemplate;
module.exports.$inject = ['$resource', '$q'];

function ProfileTemplate ($resource, $q) {
  /**
   * @ngdoc service
   * @name ProfileTemplate
   * 
   * @description
   * Factory for profile templates.
   */
  var ProfileTemplateFactory = $resource('http://dev.local/templates/:template_id', {template_id: '@id'});

  /**
   * @ngdoc method
   * @name ProfileTemplate#createProfile
   * 
   * @param {Object} user
   * 
   * @returns {Promise}
   */
  ProfileTemplateFactory.prototype.createProfile = function createProfileFromTemplate (user) {
    return $q.reject(new Error('Not implemented.'));
  };
  
  return ProfileTemplateFactory;
}