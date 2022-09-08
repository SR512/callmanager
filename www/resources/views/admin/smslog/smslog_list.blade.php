@extends('admin.layouts.master')

@section('title') SMS Log list @endsection
@section('css')


@endsection
@section('content')

    @component('components.breadcrumb',['li_1'=>['Dashboard'=>route('root')]])
        @slot('title') SMS Log list  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">

                    </div>
                    <div class="float-start">
                        {!! Form::open(['url' =>route('smslogs.index'),'id' =>'form-search','class'=>'row row-cols-lg-auto g-3 align-items-center','method' => 'get']) !!}

                        @if(auth()->user()->getRole() == config('constants.SUPER_ADMIN'))
                        <div class="form-group">
                            {!! Form::text('query_str',request()->query('query_str'),['class'=>'form-control','placeholder'=>'Search by name','style="width: 330px;"']) !!}
                        </div>
                        @endcan
                        <div class="form-group">
                            @component('components.date-picker-component')
                            @endcomponent
                        </div>
                        <div class="form-group">
                            {!! Form::select('status',['Y'=>'Sent','N'=>'Fail'],request()->query('status'),['class'=>'form-control zone','placeholder'=>'Select status']) !!}
                        </div>
                        <button type="submit" name="type" value="submit"
                                class="btn btn-primary waves-effect waves-light">
                            Submit
                        </button>
                        &nbsp; <button type="submit" name="type" value="excel"
                                       class="btn btn-success waves-effect waves-light">
                            <i class="fa fa-download"></i>&nbsp;Export
                        </button>
                        &nbsp;
                        <a href="{{route('smslogs.index')}}" class="btn btn-secondary waves-effect waves-light">
                            Reset
                        </a>
                        {!! Form::close() !!}
                    </div>
                    <div class="clearfix"></div>
                    <div class="divtable">
                        <input type="hidden" class="page-number" value="{{request()->query('page')??0}}"></input>
                        {!! $table !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="divOffcanvas">

        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/user.js')}}"></script>
@endsection
