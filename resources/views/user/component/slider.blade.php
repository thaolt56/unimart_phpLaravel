<div class="section" id="slider-wp">
    <div class="section-detail">
        @foreach ($sliders as $slider)
        <div class="item">
            <img src="{{asset($slider->slider_path)}}" alt="">
        </div>
        @endforeach
     
    </div>
</div>