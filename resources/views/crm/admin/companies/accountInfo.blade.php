<div class="row">
    <div class="col-12 col-lg-10 col-xl-8">
        <div class="border p-2">
            <div class="d-flex align-items-center mb-4">
                <div class="widgets-icons bg-lighter">
                    <i class="bx bx-hash"></i>
                </div>
                <div class="ms-2">
                    <span class="mb-0 text-secondary">VAT ID</span>
                    <p class="m-0" id="company-vat-id">{{$company_details->vat_id}}</p>
                </div>
            </div>
            <div class="d-flex align-items-lg-center  mb-4 pe-2">
                <div class="widgets-icons bg-lighter flex-shrink-0">
                    <i class='bx bx-map-alt'></i>
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-grow-1 gap-4 ms-2">

                    <div class="">
                        <span class="mb-0 text-secondary">Address</span>
                        <p class="m-0" id="company-address">{{$company_details->address}}</p>
                    </div>

                    <div class="">
                        <span class="mb-0 text-secondary">Zipcode</span>
                        <p class="m-0" id="company-zipcode">{{$company_details->zipcode}}</p>
                    </div>
                    <div class="">
                        <span class="mb-0 text-secondary">City</span>
                        <p class="mb-0" id="company-city">{{$company_details->city}}</p>
                    </div>
                    <div class="">
                        <span class="mb-0 text-secondary">Country</span>
                        <p class="mb-0" id="company-country">{{$company_details->country}}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center mb-4">
                <div class="widgets-icons bg-lighter">
                    <i class="bx bx-envelope"></i>
                </div>
                <div class="ms-2">
                    <span class="mb-0 text-secondary">Invoice Email</span>
                    <p class="m-0" id="company-invoice-email">{{$company_details->invoice_email}}</p>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="widgets-icons bg-lighter">
                    <i class="bx bx-hash"></i>
                </div>
                <div class="ms-2">
                    <span class="mb-0 text-secondary">EAN Number</span>
                    <p class="m-0" id="company-ean-number">{{$company_details->ean_number}}</p>
                </div>
            </div>
        </div>
    </div>
</div>