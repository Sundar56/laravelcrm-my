<ul class="nav nav-pills px-3 campany-tab" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">Account Info</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-user-tab" data-bs-toggle="pill" data-bs-target="#pills-user" type="button" role="tab" aria-controls="pills-user" aria-selected="false" data-companyId="{{$company_details->id}}">User Login</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-SSO-tab" data-bs-toggle="pill" data-bs-target="#pills-SSO" type="button" role="tab" aria-controls="pills-SSO" aria-selected="false" data-companyId="{{Crypt::encrypt($company_details->id)}}">General Settings</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-ssopage-tab" data-bs-toggle="pill" data-bs-target="#pills-ssopage" type="button" role="tab" aria-controls="pills-ssopage" aria-selected="false" data-companyId="{{Crypt::encrypt($company_details->id)}}">SSO Settings</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-crm-tab" data-bs-toggle="pill" data-bs-target="#pills-crm" type="button" role="tab" aria-controls="pills-crm" aria-selected="false" data-companyid="{{Crypt::encrypt($company_details->id)}}">CRM Settings</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-cms-tab" data-bs-toggle="pill" data-bs-target="#pills-cms" type="button" role="tab" aria-controls="pills-cms" aria-selected="false" data-companyid="{{Crypt::encrypt($company_details->id)}}">CMS Settings</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-shop-tab" data-bs-toggle="pill" data-bs-target="#pills-shop" type="button" role="tab" aria-controls="pills-shop" aria-selected="false" data-companyid="{{Crypt::encrypt($company_details->id)}}">SHOP Settings</button>
    </li>
</ul>