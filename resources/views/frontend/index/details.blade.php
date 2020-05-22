@extends('frontend.layouts.app')

@section('title', $info->title)

@section('description', $info->description)

@section('content')
    <div class="col-md-9">
        <div class="blog-main">
            <div class="heading-blog">
                {!! $info->title !!}
            </div>

            <div class="blog-info">
                <p>
                    <span class="label label-success">{!! $info->category->name !!}</span>
                    @if($info->articleLabelOtm->count())
                        @foreach($info->articleLabelOtm as $k => $v)
                            <span class="label label-info">{!! $lsLabel[$v->label_id]!!}</span>
                        @endforeach
                    @endif
                </p>
                <p>
                    <span class="label label-primary">{!! $info->created_at !!}</span>
                    <span class="label label-default"><i class="fa fa-eye"></i>&nbsp;{!! $info->hits !!}</span>
                </p>
            </div>

            <div class="blog-txt">
                @include('extensions.editormd', ['docContent'=>$info->content])
            </div>
        </div>
    </div>
@endsection
