@extends('layouts.v2.master')

@section('title', 'Halal Nutrition Food | Food Product')

@section('css')
    @parent
@endsection

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Food: {{ $foodProduct->fName }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-5">
                <div id="nutrition"></div>
            </div>
            <div class="col-md-8 col-sm-7">
                <div class="form-group">
                    {!! Form::label('foodId','Food ID') !!}
                    <p>{{ $foodProduct->fCode }}</p>
                </div>
                <div class="form-group">
                    {!! Form::label('foodName','Food Name') !!}
                    <p>{{ $foodProduct->fName }}</p>
                </div>
                <div class="form-group">
                    {!! Form::label('foodManufacture','Food Manufacture') !!}
                    <p>{{ $foodProduct->fManufacture }}</p>
                </div>
                <div class="form-group">
                    {!! Form::label('foodIng','Food Ingredient') !!}
                    <p>
                        {{ implode(", ",$inglist).'.' }}
                    </p>
                </div>
                @if(!empty($addlist))
                <div class="form-group">
                    {!! Form::label('foodAdditive','Food Additive') !!}
                    <ul>
                        @foreach($addlist as $add)
                        <li><a href="{{ route('additive.show', $add['addId']) }}">{{ $add['addName'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <div class="form-group">
                    {!! Form::label('foodWarning','Food Info') !!}
                    <ul>
                        @if($foodProduct['weight'] > 0)
                            @if($fullness < 1)
                                <li>This food is not filling</li>
                            @elseif($fullness >= 1 && $fullness < 2)
                                <li>This food is less filling</li>
                            @elseif($fullness >= 2 && $fullness < 3)
                                <li>This food is enough filling</li>
                            @elseif($fullness >= 3 && $fullness < 4)
                                <li>This food is more filling</li>
                            @elseif($fullness > 4)
                                <li>This food is very filling</li>
                            @endif
                        @endif
                        @if(!empty($foodWarning))
                            <?php 
                                $first=true;
                                $category = ['','infants','less than 4 Years','pregnant and lactating women'];
                            ?>
                            @for($i=0; $i < 4 ; $i++)
                                @foreach($foodWarning[$i] as $key => $warn)
                                    @if($first)
                                        @if(empty($foodWarning[$i][$key]))
                                        @else
                                            <li>{{ $foodWarning[$i][$key].$category[$i] }}</li>
                                        @endif
                                    @else
                                        @if(empty($foodWarning[$i][$key]))
                                        @elseif($foodWarning[$i][$key] == $foodWarning[0][$key])
                                        @else
                                            <li>{{ $foodWarning[$i][$key].' for '.$category[$i] }}</li>
                                        @endif
                                    @endif
                                @endforeach
                                <?php $first=false ?>
                            @endfor
                        @endif
                    </ul>
                </div>
                
                
                @if(!empty($certificate))
                <div class="form-group">
                    {!! Form::label('certificate','Food Certificate') !!}
                    <table class="table table-bordered">
                        <thead>
                            <th>No Certificate</th>
                            <th>Expire Date</th>
                            <th>Certificate Status</th>
                        </thead>
                        @foreach($certificate as $cert)
                        <tbody>
                            <td>{{ $cert['cCode'] }}</td>
                            <td>{{ date('d-m-Y',strtotime($cert['cExpire'])) }}</td>
                            @if($cert['cStatus'] == 0)
                                <td>Development</td>
                            @elseif($cert['cStatus'] == 1)
                                <td>New</td>
                            @elseif($cert['cStatus'] == 2)
                                <td>Renew</td>
                            @endif
                        </tbody>
                        @endforeach
                    </table>
                </div>
                @endif
                <a href="{{ route('foodproduct.edit',$foodProduct->id) }}" class="btn btn-primary pull-right" role="button">Edit Food</a>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        $('#nutrition').nutritionLabel({
            'showServingUnitQuantity' : false,
            'itemName' : '{{ $foodProduct->fName }}',
            'ingredientList' : '{{ implode(", ",$inglist).'.' }}',

            'showPolyFat' : false,
            'showFatCalories' : false,
            'showMonoFat' : false,

            'valueCalories' : '{{ $foodProduct->calories }}',
            'valueTotalFat' : '{{ $foodProduct->totalFat }}',
            'valueSatFat' : '{{ $foodProduct->saturatedFat }}',
            'valueTransFat' : '{{ $foodProduct->transFat }}',
            'valueCholesterol' : '{{ $foodProduct->cholesterol }}',
            'valueSodium' : '{{ $foodProduct->sodium }}',
            'valueTotalCarb' : '{{ $foodProduct->totalCarbohydrates }}',
            'valueFibers' : '{{ $foodProduct->dietaryFiber }}',
            'valueSugars' : '{{ $foodProduct->sugar }}',
            'valueProteins' : '{{ $foodProduct->protein }}',
            'valueVitaminA' : '{{ $foodProduct->vitaminA }}',
            'valueVitaminC' : '{{ $foodProduct->vitaminC }}',
            'valueCalcium' : '{{ $foodProduct->calcium }}',
            'valueIron' : '{{ $foodProduct->iron }}'
        });
    </script>
@endsection
