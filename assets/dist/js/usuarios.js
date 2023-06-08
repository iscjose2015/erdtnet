//Funcion para leer los datos
function load(page,id=null){
	let id_delete=0;
	var query = document.getElementById("q").value;
	if (id!=null){
		id_delete=id;
	} 
	display_loader();
	fetch("ajax/buscar_usuarios.php?action=ajax&page="+page+"&q="+query+'&id='+id_delete, {
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
		const data = new FormData(document.getElementById('guardarDatos'));
		fetch('ajax/nuevo_usuario.php', {
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
		   document.getElementById("resultado_ajax").innerHTML = texto;
		   document.getElementById("guardarDatos").reset();
		   load(1);
		})
		.catch(function(err) {
		   alert(err);
		});


	   event.preventDefault();
	}

	const formAdd = document.getElementById('guardarDatos');
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
	  var nombres = button.getAttribute('data-bs-nombres')
	  var apellidos = button.getAttribute('data-bs-apellidos')
	  var email = button.getAttribute('data-bs-email')
	var usuario = button.getAttribute('data-bs-usuario')

	  
	  
	  document.getElementById('mod_id').value=id;
	  document.getElementById('firstname2').value=nombres;
	  document.getElementById('lastname2').value=apellidos;
	  document.getElementById('user_email2').value=email;
	  document.getElementById('user_name2').value=usuario;
	  
	  
	  
	  document.getElementById("resultado_ajax_2").innerHTML = '';
	  
	})
	
	var editModal2 = document.getElementById('editModalPass')
	editModal2.addEventListener('show.bs.modal', function (event) {
	  // Button that triggered the modal
	  var button = event.relatedTarget
	  // Extract info from data-bs-* attributes
	  var id = button.getAttribute('data-bs-id')
 
	  document.getElementById('user_id_mod').value=id;
	  document.getElementById("resultados_ajax3").innerHTML = '';
	  
	})
	
	function actualizar_datos(event) {
		const data = new FormData(document.getElementById('actualizarDatos'));
		fetch('ajax/editar_usuario.php', {
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
	
	//Para actualizar la contraseña
	function actualizar_datos_pass(event) {
		const data = new FormData(document.getElementById('editar_password'));
		fetch('ajax/editar_password.php', {
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
		   document.getElementById("resultados_ajax3").innerHTML = texto;
		   
		   load(1);
		})
		.catch(function(err) {
		   alert(err);
		});


	   event.preventDefault();
	}

	const formEdit2 = document.getElementById('editar_password');
	formEdit2.addEventListener('submit', actualizar_datos_pass);