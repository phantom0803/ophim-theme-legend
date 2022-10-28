@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 8]);
                try {
                    $data[] = [
                        'label' => $label,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@push('header')
    <link href="/themes/legend/css/theme1.css" rel="stylesheet">
    <link href="/themes/legend/css/styles.css" rel="stylesheet">
    <link href="/themes/legend/css/phim.css" rel="stylesheet">
    <link href="/themes/legend/css/theme2.css" rel="stylesheet">
    <link href="/themes/legend/css/theme3.css" rel="stylesheet">
@endpush

@section('body')
    @include('themes::themelegend.inc.header')
    @include('themes::themelegend.inc.nav')
    @if (get_theme_option('ads_header'))
        <div class="ad-container watch-banner-2">
            {!! get_theme_option('ads_header') !!}
        </div>
    @endif
    <div class="container">
        @yield('slider_recommended')
        @yield('breadcrumb')
        @yield('catalog_filter')
        <div class="row">
            <div class="col-lg-8">
                @yield('content')
            </div>
            <div class="col-lg-4 sidebar" id="sidebar">
                @include('themes::themelegend.inc.rightbar')
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
@endsection

@section('footer')
    <footer>
        <div class="footer">
            <div class="container">
                {!! get_theme_option('footer') !!}
            </div>
        </div>
    </footer>

    @if (get_theme_option('ads_catfish'))
        <div id="catfish" style="width: 100%;position:fixed;bottom:0;left:0;z-index:222" class="mp-adz">
            <div style="margin:0 auto;text-align: center;overflow: visible;" id="container-ads">
                {!! get_theme_option('ads_catfish') !!}
            </div>
        </div>
    @endif

    <script type="text/javascript" src="/themes/legend/js/jquery.js"></script>
    <script type="text/javascript" src="/themes/legend/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/themes/legend/js/carouFredSel.js"></script>
    <script type="text/javascript" src="/themes/legend/js/jquery.hoverIntent.minified.js"></script>
    <script type="text/javascript" src="/themes/legend/js/jquery.dcmegamenu.js"></script>
    <script type="text/javascript" src="/themes/legend/js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/themes/legend/js/jquery.ellipsis.js"></script>
    <script type="text/javascript" src="/themes/legend/js/bootstrap.js"></script>
    <script type="text/javascript" src="/themes/legend/js/common.js"></script>
    <script type="text/javascript" src="/themes/legend/js/global.js"></script>

    {!! setting('site_scripts_google_analytics') !!}
@endsection
