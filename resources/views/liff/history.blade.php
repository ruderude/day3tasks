@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">タスクの履歴</div>

                <div class="card-body">
                    <History></History>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
