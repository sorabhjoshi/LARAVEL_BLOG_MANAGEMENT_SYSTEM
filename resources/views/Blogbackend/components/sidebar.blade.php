@php
    use Illuminate\Support\Facades\Route;
@endphp

<style>
    :root {
--primary-color: #4a90e2;
--bg-color: white;
--text-color: rgb(255, 255, 255);
--sidebar-bg: #2d3e50;
--sidebar-hover: #3e5773;
}

.dark {
--primary-color: #90caf9; /* Lighter blue for dark mode */
--bg-color: #121212; /* Dark background */
--text-color: #ffffff; /* Light text color */
--sidebar-bg: #1e1e1e; /* Dark sidebar background */
--sidebar-hover: #333333; /* Slightly lighter hover effect */
}

body {
font-family: 'Poppins', sans-serif;
margin: 0;
padding: 0;
background-color: var(--bg-color);
/* color: var(--text-color); */
}

.sidebar {
height: 100vh;
width: 300px;
position: fixed;
z-index: 1;
top: 0;
left: 0;
background-color: var(--sidebar-bg);
overflow-y: auto;
transition: 0.3s;
box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
white-space: nowrap;
}

/* Hide scrollbar for modern browsers */
.sidebar::-webkit-scrollbar {
width: 0;
height: 0;
}

.sidebar {
scrollbar-width: none;
-ms-overflow-style: none;
}

.sidebar-header {
padding: 24px;
display: flex;
align-items: center;
justify-content: space-between;
border-bottom: 1px solid #e0e0e0;
}

.sidebar-header h3 {
margin: 0;
font-size: 1.2em;
color: var(--primary-color);
}

.toggle-btn {
background: none;
border: none;
color: var(--text-color);
font-size: 20px;
cursor: pointer;
transition: 0.2s;
}

.toggle-btn:hover {
color: var(--primary-color);
}

.sidebar a {
padding: 15px 16px !important;
text-decoration: none;
font-size: 16px;
color: var(--text-color);
display: flex;
align-items: center;
transition: 0.2s;
}
.headerimg a{
    padding: 15px 22px !important;
}

.sidebar a:hover {
background-color: var(--sidebar-hover);
color: var(--primary-color);
}

.sidebar a i {
min-width: 30px;
font-size: 20px;
}

#main {
transition: margin-left .3s;
padding: 20px;
margin-left: 300px;
}

.sidebar.closed {
width: 65px;
}

.sidebar.closed .sidebar-header h3 {
display: none;
}

.sidebar.closed a span {
display: none;
}

.sidebar.closed~#main {
margin-left: 70px;
}

.menu,
.menu ul {
list-style: none;
padding: 0;
margin: 0;
}

.menu-toggle-icon {
margin-left: auto;
font-size: 16px;
}

#btn {
cursor: pointer;
}

@media screen and (max-width: 768px) {
.sidebar {
    width: 70px;
}
.sidebar a {
padding: 15px 25px !important;
}
.sidebar .sidebar-header h3 {
    display: none;
}

.sidebar a span {
    display: none;
}

#main {
    margin-left: 70px;
}

.sidebar.open {
    width: 300px;
}

.sidebar.open .sidebar-header h3 {
    display: block;
}

.sidebar.open a span {
    display: inline;
}

.sidebar.open~#main {
    margin-left: 300px;
}
}

/* Dark Mode Styles */
.dark body {
background-color: var(--bg-color);
/* color: var(--text-color); */
}

.dark .sidebar {
background-color: var(--sidebar-bg);
box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
}

.dark .sidebar a {
color: var(--text-color);
}

.dark .sidebar a:hover {
background-color: var(--sidebar-hover);
color: var(--primary-color);
}

.dark .sidebar-header h3 {
color: var(--primary-color);
}

.dark .toggle-btn {
color: var(--text-color);
}

.dark .toggle-btn:hover {
color: var(--primary-color);
}

.dark .menu-toggle-icon {
color: var(--text-color);
}
@media (max-width: 768px) {
   
    .headerimg button{
        padding: 14px 16px !important;
    }
     .headerimg{
        padding: 0;
    } 
    .main-content {
    margin-left: 70px;
}
.data-card{
    width: 450px;
}
}
.headerimg button {
    padding: 14px 18px !important;
    border-bottom: 1px solid #4b5c70 !important;
}

</style>
<aside class="sidebar" id="mySidebar">

    <div class="headerimg">
        <a href="{{route('home')}}" class="imghead">
            <img src="https://www.absglobaltravel.com/public/images/absolute-global-travel-logo.webp" alt="" class="imghead">
        </a>
        <button class="toggle-btn" >
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="sidebar-content">
        <ul class="menu">
            @foreach($menu->json_output as $item)
                @php
                    $hasValidRoute = !empty($item['href']) && Route::has($item['href']); 
                @endphp
                <li class="menu-item">
                    <a href="{{ $hasValidRoute ? route($item['href']) : 'javascript:void(0);' }}" class="menu-link menu-toggle">
                        <i class="menu-icon {{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                        <div data-i18n="{{ $item['title'] ?? '' }}">{{ $item['text'] }}</div>
                        @if(!empty($item['children']))
                            <span class="dropdown-icon mr-4"></span> <!-- Icon for dropdown toggle -->
                        @endif
                    </a>
                    @if(!empty($item['children']) && $item['deletestatus']==0)
                        <ul class="menu-sub">
                            @foreach($item['children'] as $child)
                                @php
                                    $childHasValidRoute = !empty($child['href']) && Route::has($child['href']) && $child['deletestatus']==0
                                @endphp
                                @if(($childHasValidRoute || !empty($child['children']) && $child['deletestatus']==0))
                                    <li class="menu-item" id="child">
                                        <a href="{{ $childHasValidRoute ? route($child['href']) : 'javascript:void(0);' }}" class="menu-link">
                                            <i class="menu-icon {{ $child['icon'] ?? 'fas fa-circle' }}"></i>
                                            <div data-i18n="{{ $child['title'] ?? '' }}">{{ $child['text'] }}</div>
                                        </a>
                                        @if(!empty($child['children']))
                                            <ul class="menu-sub">
                                                @foreach($child['children'] as $subChild)
                                                    @php
                                                        $subChildHasValidRoute = !empty($subChild['href']) && Route::has($subChild['href']);
                                                    @endphp
                                                    @if($subChildHasValidRoute)
                                                        <li class="menu-item" id="child">
                                                            <a href="{{ route($subChild['href']) }}" class="menu-link">
                                                                <i class="menu-icon {{ $subChild['icon'] ?? 'fas fa-circle' }}"></i>
                                                                <div data-i18n="{{ $subChild['title'] ?? '' }}">{{ $subChild['text'] }}</div>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
                             
    </div>
</aside>
