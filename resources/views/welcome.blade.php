@extends('layouts.app')

@section('content')

    <!-- <div class="jumbotron text-center welcome_header">
            <h1>Encounter</h1>
    </div>  -->
<<<<<<< HEAD
<!--    
=======

>>>>>>> 438a00eb021c50b203b2af5dfd820b23e2ddfa6c
    <div class="container-fluid welcome_header" >
        <div class="row">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          </ol>


          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="images/2.jpg" alt="">
              <div class="carousel-caption">
              </div>
            </div>

            <div class="item">
              <img src="images/1.jpg" alt="">
              <div class="carousel-caption">
              </div>
            </div>

            <div class="item">
              <img src="images/3.jpg" alt="">
              <div class="carousel-caption">
              </div>
            </div>
          </div>


          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a >
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a >
        </div>

        </div>
    </div>
  -->

    <!-- include search page -->
    @include('homepage_search')

    @if (count($event)>0)
    <div class="container">
            <h3>Recommended Events</h3>

        @foreach (array_chunk($event,3) as $e)
        <div class="row">

            @foreach($e as $add)
            <div class="col-md-4 marginbottom">
                <a href="{{ url('event/'.$add['id']) }}">
                  <div class="panel panel-primary text-center">
                      <div class="panel-heading">
                          <h3>{{ $add["title"] }}</h3>
                          <h4>Matching Percentage: {{ Session::get($add['id'])}}%</h4>
                      </div>
                      <div class="panel-body">
                          <p>{{  $add["description"] }}</p>
                          <div>{{ $add["start_date"] }}</div>
                          <div>{{ $add["start_time"] }}</div>
                      </div>
                  </div>
                </a>
            </div>
            @endforeach


        </div>
        @endforeach

    </div>
    @endif
    <!--Explore by category-->
    <div class="container">
        <h3>Explore By Category</h3>

            @foreach($categories->chunk(3) as $category)
                <div class="row">
                    @foreach($category as $c)
                    <div class="col-md-4 col-sm-12 marginbottom">
                            <a href="{{ url('/'.$c['cat_name']) }}">
                            <div class="panel panel-success text-center" >
                                <div class="panel-heading" style="height: 100px; font-size: 40px" >{{ $c['cat_name'] }}</div>

                                  
                            </div>
                           </a>
                    </div>
                    @endforeach

            </div>
            @endforeach


    </div>

    <!--Content-->
<!--    <div class="container-fluid minfooter">
        <div class="row ">
            <div class="col-md-8 col-md-offset-2">
              <div class="col-md-6 text-center"><h2>HELP</h2></div>
              <div class="col-md-6 text-center"><h2>DISCOVER</h2></div>
            </div>
    </div>
</div>
-->

<script type="text/javascript">
    $(function(){
        $('.panel').matchHeight();
    });
</script>

    <script>

        $(document).ready(function() {
            $('#main-menu .subcatmenu').hide();
            $('#main-menu >li a').click(function(){

                $('#main-menu >li .subcatmenu').show();

            });

        });

    </script>
@endsection
<script type="text/javascript">
<<<<<<< HEAD
    
=======


>>>>>>> 438a00eb021c50b203b2af5dfd820b23e2ddfa6c
        var options = [];
$( '.dropdown-menu a' ).on( 'click', function( event ) {
   var $target = $( event.currentTarget ),
       val = $target.attr( 'data-value' ),
       $inp = $target.find( 'input' ),
       idx;
   if ( ( idx = options.indexOf( val ) ) > -1 ) {
      options.splice( idx, 1 );
      setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
   } else {
      options.push( val );
      setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
   }
   $( event.target ).blur();

   return false;
});
    </script>
<<<<<<< HEAD


=======
>>>>>>> 438a00eb021c50b203b2af5dfd820b23e2ddfa6c
