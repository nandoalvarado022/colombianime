<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */

$img=str_replace("<span>", "", $fields["uri"]->content);
$img=str_replace("</span>", "", $img);
$link=str_replace("<span>", "", $fields["path"]->content);
$link=str_replace("</span>", "", $link);

?>

<!-- Wide card with share menu button -->
<div class="demo-card-wide mdl-card mdl-shadow--2dp">
  <div class="mdl-card__title" style="background: url('<?php echo $img?>') center / cover;">
    <h2 class="mdl-card__title-text"><?php print $fields["title"]->content;?></h2>
  </div>
  <div class="mdl-card__supporting-text">
	<?php print $fields["body"]->content;?>
  </div>
  <div class="mdl-card__actions mdl-card--border">
    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php print $link;?>">
      Seguir leyendo
    </a>
  </div>
  <div class="mdl-card__menu">
    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" id="menu-share-<?php echo $fields["nid"] ?>">
      <i class="material-icons">share</i>
    </button>

	<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-share-<?php echo $fields["nid"] ?>">
	  <li class="mdl-menu__item">Facebook</li>
	  <li class="mdl-menu__item">Twitter</li>
	</ul>
  </div>
</div>

<?php // echo "<pre>"; print_r($fields); echo "</pre>";?>
<?php 
/*foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php print $field->content; ?>
  <?php print $field->wrapper_suffix; ?>
<?php endforeach; */?>