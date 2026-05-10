<?php
//============================================================+
// File name   : tce_license_notice.php
// Begin       : 2026-05-11
// Description : Function to display translatable license notice
// Author      : Claude Code
// License     : GNU Affero General Public License v.3
//============================================================+

/**
 * Display license notice with language support
 * Supports multiple languages via TMX translation system
 *
 * @return void
 */
function F_displayLicenseNotice() {
    $notice = '<div style="direction:ltr;text-align:left;border:1px solid black; padding:5px; margin:10px; background-color:#DDEEFF; color:#000000; width:95%; margin-left:auto; margin-right:auto; font-weight:bold; font-size:95%;">';

    // Main license text
    $notice .= F_getLanguageVariable('a_license_header');

    // License terms list
    $notice .= '<ul>';
    $notice .= '<li>' . F_getLanguageVariable('a_license_term_1') . '</li>';
    $notice .= '<li>' . F_getLanguageVariable('a_license_term_2') . '</li>';
    $notice .= '</ul>';

    // Commercial license info
    $notice .= F_getLanguageVariable('a_license_commercial');

    $notice .= '</div>';

    echo $notice . K_NEWLINE;
}

?>
