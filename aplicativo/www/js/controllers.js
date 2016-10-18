angular.module('starter.controllers', [])
  .controller('AppCtrl', function($scope, $ionicModal, $timeout,$http,$rootScope) {

    $scope.searchMenu = function(valor) {
        $rootScope.searchMenuGlobal(valor);
    };
    $rootScope.searchMenuGlobal = function(valor) {
      if(valor.length>=3){
          $scope.buscar_por = (valor);
          $http.get('http://tmlqa.com.br/wp-json/posts?filter[posts_per_page]=10&filter[s]='+valor).success(function(response) {
              $scope.data_buscar = (response);
          });
      }else{
          $scope.data_buscar = false;
      }
    };
    $scope.comentario = {};
    $ionicModal.fromTemplateUrl('templates/add_comentario.html', {
      scope: $scope
    }).then(function(modal) {
      $scope.modal = modal;
    });

    $scope.closeComentario = function() {
      $scope.modal.hide();
    };

    $scope.open_comentario = function(post_id,parent_id) {
		$scope.parent_id = {};
		$scope.post_id = {};
		$scope.parent_id = parent_id;
		$scope.post_id = post_id;
		$scope.modal.show();
    };
    $scope.salvarComentario = function() {
		$http.post('http://tmlqa.com.br/api/comentario/save',{'post_id':$scope.post_id,'nome':$scope.comentario.nome,'email':$scope.comentario.email,'comentario':$scope.comentario.descricao,'parent_id':$scope.parent_id}).success(function(response) {
			$timeout(function() {
					$rootScope.getComentariosPostDetalhe();
			  }, 0);
		});
      $timeout(function() {
        $scope.closeComentario();
      }, 0);
    };
  })
  .controller('CategoriaCtrl', function($scope,$http,$stateParams) {
    $scope.categoria = ($stateParams.categoria);
    $http.get('http://tmlqa.com.br/wp-json/posts?filter[posts_per_page]=20&filter[category_name]='+$scope.categoria+'&filter[orderby]=date&order=asc').success(function(response) {
      $scope.data = (response);
    });
  })
  .controller('DetalheCtrl', function($scope,$http,$stateParams,$sce,$rootScope) {
    $scope.categoria = ($stateParams.categoria);
    var id = ($stateParams.id);
    $http.get('http://tmlqa.com.br/wp-json/posts/'+id).success(function(response) {
      $scope.content = $sce.trustAsHtml(response.content);
      $scope.data = (response);
    });
	$rootScope.getComentariosPostDetalhe = function() {
        $http.post('http://tmlqa.com.br/api/comentario/list',{'post_id':$stateParams.id}).success(function(response) {
            $scope.comments = (response.comentarios);
        });
	};
  })
  .controller('TimeCtrl', function($scope,$http) {
		$http.get('http://tmlqa.com.br/wp-json/pages/234').success(function(response) {
			$scope.data = (response);
		});
  })
  .controller('HomeCtrl', function($scope,$http,$rootScope) {
    $scope.name_livros_categoria = "livros";
    $http.get('http://tmlqa.com.br/wp-json/posts?filter[category_name]=livros&filter[posts_per_page]=2').success(function(response) {
      $scope.data_livros = (response);
    });
    $scope.name_filmes_categoria = "filmes";
    $http.get('http://tmlqa.com.br/wp-json/posts?filter[category_name]=filmes&filter[posts_per_page]=2').success(function(response) {
      $scope.data_filmes = (response);
    });
    $scope.name_noticias_categoria = "noticias";
    $http.get('http://tmlqa.com.br/wp-json/posts?filter[category_name]=noticias&filter[posts_per_page]=2').success(function(response) {
      $scope.data_noticias = (response);
    });
	$scope.name_promocoes_categoria = "promocoes";
    $http.get('http://tmlqa.com.br/wp-json/posts?filter[category_name]=promocoes&filter[posts_per_page]=2').success(function(response) {
      $scope.data_promocoes = (response);
    });
  });
