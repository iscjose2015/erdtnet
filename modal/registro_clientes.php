
	
		<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->

	
	<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"> Agregar nuevo cliente		</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form method="post" id="guardarDatos" name="guardarDatos">
			
			<div id="resultado_ajax_cl"></div>
			  <div class="mb-2">
				<label for="nombre_cl" class="col-form-label">Nombre:</label>
				<input type="text" class="form-control" id="nombre_cl" name="nombre_cl" required>
			  </div>
			  <div class="mb-2">
			   <label for="telefono_cl" class="col-form-label">Teléfono:</label>
			   <input type="text" class="form-control" id="telefono_cl" name="telefono_cl" >
			  </div>
			  
			  <div class="mb-2">
			   <label for="email_cl" class="col-form-label">E-mail:</label>
			   <input type="email" class="form-control" id="email_cl" name="email_cl" >
			  </div>
			  
			  <div class="mb-2">
			   <label for="direccion_cl" class="col-form-label">Dirección:</label>
				<textarea class="form-control" id="direccion_cl" name="direccion_cl"   maxlength="255" ></textarea>	
			  </div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" >Guardar datos</button>
			</form>
		  </div>
		</div>
	  </div>
	</div>


	<?php
		}
	?>
	