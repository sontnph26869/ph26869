@extends('layouts.client')

@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background=" {{asset('client/assets/images/banner/banner01.jpg')}}"></div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title  cd-headline clip"><span class="d-block">book your</span> tickets for 
                    <span class="color-theme cd-words-wrapper p-0 m-0">
                        <b class="is-visible">Movie</b>
                        <b>Event</b>
                        <b>Sport</b>
                    </span>
                </h1>
                <p>Safe, secure, reliable ticketing.Your ticket to live entertainment!</p>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

 <!-- ==========Ticket-Search========== -->
 @include('client.ticket')
    
    <!-- ==========Ticket-Search========== -->

    <!-- ==========Movie-Section========== -->
    @include('client.books.book')
  
    <!-- ==========Movie-Section========== -->

    <!-- ==========Event-Section========== -->
    @include('client.event')
  
    <!-- ==========Event-Section========== -->

    <!-- ==========Sports-Section========== -->
    @include('client.sports')

    <!-- ==========Sports-Section========== -->
 @endsection
