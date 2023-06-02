{extends file="layout.tpl"}
{block name='head:title'}homepages{/block}
{block name='body:id'}homepages{/block}
{*block name="stylesheets" append}
    <link rel="stylesheet" href="/{baseadmin}/min/?f=plugins/{$smarty.get.controller}/css/admin.min.css" media="screen" />
{/block*}
{block name='article:header'}
    <h1 class="h2">{#homepages_plugin#}</h1>
{/block}
{block name="article:content"}
    {if {employee_access type="view" class_name=$cClass} eq 1}
    <div class="panels row">
        <section class="panel col-ph-12">
            {if $debug}
                {$debug}
            {/if}
            <header class="panel-header">
                <h2 class="panel-heading h5">{#root_homepages#}</h2>
            </header>
            <div class="panel-body panel-body-form">
                <div class="mc-message-container clearfix">
                    <div class="mc-message"></div>
                </div>
                {include file="form/homepages.tpl"}
            </div>
        </section>
    </div>
    {include file="modal/delete.tpl" data_type='page' title={#modal_delete_title#|ucfirst} info_text=true delete_message={#modal_delete_message#}}
    {include file="modal/error.tpl"}
    {else}
        {include file="section/brick/viewperms.tpl"}
    {/if}
{/block}

{block name="foot" append}
    {capture name="scriptForm"}{strip}
        /{baseadmin}/min/?f=libjs/vendor/jquery-ui-1.12.min.js,
        libjs/vendor/tabcomplete.min.js,
        libjs/vendor/livefilter.min.js,
        libjs/vendor/bootstrap-select.min.js,
        libjs/vendor/filterlist.min.js,
        plugins/homepages/js/admin.min.js
    {/strip}{/capture}
    {script src=$smarty.capture.scriptForm type="javascript"}
    <script type="text/javascript">
        $(function(){
            if (typeof homepages == "undefined")
            {
                console.log("setting is not defined");
            }else{
                var controller = "{$smarty.server.SCRIPT_NAME}?controller={$smarty.get.controller}";
                homepages.run(controller);
            }
        });
    </script>
{/block}