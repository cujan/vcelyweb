<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('7217401318', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbbc69978402_content')) { function _lbbc69978402_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;if ($prijemvydaj) { ?>
	<p>Are you sure that you want to delete ‘<?php echo Latte\Runtime\Filters::escapeHtml($prijemvydaj->popis, ENT_NOQUOTES) ?>
’ by ‘<?php echo Latte\Runtime\Filters::escapeHtml($prijemvydaj->datum, ENT_NOQUOTES) ?>’?</p>
<?php $_l->tmp = $_control->getComponent("deleteForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>

<?php } else { ?>
	<p>Cannot find album.</p>
<?php } 
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIMacros::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 