<div class="col-md-4">
        <!-- Info Boxes Style 2 -->
    <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fab fa-cc-visa"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Tarjetas Visa</span>
        <span class="info-box-number">{{$info['visa']}}</span>
        <div class="progress">
            <div class="progress-bar" style="width: {{ ($info['total']!=0) ? ($info['visa']/$info['total']*100) : 0}}%"></div>
        </div>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="fab fa-cc-mastercard"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Tarjetas MasterCard</span>
        <span class="info-box-number">{{$info['master']}}</span>
        <div class="progress">
            <div class="progress-bar" style="width: {{($info['total']!=0) ? ($info['master']/$info['total']*100) : 0}}%"></div>
        </div>     
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    <div class="info-box bg-red">
        <span class="info-box-icon"><i class="fab fa-cc-amazon-pay"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Otras Tarjetas</span>
        <span class="info-box-number">{{$info['otrasTarjetas']}}</span>

        <div class="progress">
            <div class="progress-bar" style="width: {{($info['total']!=0) ?  ($info['otrasTarjetas']/$info['total']*100) : 0}}%"></div>
        </div>
        </div>
        <!-- /.info-box-content -->
    </div>    
</div>
<div class="col-sm-4">
    <!-- /.info-box -->
    <div class="info-box bg-navy">
        <span class="info-box-icon"><i class="fas fa-money-bill-alt"></i></span>
        <div class="info-box-content">
        <span class="info-box-text"> Efectivo</span>
        <span class="info-box-number">{{$info['efectivo']}}</span>

        <div class="progress">
            <div class="progress-bar" style="width: {{($info['total']!=0) ? ($info['efectivo']/$info['total']*100) : 0}}%"></div>
        </div>     
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    <div class="info-box bg-secondary">
        <span class="info-box-icon"><i class="fas fa-money-bill-wave-alt"></i></span>
        <div class="info-box-content">
        <span class="info-box-text"> Depósitos</span>
        <span class="info-box-number">{{$info['depositos']}}</span>
        <div class="progress">
            <div class="progress-bar" style="width: {{($info['total']!=0) ?  ($info['depositos']/$info['total']*100) : 0}}%"></div>
        </div>     
        </div>
        <!-- /.info-box-content -->
    </div>
    <div class="info-box bg-orange">
        <span class="info-box-icon"><i class="fas fa-money-check"></i></span>
        <div class="info-box-content">
        <span class="info-box-text"> Apertura Caja</span>
        <span class="info-box-number">{{$info['apertura']}}</span>
        <div class="progress">
            <div class="progress-bar" style="width: {{($info['total']!=0) ? ($info['apertura']/$info['total']*100) : 0}}%"></div>
        </div>     
        </div>
        <!-- /.info-box-content -->
    </div>
</div>
