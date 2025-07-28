@extends('crm.admin.layouts.app')

@section('title', 'Dashboard')

@section('vendor-style')
<!-- Vendor Styles -->
<link
    href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css' . Config::get('app.assets_version')) }}"
    rel="stylesheet">
</link>
<link
    href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap5.css' . Config::get('app.assets_version')) }}"
    rel="stylesheet">
</link>
@endsection

@section('vendor-script')
<script
    src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js' . Config::get('app.assets_version')) }}"></script>
<script
    src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js' . Config::get('app.assets_version')) }}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/company.js' . Config::get('app.assets_version')) }}"></script>
@endsection

@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 pageTop">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="card border-start border-0 border-4" style="border-color: #ff6b35 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Welcome</p>
                                <h3 style="color:#ff6b35">{{Auth::user()->user_displayname}}</h3>
                                <p class="mb-0">You can manage your Customers and Admin Users here!</p>
                            </div>
                            <div class="widgets-icons-2 ms-auto rounded-0 flex-shrink-0" style="background-color: #f6dbd0;width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                <i class='bx bx-line-chart' style="font-size: 45px;color:#ff6b35"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="card border-start border-0 border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mb-3">
                                <p class="mb-0">No of Admin Users</p>
                                <h3 class="my-1 text-success">{{ $userCount }}</h3>
                            </div>
                            <div class="widgets-icons-2 text-success ms-auto rounded-0 flex-shrink-0" style="background-color: #c9ebcd;width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                <i class='bx bx-user' style="font-size: 45px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="card border-start border-0 border-4 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="mb-3">
                                <p class="mb-0">No of Companies</p>
                                <h3 class="my-1 text-warning">{{ $companyCount }}</h3>
                            </div>
                            <div class="widgets-icons-2 text-warning ms-auto rounded-0 flex-shrink-0" style="background-color: #ffefc1; width: 80px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                <i class='bx bx-building-house' style="font-size: 45px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--end row-->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center mt-2 mb-0">
                <h6 class="card-title mb-0">
                    <i class="bx bx-buildings fs-5"></i> Company Registered
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive card-datatable">
                    <table class="table dt-responsive datatable" id="dashboard_companyList_table" style="width:100%">
                        <thead>
                            <tr class="table-secondary">
                                <th scope="col">ID</th>
                                <th scope="col">Company</th>
                                <th scope="col">VAT ID</th>
                                <th scope="col">Invoice Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Zipcode</th>
                                <th scope="col">City</th>
                                <th scope="col">Country</th>
                                <th scope="col">Status</th>
                                <th scope="col">Registered at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic content will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection