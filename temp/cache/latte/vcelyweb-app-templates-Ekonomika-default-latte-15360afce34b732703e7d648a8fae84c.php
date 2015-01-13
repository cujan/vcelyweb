<?php
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0970072376', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb7e7ba0025e_content')) { function _lb7e7ba0025e_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><h1>Ekonomika včelára</h1>
celkovy prijem = <?php echo Latte\Runtime\Filters::escapeHtml($celkovyPrijem, ENT_NOQUOTES) ?>

celkovy vydaj = <?php echo Latte\Runtime\Filters::escapeHtml($celkovyVydaj, ENT_NOQUOTES) ?>

saldo = <?php echo Latte\Runtime\Filters::escapeHtml($celkovyPrijem - $celkovyVydaj, ENT_NOQUOTES) ?>

<?php $_l->tmp = $_control->getComponent("polozkaForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;$_l->tmp = $_control->getComponent("grid"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
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
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 