<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-info " aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href="principal.php">Aduana</a>
    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">


      <li class="nav-item">
          <a class="nav-link <?php if(isset($active_clientes)){echo $active_clientes;}?>" href="clientes.php"><i ></i> Clientes</a>
        </li>

      <li class="nav-item">
          <a class="nav-link <?php if(isset($active_perfil)){echo $active_perfil;}?>" href="empresas.php"><i ></i>Empresas</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="facturacion.php"><i ></i> Facturas</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="ordenes.php"><i ></i> Ordenes</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="registra_factura.php"><i></i>Registrar Factura</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_productos)){echo $active_productos;}?>" href="productos.php"><i class="bi bi-upc"></i> Productos</a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="proveedores.php"><i class="bi bi-file-earmark"></i> Proveedores</a>
        </li>


        
        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="facturacion.php"><i class="bi bi-file-earmark"></i> Facturar</a>
          <ul>
            <li>Uno</li>
            <li>Dos</li>
          </ul>
        </li>


        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="complementos.php"><i class="bi bi-file-earmark"></i>Complemplementos</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="cuentas.php"><i class="bi bi-file-earmark"></i>
        
        
        
        </a>
        </li>


 
        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_usuarios)){echo $active_usuarios;}?>" href="usuarios.php"><i class="bi bi-person-fill"></i> Usuarios</a>
        </li>

    

     
        
      </ul>
      <ul class="navbar-nav ml-auto ">

		<li class="nav-item">
		  <a class="nav-link" href="login.php?logout"> <i class="bi bi-power"></i> Salir</a>
		</li>
    
	</ul>
  
    </div>
  </div>
</nav>