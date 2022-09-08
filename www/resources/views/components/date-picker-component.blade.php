<input type="text" class="date-range form-control" style="width:200px" readonly>
<input type="hidden" value="{{request()->query('start_date')}}" name="start_date" class="start_date">
<input type="hidden" value="{{request()->query('end_date')}}" name="end_date" class="end_date">

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('.date-range').daterangepicker({
                autoApply: false,
                alwaysShowCalendars: true,
                opens: 'left',
                applyButtonClasses: 'btn-danger',
                cancelClass: 'btn-white',
                locale: {
                        format: 'DD/MM/YYYY',
                    separator: " => ",
                },
                startDate: '{{!empty(request()->query('start_date')) ?\Carbon\Carbon::parse(request()->query('start_date'))->format('d/m/Y'):\Carbon\Carbon::now()->subDays(7)->format('d/m/Y')}}',
                endDate: '{{\Carbon\Carbon::parse(request()->query('end_date'))->format('d/m/Y')}}',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Next 7 Days': [moment(), moment().add(6, 'days')],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'All Time': [moment('2015-01-01'), moment().add(30, 'days')]
                },
            });

            $('.date-range').on('apply.daterangepicker', function (ev, picker) {
                $('.start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('.end_date').val(picker.endDate.format('YYYY-MM-DD'));
            });
        });

    </script>
@endsection
