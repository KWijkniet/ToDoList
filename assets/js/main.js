var baseUrl = "http://localhost/ToDoList/";
var app = angular.module('myApp', []);

app.controller('MainController', function($scope, $http) {
    //preset filter variables
    $scope.filterReverse = [];
    $scope.filterType = [];

    //preset tables variables
    $scope.tables = [];

    //get all tables
    $scope.GetTables = function(){
        //clear tables list if you switched user or viewed different user
        $scope.tables = [];
        var req = {
            method: "GET",
            url: baseUrl + "dashboard/GetUserTables",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            //set tables list to response data
            $scope.tables = response.data;
        }, function errorCallback(response){});
    }

    //update title of table
    $scope.UpdateTitle = function(item, elem){
        //get new title
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
            //update local tables list
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == item.id){
                    table.name = newValue;
                }
            }
        }, function errorCallback(response){});
    }

    //update item (name)
    $scope.UpdateItem = function(item, elem){
        //get new name
        var newValue = elem.currentTarget.innerHTML;

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
            //update local variables
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

    //update item (time)
    $scope.UpdateItemTime = function(item, elem){
        //get new time
        var newValue = elem.currentTarget.innerHTML;

        //set to 0 if empty is given
        if(newValue.length == 0){
            newValue = 0;
        }

        var req = {
            method: "POST",
            url: baseUrl + "dashboard/UpdateItemTime",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item,
                'value': newValue
            }
        }
        $http(req).then(function successCallback(response){
            //update local variables
            for(var i = 0; i < $scope.tables.length; i++){
                var table = $scope.tables[i];
                if(table.id == item.table_id){
                    for(var r = 0; r < table.content.length; r++){
                        var content = table.content[r];
                        if(content.id == item.id){
                            content.time = newValue;
                        }
                    }
                }
            }
        }, function errorCallback(response){});
    }

    //create item
    $scope.CreateItem = function(tableID){
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
            //update local variables
            for(var i = 0; i < $scope.tables.length; i++){
                if($scope.tables[i].id == tableID){
                    //show new item
                    if($scope.tables[i].content == undefined){
                        $scope.tables[i].content = [];
                    }
                    var item = {
                        'id': response.data.id,
                        'name': "placeholder",
                        'time': 0,
                        'completed': 0,
                        'table_id': tableID
                    };
                    $scope.tables[i].content.push(item);
                }
            }
        }, function errorCallback(response){});
    }

    //create table
    $scope.CreateTable = function(){
        var req = {
            method: "GET",
            url: baseUrl + "dashboard/CreateTable",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            //show new table
            var item = {
                'id': response.data.id,
                'name': "placeholder"
            };
            $scope.tables.push(item);
        }, function errorCallback(response){});
    }

    //delete item
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
            //update local variable
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

    //accept item
    $scope.AcceptItem = function(item, elem){
        //get new value
        var elem = elem.currentTarget;
        //get all siblings
        var elems = elem.parentNode.getElementsByTagName('p');

        //toggle strikethrough style
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

    //delete table
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
            //update local variable
            for(var i = 0; i < $scope.tables.length; i++){
                if($scope.tables[i].id == id){
                    $scope.tables.splice(i, 1);
                }
            }
        }, function errorCallback(response){});
    }
});
