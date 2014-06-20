<div class="box box-solid">
	<div class="overlay" data-autohide="1" id="over-list"></div>
	<div class="afterAdd">
		<h4>Asistencia tomada <i class="fa fa-check"></i></h4>
		<a class="btn btn-primary" href="/asistencia/tomar"> Tomar otro día <i class="fa fa-calendar"></i></a>
	</div>
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

@section('scriptsInLine')
	var commentId = "";
	(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('*[data-autohide="1"]').hide();
    })();

    $('.minibtn-comment').click(function(event) {
    	$('#commet-text').val("");
    	var comment = $(this).data('comment');
    	commentId = $(this).attr('id');
    	$('#commet-text').val(comment);
    	$('#comment-box').modal();
    });

    $('#saveComment').click(function(event) {
    	$('#'+commentId).data('comment', $('#commet-text').val());
    	$('#comment-box').modal('hide');
    });

	$('#save').click(function(event){
		$.ajax({
			url: '/asistencia/tomar/{{ $action }}',
			type: 'post',
			data: { 
                'values' : getValues()
                @if($action == "update")
                    ,'fecha' : '{{ $fecha }}'
                @endif
            },
			beforeSend : function(){
				$('#over-list').fadeIn();
			},
			success : function(response){
				var obj = JSON.parse(response);
				if(obj['status']){
					$(".afterAdd").fadeIn();
				}
				else{
					$('#msj-error').text(obj['motivo']);
	                $('#over-list').fadeOut();
	                $('#error-server').modal();
				}
			},
			error : function(xhr){
				$('#msj-error').text('Error de conexión al momento de recuperar los datos, intentelo más tarde.');
                $('#over-list').fadeOut();
                $('#error-server').modal();
			}
		});
		
	});

	function getValues(){
		var finalData = new Array();
		$('.minibtn-comment').each(function(index, val){
			var tmp = $(this).attr('id');
			if( (values.indexOf(tmp+"ST0") != -1) || (values.indexOf(tmp+"ST1") != -1) ){

				var index = values.indexOf(tmp+"ST0");
				if(index == -1){
					index = values.indexOf(tmp+"ST1");
				}

				if(index != -1)
					rut = values[index];
				else
					rut = "NotFound";

				finalData.push({
					'rut' : rut,
					'comment' : $(this).data('comment')
				});
			}
		});
		return JSON.stringify(finalData);
	}

    values = {{ $values }};
    $('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
        checkboxClass: 'icheckbox_flat-orange',
        radioClass: 'iradio_flat-orange'
    });
    $('input[type="checkbox"]').on('ifChecked', function(event){
    	var index = values.indexOf($(this).val()+"ST0");
    	if(index != -1)
    		values.splice(index,1);
        values.push($(this).val()+"ST1");
    });
    $('input[type="checkbox"]').on('ifUnchecked', function(event){
    	var index = values.indexOf($(this).val()+"ST1");
    	if(index != -1)
    		values.splice(index,1);
        values.push($(this).val()+"ST0");
    });
@stop