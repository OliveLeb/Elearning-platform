@extends('layouts.app')

@section('content')

<section class="related-post-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Cours</h2>
                    <p class="mt-3">Dès maintenant, créez votre prochain cours en quelques clics !</p>
                    <a href="#" class="primary-btn mt-3">
                        <i class="fas fa-plus"></i>
                        Nouveau cours
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            @if(count(Auth::user()->courses) > 0)
            @foreach(Auth::user()->courses as $course)
            <div class="col-md-4">
                <div class="card-body">
                    <div class="bi-text">
                        <h5><a class="btn font-weight-bold" href="#"> {{$course->title}} </a></h5>
                        <span><i class="fa fa-clock-o"></i> {{$course->created_at}} </span>
                    </div>
                </div>
                <div class="blog-item set-bg" data-setbg="https://blog.hyperiondev.com/wp-content/uploads/2019/02/Blog-Types-of-Web-Dev.jpg">
                </div>
                <div class="btn-actions d-flex justify-content-center">
                    <a href="#" class="primary-btn">
                        <i class="fas fa-edit"></i>
                        Modifier
                    </a>
                </div>
            </div>
            @endforeach
            @else
            <p>Pas de cours</p>
            @endif
        </div>
    </div>
</section>

@endsection
