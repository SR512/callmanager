<div class="offcanvas offcanvas-end" style="width: 30% !important;" tabindex="-1" id="offcanvasCreate"
     aria-labelledby="offcanvasCreate">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasCreate">SMS configuration {{isset($user)?'('.$user->name.')':''}} </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        @if(isset($user))
            {!! Form::open(array('url' => route('sms.configuration.store'),'method'=>'POST','id'=>'user-sms-configuration-form','files'=>true)) !!}
            <input type="hidden" value="{{$user->id}}" name="user_id">
        @endif
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <div class="form-group">
                        {!!  Form::label('api_key', 'Api key',['style' =>'justify-content: right']); !!}<span
                            class="required">*</span>
                        {!! Form::text('api_key',$user->sms_configuration->api_key ?? old('api_key'),['class' => 'form-control','id' =>'api_key'])!!}
                        @error('api_key')
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
                        {!!  Form::label('username', 'User name',['style' =>'justify-content: right']); !!}<span
                            class="required">*</span>
                        {!! Form::text('username',$user->sms_configuration->username ?? old('username'),['class' => 'form-control','id' =>'username'])!!}
                        @error('username')
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
                        {!!  Form::label('sender_name', 'Sender name',['style' =>'justify-content: right']); !!}<span
                            class="required">*</span>
                        {!! Form::text('sender_name',$user->sms_configuration->sender_name ?? old('name'),['class' => 'form-control','id' =>'sender_name'])!!}
                        @error('sender_name')
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
                        {!!  Form::label('sms_type', 'SMS type',['style' =>'justify-content: right']); !!}<span
                            class="required">*</span>
                        {!! Form::text('sms_type',$user->sms_configuration->sms_type ?? old('sms_type'),['class' => 'form-control','id' =>'sms_type'])!!}
                        @error('sms_type')
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
{!! JsValidator::formRequest('App\Http\Requests\SmSConfigurationRequest', '#user-sms-configuration-form'); !!}
<script>
    // Save OR UPDATE DATA
    $('#user-sms-configuration-form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($('#user-sms-configuration-form')[0]);
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
