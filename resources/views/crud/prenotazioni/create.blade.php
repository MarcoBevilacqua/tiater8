@extends('admin.inner-admin-layout')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="page-header text-center">
                <h1>Prenota</h1>
            </div>
        </div>

        <div class="row">
            <!-- apertura form -->
            {{Form::open(array('url' => 'book', 'class' => 'form form-horizontal')) }}
            <div class="form-group">
                {{Form::label('show', 'Spettacolo', array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-5">
                    {{Form::select('show', $shows, null,  array(
                    'class'     => 'form-control tiater-select',
                    'data-ref'  => URL::to('/') . '/api/event/for/book/',
                    'placeholder' => 'Nessuno spettacolo'
                    ))}}
                </div>
            </div>
            <!-- /PANEL SPETTACOLO -->

            <!-- DATE -->
            <div class="form-group">
                {{Form::label('date', 'Data', array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-5">
                    <select autocomplete="off" name="date" id="date"
                            class="form-control">
                        <option value="" selected>Nessuna data</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <h5 id="posti"><em>Posti disponibili:</em> <b class="price"></b></h5>
                </div>
            </div>
            <!-- /DATE -->

            <!-- SPETTATORI -->
            <div class="form-group">
                {{Form::hidden('viewer', '', array('id' => 'viewer'))}}

                {{Form::label('spettatori', 'Spettatori', array('class' => 'col-sm-2 control-label'))}}
                <div class="col-sm-5">
                    {{Form::text('spettatore', '',
                    array(
                        'id' => 'spettatori-autocomplete',
                        'class' => 'form-control',
                        'data-ref' => URL::to('/') .'/api/users/search',
                        'autocomplete' => 'off'))
                    }}
                </div>
                <div class="col-sm-2">
                    <!-- trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus-circle"></i> aggiungi</button>
                </div>
            </div>
            <!-- /SPETTATORI -->

            <!-- Biglietti interi/ridotti -->
            <div class="form-group">
                <label for="interi" class="col-sm-2 control-label">Interi</label>
                <div class="col-sm-1">
                    {{Form::select('full_price_qnt', array(
                    "0" => 0,
                    "1" => 1,
                    "2", 2,
                    "3" => 3,
                    "4" => 4), "0",
                    array('class' => 'form-control'))}}
                </div>
                <label for="ridotti" class="col-sm-1 control-label">Ridotti</label>
                <div class="col-sm-1">
                    {{Form::select('half_price_qnt', array(
                    "0" => 0,
                    "1" => 1,
                    "2", 2,
                    "3" => 3,
                    "4" => 4), "0",
                    array('class' => 'form-control'))}}
                </div>
            </div>
            <!-- /Biglietti interi/ridotti -->

            <!-- check pagamento -->
            <div class="form-group">
                <label for="place_code" class="col-sm-2 control-label">Cod.Posto</label>
                <div class="col-sm-1">
                    {{Form::text('Cod.posto', '',
                        array(
                            'name' => 'place_code',
                            'class' => 'form-control'))
                    }}
                </div>
                <label for="paid" class="col-sm-1 control-label">Pagato</label>
                <div class="col-sm-1">
                    {{Form::select('paid', array("S" => "Sì", "N" => "No"), true,
                    array('class' => 'form-control'))}}
                </div>
            </div>
            <!-- /check pagamento -->

            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <div class="space-60" style="height: 80px;width:100%;"></div>
                <a href="{{URL::to('spettacoli')}}" class="btn btn-default">Annulla</a>
                <button type="submit" class="btn btn-primary">Prenota</button>
            </div>

        </div>
    {{ Form::close()}}
        @include('.modal.add-user')
    </div>

    <link rel="stylesheet" href="{{ URL::asset('stylesheets/jquery-ui.min.css') }}" >
    <script type="text/javascript" src="{{ URL::asset('javascripts/jquery-ui.min.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function(){
            $('#show').on('change', getShowDates);
            $('#date').on('change', getShowPlaces);
        });

        $('#spettatori-autocomplete').autocomplete({

            source: function(request, response){

                console.log(request);
                $.ajax({
                    url: $('#spettatori-autocomplete').data('ref'),
                    type: 'GET',
                    data: request,
                    success:function(data){
                        //var _data = $.parseJSON(data[0]);
                        response(
                            $.map(data, function(item){
                                var s = [],
                                _label = '<span>'+item.full_name+'<br /><small> '+item.email+'</small></span>';
                                s.push({name: item.full_name, label:_label, value: item.id});
                                    return s;
                                })
                        );
                    }
                });// end AJAX

            },
            minLength: 3,
            select:function(event, ui){
                //console.log(ui);
                $(this).val(ui.item.name);
                $('input[name="viewer"]').val(ui.item.value);

                return false;
            },
            open:function(){
                $(this).data("uiAutocomplete").menu.element.addClass("custom-autocomplete");
            }

        }).data("ui-autocomplete")._renderItem = function(ul, item){
            return $('<li></li>')
                    .data('item.autocomplete', item)
                    .append(item.label)
                    .appendTo(ul);
        };

        $('#remote-save-user').submit(function(evt){
            evt.preventDefault();

            var _url = $(this).data('ref');

            $.ajax({
                url:_url,
                data:$(this).serialize(),
                type:'POST',
                success:function(data){
                    if(data.success){
                        //console.log(data);
                        $('.modal-body').html('<h2>Utente Registrato Correttamente</h2>');
                        //$('#modal-close').trigger('click');
                    }
                }
            });

        }); //end submit

    </script>
    <script type="text/javascript" src="{{asset('javascripts/book/book.js')}}"></script>
@stop