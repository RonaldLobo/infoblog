'use strict';

/**
 * @ngdoc function
 * @name infoblogApp.controller:HomeCtrl
 * @description
 * # HomeCtrl
 * Controller of the infoblogApp
 */
angular.module('infoblogApp')
  .controller('HomeCtrl', function ($scope,parallaxHelper) {
    $scope.background = parallaxHelper.createAnimator(-0.3, 150, -150);
  });
