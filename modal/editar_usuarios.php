	<?php
		if (isset($con))
		{
	?>
	<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Editar usuario		</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="actualizarDatos" name="actualizarDatos">
		<div id="resultado_ajax_2"></div>
		
		<div class="mb-2">
				<label for="firstname2" class="col-form-label">Nombres:</label>
				<input type="text" class="form-control" id="firstname2" name="firstname2" placeholder="Nombres" required>
				<input type="hidden" class="form-control" id="mod_id" name="mod_id">
			  </div>
			  <div class="mb-2">
			   <label for="lastname2" class="col-form-label">Apellidos:</label>
			   <input type="text" class="form-control" id="lastname2" name="lastname2" placeholder="Apellidos" required>
			  </div>
			  
			  <div class="mb-2">
			   <label for="user_name2" class="col-form-label">Usuario:</label>
					<input type="text" class="form-control" id="user_name2" name="user_name2" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
			  </div>
			  
			  <div class="mb-2">
			   <label for="user_email2" class="col-form-label">E-mail:</label>
				<input type="email" class="form-control" id="user_email2" name="user_email2" placeholder="Correo electrónico" required>
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