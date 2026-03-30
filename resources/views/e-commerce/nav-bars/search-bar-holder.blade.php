@if(in_array(request()->route()->getName(), ['search.index', 'browse-by-menu.index']))
    <main-search-bar use-bus/>
@else
    <main-search-bar />
@endif