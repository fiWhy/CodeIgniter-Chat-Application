var app = angular.module('testApp', ['ui.bootstrap', 'httpPostFix']);

app.filter('cut', function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace != -1) {
                    value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
    });

app.controller('Dialogue', function($scope, $http){
    $scope.dialogues = [];
    $scope.sort = {type:'desc'}
    $scope.form = {dialogue_id: 0, data: ''};
    
    $scope.changeSorting = function(sorttype){
        $scope.sort.type = sorttype;
        $scope.getDialogues();
    }
    $scope.setIntGD = function(){
        setInterval(function(){
            $scope.getDialogues();
        }, 2000);
    }
    $scope.getDialogues = function(){
        $scope.addLoad();
        $http.get('/api/communication/communication_model/getDialogues/'+$scope.sort.type)
                .then(function(response){
                    angular.copy(response.data, $scope.dialogues);
                    $scope.deleteLoad();
                })
    }
    
    
    $scope.send = function(){
        $http.post('/api/communication/communication_model/sendMessage', $scope.form)
                .then(function(response){
                    if(response.data.answer){
                        $scope.dialogues.push(response.data.data);
                    }
                })
    }
    
    $scope.deleteMessage = function(index){
        $http.get('/api/communication/communication_model/deleteMessage/'+$scope.dialogues[index]['um_id'])
                .then(function(response){
                    $scope.dialogues.splice(index, 1);
                })
    }
    
    $scope.deleteDialogue = function(index){
        $http.get('/api/communication/communication_model/deleteDialogue/'+$scope.dialogues[index]['ud_id'])
                .then(function(response){
                    $scope.dialogues.splice(index, 1);
                })
    }
    
    $scope.setIntDM = function(id){
        setInterval(function(){
            $scope.getDialogueMessages(id);
        }, 2000);
    }
    $scope.getDialogueMessages = function(id){
        $scope.addLoad();
        $http.get('/api/communication/communication_model/getDialogueMessages/'+id)
                .then(function(response){
                    angular.copy(response.data, $scope.dialogues);
                    $scope.deleteLoad();
                })
    }
    
    $scope.addLoad = function(){
        if($scope.dialogues.length == 0)
            $('#dialogues').append('<div class="overlay">Загрузка диалогов...</div>');
    }
    
    $scope.deleteLoad = function(){
        var overlay = $('#dialogues').find('.overlay');
            overlay.remove();
    }
})