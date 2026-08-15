@extends('layouts.error')

@section('title', '404 – Page not found')

@section('content')
  <x-error-page
    image="{{ Storage::disk('s3')->url('site/images/rook-error.webp') }}"
    title="404 – Page not found"
    message="This page is proving elusive"
    button-text="Fly Home"
  />
@endsection
