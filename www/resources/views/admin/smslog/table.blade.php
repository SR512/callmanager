<table id="user-data " class="table table-striped table-bordered dt-responsive mt-2"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th>Date</th>
        <th>User</th>
        <th>Device</th>
        <th>Message</th>
        <th>Error</th>
        <th>Status</th>
{{--        <th>Action</th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach ($tableData as $key => $row)
        <tr>
            <td width="10%">{{ $row->date_formatted }}</td>
            <td>{{ $row->users->name }}</td>
            <td>
                Device code :- {{ $row->devices->device_code }}<br/>
                Device OS :- {{ $row->devices->device_os }}<br/>
                Device model :- {{ $row->devices->device_model }}<br/>
            </td>
            <td width="30%">{{ $row->message }}</td>
            <td width="10%">{{ $row->error }}</td>

            <td>
                @if($row->is_send == 'Y')
                    <span class="badge badge-soft-success">Sent</span>
                @else
                    <span class="badge badge-soft-danger">fail</span>
                @endif
            </td>
{{--            <td>--}}

{{--                <div class="btn-group" role="group">--}}
{{--                    <button id="btnGroupVerticalDrop1" type="button"--}}
{{--                            class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"--}}
{{--                            aria-haspopup="true" aria-expanded="true">--}}
{{--                        Action <i class="mdi mdi-chevron-down"></i>--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu">--}}
{{--                        @can('usermanagements.edit')--}}
{{--                            <a class="dropdown-item" onclick="showEditModel(event)"--}}
{{--                               href="{{route('usermanagements.edit',$row->id)}}">Edit</a>--}}
{{--                        @endcan--}}
{{--                        <a class="dropdown-item" onclick="showSMSConfigurationModel(event)" href="{{ route('usermanagements.sms_configuration',$row->id) }}">Set SMS configuration</a>--}}
{{--                        @if($row->is_active == 'Y')--}}
{{--                            <a class="dropdown-item" href="{{ route('usermanagements.status',$row->id) }}">Inactive</a>--}}
{{--                        @else--}}
{{--                            <a class="dropdown-item" href="{{ route('usermanagements.status',$row->id) }}">Active</a>--}}
{{--                        @endif--}}
{{--                        @can('usermanagements.destroy')--}}
{{--                            <a class="dropdown-item"--}}
{{--                               onclick="if(confirm('Are you sure you want to delete.')) document.getElementById('delete-{{ $row->id }}').submit()">--}}
{{--                                Delete</a>--}}
{{--                            <form id="delete-{{ $row->id }}"--}}
{{--                                  action="{{ route('usermanagements.destroy', $row->id) }}"--}}
{{--                                  method="POST">--}}
{{--                                @method('DELETE')--}}
{{--                                @csrf--}}
{{--                            </form>--}}
{{--                        @endcan--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </td>--}}
        </tr>
    @endforeach
    </tbody>
</table>

{{$tableData->appends($_GET)->links()}}
