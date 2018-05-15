<!DOCTYPE html>
<html lang="UTF-8">
<head>
	<title>Kết Quả</title>
</head>
<body>
	<h3>Tìm thấy {{$found}} kết quả</h3><br><br>
	@foreach($resultset as $document)
		<hr><table class="table">
			@foreach($document as $field => $value)
			@if(is_array($value))
				<?php $value = implode(', ', $value) ?>
			@endif
			<tr>
				<th>
					{{$field}}
				</th>
				<td>
					{{$value}}
				</td>
			</tr>
			@endforeach
		</table>
	@endforeach
</body>
</html>