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
 * Uses global $l array for language strings
 *
 * @return void
 */
function F_displayLicenseNotice() {
    global $l;

    $notice = '<div style="direction:ltr;text-align:left;border:1px solid black; padding:5px; margin:10px; background-color:#DDEEFF; color:#000000; width:95%; margin-left:auto; margin-right:auto; font-weight:bold; font-size:95%;">';

    // Main license text
    if (isset($l['a_license_header'])) {
        $notice .= $l['a_license_header'];
    }

    // License terms list
    $notice .= '<ul>';
    if (isset($l['a_license_term_1'])) {
        $notice .= '<li>' . $l['a_license_term_1'] . '</li>';
    }
    if (isset($l['a_license_term_2'])) {
        $notice .= '<li>' . $l['a_license_term_2'] . '</li>';
    }
    $notice .= '</ul>';

    // Commercial license info
    if (isset($l['a_license_commercial'])) {
        $notice .= $l['a_license_commercial'];
    }

    $notice .= '</div>';

    echo $notice . K_NEWLINE;
}

?>
