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

    // Main license text with link to AGPL
    if (isset($l['a_license_header'])) {
        $notice .= str_replace('GNU-AGPL v.3', '<a href="http://www.fsf.org/licensing/licenses/agpl-3.0.html" title="External link to GNU Affero General Public License">GNU-AGPL v.3</a>', $l['a_license_header']);
    }

    // License terms list
    $notice .= '<ul>';
    if (isset($l['a_license_term_1'])) {
        $term1 = $l['a_license_term_1'];
        $term1 = str_replace('TECNICK.COM', '<a href="http://www.tecnick.com">TECNICK.COM</a>', $term1);
        $term1 = str_replace('TCEXAM', '<a href="http://www.tcexam.org">TCEXAM</a>', $term1);
        $notice .= '<li>' . $term1 . '</li>';
    }
    if (isset($l['a_license_term_2'])) {
        $term2 = $l['a_license_term_2'];
        $term2 = str_replace('TECNICK.COM LTD', '<a href="http://www.tecnick.com">TECNICK.COM LTD</a>', $term2);
        $notice .= '<li>' . $term2 . '</li>';
    }
    $notice .= '</ul>';

    // Commercial license info with mailto link
    if (isset($l['a_license_commercial'])) {
        $notice .= str_replace('info@tecnick.com', '<a href="mailto:info@tecnick.com">info@tecnick.com</a>', $l['a_license_commercial']);
    }

    $notice .= '</div>';

    echo $notice . K_NEWLINE;
}

?>
