<div>
    @if(role_name(Auth::user()->id) != 'Administrator')
    <!-- <span class="badge rounded-pill bg-primary fs-0">Balance : {{total_balance_on_header(Auth::user()->id).' '.currencySign()}}</span> -->
    <div class="btn-group">
        <button class="btn btn-primary btn-sm " type="button">Balance : {{total_balance_on_header(Auth::user()->id).' '.currencySign()}}</button>
        @if(role_name(Auth::user()->id) != 'Employee')
        <button class="btn btn-success btn-sm topup" type="button"><i class="fe fe-plus"></i></button>
        @endif
    </div>


    <!-- modal for top up balance -->

    @if(role_name(Auth::user()->id) != 'Employee')
    <div class="modal" id="topup-modal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px">
            <form action="/api/balance-topup" method="POST" class="modal-content position-relative" id="balance-topup-form">
                <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-light">
                        <h4 class="mb-1" id="modalExampleDemoLabel"> Balance Top Up <span id="balanceReflection"></span> </h4>
                    </div>
                    <div class="p-4 pb-0">
                        @csrf


                        <div id="successcard" class=""></div>

                        <input type="hidden" value="" id="token" name="token">
                        <input type="hidden" value="" id="user_id" name="user_id">

                        <div class="mb-2">
                            <label for="cardholderName">Cardholder's Name:</label>
                            <input type="text" id="cardholderName" name="cardholderName" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="amount">Enter Amount:</label>
                            <input type="text" 
                            name="amount" id="amount" 
                            class="form-control amount" 
                            oninput="this.value = this.value.match(/^\d+(\.\d{0,4})?/)?.[0] || '';" step="0.0001" required />
                        </div>
                        
                        <div class="mb-5">
                            <label for="card-element">Enter Card Information:</label>
                            <div id="card-element" class="border border-1 p-2"></div>
                            <div id="errorcard" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary make-payment" type="submit"> Top Up Now </button>
                </div>
            </form>
        </div>
    </div>
    @endif



    @endif

    @push('js')

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        $(document).on('keyup', '.amount', function(){
            var amountValue = $(this).val();
            $('#balanceReflection').text('€' + amountValue);
        });
    </script>

    <script>
        $(document).on('click', '.topup', function() {
            $('#topup-modal').modal('show');
            $('#amount').val('');
            $('#cardholderName').val('');
            $('#successcard').val('');
            $('#user_id').val('{{Auth::user()->id}}');
            
            var style = {
                base: {
                    color: '#32325d', // Text color
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif', // Font
                    fontSmoothing: 'antialiased', // Smooth font rendering
                    fontSize: '16px', // Font size
                    '::placeholder': {
                    color: '#aab7c4', // Placeholder text color
                    }
                },
                invalid: {
                    color: '#fa755a', // Color for invalid card details
                    iconColor: '#fa755a' // Color for the error icon
                }
            };

            var stripe   = Stripe("{{ \App\Models\Stripething::first() ? \App\Models\Stripething::first()->public_key : '' }}");
            var elements = stripe.elements();
            var card     = elements.create('card', { style: style });
            card.mount('#card-element');

            var form = document.getElementById('balance-topup-form');
            form.addEventListener('submit', function(e){
                
                e.preventDefault();

                $('.make-payment').attr('disabled', 'disabled').text('Processing...');

                stripe.createToken(card).then(function(result){
                    if (result.error) {
                        let errorcard = document.getElementById('errorcard');
                        errorcard.textContent = result.error.message;
                        $('.make-payment').removeAttr('disabled').text('Top Up Now');
                    } else {

                        $('#successcard').addClass('alert alert-success').text('Balance Top-Up is in Review.');
                        let token = document.getElementById('token');
                        token.value = result.token.id;
                        form.submit();
                    }
                })
            })
        });
    </script>
    @endpush
</div>