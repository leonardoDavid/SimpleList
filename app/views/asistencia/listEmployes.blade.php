<div class="box box-solid">
    <div class="box-header">
        <i class="fa fa-group"></i>
        <h3 class="box-title">Empleados de {{ $centerName }}</h3>
    </div>
    <div class="box-body">
    	<table id="employes" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>RUT</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            	{{ $employes }}
            </tbody>
        </table>
    </div>
    <div class="box-footer clearfix text-right">
        <a href="/asistencia/tomar" class="btn btn-danger" id="cancel"><span>Cancelar</span> <i class="fa fa-times-circle"></i></a>
        <button class="btn btn-primary" id="save"><span>Guardar</span> <i class="fa fa-save"></i></button>
    </div>
</div>