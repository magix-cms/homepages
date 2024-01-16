<?php
function smarty_function_homepages_data($params, $smarty){
    $modelTemplate = $smarty->tpl_vars['modelTemplate']->value instanceof frontend_model_template ? $smarty->tpl_vars['modelTemplate']->value : new frontend_model_template();
    //$modelSystem = new frontend_model_core($modelTemplate);
    $collection = new plugins_homepages_public($modelTemplate);
    $modelTemplate->addConfigFile([component_core_system::basePath().'/plugins/homepages/i18n/'], ['public_local_']);
    $modelTemplate->configLoad();
    //$current = $modelSystem->setCurrentId();
    $smarty->assign('hps',$collection->getHomePages());
}