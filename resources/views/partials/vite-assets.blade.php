@php
    $hasViteAssets = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
@endphp

@if($hasViteAssets)
    @vite($entries)
@else
    <script src="https://cdn.tailwindcss.com"></script>
@endif
