
<!-- HTML do slider-->
```
<section id="slider">
		<a href="javascript:;" id="btn_previous"> ≤≤ </a>
		<div class="galeria">
			<?php foreach($lista as $key => $item) : ?>
				<div class="item">
					<img src="/files/thumb/<?php echo $item['Video']['thumb_video']; ?>" /><br />
				</div>
			<?php endforeach; ?>
		</div>
		<a href="javascript:;" id="btn_next"> ≥≥ </a>		
</section>
```
  
  
  
<!-- JS -->
``` Monta visualizacao do Slider e define os gatilhos prev/next:
<script>
  #personalize a quantidade que deve aparecer por vez!
  var qtd_thumb = 5;

  $(document).ready(function() {
	  setup();
  });

  function setup() {
    montaVideoSlide();

    // bind botoes (anterior e proximo)
    $("#btn_next").click(function () { next(); });
    $("#btn_previous").click(function () { previous(); });
  }


  function montaVideoSlide() {

    // esconde todos os itens
    $(".galeria .item").hide();

    // mostra somente quantidade definida
    // if($(".galeria .item").length > qtd_thumb) {
      $(".galeria .item").each( function (count, element) {
        $(this).attr("id", "item_" + count);

        // mostra apenas qtd de thumb definida $qtd_thumb
        if(count < qtd_thumb) {
          $("#item_" + count).show();
        }
      })
    // }
  }

  function previous() {
    if($(".galeria .item").length > qtd_thumb) {
      var previous_item = "#" + $(".galeria .item:visible:first").prev().attr("id");

      if($(previous_item).length) {
        $(".galeria .item:visible:last").hide();
        $(previous_item).fadeIn();
      }
    }
  }

  function next() {
    if($(".galeria .item").length > qtd_thumb) {
      var next_element = "#" + $(".galeria .item:visible:last").next().attr("id");

      if($(next_element).length) {
        $(".galeria .item:visible:first").hide();
        $(next_element).fadeIn();
      }	
    }
  }
</script>
```  
