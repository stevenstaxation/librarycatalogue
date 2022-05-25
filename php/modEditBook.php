<!-- Modal -->
<div class="modal" id="modEditBook" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Book</h5>
        <img id='editBookImage' height='160px'></img>
      </div>
      <div class="modal-body">
      <form id='editBookForm'>
        <div class='row'>
          <div class='col-4'>
            <label for='editISBN' class='inputLabelField'>ISBN</label>
          </div>
          <div class='col-8'>
          <input type='text' id='editISBN' class='inputTextField'> 
          </div>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <div class='col-4'>
            <label for='editBookTitle' class='inputLabelField'>Title</label>
          </div>
          <div class='col-8'>
            <input type='text' id='editBookTitle' class='inputTextField'>  
          </div>
        </div>
        <div class='row'>
          <div class='col-4'>
            <label for='editBookDescription' class='inputLabelField'>Description/Notes</label>
          </div>
          <div class='col-8'>
          <textarea style='font-size:12px; padding: 2px 2px;' class='form-control inputTextField z-depth-1' id='editBookDescription' rows='4'></textarea>
          </div>
        </div>
        <hr>
        <div class='row' style='margin-bottom:6px;'>
          <div class='col-4'>
            <label for='editBookAuthors' class='inputLabelField'>Author(s)</label>
          </div>
          <div class='col-8'>
            <textarea style='font-size:12px; padding: 2px 2px;' class='form-control inputTextField z-depth-1' id='editBookAuthors' rows='1'></textarea>
          </div>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <div class='col-4'>
            <label for='editBookPublisher' class='inputLabelField'>Publisher(s)</label>
          </div>
          <div class='col-8'>
          <textarea style='font-size:12px; padding: 2px 2px;' class='form-control inputTextField z-depth-1' id='editBookPublisher' rows='1'></textarea> 
          </div>
        </div>
        <div class='row'>
          <div class='col-4'>
            <label for='editBookYear' class='inputLabelField'>Year Published</label>
          </div>
          <div class='col-2'>
            <input type='text' id='editBookYear' class='inputTextField text-center'>  
          </div>
          <div class='col-3'></div>
          <div class='col-1'>
            <label for='editBookPages' class='inputLabelField'>Pages</label>
          </div>
          <div class='col-2'>
            <input type='text' id='editBookPages' class='inputTextField text-center'>  
          </div>
        </div>
        <hr>
        <div class='row' style='margin-bottom: 6px'>
          <div class='col-4'>
            <label for='editBookLocation' class='inputLabelField'>Location</label>
          </div>
          <div class='col-8'>
          <select id='editBookLocation' class='inputTextField' style='padding: 2px 0;'>
            <?php
              $sql = 'SELECT * FROM tblLocation';
              $result = mysqli_query($link, $sql);
              while ($row = mysqli_fetch_array($result)) {
                echo "<option value = '" . $row['ID'] . "'>" . $row['Description'] ."</option>";
              }
            ?>
          </select>
          </div>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <div class='col-4'>
            <label for='editBookTags' class='inputLabelField'>Tag(s)</label>
          </div>
          <div class='col-8'>
            <textarea style='font-size:12px; padding: 2px 2px;' class='form-control inputTextField z-depth-1' id='editBookTags' rows='2'></textarea>  
          </div>
        </div>
        <div class='row'>
          <div class='col-4'>
            <label for='editBookCopies' class='inputLabelField'>Copies</label>
          </div>
          <div class='col-2'>
            <input type='number' id='editBookCopies' class='inputTextField text-center' value=1 min=0>  
          </div>
          <div class='col-3'></div>
          <div class='col-1'>
            <label for='editBookCost' class='inputLabelField'>Cost</label>
          </div>
          <div class='col-2'>
            <input type='text' id='editBookCost' class='inputTextField text-end'>  
          </div>
        </div>

        <div id='container-fluid'>
          <div id='editBookModalMessage' style='margin-top:7px'></div>
          <div id='editingHiddenRow' style='display: none'></div>
        </div>
        
      </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id='editBookButton'>Update</button>
        <button type="button" class="btn btn-outline-warning" id='deleteBookButton'>Delete</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>        
      </div> 
    </div>
  </div>
</div>