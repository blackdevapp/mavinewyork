<?php /** admin system image home page 
      /* set type to table that will append table data  */ ?>
@include('admin.static', ['type' => 'table', 'cid' => $cid, 'cfield' => $fields])
@yield('static.base')
	<div>
		<a href="{{ config('app.admin_url').'/system/images' }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50">
              <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">{{ trans($router.'back') }}</span>
      	</a>
	</div>
	<hr />
	<div class="row">
		<div class="col-3"> </div>
		<div class="col-6">
        	<div class="card">
        		<div class="card-header">
        			{{ trans($router.'create') }}
        		</div>
        		<div class="card-body">
            		<div class="row">
                        <div class="col-lg-12">
                            <form role="form" method="POST" action="{{ config('app.admin_url').'/system/images/create' }}">
                            	@csrf
                            	@foreach($fields as $field_id => $field)
                            		@if($field['hide'])
                            			{!! $field['field'] !!}
                            		@else
                            			<div class="form-group">
                                            <label>{{ $field['name'] }}</label>
                                            {!! $field['field'] !!}
                                    	</div>
                            		@endif
                                @endforeach
                                <button type="submit" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                      <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">{{ trans($router.'create_button') }}</span>
                          		</button>
                            </form>
                        </div>
                    </div>
            	</div>
        	</div>
        </div>
    	<div class="col-3"> </div>
    </div>
@yield('footer.login')