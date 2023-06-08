
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-info " aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href="principal.php"><?php echo "Usuario: ".$_SESSION['user_name']; ?></a>
    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">


      <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Catalogos</a>
          <ul>
            <li><a href="empresas.php">Empresas</a></li>
            <li><a href="clientes.php">Clientes</a></li>
           <!-- <li><a href="productos.php">Productos</a></li> -->
            <li><a href="proveedores.php">Proveedores</a></li>
         <!--   <li><a href="cuentas_bancarias.php">Cuentas Bancarias</a></li>
            <li><a href="cuentas_ordenantes.php">Cuentas Ordenantes</a></li> -->
            <li><a href="catalogo_correos.php">Correos</a></li>
        
           <!--li><a href="correos.php">Correos</a></li>
            <li><a href="pedimentos_facturacion.php">Pedimentos</a></li> -->
          </ul>
        </li>


        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Ordenes</a>
          <ul>
            <li><a href="ordenes.php">Orden de Compra</a></li>
          </ul>
        </li>


        
        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Compras </a>
          <ul>
            <li><a href="registra_factura.php">Ingresar / Ver Compras</a></li>
        
            <li><a href="contenedores.php">Ver / Contenedores</a></li>
          </ul>
        </li>
        
      <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Facturar</a>
          <ul>
            <li><a href="facturacion.php?f=n">Nueva factura</a></li>
            
            <li><a href="facturacion.php?f=n">Facturas Pendientes</a></li>
            <li><a href="complementos.php">Complementos Pendientes</a></li>
            <li><a href="facturacion.php?f=ant">Anticipos Pendientes</a></li>
          </ul>
        </li>


        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Historico</a>
          <ul>
            <li><a href="timbradas.php?f=n">Facturas Timbradas</a></li>
            <li><a href="canceladas.php">Facturas Canceladas</a></li>
            <li><a href="comple_timbrados.php">Complementos Timbrados</a></li>
            <li><a href="comple_canceladas.php">Complementos Cancelados</a></li>

          </ul>
        </li>


        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Reportes</a>
          <ul>
            <li><a href="reporte_facturas.php?f=n">Reporte de Facturas</a></li>
            <li><a href="reporte_saldo_facturas.php?f=n">Reporte Saldo Facturas</a></li>

          </ul>
        </li>






        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href=""><i class="bi bi-file-earmark"></i> Kardex</a>
          <ul>
          <li><a href="productos_completo.php">Ver Productos</a></li>

          </ul>
        </li>



        
        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_usuarios)){echo $active_usuarios;}?>" href="usuarios.php"><i class="bi bi-person-fill"></i> Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if(isset($active_usuarios)){echo $active_usuarios;}?>" href="backup/crea_respaldo.php"><i class="bi bi-person-fill"></i> Respaldo </a>
        </li>


              
        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="ayuda.php" target="_blank"><i class="bi bi-file-earmark"></i> Ayuda</a>
          
        </li>

                      
        <li class="nav-item ">
          <a class="nav-link <?php if(isset($active_facturas)){echo $active_facturas;}?>" aria-current="page" href="http://172.18.10.77:8080/ws/ws_kepler/todos_update.php" target="_blank"><i class="bi bi-file-earmark"></i> Upd. </a>
          
        </li>




              <ul class="navbar-nav ml-auto ">

      <li class="nav-item">
        <a class="nav-link" href="login.php?logout"> <i class="bi bi-power"></i> Salir</a>
      </li>
     
    
	</ul>
  
    </div>
  </div>
</nav>