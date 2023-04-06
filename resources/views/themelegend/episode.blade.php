@extends('themes::themelegend.layout')

@push('header')
    <style>
        #media-player-box iframe {
            height: 365px;
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb" itemScope itemType="https://schema.org/BreadcrumbList">
        <li itemProp="itemListElement" itemScope itemType="http://schema.org/ListItem">
            <a class="" itemProp="item" title="Xem phim" href="/">
                <span class="" itemProp="name">
                    Xem phim
                </span>
                <meta itemProp="position" content="1" />
            </a>
        </li>
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a class="" itemprop="item"
                href="/danh-sach/{{ $currentMovie->type == 'single' ? 'phim-le' : 'phim-bo' }}"
                title="{{ $currentMovie->type == 'single' ? 'Phim lẻ' : 'Phim bộ' }}">
                <span itemprop="name">
                    {{ $currentMovie->type == 'single' ? 'Phim lẻ' : 'Phim bộ' }}
                </span>
            </a>
            <meta itemprop="position" content="2">
        </li>

        @foreach ($currentMovie->regions as $region)
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a class="" itemprop="item" href="{{ $region->getUrl() }}" title="{{ $region->name }}">
                    <span itemprop="name">
                        {{ $region->name }}
                    </span>
                </a>
                <meta itemprop="position" content="3">
            </li>
        @endforeach
        @foreach ($currentMovie->categories as $category)
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a class="" itemprop="item" href="{{ $category->getUrl() }}" title="{{ $category->name }}">
                    <span itemprop="name">
                        {{ $category->name }}
                    </span>
                </a>
                <meta itemprop="position" content="3">
            </li>
        @endforeach
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="{{ $currentMovie->getUrl() }}" title="{{ $currentMovie->name }}">
                <span itemprop="name">
                    {{ $currentMovie->name }}
                </span>
            </a>
            <meta itemprop="position" content="4">
        </li>
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="{{ url()->current() }}" title="Tập {{ $episode->name }}">
                <span class="breadcrumb_last" itemprop="name">
                    Tập {{ $episode->name }}
                </span>
            </a>
            <meta itemprop="position" content="5">
        </li>
    </ol>

    <div class="clear"></div>
@endsection

@push('header')
@endpush

@section('content')
    <div id="output"></div>
    <div class="block-wrapper page-single" id="block-player">
        <div class="movie-info movie-info-watch watch-info-box" id="movie-info">
            <div class="block-movie-info">
                <div class="row">
                    <div class="col-9 movie-detail">
                        <h1 class="movie-title">
                            <span class="title-1" itemprop="name">{{ $currentMovie->name }}</span>
                            <span class="title-2" itemprop="name">{{ $currentMovie->origin_name }}</span>
                        </h1>
                        <div class="film-description-box">
                            <p class="film-description-short">{!! strip_tags($currentMovie->content) !!}</p>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="col-3 movie-image">
                        <div class="movie-l-img">
                            <img itemprop="image" alt="{{ $currentMovie->name }} - {{ $currentMovie->origin_name }}"
                                src="{{ $currentMovie->getThumbUrl() }}" />
                            <div class="movie-watch-link-box">
                                <a class="movie-watch-link"
                                    title="Xem phim {{ $currentMovie->name }} - {{ $currentMovie->origin_name }} Tập {{ $episode->name }}">Tập
                                    {{ $episode->name }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($currentMovie->notify && $currentMovie->notify != '')
            <div class="block-wrapper page-single block-note">
                Thông báo: <span class="text-danger">{{ strip_tags($currentMovie->notify) }}</span>
            </div>
        @endif

        @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
            <div class="block-wrapper page-single block-note">
                Lịch chiếu: <span class="text-info">{!! $currentMovie->showtimes !!}</span>
            </div>
        @endif

        <div id="watch-block" class="small-player">

            <div class="media-player uniad-player" id="media-player-box">

            </div>

            <div id="go-server">
                <center>
                    <ul class="server-list">
                        <li class="backup-server"> <span class="server-title">Đổi Sever</span>
                            <ul class="list-episode">
                                <li class="episode">
                                    @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                        <a data-id="{{ $server->id }}" data-link="{{ $server->link }}"
                                            data-type="{{ $server->type }}" onclick="chooseStreamingServer(this)"
                                            class="streaming-server btn-link-backup btn-episode black episode-link">VIP
                                            #{{ $loop->index + 1 }}</a>
                                    @endforeach
                                </li>
                            </ul>
                        </li>
                    </ul>
                </center>
            </div>
            <div class="user-action">
                <div id="btn-light" class="btn-cs light-off"><i class="btn-cs-icon icon-light-sm"></i><span
                        id="light-status">Tắt đèn</span></div>
                <div id="btn-expand" class="btn-cs expand-player" title="Phóng to/Thu nhỏ player"><i
                        class="btn-cs-icon icon-expand-sm"></i><span id="expand-status">Phóng to</span></div>
                <a id="btn-toggle-error" class="btn-cs error-player"
                    title="Báo lỗi phim {{ $currentMovie->name }} - {{ $currentMovie->origin_name }}"
                    href="javascript:void(0)"><i class="btn-cs-icon icon-error-sm"></i><span>Báo lỗi</span></a>

                <div class="box-rating">
                    <input id="hint_current" type="hidden" value="">
                    <input id="score_current" type="hidden"
                        value="{{$currentMovie->getRatingStar()}}">
                    <p>Đánh giá phim <span class="num-rating">({{$currentMovie->getRatingStar()}} sao
                            / {{$currentMovie->getRatingCount()}} đánh giá)</span></p>
                    <div id="star" data-score="{{$currentMovie->getRatingStar()}}"
                        style="cursor: pointer;"></div>
                    <span id="hint"></span>
                    <img class="hidden" itemprop="thumbnailUrl" src="{{ $currentMovie->getThumbUrl() }}"
                        alt="{{ $currentMovie->name }}">
                    <img class="hidden" itemprop="image" src="{{ $currentMovie->getThumbUrl() }}"
                        alt="{{ $currentMovie->name }}">
                    <span class="hidden" itemprop="aggregateRating" itemscope
                        itemtype="http://schema.org/AggregateRating">
                        <span itemprop="ratingValue">{{$currentMovie->getRatingStar()}}</span>
                        <meta itemprop="ratingcount" content="{{$currentMovie->getRatingCount()}}">
                        <meta itemprop="bestRating" content="10" />
                        <meta itemprop="worstRating" content="1" />
                        <span class="hidden" itemprop="reviewCount">0</span>
                    </span>
                </div>
            </div>
        </div>
        <div class="ad-container watch-banner-2" id="adtop-watch">
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="ad-container watch-banner-2"></div>
        <div class="list-server">
            @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                <div class="server clearfix server-group">
                    <h3 class="server-name"> {{ $server }} </h3>
                    <ul class="list-episode">
                        @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                            <li class="episode">
                                <a class="btn-episode episode-link btn3d black @if ($item->contains($episode)) active @endif"
                                    title="{{ $name }}"
                                    href="{{ $item->sortByDesc('type')->first()->getUrl() }}">{{ $name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="clear"></div>
        <div class="block-tags">
            <h3 class="movie-detail-h3">Từ khóa:</h3>
            <ul class="tag-list" itemprop="keywords" style="font-size:12px;">
                @foreach ($currentMovie->tags as $tag)
                    <li class="tag-item"><a href="{{ $tag->getUrl() }}"
                            title="{{ $tag->name }}">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <div class="ad-top-comment page-single" style="padding: 0;">
    </div>
    <div class="block-wrapper page-single block-comments" id="block-comment">
        <h4>Bình luận về phim</h4>
        <div style="width: 100%; background-color: #fff">
            <div class="fb-comments" data-href="{{ $currentMovie->getUrl() }}" data-width="100%" data-colorscheme="dark"
                data-numposts="5" data-order-by="reverse_time" data-lazy="true"></div>
        </div>
    </div>

    <div class="clear"></div>
    <div class="movie-list-index related-box">
        <h2 class="header-list-index">
            <span class="title-list-index">Có thể bạn thích xem</span>
        </h2>
        <ul class="list-movie">
            @foreach ($movie_related ?? [] as $movie)
                <li class="movie-item">
                    <a class="block-wrapper" title="{{ $movie->name }}" href="{{ $movie->getUrl() }}">
                        <div class="movie-thumbnail"
                            style="background:url({{ $movie->getThumbUrl() }}); background-size: cover;">
                        </div>
                        <div class="movie-meta">
                            <span class="movie-title-1">{{ $movie->name }}</span>
                            <span class="movie-title-2">{{ $movie->origin_name }}</span>
                            <span class="movie-title-chap">{{ $movie->publish_year }}</span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="clear"></div>
    <div class="clear"></div>
@endsection

@push('scripts')
    <script src="/themes/legend/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/legend/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('#media-player-box').offset().top - 40
            }, 'slow');
        });
    </script>

    <script>
        var episode_id = {{$episode->id}};
        const wrapper = document.getElementById('media-player-box');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active');
            })
            el.classList.add('active');

            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/legend/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{$episode->id}}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    <script type="text/javascript">
        var URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
        var URL_POST_REPORT_ERROR = '{{ route('episodes.report', ['movie' => $currentMovie->slug, 'episode' => $episode->slug, 'id' => $episode->id]) }}';
    </script>
    <script type="text/javascript" src="/themes/legend/js/jquery.raty.js"></script>
    <script type="text/javascript" src="/themes/legend/js/public.film.js"></script>
    <script type="text/javascript" src="/themes/legend/js/film-info.js"></script>
    <script type="text/javascript" src="/themes/legend/js/phimv2.3.js"></script>
    <script type="text/javascript" src="/themes/legend/js/fx/util.js"></script>
    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
