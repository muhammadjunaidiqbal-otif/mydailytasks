@extends('Layouts.dashboard-layout')
@section('title')
    Order Details {{isset($orders)?$order->id:""}}
@endsection
@section('Vendor-CSS')
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

@endsection
@section('Page-CSS')
    
@endsection
@section('content')
     <!-- Content -->
     
     <div class="container-xxl flex-grow-1 container-p-y">
        <div
          class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
          <div class="d-flex flex-column justify-content-center">
            <div class="mb-1">
              <span class="h5">Order #{{isset($order->id)}}</span><span class="badge bg-label-success me-1 ms-2">{{isset($order->payment_status)}}</span>
              <span class="badge bg-label-info">{{isset($order->status)}}</span>
            </div>
            <p class="mb-0">Aug 17, <span id="orderYear"></span>, 5:48 (ET)</p>
          </div>
          <div class="d-flex align-content-center flex-wrap gap-2">
            <button class="btn btn-label-danger delete-order data-id="{{isset($order->id)}}">Delete Order</button>
          </div>
        </div>

        <!-- Order Details Table -->

        <div class="row">
          <div class="col-12 col-lg-8">
            <div class="card mb-6">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">Order details</h5>
                {{-- <h6 class="m-0"><a href=" javascript:void(0)">Edit</a></h6> --}}
              </div>
              <div class="card-datatable table-responsive">
                <table class="datatables-order-details table border-top">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th class="w-50">products</th>
                      <th class="w-25">price</th>
                      <th class="w-25">qty</th>
                      <th>total</th>
                    </tr>
                  </thead>
                </table>
                <div class="d-flex justify-content-end align-items-center m-6 mb-2">
                  <div class="order-calculations">
                    <div class="d-flex justify-content-start mb-2">
                      <span class="w-px-100 text-heading">Subtotal:</span>
                      <h6 class="mb-0">$2093</h6>
                    </div>
                    <div class="d-flex justify-content-start mb-2">
                      <span class="w-px-100 text-heading">Discount:</span>
                      <h6 class="mb-0">$2</h6>
                    </div>
                    <div class="d-flex justify-content-start mb-2">
                      <span class="w-px-100 text-heading">Tax:</span>
                      <h6 class="mb-0">$28</h6>
                    </div>
                    <div class="d-flex justify-content-start">
                      <h6 class="w-px-100 mb-0">Total:</h6>
                      <h6 class="mb-0">$2113</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- <div class="card mb-6">
              <div class="card-header">
                <h5 class="card-title m-0">Shipping activity</h5>
              </div>
              <div class="card-body pt-1">
                <ul class="timeline pb-0 mb-0">
                  <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                      <div class="timeline-header">
                        <h6 class="mb-0">Order was placed (Order ID: #32543)</h6>
                        <small class="text-muted">Tuesday 11:29 AM</small>
                      </div>
                      <p class="mt-3">Your order has been placed successfully</p>
                    </div>
                  </li>
                  <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                      <div class="timeline-header">
                        <h6 class="mb-0">Pick-up</h6>
                        <small class="text-muted">Wednesday 11:29 AM</small>
                      </div>
                      <p class="mt-3 mb-3">Pick-up scheduled with courier</p>
                    </div>
                  </li>
                  <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                      <div class="timeline-header">
                        <h6 class="mb-0">Dispatched</h6>
                        <small class="text-muted">Thursday 11:29 AM</small>
                      </div>
                      <p class="mt-3 mb-3">Item has been picked up by courier</p>
                    </div>
                  </li>
                  <li class="timeline-item timeline-item-transparent border-primary">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                      <div class="timeline-header">
                        <h6 class="mb-0">Package arrived</h6>
                        <small class="text-muted">Saturday 15:20 AM</small>
                      </div>
                      <p class="mt-3 mb-3">Package arrived at an Amazon facility, NY</p>
                    </div>
                  </li>
                  <li class="timeline-item timeline-item-transparent border-left-dashed">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                      <div class="timeline-header">
                        <h6 class="mb-0">Dispatched for delivery</h6>
                        <small class="text-muted">Today 14:12 PM</small>
                      </div>
                      <p class="mt-3 mb-3">Package has left an Amazon facility, NY</p>
                    </div>
                  </li>
                  <li class="timeline-item timeline-item-transparent border-transparent pb-0">
                    <span class="timeline-point timeline-point-secondary"></span>
                    <div class="timeline-event pb-0">
                      <div class="timeline-header">
                        <h6 class="mb-0">Delivery</h6>
                      </div>
                      <p class="mt-1 mb-0">Package will be delivered by tomorrow</p>
                    </div>
                  </li>
                </ul>
              </div>
            </div> --}}
          </div>
          <div class="col-12 col-lg-4">
            <div class="card mb-6">
              <div class="card-header">
                <h5 class="card-title m-0">Customer details</h5>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-start align-items-center mb-6">
                  <div class="avatar me-3">
                    <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                  </div>
                  <div class="d-flex flex-column">
                    <a href="app-user-view-account.html" class="text-body text-nowrap">
                      <h6 class="mb-0">{{$order->billingAddress->first_name ." ". $order->billingAddress->last_name}}</h6>
                    </a>
                    <span>Customer ID: #{{$order->billingAddress->id}}</span>
                  </div>
                </div>
                <div class="d-flex justify-content-start align-items-center mb-6">
                  <span
                    class="avatar rounded-circle bg-label-success me-3 d-flex align-items-center justify-content-center"
                    ><i class="ti ti-shopping-cart ti-lg"></i
                  ></span>
                  <h6 class="text-nowrap mb-0"></h6>
                </div>
                <div class="d-flex justify-content-between">
                  <h6 class="mb-1">Contact info</h6>
                  <h6 class="mb-1">
                    {{-- <a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editUser">Edit</a> --}}
                  </h6>
                </div>
                <p class="mb-1">Email: {{$order->billingAddress->email}}</p>
                <p class="mb-0">Mobile: {{$order->billingAddress->phone}}</p>
              </div>
            </div>

            {{-- <div class="card mb-6">
              <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0">Shipping address</h5>
                <h6 class="m-0">
                  <a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addNewAddress">Edit</a>
                </h6>
              </div>
              <div class="card-body">
                <p class="mb-0">45 Roker Terrace <br />Latheronwheel <br />KW5 8NW,London <br />UK</p>
              </div>
            </div> --}}
            <div class="card mb-6">
              <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0">Billing address</h5>
                {{-- <h6 class="m-0">
                  <a href=" javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addNewAddress">Edit</a>
                </h6> --}}
              </div>
              <div class="card-body">
                <p class="mb-6">{{$order->billingAddress->address}}<br />{{$order->billingAddress->city->name}} <br />{{$order->billingAddress->state->name}} <br />{{$order->billingAddress->country->name}}</p>
                <h5 class="mb-1">Mastercard</h5>
                <p class="mb-0">Card Number: ******4291</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-simple modal-edit-user">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                  <h4 class="mb-2">Edit User Information</h4>
                  <p>Updating user details will receive a privacy audit.</p>
                </div>
                <form id="editUserForm" class="row g-6" onsubmit="return false">
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserFirstName">First Name</label>
                    <input
                      type="text"
                      id="modalEditUserFirstName"
                      name="modalEditUserFirstName"
                      class="form-control"
                      placeholder="John"
                      value="John" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserLastName">Last Name</label>
                    <input
                      type="text"
                      id="modalEditUserLastName"
                      name="modalEditUserLastName"
                      class="form-control"
                      placeholder="Doe"
                      value="Doe" />
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="modalEditUserName">Username</label>
                    <input
                      type="text"
                      id="modalEditUserName"
                      name="modalEditUserName"
                      class="form-control"
                      placeholder="johndoe007"
                      value="johndoe007" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserEmail">Email</label>
                    <input
                      type="text"
                      id="modalEditUserEmail"
                      name="modalEditUserEmail"
                      class="form-control"
                      placeholder="example@domain.com"
                      value="example@domain.com" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserStatus">Status</label>
                    <select
                      id="modalEditUserStatus"
                      name="modalEditUserStatus"
                      class="select2 form-select"
                      aria-label="Default select example">
                      <option selected>Status</option>
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                      <option value="3">Suspended</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditTaxID">Tax ID</label>
                    <input
                      type="text"
                      id="modalEditTaxID"
                      name="modalEditTaxID"
                      class="form-control modal-edit-tax-id"
                      placeholder="123 456 7890"
                      value="123 456 7890" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserPhone">Phone Number</label>
                    <div class="input-group">
                      <span class="input-group-text">US (+1)</span>
                      <input
                        type="text"
                        id="modalEditUserPhone"
                        name="modalEditUserPhone"
                        class="form-control phone-number-mask"
                        placeholder="202 555 0111"
                        value="202 555 0111" />
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserLanguage">Language</label>
                    <select
                      id="modalEditUserLanguage"
                      name="modalEditUserLanguage"
                      class="select2 form-select"
                      multiple>
                      <option value="">Select</option>
                      <option value="english" selected>English</option>
                      <option value="spanish">Spanish</option>
                      <option value="french">French</option>
                      <option value="german">German</option>
                      <option value="dutch">Dutch</option>
                      <option value="hebrew">Hebrew</option>
                      <option value="sanskrit">Sanskrit</option>
                      <option value="hindi">Hindi</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalEditUserCountry">Country</label>
                    <select
                      id="modalEditUserCountry"
                      name="modalEditUserCountry"
                      class="select2 form-select"
                      data-allow-clear="true">
                      <option value="">Select</option>
                      <option value="Australia">Australia</option>
                      <option value="Bangladesh">Bangladesh</option>
                      <option value="Belarus">Belarus</option>
                      <option value="Brazil">Brazil</option>
                      <option value="Canada">Canada</option>
                      <option value="China">China</option>
                      <option value="France">France</option>
                      <option value="Germany">Germany</option>
                      <option value="India" selected>India</option>
                      <option value="Indonesia">Indonesia</option>
                      <option value="Israel">Israel</option>
                      <option value="Italy">Italy</option>
                      <option value="Japan">Japan</option>
                      <option value="Korea">Korea, Republic of</option>
                      <option value="Mexico">Mexico</option>
                      <option value="Philippines">Philippines</option>
                      <option value="Russia">Russian Federation</option>
                      <option value="South Africa">South Africa</option>
                      <option value="Thailand">Thailand</option>
                      <option value="Turkey">Turkey</option>
                      <option value="Ukraine">Ukraine</option>
                      <option value="United Arab Emirates">United Arab Emirates</option>
                      <option value="United Kingdom">United Kingdom</option>
                      <option value="United States">United States</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <div class="form-check form-switch">
                      <input type="checkbox" class="form-check-input" id="editBillingAddress" />
                      <label for="editBillingAddress" class="switch-label">Use as a billing address?</label>
                    </div>
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button
                      type="reset"
                      class="btn btn-label-secondary"
                      data-bs-dismiss="modal"
                      aria-label="Close">
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!--/ Edit User Modal -->

        <!-- Add New Address Modal -->
        <div class="modal fade" id="addNewAddress" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                  <h4 class="address-title mb-2">Add New Address</h4>
                  <p class="address-subtitle">Add new address for express delivery</p>
                </div>
                <form id="addNewAddressForm" class="row g-6" onsubmit="return false">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-md mb-md-0 mb-4">
                        <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioHome">
                            <span class="custom-option-body">
                              <svg
                                width="28"
                                height="28"
                                viewBox="0 0 28 28"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                  opacity="0.2"
                                  d="M16.625 23.625V16.625H11.375V23.625H4.37501V12.6328C4.37437 12.5113 4.39937 12.391 4.44837 12.2798C4.49737 12.1686 4.56928 12.069 4.65939 11.9875L13.4094 4.03592C13.5689 3.88911 13.7778 3.80762 13.9945 3.80762C14.2113 3.80762 14.4202 3.88911 14.5797 4.03592L23.3406 11.9875C23.4287 12.0706 23.4992 12.1706 23.548 12.2814C23.5969 12.3922 23.6231 12.5117 23.625 12.6328V23.625H16.625Z" />
                                <path
                                  d="M23.625 23.625V12.6328C23.623 12.5117 23.5969 12.3922 23.548 12.2814C23.4992 12.1706 23.4287 12.0706 23.3406 11.9875L14.5797 4.03592C14.4202 3.88911 14.2113 3.80762 13.9945 3.80762C13.7777 3.80762 13.5689 3.88911 13.4094 4.03592L4.65937 11.9875C4.56926 12.069 4.49736 12.1686 4.44836 12.2798C4.39936 12.391 4.37436 12.5113 4.375 12.6328V23.625M1.75 23.625H26.25M16.625 23.625V17.5C16.625 17.2679 16.5328 17.0454 16.3687 16.8813C16.2046 16.7172 15.9821 16.625 15.75 16.625H12.25C12.0179 16.625 11.7954 16.7172 11.6313 16.8813C11.4672 17.0454 11.375 17.2679 11.375 17.5V23.625"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round" />
                              </svg>
                              <span class="custom-option-title">Home</span>
                              <small> Delivery time (9am – 9pm) </small>
                            </span>
                            <input
                              name="customRadioIcon"
                              class="form-check-input"
                              type="radio"
                              value=""
                              id="customRadioHome"
                              checked />
                          </label>
                        </div>
                      </div>
                      <div class="col-md mb-md-0 mb-4">
                        <div class="form-check custom-option custom-option-icon">
                          <label class="form-check-label custom-option-content" for="customRadioOffice">
                            <span class="custom-option-body">
                              <svg
                                width="28"
                                height="28"
                                viewBox="0 0 28 28"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                  opacity="0.2"
                                  d="M15.75 23.625V4.375C15.75 4.14294 15.6578 3.92038 15.4937 3.75628C15.3296 3.59219 15.1071 3.5 14.875 3.5H4.375C4.14294 3.5 3.92038 3.59219 3.75628 3.75628C3.59219 3.92038 3.5 4.14294 3.5 4.375V23.625" />
                                <path
                                  d="M1.75 23.625H26.25M15.75 23.625V4.375C15.75 4.14294 15.6578 3.92038 15.4937 3.75628C15.3296 3.59219 15.1071 3.5 14.875 3.5H4.375C4.14294 3.5 3.92038 3.59219 3.75628 3.75628C3.59219 3.92038 3.5 4.14294 3.5 4.375V23.625M24.5 23.625V11.375C24.5 11.1429 24.4078 10.9204 24.2437 10.7563C24.0796 10.5922 23.8571 10.5 23.625 10.5H15.75M7 7.875H10.5M8.75 14.875H12.25M7 19.25H10.5M19.25 19.25H21M19.25 14.875H21"
                                  stroke-opacity="0.9"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round" />
                              </svg>
                              <span class="custom-option-title"> Office </span>
                              <small> Delivery time (9am – 5pm) </small>
                            </span>
                            <input
                              name="customRadioIcon"
                              class="form-check-input"
                              type="radio"
                              value=""
                              id="customRadioOffice" />
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalAddressFirstName">First Name</label>
                    <input
                      type="text"
                      id="modalAddressFirstName"
                      name="modalAddressFirstName"
                      class="form-control"
                      placeholder="John" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalAddressLastName">Last Name</label>
                    <input
                      type="text"
                      id="modalAddressLastName"
                      name="modalAddressLastName"
                      class="form-control"
                      placeholder="Doe" />
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="modalAddressCountry">Country</label>
                    <select
                      id="modalAddressCountry"
                      name="modalAddressCountry"
                      class="select2 form-select"
                      data-allow-clear="true">
                      <option value="">Select</option>
                      <option value="Australia">Australia</option>
                      <option value="Bangladesh">Bangladesh</option>
                      <option value="Belarus">Belarus</option>
                      <option value="Brazil">Brazil</option>
                      <option value="Canada">Canada</option>
                      <option value="China">China</option>
                      <option value="France">France</option>
                      <option value="Germany">Germany</option>
                      <option value="India">India</option>
                      <option value="Indonesia">Indonesia</option>
                      <option value="Italy">Italy</option>
                      <option value="Japan">Japan</option>
                      <option value="Korea">Korea, Republic of</option>
                      <option value="Mexico">Mexico</option>
                      <option value="Philippines">Philippines</option>
                      <option value="Russia">Russian Federation</option>
                      <option value="South Africa">South Africa</option>
                      <option value="Thailand">Thailand</option>
                      <option value="Turkey">Turkey</option>
                      <option value="Ukraine">Ukraine</option>
                      <option value="United Arab Emirates">United Arab Emirates</option>
                      <option value="United Kingdom">United Kingdom</option>
                      <option value="United States">United States</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="modalAddressAddress1">Address Line 1</label>
                    <input
                      type="text"
                      id="modalAddressAddress1"
                      name="modalAddressAddress1"
                      class="form-control"
                      placeholder="12, Business Park" />
                  </div>
                  <div class="col-12">
                    <label class="form-label" for="modalAddressAddress2">Address Line 2</label>
                    <input
                      type="text"
                      id="modalAddressAddress2"
                      name="modalAddressAddress2"
                      class="form-control"
                      placeholder="Mall Road" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalAddressLandmark">Landmark</label>
                    <input
                      type="text"
                      id="modalAddressLandmark"
                      name="modalAddressLandmark"
                      class="form-control"
                      placeholder="Nr. Hard Rock Cafe" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalAddressCity">City</label>
                    <input
                      type="text"
                      id="modalAddressCity"
                      name="modalAddressCity"
                      class="form-control"
                      placeholder="Los Angeles" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalAddressLandmark">State</label>
                    <input
                      type="text"
                      id="modalAddressState"
                      name="modalAddressState"
                      class="form-control"
                      placeholder="California" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="form-label" for="modalAddressZipCode">Zip Code</label>
                    <input
                      type="text"
                      id="modalAddressZipCode"
                      name="modalAddressZipCode"
                      class="form-control"
                      placeholder="99950" />
                  </div>
                  <div class="col-12">
                    <div class="form-check form-switch">
                      <input type="checkbox" class="form-check-input" id="billingAddress" />
                      <label for="billingAddress" class="form-label">Use as a billing address?</label>
                    </div>
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button
                      type="reset"
                      class="btn btn-label-secondary"
                      data-bs-dismiss="modal"
                      aria-label="Close">
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!--/ Add New Address Modal -->
      </div>
      <!-- / Content -->
@endsection
@section('Build-JS')
    
<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../../assets/vendor/libs/popper/popper.js"></script>
<script src="../../assets/vendor/js/bootstrap.js"></script>
<script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/js/menu.js"></script>

@endsection
@section('Vendor-JS')
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection
@section('Page-JS')
    <script src="../../assets/js/app-ecommerce-order-details.js"></script>
    <script src="../../assets/js/modal-edit-user.js"></script>
    <script src="../../assets/js/modal-add-new-address.js"></script>
    <script>
      var cartDetailsURl = "{{route('cartDetailsForOrderId',$order->id)}}";
    </script>
@endsection