@extends('Layouts.users-layout')
@section('title')
    Check Out
@endsection
@section('Plugin-CSS')

@endsection
@section('Main-CSS')

@endsection
@section('content')
<main class="main">
    <div class="page-content">
        <div class="checkout">
            <div class="container">
                <div class="checkout-discount">
                    {{-- <form action="#">
                        <input type="text" class="form-control" required id="checkout-discount-input">
                        <label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
                    </form> --}}
                </div><!-- End .checkout-discount -->
                <form action="">
                    <div class="row">
                        <div class="col-lg-9">
                            <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>First Name *</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Last Name *</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Company Name (Optional)</label>
                                <input type="text" class="form-control" id="companyName" name="companyName">

                                <label>Country *</label>
                                <select id="country" name="country_id" class="form-control">
                                    <option value="">Select Country</option>
                                     @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                     @endforeach 
                                </select>

                                <label>Street address *</label>
                                <input type="text" class="form-control" placeholder="House number and Street name" id="address" name="addess" required>
                                

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>State / County *</label>
                                        <select id="state" name="state_id"  class="form-control" required>
                                            <option value="">Select State</option>                                           
                                        </select>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Town / City *</label>
                                        <select id="city" name="city_id"  class="form-control" required>
                                            <option value="">Select City</option>
                                            
                                        </select>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Postcode / ZIP *</label>
                                        <input type="text" class="form-control" id="postalCode" name="postalCode" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Phone *</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Email address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>

                                {{-- <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-create-acc">
                                    <label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
                                </div><!-- End .custom-checkbox --> --}}

                                {{-- <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-diff-address">
                                    <label class="custom-control-label" for="checkout-diff-address">Ship to a different address?</label>
                                </div><!-- End .custom-checkbox --> --}}

                                <label>Order notes (optional)</label>
                                <textarea class="form-control" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery" id="description" name="description"></textarea>
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->
                                
                                <table class="table table-summary">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    @if(count($products) > 0)
                                    @foreach ($products as $product)
                                    <tbody>
                                        <tr>
                                            <td><a href="">{{$product['name']}} x {{$product['quantity']}}</a></td>
                                            <td class="checkout-price">{{$product['price'] * $product['quantity']}}</td>
                                        </tr>
                                    @endforeach
                                    
                                    @else
                                        <td class="text-center">No Items Selected</td>
                                    @endif
                                        <tr class="summary-subtotal">
                                            <td>Subtotal:</td>
                                            <td class="checkout-subtotal"></td>
                                        </tr><!-- End .summary-subtotal -->
                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td class="checkout-total"></td>
                                        </tr><!-- End .summary-total -->
                                    </tbody>
                                    
                                </table><!-- End .table table-summary -->

                                <div class="accordion-summary" id="accordion-payment">
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h2 class="card-title">
                                                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                                    Direct bank transfer
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->

                                    <div class="card">
                                        <div class="card-header" id="heading-2">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                    Check payments
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. 
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->

                                    <div class="card">
                                        <div class="card-header" id="heading-3">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                    Cash on delivery
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-payment">
                                            <div class="card-body">Quisque volutpat mattis eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. 
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->

                                    <div class="card">
                                        <div class="card-header" id="heading-4">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                                    PayPal <small class="float-right paypal-link">What is PayPal?</small>
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum.
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->

                                    <div class="card">
                                        <div class="card-header" id="heading-5">
                                            <h2 class="card-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                                    Credit Card (Stripe)
                                                    <img src="user-assets/images/payments-summary.png" alt="payments cards">
                                                </a>
                                            </h2>
                                        </div><!-- End .card-header -->
                                        <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-payment">
                                            <div class="card-body"> Donec nec justo eget felis facilisis fermentum.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Lorem ipsum dolor sit ame.
                                            </div><!-- End .card-body -->
                                        </div><!-- End .collapse -->
                                    </div><!-- End .card -->
                                </div><!-- End .accordion -->

                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block" id="submitBillingForm">
                                    <span class="btn-text">Place Order</span>
                                    <span class="btn-hover-text">Proceed to Checkout</span>
                                </button>
                            </div><!-- End .summary -->
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </form>
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection
@section('Plugin-JS')

@endsection
@section('Main-JS')
    <script>
        $(document).ready(function () {
        let subtotal = 0;
    
        // Iterate over each element with the class 'checkout-price'
        $('.checkout-price').each(function () {
          // Parse the text content to a float
          let value = parseFloat($(this).text());
    
          // Check if the parsed value is a valid number
          if (!isNaN(value)) {
            subtotal += value;
          }
        });
    
        // Format the subtotal to two decimal places
        let formattedSubtotal = subtotal.toFixed(2);
    
        // Update the subtotal and total fields
        $('.checkout-subtotal').text(formattedSubtotal);
        $('.checkout-total').text(formattedSubtotal);
      });  
      var getStatesUrl = "{{ route('states-for-countries', ':id' )}}";
      var getCitiesUrl = "{{route('cities-for-states',':id')}}";
      var addBillingInfoUrl = "{{route('add-billing-info')}}";
      const cartProducts = @json($products);
    </script>
    <script>
    $(document).ready(function() {
    $('#country').on('change', function() {
        var countryID = $(this).val();
        console.log('Selected Country ID:', countryID);
        $("#state").html('<option value="">Select State</option>');
        if(countryID){
            $.ajax({
                url: getStatesUrl.replace(':id',countryID),
                type: "GET",
                dataType: 'json',
                success: function(res){
                    $.each(res, function(key, value){
                        $("#state").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        }
    });
  });
  $(document).ready(function() {
  $('#state').on('change', function() {
        var stateID = $(this).val();
        console.log('Selected Country ID:', stateID);
        $("#city").html('<option value="">Select City</option>');
        if(stateID){
            $.ajax({
                url: getCitiesUrl.replace(':id',stateID),
                type: "GET",
                dataType: 'json',
                success: function(res){
                    $.each(res, function(key, value){
                        $("#city").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        }
    });
});
$(document).ready(function(){
    $('#submitBillingForm').on('click', function (e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('first_name', $('#firstName').val());
        formData.append('last_name', $('#lastName').val());
        formData.append('company_name', $('#companyName').val());
        formData.append('country_id', $('#country').val());
        formData.append('address', $('#address').val());
        formData.append('state_id', $('#state').val());
        formData.append('city_id', $('#city').val());
        formData.append('postal_code', $('#postalCode').val());
        formData.append('phone', $('#phone').val());
        formData.append('email', $('#email').val());
        formData.append('description',$('#description').val());

        var cartProducts = @json($products);
        var total = $('.checkout-total').text();

        formData.append('cart', JSON.stringify(cartProducts));
        formData.append('total', total);

        for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
        }
        //console.log(cartProducts , total)
        if(formData){
        $.ajax({
            url :addBillingInfoUrl ,
            type : "POST" , 
            data : formData ,
            processData: false,
            contentType: false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
            },
            success : function(response){
                console.log("Created Successfully")
            },
            error : function(){
                console.log("Error")
            },
            complete : function(){

            }
        });
    }
    });
});
    </script>
@endsection