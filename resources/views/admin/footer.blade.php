@section('footer.notLogin')
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('sbadmin/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('sbadmin/js/admin.js') }}"></script>
</body>
@endsection
@section('footer.login')
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ config('app.admin_url').'/logout' }}">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('sbadmin/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('sbadmin/js/admin.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
    <?php if(isset($type)){ ?>
  	@switch($type)
  		@case('table')
  			  <!-- Page level plugins -->
              <script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.js') }}"></script>
              <script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
              <!-- Page level custom scripts -->
              <script>
              	$(document).ready(function() {
            	  var table = $('#{{ $cid }}').DataTable({
            		  'processing': true,
            		  'serverSide': true,
            		  "ajax": {
            			  "url": "{{ config('app.admin_url') }}/get_tables/",
            			  "data": {
            				  cid: "{{ $cid }}",
            			  },
            			  "dataType": "json"
            		  }
            	  });
            	  $('#{{ $cid }}').on( 'click', 'tr', function () {
        	        if ( $(this).hasClass('selected') ) {
        	            $(this).removeClass('selected');
        	        }
        	        else {
        	            table.$('tr.selected').removeClass('selected');
        	            $(this).addClass('selected');
        	        }
        	    } );
            	});
              </script>
  			@break
  		@default
  			<!-- nothing -->
  	@endswitch
  <?php } else { ?>
      <script src="{{ asset('sbadmin/js/demo/chart-area-demo.js') }}"></script>
      <script src="{{ asset('sbadmin/js/demo/chart-pie-demo.js') }}"></script>
  <?php } ?>
</body>
@endsection