app.controller('LoginController', function($scope, $http) {
    //preset page bools
    $scope.isLoggedIn = false;
    $scope.isRegister = false;
    $scope.isViewing = false;

    //preset input values
    $scope.login = {};
    $scope.register = {};

    //preset admins users list
    $scope.users = [];

    //preset session user
    $scope.user = {};

    //check session
    var req = {
        method: "GET",
        url: baseUrl + "login/CheckLogin",
        headers: {
            "Content-Type":undefined
        }
    }
    $http(req).then(function successCallback(response){
        if(response.data != "null" && response.data != null){
            $scope.isLoggedIn = true;
            $scope.user = response.data;
            console.log("user is already Loggedin");

            if($scope.user['role_id'] == 1){
                $scope.GetUsers();
            }else{
                $scope.GetTables();
            }
        }else{
            $scope.isLoggedIn = false;
            console.log("user is not Loggedin");
        }
    }, function errorCallback(response){});

    //login function
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
            //act based on response
            if(response.data != "null"){
                $scope.isLoggedIn = true;
                $scope.user = response.data;
                //get all tables
                $scope.GetTables();
            }else{
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    //logout the user
    $scope.Logout = function(){
        var req = {
            method: "GET",
            url: baseUrl + "login/Logout",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            //reset variables
            $scope.isLoggedIn = false;
            $scope.user = {};
        }, function errorCallback(response){});
    }

    //change page
    $scope.RegisterPage = function(){
        $scope.isRegister = true;
    }

    //change page
    $scope.LoginPage = function(){
        $scope.isRegister = false;
    }

    //change page
    $scope.AdminPage = function(){
        $scope.isViewing = false;
    }

    //register new user
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
            //act based on response
            if(response.data != "null" && response.data != null){
                $scope.isLoggedIn = true;
                $scope.isRegister = false;
                $scope.user = response.data;
                //get tables
                $scope.GetTables();
            }else{
                console.log(response.data);
            }
        }, function errorCallback(response){});
    }

    //get users from db
    $scope.GetUsers = function(){
        var req = {
            method: "GET",
            url: baseUrl + "login/GetUsers",
            headers: {
                "Content-Type":undefined
            }
        }
        $http(req).then(function successCallback(response){
            $scope.users = response.data;
        }, function errorCallback(response){});
    }

    //toggle role id
    $scope.ToggleAdmin = function(item){
        //toggle
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

    //show table by user id
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
});
