'use strict';

/**
 * @ngdoc function
 * @name infoblogApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the infoblogApp
 */
angular.module('infoblogApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
