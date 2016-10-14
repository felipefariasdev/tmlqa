angular.module('starter', ['ionic', 'starter.controllers'])

  .run(function($ionicPlatform) {
    $ionicPlatform.ready(function() {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      if (window.cordova && window.cordova.plugins.Keyboard) {
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        cordova.plugins.Keyboard.disableScroll(true);

      }
      if (window.StatusBar) {
        // org.apache.cordova.statusbar required
        StatusBar.styleDefault();
      }
    });
  })

  .config(function($stateProvider, $urlRouterProvider) {
    $stateProvider

      .state('app', {
        url: '/app',
        abstract: true,
        templateUrl: 'templates/menu.html',
        controller: 'AppCtrl'
      })
	  .state('app.time', {
        url: '/home/time/equipe',
        views: {
          'menuContent': {
            templateUrl: 'templates/time.html',
            controller: 'TimeCtrl'
          }
        }
      })
      .state('app.home', {
        url: '/home',
        views: {
          'menuContent': {
            templateUrl: 'templates/home.html',
            controller: 'HomeCtrl'
          }
        }
      })
      .state('app.categoria', {
        url: '/categoria/{categoria}',
        views: {
          'menuContent': {
            templateUrl: 'templates/categoria.html',
            controller: 'CategoriaCtrl'
          }
        }
      })

      .state('app.detalhe', {
        url: '/categoria/{categoria}/{id}',
        views: {
          'menuContent': {
            templateUrl: 'templates/detalhe.html',
            controller: 'DetalheCtrl'
          }
        }
      });

    $urlRouterProvider.otherwise('/app/home');
  });
