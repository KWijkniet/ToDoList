var baseUrl = "http://localhost/ToDoList/";
var app = angular.module('myApp', []);

app.controller('MainController', function($scope, $http, $timeout) {

    $scope.tables = [];

    $scope.UpdateTitle = function(table, elem){
        var newValue = elem.currentTarget.innerHTML;
        UpdateTable(table, newValue);
    }

    $scope.UpdateItem = function(item, elem){
        var newValue = elem.currentTarget.innerHTML;
        UpdateItem(item, newValue);
    }

    $scope.CreateItem = function(tableID){

    }

    $scope.CreateTable = function(){

    }

    GetItems();
    function GetItems(){
        var req = {
            method: "GET",
            url: baseUrl + "dashboard/GetUserTables",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            $scope.tables = response.data;
        }, function errorCallback(response){});
    }

    function UpdateItem(item, value){
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/UpdateItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item,
                'value': value
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == item.table_id){
                    for(var r = 0; r < table.content.length; r++){
                        var content = table.content[r];
                        if(content.id == item.id){
                            content.name = value;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    function UpdateTable(item, value){
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/UpdateTable",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item.id,
                'value': value
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == item.id){
                    table.name = value;
                }
            }
        }, function errorCallback(response){});
    }
});
