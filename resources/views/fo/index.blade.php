@extends('fo.common.layout') 

@section('content')

<div class="wrapper_our_service"> 
    <div class="col-sm-12 text-center padding-bottom-sm padding-top-sm  wow fadeInUp animated delay">
      <h1 class="title_our_service">OUR SERVICES</h1>
    </div>
    <div class="container">
      <div class=" our_service col-sm-12 padding-bottom-lg">

        <div class="col-sm-4 text-center wow fadeInUp animated delay">
          <div class="col-sm-12">
            <center>
              <a href="#">
                <img class="img-responsive" style="width:200px;" src="{{url('images/c1.png')}}"
                alt="service">
              </a>
            </center>
          </div>
          <div class="col-sm-12">
            <a href="#">
              <h4 class="font-size padding">CIVIL & STRUCTURAL</h4>
            </a>`
          </div>
        </div>

        <div class="col-sm-4 text-center wow fadeInUp animated delay">
            <div class="col-sm-12">
              <center>
                <a href="#">
                <img class="img-responsive" style="width:200px;" src="{{url('images/c2.png')}}"
                  alt="service">
                </a>
              </center>
            </div>
            <div class="col-sm-12 padding">
              <a href="">
                <h4 class="font-size">SPECIALIZED LABOR</h4>
              </a>
            </div> 
        </div>

        <div class="col-sm-4 text-center wow fadeInUp animated delay">
            <div class="col-sm-12">
              <center>
                 <a href="#">
                <img class="img-responsive" style="width:200px;" src="{{url('images/c3.png')}}"
                  alt="service">
                  </a>
              </center>
            </div>
            <div class="col-sm-12 padding">
              <a href="#">
                <h4 class="font-size">ELECTRICAL & COMMUNICATION</h4>
              </a>
            </div>
          </a>
        </div>
      </div>
    </div>
</div>
@endsection
<style type="text/css">
  
  .our_service a img:hover{
    background-color: #e41c47;
    border-radius: 100%;
  }
  .our_service a .font-size:hover{
    color: #e41c47;
  }
</style>