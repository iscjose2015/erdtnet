	<?php
		if (isset($con))
		{
	?>
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Editar cliente		</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="actualizarDatos" name="actualizarDatos">
		<div id="resultado_ajax_2"></div>
          <div class="mb-2">
            <label for="mod_codigo" class="col-form-label">Nombre:</label>
			 <input type="text" class="form-control" id="mod_nombre" name="mod_nombre"  required>
			<input type="hidden" name="mod_id" id="mod_id">
          </div>
          <div class="mb-2">
           <label for="mod_nombre" class="col-form-label">Teléfono:</label>
			<input type="text" class="form-control" id="mod_telefono" name="mod_telefono">
          </div>
		  
		  <div class="mb-2">
           <label for="mod_email" class="col-form-label">E-mail:</label>
				<input type="email" class="form-control" id="mod_email" name="mod_email">
          </div>
		  
		  <div class="mb-2">
           <label for="mod_direccion" class="col-form-label">Dirección:</label>
			<textarea class="form-control" id="mod_direccion" name="mod_direccion" ></textarea>
          </div>
		  
		  <div class="mb-2">
           <label for="mod_estado" class="col-form-label">Estado:</label>
				<select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				</select>
				  
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" >Actualizar datos</button>
		</form>
      </div>
    </div>
  </div>
</div>


	
	<?php
		}
	?>