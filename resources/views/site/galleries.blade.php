@extends('site')


@section('content')

   
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
                                {!! str_limit($category->description, 75, '...') !!}
                            </span>
                        </div>
                    </div>
                
                    @if (isset($category->pictures[0]))
                        <img src="{{ route('picture', ['portfolio', $category->pictures[0]['name']] ) }}" />
                    @else
                        <img src="{{ route('picture', ['portfolio', $category->galleries[0]->pictures[0]['name']] ) }}" />
                    @endif 
                </a>
            @endforeach
        </div>

    @elseif (isset($category))  
        
        @if (count($category->galleries)>0)
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
                                    {!! str_limit($gallery->description, 75, '...') !!}
                                </span>
                            </div>
                        </div>
                        @if (isset($gallery->pictures[0]))
                            <img src="{{ route('picture', ['portfolio', $gallery->pictures[0]['name']] ) }}" />
                        @endif 
                    </a>
                @endforeach
            </div>
        @else
            <p>{{ trans('site.galleries.message.nocontent') }}</p>
        @endif    

        <div class="actions clearfix">
            <a href="{{ route_page($page) }}" class="button">{{ trans('site.global.action.back') }}</a>
        </div>

    @elseif (isset($gallery))   

        <div class="portfolio">
            @foreach ($gallery->pictures as $picture)
                <a href="{{ route('picture', ['zoom', $picture['name']] ) }}" title="{{ $picture->title }}" class="item lightbox" rel="gallery">
                    <div class="mask">
                        <div>
                            @if ($picture->title)
                                <span class="title">
                                    {{ $picture->title }}
                                </span>
                            @endif 
                        </div>
                    </div>
                    <img src="{{ route('picture', ['portfolio', $picture['name']] ) }}" />
                </a>
                
            @endforeach
        </div>

        <div class="actions clearfix">
            <a href="{{ route_page($page, [$gallery->category->slug]) }}" class="button">{{ trans('site.global.action.back') }}</a>
        </div>

    @endif 

@endsection


@section('javascript')

    @parent
    
    <script>
      $(window).load(function() {  
            $('.portfolio').gridify( {
                srcNode: '.item img',               // grid items (class, node)
                margin: '10px',                     // margin in pixel, default: 0px
                max_width: '400px',                 // dynamic gird item width if specified, (pixel)
                resizable: true,                    // re-layout if window resize
                loaded: function(elem) {
                    $(this).addClass('loaded');
                }
            });
        });
    </script>

@endsection

