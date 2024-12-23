<div class="table-responsive">
    <table class="table table-stripped table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Cód de Operación</th>
                <th>N° de Transacción</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Comisión</th>
                <th>Monto Neto</th>
                <th>Forma de pago</th>
                <th>Banco</th>
                <th>Condicion de Pago</th>
                <th>Fecha de pago</th>
            </tr>
        </thead>
        <tbody>
            @php
                $c = 0;
            @endphp
            @foreach ($pagos as $pago)
                @php $c++; @endphp
                <tr>
                    <td>{{ $c }}</td>
                    <td>{{ $pago->cod_operacion }}</td>
                    <td>{{ $pago->n_transaccion }}</td>
                    <td>{{ $pago->descripcion_pago }}</td>
                    <td>{{ $pago->monto }}</td>
                    <td>{{ $pago->comision }}</td>
                    <td>{{ $pago->monto_neto }}</td>
                    <td>{{ $pago->forma_de_pago->descripcion }}</td>
                    <td>{{ $pago->banco->descripcion }}</td>
                    <td>{{ $pago->condicion_pago ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y h:i:s A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
