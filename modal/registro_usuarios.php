	<?php
		if (isset($con))
		{
	?>
	
	<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"> Agregar nuevo usuario		</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			<form method="post" id="guardarDatos" name="guardarDatos">
			<div id="resultado_ajax"></div>
			  <div class="mb-2">
				<label for="firstname" class="col-form-label">Nombres:</label>
				<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required>
			  </div>
			  <div class="mb-2">
			   <label for="lastname" class="col-form-label">Apellidos:</label>
			   <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellidos" required>
			  </div>
			  
			  <div class="mb-2">
			   <label for="user_name" class="col-form-label">Usuario:</label>
					<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
			  </div>
			  
			  <div class="mb-2">
			   <label for="user_email" class="col-form-label">E-mail:</label>
				<input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo electrónico" required>
			  </div>

			  <div class="mb-2">
			   <label for="user_password_new" class="col-form-label">Contraseña:</label>
				 <input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>	
			  </div>
			  
			  <div class="mb-2">
			   <label for="user_password_repeat" class="col-form-label">Repite contraseña:</label>
				<input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite contraseña" pattern=".{6,}" required>
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