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
    <li class="active">文章编辑</li>
@endsection

@section('main-content')
    <div ng-app="myModule" ng-controller="myController">
        <div class="container-fluid spark-screen" >
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        文章管理
                        <a href="{{route('post.create')}}" class="btn btn-info" style="margin: -6px;float: right;">
                            <i class="glyphicon glyphicon-plus"></i> 新建
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label for="search-name">名称</label>
                                    <input type="text" class="form-control" id="search-name" placeholder="名称" name="search-name">
                                </div>
                                <div class="form-group">
                                    <label for="search-status">状态</label>
                                    <select class="form-control" id="search-status" name="search-status">
                                        <option value="">请选择</option>
                                        <option value="0">禁用</option>
                                        <option value="1">启用</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cate_id" class="control-label">分类:</label>
                                    <select chosen class="form-control" name="cate_id" id="cate_id" ng-model="post.cate_id"
                                            placeholder-text-single="'请选择分类'" no-results-text="'未找到'"
                                            ng-options="s.id as s.name for s in data.categories">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tags" class="control-label">所属TAG:</label>
                                    <select chosen class="form-control" name="tags[]" id="tags"
                                            placeholder-text-single="'请选择TAG'" no-results-text="'未找到'"
                                            ng-model="post.tags" ng-options="s.id as s.name for s in data.tags">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" onclick="btnquery()">查询</button>
                                </div>
                            </form>
                            <hr/>
                            <table id="table"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('self-javascript')
    <script>
        $('#table').bootstrapTable({
            striped: true,                      //是否显示行间隔色
            cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,                   //是否显示分页（*）
            sortName: 'id',
            sortOrder: 'desc',
            onSort: function (name, order) {
                this.sortName = name;
                this.sortOrder = order;
            },
            queryParams: function(params) { //传递参数（*）
                return {   //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
                    //search:params.search 自带的搜索框 我把自带的先隐藏了，
                    limit: params.limit,   //页面大小
                    offset: params.offset,  //页码
                    order: params.order,
                    sort: params.sort,
                    name: $("#search-name").val(),
                    status: $("#search-status").val(),
                    cate_id: $("#cate_id").val(),
                    tags: $("#tags").val(),
                    //请求服务器数据时，你可以通过重写参数的方式添加一些额外的参数，例如 toolbar 中的参数 如果 queryParamsType = 'limit' ,返回参数必须包含
                    //limit, offset, search, sort, order 否则, 需要包含: pageSize, pageNumber, searchText, sortName, sortOrder. 返回false将会终止请求
                };
            },
            sidePagination: "server",           //分页方式：client客户端分页，server服务端分页（*）
            pageNumber: 1,                       //初始化加载第一页，默认第一页
            pageSize: 2,                       //每页的记录行数（*）
            pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
            clickToSelect: true,                //是否启用点击选中行
            uniqueId: "id",                     //每一行的唯一标识，一般为主键列
            url: "{{route('post.lists')}}",
            columns: [{
                field: 'title',
                title: '名称',
                valign: 'middle',
                sortable: true,
            },{
                field: 'slug',
                title: 'Slug',
                valign: 'middle',
                sortable: true,
            },{
                field: 'cate_name',
                title: '分类',
                valign: 'middle',
            },{
                field: 'tag_name',
                title: 'Tags',
                valign: 'middle',
            },{
                field: 'created_by_name',
                title: '创建人',
                valign: 'middle',
            }, {
                field: 'created_at',
                title: '创建时间',
                valign: 'middle',
                sortable: true,
            }, {
                field: 'status',
                title: '状态',
                valign: 'middle',
                //sortable: true,
                formatter: function (value, row, index) {
                    return value == 1 ? '正常' : '<span class="text-warning">禁用</span>' ;
                }
            }, {
                field: 'status',
                title: '操作',
                align: 'center',
                valign: 'middle',
                formatter:  function (value, row, index) {
                    var m = '<a class="btn btn-default" href="/post/'+row.id+'/edit">修改</a>';
                    var e  = value == 1 ?
                        '<button class="btn btn-default" type="button" onclick="disableditem('+value+ ',' + row.id +')">禁用</button> ':
                        '<button class="btn btn-default" type="button" onclick="disableditem('+value+ ',' + row.id +')">启用</button> ';
                    return e + m;
                }
            }],
        });
        //搜索按钮事件
        function btnquery() {
            $("#table").bootstrapTable('refresh', {url: "{{route('post.lists')}}"});
            //主要解决在不是第一页搜索的情况下 如在第二页搜索搜索不到数据，但其实第一页是有数据的
            //源码
            /**
             * BootstrapTable.prototype.refresh = function (params) {
                    if (params && params.url) {
                        this.options.pageNumber = 1;
                    }
                    this.initServer(params && params.silent,
                        params && params.query, params && params.url);
                    this.trigger('refresh', params);
                };
             */
        }
        //禁用按钮事件
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
                    url: '/post/'+id,
                    type: 'POST',
                    data: {
                        status: status,
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

        angular.module('myModule', ['localytics.directives'])
            .controller('myController', function ($scope, $http) {
                $scope.post = {
                    cate_id: 0,
                    tags: 0
                };
                $http({
                    url: "{{route('post.catetag')}}",
                    method:'GET',
                }).then(function successCallback(response) {
                    $scope.data = response.data;
                }, function errorCallback(response) {
                    swal("错误", '服务异常', "error");
                })
            });
    </script>
@endsection