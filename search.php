<form action="" method="get">
    <div class="row">
        <div class="col-md-10">
            <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher un login, une salle, ou un pc." value="<?php if(isset($_GET['search'])) echo $_GET['search'] ?>" autofocus>
        </div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary btn-block" value="Rechercher">
        </div>
    </div>
</form>