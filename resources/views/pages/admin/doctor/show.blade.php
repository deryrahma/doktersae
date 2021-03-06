@extends( 'layouts.master' )

@section( 'custom-head' )
    {!! HTML::style( 'plugins/datatables/dataTables.bootstrap.css' ) !!}
@endsection

@section( 'custom-footer' )
    {!! HTML::script( 'plugins/datatables/jquery.dataTables.min.js' ) !!}
    {!! HTML::script( 'plugins/datatables/dataTables.bootstrap.min.js' ) !!}
    <script>
        $( function() {
            $( '.dataTable' ).DataTable( {
                "info": false,
                "searching": false,
                "lengthChange": false,
                "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                "language": {
                    "emptyTable": "Data tidak ditemukan!",
                    "paginate": {
                        "next": ">",
                        "previous": "<",
                        "first": "<<",
                        "last": ">>"
                    }
                }
            } );
        } );
    </script>
@endsection

@section( 'content' )
    @include( 'pages.admin.doctor.header' )
    <section class="content">
        @include( 'errors.session' )
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Detail Dokter </h3>                                    
                    </div>
                    <div class="box-body">
                        <div class="col-md-2">
                        @if(File::exists('data/doctor/'.$data['content']->photo) and !empty($data['content']->photo))
                            <img src="{!! asset('data/doctor/'.$data['content']->photo) !!}" class="img-responsive img-thumbnail">
                        @else
                            <img src="{!! asset('img/doctor.png') !!}" class="img-responsive img-thumbnail">
                        @endif
                        </div>
                        <div class="col-md-10">
                            <h3>{!! $data['content']->name !!}</h3>
                            <p>
                                {!! $data['content']->specialization->name !!}
                            </p>
                            <?php 
                            $rate = 0;
                            foreach ($data['content']->reviews as $row) {
                                $rate += intval($row->rating);
                            }
                            if($rate > 0)
                                $rate /= $data['content']->reviews->count();
                            $rate = intval($rate);
                            ?>
                            <p>
                                <ul class="list-rating list-inline">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rate)
                                    <li><i class="fa fa-star"></i></li>
                                    @else
                                    <li><i class="fa fa-star-o"></i></li>
                                    @endif
                                @endfor
                                </ul>
                                ({!! $data['content']->reviews->count() !!} ulasan)
                            </p>
                            <div>
                                <h4>Tempat Praktek</h4>
                                <ul class="list-inline">
                                    @foreach($data['content']->clinics as $clinic)
                                    <li>
                                        {!! $clinic->name !!}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#education" data-toggle="tab">Pendidikan</a></li>
                              <li><a href="#experience" data-toggle="tab">Pengalaman</a></li>
                              <li><a href="#schedule" data-toggle="tab">Jadwal Praktek</a></li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="education">
                                <a href="{!! route('admin.doctor.education.create',[$data['content']->id]) !!}" class="btn btn-info">Tambah Pendidikan</a>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Pendidikan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['content']->doctorEducation as $row)
                                        <tr>
                                            <td>{!! $row->year !!}</td>
                                            <td>{!! $row->name !!}</td>
                                            <td><a href="{!! route('admin.doctor.education.destroy', [$row->id]) !!}" > <i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                              </div><!-- /.tab-pane -->
                              <div class="tab-pane" id="experience">
                                <a href="{!! route('admin.doctor.experience.create',[$data['content']->id]) !!}" class="btn btn-info">Tambah Pengalaman</a>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pengalaman</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['content']->doctorExperience as $row)
                                        <tr>
                                            <td>{!! $row->name !!}</td>
                                            <td><a href="{!! route('admin.doctor.experience.destroy', [$row->id]) !!}" > <i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                              </div><!-- /.tab-pane -->
                              <div class="tab-pane" id="schedule">
                                
                              </div>
                            </div><!-- /.tab-content -->
                          </div><!-- nav-tabs-custom -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include( 'scripts.delete-modal' )
@endsection