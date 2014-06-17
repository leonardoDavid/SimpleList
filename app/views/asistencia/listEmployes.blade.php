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
                    <th></th>
                </tr>
            </thead>
            <tbody>
            	{{ $employes }}
            </tbody>
        </table>
    </div>
</div>