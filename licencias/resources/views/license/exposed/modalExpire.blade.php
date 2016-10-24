<div class="modal fade" id="modal-caducidad" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed remove-margin-b">
                <div class="block-header ">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="fa fa-times" aria-hidden="true" style="color: #151515 !important;"></i></button>
                        </li>
                    </ul>
                    <h3 ><strong>Licencia existente</strong></h3>
                </div>
                <div class="block-content">
                    <div class="row">
						<div class="col-md-10 col-md-offset-1 text-justify">
							<p >
								La ubicación que quiere asociar a la nueva licencia ya se encuentra dada de alta en otra licencia.
								<br><strong>La licencia contiene la siguiente información:</strong>
								<ul>
									<li>
										<strong>Número de expediente:</strong> <p id="expedient_number"></p>
									</li>
									<li>
										<strong>Número de registro:</strong> <p id="register_number"></p>
									</li>
									<li>
										<strong>Nombre del negocio:</strong> <p id="commerce_name"></p>
									</li>
									<li>
										<strong>Titular:</strong> <p id="titular"></p>
									</li>
								</ul>
								<br>
								Para poder dar de alta la licencia se tiene que caducar la que ya existe. 
							</p>
						</div>
					</div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- data-dismiss="modal" -->
                <button class="btn btn-sm btn-primary" type="button" ng-click="caducarlicencia()"><i class="fa fa-check"></i> Caducar licencia</button>
            </div>
        </div>
    </div>
</div>