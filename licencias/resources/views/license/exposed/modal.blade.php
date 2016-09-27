<div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed remove-margin-b">
                <div class="block-header ">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="fa fa-times" aria-hidden="true" style="color: #151515 !important;"></i></button>
                        </li>
                    </ul>
                    <h3 >Avisos/Alertas</h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t" >
                        
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <div class="form-material floating">
                                        <input class="form-control" type="text" id="title" name="title" ng-model="alert.title">
                                        <label for="title">Titulo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="form-material">
                                        <input class="js-datepicker form-control" type="date" id="date" name="date" ng-model="alert.date" data-date-format="dd-mm-yyyy">
                                        <label for="date">Fecha de publicación</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="type_alert_id">Tipo de alerta</label><br>
                                    <select id="type_alert_id" ng-model="alert.type_alert_id">
                                        <option ng-repeat="type in typeAlert" value="@{{type.id}}">@{{type.type}}</option>
                                    </select>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material floating">
                                        <textarea class="form-control" id="description" name="description" ng-model="alert.description" rows="3"></textarea>
                                        <label for="description">Descripción</label>
                                    </div>
                                </div>
                            </div>
                        
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- data-dismiss="modal" -->
                <button class="btn btn-sm btn-primary" type="button" ng-click="guardarAlerta()"><i class="fa fa-check"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>