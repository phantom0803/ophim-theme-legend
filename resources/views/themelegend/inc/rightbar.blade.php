@foreach ($tops as $top)
    <div class="right-box top-film-week">
        <h2 class="right-box-header star-icon"><span>{{ $top['label'] }}</span></a></h2>
        <div class="right-box-content">
            <ul class="list-top-movie" id="list-top-film-week">
                @foreach ($top['data'] ?? [] as $movie)
                    <li class="list-top-movie-item" id="list-top-movie-item-1">
                        <a class="list-top-movie-link" title="{{ $movie->name }}"
                            href="{{ $movie->getUrl() }}">
                            <span class="status">{{ $movie->quality }} {{ $movie->language }}</span>
                            <div class="list-top-movie-item-thumb"
                                style="background-image: url('{{ $movie->thumb_url }}')">
                            </div>
                            <div class="list-top-movie-item-info">
                                <span class="list-top-movie-item-vn">{{ $movie->name }}</span>
                                <span class="list-top-movie-item-en">{{ $movie->origin_name }}</span>
                                <span class="list-top-movie-item-view">{{ $movie->view_total }} lượt xem</span>
                                <span class="rate-vote rate-vote-{{number_format($movie->rating_star ?? 0, 0)}}"></span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="clear"></div>
@endforeach
