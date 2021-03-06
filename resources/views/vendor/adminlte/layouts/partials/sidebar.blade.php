<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    {{--<img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />--}}
                    <img src="{{ asset('/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li <?php if(Request::path() == 'home') echo 'class="active"'; ?>><a href="{{ url('home') }}"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <li><a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.anotherlink') }}</span></a></li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>{{ trans('adminlte_lang::message.multilevel') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li>
            <?php
                $post = $category = $tag = $comment = $art = '';
               if(Request::is('post*')) $post = $art = 'active';
               if(Request::is('category*')) $category = $art = 'active';
               if(Request::is('tag*')) $tag = $art = 'active';
               if(Request::is('comment*')) $comment = $art = 'active';
            ?>
            <li class="treeview {{ $art }}"  >
                <a href="#"><i class='fa fa-link'></i> <span>文章管理</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ $post }}" ><a href="{{route('post.index')}}">文章模块</a></li>
                    <li class="{{ $category }}" ><a href="{{route('category.index')}}">类别模块</a></li>
                    <li class="{{ $tag }}" ><a href="{{route('tag.index')}}">标签模块</a></li>
                    <li class="{{ $comment }}" ><a href="{{route('comment.index')}}">评论模块</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-link'></i> <span>权限管理</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    {{--<li><a href="{{route('user.index')}}">用户管理</a></li>--}}
                    {{--<li><a href="{{route('role.index')}}">角色管理</a></li>--}}
                    {{--<li><a href="{{route('permission.index')}}">权限管理</a></li>--}}
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
