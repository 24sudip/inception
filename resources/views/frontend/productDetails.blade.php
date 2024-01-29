@extends('frontend.frontendMaster')

@section('content')
<!-- product_details - start
================================================== -->
<section class="product_details section_space pb-0">
    <div class="container">
        <div class="row">
            <div class="col col-lg-6">
                <div class="product_details_image">
                    <div class="details_image_carousel">
                        <div class="slider_item">
                            <img src="{{ asset('uploads/product_photo') }}/{{ $products->thumbnail }}" alt="image_not_found">
                        </div>
                        @foreach ($product_gal as $gallery_img)
                        <div class="slider_item">
                            <img src="{{ asset('uploads/product_gallery') }}/{{ $gallery_img->multi_img }}" alt="image_not_found">
                        </div>
                        @endforeach
                    </div>

                    <div class="details_image_carousel_nav">
                        <div class="slider_item">
                            <img src="{{ asset('uploads/product_photo') }}/{{ $products->thumbnail }}" alt="image_not_found">
                        </div>
                        @foreach ($product_gal as $gallery_img)
                        <div class="slider_item">
                            <img src="{{ asset('uploads/product_gallery') }}/{{ $gallery_img->multi_img }}" alt="image_not_found">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <form action="{{ route('cart', $products->id) }}" method="POST">
                    @csrf
                    {{-- <input type="number" value="{{ auth()->id() }}" hidden name="user_id"> --}}
                    <div class="product_details_content">
                        <h2 class="item_title">{{ $products->name }}</h2>
                        <p>{{ $products->description }}</p>
                        <div class="item_review">
                            <ul class="rating_star ul_li">
                                <li><i class="fas fa-star"></i>></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star-half-alt"></i></li>
                            </ul>
                            <span class="review_value">3 Rating(s)</span>
                        </div>

                        <div class="item_price">
                            @if ($products->discount_price)
                            <span>{{ $products->discount_price }}</span>
                            <del>{{ $products->regular_price }}</del>
                            @else
                            <span>{{ $products->regular_price }}</span>
                            @endif

                        </div>
                        <hr>

                        <div class="item_attribute">
                            <div class="row">
                                <div class="col col-md-6">
                                    <div class="select_option clearfix">
                                        <h4 class="input_title">Size *</h4>
                                        <select name="size_id">
                                            <option data-display="- Please select -">Choose A Option</option>
                                            @foreach($inventories as $inventory)
                                            <option value="{{ $inventory->relation_to_size->id }}">{{ $inventory->relation_to_size->size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="select_option clearfix">
                                        <h4 class="input_title">Color *</h4>
                                        <select name="color_id">
                                            <option data-display="- Please select -">Choose A Option</option>
                                            @foreach($inventories as $inventory)
                                            <option value="{{ $inventory->relation_to_color->id }}">{{ $inventory->relation_to_color->color }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="quantity_wrap">
                            <div class="quantity_input">
                                <button type="button" class="input_number_decrement btn_d">
                                    <i class="fal fa-minus"></i>
                                </button>
                                <input class="input_number i_val" type="text" value="1" name="quantity">
                                <button type="button" class="input_number_increment btn_i">
                                    <i class="fal fa-plus"></i>
                                </button>
                            </div>
                            <div class="total_price">Total: <span class="total_amount">
                                @if ($products->discount_price)
                                <span>{{ $products->discount_price }}</span>
                                @else
                                <span>{{ $products->regular_price }}</span>
                                @endif
                                </span>
                            </div>
                        </div>
                        @if (session('cartInsertMsg'))
                        <div class="alert alert-success">{{ session('cartInsertMsg') }}</div>
                        @endif
                        @auth()
                        <ul class="default_btns_group ul_li">
                            <li>
                                <button type="submit" class="btn btn_primary addtocart_btn" href="#!">Add To Cart</button>
                            </li>
                        </ul>
                        @else
                        <ul class="default_btns_group ul_li">
                            <li>
                                <a href="{{ route('accounts') }}" class="btn btn_primary addtocart_btn not_user">Login First</a>
                            </li>
                        </ul>
                        @endauth
                    </div>
                </form>
            </div>
        </div>

        <div class="details_information_tab">
            <ul class="tabs_nav nav ul_li" role=tablist>
                <li>
                    <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button" role="tab" aria-controls="description_tab" aria-selected="true">
                    Description
                    </button>
                </li>
                <li>
                    <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button" role="tab" aria-controls="additional_information_tab" aria-selected="false">
                    Additional information
                    </button>
                </li>
                <li>
                    <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab" aria-controls="reviews_tab" aria-selected="false">
                    Reviews(2)
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla.</p>
                    <p class="mb-0">
                    Pellentesque aliquet, sem eget laoreet ultrices, ipsum metus feugiat sem, quis fermentum turpis eros eget velit. Donec ac tempus ante. Fusce ultricies massa massa. Fusce aliquam, purus eget sagittis vulputate, sapien libero hendrerit est, sed commodo augue nisi non neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat vestibulum, metus nisi posuere nisl, in accumsan elit odio quis mi. Cras neque metus, consequat et blandit et, luctus a nunc. Etiam gravida vehicula tellus, in imperdiet ligula euismod eget.
                    </p>
                </div>

                <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                    <p>{{ $products->additional_information }}</p>

                    <div class="additional_info_list">
                        <h4 class="info_title">Additional Info</h4>
                        <ul class="ul_li_block">
                            <li>No Side Effects</li>
                            <li>Made in USA</li>
                        </ul>
                    </div>

                    <div class="additional_info_list">
                        <h4 class="info_title">Product Features Info</h4>
                        <ul class="ul_li_block">
                            <li>Compatible for indoor and outdoor use</li>
                            <li>Wide polypropylene shell seat for unrivalled comfort</li>
                            <li>Rust-resistant frame</li>
                            <li>Durable UV and weather-resistant construction</li>
                            <li>Shell seat features water draining recess</li>
                            <li>Shell and base are stackable for transport</li>
                            <li>Choice of monochrome finishes and colourways</li>
                            <li>Designed by Nagi</li>
                        </ul>
                    </div>
                </div>

                <div class="tab-pane fade" id="reviews_tab" role="tabpanel">
                    <div class="average_area">
                        <div class="row align-items-center">
                            <div class="col-md-12 order-last">
                                <div class="average_rating_text">
                                    <ul class="rating_star ul_li_center">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                    </ul>
                                    <p class="mb-0">
                                    Average Star Rating: <span>4 out of 5</span> (2 vote)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="customer_reviews">
                        <h4 class="reviews_tab_title">2 reviews for this product</h4>
                        <div class="customer_review_item clearfix">
                            <div class="customer_image">
                                <img src="assets/images/team/team_1.jpg" alt="image_not_found">
                            </div>
                            <div class="customer_content">
                                <div class="customer_info">
                                    <ul class="rating_star ul_li">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                    </ul>
                                    <h4 class="customer_name">Aonathor troet</h4>
                                    <span class="comment_date">JUNE 2, 2021</span>
                                </div>
                                <p class="mb-0">Nice Product, I got one in black. Goes with anything!</p>
                            </div>
                        </div>

                        <div class="customer_review_item clearfix">
                            <div class="customer_image">
                                <img src="assets/images/team/team_2.jpg" alt="image_not_found">
                            </div>
                            <div class="customer_content">
                                <div class="customer_info">
                                    <ul class="rating_star ul_li">
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star"></i></li>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                    </ul>
                                    <h4 class="customer_name">Danial obrain</h4>
                                    <span class="comment_date">JUNE 2, 2021</span>
                                </div>
                                <p class="mb-0">
                                Great product quality, Great Design and Great Service.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="customer_review_form">
                        <h4 class="reviews_tab_title">Add a review</h4>
                        <form action="#">
                            <div class="form_item">
                                <input type="text" name="name" placeholder="Your name*">
                            </div>
                            <div class="form_item">
                                <input type="email" name="email" placeholder="Your Email*">
                            </div>
                            <div class="your_ratings">
                                <h5>Your Ratings:</h5>
                                <button type="button"><i class="fal fa-star"></i></button>
                                <button type="button"><i class="fal fa-star"></i></button>
                                <button type="button"><i class="fal fa-star"></i></button>
                                <button type="button"><i class="fal fa-star"></i></button>
                                <button type="button"><i class="fal fa-star"></i></button>
                            </div>
                            <div class="form_item">
                                <textarea name="comment" placeholder="Your Review*"></textarea>
                            </div>
                            <button type="submit" class="btn btn_primary">Submit Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product_details - end
================================================== -->

<!-- related_products_section - start
================================================== -->
<section class="related_products_section section_space">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="best-selling-products related-product-area">
                    <div class="sec-title-link">
                        <h3>Related products</h3>
                        <div class="view-all"><a href="#">View all<i class="fal fa-long-arrow-right"></i></a></div>
                    </div>
                    <div class="product-area clearfix">
                        @forelse ($related_products as $related_product)
                        @include('frontend.components.products.grid')
                        @empty
                        <p>No Related Product Available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let inputEl = document.querySelector(".i_val");
    let btn_i = document.querySelector(".btn_i");
    let btn_d = document.querySelector(".btn_d");

    let total_amount = document.querySelector(".total_amount");
    let main_total = total_amount.children[0].innerText;

    inputEl.addEventListener("input", function (e) {
        if (!Number.isNaN(parseInt(e.target.value))) {
            total_amount.children[0].innerText = parseInt(e.target.value) * main_total;
        } else {
            total_amount.children[0].innerText = "wrong quantity";
        }
    });

    btn_i.addEventListener("click", () => {
        let main_value = inputEl.value;
        main_value++;
        total_amount.children[0].innerText = main_value * main_total;
    });

    btn_d.addEventListener("click", () => {
        if (inputEl.value > 1) {
            let main_value = inputEl.value;
            main_value--;
            total_amount.children[0].innerText = main_value * main_total;
        } else {
            inputEl.value = 1;
            total_amount.children[0].innerText = "0";
        }
    });
</script>
<!-- related_products_section - end
================================================== -->
@endsection

@section('footer_script')
<script>
    let not_user = document.querySelector(".not_user");
    not_user.addEventListener("click", () => {
        const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: "Are you Our Customer?",
      text: "If You want to be our premium customer then please login",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "<a href="{{ route('accounts') }}">LOGIN</a>",
      cancelButtonText: "No, then Register First",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        swalWithBootstrapButtons.fire({
          title: "Wait!",
          text: "Redirecting",
          icon: "success"
        });
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire({
          title: "Not Here",
          text: "Please Go to Home Page :)",
          icon: "error"
        });
      }
    });
    });
</script>
@endsection
