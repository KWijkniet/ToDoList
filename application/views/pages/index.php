<div class="center-page" ng-controller="LoginController">
    <div class="center-container" ng-if="isLoggedIn == false && isRegister == false">
        <form action="" method="" name="logins">
            <div class="form-group">
                <label for="loginEmail">Email address</label>
                <input type="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Enter email" ng-model="login.email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" class="form-control" id="loginPassword" placeholder="Password" ng-model="login.password">
            </div>
            <button type="button" class="btn btn-primary" ng-click="Login();">Login</button>
            <button type="button" class="btn btn-primary" ng-click="RegisterPage();">Register</button>
        </form>
    </div>
    <div class="center-container" ng-if="isLoggedIn == false && isRegister == true">
        <form action="" method="" name="registers">
            <div class="form-group">
                <label for="registerEmail">Email address</label>
                <input type="email" class="form-control" id="registerEmail" aria-describedby="emailHelp" placeholder="Enter email" ng-model="register.email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="registerPassword">Password</label>
                <input type="password" class="form-control" id="registerPassword" placeholder="Password" ng-model="register.password">
            </div>
            <button type="button" class="btn btn-primary" ng-click="Register();">Register</button>
            <button type="button" class="btn btn-primary" ng-click="LoginPage();">Back</button>
        </form>
    </div>
    <div class="center-container" ng-if="isLoggedIn == true && user.role_id == 2">
        <button class="btn btn-primary logout-button" type="button" ng-click="Logout()">Logout</button>
        <a ng-show="tables.length == 0" href="#" class="" ng-click="CreateTable();"><i class="fas fa-plus"></i></a>
        <div class="todo-list" ng-repeat="x in tables track by $index">
            <a href="#" class="add-table-button" ng-click="CreateTable();"><i class="fas fa-plus"></i></a>
            <ul class="list-group">
                <li class="list-group-item active disabled">
                    <a href="#" class="delete-table-button" ng-click="DeleteTable(x.id);"><i class="fas fa-minus"></i></a>
                    <p class="list-title" ng-blur="UpdateTitle(x, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true" ng-bind="x.name"></p>
                </li>
                <li class="list-group-item active disabled">
                    <button href="#" class="filter-buttons left" ng-click="filterReverse = !filterReverse; filterType = 'completed';">Filter completed</button>
                    <button href="#" class="filter-buttons right" ng-click="filterReverse = !filterReverse; filterType = 'time';">Filter time</button>
                </li>
                <li class="list-group-item" ng-repeat="r in x.content | orderBy:filterType:filterReverse track by $index">
                    <input type="checkbox" ng-click="AcceptItem(r, $event)" ng-if="r.completed == 1" checked>
                    <input type="checkbox" ng-click="AcceptItem(r, $event)" ng-if="r.completed == 0">
                    <p class="list-time" ng-class="{'strikethrough': r.completed == 1}">(<span ng-blur="UpdateItemTime(r.id, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true">{{(r.time == null ? 0 : r.time)}}</span> min)</p>
                    <p class="list-text" ng-class="{'strikethrough': r.completed == 1}" ng-blur="UpdateItem(r.id, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true" ng-bind="r.name"></p>
                    <a href="#" class="delete-item-button" ng-click="DeleteItem(r.id, r.table_id);"><i class="fas fa-minus"></i></a>
                </li>
                <li class="list-group-item" ng-click="CreateItem(x.id)" contenteditable="false" style="text-align: center;"><i class="fas fa-plus"></i></li>
            </ul>
        </div>
    </div>
    <div class="center-container" ng-if="isLoggedIn == true && user.role_id == 1 && isViewing == false">
        <button class="btn btn-primary logout-button" type="button" ng-click="Logout()">Logout</button>
        <div class="todo-list">
            <ul class="list-group">
                <li class="list-group-item active disabled">
                    <p style="width:100%; text-align:center;">Users:</p>
                </li>
                <li class="list-group-item active disabled">
                    <button href="#" class="filter-buttons left" ng-click="filterReverse = !filterReverse; filterType = 'completed';">Filter Admin</button>
                </li>
                <li class="list-group-item">
                    <p class="list-text" ng-bind="user.email"></p>
                    <a href="#" class="delete-item-button" ng-click="ShowTableByUser(user.id);"><i class="fas fa-chevron-right"></i></a>
                </li>
                <li class="list-group-item" ng-repeat="x in users | orderBy:filterType:filterReverse track by $index"  ng-if="x.id != user.id">
                    <input type="checkbox" ng-click="ToggleAdmin(x)" ng-if="x.role_id == 1" checked>
                    <input type="checkbox" ng-click="ToggleAdmin(x)" ng-if="x.role_id == 2">
                    <p class="list-text" ng-bind="x.email"></p>
                    <a href="#" class="delete-item-button" ng-click="ShowTableByUser(x.id);"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="center-container" ng-if="isLoggedIn == true && user.role_id == 1 && isViewing == true">
        <button class="btn btn-primary logout-button" type="button" ng-click="Logout()">Logout</button>
        <button class="btn btn-primary back-button" type="button" ng-click="AdminPage()">Back</button>
        <a ng-show="tables.length == 0" href="#" class="" ng-click="CreateTable();"><i class="fas fa-plus"></i></a>
        <div class="todo-list" ng-repeat="x in tables track by $index">
            <a href="#" class="add-table-button" ng-click="CreateTable();"><i class="fas fa-plus"></i></a>
            <ul class="list-group">
                <li class="list-group-item active disabled">
                    <a href="#" class="delete-table-button" ng-click="DeleteTable(x.id);"><i class="fas fa-minus"></i></a>
                    <p class="list-title" ng-blur="UpdateTitle(x, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true" ng-bind="x.name"></p>
                </li>
                <li class="list-group-item active disabled">
                    <button href="#" class="filter-buttons left" ng-click="filterReverse = !filterReverse; filterType = 'completed';">Filter completed</button>
                    <button href="#" class="filter-buttons right" ng-click="filterReverse = !filterReverse; filterType = 'time';">Filter time</button>
                </li>
                <li class="list-group-item" ng-repeat="r in x.content | orderBy:filterType:filterReverse track by $index">
                    <input type="checkbox" ng-click="AcceptItem(r, $event)" ng-if="r.completed == 1" checked>
                    <input type="checkbox" ng-click="AcceptItem(r, $event)" ng-if="r.completed == 0">
                    <p class="list-time" ng-class="{'strikethrough': r.completed == 1}">(<span ng-blur="UpdateItemTime(r.id, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true">{{r.time}}</span> min)</p>
                    <p class="list-text" ng-class="{'strikethrough': r.completed == 1}" ng-blur="UpdateItem(r.id, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true" ng-bind="r.name"></p>
                    <a href="#" class="delete-item-button" ng-click="DeleteItem(r.id, r.table_id);"><i class="fas fa-minus"></i></a>
                </li>
                <li class="list-group-item" ng-click="CreateItem(x.id)" contenteditable="false" style="text-align: center;"><i class="fas fa-plus"></i></li>
            </ul>
        </div>
    </div>
</div>
