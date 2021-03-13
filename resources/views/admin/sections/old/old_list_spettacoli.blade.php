
 <div class="panel panel-default">
                     <div class="panel-heading">
                         <i class="fa fa-navicon fa-fw"></i> Spettacoli
                     </div>
                     <!-- /.panel-heading -->
                     <div class="panel-body">
                         <div class="table-responsive">
                             <table class="table table-condensed" id="dataTables-example">
                                 <tbody>
                                 @if(count($spettacoli) > 0)
                                 @foreach($spettacoli as $gig)
                                     <tr class="odd" id="gig-{{$gig->id}}">
                                         <td class="col-lg-12 col-md-12 col-sm-12">
                                             <div class="border-right title-container col-lg-9 col-md-9 col-sm-12">
                                                 <div>
                                                     <h2 class="text-uppercase gig-title upper">
                                                         {{$gig->nome}}
                                                         <small>
                                                             <a href="{{URL::to('spettacoli', $gig->id).'/edit'}}">
                                                                 <i class="fa fa-edit" title="modifica"></i>
                                                             </a>
                                                          </small>
                                                     </h2>
                                                 </div>
                                                 <div>
                                                     <ul class="list-inline">
                                                         <li>
                                                             <span class="bigfat-number">
                                                             {{Eventi::where('spettacolo_id', '=', $gig->id)->count();}}
                                                             <small>date</small>
                                                             </span>
                                                         </li>
                                                         <li>
                                                             <span class="bigfat-number">
                                                             {{$gig->prezzo_intero}}
                                                             <small>intero</small>
                                                             </span>
                                                         </li>
                                                         <li>
                                                             <span class="bigfat-number">
                                                             {{$gig->prezzo_ridotto}}
                                                             <small>ridotto</small>
                                                             </span>
                                                         </li>
                                                         <li>
                                                         @if(Prenotazioni::where('spettacolo_id', '=', $gig->id)->count() > 0)
                                                             <span class="bigfat-number">
                                                             {{Prenotazioni::where('spettacolo_id', '=', $gig->id)->sum('qnt');}}
                                                             <small>prenotazioni</small>
                                                             </span>
                                                         @endif
                                                         </li>
                                                     </ul>
                                                 </div>
                                             </div>
                                             <div class="col-lg-3 col-md-3 col-sm-12 text-center upper">
                                                 <ul class="list-unstyled">
                                                     <li>
                                                         {{--<a title="prenota" href="{{URL::to('spettacoli/book/'.$gig->nome)}}" class="action-ref">--}}
                                                         <a title="prenota" href="{{URL::to('spettacoli/book/'.($gig->id))}}" class="action-ref">
                                                             <div class="fake-btn">
                                                                 <span> <i class="fa fa-shopping-cart"></i> Prenota </span>
                                                             </div>
                                                         </a>
                                                     </li>
                                                     <li>
                                                         <a title="calendario" data-toggle="collapse" class="action-ref"
                                                         href="#open-me-{{$gig->id}}" aria-expanded="false" aria-controls="open-me-{{$gig->id}}">
                                                         <div class="fake-btn fake-btn-alt" data-open-el="open-me-{{$gig->id}}">
                                                             <span><i class="fa fa-calendar"></i> Date  </span>
                                                         </div>
                                                         </a>
                                                     </li>
                                                 </ul>
                                             </div>

                                             <div class="collapse col-lg-9 col-md-9 col-sm-9" id="open-me-{{$gig->id}}">
                                                 <table class="table table-condensed">
                                                 <thead>
                                                     <th>data</th>
                                                     <th>orario</th>
                                                     <th class="text-center">prenotazioni</th>
                                                     <th class="text-center">operazioni</th>
                                                 </thead>
                                                 <tbody>
                                                 @foreach(Eventi::where('spettacolo_id', '=', $gig->id)->get() as $ev)
                                                     <tr>
                                                         <td colspan="1s"><span>{{date('d/m/Y', strtotime($ev->data_spettacolo))}}</span></td>
                                                         <td><span>{{date('H:i', strtotime($ev->data_spettacolo))}}</span></td>
                                                         <td class="text-center"><span>{{Prenotazioni::where('evento_id', '=', $ev->id)->sum('qnt');}}/{{$ev->qnt - Prenotazioni::where('evento_id', '=', $ev->id)->sum('qnt');}}</span></td>

                                                         <td class="text-center">
                                                             <ul class="list-inline">
                                                                 <li>
                                                                     <a href="#"><i class="fa fa-edit"></i></a>
                                                                 </li>
                                                                 <li>
                                                                     <a href="{{URL::to('list/print', array('id_evento' => $ev->id))}}">
                                                                         <i class="fa fa-print"></i>
                                                                     </a>
                                                                 </li>
                                                             </ul>
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                                 </tbody>
                                                 </table>
                                             </div>
                                             <!-- end container -->
                                         </td>
                                     </tr>
                                     {{--@endif--}}
                                 @endforeach
                                 @else
                                 <tr class="text-center">
                                     <td><h3>Non ci sono spettacoli disponibili<br />
                                     <small>Puoi aggiungerne uno cliccando
                                     <a class="text-primary" href="{{URL::to('spettacoli/create')}}">qui</a> </small></h3></td>
                                 </tr>
                                 @endif
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>