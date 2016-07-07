<!-- Caledario  -->
  <?php
    $diasMes=30;
    $diasVacios=3;
    $arrEventos=array();

    array_push($arrEventos, $arrayName = array('dia' => 14, 'nombre' => 'shinaime'));
    array_push($arrEventos, $arrayName = array('dia' => 14, 'nombre' => 'anime fest'));
    array_push($arrEventos, $arrayName = array('dia' => 16, 'nombre' => 'anime fest del 16'));
    echo "<pre>";print_r($arrEventos);echo "</pre>";

  ?>

  <section id="calendario">
    <div style="
    background: url(/sites/default/files/calendario-anime.png);
    width: 366px;
    height: 523px;
    background-repeat: no-repeat;
    margin: 0 auto;    padding-top: 288px;    padding-left: 6px; position: relative;">
      <?php 
      for ($i=1; $i <= $diasMes; $i++) {?>
	    <article class="infoDia" data-dia="<?=$i?>">
		    <?php
	      	foreach ($arrEventos as $key => $value) {
	      		if ($value["dia"]==$i) {?>
	      			<div>
	      				<?php echo $value["nombre"]?>
	      				<a class="regresar">Regresar al calendario</a>
	      			</div>
	      			<?php
	      		}
	      	}?>
      	</article>
      	<?php
      }
      for ($i=1; $i <= $diasVacios; $i++) {?>
        <article class="itemCalendario"></article>
        <?php
      }
      for ($i=1; $i <= $diasMes; $i++) {?>
        <article class="itemCalendario">
          <?php
          foreach ($arrEventos as $key => $value) {
          	if ($value["dia"]==$i) {?>
          		<figure data-dia="<?php echo $i;?>" class="iconoEvento"></figure>
          		<?php
          	}
          }
          echo $i?>
        </article>
        <?php
        }?>
    </div>
  </section>

  <style>
    .itemCalendario{
        width: 47px;
    height: 43px;
    float: left;
    position: relative;
    font-family: Arial;
    text-align: right;
    line-height: 60px;
    padding-right: 3px;
    font-weight: bold;
    color: #434850;
    }
    .itemCalendario .iconoEvento{
	    width: 35px;
    height: 37px;
    background: url(/sites/default/files/neko.png);
    cursor: pointer;
    position: absolute;
    top: 5px;
    left: 0;
    }
    .infoDia{    background: red;
    display: none;
    position: absolute;
    top: 288px;
    left: 6px;
    height: 227px;
    width: 351px;
    z-index: 1;}

  </style>

  <script>
  	$("#calendario .itemCalendario .iconoEvento").click(function(){
  		$("#calendario .infoDia").hide();
  		$("#calendario .infoDia .regresar").click(function(){
  			$("#calendario .infoDia").hide();

  		});
  		indexDia=$(this).attr("data-dia");
  		$("#calendario .infoDia[data-dia='"+indexDia+"']").fadeIn();
  		console.log(indexDia);

  	});
  </script>
  <!-- Fin calendario -->