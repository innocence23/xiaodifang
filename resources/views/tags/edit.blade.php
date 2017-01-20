@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('self-css')
    <!-- Latest compiled and minified CSS -->
@endsection

@section('contentheader_title')
    TAG管理
@endsection
@section('breadcrumb')
    <li><a href="{{route('tag.index')}}"> TAG管理 </a></li>
    <li class="active">TAG编辑</li>
@endsection

@section('main-content')
    <div ng-app="myModule" ng-controller="myController">
        <div class="container-fluid spark-screen" >
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">类别标签</div>
                    <div class="panel-body container-fluid">
                        <form name="myForm" ng-submit="save()" novalidate>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.name.$dirty && myForm.name.$invalid }">
                                <label for="cate-name" class="control-label">名称:</label>
                                <input type="text" class="form-control" name="name"  id="cate-name" required ng-model="tag.name">
                                <p ng-show="myForm.name.$dirty && myForm.name.$invalid" class="help-block">不能为空</p>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" ng-disabled="myForm.$invalid">保存</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('self-javascript')
    <script>
        angular.module('myModule', [])
            .controller('myController', function ($scope, $http) {
                $scope.tag = {
                    'id':'{{$model->id}}',
                    'name':'{{$model->name}}',
                };
                $scope.save = function () {
                    $http({
                        url: "{{route('tag.update', $model->id)}}",
                        method:'POST',
                        data:{name: $scope.tag.name}
                    }).then(function successCallback(response) {
                        swal({
                            title: "成功!",
                            text: "",
                            type: "success"
                            }, function(){
                                $('#myModal').modal('hide');
                                window.location.href="{{route('tag.index')}}";
                            });
                    }, function errorCallback(response) {
                        var errorMsg = '';
                        for (i in response.data) {
                            errorMsg += i + ": " + response.data[i] + "\n";
                        }
                        swal("错误", errorMsg, "error");
                    });
                }
            })
    </script>
@endsection