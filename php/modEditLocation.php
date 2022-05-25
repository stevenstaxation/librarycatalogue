<!-- Modal -->
<div class="modal" id="modEditLocation" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id='editLocationForm'>
          <div class='row'>
            <div class='col-12'>
              <input type='text' id='editLocation' class='inputTextField'>
            </div>
          </div>
        
          <div id='container-fluid'>
            <div id='editLocationModalMessage' style='margin-top:7px'></div>
            <div id='editableLocationID' style='display: none'></div>
          </div>        
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id='editLocationButton'>Update</button>
        <button type="button" class="btn btn-outline-warning" id='deleteLocationButton'>Delete</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>        
      </div> 
    </div>
  </div>
</div>