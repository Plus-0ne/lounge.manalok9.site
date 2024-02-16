<form action="{{ route('user.profile-update') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="modal fade" id="user_profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Profile Settings</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row p-2">
              <div class="my-2 col-12 col-sm-12">
                <div class="profile-container">
                  @if (!empty(Auth::user()->image))
                    <img src="{{ asset(Auth::user()->image) }}">
                  @else
                    <img src="{{ asset('my_custom_symlink_1/user.png') }}">
                  @endif
                  
                </div>
                <br>
                <input class="form-control" type="file" name="image" value="{{ Auth::user()->first_name }}" autocomplete="off">
                 <hr>
              </div>
              <div class="my-2 col-12 col-sm-12 col-md-6">
                <label>
                  First Name
                </label>
                <input class="form-control" type="text" name="first_name" value="{{ Auth::user()->first_name }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12 col-md-6">
                <label>
                  Last Name
                </label>
                <input class="form-control" type="text" name="last_name" value="{{ Auth::user()->last_name }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12">
                <label>
                  Address
                </label>
                <input class="form-control" type="text" name="Address" value="{{ Auth::user()->Address }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12">
                <label>
                  Contact #
                </label>
                <input class="form-control" type="text" name="Contact" value="{{ Auth::user()->Contact }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12">
                <label>
                  Kennel
                </label>
                <input class="form-control" type="text" name="kennel" value="{{ Auth::user()->kennel }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12">
                <label>
                  Cattery
                </label>
                <input class="form-control" type="text" name="cattery" value="{{ Auth::user()->cattery }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12">
                <label>
                  Rabittry
                </label>
                <input class="form-control" type="text" name="rabbitry" value="{{ Auth::user()->rabbitry }}" autocomplete="off">
              </div>
              <div class="my-2 col-12 col-sm-12">
                <label>
                  Chicken Coop
                </label>
                <input class="form-control" type="text" name="chicken_coop" value="{{ Auth::user()->chicken_coop }}" autocomplete="off">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Save</button>
        </div>
      </div>
    </div>
  </div>
</form>