'use strict';

/**
 * @ngdoc function
 * @name infoblogApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the infoblogApp
 */
angular.module('infoblogApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
