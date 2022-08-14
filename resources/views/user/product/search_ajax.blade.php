@foreach ($search_product as $item)
<div class="media">
    <div class="media-left">
      <a href="{{route('product.detail',['id'=>$item->id,'slug'=>$item->slug])}}">
        <img width="100px" class="media-object" src="{{asset($item->thumbnail)}}" alt="...">
      </a>
    </div>
    <div class="media-body">
        <a href="{{route('product.detail',['id'=>$item->id,'slug'=>$item->slug])}}" title="" class="product-name">{{$item->name}}</a>
        <p class="price">{{number_format($item->price,0,'','.')}}₫</p>
        
    </div>
  </div>
@endforeach
