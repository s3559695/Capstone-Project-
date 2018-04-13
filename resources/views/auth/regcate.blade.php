@extends('layouts.app')

@section('content')
	<div class="jumbotron welcome_header text-center">
			<h1>Get Few Interest</h1>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">

		<form role="form" method="POST" action="{{ route('poststep2') }}">
			 {{ csrf_field() }}
			
			@foreach($categories->chunk(3) as $cate)
						<div class="row">
							@foreach($cate as $c)
							<div class="col-md-4 margin-t-b">
							<select class="selectpicker form-control" name="pref[]" multiple="" title="{{$c['original']['cat_name']}}" data-selected-text-format="count" data-size="5" data-actions-box="true">
							
							@foreach($subs as $sub)
								@if($sub->cate_id==$c['original']['id'])
								<option value="{{ $sub->id }}">{{ $sub->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
							@endforeach
						
						</div>
					
			
        		@endforeach
			
			 <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
            </div>		
        
		</form>

		</div>
	</div>
	</div>
	<!-- @if (session('name'))
		<p>{{ session('name')}}</p>
	
	@else
		<p>not session</p>
	
	@endif -->

@endsection