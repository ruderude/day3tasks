@extends('layouts.app')

@section('content')
<div>
    <Today liff-id="{{env('VUE_APP_LIFF_ID')}}"></Today>
</div>
@endsection