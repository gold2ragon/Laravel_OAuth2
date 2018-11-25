@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-right" style="margin-bottom: 10px;">
                <a href="{{url('lists')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Load data from database and local images">Load data from Local</a>
                <a href="{{url('checkAPI')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Load all data from API">Check new data</a>
                <button class="btn btn-primary" onclick="submit(this, 'updateDB')" data-toggle="tooltip" data-placement="right" title="Save data to database and download images">Download feed</button>
            </div>
            @foreach($items as $item)
            <div class="card">
                <div class="card-header"><a href="{{$item->link}}">{{$item->name}}</a></div>
                <div class="card-body">
                    
                    <div class="row">
                        
                        <div class="col-md-8">
                            @if($item->address != null && $item->address != 'null')
                            <div><strong>Address:</strong> {{$item->address}}</div><br>
                            @endif
                            @if(isset($item->latitude) && $item->latitude != null && $item->latitude != 'null')
                            <strong>Latitude: </strong>{{$item->latitude}}<br>
                            <strong>Longitude: </strong>{{$item->longitude}}<br>
                            @endif

                            @if(isset($item->duration) && $item->duration != null && $item->duration != 'null')
                            <strong>Duration: </strong>{{$item->duration}}<br>
                            @endif

                            @if(isset($item->category) && $item->category != null && $item->category != 'null')
                            <strong>Category: </strong>{{$item->category}}<br>
                            @endif

                            @if(isset($item->rating) && $item->rating != null && $item->rating != 'null')
                            <strong>Rating: </strong>{{$item->rating}}<br>
                            @endif


                            @if(isset($item->rating_count) && $item->rating_count != null && $item->rating_count != 'null')
                            <strong>Rating Count: </strong>{{$item->rating_count}}<br>
                            @endif

                            @if(isset($item->price) && $item->price != null && $item->price != 'null')
                            <strong>Price: </strong>{{$item->price}}<br>
                            @endif
                            @if(isset($item->description) && $item->description != null && $item->description != 'null')
                            <strong>Discription: </strong><div class="description">{{strip_tags($item->description)}}</div>
                            @endif

                        </div>
                        <div class="col-md-4">
                            @if(isset($item->image))
                            <img src="{{$item->image}}">
                            @elseif(isset($item->image_thumb))
                            <img src="{{$item->image_thumb}}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
        
    </div>
</div>
@endsection

@section('script')
<script>
function submit(button, url){
    btnstring = button.innerHTML;
    button.innerHTML = btnstring + ' <i class="fas fa-spinner fa-spin"></i>';
    $.ajax({
        type:'POST',
        url: url,
        data: {
            _token : '<?php echo csrf_token() ?>'
        },
        success:function(data){
            button.innerHTML = btnstring;
            alert(data);
        },
        error(xhr,status,error)
        {
            button.innerHTML = btnstring;
            alert(error);            
        }
    });
}
</script>
@endsection
