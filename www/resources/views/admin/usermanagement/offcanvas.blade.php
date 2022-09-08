<div class="offcanvas offcanvas-end" style="width: 30% !important;" tabindex="-1" id="offcanvasCreate"
     aria-labelledby="offcanvasCreate">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasCreate">{{isset($user)?'Edit':'Create new'}} user</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        @if(isset($user))
            {!! Form::open(array('url' => route('usermanagements.update',$user->id),'method'=>'PATCH','id'=>'user-form','files'=>true)) !!}
        @else
            {!! Form::open(array('url' => route('usermanagements.store'),'method'=>'POST','id'=>'user-form','files'=>true)) !!}
        @endif

            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-group">
                            {!!  Form::label('name', 'Name',['style' =>'justify-content: right']); !!}<span
                                class="required">*</span>
                            {!! Form::text('name',isset($user) ? $user->name:old('name'),['class' => 'form-control','id' =>'name'])!!}
                            @error('name')
                            <span style="color:red">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-group">
                            {!!  Form::label('email', 'email',['style' =>'justify-content: right']); !!}<span
                                class="required">*</span>
                            {!! Form::text('email',isset($user) ? $user->email:old('email'),['class' => 'form-control','id' =>'email'])!!}
                            @error('email')
                            <span style="color:red">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-group">
                            {!!  Form::label('expiry_date', 'Expiry date',['style' =>'justify-content: right']); !!}<span
                                class="required">*</span>
                            {!! Form::date('expiry_date',isset($user) ? $user->expiry_date:old('expiry_date'),['class' => 'form-control','id' =>'expiry_date'])!!}
                            @error('expiry_date')
                            <span style="color:red">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-group">
                            {!!  Form::label('message', 'Message',['style' =>'justify-content: right']); !!}<span
                                class="required">*</span>
                            {!! Form::number('message',isset($user) ? $user->message:old('message'),['class' => 'form-control','id' =>'message'])!!}
                            @error('message')
                            <span style="color:red">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-group">
                            {!!  Form::label('device', 'Device',['style' =>'justify-content: right']); !!}<span
                                class="required">*</span>
                            {!! Form::number('device',isset($user) ? $user->device:old('device'),['class' => 'form-control','id' =>'device'])!!}
                            @error('device')
                            <span style="color:red">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-group">
                            {!!  Form::label('role', 'Role',['style' =>'justify-content: right']); !!}<span
                                class="required">*</span>
                            {!! Form::select('role',$roles,isset($user) ? $user->roles()->first()->id:old('role'),['class'=>'form-control','id'=>'role','style'=>'width: 100%','placeholder'=>'Select role']) !!}
                            @error('role')
                            <span style="color:red">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
            </div>
        </div>
        </form>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\UserRequest', '#user-form'); !!}
<script>
    // Save OR UPDATE DATA
    $('#user-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('#user-form')[0]);
        var page = $('.page-number').val()
        formData.append('page', page);
        var url = $(this).attr('action');
        var method = $(this).attr('method');

        if ($(this).valid()) {
            $('#status').show();
            $('#preloader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                processData: false,
                contentType: false,
                type: method,
                data: formData,
                success: function (data, textStatus, jqXHR) {
                    if (!data.error) {
                        $('#status').hide();
                        $('#preloader').hide();
                        $(".divtable").html(data.view);
                        toastr.success(data.message);
                        let closeCanvas = document.querySelector('[data-bs-dismiss="offcanvas"]');
                        closeCanvas.click();
                        location.reload();
                    } else {
                        $('#status').hide();
                        $('#preloader').hide();
                        toastr.error(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#status').hide();
                    $('#preloader').hide();
                    toastr.error('Error occurred!');
                }
            });
        }
    })
</script>
