<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-danger">
        <h2>{{ __('front.oops..') }}</h2>
        <h3>{{ __('front.You have to add minimum ' . $min_qty . ' products!') }}</h3>
    </div>
    <div class="text-center mt-5">
        <button class="btn btn-outline-primary" data-dismiss="modal">{{ __('front.Back to shopping') }}</button>
    </div>
</div>
