@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Favourite
@endsection


@section('frontend_content')

    <style>
        .big-hr {
            width: 100% !important;
        }

    </style>

    <section id="cart-home " class="mt-5 pt-5 container">
        <h2 class="font-weight-bold ">Favourite</h2>
        <hr>
    </section>


    <section class="cart container py-5 mb-5">

        @if ($wishlist->count() > 0)
            <table width="100%">
                <thead>
                    <tr>
                        <td>Product</td>
                        <td>Image</td>
                        <td>Price</td>
                        <td>Product Details</td>
                        <td>Remove</td>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($wishlist as $row)
                        @php $item = $row->product ?? $row->businessProduct; @endphp
                        <tr>
                            <td>
                                <p class="font-weight-bold">{{ optional($item)->product_name ?? 'Unknown Product' }}</p>
                            </td>

                            <td>
                                @if ($row->product)
                                    <img class="img-fluid" src="{{ asset('img_DB/product/image_one/' . $item->image_one) }}" alt="">
                                @elseif ($row->businessProduct)
                                    <img class="img-fluid" src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}" alt="">
                                @else
                                    <span>N/A</span>
                                @endif
                            </td>

                            <td>
                                <p><small> {{ optional($item)->price ?? '0' }} TK</small></p>
                            </td>

                            <td>
                                @if ($row->product)
                                    <a class="btn btn-success btn-sm" href="{{ url('product_details/' . $item->id) }}" role="button">Product Details</a>
                                @else
                                    <a class="btn btn-success btn-sm" href="{{ url('business_product_details/' . $item->id) }}" role="button">Product Details</a>
                                @endif
                            </td>

                            <td><a href="{{ url('wishlist_destroy/' . $row->id) }}"><i class="fas fa-trash"></i></a></td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        @else
            <div class="card p-5 text-white" style="background: green">
                <h2 class="text-center ">Wishlist Not Available</h2>
                <a class="btn float-end" style="background: green; color:#fff" href="{{ url('shop') }}"
                    role="button">Continue
                    to Shopping</a>
            </div>
        @endif
    </section>



@endsection
