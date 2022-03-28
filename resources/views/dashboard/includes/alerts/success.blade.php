 @if(Session::has('success_message'))

<div class="alert alert-success alert-dismissible fade show mb-2 " role="alert">
  <strong class=""> {{Session::get('success_message')}} </strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>




@endif
