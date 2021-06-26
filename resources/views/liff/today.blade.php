@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">今日のタスク</div>

                <div class="card-body">
                今日のタスク
                </div>
            </div>
            <List></List>
        </div>
    </div>
</div>
@endsection