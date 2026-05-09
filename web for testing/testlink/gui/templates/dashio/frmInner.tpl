{* TestLink Open Source Project - http://testlink.sourceforge.net/ *}
{* @filesource frmInner.tpl *}
{* Purpose: smarty template - inner frame for workarea *}
<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset={$pageCharset}" />
    	<meta http-equiv="Content-language" content="en" />
    	<meta http-equiv="expires" content="-1" />
    	<meta http-equiv="pragma" content="no-cache" />
    	<meta name="generator" content="testlink" />
    	<meta name="author" content="Martin Havlat" />
    	<meta name="copyright" content="GNU" />
    	<meta name="robots" content="NOFOLLOW" />
    	<base href="{$basehref}" />
    	<title>TestLink Inner Frame</title>
    	<style media="all" type="text/css">@import "{$css}";</style>
    	<link rel="stylesheet" type="text/css" href="{$basehref}gui/themes/default/css/frame.css">

    	{* Admin sidebar (aside.tpl) styles — same stack the dashboard uses *}
    	<link href="{$dashioHomeURL}lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    	<link href="{$fontawesomeHomeURL}/css/all.css" rel="stylesheet" />
    	<link href="{$dashioHomeURL}css/style.css" rel="stylesheet">
    	<link href="{$dashioHomeURL}css/style-responsive.css" rel="stylesheet">

    	<style>
    	  /* Admin sidebar is position:fixed (210px wide), pinned to the
    	     left edge of the iframe viewport. We can't use body padding —
    	     #sidebar has no explicit `left:0`, so padding shifts the fixed
    	     element along with the iframes. Instead, wrap the iframes in
    	     a container that's pushed 210px right; the iframes keep their
    	     percentage widths (29% / 71%) inside the smaller container. */
    	  body.has-admin-sidebar #sidebar { left: 0 !important; }
    	  body.has-admin-sidebar #frame-content {
    	    margin-left: 210px;
    	    height: 100%;
    	    transition: margin-left 0.2s;
    	  }
    	  body.has-admin-sidebar.sidebar-closed #frame-content {
    	    margin-left: 0;
    	  }
    	  #frame-content {
    	    position: relative;
    	  }
    	  .iframe-loading-overlay {
    	    align-items: center;
    	    background: rgba(255, 255, 255, 0.72);
    	    color: #2f4050;
    	    display: none;
    	    flex-direction: column;
    	    gap: 10px;
    	    justify-content: center;
    	    position: absolute;
    	    z-index: 50;
    	  }
    	  .iframe-loading-overlay.is-visible {
    	    display: flex;
    	  }
    	  .workframe-loading-spinner {
    	    animation: workframe-loading-spin 0.8s linear infinite;
    	    border: 4px solid rgba(47, 64, 80, 0.18);
    	    border-radius: 50%;
    	    border-top-color: #2f80ed;
    	    height: 42px;
    	    width: 42px;
    	  }
    	  .workframe-loading-text {
    	    font-size: 13px;
    	    font-weight: 600;
    	    letter-spacing: 0.02em;
    	  }
    	  @keyframes workframe-loading-spin {
    	    to {
    	      transform: rotate(360deg);
    	    }
    	  }
    	</style>

    	<script type="text/javascript" src="{$basehref}third_party/jquery/jquery-3.4.1.min.js"></script>
    	<script type="text/javascript" src="{$basehref}third_party/chosen/chosen.jquery.js"></script>

    	{include file="bootstrap.inc.tpl"}
    </head>
    <body class="has-admin-sidebar">
      {include file="aside.tpl"}
      <div id="frame-content">
        <iframe src="{$treeframe}" name="treeframe" class="treeframe"></iframe>
        <iframe src="{$workframe}" id="workframe" name="workframe" class="workframe"></iframe>
      </div>

      <script src="{$dashioHomeURL}lib/jquery.dcjqaccordion.2.7.js"></script>
      <script src="{$dashioHomeURL}lib/jquery.scrollTo.min.js"></script>
      <script src="{$dashioHomeURL}lib/jquery.nicescroll.js"></script>
      <script src="{$dashioHomeURL}lib/left-bar-scripts.js"></script>
      <script>
        (function() {
          var activeSpinners = new Map();

          function getSpinnerForIframe(iframe) {
            if (activeSpinners.has(iframe)) return activeSpinners.get(iframe);

            var spinner = document.createElement('div');
            spinner.className = 'iframe-loading-overlay';
            spinner.innerHTML = '<div class="workframe-loading-spinner" aria-hidden="true"></div><div class="workframe-loading-text">Loading...</div>';
            
            if (iframe.parentNode) {
              iframe.parentNode.insertBefore(spinner, iframe.nextSibling);
            }
            activeSpinners.set(iframe, spinner);
            return spinner;
          }

          function updateSpinnerPosition(iframe, spinner) {
            spinner.style.top = iframe.offsetTop + 'px';
            spinner.style.left = iframe.offsetLeft + 'px';
            spinner.style.width = iframe.offsetWidth + 'px';
            spinner.style.height = iframe.offsetHeight + 'px';
          }

          function showSpinner(iframe) {
            var spinner = getSpinnerForIframe(iframe);
            updateSpinnerPosition(iframe, spinner);
            spinner.classList.add('is-visible');
          }

          function hideSpinner(iframe) {
            if (activeSpinners.has(iframe)) {
              activeSpinners.get(iframe).classList.remove('is-visible');
            }
          }

          function setupIframe(iframe) {
            if (iframe.dataset.spinnerSetup) return;
            iframe.dataset.spinnerSetup = 'true';

            iframe.addEventListener('load', function() {
              hideSpinner(iframe);
              try {
                iframe.contentWindow.addEventListener('unload', function() {
                  showSpinner(iframe);
                });
              } catch(e) {}
            });
            
            showSpinner(iframe);
          }

          var iframes = document.getElementsByTagName('iframe');
          for (var i = 0; i < iframes.length; i++) setupIframe(iframes[i]);

          var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
              mutation.addedNodes.forEach(function(node) {
                if (node.tagName === 'IFRAME') {
                  setupIframe(node);
                } else if (node.querySelectorAll) {
                  var nested = node.querySelectorAll('iframe');
                  for (var j = 0; j < nested.length; j++) setupIframe(nested[j]);
                }
              });
            });
          });
          observer.observe(document.body, { childList: true, subtree: true });

          window.addEventListener('resize', function() {
            activeSpinners.forEach(function(spinner, iframe) {
              if (spinner.classList.contains('is-visible')) {
                updateSpinnerPosition(iframe, spinner);
              }
            });
          });

          window.showWorkframeLoading = function() {
            var wf = document.getElementById('workframe');
            if (wf) showSpinner(wf);
          };
          window.hideWorkframeLoading = function() {
            var wf = document.getElementById('workframe');
            if (wf) hideSpinner(wf);
          };
        })();
      </script>
    </body>
</html>
