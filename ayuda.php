<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ayuda CONI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Ayuda y Esquema del Sistema de Control de Inventarios</h2>
  <br>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Catalogos</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu3">Ordenes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu4">Compras</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu5">Facturacion</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu6">Reportes</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu7">Esquema</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu8">Vinculo Especial</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
      <h3>Catalogos</h3>
      <p><b><i>Clientes</i></b></p>
      <p>Son los datos de a quienes vamos a facturar.</p>


      <p><b><i>Empresas</i></b></p>
      <p>Las empresas son las entidades que va a facturar, se deberá generar los certificados correspondientes.</p>
      
      <p><b><i>Proveedores</i></b></p>
      <p>Son los datos de los proveedores chinos, aquien se le compra. En este catalogo lo importante es el correo electronico.</p>

      <p><b><i>Cuentas Bancarias</i></b></p>
      <p>Son las cuentas que se utilizar en complementos, para el concepto de cuenta bancaria</p>

      <p><b><i>Cuentas Ordenantes</i></b></p>
      <p>Son las cuentas que se utilizan en complementos, para el concepto de cuenta ordenante</p>

    </div>
    <div id="menu3" class="container tab-pane fade"><br>
      <p>Este modulo Carga un excel, con datos de una de un orden de compra</p>
      <p><a href="https://www.elreydeltornillo.com/sit/facturacion/ejemplos_excel.php/ejemplo_subir_oc.xlsx">Bajar Formato de OC</a></p>
    </div>
    <div id="menu4" class="container tab-pane fade"><br>
      <h3></h3>
      <p>El modulo Almacen - Ingreso Almacen</p>
      <p><a href= "https://elreydeltornillo.com/sit/facturacion/ejemplos_excel/ejemplo_factura_ingreso_almacen.xlsx">Descargar Formato de Excel para ingreso a Almacen</a></p>
    </div>
    <div id="menu5" class="container tab-pane fade"><br>
      <h3></h3>
      <p>El sistema es capaz de: </p>
      <p>Timbrar factura de Ingreso</p>
      <p>Timbrar factura de Egreso</p>
      <p>Timbrar factura de Cancelar</p>
      <p>Timbrar factura de Anticipo</p>
      <p>Timbrar factura de Complementos de Pago</p>
    </div>
    <div id="menu6" class="container tab-pane fade"><br>
      <h3></h3>


    </div>
    <div id="menu7" class="container tab-pane fade"><br>
      <h3></h3>
      <p><img src="esquema.jpg" alt="CONI"> </p>
      <p></p>

    </div>

    <div id="menu8" class="container tab-pane fade"><br>
      <h3></h3>
      <p><img src="kepler.png" alt="Kepler"> </p>
      <p></p>

    </div>
  </div>
</div>

</body>
</html>