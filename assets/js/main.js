var baseUrl = "http://localhost/ToDoList/";
var app = angular.module('myApp', []);

app.controller('MainController', function($scope, $http) {
    $scope.filterReverse = false;
    $scope.filterType = '';

    $scope.tables = [];

    $scope.GetItems = function(){
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

    $scope.UpdateTitle = function(item, elem){
        var newValue = elem.currentTarget.innerHTML;
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/UpdateTable",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item.id,
                'value': newValue
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == item.id){
                    table.name = newValue;
                }
            }
        }, function errorCallback(response){});
    }

    $scope.UpdateItem = function(item, elem){
        var newValue = elem.currentTarget.innerHTML;

        if(item['id'] != undefined){
            item = item.id;
        }
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/UpdateItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item,
                'value': newValue
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == item.table_id){
                    for(var r = 0; r < table.content.length; r++){
                        var content = table.content[r];
                        if(content.id == item.id){
                            content.name = newValue;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    $scope.CreateItem = function(tableID){
        if(tableID['id'] != undefined){
            tableID = tableID.id;
        }
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/CreateItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'table_id': tableID
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                if($scope.tables[i].id['id'] != undefined){
                    $scope.tables[i].id = $scope.tables[i].id.id;
                }
                if($scope.tables[i].id == tableID){
                    if($scope.tables[i].content == undefined){
                        $scope.tables[i].content = [];
                    }
                    var item = {
                        'id': response.data.id,
                        'name': "placeholder",
                        'completed': 0,
                        'table_id': tableID
                    };
                    $scope.tables[i].content.push(item);
                }
            }
        }, function errorCallback(response){});
    }

    $scope.CreateTable = function(){
        var req = {
            method: "GET",
            url: baseUrl + "dashboard/CreateTable",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            var item = {
                'id': response.data.id,
                'name': "placeholder"
            };
            $scope.tables.push(item);
        }, function errorCallback(response){});
    }

    $scope.DeleteItem = function(id, table_id){
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/DeleteItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': id
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == table_id){
                    for(var r = 0; r < table.content.length; r++){
                        if(table.content[r].id == id){
                            table.content.splice(r, 1);
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    $scope.AcceptItem = function(item, elem){
        var elem = elem.currentTarget;
        var elems = elem.parentNode.getElementsByTagName('p');
        if(item.completed == 1){
            item.completed = 0;
            for(var i = 0; i < elems.length; i++){
                elems[i].classList.remove("strikethrough");
            }
        }else{
            item.completed = 1;
            for(var i = 0; i < elems.length; i++){
                elems[i].classList.add("strikethrough");
            }
        }

        var req = {
            method: "POST",
            url: baseUrl + "dashboard/AcceptItem",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item.id,
                'value': item.completed
            }
        }
        $http(req).then(function successCallback(response){}, function errorCallback(response){});
    }

    $scope.DeleteTable = function(id){
        var req = {
            method: "POST",
            url: baseUrl + "dashboard/DeleteTable",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': id
            }
        }
        $http(req).then(function successCallback(response){
            for(var i = 0; i < $scope.tables.length; i++){
                if($scope.tables[i].id == id){
                    $scope.tables.splice(i, 1);
                }
            }
        }, function errorCallback(response){});
    }
});
