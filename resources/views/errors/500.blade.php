@extends('layouts.error')

@section('title', '500 – Something’s gone wrong')

@section('content')
  <x-error-page
    image="{{ asset('jackdaw-error.jpg') }}"
    title="500 – Oops, our nest got scrambled"
    message="Give us a moment to straighten out our feathers."
    button-text="Try Again"
    button-url="javascript:location.reload()"
  />
@endsection
