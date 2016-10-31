@if(sizeof($slide_image)>0)
<!-- slide -->
<div class="slider wow fadeInDown animated delay">
  <!-- Slideshow -->
  <div class="callbacks_container" >
    <ul class="rslides" id="slider">
    @foreach($slide_image as $img)  
      <li>
        <img src="{{$img->image}}" alt="">
        <div class="caption">
          <h1>{{$img->title}}</h1>
          <div class="container">
            <span ><?php echo html_entity_decode($img->description)?></span>
            
          </div>
        </div>
      </li>
    @endforeach
      <!-- <li>->description}}
        <img src="lib/slide_update/images/slideshow-image2.jpg" alt="">
        <div class="caption">
          <h1>Welcome</h1>
          <div class="container">
            <span > Civil Construction works. Civil & Structural services are the core competency of ZAC Resources Co.,Ltd. Over the years, our personal have grown from strength th strength and built extensive capabilities for all types of industrial civil and structural requirements. We specialize in Earth Moving, Concrete Works, Steel Structures and Major Civil Construction works. </span>
            
          </div>
        </div>
      </li>
      <li>
        <img src="lib/slide_update/images/slideshow-image3.jpg" alt="">
        <div class="caption">
          <h1>Welcome</h1>
           <div class="container">
            <span > Civil Construction works. Civil & Structural services are the core competency of ZAC Resources Co.,Ltd. Over the years, our personal have grown from strength th strength and built extensive capabilities for all types of industrial civil and structural requirements. We specialize in Earth Moving, Concrete Works, Steel Structures and Major Civil Construction works. </span>
            
          </div>
        </div>
      </li> -->
    </ul>
  </div>
  <div class="clear"></div>
</div>
@endif