
<!DOCTYPE html>
<html>
<head>
    <title>Reporte seminarios</title>
</head>
<body>
    <h2>DATOS DE SEMINARIOS</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>ID Forms</th>
                <th>Estado Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos_limpios as $data)
                <tr>
                    <td>{{ $data['Nombre'] ?? '' }}</td>
                    <td>{{ $data['Teléfono'] ?? '' }}</td>
                    <td>{{ $data['estado'] ?? '' }}</td>
                    <td>{{ $data['Comentario'] ?? '' }}</td>
                    <td>{{ $data['fecha'] ?? '' }}</td>
                    <td>{{ $data['total'] ?? 0 }}</td>
                    <td>{{ $data['id_forms'] ?? '' }}</td>
                    <td>{{ $data['estado_reg'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
