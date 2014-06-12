<tr>
    <td>{{ $rut }}</td>
    <td>{{ $firstname }}</td>
    <td>{{ $lastname }}</td>
    @if($status == 1)
    	<td>Activo</td>
    @else
    	<td>Deshabilitado</td>
    @endif
    <td>
        <input type="checkbox" class="flat-orange" name="employedIdOperating" value="{{ $value }}">
    </td>
</tr>