<table id="user-data " class="table table-striped table-bordered dt-responsive mt-2"
       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Created at</th>
        <th>Expired at</th>
        <th>Message</th>
        <th>Devices</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tableData as $key => $row)
        <tr>
            <td class="clickable row_expand" data-toggle="collapse" id="row{{$key}}" data-target=".row{{$key}}"><i
                    class="fa fa-plus"></i> {{ $row->name }}</td>
            <td>{{ $row->email }}</td>
            <td>{{ $row->getRoleNames()->first()  }}</td>
            <td>{{ $row->created_at_formatted }}</td>
            <td>{{ $row->expiry_date_at_formatted }}</td>
            <td>{{ $row->message }}</td>
            <td>{{ $row->device }}</td>
            <td>
                @if($row->is_active == 'Y')
                    <span class="badge badge-soft-success">Active</span>
                @else
                    <span class="badge badge-soft-danger">Inactive</span>
                @endif
            </td>
            <td>

                <div class="btn-group" role="group">
                    <button id="btnGroupVerticalDrop1" type="button"
                            class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        Action <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        @can('usermanagements.edit')
                            <a class="dropdown-item" onclick="showEditModel(event)"
                               href="{{route('usermanagements.edit',$row->id)}}">Edit</a>
                        @endcan
                        <a class="dropdown-item" onclick="showSMSConfigurationModel(event)" href="{{ route('usermanagements.sms_configuration',$row->id) }}">Set SMS configuration</a>
                        @if($row->is_active == 'Y')
                            <a class="dropdown-item" href="{{ route('usermanagements.status',$row->id) }}">Inactive</a>
                        @else
                            <a class="dropdown-item" href="{{ route('usermanagements.status',$row->id) }}">Active</a>
                        @endif
                        @can('usermanagements.destroy')
                            <a class="dropdown-item"
                               onclick="if(confirm('Are you sure you want to delete.')) document.getElementById('delete-{{ $row->id }}').submit()">
                                Delete</a>
                            <form id="delete-{{ $row->id }}"
                                  action="{{ route('usermanagements.destroy', $row->id) }}"
                                  method="POST">
                                @method('DELETE')
                                @csrf
                            </form>
                        @endcan
                    </div>
                </div>
            </td>
        </tr>
        <tr class="row{{$key}} in collapse">
            <td colspan="9">
                <table class="table table-bordered dt-responsive">
                    <thead>
                    <tr>
                        <th>Device code</th>
                        <th>OS</th>
                        <th>Device model</th>
                        <th>Status</th>
                        <th width="20%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($row->devices) != 0)
                        @foreach($row->devices as $device)
                            <tr class="">
                                <td>{{$device->device_code}}</td>
                                <td>{{$device->device_os}}</td>
                                <td>{{$device->device_model}}</td>
                                <td>
                                    @if($device->is_active == 'Y')
                                        <span class="badge badge-soft-success">Active</span>
                                    @else
                                        <span class="badge badge-soft-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($device->is_active == 'Y')
                                        <a class="btn btn-danger btn-sm"
                                           href="{{route('devices.status',$device->id)}}">Inactive</a>
                                    @else
                                        <a class="btn btn-success btn-sm"
                                           href="{{route('devices.status',$device->id)}}">Active</a>
                                    @endif
                                    <a class="btn btn-danger btn-sm"
                                       onclick="if(confirm('Are you sure you want to delete.')) document.getElementById('delete-{{ $device->id }}').submit()">
                                        Delete</a>
                                    <form id="delete-{{ $device->id }}"
                                          action="{{ route('devices.destroy', $device->id) }}"
                                          method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr align="center">
                            <td colspan="9">No device found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$tableData->appends($_GET)->links()}}
