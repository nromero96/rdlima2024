<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #C40000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #C40000;
            color: #fff;
        }

        td {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .signature {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>INSCRIPPCIÓN #{{ $datainscription->id }}: En Proceso</h1>
        <p>Estimado(a) <b>{{ $userinfo->name }} {{ $userinfo->lastname }}</b>,</p>
        <p>Le informamos que su preinscripción para la <b>XLI Reunión Anual de Dermatólogos Latinoamericanos</b> ha sido recibida. El evento se llevará a cabo del 8 al 11 de mayo de 2024 en el Swissôtel Lima.</p>

        <!-- Título "Detalle de tu Inscripción" -->
        <h2>Detalle de tu Inscripción</h2>

        <!-- Tabla de resumen de inscripción con bordes -->
        <table>
            <tr>
                <th>Descripción</th>
                <th>Información</th>
            </tr>
            <tr>
                <td>Nombre Completo</td>
                <td>{{ $userinfo->name }} {{ $userinfo->lastname }} {{ $userinfo->second_lastname }}</td>
            </tr>
            <tr>
                <td>Categoría</td>
                <td>{{ $datainscription->category_inscription_name }}</td>
            </tr>
            <tr>
                <td>Precio</td>
                <td>{{ $datainscription->price_category }}</td>
            </tr>
            <tr>
                <td>Acompañante</td>
                <td>{{ $datainscription->price_accompanist }}</td>
            </tr>
            <tr>
                <td><b>Monto Total</b></td>
                <td>{{ $datainscription->total }}</td>
            </tr>
            <tr>
                <td>Método de Pago</td>
                <td>{{ $datainscription->payment_method }}</td>
            </tr>
        </table>
        <!-- Fin de la tabla -->

        <!-- Recordatorio para ver el proceso de inscripción -->
        <p>Recuerda que puedes ver el proceso de tu inscripción en el siguiente enlace:</p>
        <p><a href="https://my.radla2024.org/">Ver Proceso de Inscripción</a></p>

        <!-- Mensaje de validación de pago e información -->
        <p>Antes de aprobar su inscripción, validaremos el pago y la información proporcionada. Estamos aquí para ayudarte en caso de cualquier consulta o aclaración adicional.</p>

        <!-- Contacto de soporte -->
        <p>Si necesita más información o asistencia adicional, no dude en ponerse en contacto con nosotros a través de la dirección de correo electrónico: <b>inscripciones@radla2024.org</b></p><br>

        <!-- Firma y contacto del Comité Organizador -->
        <p class="signature">Atentamente,<br>Comité Organizador<br><b>RADLA LIMA 2024</b><br>+51 983 481 269<br>inscripciones@radla2024.org</p>
    </div>
</body>
</html>