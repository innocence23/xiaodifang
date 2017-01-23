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
                        @include('posts.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('self-javascript')
    <script src="/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'editor1', {
            language: 'zh-cn',
        });

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

                $http({
                    url: "{{route('post.catetag')}}",
                    method:'GET',
                }).then(function successCallback(response) {
                    $scope.data = response.data;
                }, function errorCallback(response) {
                    swal("错误", '服务异常', "error");
                });


                $scope.save = function () {
                    var editor1 = CKEDITOR.instances.editor1.getData();
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
                            content: editor1,
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