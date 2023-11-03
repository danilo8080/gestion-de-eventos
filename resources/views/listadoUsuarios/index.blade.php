@extends('../plantillas/layout')
@section('head_content')
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            padding: 0;
            background: linear-gradient(150deg, #D5F5E3, #229954);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .table-container {
            width: 80%;
            background: white;
            border-radius: 10px;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #adadad;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background: #6C3483;
            color: white;
        }

        .table tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
@endsection
@section('body_content')
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apodo</th>
            </tr>
        </thead>
        <tbody class="tbodyUsers">
        </tbody>
    </table>
</div>
@endsection
