	<?php
		if (isset($con))
		{
	?>
		<div class="modal fade" id="editModalPass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Cambiar contraseña		</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="editar_password" name="editar_password">
		<div id="resultados_ajax3"></div>
		
		<div class="mb-2">
				<label for="firstname2" class="col-form-label">Nueva contraseña:</label>
				<input type="password" class="form-control" id="user_password_new3" name="user_password_new3" placeholder="Nueva contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
					<input type="hidden" id="user_id_mod" name="user_id_mod">
			  </div>
			  <div class="mb-2">
			   <label for="lastname2" class="col-form-label">Repite contraseña:</label>
			   <input type="password" class="form-control" id="user_password_repeat3" name="user_password_repeat3" placeholder="Repite contraseña" pattern=".{6,}" required>
			  </div>
			  
			 

			  
			  
          
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" >Cambiar contraseña</button>
		</form>
      </div>
    </div>
  </div>
</div>


	
	<?php
		}
	?>	