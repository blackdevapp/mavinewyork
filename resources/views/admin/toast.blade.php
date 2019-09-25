@section('toast')
<div style="position: absolute; top: 10px; left: 15px; z-index: 1">
	@foreach ($errors->all() as $error)
    <div class="toast fade show" data-autohide="true" data-delay="3000" id="myToast">
        <div class="toast-header" style="padding-top: 0px;padding-bottom: 0px;">
            <strong class="mr-auto"><i class="fas fa-exclamation"></i> Error</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body" style="padding-top: 5px;padding-bottom: 5px;">
            {{ $error }}
        </div>
    </div>
    @endforeach
</div>
@endsection