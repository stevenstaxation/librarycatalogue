<!-- Modal -->
<div class="modal" id="modAddBook" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="staticBackdropLabel">Add Book</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     
      <form id='newBookForm'>
     
        <div class='row'>
          <div class='col-6'>
          <img id='bookImage' height='120px'></img>
          </div>
          <div class='col-6'>
          <label for='ISBN' class='inputLabelField'><strong>ISBN</strong></label>
            <p id='ISBN' class='form-control-plaintext inputLabelField'></p>
          </div>
        </div>
        <div class='row' style='margin-top: 10px; margin-bottom:6px;'>
          <label for='bookTitle' class='inputLabelField'><strong>Title</strong></label>
          <input type='text' id='bookTitle' class='form-control inputTextField'>  
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookDescription' class='inputLabelField'><strong>Description/Notes</strong></label>
          <textarea style='font-size:12px;' class='form-control inputTextField z-depth-1' id='bookDescription' rows='8'></textarea>
        </div>
     
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookAuthors' class='inputLabelField'><strong>Author(s)</strong></label>
          <textarea class='form-control inputTextField z-depth-1' id='bookAuthors' rows='1'></textarea>
        </div>
        <div class='row' style='margin-bottom:6px;'>
          <label for='bookPublisher' class='inputLabelField'><strong>Publisher(s)</strong></label>
          <textarea class='form-control inputTextField z-depth-1' id='bookPublisher' rows='1'></textarea> 
        </div>
 
        <div class='row' style='margin-bottom: 6px'>
          <label for='bookLocation' class='inputLabelField'><strong>Location</strong></label>
          <select id='bookLocation' class='form-control inputTextField'>
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
          <label for='bookTags' class='inputLabelField'><strong>Tag(s)</strong></label>
          <textarea class='form-control inputTextField z-depth-1' id='bookTags' rows='2'></textarea>  
        </div>


        <div class='row'>
          <div class='col-3'>
            <label for='bookYear' class='inputLabelField'><strong>Year</strong></label>
            <input type='text' id='bookYear' class='form-control form-control-sm inputTextField text-center' style='width: 85%; margin-left: 0'>  
          </div>
          <div class='col-3'>
            <label for='bookPages' class='inputLabelField'><strong>Pages</strong></label>
            <input type='text' id='bookPages' class='form-control form-control-sm inputTextField text-center' style='width: 85%; margin-left: 0'>  
          </div>
          <div class='col-3'>
            <label for='bookCopies' class='inputLabelField'><strong>Copies</strong></label>
            <input type='number' id='bookCopies' class='form-control form-control-sm inputTextField text-center' value=1 min=0 style='width: 85%; margin-left: 0'>  
          </div>
          <div class='col-3'>
            <label for='bookCost' class='inputLabelField'><strong>Cost</strong></label>
            <input type='text' id='bookCost' class='form-control form-control-sm inputTextField text-end' style='width: 85%; margin-left: 0'>  
          </div>
        </div>

        <div id='container-fluid'>
          <div id='addBookModalMessage' style='margin-top:7px'></div>
        </div>
        
      </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id='addNewBookButton'>Add Book</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>        
      </div> 
    </div>
  </div>
</div>