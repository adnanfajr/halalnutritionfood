{{--
 Created by Adnan Mauludin Fajriyadi
 "Peningkatan Relevansi Pencarian Produk Halal Dalam Aplikasi Halal Nutrition Food Menggunakan Algoritma OKAPI BM25F"

 April 2017
--}}

@extends('layouts.master') 

@section('title', 'Welcome To Halal Nutrition Food') 

@section('css') 
@parent 

@endsection 

@section('body')
<div class="jumbotron">
    <div class="container">
        <center>
            <h1>Halal Nutrition Food</h1>
        </center>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        {!! Form::open(array('method' => 'GET')) !!}
        <div class="input-group">
            {!! Form::text('q', Input::get('q'), array('class' => 'form-control input-lg', 'placeholder' => 'Enter your search term')) !!}
            <span class="input-group-btn">
                {!! Form::submit('Search', array('class' => 'btn btn-primary btn-lg')) !!}            
            </span>
        </div>
        {!! Form::close() !!}
        
        @if (isset($resultset)) 
        <p>Your search yielded <strong>{{ $resultset->getNumFound() }}</strong> results:</p>
        <hr />

        @foreach ($resultset as $document)

            <h3>{{ $document->title }}</h3>

            <dl>
                <dt>Year</dt>
                <dd>{{ $document->id }}</dd>

                @if (is_array($document->food_name))
                <dt>food_name</dt>
                <dd>{{ implode(', ', $document->food_name) }}</dd>              
                @endif

                </dl>

                {{ $document->food_man }}

        @endforeach
        @endif

        </div>
    </div>
</div>
@endsection 

@section('js') 
@parent 

@endsection