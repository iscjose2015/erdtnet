//Funcion para leer los datos
function load(page,id=null){
	let id_delete=0;
	var query = document.getElementById("q").value;
	if (id!=null){
		id_delete=id;
	} 
	display_loader();
	fetch("ajax/buscar_facturas.php?action=ajax&page="+page+"&q="+query+'&id='+id_delete, {
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
		cargar_tooltip();
	})
	.catch(function(err) {
	   
	   alert(err);
	});
	
	hidde_loader();
}

	load(1);//Inicializar los datos



	

	
	
	
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
	
	
	function imprimir_factura(id_factura){
			VentanaCentrada('ver-factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}
	
	
	
	
	
	
	function cargar_tooltip(){
		
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		  return new bootstrap.Tooltip(tooltipTriggerEl)
		})
		
	}
	
