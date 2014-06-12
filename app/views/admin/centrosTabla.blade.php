<tr>
    <td>{{ $name }}</td>
    @if($status == 1)
    	<td>Activo</td>
    @else
    	<td>Deshabilitado</td>
    @endif
    <td>{{ $dateAdd }}</td>
    <td>
        <input type="checkbox" class="flat-orange" name="centerIdOperating" value="{{ $value }}">
    </td>
</tr>