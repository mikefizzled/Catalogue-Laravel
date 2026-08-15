@extends('layouts.error')

@section('title', '503 – Gone for a brief migration')

@section('content')
  <x-error-page
    image="{{ Storage::disk('s3')->url('site/images/jackdaw-error.webp') }}"
    title="503 – We’ll be right back"
    message="The birds have gone for a brief migration and will return shortly."
    button-text="Check Again Later"
    button-url="{{ url()->current() }}"
  />
@endsection
