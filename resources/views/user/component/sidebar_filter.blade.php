<div class="sidebar fl-left">
            <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <div class="secion-detail">
                        <ul class="list-item">
                            @foreach ($product_cat_parents as $item)
                            <li>
                                <a href="{{route('product.cat',['cat_id'=>$item->id,'slug'=>$item->slug])}}" title="">{{$item->name}}</a>
                                <ul class="sub-menu">
                                    @foreach ($item->productCatChild as $cat_child)
                                    <li>
                                        <a href="{{route('product.cat',['cat_id'=>$cat_child->id,'slug'=>$cat_child->slug])}}" title="">{{$cat_child->name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form method="" action="">
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Giá</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input 
                                        @if ($r_price == "duoi-2.000.000")
                                        {{"checked = 'checked'"}}
                                        @endif
                                        type="radio" name="r-price" value="duoi-2.000.000"></td>
                                    <td>Dưới 2.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input 
                                        @if ($r_price == "2.000.000-den-5000.000")
                                        {{"checked = 'checked'"}}
                                        @endif
                                        type="radio" name="r-price" value="2.000.000-den-5000.000"></td>
                                    <td>2.000.000đ - 5.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input 
                                        @if ($r_price == "5000.000-den-8.000.000")
                                        {{"checked = 'checked'"}}
                                        @endif
                                        type="radio" name="r-price" value="5000.000-den-8.000.000"></td>
                                    <td>5.000.000đ - 8.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input 
                                        @if ($r_price == "8.000.000-den-12.000.000")
                                        {{"checked = 'checked'"}}
                                        @endif
                                        type="radio" name="r-price" value="8.000.000-den-12.000.000"></td>
                                    <td>8.000.000đ - 12.000.000đ</td>
                                </tr>
                                <tr>
                                    <td><input 
                                        @if ($r_price == "tren-12.000.000")
                                        {{"checked = 'checked'"}}
                                        @endif
                                        type="radio" name="r-price" value="tren-12.000.000"></td>
                                    <td>Trên 12.000.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <thead>
                                <tr>
                                    <td colspan="2">Hãng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productCatParent->productCatChild as $item)
                                <tr>
                                    <td><input 
                                       @if (is_array($r_brand))
                                      {{in_array($item->id,$r_brand)?'checked':''}}
                                       @endif
                                        type="checkbox" name="r-brand[]" value="{{$item->id}}"
                                        @if ($item->id == $cat_id)
                                            {{"checked = 'checked'"}}
                                        @endif
                                  
                                        ></td>
                                    <td>{{$item->name}}</td>
                                </tr>
                                @endforeach
                              
                               
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-outline-success">Lọc</button>
                    </form>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="?page=detail_product" title="" class="thumb">
                        <img src="{{asset('user/public/images/banner-11.jpg')}}" alt="">
                    </a>
                </div>
            </div>
        </div>