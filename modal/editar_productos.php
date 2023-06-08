	<?php
		if (isset($con))
		{
	?>
		<!-- Modal -->

	
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Editar producto		</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="actualizarDatos" name="actualizarDatos">
		<div id="resultado_ajax_2"></div>
          <div class="mb-2">
            <label for="mod_codigo" class="col-form-label">Código del producto:</label>
            <input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" required>
			<input type="hidden" class="form-control" id="mod_id" name="mod_id">
          </div>
          <div class="mb-2">
           <label for="mod_nombre" class="col-form-label">Nombre del producto:</label>
           <textarea class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required maxlength="255" ></textarea>
          </div>
		  
		  <div class="mb-2">
           <label for="mod_estado" class="col-form-label">Estado:</label>
				<select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
          </div>
		  
		  <div class="mb-2">
           <label for="mod_precio" class="col-form-label">Precio:</label>
			<input type="text" class="form-control" id="mod_precio" name="mod_precio" placeholder="Precio de venta del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8">	
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