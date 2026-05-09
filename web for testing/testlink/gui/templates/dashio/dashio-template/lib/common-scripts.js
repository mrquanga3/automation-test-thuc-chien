/*---LEFT BAR ACCORDION----*/
$(function() {
  // Guard against missing plugin (loaded via separate <script> tag)
  if (typeof $.fn.dcAccordion === 'function') {
    $('#nav-accordion').dcAccordion({
      eventType: 'click',
      autoClose: true,
      saveState: true,
      disableLink: true,
      speed: 'slow',
      showCount: false,
      autoExpand: true,
      //        cookie: 'dcjq-accordion-1',
      classExpand: 'dcjq-current-parent'
    });
  }
});

var Script = function() {


  //    sidebar dropdown menu auto scrolling
  jQuery('#sidebar .sub-menu > a').click(function() {
    var o = ($(this).offset());
    diff = 250 - o.top;
    if (diff > 0)
      $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
    else
      $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
  });



  //    sidebar toggle
  $(function() {
    function responsiveView() {
      var wSize = $(window).width();
      if (wSize <= 768) {
        $('#container').addClass('sidebar-close');
        $('#sidebar > ul').hide();
      }

      if (wSize > 768) {
        $('#container').removeClass('sidebar-close');
        $('#sidebar > ul').show();
      }
    }
    $(window).on('load', responsiveView);
    $(window).on('resize', responsiveView);
  });

  /**
   *
   */
  $('.fa-bars').click(function() {
    // Find every document that may contain #sidebar — in TestLink the
    // sidebar can live in main.tpl (current doc), parent main.tpl, or
    // mainframe (parent.frames[1] when navBar lives in titlebar iframe).
    // We hit ALL candidates so the toggle works regardless of where the
    // hamburger ended up rendering.
    var candidates = [];
    candidates.push(document);
    if (window.parent && window.parent !== window) {
      try { candidates.push(window.parent.document); } catch(e) {}
      try {
        for (var i = 0; i < window.parent.frames.length; i++) {
          try { candidates.push(window.parent.frames[i].document); } catch(e) {}
        }
      } catch(e) {}
    }

    var toggledAny = false;
    candidates.forEach(function(doc) {
      try {
        var sidebar = doc.getElementById('sidebar');
        if (!sidebar) { return; }

        var sidebarUL  = doc.getElementById('nav-accordion');
        var mainContent = doc.getElementById('main-content');
        var container  = doc.getElementById('container');
        var body       = doc.body;

        // Determine visibility from inline style or body class so it
        // works whether or not #container exists in the layout.
        var hidden = (sidebar.style.marginLeft === '-210px') ||
                     (body && body.classList.contains('sidebar-closed'));

        if (!hidden) {
          // Hide
          sidebar.style.marginLeft = '-210px';
          if (sidebarUL)  sidebarUL.style.display = 'none';
          if (mainContent) mainContent.style.marginLeft = '0px';
          if (container)  container.classList.add('sidebar-closed');
          if (body)       body.classList.add('sidebar-closed');
        } else {
          // Show
          sidebar.style.marginLeft = '0';
          if (sidebarUL)  sidebarUL.style.display = '';
          if (mainContent) mainContent.style.marginLeft = '210px';
          if (container)  container.classList.remove('sidebar-closed');
          if (body)       body.classList.remove('sidebar-closed');
        }
        toggledAny = true;
      } catch(e) { /* cross-origin or transient frame, skip */ }
    });

    // Fallback: pages like Execute Test render frmInner.tpl which has
    // no #sidebar — instead it has a treeframe (filter panel) and a
    // workframe side-by-side. Toggle the treeframe so the workframe
    // can use the full width.
    if (!toggledAny) {
      candidates.forEach(function(doc) {
        try {
          var tree = doc.getElementsByName('treeframe')[0]
                  || doc.querySelector('iframe.treeframe');
          var work = doc.getElementsByName('workframe')[0]
                  || doc.querySelector('iframe.workframe');
          if (!tree || !work) { return; }

          var hidden = tree.style.display === 'none';
          if (!hidden) {
            tree.dataset.tlPrevDisplay = tree.style.display || '';
            work.dataset.tlPrevWidth   = work.style.width   || '';
            tree.style.display = 'none';
            work.style.width   = '100%';
          } else {
            tree.style.display = tree.dataset.tlPrevDisplay || '';
            work.style.width   = work.dataset.tlPrevWidth   || '';
          }
          toggledAny = true;
        } catch(e) {}
      });
    }

    if (!toggledAny && window.console) {
      console.warn('TestLink toggle: no #sidebar or treeframe/workframe found in any reachable document');
    }
  });

  // custom scrollbar
  $("#sidebar").niceScroll({
    styler: "fb",
    cursorcolor: "#4ECDC4",
    cursorwidth: '3',
    cursorborderradius: '10px',
    background: '#404040',
    spacebarenabled: false,
    cursorborder: ''
  });

  //  $("html").niceScroll({styler:"fb",cursorcolor:"#4ECDC4", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

  // widget tools

  jQuery('.panel .tools .fa-chevron-down').click(function() {
    var el = jQuery(this).parents(".panel").children(".panel-body");
    if (jQuery(this).hasClass("fa-chevron-down")) {
      jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
      el.slideUp(200);
    } else {
      jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
      el.slideDown(200);
    }
  });

  jQuery('.panel .tools .fa-times').click(function() {
    jQuery(this).parents(".panel").parent().remove();
  });


  //    tool tips

  $('.tooltips').tooltip();

  //    popovers

  $('.popovers').popover();



  // custom bar chart

  if ($(".custom-bar-chart")) {
    $(".bar").each(function() {
      var i = $(this).find(".value").html();
      $(this).find(".value").html("");
      $(this).find(".value").animate({
        height: i
      }, 2000)
    })
  }

}();

jQuery(document).ready(function( $ ) {

  // Go to top
  $('.go-top').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop : 0},500);
  });
});
