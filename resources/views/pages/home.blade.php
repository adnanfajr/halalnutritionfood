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
        <br>
        <p>Your search yielded <strong>{{ $resultset->getNumFound() }}</strong> results:</p>
        <hr />
            @foreach ($resultset as $doc)
            <a href="{{ url('foodproduct',['id' => $doc->id]) }}"><h3>{{ implode(', ', $doc->food_name) }}<small class="pull-right">{{ implode(', ', $doc->food_man) }}</small></h3></a>
            @endforeach
        @endif
        <br>
        </div>
    </div>
</div>
@endsection 

@section('js') 
@parent 

@endsection