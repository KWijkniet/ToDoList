app.controller('LoginController', function($scope, $http) {
    $scope.isLoggedIn = false;
    $scope.isRegister = false;
    $scope.isViewing = false;
    $scope.login = {};
    $scope.register = {};
    $scope.users = [];

    $scope.user = {};

    var req = {
        method: "GET",
        url: baseUrl + "login/CheckLogin",
        headers: {
            "Content-Type":undefined
        }
    }
    $http(req).then(function successCallback(response){
        if(response.data != "null"){
            $scope.isLoggedIn = true;
            $scope.user = response.data;

            if($scope.user['role_id'] == 1){
                $scope.GetUsers();
            }else{
                $scope.GetItems();
            }
        }else{
            $scope.isLoggedIn = false;
        }
    }, function errorCallback(response){});


    $scope.Login = function(){
        var req = {
            method: "POST",
            url: baseUrl + "login/Login",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'email': $scope.login.email,
                'password': $scope.login.password
            }
        }
        $http(req).then(function successCallback(response){
            if(response.data != "null"){
                $scope.isLoggedIn = true;
                $scope.user = response.data;
                $scope.GetItems();
            }else{
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    $scope.Logout = function(){
        var req = {
            method: "GET",
            url: baseUrl + "login/Logout",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            $scope.isLoggedIn = false;
            $scope.user = {};
        }, function errorCallback(response){});
    }

    $scope.RegisterPage = function(){
        $scope.isRegister = true;
    }

    $scope.LoginPage = function(){
        $scope.isRegister = false;
    }

    $scope.Register = function(){
        var req = {
            method: "POST",
            url: baseUrl + "login/Register",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'email': $scope.register.email,
                'password': $scope.register.password
            }
        }
        $http(req).then(function successCallback(response){
            if(response.data == true || response.data == "true"){
                $scope.isLoggedIn = true;
                $scope.isRegister = false;
                $scope.GetItems();
            }else{
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    $scope.GetUsers = function(){
        var req = {
            method: "GET",
            url: baseUrl + "login/GetUsers",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            console.log(response.data);
            $scope.users = response.data;
        }, function errorCallback(response){});
    }

    $scope.ToggleAdmin = function(item){
        if(item.role_id == 1){
            item.role_id = 2;
        }else{
            item.role_id = 1;
        }

        var req = {
            method: "POST",
            url: baseUrl + "login/ToggleAdmin",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': item.id,
                'value': item.role_id
            }
        }
        $http(req).then(function successCallback(response){}, function errorCallback(response){});
    }

    $scope.ShowTableByUser = function(id){
        var req = {
            method: "POST",
            url: baseUrl + "login/GetTableByUser",
            headers: {
                "Content-Type":undefined
            },
            data: {
                'id': id
            }
        }
        $http(req).then(function successCallback(response){
            $scope.tables = response.data;
            $scope.isViewing = true;
        }, function errorCallback(response){});
    }

    $scope.AdminPage = function(){
        $scope.isViewing = false;
    }
});
