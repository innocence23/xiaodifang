@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('self-css')
    <!-- Latest compiled and minified CSS -->
@endsection

@section('main-content')
    <div ng-app="myModule" ng-controller="myController">
        <div class="container-fluid spark-screen" >
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">类别管理</div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div id="toolbar">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="glyphicon glyphicon-plus"></i> 新建
                                </button>
                            </div>
                            <table id="table"
                                   data-toolbar="#toolbar"
                                   data-search="true"
                                   data-advanced-search="true"
                                   data-pagination="true"
                                   data-id-field="id"
                                   data-page-list="[10, 25, 50, 100]">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" aria-labelledby="exampleModalLabel" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">新建类别</h4>
                    </div>
                    <div class="modal-body">
                        <form name="myForm" ng-submit="save()" id="form1" novalidate>
                            <div class="form-group"  ng-class="{ 'has-error' : myForm.name.$dirty && myForm.name.$invalid }">
                                <label for="cate-name" class="control-label">名称:</label>
                                <input type="text" class="form-control" name="name"  id="cate-name" required ng-model="category.name">
                                <p ng-show="myForm.name.$dirty && myForm.name.$invalid" class="help-block">不能为空</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary" form="form1" ng-disabled="myForm.name.$invalid">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('self-javascript')
    <script>
        $('#table').bootstrapTable({
            url: '/category/lists',
            columns: [{
                field: 'name',
                title: '名称',
                valign: 'middle'
            }, {
                field: 'created_at',
                title: '创建时间',
                valign: 'middle'
            }, {
                field: 'status',
                title: '状态',
                valign: 'middle',
                formatter: function (value, row, index) {
                    return value == 1 ? '正常' : '<span class="text-warning">禁用</span>' ;
                }
            }, {
                field: 'status',
                title: '操作',
                align: 'center',
                valign: 'middle',
                formatter:  function (value, row, index) {
                    var m = '<a class="btn btn-default" type="button" href=" /category/'+row.id+'/edit">修改</a>';
                    var e  = value == 1 ?
                        '<button class="btn btn-default" type="button" onclick="disableditem('+value+ ',' + row.id +')">禁用</button> ':
                        '<button class="btn btn-default" type="button" onclick="disableditem('+value+ ',' + row.id +')">启用</button> ';
                    return e + m;
                }
            }],
        });

        $('#myModal').on('show.bs.modal', function (event) {
            $('#exampleModalLabel').val('修改类别');
            $('#cate-name').val('');
        });

        function disableditem(status, id) {
            swal({
                title: "确定此操作吗？",
                text: "",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "取消",
                confirmButtonColor: "#337ab7",
                confirmButtonText: "确认",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url: '/category/'+id,
                    type: 'POST',
                    data: {
                        status: status,
                        _method: 'PUT',
                        _token: window.Laravel.csrfToken
                    },
                    dataType: 'json',
                    success: function(data,textStatus,jqXHR){
                        swal("成功!", "", "success");
                        $("#table").bootstrapTable('refresh');
                    },
                    error: function(xhr,textStatus){
                        swal("错误!", "", "error");
                    }
                })
            });
        }

        angular.module('myModule', [])
            .controller('myController', function ($scope, $http) {
                $scope.category = {'name':''};
                $scope.save = function () {
                    $http({
                        url: "{{route('category.store')}}",
                        method:'POST',
                        data:{name: $scope.category.name}
                    }).then(function successCallback(response) {
                        swal("成功", '', "success");
                        $('#myModal').modal('hide');
                        $("#table").bootstrapTable('refresh');
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