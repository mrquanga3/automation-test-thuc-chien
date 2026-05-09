{*
TestLink Open Source Project - http://testlink.sourceforge.net/
tcSearchResults.tpl
*}
{$cfg_section = $smarty.template|basename|replace:".tpl":""}
{config_load file="input_dimensions.conf" section=$cfg_section}

{include file="inc_head.tpl" openHead='yes'}
{include file="inc_ext_js.tpl" bResetEXTCss=1}

{foreach from=$gui->tableSet key=idx item=matrix name="initializer"}
  {if $smarty.foreach.initializer.first}
    {$matrix->renderCommonGlobals()}
    {if $matrix instanceof tlExtTable}
        {include file="inc_ext_js.tpl" bResetEXTCss=1}
        {include file="inc_ext_table.tpl"}
    {/if}
  {/if}
  {$matrix->renderHeadSection()}
{/foreach}

{* Admin sidebar (aside.tpl) styles — same stack the dashboard uses *}
<link href="{$dashioHomeURL}lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="{$fontawesomeHomeURL}/css/all.css" rel="stylesheet" />
<link href="{$dashioHomeURL}css/style.css" rel="stylesheet">
<link href="{$dashioHomeURL}css/style-responsive.css" rel="stylesheet">

<style>
  /* Reserve 210px on the left for the admin sidebar (position:fixed).
     #sidebar lacks an explicit `left:0`, so a body padding would shift
     the fixed element along with the content — pad an inner wrapper
     instead. The hamburger toggles `.sidebar-closed` on body, which
     drops the reservation. */
  body.has-admin-sidebar #sidebar { left: 0 !important; }
  body.has-admin-sidebar #frame-content {
    margin-left: 210px;
    transition: margin-left 0.2s;
  }
  body.has-admin-sidebar.sidebar-closed #frame-content {
    margin-left: 0;
  }
</style>

</head>

<body class="has-admin-sidebar">
{include file="aside.tpl"}
<div id="frame-content">
<h1 class="{#TITLE_CLASS#}">{$gui->pageTitle}</h1>

{if $gui->drawSearchGui}
  {include file="tcSearchGUI.inc.tpl"}
{/if}

{if $gui->doSearch}
  <div class="workBack">
  {if $gui->warning_msg == ''}
    {foreach from=$gui->tableSet key=idx item=matrix}
      {$tableID="table_$idx"}
      {$matrix->renderBodySection($tableID)}
    {/foreach}
    <br />
    {lang_get s='generated_by_TestLink_on'} {$smarty.now|date_format:$gsmarty_timestamp_format}
  {else}
    <div class="user_feedback">
    <br />
    {$gui->warning_msg}
    </div>
  {/if}
{/if}
  </div>
</div>

<script src="{$dashioHomeURL}lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="{$dashioHomeURL}lib/jquery.scrollTo.min.js"></script>
<script src="{$dashioHomeURL}lib/jquery.nicescroll.js"></script>
<script src="{$dashioHomeURL}lib/left-bar-scripts.js"></script>
</body>
</html>