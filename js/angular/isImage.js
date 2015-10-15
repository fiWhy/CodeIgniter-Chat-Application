app.controller('MainCtrl', function($scope, Utils) {
	$scope.errorBlock = $($('.admin-block ul')[0]);
	
	$scope.image = {};
	$scope.video = {};
	
	$scope.init = function(oldurl, oldlongurl){
		$scope.image.newsource = $scope.image.oldsource = oldurl;
		$scope.image.newlongsource =  $scope.image.oldlongsource = oldlongurl;
	}
	
	$scope.loadVideo = function(){
		var vidBlock = angular.element('#post-video');
		Utils.isYoutube($scope.video.youtubevideo).then(function(result){
			$scope.video.videosource = '';
			vidBlock.html('');
			if(result!=false){
				$scope.video.videosource = result
				vidBlock.append('<iframe src="https://www.youtube.com/embed/'+result+'" frameborder="0" allowfullscreen></iframe>');
			}else{
				$scope.video.videosource = '';
			}
		})
	}
	
	
	$scope.loadImage = function(){
		var imgBlock = angular.element('#post-image');
		Utils.isImage($scope.image.source).then(function(result) {
			$scope.errorBlock.html();
            if(result){
            	imgBlock.html('');
            	$scope.image.newsource = $scope.image.source;     
            	$scope.image.newlongsource = $scope.image.source;     
            }else{
            	imgBlock.html('');
            	$scope.errorBlock.append('<li class="bg-danger">Введенный url не является изображением, или не удалось загрузить изображение');
            }
            

            imgBlock.append('<img src="'+$scope.image.newsource+'" alt="Изображение статьи" class="img-responsive">');   
        });
	}
	
	$scope.unsetImage = function(){
		var imgBlock = angular.element('#post-image');
		imgBlock.html('');
    	$scope.image.oldsource = '';
    	$scope.image.oldlongsource = '';
	}
	
});

app.factory('Utils', function($q) {
    return {
        isImage: function(src) {
            var deferred = $q.defer();

            var image = new Image();
            image.onerror = function() {
                deferred.resolve(false);
            };
            image.onload = function() {
                deferred.resolve(true);
            };
            image.src = src;

            return deferred.promise;
        },
        
        isYoutube : function(url){
        	var deferred = $q.defer();
         	var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
         	  (url.match(p)) ? 
         			 deferred.resolve(RegExp.$1) :
         				 deferred.resolve(false);
         	  return deferred.promise;
         	}
    };
});