<?php /** admin system image home page 
      /* set type to table that will append table data  */ ?>
@include('admin.static', ['type' => 'table', 'cid' => $cid, 'cfield' => $cfield])
@yield('static.base')
	<div>
		<a href="{{ config('app.admin_url').'/system/images/create' }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-check"></i>
            </span>
            <span class="text">{{ trans($router.'create') }}</span>
      	</a>
	</div>
	<hr />
	<div>
	   <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="{{ $cid }}" width="100%" cellspacing="0">
              <thead>
                <tr>
                	@foreach($cfield as $field_id => $field)
            			<th data-data="{{ $field['id'] }}" data-name="{{ $field['id'] }}">{{ $field['name'] }}</th>
                  	@endforeach
                  	<!-- edit , view and delete data here -->
                  	<th data-data="settings" data-name="settings"></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                	@foreach($cfield as $field_id => $field)
                  		<th data-data="{{ $field['id'] }}" data-name="{{ $field['id'] }}">{{ $field['name'] }}</th>
                  	@endforeach
                  	<th data-data="settings" data-name="settings"></th>
                </tr>
              </tfoot>
              <tbody>
                <tr>
                	@foreach($cfield as $field_id => $field)
                  		<td data-data="{{ $field['id'] }}" data-name="{{ $field['id'] }}"></td>
                  	@endforeach
                  	<th data-data="settings" data-name="settings"></th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
	</div>
@yield('footer.login')