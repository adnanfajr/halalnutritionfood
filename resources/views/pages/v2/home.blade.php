{{--
 Created by Adnan Mauludin Fajriyadi
 "Peningkatan Relevansi Pencarian Produk Halal Dalam Aplikasi Halal Nutrition Food Menggunakan Algoritma OKAPI BM25F"

 April 2017
--}}

@extends('layouts.v2.master') 

@section('title', 'Welcome To Halal Nutrition Food') 

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
            {!! Form::text('q', Input::get('q'), array('class' => 'form-control input', 'placeholder' => 'Enter your search term')) !!}
            <span class="input-group-btn">
                {!! Form::submit('Search', array('class' => 'btn btn-primary')) !!}            
            </span>
        </div>
        {!! Form::close() !!}
        
        @if (isset($resultset) && isset($debugResult) && isset($s)) 
        <br>
        <p>Your search took <strong>{{ $s }} seconds</strong> and yielded <strong>{{ $resultset->getNumFound() }}</strong> result(s) <span class="pull-right"><a href="{{ url('/') }}/json/?q={{ $debugResult->getQueryString() }}" target="_blank">raw output</a> - <a href="{{ url('/') }}:8983/solr/halal/{{ $handler }}/?q={{ $debugResult->getQueryString() }}" target="_blank">solr json</a></span></p>
        <hr />
            @foreach ($resultset as $doc)
            <a href="{{ url('foodproduct',['id' => $doc->id]) }}"><h3>{{ implode(', ', $doc->food_name) }}</h3></a>
            <small>{{ implode(', ', $doc->food_man) }}</small><small class="pull-right">relevance score : <strong>{{ $doc->score }}</strong></small>
            <p style="margin-top:5px;font-style:italic">{{ implode(', ', $doc->food_ing) }}</p>
            <hr/>
            @endforeach
        @endif
        <br>
        </div>
    </div>
</div>
@endsection 