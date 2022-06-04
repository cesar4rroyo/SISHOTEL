<div class="container">
    <hr>
    <div class="row">
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'success', 'title' => 'Ingresos', 'value' => $totales['ingresos'], 'icon' => 'fas fa-arrow-up'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'danger', 'title' => 'Egresos', 'value'=>$totales['egresos'], 'icon' => 'fas fa-arrow-down'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'info', 'title' => 'Balance', 'value' => $totales['saldo'], 'icon' => 'fas fa-balance-scale'])
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'warning', 'title' => 'Efectivo', 'value' => $totales['montoefectivo'], 'icon' => 'fas fa-money-bill-wave'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'primary', 'title' => 'T. Visa', 'value' => $totales['montovisa'], 'icon' => 'fab fa-cc-visa'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'black', 'title' => 'T. MasterCard', 'value' => $totales['montomastercard'], 'icon' => 'fab fa-cc-mastercard'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'gray', 'title' => 'T. Amex', 'value' => $totales['montoamex'], 'icon' => 'fab fa-cc-amex'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'lightblue', 'title' => 'Total Tarjetas', 'value' => $totales['totaltarjetas'], 'icon' => 'fab fa-cc-amex'])
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'success', 'title' => 'Plin', 'value' => $totales['montoplin'], 'icon' => 'fas fa-comments-dollar'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'indigo', 'title' => 'Yape', 'value' => $totales['montoyape'], 'icon' => 'fas fa-comments-dollar'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'lime', 'title' => 'Total Transferencias', 'value' => $totales['totaltransferencias'], 'icon' => 'fas fa-exchange-alt'])
        </div>
        <div class="col-sm">
            @include('control.caja2.infoBox', ['class' => 'orange', 'title' => 'Depósitos', 'value' => $totales['montodeposito'], 'icon' => 'fas fa-money-check-alt'])
        </div>
    </div>
</div>