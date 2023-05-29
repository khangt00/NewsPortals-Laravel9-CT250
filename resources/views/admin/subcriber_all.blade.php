@extends('admin.layout.app')

@section('heading', 'All Subcribers')


@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Subcriber Email</th>
                                </tr>
                            </thead>
                            @foreach($subcribers as $row)
                            <tbody>
                                <tr>
                                    <td>{{  $loop->iteration  }}</td>
                                    <td>{{  $row->email }}</td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

