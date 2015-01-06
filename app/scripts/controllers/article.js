'use strict';

/**
 * @ngdoc function
 * @name infoblogApp.controller:ArticleCtrl
 * @description
 * # ArticleCtrl
 * Controller of the infoblogApp
 */
angular.module('infoblogApp')
  .controller('ArticleCtrl', ['$scope','$routeParams','parallaxHelper',function ($scope,$routeParams,parallaxHelper) {
  	$scope.background = parallaxHelper.createAnimator(-0.3, 150, -150);
    $scope.param = $routeParams.articleId;
  }]);
