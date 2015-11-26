@extends('site')


@section('content')

   
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $page->name }}</h1>
        </div>
    </div>

    @if (isset($categories))

        <div class="portfolio clearfix">
            @foreach ($categories as $category)
                <a href="{{ route_page($page, [$category->slug]) }}" class="item">
                    <div class="mask">
                        <div>
                            <span class="title">
                                {{ $category->name }}
                            </span>
                            <span class="separator"></span>
                            <span class="summary">
                                {!! str_limit($category->description, 50, '...') !!}
                            </span>
                        </div>
                    </div>
                    @if (isset($category->pictures[0]))
                        <img src="{{ route('picture', ['portfolio', $category->pictures[0]['name']] ) }}" />
                    @endif 
                </a>
            @endforeach
        </div>

    @elseif (isset($category))  

        <div class="portfolio clearfix">
            @foreach ($category->galleries as $gallery)
                <a href="{{ route_page($page, [$category->slug, $gallery->slug]) }}" class="item">
                    <div class="mask">
                        <div>
                            <span class="title">
                                {{ $gallery->name }}
                            </span>
                            <span class="separator"></span>
                            <span class="summary">
                                {!! str_limit($gallery->description, 50, '...') !!}
                            </span>
                        </div>
                    </div>
                    @if (isset($gallery->pictures[0]))
                        <img src="{{ route('picture', ['portfolio', $gallery->pictures[0]['name']] ) }}" />
                    @endif 
                </a>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route_page($page) }}" class="button">{{ trans('site.global.action.back') }}</a>
            </div>
        </div>

    @elseif (isset($gallery))   

        <div class="portfolio clearfix">
            @foreach ($gallery->pictures as $picture)
                <a href="{{ route('picture', ['zoom', $picture['name']] ) }}" class="item">
                    <div class="mask">
                        <div>
                            <span class="title">
                                {{ $picture->name }}
                            </span>
                            <span class="separator"></span>
                            <span class="summary">
                                {!! str_limit($picture->legend, 50, '...') !!}
                            </span>
                        </div>
                    </div>
                    <img src="{{ route('picture', ['portfolio', $picture['name']] ) }}" />
                </a>
                
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route_page($page, [$gallery->category->slug]) }}" class="button">{{ trans('site.global.action.back') }}</a>
            </div>
        </div>

    @endif 

@endsection

