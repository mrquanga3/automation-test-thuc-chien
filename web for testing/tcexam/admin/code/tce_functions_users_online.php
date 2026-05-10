<?php
//============================================================+
// File name   : tce_functions_levels.php
// Begin       : 2001-10-18
// Last Update : 2020-05-06
//
// Description : Functions to display online users' data.
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
//    Copyright (C) 2004-2020  Nicola Asuni - Tecnick.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Functions to display online users' data.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2001-10-18
 */

/**
 * Convert IPv6-mapped IPv4 address to IPv4 format.
 * @param $ip (string) IP address (IPv4 or IPv6)
 * @return string IPv4 address if applicable, otherwise original IP
 */
function F_convert_ipv6_to_ipv4($ip)
{
    // Check if it's an IPv6-mapped IPv4 address
    if (strpos($ip, 'ffff:') !== false) {
        // Extract the last 32 bits (last 2 groups of 4 hex digits each)
        $parts = explode(':', $ip);
        if (count($parts) >= 2) {
            $last_group = $parts[count($parts) - 1];
            $second_last = $parts[count($parts) - 2];

            // Convert hex to decimal
            $part1 = hexdec(substr($second_last, 0, 2));
            $part2 = hexdec(substr($second_last, 2, 2));
            $part3 = hexdec(substr($last_group, 0, 2));
            $part4 = hexdec(substr($last_group, 2, 2));

            return $part1 . '.' . $part2 . '.' . $part3 . '.' . $part4;
        }
    }
    return $ip;
}

/**
 * Display online users form using F_list_online_users function.
 * @author Nicola Asuni
 * @since 2001-10-18
 * @param $wherequery (string) users selection query
 * @param $order_field (string) order by column name
 * @param $orderdir (string) oreder direction
 * @param $firstrow (string) number of first row to display
 * @param $rowsperpage (string) number of rows per page
 * @return false in case of empty database, true otherwise
 */
function F_show_online_users($wherequery, $order_field, $orderdir, $firstrow, $rowsperpage)
{
    global $l;
    require_once('../config/tce_config.php');
    F_list_online_users($wherequery, $order_field, $orderdir, $firstrow, $rowsperpage);
    return true;
}

/**
 * Display online users.
 * @author Nicola Asuni
 * @since 2001-10-18
 * @param $wherequery (string) users selection query
 * @param $order_field (string) order by column name
 * @param $orderdir (int) oreder direction
 * @param $firstrow (int) number of first row to display
 * @param $rowsperpage (int) number of rows per page
 * @return false in case of empty database, true otherwise
 */
function F_list_online_users($wherequery, $order_field, $orderdir, $firstrow, $rowsperpage)
{
    global $l, $db;
    require_once('../config/tce_config.php');
    require_once('../../shared/code/tce_functions_page.php');
    require_once('tce_functions_user_select.php');
    
    //initialize variables
    $orderdir = intval($orderdir);
    $firstrow = intval($firstrow);
    $rowsperpage = intval($rowsperpage);
    
    // order fields for SQL query
    if (empty($order_field) or (!in_array($order_field, array('cpsession_id', 'cpsession_data')))) {
        $order_field = 'cpsession_expiry';
    }
    if ($orderdir == 0) {
        $nextorderdir = 1;
        $full_order_field = $order_field;
    } else {
        $nextorderdir = 0;
        $full_order_field = $order_field.' DESC';
    }

    if (!F_count_rows(K_TABLE_SESSIONS)) { //if the table is void (no items) display message
        echo '<h2>'.$l['m_databasempty'].'</h2>';
        return false;
    }

    if (empty($wherequery)) {
        $sql = 'SELECT * FROM '.K_TABLE_SESSIONS.' ORDER BY '.$full_order_field.'';
    } else {
        $wherequery = F_escape_sql($db, $wherequery);
        $sql = 'SELECT * FROM '.K_TABLE_SESSIONS.' '.$wherequery.' ORDER BY '.$full_order_field.'';
    }
    if (K_DATABASE_TYPE == 'ORACLE') {
        $sql = 'SELECT * FROM ('.$sql.') WHERE rownum BETWEEN '.$firstrow.' AND '.($firstrow + $rowsperpage).'';
    } else {
        $sql .= ' LIMIT '.$rowsperpage.' OFFSET '.$firstrow.'';
    }

    echo '<div class="container">'.K_NEWLINE;
    echo '<table class="userselect">'.K_NEWLINE;
    echo '<tr>'.K_NEWLINE;
    echo '<th style="font-weight:bold; padding:8px;">session</th>'.K_NEWLINE;
    echo '<th style="font-weight:bold; padding:8px;">'.$l['w_user'].'</th>'.K_NEWLINE;
    echo '<th style="font-weight:bold; padding:8px;">full name</th>'.K_NEWLINE;
    echo '<th style="font-weight:bold; padding:8px;">'.$l['w_level'].'</th>'.K_NEWLINE;
    echo '<th style="font-weight:bold; padding:8px;">'.$l['w_ip'].'</th>'.K_NEWLINE;
    echo '<th style="font-weight:bold; padding:8px;">time</th>'.K_NEWLINE;
    echo '</tr>'.K_NEWLINE;

    if ($r = F_db_query($sql, $db)) {
        while ($m = F_db_fetch_array($r)) {
            $this_session = F_session_string_to_array($m['cpsession_data']);
            echo '<tr>';
            // Session column
            echo '<td align="left">';
            echo '<span style="font-size:80%; font-family:monospace;">'.substr($m['cpsession_id'], 0, 8).'</span>';
            echo '</td>';
            // User column
            echo '<td align="left">';
            $is_logged_in = isset($this_session['session_user_name']) && strpos($this_session['session_user_name'], '- [') === false;
            if ($is_logged_in) {
                $username = urldecode($this_session['session_user_name']);
                if (isset($this_session['session_user_id']) && F_isAuthorizedEditorForUser($this_session['session_user_id'])) {
                    echo '<a href="tce_edit_user.php?user_id='.$this_session['session_user_id'].'">'.$username.'</a>';
                } else {
                    echo $username;
                }
            } else {
                echo 'ANONYMOUS';
            }
            echo '</td>';
            // Full name column (from database)
            echo '<td align="left">';
            $fullname = 'ANONYMOUS';
            if ($is_logged_in && isset($this_session['session_user_id'])) {
                $user_id = intval($this_session['session_user_id']);
                $sql_user = 'SELECT user_firstname, user_lastname FROM '.K_TABLE_USERS.' WHERE user_id='.$user_id.' LIMIT 1';
                if ($r_user = F_db_query($sql_user, $db)) {
                    if ($m_user = F_db_fetch_array($r_user)) {
                        $fname = '';
                        if ($m_user['user_lastname']) {
                            $fname .= $m_user['user_lastname'];
                        }
                        if ($m_user['user_firstname']) {
                            if ($fname) $fname .= ' ';
                            $fname .= $m_user['user_firstname'];
                        }
                        if ($fname) {
                            $fullname = $fname;
                        } else {
                            // No firstname/lastname, use username in uppercase
                            $fullname = strtoupper($username);
                        }
                    }
                }
            }
            echo $fullname;
            echo '</td>';
            // Level and IP columns
            echo '<td>'.(isset($this_session['session_user_level']) ? $this_session['session_user_level'] : '').'</td>';
            echo '<td>'.(isset($this_session['session_user_ip']) ? F_convert_ipv6_to_ipv4($this_session['session_user_ip']) : '').'</td>';
            // Time column
            echo '<td>'.date(K_TIMESTAMP_FORMAT, strtotime($m['cpsession_expiry'])).'</td>';
            echo '</tr>'.K_NEWLINE;
        }
    } else {
        F_display_db_error();
    }
    echo '</table>'.K_NEWLINE;

    // --- ------------------------------------------------------
    // --- page jump
    if ($rowsperpage > 0) {
        $sql = 'SELECT count(*) AS total FROM '.K_TABLE_SESSIONS.' '.$wherequery.'';
        if (!empty($order_field)) {
            $param_array = '&amp;order_field='.urlencode($order_field).'';
        }
        if (!empty($orderdir)) {
            $param_array .= '&amp;orderdir='.$orderdir.'';
        }
        $param_array .= '&amp;submitted=1';
        F_show_page_navigator($_SERVER['SCRIPT_NAME'], $sql, $firstrow, $rowsperpage, $param_array);
    }
    echo '<div class="pagehelp">'.$l['hp_online_users'].'</div>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
    return true;
}

//============================================================+
// END OF FILE
//============================================================+
