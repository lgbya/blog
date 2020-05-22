@extends('frontend.layouts.app')

@section('title', '首页')

@section('description', 'lgbya 个人博客 php golang erlang mysql redis')

@section('content')
    <div class="col-md-9">
        @foreach($lsArticle as $k => $v)
            <div class="blog-main">
                <a href="{!! url('/details',[ 'id' => $v->id ])!!}">
                    <div class="heading-blog">
                        {!! $v->title !!}
                    </div>
                    @if($v->image)
                        <img src="{!! \Storage::disk('admin')->url($v->image) !!}" class="img-responsive img-rounded" />
                    @endif
                </a>
                <div class="blog-info">
                    <p>
                        <span class="label label-default">分类:</span>
                        <a href="{!! url('/') . '?category_id=' . $v->category_id !!}">
                            <span class="label label-success">{!! $v->category->name !!}</span>
                        </a>
                    </p>
                    @if($v->articleLabelOtm->count())
                        <p>
                            <span class="label label-default">标签:</span>
                            @foreach($v->articleLabelOtm as $k2 => $v2)
                                @if(isset($lsLabel[$v2->label_id]))
                                <a href="{!! url('/') . '?label_id=' . $v2->label_id !!}">
                                    <span class="label label-info">{!! $lsLabel[$v2->label_id]!!}</span>
                                </a>
                                @endif
                            @endforeach
                        </p>
                    @endif
                    <p>
                        <span class="label label-primary">{!! $v->created_at !!}</span>
                        <span class="label label-default"><i class="fa fa-eye"></i>&nbsp;{!! $v->hits !!}</span>
                    </p>
                </div>
                @if($v->description)
                    <div class="blog-txt">
                        {!! $v->description !!}
                    </div>
                @endif
            </div>
        @endforeach
        {{--<div style="text-align: center">{{ $lsArticle->render() }}</div>--}}
        <nav>{{ $lsArticle->render() }}</nav>
        <!--PAGING  END -->
    </div>
@endsection
