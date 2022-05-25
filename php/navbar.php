<nav class="navbar navbar-expand navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavBar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavBar">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a id='showBooks' class="nav-link" href="#"><span class='full-text'>BOOKS</span><span class='icon-only'><i class='bi-book'></i></span></a>
                </li>
                <li class="nav-item">
                    <a id='showSettings' class="nav-link" href="#"><span class='full-text'>SETTINGS</span><span class='icon-only'><i class='bi-gear'></i></span></a>
                </li>
                <li class="nav-item">
                    <a id='bulkImport' class="nav-link" href="#">
                        <span class='full-text'>BULK IMPORT</span>
                        <span class='icon-only'><i class="bi bi-inboxes-fill"></i></span>
                        <input style='display: none' type="file" id="file">
                    </a>     
                </li>
            </ul>
            <form>
                <ul class="navbar-nav mr-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a id='myAccountButton' class="nav-link" href="#"><span class='full-text'>MY ACCOUNT</span><span class='icon-only'><i class='bi-person-circle'></i></span></a>
                    </li>
                    <li class="nav-item">
                        <a id='logOut' class="nav-link" href="#"><span class='full-text'>LOG OUT</span><span class='icon-only'><i class='bi-box-arrow-left'></i></span></a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
  </nav>
