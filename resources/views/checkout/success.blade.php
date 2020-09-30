@extends('layouts.app')

@section('content')


<div class="row justify-content-center">
    @foreach($order as $item)
        <div class="card w-25 mx-5">
            <img src="/storage/courses/{{$item->model->user->id}}/{{$item->model->image}}">
            <div class="card-body">
                <div class="action d-flex justify-content-between">
                    <p>
                        <i class="fas fa-clock"></i>
                        {{$item->model->created_at}}
                    </p>
                    <p>Par {{$item->model->user->name}}</p>
                </div>
                <p class="card-text">{{$item->model->subtitle}}</p>
            </div>
            <div class="action d-flex justify-content-around my-3">
                <a href="#" class="primary-btn w-75">
                    <i class="fas fa-graduation-cap"></i>
                    Commencer
                </a>
            </div>
        </div>
    @endforeach
</div>


@stop
