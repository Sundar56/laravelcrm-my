@extends('crm.admin.layouts.app')

@section('title', 'Company')

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
<link rel="stylesheet" href="{{asset('cdn/intlTelInput/intlTelInput.css').Config::get('app.assets_version') }}" />
@endsection

@section('vendor-script')
<script
    src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js' . Config::get('app.assets_version')) }}"></script>
<script
    src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js' . Config::get('app.assets_version')) }}"></script>
<script src="{{ asset('cdn/intlTelInput/intlTelInput.js').Config::get('app.assets_version') }}"></script>
<script src="{{ asset('cdn/jquery-mask/jquery.mask.js').Config::get('app.assets_version') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/company.js' . Config::get('app.assets_version')) }}"></script>
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <nav aria-label="breadcrumb" class="pageTop">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('crm.dashboard') }}" class="text-secondary">Dashboard</a>
                </li>
                <i class="bx bx-chevron-right"></i>
                <li class="breadcrumb-item"><a href="{{ route('crm.companies.index') }}" class="text-secondary">Companies</a></li>
                <i class="bx bx-chevron-right"></i>
                <li class="breadcrumb-item active" aria-current="page">{{$company_details->company_name}}</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img class="preview-create-image-before-upload preview-img company-logo" id="update-company-logo"
                        src="{{ !empty($company_details->company_logo) ? asset($company_details->company_logo) : asset('assets/img/company.png') }}" alt="preview image">
                    <div class="text-start">
                        <h6 class="heading-text neutral-100" heading-text neutral-100id="company-name">{{$company_details->company_name}}</h6>
                        <span class="body-text neutral-300" id="company-description">{{$company_details->description}}</span>
                    </div>
                </div>
                <button class="btn btn-thin btn-edit border p-2 editCompanyForm" data-id="{{$company_details->id}}"> <i class="bx bx-edit"></i> <span class="d-none d-sm-inline-block">Edit Details</span></button>
            </div>
        </div>
        <div class="row mb-2">
            @include('crm.admin.companies.navTab')
        </div>
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
                        @include('crm.admin.companies.accountInfo')
                    </div>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                        @include('crm.admin.companies.userLogin')
                    </div>
                    <div class="tab-pane fade" id="pills-SSO" role="tabpanel" aria-labelledby="pills-SSO-tab">
                        @include('crm.admin.companies.ssoSettings')
                    </div>
                    <div class="tab-pane fade" id="pills-ssopage" role="tabpanel" aria-labelledby="pills-ssopage-tab">
                        @include('crm.admin.companies.ssoSettingpage')
                    </div>
                    <div class="tab-pane fade" id="pills-crm" role="tabpanel" aria-labelledby="pills-crm-tab">
                        @include('crm.admin.companies.crmSettings')
                    </div>
                    <div class="tab-pane fade" id="pills-cms" role="tabpanel" aria-labelledby="pills-cms-tab">
                        @include('crm.admin.companies.cmsSettings')
                    </div>
                    <div class="tab-pane fade" id="pills-shop" role="tabpanel" aria-labelledby="pills-shop-tab">
                        @include('crm.admin.companies.shopSetting')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('crm.admin.companies.editCompany')










@endsection