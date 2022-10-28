<nav>
    <div class="clear"></div>
    <div class="container">
        <div class="menu-menu-1-container">
            <ul id="mega-menu-1" class="menu">
                @foreach ($menu as $item)
                    @if (count($item['children']))
                        <li><a title="{{ $item['name'] }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a>
                            <ul>
                                @foreach ($item['children'] as $children)
                                    <li><a title="{{ $children['name'] }}" href="{{ $children['link'] }}">{{ $children['name'] }}</a></li>
                                @endforeach

                            </ul>
                        </li>
                    @else
                        <li><a title="{{ $item['name'] }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
<div class="clear"></div>
