
	function cargar_datos(id=0){
		fetch("ajax/editar_facturacion.php?id="+id, {
			method: 'GET',
		})
		.then(function(response) {
		   if(response.ok) {
			   return response.text()
		   } else {
			   throw "Error en la llamada Ajax";
		   }
		})
		.then(function(texto) {
			document.getElementById("resultados").innerHTML = texto;
		})
		.catch(function(err) {
		    alert(err);
		});
	}
	cargar_datos();
	
		function eliminar (id){
			cargar_datos(id);
		}
	

	//Funcion para leer los datos
	function load(page){
		
		var query = document.getElementById("q").value;
		fetch("ajax/productos_factura.php?action=ajax&page="+page+"&q="+query, {
		   method: 'GET',
		   
		})
		.then(function(response) {
		   if(response.ok) {
			   return response.text()
		   } else {
			   throw "Error en la llamada Ajax";
		   }

		})
		.then(function(texto) {
			//console.log(texto);
			document.getElementById("outer_div").innerHTML = texto;
		})
		.catch(function(err) {
		   
		   alert(err);
		});
		
		
	}

	load(1);//Inicializar los datos
	
	
	//Para agregar productos a la tabla detalle de ventas
	function agregar (id){
			var precio_venta=document.getElementById('precio_venta_'+id).value;
			var cantidad=document.getElementById('cantidad_'+id).value;
			//Inicia validacion
			if (isNaN(cantidad))
			{
			alert('Esto no es un numero');
			document.getElementById('cantidad_'+id).focus();
			return false;
			}
			if (isNaN(precio_venta))
			{
			alert('Esto no es un numero');
			document.getElementById('precio_venta_'+id).focus();
			return false;
			}
			//Fin validacion
			
			
			
			const formData = new FormData();
			formData.append('id', id);
			formData.append('precio_venta', precio_venta);
			formData.append('cantidad', cantidad);
			
			fetch('ajax/editar_facturacion.php', {
			   method: 'POST',
			   body: formData
			})
			.then(function(response) {
			   if(response.ok) {
				   return response.text()
			   } else {
				   throw "Error en la llamada Ajax";
			   }

			})
			.then(function(texto) {
			   document.getElementById("resultados").innerHTML = texto;
			    
			})
			.catch(function(err) {
			   alert(err);
			});
		
		
			
		}
		
		
		
		
		//Actualizar datos de la factura
		
		function actualizar_datos(event) {
			
		var id_cliente=document.getElementById('id_cliente').value;
	  
		if (id_cliente==""){
			  alert("Debes seleccionar un cliente");
			  $("#nombre_cliente").focus();
			  return false;
		  }
		  
		const data = new FormData(document.getElementById('datos_factura'));
		fetch('ajax/editar_factura.php', {
		   method: 'POST',
		   body: data
		})
		.then(function(response) {
		   if(response.ok) {
			   return response.text()
		   } else {
			   throw "Error en la llamada Ajax";
		   }

		})
		.then(function(texto) {
		   document.getElementById("editar_factura").innerHTML = texto;
		   
		   load(1);
		})
		.catch(function(err) {
		   alert(err);
		});


	   event.preventDefault();
	}

	const formEdit = document.getElementById('datos_factura');
	formEdit.addEventListener('submit', actualizar_datos);
	
		
	
		//Para guardar los datos
	function guardar_datos_cl(event) {
		const data = new FormData(document.getElementById('guardarDatos'));
		fetch('ajax/nuevo_cliente.php', {
		   method: 'POST',
		   body: data
		})
		.then(function(response) {
		   if(response.ok) {
			   return response.text()
		   } else {
			   throw "Error en la llamada Ajax";
		   }

		})
		.then(function(texto) {
		   document.getElementById("resultado_ajax_cl").innerHTML = texto;
		   document.getElementById("guardarDatos").reset();
		   load(1);
		   autocomplete();
		})
		.catch(function(err) {
		   alert(err);
		});


	   event.preventDefault();
	}

	const formAdd = document.getElementById('guardarDatos');
	formAdd.addEventListener('submit', guardar_datos_cl);
	//Finaliza seccion para guardar datos

	//Para guardar los datos de productos
	function guardar_datos(event) {
		const data = new FormData(document.getElementById('guardarDatosProducto'));
		fetch('ajax/nuevo_producto.php', {
		   method: 'POST',
		   body: data
		})
		.then(function(response) {
		   if(response.ok) {
			   return response.text()
		   } else {
			   throw "Error en la llamada Ajax";
		   }

		})
		.then(function(texto) {
		   document.getElementById("resultado_ajax_x").innerHTML = texto;
		   document.getElementById("guardarDatosProducto").reset();
		   load(1);
		})
		.catch(function(err) {
		   alert(err);
		});


	   event.preventDefault();
	}

	const formAdd2 = document.getElementById('guardarDatosProducto');
	formAdd2.addEventListener('submit', guardar_datos);
	
	
	function imprimir_factura(id_factura){
			VentanaCentrada('ver-factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
	}
	
	
	
		
	
		
	
	
	function autocomplete(){
		//Buscar clientes con Autocomplete
	
		const field = document.getElementById('nombre_cliente');
		const ac = new Autocomplete(field, {
			data: [{label: "Selecciona un valor", value: 0}],
			maximumItems: 5,
			treshold: 1,
			onSelectItem: ({label, value, email, telefono}) => {
				 document.getElementById("id_cliente").value = value;
				  document.getElementById("mail").value = email;
				 document.getElementById("tel1").value = telefono;
			}
		});
		
			
			var term = "";
			fetch("ajax/autocomplete/clientes.php?term="+term, {
			   method: 'GET',
			   
			})
			.then(function(response) {
			   if(response.ok) {
				   return response.text()
			   } else {
				   throw "Error en la llamada Ajax";
			   }

			})
			.then(function(texto) {
				var obj = JSON.parse(texto);
				ac.setData (obj);
			})
			.catch(function(err) {
			   
			   alert(err);
			});
			
		
	}
	autocomplete();