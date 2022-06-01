@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-md-10">

								<input type="file" name="file" class="form-control">
								<br>
								<div class="row">
									<div class="col-md-4">
										<h5>Master Records</h5>
										<input type="checkbox" name="Region" value="Region"> Region
										<br><input type="checkbox" name="District" value="District"> District
										<br><input type="checkbox" name="Township" value="Township"> Township
										<br><input type="checkbox" name="City" value="City"> City
										<br><input type="checkbox" name="Zone" value="Zone"> Zone
										<br><input type="checkbox" name="Ward" value="Ward"> Ward
                                    </div>

								</div>

							</div>
							<div class="col-md-2">
								<button class="btn btn-success">Import Data</button>
							</div>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
