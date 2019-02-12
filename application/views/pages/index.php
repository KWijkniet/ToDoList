<div class="center-page" ng-controller="MainController">
    <div class="center-container">
        <div class="todo-list" ng-repeat="x in tables">
            <ul class="list-group">
                <li class="list-group-item active disabled" ng-blur="UpdateTitle(x, $event)" contenteditable="true" ng-bind="x.name"></li>

                <li class="list-group-item" ng-repeat="r in x.content" ng-blur="UpdateItem(r.id, $event)" ngModel="item" contenteditable="true" ng-bind="r.name"></li>

                <li class="list-group-item" ng-click="CreateItem()" contenteditable="false" style="text-align: center;">+</li>
            </ul>
        </div>
    </div>
</div>
