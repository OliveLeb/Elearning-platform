@extends('layouts.app')

@section('content')

 <section class="about-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Cours pour commencer</h2>
                    <p class="f-para">There are several ways people can make money online. From selling products to advertising. In this article I am going to explain the concept of contextual advertising.</p>
                </div>
            </div>
        </div>
        @include('incs.courses.category-banner')
        <div class="row">
            <div class="courses">
                @foreach($courses as $course)
                    <div class="course my-5 row">
                        <div class="col-lg-4">
                            <div class="about-pic">
                                <a href="{{route('courses.show',$course->slug)}}">
                                    <img src="/storage/courses/{{$course->user_id}}/{{$course->image}}" alt="{{$course->title}}">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-text pt-0">
                                <h3>{{$course->title}}</h3>
                                <p>{{$course->subtitle}}</p>
                                <p>Par <b>{{$course->user->name}}</b></p>
                                <span class="tag">{{$course->category->name}}</span>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <p><b>{{$course->price}} €</b></p>
                            <a href="{{route('wishlist.store',$course->id)}}" title="Ajouter à la liste de souhait">
                                <i class="fas fa-heart fa-3x"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
