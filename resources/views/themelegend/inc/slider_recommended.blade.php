@if (count($recommendations))
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="row top-movie">
        <div class="col-lg-12">
            <h2 class="header-list-index"><span class="title-list-index">Phim Đề Cử</span></h2>
            <div class="top-movie-list block-wrapper">
                <div class="list_carousel">
                    <ul id="movie-carousel-top">
                        @foreach ($recommendations ?? [] as $movie)
                            <li>
                                <a class="popup" href="{{ $movie->getUrl() }}"
                                    title="{{ $movie->name }} - {{ $movie->origin_name }}">
                                    <div class="movie-carousel-top-item"
                                        style="background-image: url('{{ $movie->getThumbUrl() }}');">
                                        <div class="movie-carousel-top-item-meta">
                                            <h3 class="movie-name-1">{{ $movie->name }}</h3>
                                            <h4 class="movie-name-2">{{ $movie->origin_name }}</h4>
                                            @if ($movie->type == 'series')
                                                <span class="ribbon" style="top:-235px;">{{ $movie->episode_current }} |
                                                    {{ $movie->language }} {{ $movie->quality }}</span>
                                            @else
                                                <span class="ribbon" style="top:-235px;">{{ $movie->language }}
                                                    {{ $movie->quality }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="clear"></div>
                    <a id="prevTop" class="prev" rel="nofollow"><span class="arrow-icon left"></span></a>
                    <a id="nextTop" class="next" rel="nofollow"><span class="arrow-icon right"></span></a>
                </div>
            </div>
        </div>
    </div>
@endif
