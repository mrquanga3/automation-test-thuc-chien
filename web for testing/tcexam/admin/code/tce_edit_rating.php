<?php
//============================================================+
// File name   : tce_edit_rating.php
// Begin       : 2004-06-09
// Last Update : 2020-05-06
//
// Description : Editor to manually rate free text answers.
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
 * Display form to manually rate free-text questions.
 * @package com.tecnick.tcexam.admin
 * @author Nicola Asuni
 * @since 2004-06-09
 */

/**
 */

require_once('../config/tce_config.php');

$pagelevel = K_AUTH_ADMIN_RATING;
require_once('../../shared/code/tce_authorization.php');

$thispage_title = $l['t_rating_editor'];
require_once('../code/tce_page_header.php');
require_once('../../shared/code/tce_functions_form.php');
require_once('../../shared/code/tce_functions_tcecode.php');
require_once('../../shared/code/tce_functions_auth_sql.php');

if (isset($selectcategory)) {
    $changecategory = 1;
}
if (isset($testlog_id)) {
    $testlog_id = intval($testlog_id);
}
if (!isset($testlog_comment)) {
    $testlog_comment = '';
}
if (isset($_REQUEST['test_id']) and ($_REQUEST['test_id'] > 0)) {
    $test_id = intval($_REQUEST['test_id']);
    // check user's authorization
    if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
        F_print_error('ERROR', $l['m_authorization_denied'], true);
    }
} else {
    $test_id = 0;
}

// comma separated list of required fields
$_REQUEST['ff_required'] = 'testlog_score';
$_REQUEST['ff_required_labels'] = htmlspecialchars($l['w_score'], ENT_COMPAT, $l['a_meta_charset']);

switch ($menu_mode) {
    case 'update': { // Update
        if ($formstatus = F_check_form_fields()) {
            if (isset($testlog_score) and isset($max_score)) {
                // score cannot be greater than max_score
                $testlog_score = floatval($testlog_score);
                $max_score = floatval($max_score);
                if ($testlog_score > $max_score) {
                    F_print_error('WARNING', $l['m_score_higher_than_max']);
                    break;
                }
                $sql = 'UPDATE '.K_TABLE_TESTS_LOGS.' SET
					testlog_score='.$testlog_score.',
					testlog_comment=\''.F_escape_sql($db, $testlog_comment).'\'
					WHERE testlog_id='.$testlog_id.'';
                if (!$r = F_db_query($sql, $db)) {
                    F_display_db_error(false);
                } else {
                    F_print_error('MESSAGE', $l['m_updated']);
                    $testlog_score = '';
                    $testlog_id = '';
                    $testlog_comment = '';
                }
            }
        }
        break;
    }
    default: {
        break;
    }
} //end of switch

// --- Initialize variables

// flag to display/hide user info
if (!isset($display_user_info)) {
    $display_user_info = 0;
}
// flag to select only unrated answers
if (!isset($display_all)) {
    $display_all = 0;
}

$sqlfilter = '';
if (empty($display_all)) {
    $sqlfilter = ' AND testlog_score IS NULL';
}

// set ordering mode
if (!isset($sqlordermode)) {
    $sqlordermode = 0;
}
switch ($sqlordermode) {
    case 2: {
        // ordered by test and question creation time
        $sqlorder = 'ORDER BY testuser_test_id, testlog_id';
        break;
    }
    case 1: {
        // ordered by test and question
        $sqlorder = 'ORDER BY testuser_test_id, testlog_question_id, testlog_testuser_id';
        break;
    }
    default:
    case 0: {
        // ordered by test and users
        $sqlorder = 'ORDER BY testuser_test_id, testlog_testuser_id, testlog_id';
        break;
    }
}

if (!isset($test_id) or empty($test_id)) {
    // select one executed test
    $sql = F_select_executed_tests_sql().' LIMIT 1';
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $test_id = $m['test_id'];
        } else {
            $test_id = 0;
        }
    } else {
        F_display_db_error();
    }
}

if ((isset($changecategory) and ($changecategory > 0)) or (!isset($testlog_id)) or empty($testlog_id)) {
    $sql = 'SELECT test_id, test_score_right, test_score_wrong, test_score_unanswered, testlog_id, testlog_score, testlog_answer_text, testlog_comment, question_description, question_difficulty, question_explanation
		FROM '.K_TABLE_TESTS.', '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
		WHERE testuser_test_id=test_id
			AND testlog_testuser_id=testuser_id
			AND testlog_question_id=question_id
			AND testuser_test_id='.$test_id.'
			AND testuser_status>0
			AND testuser_status<5
			AND question_type=3
			'.$sqlfilter.'
		'.$sqlorder.'
		LIMIT 1';
} else {
    $sql = 'SELECT test_id, test_score_right, test_score_wrong, test_score_unanswered, testlog_id, testlog_score, testlog_answer_text, testlog_comment, question_description, question_difficulty, question_explanation
		FROM '.K_TABLE_TESTS.', '.K_TABLE_TEST_USER.', '.K_TABLE_TESTS_LOGS.', '.K_TABLE_QUESTIONS.'
		WHERE testuser_test_id=test_id
			AND testlog_testuser_id=testuser_id
			AND testlog_question_id=question_id
			AND testlog_id='.$testlog_id.'
		LIMIT 1';
}

if ($sql) {
    if ($r = F_db_query($sql, $db)) {
        if ($m = F_db_fetch_array($r)) {
            $testlog_id = $m['testlog_id'];
            $test_id = $m['test_id'];
            $testlog_score = $m['testlog_score'];
            $testlog_comment = $m['testlog_comment'];
            $test_score_right = round(($m['test_score_right'] * $m['question_difficulty']), 3);
            $test_score_wrong = round(($m['test_score_wrong'] * $m['question_difficulty']), 3);
            $test_score_unanswered = round(($m['test_score_unanswered'] * $m['question_difficulty']), 3);
            $question = F_decode_tcecode($m['question_description']);
            $explanation =  F_decode_tcecode($m['question_explanation']);
            $answer = F_decode_tcecode($m['testlog_answer_text']);
        } else {
            $testlog_id = '';
            $testlog_score = '';
            $test_score_right = 1;
            $test_score_wrong = 0;
            $test_score_unanswered = 0;
            $question = '';
            $explanation = '';
            $answer = '';
            $testlog_comment = '';
        }
    } else {
        F_display_db_error();
    }
}

echo '<div class="container">'.K_NEWLINE;

echo '<div class="tceformbox">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_ratingeditor">'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="test_id">'.$l['w_test'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="changecategory" id="changecategory" value="" />'.K_NEWLINE;
echo '<select name="test_id" id="test_id" class="searchable" size="0" onchange="document.getElementById(\'form_ratingeditor\').changecategory.value=1;document.getElementById(\'form_ratingeditor\').submit()" title="'.$l['h_test'].'">'.K_NEWLINE;
$sql = F_select_executed_tests_sql();
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        echo '<option value="'.$m['test_id'].'"';
        if ($m['test_id'] == $test_id) {
            echo ' selected="selected"';
        }
        echo '>'.substr($m['test_begin_time'], 0, 10).' : '.htmlspecialchars($m['test_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
    }
} else {
    F_display_db_error();
}
echo '</select>'.K_NEWLINE;

// link for user selection popup
$jsaction = 'selectWindow=window.open(\'tce_select_tests_popup.php?cid=test_id\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\');return false;';
echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectcategory');

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="testlog_id">'.$l['w_answer'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="testlog_id" id="testlog_id" value="'.$testlog_id.'">'.K_NEWLINE;

// Get selected answer display if testlog_id is set
$selected_display = 'Select an answer';
if (!empty($testlog_id)) {
    $selected_sql = 'SELECT testlog_id, testlog_score, testlog_answer_text, user_lastname, user_firstname, user_name, question_description FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_TEST_USER.', '.K_TABLE_USERS.', '.K_TABLE_QUESTIONS.' WHERE testlog_id='.intval($testlog_id).' AND testlog_testuser_id=testuser_id AND testuser_user_id=user_id AND testlog_question_id=question_id';
    if ($selected_result = F_db_query($selected_sql, $db)) {
        if ($selected_row = F_db_fetch_array($selected_result)) {
            $sel_user = htmlspecialchars($selected_row['user_lastname'].' '.$selected_row['user_firstname'].' '.$selected_row['user_name'], ENT_NOQUOTES, $l['a_meta_charset']);
            $sel_status = (!empty($selected_row['testlog_score'])) ? 'Scored' : 'Not Scored';
            $sel_score = !empty($selected_row['testlog_score']) ? htmlspecialchars($selected_row['testlog_score'], ENT_COMPAT, $l['a_meta_charset']) : 'Not rated';
            $sel_question = htmlspecialchars(substr(strip_tags(F_decode_tcecode($selected_row['question_description'])), 0, 100), ENT_COMPAT, $l['a_meta_charset']);
            $sel_answer_full = strip_tags(F_decode_tcecode($selected_row['testlog_answer_text']));
            $sel_answer = empty($sel_answer_full) ? '(no answer)' : htmlspecialchars(substr($sel_answer_full, 0, 100), ENT_COMPAT, $l['a_meta_charset']);
            if (strlen($sel_question) > 100) $sel_question .= '...';
            if (strlen($sel_answer) > 100) $sel_answer .= '...';

            $selected_display = htmlspecialchars($sel_user, ENT_COMPAT, $l['a_meta_charset']) . ' | ' . htmlspecialchars($sel_status, ENT_COMPAT, $l['a_meta_charset']) . ' | ' . htmlspecialchars($sel_score, ENT_COMPAT, $l['a_meta_charset']) . ' | Q: ' . $sel_question . ' | A: ' . $sel_answer;
        }
    }
}

echo '<div id="custom-dropdown" class="custom-dropdown" title="'.$l['h_select_answer'].'">'.K_NEWLINE;
echo '  <div class="dropdown-trigger">'.K_NEWLINE;
echo '    <div id="dropdown-display" style="flex: 1; word-break: break-word; overflow: hidden;">'.$selected_display.'</div>'.K_NEWLINE;
echo '    <span class="dropdown-arrow">▼</span>'.K_NEWLINE;
echo '  </div>'.K_NEWLINE;
echo '  <div class="dropdown-menu" id="dropdown-menu">'.K_NEWLINE;

$sql = 'SELECT testlog_id, testlog_score, testlog_answer_text, user_lastname, user_firstname, user_name, question_description FROM '.K_TABLE_TESTS_LOGS.', '.K_TABLE_TEST_USER.', '.K_TABLE_USERS.', '.K_TABLE_QUESTIONS.' WHERE testlog_testuser_id=testuser_id AND testuser_user_id=user_id AND testlog_question_id=question_id AND testuser_test_id='.intval($test_id).' AND testuser_status>0 AND testuser_status<5 AND question_type=3 '.$sqlfilter.' '.$sqlorder.'';
if ($r = F_db_query($sql, $db)) {
    $countitem = 1;
    while ($m = F_db_fetch_array($r)) {
        $status = (!empty($m['testlog_score'])) ? '+' : '-';
        $status_text = (!empty($m['testlog_score'])) ? 'Scored' : 'Not Scored';
        $user_name = htmlspecialchars($m['user_lastname'].' '.$m['user_firstname'].' '.$m['user_name'], ENT_NOQUOTES, $l['a_meta_charset']);
        $question_full = strip_tags(F_decode_tcecode($m['question_description']));
        $answer_full = strip_tags(F_decode_tcecode($m['testlog_answer_text']));
        $question_text = htmlspecialchars(substr($question_full, 0, 50), ENT_NOQUOTES, $l['a_meta_charset']);
        $answer_display = empty($answer_full) ? '(no answer)' : htmlspecialchars(substr($answer_full, 0, 80), ENT_NOQUOTES, $l['a_meta_charset']);
        $question_escaped = htmlspecialchars($question_full, ENT_COMPAT, $l['a_meta_charset']);
        $answer_escaped = empty($answer_full) ? '(no answer)' : htmlspecialchars($answer_full, ENT_COMPAT, $l['a_meta_charset']);
        $question_display = substr($question_escaped, 0, 100) . (strlen($question_escaped) > 100 ? '...' : '');
        $answer_display = substr($answer_escaped, 0, 100) . (strlen($answer_escaped) > 100 ? '...' : '');
        $score_display = !empty($m['testlog_score']) ? htmlspecialchars($m['testlog_score'], ENT_COMPAT, $l['a_meta_charset']) : 'Not rated';
        echo '    <div class="dropdown-option"'.($m['testlog_id'] == $testlog_id ? ' data-selected="true"' : '').' data-testlog-id="'.$m['testlog_id'].'" data-question="'.$question_escaped.'" data-answer="'.$answer_escaped.'" data-status="'.$status_text.'" data-user="'.$user_name.'" data-score="'.$score_display.'">'.K_NEWLINE;
        echo '      <div class="option-header"><strong>'.$status.' '.$user_name.'</strong> <span class="option-id">[ID: '.$m['testlog_id'].']</span></div>'.K_NEWLINE;
        echo '      <div class="option-status">Status: '.$status_text.' | Score: '.$score_display.'</div>'.K_NEWLINE;
        echo '      <div class="option-question"><span style="color: #7f8c8d; font-size: 11px; font-weight: bold;">Q:</span> '.$question_display.'</div>'.K_NEWLINE;
        echo '      <div class="option-answer"><span style="color: #7f8c8d; font-size: 11px; font-weight: bold;">A:</span> '.$answer_display.'</div>'.K_NEWLINE;
        echo '    </div>'.K_NEWLINE;
        $countitem++;
    }
    if ($countitem == 1) {
        echo '    <div class="dropdown-option" data-testlog-id="0">&nbsp;</div>'.K_NEWLINE;
    }
} else {
    F_display_db_error();
}

echo '  </div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');

echo '<style>
.custom-dropdown {
    position: relative;
    display: inline-block;
    width: 100%;
    background: #ffffff;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: inherit;
    font-family: inherit;
}
.dropdown-trigger {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 5px 8px;
    cursor: pointer;
    background: #ffffff;
    user-select: none;
    min-height: 22px;
    gap: 8px;
    font-size: inherit;
    font-family: inherit;
}
.dropdown-trigger:hover {
    background-color: #f5f5f5;
}
#dropdown-display {
    font-size: inherit;
    line-height: 1.5;
}
.dropdown-arrow {
    font-size: 12px;
    color: #666;
    transition: transform 0.2s;
}
.custom-dropdown.active .dropdown-arrow {
    transform: rotate(180deg);
}
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #ccc;
    border-top: none;
    max-height: 400px;
    min-width: 400px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    border-radius: 0 0 4px 4px;
}
.custom-dropdown.active .dropdown-menu {
    display: block;
}
.dropdown-option {
    padding: 12px 12px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    white-space: normal;
    word-break: break-word;
    font-size: 13px;
    line-height: 1.4;
    transition: background-color 0.15s;
}
.option-header {
    font-size: 13px;
    margin-bottom: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.option-id {
    font-size: 11px;
    color: #7f8c8d;
    font-weight: normal;
}
.option-status {
    font-size: 12px;
    color: #555;
    margin-bottom: 6px;
}
.option-question {
    font-size: 12px;
    color: #333;
    margin-bottom: 4px;
    line-height: 1.5;
}
.option-answer {
    font-size: 12px;
    color: #555;
    margin-bottom: 4px;
    line-height: 1.5;
}
.dropdown-option:last-child {
    border-bottom: none;
}
.dropdown-option:hover {
    background-color: #e3f2fd;
}
.dropdown-option[data-selected="true"] {
    background-color: #fff3e0;
    font-weight: bold;
}
#answer-tooltip {
    position: fixed;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: #ffffff;
    padding: 0;
    border-radius: 8px;
    font-size: 14px;
    max-width: 800px;
    z-index: 10000;
    display: none;
    word-wrap: break-word;
    max-height: 500px;
    overflow: hidden;
    border: 2px solid #3498db;
    box-shadow: 0 8px 25px rgba(0,0,0,0.6), 0 0 0 1px rgba(52, 152, 219, 0.3);
    font-family: Arial, sans-serif;
    line-height: 1.6;
}
#answer-tooltip-header {
    background: linear-gradient(90deg, #2980b9 0%, #3498db 100%);
    padding: 12px 15px;
    font-weight: bold;
    font-size: 15px;
    border-bottom: 2px solid #2980b9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
#answer-tooltip-close {
    cursor: pointer;
    font-size: 18px;
    color: #ffffff;
    background: none;
    border: none;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#answer-tooltip-close:hover {
    background-color: rgba(255,255,255,0.2);
    border-radius: 3px;
}
#answer-tooltip-content {
    padding: 15px;
    overflow-y: auto;
    max-height: 430px;
}
#answer-tooltip .tooltip-section {
    margin-bottom: 12px;
    padding: 10px 12px;
    background-color: rgba(255,255,255,0.05);
    border-left: 4px solid #3498db;
    border-radius: 4px;
}
#answer-tooltip .tooltip-section:last-child {
    margin-bottom: 0;
}
#answer-tooltip .tooltip-label {
    font-weight: bold;
    color: #3498db;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 6px;
}
#answer-tooltip .tooltip-content {
    color: #ecf0f1;
    margin-top: 6px;
    line-height: 1.5;
    word-break: break-word;
    padding: 8px;
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}
</style>'.K_NEWLINE;

echo '<div id="answer-tooltip">'.K_NEWLINE;
echo '  <div id="answer-tooltip-header">'.K_NEWLINE;
echo '    <span>Answer Details</span>'.K_NEWLINE;
echo '    <button id="answer-tooltip-close" onclick="hideAnswerTooltip()">&times;</button>'.K_NEWLINE;
echo '  </div>'.K_NEWLINE;
echo '  <div id="answer-tooltip-content"></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    var dropdown = document.getElementById("custom-dropdown");
    var trigger = dropdown.querySelector(".dropdown-trigger");
    var options = dropdown.querySelectorAll(".dropdown-option");

    trigger.addEventListener("click", function(e) {
        e.stopPropagation();
        dropdown.classList.toggle("active");
    });

    options.forEach(function(option) {
        option.addEventListener("click", function(e) {
            e.stopPropagation();
            var testlogId = option.getAttribute("data-testlog-id");
            var user = option.getAttribute("data-user");
            var status = option.getAttribute("data-status");
            var score = option.getAttribute("data-score");
            var question = option.getAttribute("data-question");
            var answer = option.getAttribute("data-answer");

            var questionDisplay = question.substring(0, 100) + (question.length > 100 ? "..." : "");
            var answerDisplay = answer.substring(0, 100) + (answer.length > 100 ? "..." : "");

            var displayHtml = \'\';
            displayHtml += \'<div style="font-weight: bold; margin-bottom: 6px;">\' + user + \' <span style="font-size: 11px; color: #7f8c8d;">[ID: \' + testlogId + \']</span></div>\';
            displayHtml += \'<div style="font-size: 12px; color: #555; margin-bottom: 6px;">Status: \' + status + \' | Score: \' + score + \'</div>\';
            displayHtml += \'<div style="font-size: 12px; color: #333; margin-bottom: 4px;"><span style="color: #7f8c8d; font-weight: bold;">Q:</span> \' + questionDisplay + \'</div>\';
            displayHtml += \'<div style="font-size: 12px; color: #555;"><span style="color: #7f8c8d; font-weight: bold;">A:</span> \' + answerDisplay + \'</div>\';

            document.getElementById("testlog_id").value = testlogId;
            document.getElementById("dropdown-display").innerHTML = displayHtml;
            dropdown.classList.remove("active");
            document.getElementById("form_ratingeditor").submit();
        });
    });

    document.addEventListener("click", function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("active");
        }
    });
});
</script>'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="sqlordermode">'.$l['w_order'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<select name="sqlordermode" id="sqlordermode" size="0" onchange="document.getElementById(\'form_ratingeditor\').submit()" title="'.$l['w_order'].'">'.K_NEWLINE;
echo '<option value="0"';
if ($sqlordermode == 0) {
    echo ' selected="selected"';
}
echo '>'.$l['w_user'].'</option>'.K_NEWLINE;
echo '<option value="1"';
if ($sqlordermode == 1) {
    echo ' selected="selected"';
}
echo '>'.$l['w_question'].'</option>'.K_NEWLINE;
echo '<option value="2"';
if ($sqlordermode == 2) {
    echo ' selected="selected"';
}
echo '>'.$l['w_time'].'</option>'.K_NEWLINE;
echo '</select>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectmode');

echo getFormRowCheckBox('display_user_info', $l['w_display_user_info'], $l['h_display_user_info'], '', 1, $display_user_info, false, '');
echo getFormRowCheckBox('display_all', $l['w_display_all'], $l['h_display_all'], '', 1, $display_all, false, '');

echo '<div class="row"><hr /></div>'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<span title="'.$l['h_question_description'].'">'.$l['w_question'].'</span>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo $question;
echo '&nbsp;'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

if (K_ENABLE_QUESTION_EXPLANATION and !empty($explanation)) {
    echo '<div class="row">'.K_NEWLINE;
    echo '<span class="label">'.K_NEWLINE;
    echo '<span title="'.$l['w_explanation'].'">'.$l['w_explanation'].'</span>'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '<span class="formw">'.K_NEWLINE;
    echo $explanation.'&nbsp;'.K_NEWLINE;
    echo '</span>'.K_NEWLINE;
    echo '</div>'.K_NEWLINE;
}

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<span title="'.$l['h_answer'].'">'.$l['w_answer'].'</span>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo $answer.'&nbsp;<br />&nbsp;'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormRowTextInput('testlog_score', $l['w_score'], $l['h_score'], '', $testlog_score, '^([0-9\+\-]*)([\.]?)([0-9]*)$');

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">&nbsp;</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<input type="hidden" name="max_score" id="max_score" value="'.$test_score_right.'" />'.K_NEWLINE;
echo '<div style="display: flex; align-items: center; gap: 5px;">'.K_NEWLINE;
echo '<input type="radio" name="default_score" id="default_score_correct" value="0" onclick="document.getElementById(\'form_ratingeditor\').testlog_score.value=\''.$test_score_right.'\'" title="'.$l['h_score_right'].'" /><label for="default_score_correct">'.$l['w_score_right'].' ['.$test_score_right.']</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">&nbsp;</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<div style="display: flex; align-items: center; gap: 5px;">'.K_NEWLINE;
echo '<input type="radio" name="default_score" id="default_score_wrong" value="0" onclick="document.getElementById(\'form_ratingeditor\').testlog_score.value=\''.$test_score_wrong.'\'" title="'.$l['h_score_wrong'].'" /><label for="default_score_wrong">'.$l['w_score_wrong'].' ['.$test_score_wrong.']</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">&nbsp;</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<div style="display: flex; align-items: center; gap: 5px;">'.K_NEWLINE;
echo '<input type="radio" name="default_score" id="default_score_unanswered" value="0" onclick="document.getElementById(\'form_ratingeditor\').testlog_score.value=\''.$test_score_unanswered.'\'" title="'.$l['h_score_unanswered'].'" /><label for="default_score_unanswered">'.$l['w_score_unanswered'].' ['.$test_score_unanswered.']</label>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormRowTextBox('testlog_comment', $l['w_comment'], $l['w_comment'], $testlog_comment);

echo '<div class="row">'.K_NEWLINE;

// show buttons by case
if (isset($testlog_id) and ($testlog_id > 0)) {
    F_submit_button("update", $l['w_update'], $l['h_update']);
}

echo '</div>'.K_NEWLINE;
echo F_getCSRFTokenField().K_NEWLINE;
echo '</form>'.K_NEWLINE;

echo '<script>
var testlogSelect = document.getElementById("testlog_id");
function showAnswerTooltip() {
    var selectedIndex = testlogSelect.selectedIndex;
    if (selectedIndex >= 0) {
        var option = testlogSelect.options[selectedIndex];
        var question = option.getAttribute("data-question");
        var answer = option.getAttribute("data-answer");
        var status = option.getAttribute("data-status");
        var user = option.getAttribute("data-user");
        var testlogId = option.getAttribute("data-testlog-id");

        if (question) {
            var tooltipDiv = document.getElementById("answer-tooltip");
            var contentDiv = document.getElementById("answer-tooltip-content");
            var tooltipHtml =
                "<div class=\"tooltip-section\">" +
                "  <div class=\"tooltip-label\">📋 Question:</div>" +
                "  <div class=\"tooltip-content\">" + question + "</div>" +
                "</div>" +
                "<div class=\"tooltip-section\">" +
                "  <div class=\"tooltip-label\">✎ Answer:</div>" +
                "  <div class=\"tooltip-content\">" + answer + "</div>" +
                "</div>" +
                "<div class=\"tooltip-section\">" +
                "  <div class=\"tooltip-label\">👤 User:</div>" +
                "  <div class=\"tooltip-content\">" + user + "</div>" +
                "</div>" +
                "<div class=\"tooltip-section\">" +
                "  <div class=\"tooltip-label\">✓ Status:</div>" +
                "  <div class=\"tooltip-content\">" + status + "</div>" +
                "</div>" +
                "<div class=\"tooltip-section\">" +
                "  <div class=\"tooltip-label\">🔢 TestLog ID:</div>" +
                "  <div class=\"tooltip-content\">" + testlogId + "</div>" +
                "</div>";

            contentDiv.innerHTML = tooltipHtml;
            tooltipDiv.style.display = "flex";
            tooltipDiv.style.flexDirection = "column";
            tooltipDiv.style.left = "50%";
            tooltipDiv.style.top = "50%";
            tooltipDiv.style.transform = "translate(-50%, -50%)";
        }
    }
}
function hideAnswerTooltip() {
    var tooltipDiv = document.getElementById("answer-tooltip");
    tooltipDiv.style.display = "none";
}
document.addEventListener("keydown", function(e) {
    if (e.key === "Escape") hideAnswerTooltip();
});
</script>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

echo '<div class="pagehelp">'.$l['hp_edit_rating'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/tce_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
