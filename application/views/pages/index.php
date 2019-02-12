<div class="center-page" ng-controller="MainController">
    <div class="center-container">
        <a ng-show="tables.length == 0" href="#" class="" ng-click="CreateTable();"><i class="fas fa-plus"></i></a>
        <div class="todo-list" ng-repeat="x in tables">
            <a href="#" class="add-table-button" ng-click="CreateTable();"><i class="fas fa-plus"></i></a>
            <ul class="list-group">
                <li class="list-group-item active disabled" ng-blur="UpdateTitle(x, $event)" contenteditable="true" ng-bind="x.name"></li>
                <li class="list-group-item" ng-repeat="r in x.content">
                    <p class="list-text" ng-blur="UpdateItem(r.id, $event)" contenteditable="true" ng-bind="r.name"></p>
                    <a href="#" class="delete-table-button" ng-click="DeleteItem();"><i class="fas fa-minus"></i></a>
                </li>
                <li class="list-group-item" ng-click="CreateItem(x.id)" contenteditable="false" style="text-align: center;"><i class="fas fa-plus"></i></li>
            </ul>
        </div>
    </div>
</div>
