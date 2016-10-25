<div class="modal fade" id="modal-denuncia" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed remove-margin-b">
                <div class="block-header ">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="fa fa-times" aria-hidden="true" style="color: #151515 !important;"></i></button>
                        </li>
                    </ul>
                    <h3 >Denuncia</h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t" >
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="form-material">
                                    <label for="fecha">Fecha de registro</label>
                                </div>
                                <div class='input-group date' >
                                    <input type='text' class="form-control" id='datepicker2' name="fecha" ng-model="denuncia.fecha"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <div class="form-material floating">
                                        <input class="form-control" type="text" id="numero" name="numero" ng-model="denuncia.numero_exp">
                                        <label for="numero">Número de expediente</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material floating">
                                        <textarea class="form-control" id="razon" name="razon" ng-model="denuncia.razon" rows="3"></textarea>
                                        <label for="razon">Razón</label>
                                    </div>
                                </div>
                            </div>
                   </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- data-dismiss="modal" -->
                <button class="btn btn-sm btn-primary" type="button" ng-click="guardarDenuncia()"><i class="fa fa-check"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>