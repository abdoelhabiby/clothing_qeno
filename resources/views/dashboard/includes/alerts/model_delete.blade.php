
  <div class="modal fade" id="custom_modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  are you shore to delete <span class="name"></span>
              </div>
              <div class="modal-footer">
                  <form action="" method="post">
                      @csrf()
                      @method("delete")

                      <input type="submit" value="delete" class="btn btn-danger">
                  </form>


              </div>
          </div>
      </div>
  </div>
