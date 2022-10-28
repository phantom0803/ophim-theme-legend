@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header>
    <div class="header">
        <div class="container">
            <div class="header-logo">
                <a class="logo" href="/" title="{{ $title }}">
                    @if ($logo)
                        {!! $logo !!}
                    @else
                        {!! $brand !!}
                    @endif
                </a>
            </div>
            <div id="header-search-form" class="widget_search">
                <form method="GET" id="form-search" action="/">
                    <div><input type="text" name="search" placeholder="Tìm kiếm phim..." value="{{ request('search') }}"></div>
                </form>
                <div class="search-suggest" style="display: none;">
                    <ul style="margin-bottom: 0;" id="search-suggest-list"></ul>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="clear"></div>
