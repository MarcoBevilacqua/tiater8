@extends("admin/admin-layout")

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="page-header">
                <h1>Cerca Prenotazione</h1>
            </div>
        </div>
        <div class="row">
            <!-- SPETTATORI -->
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h4>Spettatore/email</h4>
                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                    {{Form::text('spettatore', '',
                    array(
                        'id' => 'cerca-codice-autocomplete',
                        'class' => 'form-control',
                        'data-ref' => URL::to('/') .'/api/users/search',
                        'autocomplete' => 'off'))
                    }}
                    {{Form::hidden('spettatore_id', '', array('id' => 'spettatore_id'))}}
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <button data-ref="{{URL::to('api/book/user/search')}}"
                            type="button" id="btn-visualizza-spettatore"
                            data-input="spettatore_id"
                            class="btn btn-primary disabled">Visualizza Prenotazioni
                    </button>
                </div>
            </div>
            {{-- TOKEN UNIVOCO --}}
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h4>Codice Univoco</h4>
                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                    {{Form::text('token', '', array(
                        'id' => 'cerca-token-autocomplete',
                        'class' => 'form-control',
                        'data-ref' => URL::to('/') .'/api/book/token/search',
                        'autocomplete' => 'off'))
                    }}
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <button data-ref="{{URL::to('/api/book/token/search')}}"
                            type="button" id="btn-visualizza-token" data-input="cerca-token-autocomplete"
                            class="btn btn-primary">Visualizza Prenotazioni
                    </button>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        <div class="row">
            <!-- da riempire con i risultati della ricerca [ALT]-->
            <div class="col-lg-12 col-md-12 col-sm-12" id="search-result-alt">
                <div class="page-header text-center">
                    <h3>Risultati ricerca</h3>
                </div>
                <div class="search-res-clone hidden">
                    <div data-class="cloned-search-result-child">
                        <div data-class="upper">
                            <div class="col-lg-10 col-md-10 col-sm-10 text-left">
                                <h6>
                                    <i class="fa fa-calendar-o"></i> <span class="date"></span>
                                    <i class="fa fa-clock-o"></i> <span class="hour"></span>
                                </h6>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1">
                                <h5 class="label paid"></h5>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 url-container">
                                <h6><a class="url" href="#"></a></h6>
                            </div>
                        </div>
                        <div data-class="center" class="col-lg-12 col-md-12 col-sm-12">
                            <div class="text-left info">
                                <h2 class="title"></h2>
                                <h5>
                                    <span class="place"></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ URL::asset('stylesheets/jquery-ui.min.css') }}">
    <script type="text/javascript" src="{{ URL::asset('javascripts/jquery-ui.min.js')}}"></script>

    <script type="text/javascript">

        var _href = $('#cerca-codice-autocomplete').data('ref');
        $('#cerca-codice-autocomplete').autocomplete({
            source: function (request, response) {

                $.ajax({
                    url: _href,
                    type: 'GET',
                    data: request,
                    success: function (data) {
                        //var _data = $.parseJSON(data[0]);
                        response(
                                $.map(data, function (item) {
                                    var s = [];
                                    var __label = '<span>' + item.full_name + '<br /><small> ' + item.email + '</small></span>';
                                    s.push({name: item.email, label: __label, value: item.id});
                                    return s;
                                })
                        );
                    }
                });// end AJAX

            },
            minLength: 3,
            select: function (event, ui) {
                //console.log(ui);
                $(this).val(ui.item.name);
                $('input[name="spettatore_id"]').val(ui.item.value);
                $('#btn-visualizza-spettatore').removeClass("disabled");

                return false;
            },
            open: function () {
                $(this).data("uiAutocomplete").menu.element.addClass("custom-autocomplete");
            }

        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $('<li></li>')
                    .data('item.autocomplete', item)
                    .append(item.label)
                    .appendTo(ul);
        };


        //TODO: refactor funzioni (fanno la stessa cosa, si possono unificare)
        //visualizza prenotazioni per spettatore
        $('#btn-visualizza-spettatore').on('click', fillSearchAlt);

        //visualizza prenotazioni per token
        $('#btn-visualizza-token').on('click', fillSearchAlt);

        function fillSearchAlt() {
            var $id = $('#' + $(this).data('input')).val(),
                    $url = $(this).data('ref');

            if (!$id) {
                return;
            }

            //pulisce i risultati
            $('.cloned').remove();

            $.get($url + "/" + $id, [], function (data) {

                if (!data) {
                    return;
                }

                $(data).each(function (i, e) {
                    //build single search result element
                    buildSearchResult(e);
                });

            });

        }

        function buildSearchResult(e) {

            console.log(e);

            //clone and append
            $('.search-res-clone').not('.cloned').clone()
                    .addClass('cloned cloned-search-result col-lg-6 col-md-6 col-sm-6 text-center')
                    .appendTo('#search-result-alt');

            var $div = $('.cloned.cloned-search-result').last();

            $div
                    .find('[data-class="cloned-search-result-child"]').addClass('cloned-search-result-child');
            $div
                    .find('[data-class="upper"]')
                    .addClass('upper')
                    .removeAttr('data-class')
            ;

            $div.find('[data-class="center"]')
                    .addClass('center')
                    .removeAttr('data-class');
            $div
                    .find('[data-class="edit"]').addClass('edit').removeAttr('data-class');
            $div
            //fill data
                    .find('.date').html(e.show_date)
                    .closest('.upper').find('.hour').html(e.show_hour)
                    .closest('.upper').find('.url').attr('href', e.url).html('<i class="fa fa-2x fa-ellipsis-h"></i>')
            ;

            $div
            //show title + place code + paid label + image
                    .find('.center').find('.title').html(e.show)
                    .parent().find('.place').html("Posto <code>" + e.place + "</code> / " + "Codice <code>" + e.code + "</code>")
                    .closest('.info').find('.paid').addClass(e.paid.class)
            ;
            $div
                    .removeClass('hidden')
                    .fadeIn('300')
            ;

        }

        function showSearchResult() {

            var $id = $('#spettatore_id').val();

            $.ajax({
                url: $(this).data('ref'),
                type: 'GET',
                data: {id: $id},
                success: function (data) {
                    console.log(data);
                    //pulisce la tabella
                    $('#search-result').find('tbody tr').remove();

                    //inserisce gli item
                    $(data).each(function (i) {
                        var itemData = data[i];
                        var item = $('<tr></tr>').attr('id', 'bk-' + itemData.id)
                                .html(
                                        '<td>' + itemData.spettacolo + '</td>' +
                                        '<td>' + itemData.token + '</td>' +
                                        '<td>' + itemData.data + '</td>' +
                                        '<td>' + itemData.data_prenotazione + '</td>' +
                                        '<td>' + itemData.posto + '</td>' +
                                        '<td>' + itemData.pagato + '</td>');
                        $('#search-result tbody').append(item);

                    });//end function
                },
                error: function (err, xhr, text) {
                    console.log(err);
                }
            });// end AJAX
        }

        function fillSearchResult() {
            var $token = $('#cerca-token-autocomplete').val();

            $.ajax({
                url: $(this).data('ref') + '/' + $token,
                type: 'GET',
                success: function (data) {

                    //pulisce la tabella
                    $('#search-result').find('tbody tr').remove();

                    //inserisce gli item
                    $(data).each(function (i) {
                        var itemData = data[i];
                        var item = $('<tr></tr>').attr('id', 'bk-' + itemData.id)
                                .html(
                                        '<td>' + itemData.spettacolo + '</td>' +
                                        '<td>' + itemData.token + '</td>' +
                                        '<td>' + itemData.data + '</td>' +
                                        '<td>' + itemData.data_prenotazione + '</td>' +
                                        '<td>' + itemData.posto + '</td>' +
                                        '<td>' + itemData.pagato + '</td>');
                        $('#search-result tbody').append(item);

                    });//end function
                },
                error: function (err, xhr, text) {
                    console.log(err);
                }
            });// end AJAX
        }

    </script>

@stop


