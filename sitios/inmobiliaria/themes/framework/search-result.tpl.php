<?php

/**
 * @file
 * Displays the search form block.
 *
 * Available variables:
 * - $search_form: The complete search form ready for print.
 * - $search: Associative array of search elements. Can be used to print each
 *   form element separately.
 *
 * Default elements within $search:
 * - $search['search_block_form']: Text input area wrapped in a div.
 * - $search['actions']: Rendered form buttons.
 * - $search['hidden']: Hidden form elements. Used to validate forms when
 *   submitted.
 *
 * Modules can add to the search form, so it is recommended to check for their
 * existence before printing. The default keys will always exist. To check for
 * a module-provided field, use code like this:
 * @code
 *   <?php if (isset($search['extra_field'])): ?>
 *     <div class="extra-field">
 *       <?php print $search['extra_field']; ?>
 *     </div>
 *   <?php endif; ?>
 * @endcode
 *
 * @see template_preprocess_search_block_form()
 */
//print_r($variables);
$result=$variables["result"];
//echo $var=array_keys($result);
//echo "<pre>";print_r($result["node"]);echo "<pre>";
$titulo=$result["node"]->title;
$body=$result["node"]->body["und"][0]["value"];
$body=substr($body, 0, 145);

/*Info empresa*/
    if ($result["node"]->field_empresa) {
        $empresa_id=$result["node"]->field_empresa["und"][0]["tid"];
        if ($empresa_id) {
            $empresa_info=taxonomy_term_load($empresa_id);
            $empresa_img=$empresa_info->field_logo["und"][0]["uri"];
            $src=image_style_url('thumbnail', $empresa_img);
            $empresa_img=$src;
        }
    }

$node_id=$result["node"]->vid;
$link=drupal_get_path_alias('node/'.$node_id);
//$body=substr($value->body["und"][0]["value"], 0, 145);
$img=$result["node"]->field_imagen_principal["und"][0]["filename"];
if ($img!="") {
    $img="http://areacaribe.calipso.com.co/sites/default/files/styles/img-proyectos300x196/public/".$img."?itok=cBK0a1C8";
} else if($img==""){
    //echo "<pre>";print_r($result["node"]->field_foto_principal);echo "</pre>";
    $img=$result["node"]->field_foto_principal["und"][0]["filename"];
    $src=image_style_url('img-proyectos300x196', $img);
    $img=$src;
}?>

<div class="row_result">
    <div class='imagen'><a href='<?=$link?>'>
        <img src="<?=$img?>" style='width: 300px; height: 196px;'></a>
    </div>
    <div class='titulo'><a href='/"<?=$link?>"'><?=$title?></a></div>
    <div class='body'><a href="<?=$link?>"><?=$body?> ... LEER MAS</a></div>
    <?php if ($empresa_img) {?>
        <p class="proyecto-de-empresa">Un proyecto de:</p>
        <div class="views-field-field-logo">
            <p class="field-content">
                <img typeof="foaf:Image" src="<?=$empresa_img?>">
            </p>
        </div>
    <?php }?>
</div>
<?php
//     //Cargar NODO Drupal
//     $query = new EntityFieldQuery();
//     $entities = $query->entityCondition('entity_type', 'node')
//     ->propertyCondition('nid', 41)
//     ->execute();

//     if (!empty($entities['node'])) {
//       $node = node_load(array_shift(array_keys($entities['node'])));
//     }

//     echo "Titulo array<br>";
//     print_r($node);
//     echo "<hr>";
?>

<style>
.row_result{
    display: inline-block;
    margin: 10px 20px 40px;
    text-align: left;
    position: relative;
    font-family: "Dosis",sans-serif;
    width: 300px;
    vertical-align: top;
}
.row_result .titulo{
    color: #0073DC;
    /*padding-left: 15px;*/
    padding-top: 10px;
}
.row_result .body{
    color: #8E8C8C;
    margin-top: 10px;
    background-color: rgba(204, 204, 204, 0.13);
    /*padding: 5px 15px 0px 15px;*/
    padding:0;
    background: transparent linear-gradient(to bottom, #FFF 0%, #F9F6F6 100%) repeat scroll 0% 0%;
    padding-bottom: 20px;
}
.row_result .field-label{display: none;}
.search-results {
    text-align: center;
    list-style: none;
    background: #fff;
    padding: 10px 20px;
    width: 85%;
    margin: 0 auto;
}
fieldset.collapsible{
	display: none;
}
div.section h2{display: none;}
.search-form{text-align: center;}
#main .container-inline.form-wrapper{margin: 20px 0 20px;}

@media(max-width: 768px){
    .row_result .titulo{padding-left:0;margin: 5px 0 0;}
    .row_result .body{padding: 0px 0 0 0px;}

}
</style>