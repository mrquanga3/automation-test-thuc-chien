<?php
//============================================================+
// File name   : tce_page_userbar.php
// Begin       : 2004-04-24
// Last Update : 2020-07-16
//
// Description : Display user's bar containing copyright
//               information, user status and language
//               selector.
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//
// License:
//    Copyright (C) 2004-2020 Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Display user's bar containing copyright information, user status and language selector.
 * @package com.tecnick.tcexam.shared
 * @author Nicola Asuni
 * @since 2004-04-24
 */

// IMPORTANT: DO NOT REMOVE OR ALTER THIS PAGE!

// Skip login button on login pages (to avoid duplicate login buttons)
$skip_login_button = strpos($_SERVER['SCRIPT_NAME'], 'tce_login.php') !== false || strpos($_SERVER['SCRIPT_NAME'], 'tce_password_reset.php') !== false || strpos($_SERVER['SCRIPT_NAME'], 'tce_user_registration.php') !== false;

// skip links
echo '<div class="minibutton" dir="ltr">'.K_NEWLINE;
echo '<a href="#timersection" accesskey="3" title="[3] '.$l['w_jump_timer'].'" class="white">'.$l['w_jump_timer'].'</a> <span style="color:white;">|</span>'.K_NEWLINE;
echo '<a href="#menusection" accesskey="4" title="[4] '.$l['w_jump_menu'].'" class="white">'.$l['w_jump_menu'].'</a>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

// Only show userbar if user is logged in
if (isset($_SESSION['session_user_level']) && $_SESSION['session_user_level'] > 0) {
    echo '<div class="userbar">'.K_NEWLINE;
    // display user information
    echo '<span title="'.$l['h_user_info'].'">'.$l['w_user'].': '.$_SESSION['session_user_name'].'</span>';
    // display logout link
    echo ' <a href="tce_logout.php" class="logoutbutton" title="'.$l['h_logout_link'].'" onclick="return confirm(\''.$l['w_logout'].' ?\')">'.$l['w_logout'].'</a>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
}

echo '<div class="minibutton" dir="ltr">';
echo '<span class="copyright"><a href="http://www.tcexam.org">TCExam</a> ver. '.K_TCEXAM_VERSION.' - Copyright &copy; 2004-2020 Nicola Asuni - <a href="http://www.tecnick.com">Tecnick.com LTD</a></span>';
echo '</div>'.K_NEWLINE;

// Display W3C logos
echo '<div class="minibutton" dir="ltr">'.K_NEWLINE;
echo '<a href="http://validator.w3.org/check?uri='.K_PATH_HOST.$_SERVER['SCRIPT_NAME'].'" class="minibutton" title="This Page Is Valid XHTML 1.0 Strict!">W3C <span>XHTML 1.0</span></a> <span style="color:white;">|</span>'.K_NEWLINE;
echo '<a href="http://jigsaw.w3.org/css-validator/" class="minibutton" title="This document validates as CSS!">W3C <span>CSS 2.0</span></a> <span style="color:white;">|</span>'.K_NEWLINE;
echo '<a href="http://www.w3.org/WAI/WCAG1AAA-Conformance" class="minibutton" title="Explanation of Level Triple-A Conformance">W3C <span>WAI-AAA</span></a>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

//============================================================+
// END OF FILE
//============================================================+
