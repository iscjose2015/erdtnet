<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-info " aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href=""><?php echo "Usuario: ".$_SESSION['user_name']; ?></a>
    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
      </ul>
      <ul class="navbar-nav ml-auto ">

		<li class="nav-item">
		  <a class="nav-link" href="login.php?logout"> <i class="bi bi-power"></i> Salir</a>
		</li>
    
	</ul>
  
    </div>
  </div>
</nav>