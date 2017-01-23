@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('self-css')
    <!-- Latest compiled and minified CSS -->
@endsection

@section('contentheader_title')
    文章管理
@endsection
@section('breadcrumb')
    <li><a href="{{route('post.index')}}"> 文章管理 </a></li>
    <li class="active">文章添加</li>
@endsection

@section('main-content')
    <div ng-app="myModule" ng-controller="myController">
        <div class="container-fluid spark-screen" >
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">新建文章</div>
                    <div class="panel-body container-fluid">
                        <form name="myForm" ng-submit="save()" novalidate>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.title.$dirty && myForm.title.$invalid }">
                                <label for="title" class="control-label">标题:</label>
                                <input type="text" class="form-control" name="title" id="title" required ng-model="post.title">
                                <p ng-show="myForm.title.$dirty && myForm.title.$invalid" class="help-block">不能为空</p>
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.keyword.$dirty && myForm.keyword.$invalid }">
                                <label for="keyword" class="control-label">关键字:</label>
                                <input type="text" class="form-control" name="keyword" id="keyword" required ng-model="post.keyword">
                                <p ng-show="myForm.keyword.$dirty && myForm.keyword.$invalid" class="help-block">不能为空</p>
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.desc.$dirty && myForm.desc.$invalid }">
                                <label for="desc" class="control-label">描述:</label>
                                <input type="text" class="form-control" name="desc" id="desc" required ng-model="post.desc">
                                <p ng-show="myForm.desc.$dirty && myForm.desc.$invalid" class="help-block">不能为空</p>
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.cate_id.$dirty && myForm.cate_id.$invalid }">
                                <label for="cate_id" class="control-label">所属分类:</label>
                                <select chosen
                                        ng-model="state"
                                        ng-options="s for s in post.cate_id">
                                </select>
                                <input type="text" class="form-control" name="cate_id" id="cate_id" required ng-model="post.cate_id">
                                <p ng-show="myForm.cate_id.$dirty && myForm.cate_id.$invalid" class="help-block">不能为空</p>
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.slug.$dirty && myForm.slug.$invalid }">
                                <label for="slug" class="control-label">Slug:</label>
                                <input type="text" class="form-control" name="slug" id="slug" required ng-model="post.slug">
                                <p ng-show="myForm.slug.$dirty && myForm.slug.$invalid" class="help-block">不能为空</p>
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.pic.$dirty && myForm.pic.$invalid }">
                                <label for="pic" class="control-label">头图:</label>
                                <input type="file" class="form-control" name="pic" id="pic" ng-model="post.pic">
                                {{--<p ng-show="myForm.pic.$dirty && myForm.pic.$invalid" class="help-block">不能为空</p>--}}
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.content.$dirty && myForm.content.$invalid }">
                                <label for="content" class="control-label">内容:</label>
                                <input type="text" class="form-control" name="content" id="content" required ng-model="post.content">
                                <p ng-show="myForm.content.$dirty && myForm.content.$invalid" class="help-block">不能为空</p>
                            </div>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.tags.$dirty && myForm.tags.$invalid }">
                                <label for="tags" class="control-label">所属TAG:</label>
                                <input type="text" class="form-control" name="tags[]" id="tags" required ng-model="post.tags">
                                <p ng-show="myForm.tags.$dirty && myForm.tags.$invalid" class="help-block">不能为空</p>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" ng-disabled="myForm.$invalid">保存</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{$categories}}
@section('self-javascript')
    <script>
        angular.module('myModule', ['localytics.directives'])
            .controller('myController', function ($scope, $http) {
                $scope.post = {
                    'title':'',
                    'keyword':'',
                    'desc':'',
                    'cate_id': "",
                    'slug':'',
                    'pic':'',
                    'content':'',
                    'tags':'',
                };

                console.log($scope.post.cate_id);
                console.log(JSON.parse("{!! $categories !!}"));
                $scope.save = function () {
                    $http({
                        url: "{{route('post.store')}}",
                        method:'POST',
                        data:{
                            title: $scope.post.title,
                            keyword: $scope.post.keyword,
                            desc: $scope.post.desc,
                            cate_id: $scope.post.cate_id,
                            slug: $scope.post.slug,
                            pic: $scope.post.pic,
                            content: $scope.post.content,
                            tags: $scope.post.tags,
                        }
                    }).then(function successCallback(response) {
                        swal({
                            title: "成功!",
                            text: "",
                            type: "success"
                            }, function(){
                                window.location.href="{{route('post.index')}}";
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