<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="@yield('description')" />
    <meta name="author" content="" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Lgbya Blog @yield('title')</title>
    {{--<link rel="shortcut icon"  href={!! asset('style/image/icon.png')!!} >--}}
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href={!! asset('style/assets/css/bootstrap.css')!!} rel="stylesheet" />
    <!-- FONTAWESOME STYLE CSS -->
    <link href={!! asset('style/assets/css/font-awesome.css')!!} rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href={!! asset('style/assets/css/style.css')!!} rel="stylesheet" />
    <script src={!! asset('style/js/jQuery-2.1.4.min.js') !!}></script>
</head>
<body>

<section class="header-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-5 text-center">
                <h1><strong>Lgbya </strong></h1>
                <h4>Blogger & Designer</h4>
            </div>

        </div>
    </div>
</section>
<br>
<section>
    <div class="container">
        <div class="row">
            @yield('content')

            <div class="col-md-3">
                <div>
                    <form action="">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">关键字搜索</h3>
                            </div>
                            <div class="panel-body">
                                <input type="text" name="search_keyword" class="form-control" placeholder="关键字:分类,标签,标题,描述" />
                                <hr />
                                <input type="submit"  class="btn btn-info btn-sm btn-block" value="搜索">
                            </div>
                        </div>
                    </form>

                </div>

                <ul class="list-group">

                    <li class="list-group-item">
                        <strong>文章分类</strong>
                    </li>
                    <li class="list-group-item">
                        {{--<span class="badge">104</span>--}}
                        <a href="/">首页</a>
                    </li>
                    @foreach($lsCategory as $k => $v)

                        <li class="list-group-item">
                            {{--<span class="badge">104</span>--}}
                            <a href="{!! url('/') . '?category_id=' . $v->id !!}">{!! $v->name !!}</a>
                        </li>
                    @endforeach
                    {{--<li class="list-group-item">--}}
                    {{--<strong>个人计划</strong>--}}
                    {{--</li>--}}
                    {{--<li class="list-group-item">--}}
                    {{--<span class="badge">104</span>--}}
                    {{--Technology--}}
                    {{--</li>--}}
                </ul>
                <br />

                {{--<ul class="list-group">--}}
                {{--<li class="list-group-item">Advrtisements--}}
                {{--</li>--}}
                {{--<li class="list-group-item">--}}
                {{--<a href="#">--}}
                {{--<img src="assets/img/ad1.jpg" class="img-responsive" />--}}
                {{--</a>--}}
                {{--<br />--}}
                {{--</li>--}}
                {{--</ul>--}}
            </div>

        </div>
    </div>
</section>

<hr />
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center set-foot">
            &copy {!! date('Y-m-d') !!} lgbya
        </div>
    </div>
</div>

</body>
</html>
