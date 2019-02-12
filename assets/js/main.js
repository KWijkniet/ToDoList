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
        var req = {
            method: "GET",
            url: baseUrl + "dashboard/CreateItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'table_id': tableID
            }
        }
        $http(req).then(function successCallback(response){
            console.log(response.data);
            for(var i = 0; i < $scope.tables.length; i++){
                if($scope.tables[i].id == tableID){
                    var content = $scope.tables[i].content;
                    var item = {
                        'id': response.data,
                        'name': "placeholder",
                        'completed': 0
                    };
                    content.push(item);
                }
            }
            $scope.tables = response.data;
        }, function errorCallback(response){});
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
