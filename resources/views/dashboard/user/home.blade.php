
@extends('layouts.app_new')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                 <h4>Dashboard</h4><hr>
                 <table class="table table-striped table-inverse table-responsive">
                     <thead class="thead-inverse">
                         <tr>
                             <th>Name</th>
                             <th>Email</th>
                             <th>Notifications</th>
                             <th>Action</th>
                         </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>{{ Auth::guard('web')->user()->name }}</td>
                                 <td>{{ Auth::guard('web')->user()->email }}</td>
                                 <td><button type="button" id="notn" class="btn btn-info" >View</button></td>

                                 <!-- <td><button type="button" id="notn" class="btn btn-info" data-toggle="modal" data-target="#myModal">View</button></td> -->
                                 <td>
                                     <a href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                     <form action="{{ route('user.logout') }}" method="post" class="d-none" id="logout-form">@csrf</form>
                                 </td>
                             </tr>
                         </tbody>
                 </table>
            </div>
        </div>
    </div>




<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p id ="text_p"> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




    @endsection
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      var APP_URL = '{{ env('APP_URL') }}'
    $( document ).ready(function() {
        console.log( "document loaded" );
   
    $(".btn-info").click(function () {
      $.ajax({
        url: APP_URL+"user/getNotification",
        type:"GET",
        
        success:function(response){
          $('#myModal').modal();

          if(response ==1) {
            $('#text_p').text("New Mars Rover picture is released, check website");
          }
          else{
            $('#text_p').text("No new Notifications");
          }
        },
        error: function(error) {
         console.log(error);
        }
       });

        });
    });
    </script>

    
  
