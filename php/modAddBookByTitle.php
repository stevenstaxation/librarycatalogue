<!-- Modal -->
<div class="modal" id="modAddBookByTitle" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="staticBackdropLabel">Add book to library</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id='newBookForm'>
        <div class='row'>
          <label for='ISBNByTitle' class='inputLabelField'><strong>ISBN</strong></label>
          <input type='text' id='ISBNByTitle' class='form-control inputTextField'> 
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookTitleByTitle' class='inputLabelField'><strong>Title</strong></label>
          <input type='text' id='bookTitleByTitle' class='form-control inputTextField'>  
        </div>

        <div class='row'>
          <label for='bookDescriptionByTitle' class='inputLabelField'><strong>Description/Notes</strong></label>
          <textarea style='font-size:12px;' class='form-control inputTextField z-depth-1' id='bookDescriptionByTitle' rows='8'></textarea>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookAuthorsByTitle' class='inputLabelField'><strong>Author(s)</strong></label>
          <textarea class='form-control inputTextField z-depth-1' id='bookAuthorsByTitle' rows='1'></textarea>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookPublisherByTitle' class='inputLabelField'><strong>Publisher(s)</strong></label>
          <textarea class='form-control inputTextField z-depth-1' id='bookPublisherByTitle' rows='1'></textarea> 
        </div>
        <div class='row' style='margin-bottom: 6px'>
          <label for='bookLocationByTitle' class='inputLabelField'><strong>Location</strong></label>
          <select id='bookLocationByTitle' class='form-control inputTextField'>
            <?php
              $sql = 'SELECT * FROM tblLocation';
              $result = mysqli_query($link, $sql);
              while ($row = mysqli_fetch_array($result)) {
                echo "<option value = '" . $row['ID'] . "'>" . $row['Description'] ."</option>";
              }
            ?>
          </select>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookTagsByTitle' class='inputLabelField'><strong>Tag(s)</strong></label>
          <textarea class='form-control inputTextField z-depth-1' id='bookTagsByTitle' rows='2'></textarea>  
        </div>
      
        <div class='row'>
          <div class='col-3'>
            <label for='bookYearByTitle' class='inputLabelField justify-content-center'><strong>Year</strong></label>
            <input type='text' id='bookYearByTitle' class='form-control form-control-sm inputTextField text-center' style='width: 85%; margin-left: 0'>  
          </div>
          <div class='col-3'>
            <label for='bookPagesByTitle' class='inputLabelField'><strong>Pages</strong></label>
            <input type='text' id='bookPagesByTitle' class='form-control form-control-sm inputTextField text-center' style='width: 85%; margin-left: 0'>  
          </div>
          <div class='col-3'>
            <label for='bookCopiesByTitle' class='inputLabelField'><strong>Copies</strong></label>
            <input type='number' id='bookCopiesByTitle' class='form-control form-control-sm inputTextField text-center' value=1 min=0 style='width: 85%; margin-left: 0'>  
          </div>
          <div class='col-3'>
            <label for='bookCostByTitle' class='inputLabelField'><strong>Cost</strong></label>
            <input type='text' id='bookCostByTitle' class='form-control form-control-sm inputTextField text-end' style='width: 85%; margin-left: 0'>  
          </div>
        </div>

        <div id='container-fluid'>
          <div id='addBookModalMessageByTitle' style='margin-top:7px'></div>
        </div>
        
      </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id='addNewBookButtonByTitle'>Add Book</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>        
      </div> 
    </div>
  </div>
</div>