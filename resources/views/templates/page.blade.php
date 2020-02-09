@php
    $baseUrl = \URL::to('/');
    $assetUrl = asset('templates/example/');
    $slug = $slug;
    if($slug != '') {
        require public_path().'/templates/example/page-'.$slug.'.php';
    } else {
        require public_path().'/templates/example/page.php';
    }
@endphp