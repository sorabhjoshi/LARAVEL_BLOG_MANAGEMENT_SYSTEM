

<aside class="sidebar">

    <div class="img">
        <a href="{{route('home')}}" class="headerimg">
            <img src="https://www.absglobaltravel.com/public/images/absolute-global-travel-logo.webp" alt="">
        </a>
    </div>
    <div class="sidebar-content">
        <ul class="menu">
            @foreach($menu->json_output as $item)
                <li class="menu-item">
                    <a href="{{ $item['href'] ? route($item['href']) : 'javascript:void(0);' }}" class="menu-link menu-toggle">
                        <i class="menu-icon {{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                        <div data-i18n="{{ $item['title'] ?? '' }}">{{ $item['text'] }}</div>
                        @if(!empty($item['children']))
                            <span class="dropdown-icon mr-4"></span> <!-- Icon for dropdown toggle -->
                        @endif
                    </a>
                    @if(!empty($item['children']))
                        <ul class="menu-sub">
                            @foreach($item['children'] as $child)
                                <li class="menu-item">
                                    <a href="{{ $child['href'] ? route($child['href']) : 'javascript:void(0);' }}" class="menu-link">
                                        <i class="menu-icon {{ $child['icon'] ?? 'fas fa-circle' }}"></i>
                                        <div data-i18n="{{ $child['title'] ?? '' }}">{{ $child['text'] }}</div>
                                    </a>
                                    @if(!empty($child['children']))
                                        <ul class="menu-sub">
                                            @foreach($child['children'] as $subChild)
                                                <li class="menu-item">
                                                    <a href="{{ $subChild['href'] ? route($subChild['href']) : 'javascript:void(0);' }}" class="menu-link">
                                                        <i class="menu-icon {{ $subChild['icon'] ?? 'fas fa-circle' }}"></i>
                                                        <div data-i18n="{{ $subChild['title'] ?? '' }}">{{ $subChild['text'] }}</div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>                     
    </div>
</aside>