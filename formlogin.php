<link href="css/login.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class='alert-info form-signin text-center'>
            Veuillez vous connecter avec vos
            <b>identifiants internes</b>.
        </div>
        <?php
        if (isset($_GET['msg']) && $_GET['msg'] === "logerror") {
        ?>
            <div class='alert-danger form-signin text-center'>
                Erreur de conenxion, veuillez rééssayer.
            </div>
        <?php
        }
        else if (isset($_GET['msg']) && $_GET['msg'] === "deloged") {
        ?>
            <div class='alert-success form-signin text-center'>
                Vous êtes déconnecté.
            </div>
        <?php
        }
        ?>
        <form class="form-signin" role="form" method='post' action="login.php">
        <h2 class="form-signin-heading">Identifiez-vous</h2>
        <input name='login' id='login' type="login" class="form-control" placeholder="Identifiant" required autofocus
               <?php if (isset($_GET['user'])) {
                   echo 'value='.$_GET['user'];
               } ?>
        >
        <input name='password' id='password' type="password" class="form-control" placeholder="Mot de passe" required>
        <?php /*
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
         */ ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
      </form>
    </div> <!-- /container -->

  </body>
