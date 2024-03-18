@extends('layouts.app')
@section('content')


<section class="container mx-auto px-6 p-10">

    <div class="container px-4">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
            Create a listing (EUR 99.00)
        </h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('listing.store') }}" method="POST" id="payment_form" class="form-control" enctype="multipart/form-data">
            @csrf

            @guest

            <x-form.input name="email" label="Email" id="email" type="email" required="true" autofocus />
            <x-form.input name="name" label="Name" type="text" id="name" required="true" autofocus />
            <hr />
            <x-form.input name="password" label="Password" type="password" required="true" autofocus />
            <x-form.input name="password_confirmation" label="Confirm Password" type="password" required="true" autofocus />

            @endguest

            <hr />

            <div class="mb-3">
                <label class="form-label">Is Highlighted?</label>
                <p class="form-text">Highlighted listings are shown at the top of the list for (EUR 19.00)</p>
                <div class="form-form-check-inline">
                    <input class="form-check-input" type="radio" name="is_highlighted" id="highlighted_yes" value="1">
                    <label class="form-check-label px-1" for="highlighted_yes">
                        Yes
                    </label>

                    <input class="form-check-input" type="radio" name="is_highlighted" id="highlighted_no" value="0" checked>
                    <label class="form-check-label px-1" for="highlighted_no">
                        No
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input type="text" class="form-control" id="company" name="company" required>
            </div>
            <!-- <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo" required>
            </div> -->
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>

            <div class="mb-3">
                <label for="apply_link" class="form-label">Apply Link</label>
                <input type="text" class="form-control" id="apply_link" name="apply_link" required>
            </div>

            <div class="mb-3" style="height:120px">
                <label for="card-element">
                    Card Details</label>
                <div id="card-element"></div>
            </div>
            <div class="mb-3 mx-2">
                @csrf

                <input type="hidden" id="payment_method_id" name="payment_method_id" value="">
                <button type="submit" id="form_submit" class="btn btn-primary">Pay + Continue</button>
                <style>
                    #card-element {
                        background-color: white;
                        color: black;
                    }
                </style>
            </div>

        </form>
    </div>
</section>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        classes: {
            base: 'form-control'
        },
        style: {
            base: {
                'background-color': 'blue',
                'color': 'black'
            }
        }
    });

    cardElement.mount('#card-element');

    document.getElementById('form_submit').addEventListener('click', async (e) => {
        // prevent the submission of the form immediately
        e.preventDefault();

        const {
            paymentMethod,
            error
        } = await stripe.createPaymentMethod(
            'card', cardElement, {}
        );

        if (error) {
            alert(error.message);
        } else {
            // card is ok, create payment method id and submit form
            document.getElementById('payment_method_id').value = paymentMethod.id;
            document.getElementById('payment_form').submit();
        }
    })
</script>
@endsection