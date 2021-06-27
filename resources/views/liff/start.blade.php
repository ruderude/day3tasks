@extends('layouts.app')

@section('content')
<div class="">
    <Start :csrf="{{json_encode(csrf_token())}}"></Start>
</div>
@endsection