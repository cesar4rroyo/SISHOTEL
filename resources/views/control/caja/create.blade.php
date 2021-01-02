@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <a href="{{ route('caja') }}" title="Regresar"><button class="btn btn-primary btn-sm mb-2"><i
                                class="fas fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                </div>
                <div class="container mt-2">
                    <form method="POST" action="{{ route('store_caja') }}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('control.caja.form', ['formMode' => 'create'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

{{-- <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        var layout_select_html = $('#concepto').html(); //save original dropdown list
        $("#column_select").change(function () {
            var cur_column_val = $(this).val(); //save the selected value of the first dropdown
            $('#concepto').html(layout_select_html); //set original dropdown list back
            $('#concepto').children('option').each(function(){ //loop through options
                if($(this).val().indexOf(cur_column_val)== -1){ //do your conditional and if it should not be in the dropdown list
                $(this).remove(); //remove option from list
                }
            });
        });
        });
</script> --}}