var baseUrl = "http://localhost/ToDoList/";
var app = angular.module('myApp', []);

app.controller('MainController', function($scope, $http, $timeout) {
    /*function GetItems(){
        var req = {
            method: "POST",
            url: baseUrl + "subjects/GetAllItems/" + $scope.subject.slug,
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            if(response.data.length >= 1){
                $scope.items = response.data;
                $timeout(function(){
                    var elems = document.getElementsByClassName("card");
                    for(var i = 0; i < elems.length; i++){
                        elems[i].style.transform = "scale(1,1)";
                    }
                }, 500);
            }else{
                console.log("Cant read items");
            }
        }, function errorCallback(response){});
    }*/
});
