@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <form id="payment-form" class="jumbotron row contact_form" action="{{route('checkout.charge')}}" method="POST">
                @csrf
                <div class="col-md-12 form-group">
                    <div class="create_account">
                    <h3 class="mb-3">Paiement</h3>
                    <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                </div>
                <button id="complete-order" type="submit" class="primary-btn my-3">Procéder au paiement</button>
            </form>
            <div class="order-details my-5">
                <h3>Détails de la commande</h3>

                <table class="table table-striped">
                    <tbody>
                        @php
                        $tax = \Cart::session(Auth::user()->id)->getTotal() / 5;
                        $roundedTax = round($tax,2);
                        @endphp
                        @foreach(\Cart::session(Auth::user()->id)->getContent() as $course)
                        <tr>
                            <td><img class="cart-img" src="/storage/courses/{{$course->model->user_id}}/{{$course->model->image}}" /> </td>
                            <td><p><b>{{$course->model->title}}</b></p><p>Par {{$course->model->user->name}}</p></td>
                            <td class="text-right">{{$course->price}} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                  Résumé
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p>Prix d'origine:</p>
                        <p>{{\Cart::getSubTotal()}} €</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p>Taxe:</p>
                        <p>{{$roundedTax}} €</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p><b>Prix total:</b></p>
                        <p><b>{{\Cart::getTotal() + $roundedTax}} €</b></p>
                    </div>
                    <small class="card-text">Comme exigé par la loi, Elearning prélève les taxes sur les transactions applicables aux achats réalisés dans certaines juridictions fiscales.
                    En validant votre achat, vous acceptez ces Conditions générales d'utilisation.</small>
                </div>
              </div>
        </div>
    </div>
</div>

@stop

@section('stripe')

<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_51HX99EGk43TbK34ufEJ1A7BB3pJYiZkccMz15i007cNJOSe1uB6gV5YeRXE1NTBR3jWGvzD3ZAHf9hOPWGC90bzE009VCesZWB');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
        color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createToken(card).then(function(result) {
        if (result.error) {
        // Inform the user if there was an error.
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
        } else {
        // Send the token to your server.
        stripeTokenHandler(result.token);
        }
    });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
    }
</script>

@stop
