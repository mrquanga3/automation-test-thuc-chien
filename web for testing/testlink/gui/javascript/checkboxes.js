// TestLink Open Source Project - http://testlink.sourceforge.net/ 
// $Id: checkboxes.js,v 1.12 2010/08/10 21:55:39 erikeloff Exp $ 
//
//
// rev :
//      20100209 - francisco- BUGID 0003150: "Bulk user assignment" on "Assign testcase execution" doesn't work anymore
//

/*
  function: 
           Takes a div tag and whether or not you want the checkboxes checked or not
           Then goes through all of the elements of the div tag that is passed in 
           and if they are checkboxes.
           used in planAddTC.php script

  args :
  
  returns: 

*/
function box(myDiv, checkBoxStatus)
{
	var frm = document.getElementById(myDiv).getElementsByTagName('input');
	for(var idx = 0; idx < frm.length; idx++)
	{
		var elemType = frm[idx].type;		
		
		if(elemType == "checkbox")
		{
			frm[idx].checked = checkBoxStatus;
		}	
	}
}

// next two functions allows to check and uncheck all checkboxes in form
// are used in planUpdateTC.php
/*
  function: 

  args :
  
  returns: 

*/
function checkAll(ml)
{
	checkOrUncheckAll(ml,true)	
}

/*
  function: 

  args :
  
  returns: 

*/
function uncheckAll(ml)
{
	checkOrUncheckAll(ml,false)	
}

/*
  function: 

  args :
  
  returns: 

*/
function checkOrUncheckAll(ml,bCheck)
{
	// var ml = document.myform;
	var my_form=document.getElementById(ml);
	
	// alert(ml);
	// alert(my_form);
	
	var len = my_form.elements.length;
	
	for (var idx = 0; idx < len; idx++)
	{
		var e = my_form.elements[idx];
		if (e.type == "checkbox")
		{
			e.checked = bCheck;
		}	
	}
}

/*
  function: checkbox_count_checked 
            given a container id, will return how many checkboxes are checked.
            
  args : container_id
  
  returns: number

  rev :
        20070102 - franciscom
*/
function checkbox_count_checked(container_id)
{
  var container=document.getElementById(container_id);
	var all_inputs = container.getElementsByTagName('input');
	var input_element;
	var count_checked=0;

	for(var idx = 0; idx < all_inputs.length; idx++)
	{
	  input_element=all_inputs[idx];		
		if(input_element.type == "checkbox" &&  
		   input_element.checked  &&
		   !input_element.disabled)
		{
			count_checked++;
		}	
	}
  return(count_checked);
}



/*
  function: set_combo_if_checkbox

  args : oid
  
  returns: 

  rev :
        20070118 - franciscom
*/
function set_combo_if_checkbox(oid,combo_id_prefix,value_to_assign)
{
  var f=document.getElementById(oid);
	var all_inputs = f.getElementsByTagName('input');
	var input_element;
	var check_id='';
	var apieces='';
	var combo_id_suffix='';
	var cb_id= new Array();
	var jdx=0;
	var idx=0;
		
	// Build an array with the html select ids
	//	
	for(idx = 0; idx < all_inputs.length; idx++)
	{
	  input_element=all_inputs[idx];		
		if(input_element.type == "checkbox" &&  
		   input_element.checked  &&
		   !input_element.disabled)
		{
      check_id=input_element.id;
      
      // Consider the id a list with '_' as element separator
      apieces=check_id.split("_");
      
      // BUGID 0003150: "Bulk user assignment" on "Assign testcase execution" doesn't work anymore
      // 20100209 - needed due to platform features
      // apieces.length-2 => test case id
      // apieces.length-1 => platform id
      //
      combo_id_suffix=apieces[apieces.length-2] + '_' + apieces[apieces.length-1];
      cb_id[jdx]=combo_id_prefix + combo_id_suffix;
      jdx++;
		}	
	}
	
	// now set the combos
	for(idx = 0; idx < cb_id.length; idx++)
	{
	   //debug - alert(cb_id[idx] + " will be" + value_to_assign);
	   input_element=document.getElementById(cb_id[idx]);
	   input_element.value=value_to_assign;
	}
}

/*
  function: set_checkbox 

  args : oid
         value_to_assign
  
  returns: 

  rev :
        20070118 - franciscom
*/
function set_checkbox(oid,value_to_assign)
{
  var cb=document.getElementById(oid);
	cb.checked=value_to_assign;
}


/*
  function: checkbox_get_checked 

  args : oid
  
  returns: 

  rev :
        20070118 - franciscom
*/
function checkbox_get_checked(oid)
{
  var f=document.getElementById(oid);
	var all_inputs = f.getElementsByTagName('input');
	var input_element;
	for(var idx = 0; idx < all_inputs.length; idx++)
	{
	  input_element=all_inputs[idx];		
		if(input_element.type == "checkbox" &&  
		   input_element.checked  &&
		   !input_element.disabled)
		{

			alert("checkbox found. " + input_element.id);
		}	
	}
}


/*
  function:  cs_all_checkbox_in_div
             Change Status of all checkboxes with a id prefix
             on a div.

  args :
        div_id: id of the div container of checkboxs
 
        cb_id_prefix: checkbox id prefix
        
        memory_id: id of hidden input used to hold old check value.
        
  
        
  returns:  - 

*/
function showCheckboxLoadingOverlay() {
	var existing = document.getElementById('tl_cb_loading_overlay');
	if (existing) return existing;

	var overlay = document.createElement('div');
	overlay.id = 'tl_cb_loading_overlay';
	overlay.style.cssText =
		'position:fixed;top:0;left:0;width:100%;height:100%;' +
		'background:rgba(255,255,255,0.6);z-index:99999;' +
		'display:flex;align-items:center;justify-content:center;' +
		'font-family:sans-serif;';
	overlay.innerHTML =
		'<div style="background:#fff;padding:20px 30px;border-radius:8px;' +
		'box-shadow:0 2px 12px rgba(0,0,0,0.2);text-align:center;">' +
		'<i class="fa fa-spinner fa-spin fa-2x" style="color:#3498db;"></i>' +
		'<div style="margin-top:10px;color:#333;">Processing...</div>' +
		'</div>';
	document.body.appendChild(overlay);
	return overlay;
}

function hideCheckboxLoadingOverlay() {
	var overlay = document.getElementById('tl_cb_loading_overlay');
	if (overlay && overlay.parentNode) {
		overlay.parentNode.removeChild(overlay);
	}
}

function cs_all_checkbox_in_div(div_id, cb_id_prefix, memory_id, icon_id)
{
	// Show loading overlay
	showCheckboxLoadingOverlay();

	// Use setTimeout to allow UI to render the overlay before processing
	setTimeout(function() {
		try {
			var inputs = document.getElementById(div_id).getElementsByTagName('input');
			var memory = document.getElementById(memory_id);

			for(var idx = 0; idx < inputs.length; idx++)
			{
				if(inputs[idx].type == "checkbox" &&
				   inputs[idx].disabled == false &&
				  (inputs[idx].id.indexOf(cb_id_prefix)==0) )
				{
			      inputs[idx].checked = (memory.value == "1") ? false : true;
				}
			} // for

			memory.value = (memory.value == "1") ? "0" : "1";

			// Update icon based on new state
			if (icon_id) {
				var icon = document.getElementById(icon_id);
				if (icon) {
					if (memory.value == "1") {
						// All checked now
						icon.classList.remove('fa-square');
						icon.classList.remove('far');
						icon.classList.add('fas');
						icon.classList.add('fa-check-square');
					} else {
						// All unchecked now
						icon.classList.remove('fas');
						icon.classList.remove('fa-check-square');
						icon.classList.add('far');
						icon.classList.add('fa-square');
					}
				}
			}
		} finally {
			hideCheckboxLoadingOverlay();
		}
	}, 50);
}

/**
 * This function changes state of all checkboxes inside div_id with regards to
 * platform_id. platform_id is parsed from the name of the checkbox
 * (prefix...[tc_id][platform_id]). Uses global object check_state for memory.
 * If platform_id=0 is called all platforms will be checked/unchecked.
 */
var check_state = {};
var how_many = 0;
function cs_all_checkbox_in_div_with_platform(div_id, prefix, platform_id) {
	var state = prefix + platform_id;
	if (check_state[state] === undefined) {
		check_state[state] = true;
	}

	// Show loading overlay
	showCheckboxLoadingOverlay();

	// Use setTimeout to allow UI to render the overlay before processing
	setTimeout(function() {
		var userfeedback;
		var count = 0;
		try {
			// get all checkboxes with id starting with prefix inside div_id
			Ext.get(div_id).select("input[type=checkbox][id^=" + prefix + "]")
				.each(function (el, c, idx) {
					// the regex matches the number inside the last brackets of the name
					var check_platform_id = el.dom.name.match("([0-9]+)\]$")[1];
					if (platform_id == 0 || check_platform_id == platform_id) {
						el.dom.checked = check_state[state];
						count++;
					}
				});

			userfeedback = js_cs_all_checkbox_deselected;
			if (check_state[state]) {
				userfeedback =  js_cs_all_checkbox_selected;
			}

			check_state[state] = !check_state[state];
		} finally {
			hideCheckboxLoadingOverlay();
		}

		// Show feedback after loading is hidden
		bootbox.alert(userfeedback.replace('%s', count));
	}, 100);
}

