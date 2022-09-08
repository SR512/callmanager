@extends('admin.layouts.master')

@section('title') User list @endsection
@section('css')


@endsection
@section('content')

    @component('components.breadcrumb',['li_1'=>['Dashboard'=>route('root')]])
        @slot('title') User list  @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        @can('usermanagements.create')
                            <a href="{{route('usermanagements.create')}}" onclick="showSaveModel(event)"
                               class="btn btn-primary"><i
                                    class="mdi mdi-account-plus"></i>&nbsp;Add User</a>
                        @endcan
                    </div>
                    <div class="float-start">
                        {!! Form::open(['url' =>route('usermanagements.index'),'id' =>'form-search','class'=>'row row-cols-lg-auto g-3 align-items-center','method' => 'get']) !!}
                        <div class="form-group">
                            {!! Form::text('query_str',request()->query('query_str'),['class'=>'form-control','placeholder'=>'Search by name / email','style="width: 330px;"']) !!}
                        </div>
                        <div class="form-group">
                            @component('components.date-picker-component')
                            @endcomponent
                        </div>
                        <div class="form-group">
                            {!! Form::select('role',$roles,request()->query('role'),['class'=>'form-control zone','placeholder'=>'Select role']) !!}
                        </div>
                        <button type="submit" name="type" value="submit"
                                class="btn btn-primary waves-effect waves-light">
                            Submit
                        </button>
                        &nbsp;
                        <a href="{{route('usermanagements.index')}}" class="btn btn-secondary waves-effect waves-light">
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
    <script type="text/javascript">
        $('.show_confirm').click(function (e) {
            if (!confirm('Are you sure you want to delete this?')) {
                e.preventDefault();
            }
        });
        $(".row_expand").on('click', function () {
            if ($(this).children().hasClass('fa-plus')) {
                $(this).children().removeClass('fa-plus');
                $(this).children().addClass('fa-minus');
                $($(this).data('target')).addClass('show')
            } else {
                $(this).children().addClass('fa-plus');
                $(this).children().removeClass('fa-minus');
                $($(this).data('target')).removeClass('show')
            }
        });

    </script>
@endsection
