    <!-- Start footer -->
    <div class="footer">
        <div class="useful">
          <h4>روابط مفيدة</h4>
          <ul>
            <li><a href="#">الأكثر مبيعا في إنارات</a></li>
            <li><a href="#">ترشيحات إنارات</a></li>
            <li><a href="#">أحدث المنتجات</a></li>
          </ul>
        </div>
        <div class="quick">
          <h4>روابط سريعة</h4>
          <ul>
            <li><a href="3">الرئيسية</a></li>
            <li><a href="#">عن إنارات</a></li>
            <li><a href="#">المقالات</a></li>
            <li><a href="#">سياسة إنارات</a></li>
          </ul>
        </div>
  
        <div class="about">
          <h2>سيتى لايت</h2>
          <p>
            سيتى لايت أكبر متجر إلكتروني متخصص في بيع وحدات الإضاءة والديكور في
            السعوديه. يمكنك أن تجد وتطلب كل احتياجاتك من وحدات الإضاءة والديكور في
            مكان واحد في أي وقت ومن أي مكان مع التوصيل لأي مكان في مصر
          </p>
        </div>
      </div>
      <!-- End footer -->
      <script type="text/javascript" src="{{static_asset('asset/js/jquery-3.3.1.min.js')}}"></script>
      {{--<script type="text/javascript" src="{{static_asset('asset/js/bootstrap.min.js')}}"></script>--}}
      <script type="text/javascript" src="{{static_asset('asset/js/jquery.flexslider-min.js')}}"></script>
      <script type="text/javascript" src="{{static_asset('asset/js/owl.carousel.js')}}"></script>
      <script type="text/javascript" src="{{static_asset('asset/js/custom.js')}}"></script>
      
      {{--<script src=" {{asset('assets')}}/js/vendors.js"></script>--}}
      {{--<script src="{{asset('assets')}}/js/aiz-core.js"></script>--}}
      {{--<script src="{{asset('assets')}}/js/aiz-core.js"></script>--}}
      
      <script src="{{static_asset('assets/js/vendors.js')}}"></script>
      <script src="{{static_asset('assets/js/aiz-core.js')}}"></script>
      
      
      
      
      <script>
          @foreach (session('flash_notification', collect())->toArray() as $message)
          AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
          @endforeach
      </script>
      
      
      
      <script>
      
          if ($('#lang-change').length > 0) {
              $('#lang-change .dropdown-menu a').each(function() {
                  $(this).on('click', function(e){
                      e.preventDefault();
                      var $this = $(this);
                      var locale = $this.data('flag');
                      console.log(locale);
                      $.get('{{ route('language.change') }}',{_token: AIZ.data.csrf, locale:locale}, function(data){
                          location.reload();
                      });
      
                  });
              });
          }
      
          function show_purchase_history_details(order_id)
          {
              $('#order-details-modal-body').html(null);
      
              if(!$('#modal-size').hasClass('modal-lg')){
                  $('#modal-size').addClass('modal-lg');
              }
      
              $.post('{{ route('purchase_history.details') }}', { _token : AIZ.data.csrf, order_id : order_id}, function(data){
      
                  $('#order-details-modal-body').html(data);
                  $('#order_details').modal();
                  $('.c-preloader').hide();
              });
          }
      
      </script>
      
      <script>
      
      
          function showAddToCartModal(id){
              if(!$('#modal-size').hasClass('modal-lg')){
                  $('#modal-size').addClass('modal-lg');
              }
              $('#addToCart-modal-body').html(null);
              $('#addToCart').modal();
              $('.c-preloader').show();
              $.post('{{ route('cart.showCartModal') }}', {_token: AIZ.data.csrf, id:id}, function(data){
                  $('.c-preloader').hide();
                  $('#addToCart-modal-body').html(data);
                  AIZ.plugins.slickCarousel();
                  AIZ.plugins.zoom();
                  AIZ.extra.plusMinus();
                  getVariantPrice();
              });
          }
      
          function checkAddToCartValidity(){
              var names = {};
              $('#option-choice-form input:radio').each(function() { // find unique names
                  names[$(this).attr('name')] = true;
              });
              var count = 0;
              $.each(names, function() { // then count them
                  count++;
              });
      
              if($('#option-choice-form input:radio:checked').length == count){
                  return true;
              }
      
              return false;
          }
      
          function getVariantPrice(){
              if($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()){
                  $.ajax({
                      type:"POST",
                      url: '{{ route('products.variant_price') }}',
                      data: $('#option-choice-form').serializeArray(),
                      success: function(data){
      
                          $('.product-gallery-thumb .carousel-box').each(function (i) {
                              if($(this).data('variation') && data.variation == $(this).data('variation')){
                                  $('.product-gallery-thumb').slick('slickGoTo', i);
                              }
                          })
      
                          $('#option-choice-form #chosen_price_div').removeClass('d-none');
                          $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                          $('#available-quantity').html(data.quantity);
                          $('.input-number').prop('max', data.max_limit);
                          if(parseInt(data.in_stock) == 0 && data.digital  == 0){
                              $('.buy-now').addClass('d-none');
                              $('.add-to-cart').addClass('d-none');
                              $('.out-of-stock').removeClass('d-none');
                          }
                          else{
                              $('.buy-now').removeClass('d-none');
                              $('.add-to-cart').removeClass('d-none');
                              $('.out-of-stock').addClass('d-none');
                          }
                      }
                  });
              }
          }
      
          function addToCart(){
      
              if(checkAddToCartValidity()) {
                  $('#addToCart').modal();
                  $('.c-preloader').show();
                  $.ajax({
                      type:"POST",
                      url: '{{ route('cart.addToCart') }}',
                      data: $('#option-choice-form').serializeArray(),
                      success: function(data){
      
                          $('#addToCart-modal-body').html(null);
                          $('.c-preloader').hide();
                          $('#modal-size').removeClass('modal-lg');
                          $('#addToCart-modal-body').html(data.modal_view);
                          AIZ.extra.plusMinus();
                          updateNavCart(data.nav_cart_view,data.cart_count);
                      }
                  });
              }
              else{
                  AIZ.plugins.notify('warning', "{{ __('front.please choose all the options') }}");
              }
          }
      
          function updateNavCart(view,count){
              $('.cart-count').html(count);
              $('#cart_items').html(view);
          }
      
          function buyNow(){
              if(checkAddToCartValidity()) {
                  $('#addToCart-modal-body').html(null);
                  $('#addToCart').modal();
                  $('.c-preloader').show();
                  $.ajax({
                      type:"POST",
                      url: '{{ route('cart.addToCart') }}',
                      data: $('#option-choice-form').serializeArray(),
                      success: function(data){
                          if(data.status == 1){
      
                              $('#addToCart-modal-body').html(data.modal_view);
                              updateNavCart(data.nav_cart_view,data.cart_count);
      
                              window.location.replace("{{ route('cart') }}");
                          }
                          else{
                              $('#addToCart-modal-body').html(null);
                              $('.c-preloader').hide();
                              $('#modal-size').removeClass('modal-lg');
                              $('#addToCart-modal-body').html(data.modal_view);
                          }
                      }
                  });
              }
              else{
                  AIZ.plugins.notify('warning', "{{ __('front.please choose all the options') }}");
              }
          }
      
          function removeFromCart(key){
              $.post('{{ route('cart.removeFromCart') }}', {
                  _token  : AIZ.data.csrf,
                  id      :  key
              }, function(data){
                  updateNavCart(data.nav_cart_view,data.cart_count);
                  $('#cart-summary').html(data.cart_view);
                  AIZ.plugins.notify('success', "{{ __('front.item has been removed from cart') }}");
                  $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html())-1);
              });
          }
      
      
          $('#search').on('keyup', function(){
              search();
          });
      
          $('#search').on('focus', function(){
              search();
          });
      
          function search(){
              var searchKey = $('#search').val();
              if(searchKey.length > 0){
                  $('body').addClass("typed-search-box-shown");
      
                  $('.typed-search-box').removeClass('d-none');
                  $('.search-preloader').removeClass('d-none');
                  $.post('{{ route('search.ajax') }}', { _token: AIZ.data.csrf, search:searchKey}, function(data){
                      if(data == '0'){
                          // $('.typed-search-box').addClass('d-none');
                          $('#search-content').html(null);
                          $('.typed-search-box .search-nothing').removeClass('d-none').html('{{__('front.sorry, nothing found for')}}  <strong>"'+searchKey+'"</strong>');
                          $('.search-preloader').addClass('d-none');
      
                      }
                      else{
                          $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                          $('#search-content').html(data);
                          $('.search-preloader').addClass('d-none');
                      }
                  });
              }
              else {
                  $('.typed-search-box').addClass('d-none');
                  $('body').removeClass("typed-search-box-shown");
              }
          }
      
      </script>
      
      
      
      
      @yield('script')