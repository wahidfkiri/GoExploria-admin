@extends('theme::layout')

@section('title', $page->title ?? 'Page')

@section('content')
<section class="page-content">
    <div class="container">
        <div class="page-body">
            {!! $content ?? '' !!}
        </div>
    </div>
</section>
@endsection