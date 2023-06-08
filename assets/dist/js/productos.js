//Funcion para leer los datos
function load(page,id=null){
	let id_delete=0;
	var query = document.getElementById("q").value;
	if (id!=null){
		id_delete=id;
	} 
	display_loader();
	fetch("ajax/buscar_productos.php?action=ajax&page="+page+"&q="+query+'&id='+id_delete, {
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
	    document.getElementById("resultados").innerHTML = texto;
	})
	.catch(function(err) {
	   
	   alert(err);
	});
	
	hidde_loader();
}

	load(1);//Inicializar los datos



	
	
	
	
	

	//Para guardar los datos
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

	const formAdd = document.getElementById('guardarDatosProducto');
	formAdd.addEventListener('submit', guardar_datos);
	//Finaliza seccion para guardar datos
	
	
	
	//Funciones para mostrar y ocultar la imagen del loader
	
	function display_loader(){
		var img = document.getElementById('cargador');
		img.style.visibility = 'display';
		
	}
	
	function hidde_loader(){
		var img = document.getElementById('cargador');
		img.style.visibility = 'hidden'
	}


	//Eliminar datos
	
	function eliminar(id){
		Swal.fire({
		  title: 'Estas seguro?',
		  text: "No podrás revertir esto!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Si, eliminarlo!',
		  cancelButtonText: 'Cancelar'
		}).then((result) => {
		  if (result.isConfirmed) {
			load(1,id);
			
		
		  }
		})


	}
	
	
	//Editar datos
	
	var editModal = document.getElementById('editModal')
	editModal.addEventListener('show.bs.modal', function (event) {
	  // Button that triggered the modal
	  var button = event.relatedTarget
	  // Extract info from data-bs-* attributes
	  var id = button.getAttribute('data-bs-id')
	  var codigo = button.getAttribute('data-bs-codigo')
	  var nombre = button.getAttribute('data-bs-nombre')
	  var estado = button.getAttribute('data-bs-estado')
	  var precio = button.getAttribute('data-bs-precio')
	  
	  document.getElementById('mod_id').value=id;
	  document.getElementById('mod_codigo').value=codigo;
	  document.getElementById('mod_nombre').value=nombre;
	  document.getElementById('mod_estado').value=estado;
	  document.getElementById('mod_precio').value=precio;
	  
	  document.getElementById("resultado_ajax_2").innerHTML = '';
	  
	})
	
	function actualizar_datos(event) {
		const data = new FormData(document.getElementById('actualizarDatos'));
		fetch('ajax/editar_producto.php', {
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
		   document.getElementById("resultado_ajax_2").innerHTML = texto;
		   
		   load(1);
		})
		.catch(function(err) {
		   alert(err);
		});


	   event.preventDefault();
	}

	const formEdit = document.getElementById('actualizarDatos');
	formEdit.addEventListener('submit', actualizar_datos);