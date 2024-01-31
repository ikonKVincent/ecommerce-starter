@if (setting('seo_robot') && !isset($seo_robot))
    <meta name="robots" content="all">
@elseif(isset($seo_robot))
    @if ($seo_robot)
        <meta name="robots" content="{{ $seo_robot }}">
    @else
        @if (setting('seo_robot'))
            <meta name="robots" content="all">
        @else
            <meta name="robots" content="none">
        @endif
    @endif
@else
    <meta name="robots" content="none">
@endif
<title>{{ isset($seo_title) ? $seo_title : setting('seo_title') }}</title>
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta name="title" content="{{ isset($seo_title) ? $seo_title : setting('seo_title') }}">
<meta name="description" content="{{ isset($seo_description) ? $seo_description : setting('seo_description') }}">
<meta name="author" content="{{ env('APP_NAME') }}">
<meta property="og:type" content="{{ isset($seo_type) ? $seo_type : 'website' }}">
@if (isset($seo_route))
    <meta property="og:url" content="{{ $seo_route }}" />
    <link rel="canonical" href="{{ $seo_route }}">
@endif
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta property="og:title" content="{{ isset($seo_description) ? $seo_description : setting('seo_description') }}" />
<meta property="og:description" content="{{ isset($seo_description) ? $seo_description : setting('seo_description') }}">
@if (isset($seo_image) && $seo_image)
    <meta property="og:image" content="{{ $seo_image }}">
@endif
<meta name="twitter:card" content="summary_large_image" />
@if (isset($seo_route))
    <meta name="twitter:url" content="{{ $seo_route }}">
@endif
<meta name="twitter:title" content="{{ isset($seo_title) ? $seo_title : setting('seo_title') }}">
<meta name="twitter:description" content="{{ isset($seo_description) ? $seo_description : setting('seo_description') }}">
@if (isset($seo_image) && $seo_image)
    <meta name="twitter:image" content="{{ $seo_image }}">
@endif
@yield('seo_tags')
@hasSection('seo_ld_json')
    @yield('seo_ld_json')
@else
    <script type="application/ld+json">{"@context":"https://schema.org","@type":"{{ isset($seo_type)?$seo_type:'website' }}","name":"{{ isset($seo_title)?$seo_title:setting('seo_title')}}","description":"{{ isset($seo_description)?$seo_description:setting('seo_description')}}"{!!  isset($seo_route)?',"url":"'.$seo_route.'"':'' !!}}</script>
@endif
