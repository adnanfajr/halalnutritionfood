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
            <form class="">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <input name="q" class="form-control"></input>
                        </div>
                    </div>
                </div>
                <center>
                    <button type="submit" class="btn btn-primary">Search</button>
                </center>
            </form>
        </div>
    </div>
</div>
@endsection 

@section('js') 
@parent 

@endsection