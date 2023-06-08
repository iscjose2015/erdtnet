	<?php
		if (isset($con))
		{
	?>	
	
	<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buscar productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
			<form class="form-horizontal">
			  <div class="row">
				<div class="col-lg-6">
				  <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
				</div>
				
				<div class="col-lg-6">
					<button type="button" class="btn btn-secondary" onclick="load(1)"><span class='bi bi-search'></span> Buscar</button>
				</div>
			</div>
			</form>
			<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
			<div id="outer_div" ></div><!-- Datos ajax Final -->
					
					
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


			
	<?php
		}
	?>