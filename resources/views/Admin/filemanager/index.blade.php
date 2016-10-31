@extends('Admin.common.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('Admin.common.message') 
    <section class="content-header">
      <h1>
        File Manager
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="iframe-responsive-wrapper">
            <img class="iframe-ratio" src="data:image/gif;base64,R0lGODlhEAAJAIAAAP///wAAACH5BAEAAAAALAAAAAAQAAkAAAIKhI+py+0Po5yUFQA7"/>
            <iframe scrolling="no" src="http://tbcccambodia.localhost:81/assets/backend/fileman/index.html?type=image" width="100%" height="650" frameborder="2" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        </div>

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

@endsection

@section('toppagescripts')
<style type="text/css">

        .iframe-responsive-wrapper {
            position: relative;
        }

        .iframe-responsive-wrapper .iframe-ratio {
            display: block;
            width: 100%;
            height: auto;
        }

        .iframe-responsive-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

    </style>
@endsection


@section('scriptsbottom')

@endsection