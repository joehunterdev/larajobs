<section class="container mx-auto px-6 p-10 my-4">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to our website!</h1>
        <p class="lead">Discover amazing products and services.</p>
        <a href="#" class="btn btn-primary btn-lg">Get Started</a>
    </div>

    <div class="w-50 mx-auto my-2"> <!-- Adjust the width as per your requirement -->
        <form action="/search" method="GET" class="mt-4">
            <div class="input-group">
                <input type="text" name="s" value="{{ request()->get('s') }}" placeholder="Search..." class="form-control">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <p class="text-muted mt-2">Windows, Marbella and Cleaning</p>
    </div>

</section>