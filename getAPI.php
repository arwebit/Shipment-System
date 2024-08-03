<?php

include './file_includes.php';

/* * *********************************** LOGIN ACCESS STARTS ************************************ */

if (isset($_REQUEST['admin_login'])) {
    $username = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['username']));
    $userpass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_POST['userpass']));
    $md5_pass = md5($userpass);

    if (empty($username) || empty($userpass)) {
        $loginErr = "Please provide all the fields";
    }
    if ($loginErr == "") {
        $user_existSQL = "SELECT * FROM admin_login_access WHERE username='$username' AND password='$md5_pass'";
        $user_existCount = connect_db()->countEntries($user_existSQL);
        if ($user_existCount > 0) {
            $user_activeSQL = "SELECT * FROM admin_login_access WHERE username='$username' AND status=1";
            $user_activeCount = connect_db()->countEntries($user_activeSQL);
            if ($user_activeCount > 0) {
                $_SESSION['shipment_user'] = $username;
                $response['error'] = false;
                $response['message'] = "Success";
                $response['data'] = "Welcome " . $username;
            } else {
                $response['error'] = true;
                $response['message'] = "Login failed";
                $response['data'] = "User not active. Please contact administrator";
            }
        } else {
            $response['error'] = true;
            $response['message'] = "Login failed";
            $response['data'] = "Wrong username or password";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Data input failed";
        $response['data'] = $loginErr;
    }
    echo json_encode($response);
}
/* * *********************************** LOGIN ACCESS ENDS ************************************ */

/* * *********************************** INSERT USERS STARTS ************************************ */
if (isset($_REQUEST['add_user'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $user_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['user_name']));
    $user_pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['user_pass']));
    $mem_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['mem_name']));
    $user_role = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['user_role']));

    if (empty($user_name)) {
        $user_nameErr = "Required";
    } else {
        $dup_user_nameSQL = "SELECT * FROM admin_login_access WHERE username='$user_name'";
        $dup_user_nameCount = connect_db()->countEntries($dup_user_nameSQL);
        if ($dup_user_nameCount > 0) {
            $user_nameErr = "Duplicate. Try again";
        }
    }
    if (empty($user_pass)) {
        $user_passErr = "Required";
    }
    if (empty($mem_name)) {
        $mem_nameErr = "Required";
    }


    if (($user_nameErr == "") && ($user_passErr == "") && ($mem_nameErr == "")) {
        $userInsertSQL .= "INSERT INTO admin_login_access VALUES('$id','$user_name','$mem_name', '$user_pass','$user_role',";
        $userInsertSQL .= "'1','$login_user')";
        $userInsertStatus = connect_db()->cud($userInsertSQL);
        if ($userInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $userErrors = array("Member_nameErr" => $mem_nameErr, "UsernameErr" => $user_nameErr, "UserpassErr" => $user_passErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($userErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT USERS ENDS ************************************ */

/* * *********************************** UPDATE USERS STARTS ************************************ */
if (isset($_REQUEST['edit_user'])) {
    $user_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['user_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $login_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_name']));
    $role = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['user_role']));
    $status = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['user_status']));

    if (empty($login_name)) {
        $login_nameErr = "Required";
    }
    if ($login_nameErr == "") {
        $userUpdateSQL .= "UPDATE admin_login_access SET name='$login_name', role='$role', create_user='$login_user', status='$status' WHERE id='$user_id' ";
        $userUpdateStatus = connect_db()->cud($userUpdateSQL);
        if ($userUpdateStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $userErrors = array("Login_nameErr" => $login_nameErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($userErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE USERS ENDS ************************************ */

/* * *********************************** CHANGE PASSWORDS STARTS ************************************ */
if (isset($_REQUEST['change_pass'])) {
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $old_pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['old_pass']));
    $new_pass = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['new_pass']));

    if (empty($old_pass)) {
        $old_passErr = "Required";
    } else {
        $m_old_pass = md5($old_pass);
        $passexistSQL = "SELECT * FROM admin_login_access WHERE password='$m_old_pass' AND username='$login_user' ";
        $passexistCount = connect_db()->countEntries($passexistSQL);
        if ($passexistCount == 0) {
            $old_passErr = "Old password is wrong";
        }
    }
    if (empty($new_pass)) {
        $new_passErr = "Required";
    } else {
        $m_new_pass = md5($new_pass);
    }
    if (($old_passErr == "") && ($new_passErr == "")) {
        $passUpdateSQL = "UPDATE admin_login_access SET password='$m_new_pass' WHERE username='$login_user' ";
        $passUpdateStatus = connect_db()->cud($passUpdateSQL);
        if ($passUpdateStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully changed";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $passErrors = array("OldpassErr" => $old_passErr, "NewpassErr" => $new_passErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($passErrors);
    }
    echo json_encode($response);
}
/* * *********************************** CHANGE PASSWORDS ENDS ************************************ */
/* * *********************************** INSERT PRIVATE MARK STARTS ************************************ */
if (isset($_REQUEST['add_private_mark'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $private_mark = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['private_mark']));
    $party_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['party_name']));
    $gstin_aadhar = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['gstin_aadhar']));

    if (empty($private_mark)) {
        $private_markErr = "Required";
    } else {
        $dup_pmSQL = "SELECT * FROM mas_private_mark WHERE UPPER(private_mark)='$private_mark'";
        $dup_pmCount = connect_db()->countEntries($dup_pmSQL);
        if ($dup_pmCount > 0) {
            $private_markErr = "Duplicate. Try again";
        }
    }
    if (empty($party_name)) {
        $party_nameErr = "Required";
    }
    if (empty($gstin_aadhar)) {
        $gstin_aadharErr = "Required";
    }


    if (($private_markErr == "") && ($party_nameErr == "") && ($gstin_aadharErr == "")) {
        $pmInsertSQL .= "INSERT INTO mas_private_mark VALUES('$id','$private_mark','$party_name', '$gstin_aadhar',";
        $pmInsertSQL .= "'1','$login_user')";
        $pmInsertStatus = connect_db()->cud($pmInsertSQL);
        if ($pmInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $pmErrors = array("Private_markErr" => $private_markErr, "Party_nameErr" => $party_nameErr, "GSTINAadharErr" => $gstin_aadharErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($pmErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT PRIVATE MARK ENDS ************************************ */
/* * *********************************** UPDATE PRIVATE MARK STARTS ************************************ */
if (isset($_REQUEST['edit_private_mark'])) {
    $pmid = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['private_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $private_mark = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['private_mark']));
    $hprivate_mark = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['hprivate_mark']));
    $party_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['party_name']));
    $gstin_aadhar = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['gstin_aadhar']));
    $pm_status = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['pm_status']));

    if (empty($private_mark)) {
        $private_markErr = "Required";
    } else {
        $dup_pmSQL = "SELECT * FROM mas_private_mark WHERE UPPER(private_mark)='$private_mark' AND UPPER(private_mark)!='$hprivate_mark'";
        $dup_pmCount = connect_db()->countEntries($dup_pmSQL);
        if ($dup_pmCount > 0) {
            $private_markErr = "Duplicate. Try again";
        }
    }
    if (empty($party_name)) {
        $party_nameErr = "Required";
    }
    if (empty($gstin_aadhar)) {
        $gstin_aadharErr = "Required";
    }


    if (($private_markErr == "") && ($party_nameErr == "") && ($gstin_aadharErr == "")) {
        $pmUpdateSQL .= "UPDATE mas_private_mark SET private_mark='$private_mark', party_name='$party_name', ";
        $pmUpdateSQL .= "gstin_aadhar='$gstin_aadhar', status='$pm_status' , create_user='$login_user' WHERE id='$pmid'";
        $pmUpdateStatus = connect_db()->cud($pmUpdateSQL);
        if ($pmUpdateStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $pmErrors = array("Private_markErr" => $private_markErr, "Party_nameErr" => $party_nameErr, "GSTINAadharErr" => $gstin_aadharErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($pmErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE PRIVATE MARK ENDS ************************************ */
/* * *********************************** INSERT CONTENTS STARTS ************************************ */
if (isset($_REQUEST['add_contents'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $contents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['contents']));
    if (empty($contents)) {
        $contentsErr = "Required";
    } else {
        $dupcontentSQL = "SELECT * FROM mas_contents WHERE UPPER(contents_desc)='$contents'";
        $dupcontentCount = connect_db()->countEntries($dupcontentSQL);
        if ($dupcontentCount > 0) {
            $contentsErr = "Duplicate. Try again";
        }
    }
    if ($contentsErr == "") {
        $cnInsertSQL .= "INSERT INTO mas_contents VALUES('$id','$contents',1,'$login_user')";
        $cnInsertStatus = connect_db()->cud($cnInsertSQL);
        if ($cnInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $cnErrors = array("ContentsErr" => $contentsErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($cnErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT CONTENTS ENDS ************************************ */
/* * *********************************** UPDATE CONTENTS STARTS ************************************ */
if (isset($_REQUEST['edit_content'])) {
    $cnid = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['content_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $contents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['contents']));
    $hcontents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['hcontents']));
    $cn_status = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['cn_status']));

    if (empty($contents)) {
        $contentsErr = "Required";
    } else {
        $dupcontentSQL = "SELECT * FROM mas_contents WHERE UPPER(contents_desc)='$contents' AND UPPER(contents_desc)!='$hcontents'";
        $dupcontentCount = connect_db()->countEntries($dupcontentSQL);
        if ($dupcontentCount > 0) {
            $contentsErr = "Duplicate. Try again";
        }
    }
    if ($contentsErr == "") {
        $cnUpdateSQL .= "UPDATE mas_contents SET contents_desc='$contents', status='$cn_status', ";
        $cnUpdateSQL .= "create_user='$login_user' WHERE id='$cnid'";
        $cnUpdateStatus = connect_db()->cud($cnUpdateSQL);
        if ($cnUpdateStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $cnErrors = array("ContentsErr" => $contentsErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($cnErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE CONTENTS ENDS ************************************ */
/* * *********************************** INSERT UNLOAD SHIPMENT STARTS ************************************ */
if (isset($_REQUEST['add_unload_shipment'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['manifest_no']));
    $despatch_from = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_from']));
    $lorry_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['lorry_no']));
    $unload_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['unload_date']));
    $manifest_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['manifest_date']));
    $despatch_to = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_to']));
    $driver_no_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['driver_no_name']));

    if (empty($manifest_no)) {
        $manifest_noErr = "Required";
    } else {
        $dupmanifest_noSQL = "SELECT * FROM unload_shipment WHERE manifest_no='$manifest_no'";
        $dup_manifestCount = connect_db()->countEntries($dupmanifest_noSQL);
        if ($dup_manifestCount > 0) {
            $manifest_noErr = "Duplicate. Try again";
        }
    }
    if (empty($despatch_from)) {
        $despatch_fromErr = "Required";
    }
    if (empty($lorry_no)) {
        $lorry_noErr = "Required";
    }
    if (empty($manifest_date)) {
        $manifest_dateErr = "Required";
    }
    if (empty($unload_date)) {
        $unload_dateErr = "Required";
    }
    if (empty($despatch_to)) {
        $despatch_toErr = "Required";
    }
    if (empty($driver_no_name)) {
        $driver_no_nameErr = "Required";
    }


    if (($manifest_noErr == "") && ($unload_dateErr == "") && ($despatch_fromErr == "") && ($lorry_noErr == "") && ($manifest_dateErr == "") && ($despatch_toErr == "") && ($driver_no_nameErr == "")) {
        $unload_shipInsertSQL .= "INSERT INTO unload_shipment VALUES('$id','$manifest_no','$manifest_date', '$unload_date','$despatch_from',";
        $unload_shipInsertSQL .= "'$despatch_to','$lorry_no','$driver_no_name','$login_user')";
        $unload_shipInsertStatus = connect_db()->cud($unload_shipInsertSQL);
        if ($unload_shipInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $shipErrors = array("Manifest_noErr" => $manifest_noErr, "Unload_dateErr" => $unload_dateErr, "Manifest_dateErr" => $manifest_dateErr, "Driver_noErr" => $driver_no_nameErr, "Despatch_fromErr" => $despatch_fromErr, "Despatch_toErr" => $despatch_toErr, "Lorry_noErr" => $lorry_noErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($shipErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT UNLOAD SHIPMENT ENDS ************************************ */
/* * *********************************** SEARCH UNLOAD SHIPMENT STARTS ************************************ */

if (isset($_REQUEST['search_unload_shipment'])) {
    $manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['manifest_no'])));
    $manifest_existSQL = "SELECT * FROM unload_shipment WHERE UPPER(manifest_no)='$manifest_no'";
    $manifest_existCount = connect_db()->countEntries($manifest_existSQL);
    if ($manifest_existCount > 0) {
        $manifestSQL = "SELECT * FROM unload_shipment WHERE UPPER(manifest_no) ='$manifest_no'";
        $manifest_fetch = json_decode(ret_json_str($manifestSQL));
        $records = "";
        $records .= "<table class='table table-bordered'>";
        $records .= "<thead>";
        $records .= "<th>MANIFEST NO</th><th>DESPATCH FROM</th><th>DESPATCH TO</th><th colspan='2'>OPTION</th>";
        $records .= "</thead>";
        $records .= "<tbody>";
        foreach ($manifest_fetch as $manifest_val) {
            $unload_id = $manifest_val->id;
            $countDespatchSQL = "SELECT * FROM despatch WHERE unload_id='$unload_id'";
            $despatchCount = connect_db()->countEntries($countDespatchSQL);
            $records .= "<tr>";
            $records .= "<td>" . $manifest_no . "</td><td>" . $manifest_val->despatch_from . "</td><td>" . $manifest_val->despatch_to . "</td>";
            $records .= "<td><a href=edit_unload_shipment.php?ship_id=" . $manifest_val->id . " class='btn btn-info'>EDIT</a></td>";
            $records .= "<td><a href=despatch_entry.php?ship_id=" . $manifest_val->id . " class='btn btn-warning'>";
            $records .= "DESPATCH ENTRY</a> No. of despatch entry : $despatchCount</td>";
            $records .= "</tr>";
        }
        $records .= "</tbody>";
        $records .= "</table>";
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** SEARCH UNLOAD SHIPMENT ENDS ************************************ */
/* * *********************************** UPDATE UNLOAD SHIPMENT STARTS ************************************ */
if (isset($_REQUEST['edit_unload_shipment'])) {
    $ship_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['ship_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['manifest_no']));
    $hmanifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['hmanifest_no']));
    $despatch_from = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_from']));
    $lorry_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['lorry_no']));
    $manifest_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['manifest_date']));
    $unload_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['unload_date']));
    $despatch_to = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_to']));
    $driver_no_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['driver_no_name']));

    if (empty($manifest_no)) {
        $manifest_noErr = "Required";
    } else {
        $dupmanifest_noSQL = "SELECT * FROM unload_shipment WHERE manifest_no='$manifest_no' AND manifest_no!='$hmanifest_no'";
        $dup_manifestCount = connect_db()->countEntries($dupmanifest_noSQL);
        if ($dup_manifestCount > 0) {
            $manifest_noErr = "Duplicate. Try again";
        }
    }
    if (empty($despatch_from)) {
        $despatch_fromErr = "Required";
    }
    if (empty($lorry_no)) {
        $lorry_noErr = "Required";
    }
    if (empty($unload_date)) {
        $unload_dateErr = "Required";
    }
    if (empty($manifest_date)) {
        $manifest_dateErr = "Required";
    }
    if (empty($despatch_to)) {
        $despatch_toErr = "Required";
    }
    if (empty($driver_no_name)) {
        $driver_no_nameErr = "Required";
    }


    if (($manifest_noErr == "") && ($unload_dateErr == "") && ($despatch_fromErr == "") && ($lorry_noErr == "") && ($manifest_dateErr == "") && ($despatch_toErr == "") && ($driver_no_nameErr == "")) {
        $unload_shipUpdateSQL .= "UPDATE unload_shipment SET manifest_no='$manifest_no', unload_date='$unload_date', manifest_date='$manifest_date', despatch_from='$despatch_from', ";
        $unload_shipUpdateSQL .= "despatch_to='$despatch_to', lorry_no='$lorry_no',driver_code='$driver_no_name', create_user='$login_user' WHERE id='$ship_id'";
        $unload_shipUnloadStatus = connect_db()->cud($unload_shipUpdateSQL);
        if ($unload_shipUnloadStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $shipErrors = array("Manifest_noErr" => $manifest_noErr, "Unload_dateErr" => $unload_dateErr, "Manifest_dateErr" => $manifest_dateErr, "Driver_noErr" => $driver_no_nameErr, "Despatch_fromErr" => $despatch_fromErr, "Despatch_toErr" => $despatch_toErr, "Lorry_noErr" => $lorry_noErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($shipErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE UNLOAD SHIPMENT ENDS ************************************ */
/* * *********************************** INSERT DESPATCH STARTS ************************************ */
if (isset($_REQUEST['add_despatch'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $unload_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['unload_id']));
    $booking_code = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['booking_code']));
    $bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['bilty_no']));
    $private_mark = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['private_mark']));
    $no_packets = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets']));
    $no_packets_received = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets_received']));
    $paid_topay = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['paid_topay']));
    $booking_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['booking_date']));
    $contents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['contents']));
    $dest_name_code = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['dest_name_code']));
    $paid_cod_amt = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['paid_cod_amt']));
    $weight = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['weight']));
    $consigner_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['consigner_name']));
    $consigner_gst = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['consigner_gst']));


    if (empty($booking_code)) {
        $booking_codeErr = "Required";
    }
    if (empty($bilty_no)) {
        $bilty_noErr = "Required";
    } else {
        $dupbilty_noSQL = "SELECT * FROM despatch WHERE bilty_no='$bilty_no' AND booking_code='$booking_code'";
        $dup_bilty_noCount = connect_db()->countEntries($dupbilty_noSQL);
        if ($dup_bilty_noCount > 0) {
            $bilty_noErr = "Duplicate bilty number for this booking code. Try again";
        }
    }

    if (empty($private_mark)) {
        $private_markErr = "Required";
    }
    if (empty($no_packets)) {
        $no_packetsErr = "Required";
    }
    if (empty($booking_date)) {
        $booking_dateErr = "Required";
    }
    if (empty($contents)) {
        $contentsErr = "Required";
    }
    if (empty($dest_name_code)) {
        $dest_name_codeErr = "Required";
    }
    if (empty($paid_cod_amt)) {
        $paid_cod_amtErr = "Required";
    }
    if (empty($weight)) {
        $weight = "0";
    }
    if (empty($no_packets_received)) {
        $no_packets_received = "0";
    }
    if (($bilty_noErr == "") && ($booking_codeErr == "") && ($private_markErr == "") && ($paid_cod_amtErr == "") && ($no_packetsErr == "") && ($booking_dateErr == "") && ($contentsErr == "") && ($dest_name_codeErr == "")) {
        $despatchInsertSQL .= "INSERT INTO despatch VALUES('$id','$unload_id','$booking_code','$booking_date','$bilty_no','$contents',";
        $despatchInsertSQL .= "'$private_mark','$no_packets', '$no_packets_received', '$weight', '$paid_topay', '$paid_cod_amt',";
        $despatchInsertSQL .= " '$dest_name_code', '$consigner_name', '$consigner_gst', '$login_user')";
        $despatchInsertStatus = connect_db()->cud($despatchInsertSQL);
        if ($despatchInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $despErrors = array("Bilty_noErr" => $bilty_noErr, "Booking_codeErr" => $booking_codeErr, "Paid_cod_amtErr" => $paid_cod_amtErr, "Private_markErr" => $private_markErr, "Packet_noErr" => $no_packagesErr, "Booking_dateErr" => $booking_dateErr, "ContentsErr" => $contentsErr, "Destination_nameErr" => $dest_name_codeErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($despErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT DESPATCH ENDS ************************************ */
/* * *********************************** SEARCH DESPATCH STARTS ************************************ */

if (isset($_REQUEST['search_despatch'])) {
    $manifest_bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['manifest_bilty_no'])));
    $despatch_existSQL .= "SELECT * FROM unload_shipment a INNER JOIN despatch b ON a.id=b.unload_id INNER JOIN mas_private_mark c ";
    $despatch_existSQL .= "ON b.private_mark_id=c.id WHERE UPPER(a.manifest_no)='$manifest_bilty_no' OR UPPER(b.bilty_no)='$manifest_bilty_no' ";
    $despatch_existSQL .= "OR UPPER(c.private_mark) LIKE '%$manifest_bilty_no%' OR UPPER(c.party_name) LIKE '%$manifest_bilty_no%'";
    $despatch_existCount = connect_db()->countEntries($despatch_existSQL);
    if ($despatch_existCount > 0) {
        $despatchSQL = "";
        $despatchSQL .= "SELECT b.id, a.manifest_no, b.bilty_no, b.payment_status, b.pay_cod_amt, b.consigner_name, b.consigner_gst, ";
        $despatchSQL .= "c.private_mark, c.party_name FROM unload_shipment a INNER JOIN despatch b ON a.id=b.unload_id INNER JOIN ";
        $despatchSQL .= "mas_private_mark c ON b.private_mark_id=c.id WHERE UPPER(a.manifest_no)='$manifest_bilty_no' OR ";
        $despatchSQL .= "UPPER(b.bilty_no)='$manifest_bilty_no' OR UPPER(c.private_mark) LIKE '%$manifest_bilty_no%' OR UPPER(c.party_name) LIKE '%$manifest_bilty_no%'";
        $despatch_fetch = json_decode(ret_json_str($despatchSQL));
        $records = "";
        $records .= "<table class='table table-bordered'>";
        $records .= "<thead>";
        $records .= "<th>GATEPASS ID</th><th>MANIFEST NO</th><th>BILTY NO</th><th>PRIVATE MARK</th><th>PARTY NAME</th><th>PAYMENT STATUS</th>";
        $records .= "<th>AMOUNT</th><th>CONSIGNER NAME</th><th>CONSIGNER GST</th><th colspan='3'>OPTION</th>";
        $records .= "</thead>";
        $records .= "<tbody>";
        foreach ($despatch_fetch as $despatch_val) {
            $despatch_id = $despatch_val->id;
            if ($despatch_val->payment_status == "P") {
                $paid_cod = "Paid";
            } else {
                $paid_cod = "To Pay";
            }
            $gatepass_idSQL = "SELECT * FROM gatepass WHERE despatch_id='$despatch_id'";
            $gatepassCount = connect_db()->countEntries($gatepass_idSQL);
            if ($gatepassCount > 0) {
                $gatepassid_fetch = json_decode(ret_json_str($gatepass_idSQL));
                foreach ($gatepassid_fetch as $gatepassid_val) {
                    $gatepass_id = $gatepassid_val->gatepass_id;
                }
            } else {
                $gatepass_id = "Not generated";
            }

            $records .= "<tr><td>" . $gatepass_id . "</td>";
            $records .= "<td>" . $despatch_val->manifest_no . "</td><td>" . $despatch_val->bilty_no . "</td><td>" . $despatch_val->private_mark . "</td><td>" . $despatch_val->party_name . "</td><td>" . $paid_cod . "</td>";
            $records .= "<td>" . $despatch_val->pay_cod_amt . "</td><td>" . $despatch_val->consigner_name . "</td><td>" . $despatch_val->consigner_gst . "</td>";
            $records .= "<td><a href=edit_despatch_entry.php?despatch_id=" . $despatch_val->id . " class='btn btn-info'>EDIT</a></td>";
            $records .= "<td><a href=delete_despatch_entry.php?despatch_id=" . $despatch_val->id . " class='btn btn-danger'>DELETE</a></td>";
            if ($despatch_val->payment_status == "C") {
                $records .= "<td><a href=gate_pass.php?despatch_id=" . $despatch_val->id . " class='btn btn-warning'>GATE PASS</a></td>";
            } else {
                $records .= "<td><button class='btn btn-danger' disabled='disabled'>GATEPASS NOT AVAILABLE</button<</td>";
            }
            $records .= "</tr>";
        }
        $records .= "</tbody>";
        $records .= "</table>";
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** SEARCH DESPATCH ENDS ************************************ */
/* * *********************************** UPDATE DESPATCH STARTS ************************************ */
if (isset($_REQUEST['edit_despatch'])) {
    $id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $unload_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['unload_id']));
    $booking_code = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['booking_code']));
    $bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['bilty_no']));
    $hbilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['hbilty_no']));
    $private_mark = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['private_mark']));
    $no_packets = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets']));
    $no_packets_recvd = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets_recvd']));
    $paid_topay = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['paid_topay']));
    $booking_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['booking_date']));
    $contents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['contents']));
    $dest_name_code = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['dest_name_code']));
    $paid_cod_amt = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['paid_cod_amt']));
    $weight = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['weight']));
    $consigner_name = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['consigner_name']));
    $consigner_gst = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['consigner_gst']));

    if (empty($booking_code)) {
        $booking_codeErr = "Required";
    }
    if (empty($bilty_no)) {
        $bilty_noErr = "Required";
    } else {
        $dupbilty_noSQL = "SELECT * FROM despatch WHERE bilty_no='$bilty_no' AND bilty_no!='$hbilty_no' AND booking_code='$booking_code'";
        $dup_bilty_noCount = connect_db()->countEntries($dupbilty_noSQL);
        if ($dup_bilty_noCount > 0) {
            $bilty_noErr = "Duplicate bilty number for this booking code. Try again";
        }
    }
    if (empty($private_mark)) {
        $private_markErr = "Required";
    }
    if (empty($no_packets)) {
        $no_packetsErr = "Required";
    }
    if (empty($booking_date)) {
        $booking_dateErr = "Required";
    }
    if (empty($contents)) {
        $contentsErr = "Required";
    }
    if (empty($dest_name_code)) {
        $dest_name_codeErr = "Required";
    }
    if (empty($paid_cod_amt)) {
        $paid_cod_amtErr = "Required";
    }
    if (empty($weight)) {
        $weight = "0.00";
    }
    if (empty($no_packets_recvd)) {
        $no_packets_recvd = "0";
    }
    if (($bilty_noErr == "") && ($booking_codeErr == "") && ($private_markErr == "") && ($paid_cod_amtErr == "") && ($no_packetsErr == "") && ($booking_dateErr == "") && ($contentsErr == "") && ($dest_name_codeErr == "")) {
        $despatchUpdateSQL .= "UPDATE despatch SET booking_code='$booking_code', booking_date='$booking_date', packet_quantity='$no_packets', packet_received='$no_packets_recvd',";
        $despatchUpdateSQL .= "bilty_no='$bilty_no', content_id='$contents', private_mark_id='$private_mark', weight='$weight', payment_status='$paid_topay', ";
        $despatchUpdateSQL .= "pay_cod_amt='$paid_cod_amt', destination='$dest_name_code', consigner_name='$consigner_name', ";
        $despatchUpdateSQL .= "consigner_gst='$consigner_gst', create_user='$login_user' WHERE id='$id'";
        $despatchUpdateStatus = connect_db()->cud($despatchUpdateSQL);
        if ($despatchUpdateStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $despErrors = array("Bilty_noErr" => $bilty_noErr, "Booking_codeErr" => $booking_codeErr, "Private_markErr" => $private_markErr, "Paid_cod_amtErr" => $paid_cod_amtErr, "Packet_noErr" => $no_packagesErr, "Booking_dateErr" => $booking_dateErr, "ContentsErr" => $contentsErr, "Destination_nameErr" => $dest_name_codeErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($despErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE DESPATCH ENDS ************************************ */
/* * *********************************** INSERT/UPDATE GATEPASS STARTS ************************************ */
if (isset($_REQUEST['gen_gatepass'])) {
    $despatch_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $way_bill_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['way_bill_no']));
    $cgst = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['cgst']));
    $payment_type = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['payment_type']));
    $gatepass_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['gatepass_date']));
    $received_amount = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['received_amount']));
    $sgst = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['sgst']));
    $cheque_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['cheque_no']));

    $dupbilty_noSQL = "SELECT * FROM gatepass WHERE despatch_id='$despatch_id'";
    $dupbilty_noCount = connect_db()->countEntries($dupbilty_noSQL);


    $gatepass_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['gatepass_id']));

    if (empty($sgst)) {
        $sgst = "0";
    }
    if (empty($cgst)) {
        $cgst = "0";
    }
    if (empty($way_bill_no)) {
        $way_bill_noErr = "Required";
    }
    if (empty($way_bill_no)) {
        $way_bill_noErr = "Required";
    }
    if (empty($payment_type)) {
        $payment_typeErr = "Required";
    }
    if (empty($gatepass_date)) {
        $gatepass_dateErr = "Required";
    }
    if (empty($received_amount)) {
        $received_amountErr = "Required";
    }

    if (($way_bill_noErr == "") && ($payment_typeErr == "") && ($received_amountErr == "") && ($gatepass_dateErr == "")) {
        $gatepassSQL = "";
        if ($dupbilty_noCount > 0) {
            $gatepassSQL .= "UPDATE gatepass SET way_bill_no='$way_bill_no', payment_type='$payment_type',cheque_no='$cheque_no', ";
            $gatepassSQL .= "received_amount='$received_amount', cgst='$cgst', sgst='$sgst', gatepass_date='$gatepass_date', create_user='$login_user' WHERE despatch_id='$despatch_id'";
        } else {
            $gatepassSQL .= "INSERT INTO gatepass VALUES(DEFAULT,'$despatch_id','$way_bill_no', '$payment_type',";
            $gatepassSQL .= "'$cheque_no','$received_amount','$cgst', '$sgst', '$gatepass_date', '$login_user')";
        }
        $gatpassStatus = connect_db()->cud($gatepassSQL);
        if ($gatpassStatus == true) {
            $bilty_noSQL = "SELECT * FROM gatepass WHERE despatch_id='$despatch_id'";
            $bilty_no_fetch = json_decode(ret_json_str($bilty_noSQL));
            foreach ($bilty_no_fetch as $bilty_no_val) {
                $gatepass_id = $bilty_no_val->gatepass_id;
            }
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved. The gatepass no. : " . $gatepass_id;
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $gpErrors = array("Gatepass_dateErr" => $gatepass_dateErr, "ReceivedAmtErr" => $received_amountErr, "Way_bill_noErr" => $way_bill_noErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($gpErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT/UPDATE GATEPASS ENDS ************************************ */

/* * *********************************** GENERATE GATEPASS STARTS ************************************ */

if (isset($_REQUEST['search_gatepass'])) {
    $gatepass_bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['gatepass_bilty_no'])));
    $gatepass_biltySQL .= "SELECT * FROM despatch a INNER JOIN gatepass b ON a.id=b.despatch_id INNER JOIN mas_private_mark c ON ";
    $gatepass_biltySQL .= "a.private_mark_id=c.id INNER JOIN mas_contents d ON a.content_id=d.id WHERE UPPER(a.bilty_no)='$gatepass_bilty_no' OR ";
    $gatepass_biltySQL .= " UPPER(b.gatepass_id)='$gatepass_bilty_no'";
    $gatepass_biltyCount = connect_db()->countEntries($gatepass_biltySQL);
    if ($gatepass_biltyCount > 0) {
        $gatepass_bilty_fetch = json_decode(ret_json_str($gatepass_biltySQL));
        foreach ($gatepass_bilty_fetch as $gatepass_bilty_val) {
            $booking_code = $gatepass_bilty_val->booking_code;
            $gatepass = $gatepass_bilty_val->gatepass_id;
            $gatepass_date = date("d / m / Y", strtotime($gatepass_bilty_val->gatepass_date));
            $private_mark = $gatepass_bilty_val->private_mark == "" ? "............" : $gatepass_bilty_val->private_mark;
            $gstin_aadhar = $gatepass_bilty_val->gstin_aadhar;
            $party_name = $gatepass_bilty_val->party_name == "" ? "............" : $gatepass_bilty_val->party_name;
            $cash_cheque = $gatepass_bilty_val->payment_type == "CA" ? "cash" : "cheque no. ";
            $cheque_no = $gatepass_bilty_val->cheque_no == "" ? "........................." : $gatepass_bilty_val->cheque_no;
            $booking_date = date("d / m / Y", strtotime($gatepass_bilty_val->booking_date));
            $bilty_no = $gatepass_bilty_val->bilty_no;
            $packet_no = $gatepass_bilty_val->packet_quantity . "/" . $gatepass_bilty_val->packet_received;
            $wbn = $gatepass_bilty_val->way_bill_no;
            $pay_cod_amt = $gatepass_bilty_val->pay_cod_amt;
            $weight = $gatepass_bilty_val->weight;
            $content_desc = $gatepass_bilty_val->contents_desc;

            $cgst_p = str_replace(",", "", number_format($gatepass_bilty_val->cgst, 2));
            $sgst_p = str_replace(",", "", number_format($gatepass_bilty_val->sgst, 2));
            $received_amount = str_replace(",", "", number_format($gatepass_bilty_val->received_amount, 2));

            $discount = str_replace(",", "", number_format($pay_cod_amt - $received_amount, 2));
            $cgst = str_replace(",", "", number_format(($pay_cod_amt * $cgst_p) / 100, 2));
            $sgst = str_replace(",", "", number_format(($pay_cod_amt * $sgst_p) / 100, 2));

            $tot_amount = str_replace(",", "", number_format($received_amount + $cgst + $sgst, 2));
            $tot_amount_words = number_words(str_replace(",", "", $tot_amount), 2);

            $gatepass_data = array("Booking_code" => $booking_code, "Gatepassno" => $gatepass, "GatepassDate" => $gatepass_date, "Party_name" => $party_name, "GSTIN" => $gstin_aadhar, "Amount" => $tot_amount, "Weight" => $weight, "Content" => $content_desc,
                "Amount_words" => $tot_amount_words, "Cash_cheque" => $cash_cheque, "Cheque_no" => $cheque_no, "BookingDate" => $booking_date, "PrivateMark" => $private_mark, "WayBillNo" => $wbn,
                "PacketNo" => $packet_no, "Biltyno" => $bilty_no, "CGST_P" => $cgst_p, "SGST_P" => $sgst_p, "CODAmountWH" => explode(".", $pay_cod_amt)[0], "CODAmountDC" => explode(".", $pay_cod_amt)[1] == null ? "00" : explode(".", $pay_cod_amt)[1],
                "CGSTWH" => explode(".", $cgst)[0], "CGSTDC" => explode(".", $cgst)[1] == null ? "00" : explode(".", $cgst)[1], "SGSTWH" => explode(".", $sgst)[0], "SGSTDC" => explode(".", $sgst)[1] == null ? "00" : explode(".", $sgst)[1],
                "RecvAmtWH" => explode(".", $received_amount)[0], "RecvAmtDC" => explode(".", $received_amount)[1] == null ? "00" : explode(".", $received_amount)[1], "TotWH" => explode(".", $tot_amount)[0], "TotDC" => explode(".", $tot_amount)[1] == null ? "00" : explode(".", $tot_amount)[1],
                "DiscountWH" => explode(".", $discount)[0], "DiscountDC" => explode(".", $discount)[1] == null ? "00" : explode(".", $discount)[1]);
        }
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = json_encode($gatepass_data);
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** GENERATE GATEPASS ENDS ************************************ */
/* * *********************************** MANIFEST NO REPORT STARTS ************************************ */

if (isset($_REQUEST['manifest_report'])) {
    $manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['manifest_no'])));
    $manifest_no_existSQL = "SELECT * FROM unload_shipment WHERE UPPER(manifest_no)='$manifest_no'";
    $manifest_noexistCount = connect_db()->countEntries($manifest_no_existSQL);
    if ($manifest_noexistCount > 0) {
        $manifest_noSQL = "SELECT * FROM unload_shipment WHERE UPPER(manifest_no)='$manifest_no'";
        $manifest_no_fetch = json_decode(ret_json_str($manifest_noSQL));
        $records = "";
        $records .= "<div id='printableArea'>";
        $records .= get_address();
        $records .= "<br/><table class='table' style='width:100%; text-align='left'>";
        $records .= "<thead>";
        foreach ($manifest_no_fetch as $manifest_no_val) {
            $records .= "<tr>";
            $records .= "<th>MANIFEST NO. : $manifest_no_val->manifest_no</th><th>MANIFEST DATE : $manifest_no_val->manifest_date</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th>DESPATCH FROM : $manifest_no_val->despatch_from</th><th>DESPATCH TO : $manifest_no_val->despatch_to</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th>LORRY NO. : $manifest_no_val->lorry_no</th><th>DRIVER CODE : $manifest_no_val->driver_code</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th colspan='2'>UNLOAD DATE : $manifest_no_val->unload_date</th>";
            $records .= "</tr>";
        }
        $records .= "</thead>";
        $records .= "</table><br /><br />";
        $records .= "<table class='table' border='1' cellspacing='0' cellpadding='10px' style='width:100%; text-align='left' font-size:12px;>";
        $records .= "<thead>";
        $records .= "<tr>";
        $records .= "<th>BILTY NO</th><th>BOOKING CODE</th><th>BOOKING DATE</th><th>CONTENTS</th><th>PARTY NAME</th><th>PRIVATE MARK</th>";
        $records .= "<th>TOTAL NO. OF PACKAGES</th><th>WEIGHT (in KG)</th><th>TO PAY</th><th>PAID</th><th>DESTINATION</th>";
        $records .= "</tr>";
        $records .= "</thead>";
        $manifestbilty_noSQL .= "SELECT a.booking_code, a.booking_date, a.bilty_no, d.contents_desc contents, c.private_mark, c.party_name, a.packet_quantity, a.weight, a.pay_cod_amt, ";
        $manifestbilty_noSQL .= "a.destination, a.payment_status, a.packet_received FROM despatch a INNER JOIN unload_shipment b on a.unload_id=b.id INNER JOIN mas_private_mark c ON ";
        $manifestbilty_noSQL .= "a.private_mark_id=c.id INNER JOIN mas_contents d ON a.content_id=d.id WHERE UPPER(b.manifest_no)='$manifest_no'";
        $manifestbilty_no_fetch = json_decode(ret_json_str($manifestbilty_noSQL));
        $records .= "<tbody>";
        $tot_no_pck = 0;
        $tot_no_pck_recvd = 0;
        $weight_packet = 0;
        $to_pay = 0;
        $paid = 0;
        foreach ($manifestbilty_no_fetch as $manifestbilty_no_val) {
            $pac_quan = $manifestbilty_no_val->packet_quantity;
            $pac_rec = $manifestbilty_no_val->packet_received;

            if ($pac_quan == $pac_rec) {
                $tot_no_pck_recvd += $manifestbilty_no_val->packet_received;
            } else {
                $tot_no_pck += $manifestbilty_no_val->packet_quantity;
                $tot_no_pck_recvd += $manifestbilty_no_val->packet_received;
            }

            $weight_packet += $manifestbilty_no_val->weight;
            $pay_stat = $manifestbilty_no_val->payment_status;
            if ($pay_stat == "C") {
                $codamt = "";
                $paidamt = "";
                $to_pay += $manifestbilty_no_val->pay_cod_amt;
                $codamt = $manifestbilty_no_val->pay_cod_amt;
            } else {
                $codamt = "";
                $paidamt = "";
                $paid += $manifestbilty_no_val->pay_cod_amt;
                $paidamt = $manifestbilty_no_val->pay_cod_amt;
            }

            if ($pac_rec == $pac_quan) {
                $v_packet = $pac_quan;
            } else {
                $v_packet = $pac_quan . "/" . $pac_rec;
            }
            if ($tot_no_pck_recvd == $tot_no_pck) {
                $v_tot_no_pck_recvd = $tot_no_pck;
            } else {
                $v_tot_no_pck_recvd =  $tot_no_pck_recvd;
            }
            $records .= "<tr>";
            $records .= "<td>$manifestbilty_no_val->bilty_no</td><td>$manifestbilty_no_val->booking_code</td><td>$manifestbilty_no_val->booking_date</td><td>$manifestbilty_no_val->contents</td>";
            $records .= "<td>$manifestbilty_no_val->party_name</td><td>$manifestbilty_no_val->private_mark</td><td align='right'>$v_packet</td><td align='right'>$manifestbilty_no_val->weight</td>";
            $records .= "<td align='right'>$codamt</td><td align='right'>$paidamt</td><td>$manifestbilty_no_val->destination</td>";
            $records .= "</tr>";
        }
        $records .= "<tr style='font-weight:bolder;'>";
        $records .= "<td colspan='6'>Grand Total </td>";
        $records .= "<td align='right'>$v_tot_no_pck_recvd</td><td align='right'>$weight_packet</td><td align='right'>$to_pay</td><td align='right'>$paid</td><td></td>";
        $records .= "</tr>";
        $records .= "<tr>";
        $records .= "<td colspan='6' valign='middle'>LOADED BY<br/><br/> SIGNATURE :  </td>";
        $records .= "<td colspan='6' valign='top'><center>FOR AMARJYOTI ROADLINK</center> <br/><br/> DATE:<br/>TIME: ";
        $records .= "<span style='float:right;'>SIGNATURE </span></td>";
        $records .= "</tr>";
        $records .= "</tbody>";

        $records .= "</table>";
        $records .= "</div>";

        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** MANIFEST NO REPORT ENDS ************************************ */
/* * *********************************** BILTY NO REPORT STARTS ************************************ */

if (isset($_REQUEST['bilty_no_report'])) {
    $bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['bilty_no'])));
    $bilty_no_existSQL = "SELECT * FROM despatch WHERE UPPER(bilty_no)='$bilty_no'";
    $bilty_no_existCount = connect_db()->countEntries($bilty_no_existSQL);
    if ($bilty_no_existCount > 0) {
        $mbilty_noSQL = "SELECT * FROM despatch a INNER JOIN unload_shipment b on a.unload_id=b.id  WHERE UPPER(a.bilty_no)='$bilty_no'";
        $mbilty_no_fetch = json_decode(ret_json_str($mbilty_noSQL));
        $records = "";
        $records .= "<div id='printableArea'>";
        $records .= get_address();
        $records .= "<br/><table class='table' style='width:100%; text-align='left'>";
        $records .= "<thead>";
        foreach ($mbilty_no_fetch as $mbilty_no_val) {
            $records .= "<tr>";
            $records .= "<th>MANIFEST NO. : $mbilty_no_val->manifest_no</th><th>MANIFEST DATE : $mbilty_no_val->manifest_date</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th>DESPATCH FROM : $mbilty_no_val->despatch_from</th><th>DESPATCH TO : $mbilty_no_val->despatch_to</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th>LORRY NO. : $mbilty_no_val->lorry_no</th><th>DRIVER CODE : $mbilty_no_val->driver_code</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th colspan='2'>UNLOAD DATE : $mbilty_no_val->unload_date</th>";
            $records .= "</tr>";
        }
        $records .= "</thead>";
        $records .= "</table><br /><br />";
        $records .= "<table class='table' border='1' cellspacing='0' cellpadding='10px' style='width:100%; text-align='left' font-size:12px;>";
        $records .= "<thead>";
        $records .= "<tr>";
        $records .= "<th>BILTY NO</th><th>BOOKING CODE</th><th>BOOKING DATE</th><th>CONTENTS</th><th>PARTY NAME</th><th>PRIVATE MARK</th>";
        $records .= "<th>TOTAL NO. OF PACKAGES</th><th>WEIGHT (in KG)</th>";
        $records .= "<th>TO PAY</th><th>PAID</th><th>DESTINATION</th>";
        $records .= "</tr>";
        $records .= "</thead>";
        $bilty_noSQL .= "SELECT a.booking_code, a.booking_date, a.bilty_no, d.contents_desc contents, c.private_mark, c.party_name, a.packet_quantity, a.weight, a.pay_cod_amt, ";
        $bilty_noSQL .= "a.destination, a.payment_status, a.packet_received FROM despatch a INNER JOIN unload_shipment b on a.unload_id=b.id INNER JOIN mas_private_mark c ON ";
        $bilty_noSQL .= "a.private_mark_id=c.id INNER JOIN mas_contents d ON a.content_id=d.id WHERE UPPER(a.bilty_no)='$bilty_no'";
        $bilty_no_fetch = json_decode(ret_json_str($bilty_noSQL));
        $records .= "<tbody>";
        $tot_no_pck = 0;
        $tot_no_pck_recvd = 0;
        $weight_packet = 0;
        $to_pay = 0;
        $paid = 0;
        foreach ($bilty_no_fetch as $bilty_no_val) {
            $pac_quan = $bilty_no_val->packet_quantity;
            $pac_rec = $bilty_no_val->packet_received;

            if ($pac_rec == $pac_quan) {
                $tot_no_pck_recvd += $bilty_no_val->packet_received;
            } else {
                $tot_no_pck += $bilty_no_val->packet_quantity;
                $tot_no_pck_recvd += $bilty_no_val->packet_received;
            }
            $weight_packet += $bilty_no_val->weight;
            $pay_stat = $bilty_no_val->payment_status;
            if ($pay_stat == "C") {
                $codamt = "";
                $paidamt = "";
                $to_pay += $bilty_no_val->pay_cod_amt;
                $codamt = $bilty_no_val->pay_cod_amt;
            } else {
                $codamt = "";
                $paidamt = "";
                $paid += $bilty_no_val->pay_cod_amt;
                $paidamt = $bilty_no_val->pay_cod_amt;
            }
            if ($pac_rec == $pac_quan) {
                $v_packet = $pac_quan;
            } else {
                $v_packet = $pac_quan . "/" . $pac_rec;
            }
            if ($tot_no_pck_recvd == $tot_no_pck) {
                $v_tot_no_pck_recvd = $tot_no_pck;
            } else {
                $v_tot_no_pck_recvd =  $tot_no_pck_recvd;
            }
            $records .= "<tr>";
            $records .= "<td>$bilty_no_val->bilty_no</td><td>$bilty_no_val->booking_code</td><td>$bilty_no_val->booking_date</td><td>$bilty_no_val->contents</td>";
            $records .= "<td>$bilty_no_val->party_name</td><td>$bilty_no_val->private_mark</td><td align='right'>$v_packet</td><td align='right'>$bilty_no_val->weight</td>";
            $records .= "<td align='right'>$codamt</td><td align='right'>$paidamt</td><td>$bilty_no_val->destination</td>";
            $records .= "</tr>";
        }
        $records .= "<tr style='font-weight:bolder;'>";
        $records .= "<td colspan='6'>Grand Total </td>";
        $records .= "<td align='right'>$v_tot_no_pck_recvd</td><td align='right'>$weight_packet</td><td align='right'>$to_pay</td><td align='right'>$paid</td><td></td>";
        $records .= "</tr>";
        $records .= "<tr>";
        $records .= "<td colspan='6' valign='middle'>LOADED BY<br/><br/> SIGNATURE :  </td>";
        $records .= "<td colspan='6' valign='top'><center>FOR AMARJYOTI ROADLINK</center> <br/><br/> DATE:<br/>TIME: ";
        $records .= "<span style='float:right;'>SIGNATURE </span></td>";
        $records .= "</tr>";
        $records .= "</tbody>";

        $records .= "</table>";
        $records .= "</div>";

        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** BILTY NO REPORT ENDS ************************************ */
/* * *********************************** MONTHLY PAID BILTY REPORT STARTS ************************************ */

if (isset($_REQUEST['paid_bilty_report'])) {
    $chk = 0;
    $ddr_id = date("YmdHis");
    $sub_no_pack = 0;
    $sub_no_pack_recvd = 0;
    $sub_wght = 0;
    $sub_topay = 0;

    $no_pack = 0;
    $no_pack_recvd = 0;
    $wght = 0;
    $sum_topay = 0;

    $counter = 0;

    $total_count = 0;

    $gen_month = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['gen_month'])));
    $page_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['last_no']))) - 1;
    $start_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['last_no'])));

    $fbook_month = date('Y-m-d', strtotime($gen_month));
    $tbook_month = date('Y-m-t', strtotime($gen_month));
    $book_month_existSQL = "SELECT * FROM despatch WHERE booking_date BETWEEN '$fbook_month' AND '$tbook_month' AND payment_status='P'";
    $book_monthexistCount = connect_db()->countEntries($book_month_existSQL);
    if ($book_monthexistCount > 0) {
        $book_monthSQL .= "SELECT a.bilty_no, a.booking_date, a.booking_code, c.private_mark, a.packet_quantity, a.weight, d.contents_desc contents, ";
        $book_monthSQL .= "a.payment_status, a.pay_cod_amt, a.packet_received FROM despatch a INNER JOIN mas_private_mark c ON a.private_mark_id=c.id INNER JOIN ";
        $book_monthSQL .= "mas_contents d ON a.content_id=d.id WHERE a.booking_date BETWEEN '$fbook_month' AND '$tbook_month' AND a.payment_status='P' ";
        $book_monthSQL .= "ORDER BY a.booking_date";
        $book_month_fetch = json_decode(ret_json_str($book_monthSQL));
        $records = "";
        $records .= "<div id='printableArea'>";
        $records .= "<table class='table table-bordered' border='0' cellspacing='0' cellpadding='10px' style='width:100%; text-align='left'>";
        $records .= "<thead><tr><th colspan='13'>" . get_address();
        $records .= "<center><b>Paid bilty report from " . date('d-m-Y', strtotime($fbook_month)) . " to " . date('d-m-Y', strtotime($tbook_month)) . "</center></b>";
        $records .= "</th></tr>";
        $records .= "<tr>";
        $records .= "<th>Sl. No.</th><th>G.R. No.</th><th>Booking date</th><th>From</th><th>Private Mark</th><th>Contents</th>";
        $records .= "<th>Total Packages</th><th>Weight (in KG)</th><th>Paid at booking office</th>";
        $records .= "</tr>";
        $records .= "</thead>";
        $records .= "<tbody>";
        foreach ($book_month_fetch as $book_month_val) {
            $counter++;
            $total_count++;
            $to_pay = 0;
            $to_pay = $book_month_val->pay_cod_amt;
            $no_pac = $book_month_val->packet_quantity;
            $no_pac_recvd = $book_month_val->packet_received;

            if ($no_pac == $no_pac_recvd) {
                $no_pack_received += $no_pac_recvd;
            } else {
                $no_pack += $no_pack;
                $no_pack_received += $no_pac_recvd;
            }
            $wght += $book_month_val->weight;
            $sum_topay += $to_pay;
            if ($no_pac_recvd == $no_pac) {
                $v_no_pac_recvd = $no_pac;
            } else {
                $v_no_pac_recvd = $no_pac . "/" . $no_pac_recvd;
            }
            $records .= "<tr>";
            $records .= "<td>$counter</td><td>$book_month_val->bilty_no</td><td>" . date('d-m-Y', strtotime($book_month_val->booking_date)) . "</td><td>$book_month_val->booking_code</td>";
            $records .= "<td>$book_month_val->private_mark</td><td>$book_month_val->contents</td><td align='right'>$v_no_pac_recvd</td>";
            $records .= "<td align='right'>$book_month_val->weight</td><td align='right'>$to_pay</td>";
            $records .= "</tr>";
            if ($total_count < $book_monthexistCount) {
                $sub_to_pay = $book_month_val->pay_cod_amt;
                $sub_no_pack += $book_month_val->packet_quantity;
                $sub_no_pack_recvd += $book_month_val->packet_received;
                $sub_wght += $book_month_val->weight;
                $sub_sum_topay += $sub_to_pay;
                if ($sub_no_pack_recvd == 0) {
                    $v_sub_no_pack_recvd = $sub_no_pack;
                } else {
                    $v_sub_no_pack_recvd = $sub_no_pack . "/" . $sub_no_pack_recvd;
                }
                if (($counter == 25) || ($counter == 0)) {
                    $page_no++;
                    $records .= "<tr style='font-weight:bold;'>";
                    $records .= "<td colspan='6'>SUB TOTAL<br/><span style='float:right;padding-top:5px;'>DDR$page_no</span></td>";
                    $records .= "<td align='right'>$v_sub_no_pack_recvd</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                    $records .= "</tr>";
                    $counter = 0;
                    $sub_no_pack = 0;
                    $sub_no_pack_recvd = 0;
                    $sub_wght = 0;
                    $sub_sum_topay = 0;
                }
            } else {
                $page_no++;
                $sub_to_pay = $book_month_val->pay_cod_amt;
                $sub_no_pack += $book_month_val->packet_quantity;
                $sub_no_pack_recvd += $book_month_val->packet_received;
                $sub_wght += $book_month_val->weight;
                $sub_sum_topay += $sub_to_pay;
                if ($sub_no_pack_recvd == $sub_no_pack) {
                    $v_sub_no_pack_recvd = $sub_no_pack;
                } else {
                    $v_sub_no_pack_recvd = $sub_no_pack . "/" . $sub_no_pack_recvd;
                }
                $records .= "<tr style='font-weight:bold;'>";
                $records .= "<td colspan='6'>SUB TOTAL</td>";
                $records .= "<td align='right'>$v_sub_no_pack_recvd</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                $records .= "</tr>";
                $chk = 1;
                $sub_no_pack = 0;
                $sub_no_pack_recvd = 0;
                $sub_wght = 0;
                $sub_sum_topay = 0;
            }
        }
        if ($no_pack_recvd == $no_pack) {
            $v_no_pack_recvd = $no_pack;
        } else {
            $v_no_pack_recvd = $no_pack . "/" . $no_pack_recvd;
        }
        $records .= "<tr style='font-weight:bold;'>";
        $records .= "<td colspan='6'>GRAND TOTAL</td>";
        $records .= "<td align='right'>$v_no_pack_recvd</td><td align='right'>$wght</td><td align='right'>" . str_replace(",", "", number_format($sum_topay, 2)) . "</td>";
        $records .= "</tr>";
        if ($chk == 1) {
            $records .= "<tr>";
            $records .= "<th colspan='14' style='border:0px;'>DDR$page_no<th>";
            $records .= "</tr>";
        }
        $records .= "</tbody>";
        $records .= "</table>";
        $records .= "</div>";
        $countddr = count_pb_ddr($fbook_month);
        if ($countddr == 0) {
            $ddrInsertSQL = "INSERT INTO ddr_generation_pb VALUES('$ddr_id','$fbook_month','$start_no','$page_no')";
            connect_db()->cud($ddrInsertSQL);
        }
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** MONTHLY PAID BILTY REPORT ENDS ************************************ */
/* * *********************************** MONTHLY REPORT GATEPASS STARTS ************************************ */

if (isset($_REQUEST['monthly_report'])) {
    $chk = 0;
    $ddr_id = date("YmdHis");
    $no_pack = 0;
    $sub_no_pack = 0;
    $no_pack_received = 0;
    $sub_no_pack_received = 0;
    $wght = 0;
    $sub_wght = 0;
    $sum_topay = 0;
    $sub_sum_topay = 0;
    $counter = 0;
    $total_count = 0;

    $gen_month = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['gen_month'])));
    $page_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['last_no']))) - 1;
    $start_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['last_no'])));

    $fbook_month = date('Y-m-d', strtotime($gen_month));
    $tbook_month = date('Y-m-t', strtotime($gen_month));

    $book_month_existSQL = "SELECT * FROM gatepass WHERE gatepass_date BETWEEN '$fbook_month' AND '$tbook_month'";
    $book_monthexistCount = connect_db()->countEntries($book_month_existSQL);
    if ($book_monthexistCount > 0) {
        $book_monthSQL .= "SELECT b.gatepass_id gatepass_no, a.bilty_no, a.booking_date, a.booking_code, c.private_mark, a.packet_quantity, ";
        $book_monthSQL .= "a.packet_received, a.weight, d.contents_desc contents, a.payment_status, a.pay_cod_amt, b.gatepass_date, ";
        $book_monthSQL .= "COALESCE(b.cgst,'0.00','') cgst, COALESCE(b.sgst,'0.00','') sgst, b.received_amount FROM despatch a INNER JOIN ";
        $book_monthSQL .= "gatepass b ON a.id=b.despatch_id INNER JOIN mas_private_mark c ON a.private_mark_id=c.id INNER JOIN mas_contents d ";
        $book_monthSQL .= "ON a.content_id=d.id WHERE b.gatepass_date BETWEEN '$fbook_month' AND '$tbook_month' ORDER BY b.gatepass_id";
        $book_month_fetch = json_decode(ret_json_str($book_monthSQL));
        $records = "";
        $records .= "<div id='printableArea'>";
        $records .= "<table class='table table-bordered' cellpadding='8' cellspacing='0' style='width:100%; padding-right:5px;'>";
        $records .= "<thead><tr><th colspan='14'>" . get_address();
        $records .= "<center><b>Monthly report from " . date('d-m-Y', strtotime($fbook_month)) . " to " . date('d-m-Y', strtotime($tbook_month)) . "</center></b>";
        $records .= "</th></tr>";
        $records .= "<tr>";
        $records .= "<th>M.R. No. </th><th>G.R. No.</th><th>Gatepass date</th><th>Booking date</th><th>From</th><th>Private Mark</th><th>Contents</th>";
        $records .= "<th>Total Packages</th><th>Weight (in KG)</th><th>Freight to pay</th><th style='font-weight:bold;'>Received freight</th><th>Service tax</th>";
        $records .= "<th>Total amount</th><th>Rebate</th>";
        $records .= "</tr>";
        $records .= "</thead>";
        $records .= "<tbody>";
        foreach ($book_month_fetch as $book_month_val) {
            $counter++;
            $total_count++;
            $to_pay = 0;
            $total_amount = 0;
            $sub_total_amount = 0;
            $service_tax = 0;
            $sub_service_tax = 0;
            $received_amount = 0;
            $sub_received_amount = 0;
            $discount = 0;
            $sub_discount = 0;
            $to_pay = $book_month_val->pay_cod_amt;
            $cgst_p = str_replace(",", "", number_format($book_month_val->cgst, 2));
            $sgst_p = str_replace(",", "", number_format($book_month_val->sgst, 2));
            $received_amount = str_replace(",", "", number_format($book_month_val->received_amount, 2));
            $cgst = str_replace(",", "", number_format(($to_pay * $cgst_p) / 100, 2));
            $sgst = str_replace(",", "", number_format(($to_pay * $sgst_p) / 100, 2));
            $service_tax = str_replace(",", "", number_format(($cgst + $sgst), 2));
            $total_amount = str_replace(",", "", number_format($received_amount + $service_tax, 2));
            $discount = str_replace(",", "", number_format($to_pay - $received_amount, 2));
            $total_amount = str_replace(",", "", number_format($received_amount + $service_tax, 2));
            $discount = str_replace(",", "", number_format($to_pay - $received_amount, 2));

            if ($book_month_val->packet_quantity == $book_month_val->packet_received) {
                $no_pack_received += $book_month_val->packet_received;
            } else {
                $no_pack += $book_month_val->packet_quantity;
                $no_pack_received += $book_month_val->packet_received;
            }

            $wght += $book_month_val->weight;
            $sum_topay += $to_pay;
            $sum_total_amount += $total_amount;
            $sum_service_tax += $service_tax;
            $sum_discount += $discount;
            $sum_received_amount += $received_amount;

            $pac_q = $book_month_val->packet_quantity;
            $pac_recvd = $book_month_val->packet_received;
            if ($pac_recvd == $pac_q) {
                $v_pack_quan = $pac_q;
            } else {
                $v_pack_quan = $pac_q . "/" . $pac_recvd;
            }

            $records .= "<tr>";
            $records .= "<td>$book_month_val->gatepass_no</td><td>$book_month_val->bilty_no</td><td>" . date('d-m-Y', strtotime($book_month_val->gatepass_date)) . "</td><td>" . date('d-m-Y', strtotime($book_month_val->booking_date)) . "</td>";
            $records .= "<td>$book_month_val->booking_code</td><td>$book_month_val->private_mark</td><td>$book_month_val->contents</td><td align='right'>$v_pack_quan</td>";
            $records .= "<td align='right'>$book_month_val->weight</td><td align='right'>$to_pay</td><td align='right' style='font-weight:bold;'>$received_amount</td><td align='right'>$service_tax</td><td align='right'>$total_amount</td><td align='right'>$discount</td>";
            $records .= "</tr>";
            if ($total_count < $book_monthexistCount) {
                if ($book_month_val->packet_quantity == $book_month_val->packet_received) {
                    $sub_no_pack_received += $book_month_val->packet_received;
                } else {
                    $sub_no_pack += $book_month_val->packet_quantity;
                    $sub_no_pack_received += $book_month_val->packet_received;
                }

                $sub_wght += $book_month_val->weight;
                $sub_topay = $book_month_val->pay_cod_amt;
                $sub_sum_topay += $sub_topay;
                $sub_received_amount = str_replace(",", "", number_format($book_month_val->received_amount, 2));
                $sub_sum_received_amount += $sub_received_amount;
                $sub_cgst_p = str_replace(",", "", number_format($book_month_val->cgst, 2));
                $sub_sgst_p = str_replace(",", "", number_format($book_month_val->sgst, 2));
                $sub_cgst = str_replace(",", "", number_format(($sub_topay * $sub_cgst_p) / 100, 2));
                $sub_sgst = str_replace(",", "", number_format(($sub_topay * $sub_sgst_p) / 100, 2));
                $sub_service_tax = str_replace(",", "", number_format(($sub_cgst + $sub_sgst), 2));
                $sub_sum_service_tax += $sub_service_tax;
                $sub_total_amount = str_replace(",", "", number_format($sub_received_amount + $sub_service_tax, 2));
                $sub_discount = str_replace(",", "", number_format($sub_topay - $sub_received_amount, 2));
                $sub_sum_discount += $sub_discount;
                $sub_sum_total_amount += $sub_total_amount;

                if ($sub_no_pack_received == $sub_no_pack_received) {
                    $v_sub_no_pack_received = $sub_no_pack;
                } else {
                    $v_sub_no_pack_received = $sub_no_pack . "/" . $sub_no_pack_received;
                }
                if (($counter == 24) || ($counter == 0)) {
                    $page_no++;
                    $records .= "<tr style='font-weight:bold;'>";
                    $records .= "<td colspan='7'>SUB TOTAL<br/><span style='float:right;padding-top:5px;'>DDR$page_no</span></td>";
                    $records .= "<td align='right'>$v_sub_no_pack_received</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                    $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_received_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_service_tax, 2)) . "</td>";
                    $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_total_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_discount, 2)) . "</td>";
                    $records .= "</tr>";
                    $counter = 0;
                    $sub_no_pack = 0;
                    $sub_no_pack_received = 0;
                    $sub_wght = 0;
                    $sub_sum_topay = 0;
                    $sub_sum_received_amount = 0;
                    $sub_sum_service_tax = 0;
                    $sub_sum_discount = 0;
                    $sub_sum_total_amount = 0;
                }
            } else {
                $page_no++;
                if ($book_month_val->packet_quantity == $book_month_val->packet_received) {
                    $sub_no_pack_received += $book_month_val->packet_received;
                } else {
                    $sub_no_pack += $book_month_val->packet_quantity;
                    $sub_no_pack_received += $book_month_val->packet_received;
                }
                $sub_wght += $book_month_val->weight;
                $sub_topay = $book_month_val->pay_cod_amt;
                $sub_sum_topay += $sub_topay;
                $sub_received_amount = str_replace(",", "", number_format($book_month_val->received_amount, 2));
                $sub_sum_received_amount += $sub_received_amount;
                $sub_cgst_p = str_replace(",", "", number_format($book_month_val->cgst, 2));
                $sub_sgst_p = str_replace(",", "", number_format($book_month_val->sgst, 2));
                $sub_cgst = str_replace(",", "", number_format(($sub_topay * $sub_cgst_p) / 100, 2));
                $sub_sgst = str_replace(",", "", number_format(($sub_topay * $sub_sgst_p) / 100, 2));
                $sub_service_tax = str_replace(",", "", number_format(($sub_cgst + $sub_sgst), 2));
                $sub_sum_service_tax += $sub_service_tax;
                $sub_total_amount = str_replace(",", "", number_format($sub_received_amount + $sub_service_tax, 2));
                $sub_discount = str_replace(",", "", number_format($sub_topay - $sub_received_amount, 2));
                $sub_sum_discount += $sub_discount;
                $sub_sum_total_amount += $sub_total_amount;
                if ($sub_no_pack_received == $sub_no_pack) {
                    $v_sub_no_pack_received = $sub_no_pack;
                } else {
                    $v_sub_no_pack_received = $sub_no_pack . "/" . $sub_no_pack_received;
                }
                $records .= "<tr style='font-weight:bold;'>";
                $records .= "<td colspan='7'>SUB TOTAL<br/></td>";
                $records .= "<td align='right'>$v_sub_no_pack_received</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_received_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_service_tax, 2)) . "</td>";
                $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_total_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_discount, 2)) . "</td>";
                $records .= "</tr>";
                $chk = 1;
                $sub_no_pack = 0;
                $sub_no_pack_received = 0;
                $sub_wght = 0;
                $sub_sum_topay = 0;
                $sub_sum_received_amount = 0;
                $sub_sum_service_tax = 0;
                $sub_sum_discount = 0;
                $sub_sum_total_amount = 0;
            }
        }
        if ($no_pack_received == $no_pack) {
            $vi_no_pack_received = $no_pack;
        } else {
            $vi_no_pack_received = $no_pack . "/" . $no_pack_received;
        }
        $records .= "<tr style='font-weight:bold;'>";
        $records .= "<td colspan='7'>GRAND TOTAL</td>";
        $records .= "<td align='right'>$vi_no_pack_received</td><td align='right'>$wght</td><td align='right'>" . str_replace(",", "", number_format($sum_topay, 2)) . "</td>";
        $records .= "<td align='right'>" . str_replace(",", "", number_format($sum_received_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sum_service_tax, 2)) . "</td>";
        $records .= "<td align='right'>" . str_replace(",", "", number_format($sum_total_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sum_discount, 2)) . "</td>";
        $records .= "</tr>";
        if ($chk == 1) {
            $records .= "<tr>";
            $records .= "<th colspan='14' style='border:0px;'>DDR$page_no<th>";
            $records .= "</tr>";
        }
        $records .= "</tbody>";
        $records .= "</table>";
        $records .= "</div>";
        $countddr = count_gp_ddr($fbook_month);
        if ($countddr == 0) {
            $ddrInsertSQL = "INSERT INTO ddr_generation_gp VALUES('$ddr_id','$fbook_month','$start_no','$page_no')";
            connect_db()->cud($ddrInsertSQL);
        }
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** MONTHLY REPORT GATEPASS ENDS ************************************ */
/* * *********************************** INSERT BRANCH SHIPMENT STARTS ************************************ */
if (isset($_REQUEST['add_branch_unload_shipment'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $source_manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['source_manifest_no']));
    $despatch_from = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_from']));
    $lorry_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['lorry_no']));
    $challan_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['challan_date']));
    $despatch_to = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_to']));

    if (empty($source_manifest_no)) {
        $source_manifest_no = "";
    }
    if (empty($despatch_from)) {
        $despatch_fromErr = "Required";
    }
    if (empty($lorry_no)) {
        $lorry_noErr = "Required";
    }
    if (empty($challan_date)) {
        $challan_dateErr = "Required";
    }
    if (empty($despatch_to)) {
        $despatch_toErr = "Required";
    }
    if (($challan_dateErr == "") && ($source_manifest_noErr == "") && ($despatch_fromErr == "") && ($lorry_noErr == "") && ($despatch_toErr == "")) {
        $count_branchSQL = "SELECT * FROM branch_unload_shipment";
        $count_branch = connect_db()->countEntries($count_branchSQL);
        $man = $count_branch + 1;
        $manifest_no = "MDP$man";
        $branch_unload_shipInsertSQL .= "INSERT INTO branch_unload_shipment VALUES('$id', '$source_manifest_no', '$challan_date','$manifest_no','$lorry_no', '$despatch_from',";
        $branch_unload_shipInsertSQL .= "'$despatch_to','$login_user')";
        $branch_unload_shipInsertStatus = connect_db()->cud($branch_unload_shipInsertSQL);
        if ($branch_unload_shipInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved. The manifest number generated is : " . $manifest_no;
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $branch_shipErrors = array("Source_manifestErr" => $source_manifest_noErr, "Challan_dateErr" => $challan_dateErr, "Despatch_fromErr" => $despatch_fromErr, "Despatch_toErr" => $despatch_toErr, "Lorry_noErr" => $lorry_noErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($branch_shipErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT BRANCH UNLOAD SHIPMENT ENDS ************************************ */

/* * *********************************** SEARCH BRANCH UNLOAD SHIPMENT STARTS ************************************ */

if (isset($_REQUEST['search_branch_unload_shipment'])) {
    $manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['manifest_no'])));
    $manifest_existSQL = "SELECT * FROM branch_unload_shipment WHERE UPPER(manifest_no)='$manifest_no'";
    $manifest_existCount = connect_db()->countEntries($manifest_existSQL);
    if ($manifest_existCount > 0) {
        $manifestSQL = "SELECT * FROM branch_unload_shipment WHERE UPPER(manifest_no) = '$manifest_no'";
        $manifest_fetch = json_decode(ret_json_str($manifestSQL));
        $records = "";
        $records .= "<table class='table table-bordered'>";
        $records .= "<thead>";
        $records .= "<th>MANIFEST NO</th><th>DESPATCH FROM</th><th>DESPATCH TO</th><th colspan='2'>OPTION</th>";
        $records .= "</thead>";
        $records .= "<tbody>";
        foreach ($manifest_fetch as $manifest_val) {
            $records .= "<tr>";
            $records .= "<td>" . $manifest_no . "</td><td>" . $manifest_val->despatch_from . "</td><td>" . $manifest_val->despatch_to . "</td>";
            $records .= "<td><a href=edit_branch_unload_shipment.php?branch_ship_id=" . $manifest_val->id . " class='btn btn-info'>EDIT</a></td>";
            $records .= "<td><a href=branch_despatch_entry.php?branch_ship_id=" . $manifest_val->id . " class='btn btn-warning'>DESPATCH ENTRY</a></td>";
            $records .= "</tr>";
        }
        $records .= "</tbody>";
        $records .= "</table>";
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** SEARCH BRANCH UNLOAD SHIPMENT ENDS ************************************ */
/* * *********************************** UPDATE BRANCH UNLOAD SHIPMENT STARTS ************************************ */
if (isset($_REQUEST['edit_branch_unload_shipment'])) {
    $branch_ship_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['branch_ship_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $source_manifest_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['source_manifest_no']));
    $despatch_from = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_from']));
    $lorry_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['lorry_no']));
    $challan_date = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['challan_date']));
    $despatch_to = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['despatch_to']));

    if (empty($source_manifest_no)) {
        $source_manifest_no = "";
    }
    if (empty($despatch_from)) {
        $despatch_fromErr = "Required";
    }
    if (empty($lorry_no)) {
        $lorry_noErr = "Required";
    }
    if (empty($challan_date)) {
        $challan_dateErr = "Required";
    }
    if (empty($despatch_to)) {
        $despatch_toErr = "Required";
    }
    if (($challan_dateErr == "") && ($source_manifest_noErr == "") && ($despatch_fromErr == "") && ($lorry_noErr == "") && ($despatch_toErr == "")) {
        $branch_unload_shipUpdateSQL .= "UPDATE branch_unload_shipment SET source_manifest_no='$source_manifest_no', challan_date ='$challan_date', ";
        $branch_unload_shipUpdateSQL .= "despatch_from='$despatch_from', despatch_to='$despatch_to', lorry_no='$lorry_no', create_user='$login_user' WHERE id='$branch_ship_id'";
        $branch_unload_shipUnloadStatus = connect_db()->cud($branch_unload_shipUpdateSQL);
        if ($branch_unload_shipUnloadStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $branch_shipErrors = array("Source_manifestErr" => $source_manifest_noErr, "Challan_dateErr" => $challan_dateErr, "Despatch_fromErr" => $despatch_fromErr, "Despatch_toErr" => $despatch_toErr, "Lorry_noErr" => $lorry_noErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($branch_shipErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE BRANCH UNLOAD SHIPMENT ENDS ************************************ */

/* * *********************************** INSERT BRANCH DESPATCH STARTS ************************************ */
if (isset($_REQUEST['add_branch_despatch'])) {
    $id = date("YmdHis");
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $branch_ship_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['branch_ship_id']));
    $bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['bilty_no']));
    $no_packets = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets']));
    $no_packets_recvd = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets_recvd']));
    $contents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['contents']));
    $weight = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['weight']));
    $booking_code = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['booking_code']));

    if (empty($booking_code)) {
        $booking_codeErr = "Required";
    }
    if (empty($bilty_no)) {
        $bilty_noErr = "Required";
    } else {
        $dupbilty_noSQL = "SELECT * FROM branch_despatch WHERE bilty_no='$bilty_no' AND booking_code='$booking_code'";
        $dup_bilty_noCount = connect_db()->countEntries($dupbilty_noSQL);
        if ($dup_bilty_noCount > 0) {
            $bilty_noErr = "Duplicate bilty no. for this booking code. Try again";
        }
    }if (empty($no_packets)) {
        $no_packetsErr = "Required";
    }
    if (empty($contents)) {
        $contentsErr = "Required";
    }
    if (empty($weight)) {
        $weight = "0";
    }
    if (empty($no_packets_recvd)) {
        $no_packets_recvd = "0";
    }
    if (($bilty_noErr == "") && ($booking_codeErr == "") && ($no_packetsErr == "") && ($contentsErr == "") && ($weightErr == "")) {
        $branchdespatchInsertSQL .= "INSERT INTO branch_despatch VALUES('$id','$branch_ship_id','$bilty_no','$booking_code', ";
        $branchdespatchInsertSQL .= "'$contents', '$no_packets', '$no_packets_recvd', '$weight', '$login_user')";
        $branchdespatchInsertStatus = connect_db()->cud($branchdespatchInsertSQL);
        if ($branchdespatchInsertStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $branchdespErrors = array("Booking_codeErr" => $booking_codeErr, "Bilty_noErr" => $bilty_noErr, "Packet_noErr" => $no_packagesErr, "WeightErr" => $weightErr, "ContentsErr" => $contentsErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($branchdespErrors);
    }
    echo json_encode($response);
}
/* * *********************************** INSERT BRANCH DESPATCH ENDS ************************************ */
/* * *********************************** SEARCH BRANCH DESPATCH STARTS ************************************ */

if (isset($_REQUEST['search_branch_despatch'])) {
    $manifest_bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['manifest_bilty_no'])));
    $despatch_existSQL .= "SELECT * FROM branch_unload_shipment a INNER JOIN branch_despatch b ON a.id=b.branch_unload_id WHERE ";
    $despatch_existSQL .= "UPPER(a.manifest_no) = '$manifest_bilty_no' OR UPPER(b.bilty_no)='$manifest_bilty_no'";
    $despatch_existCount = connect_db()->countEntries($despatch_existSQL);
    if ($despatch_existCount > 0) {
        $despatchSQL .= "SELECT b.id, a.manifest_no, b.bilty_no FROM branch_unload_shipment a INNER JOIN branch_despatch b ON ";
        $despatchSQL .= "a.id=b.branch_unload_id WHERE UPPER(a.manifest_no) = '$manifest_bilty_no' OR UPPER(b.bilty_no)='$manifest_bilty_no'";
        $branch_despatch_fetch = json_decode(ret_json_str($despatchSQL));
        $records = "";
        $records .= "<table class='table table-bordered'>";
        $records .= "<thead>";
        $records .= "<th>MANIFEST NO</th><th>BILTY NO</th><th colspan='2'>OPTION</th>";
        $records .= "</thead>";
        $records .= "<tbody>";
        foreach ($branch_despatch_fetch as $branch_despatch_val) {
            $records .= "<tr>";
            $records .= "<td>" . $branch_despatch_val->manifest_no . "</td><td>" . $branch_despatch_val->bilty_no . "</td>";
            $records .= "<td><a href=edit_branch_despatch_entry.php?branch_despatch_id=" . $branch_despatch_val->id . " class='btn btn-info'>EDIT</a></td>";
            $records .= "<td><a href=delete_branch_despatch_entry.php?branch_despatch_id=" . $branch_despatch_val->id . " class='btn btn-danger'>DELETE</a></td>";
            $records .= "</tr>";
        }
        $records .= "</tbody>";
        $records .= "</table>";
        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** SEARCH BRANCH DESPATCH ENDS ************************************ */
/* * *********************************** UPDATE BRANCH DESPATCH STARTS ************************************ */
if (isset($_REQUEST['edit_branch_despatch'])) {
    $branch_despatch_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['branch_despatch_id']));
    $branch_unload_id = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['branch_unload_id']));
    $login_user = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['login_user']));
    $bilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['bilty_no']));
    $hbilty_no = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['hbilty_no']));
    $no_packets = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets']));
    $no_packets_recvd = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['no_packets_recvd']));
    $contents = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['contents']));
    $weight = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['weight']));
    $booking_code = mysqli_real_escape_string(connect_db()->getConnection(), trim($_REQUEST['booking_code']));
    if (empty($booking_code)) {
        $booking_codeErr = "Required";
    }

    if (empty($bilty_no)) {
        $bilty_noErr = "Required";
    } else {
        $dupbilty_noSQL = "SELECT * FROM branch_despatch WHERE bilty_no='$bilty_no' AND bilty_no!='$hbilty_no' AND booking_code='$booking_code'";
        $dup_bilty_noCount = connect_db()->countEntries($dupbilty_noSQL);
        if ($dup_bilty_noCount > 0) {
            $bilty_noErr = "Duplicate bilty no. for this booking_code. Try again";
        }
    }
    if (empty($no_packets)) {
        $no_packetsErr = "Required";
    }

    if (empty($contents)) {
        $contentsErr = "Required";
    }
    if (empty($weight)) {
        $weight = "0";
    }
    if (empty($no_packets_recvd)) {
        $no_packets_recvd = "0";
    }
    if (($bilty_noErr == "") && ($booking_codeErr == "") && ($no_packetsErr == "") && ($contentsErr == "")) {
        $branchdespatchUpdateSQL .= "UPDATE branch_despatch SET bilty_no='$bilty_no', content_id='$contents', packet_quantity='$no_packets', ";
        $branchdespatchUpdateSQL .= "packet_received='$no_packets_recvd', weight='$weight', booking_code ='$booking_code', create_user='$login_user' WHERE id='$branch_despatch_id'";
        $branchdespatchUpdateStatus = connect_db()->cud($branchdespatchUpdateSQL);
        if ($branchdespatchUpdateStatus == true) {
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = "Successfully saved";
        } else {
            $response['error'] = true;
            $response['message'] = "Server error";
            $response['data'] = "Server error. Please try again later";
        }
    } else {
        $branchdespErrors = array("Booking_codeErr" => $booking_codeErr, "Bilty_noErr" => $bilty_noErr, "Packet_noErr" => $no_packagesErr, "ContentsErr" => $contentsErr);
        $response['error'] = true;
        $response['message'] = "Something went wrong";
        $response['data'] = json_encode($branchdespErrors);
    }
    echo json_encode($response);
}
/* * *********************************** UPDATE BRANCH DESPATCH ENDS ************************************ */

/* * *********************************** BRANCH REPORT STARTS ************************************ */

if (isset($_REQUEST['branch_report'])) {
    $branch_rep_cred = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['branch_rep_cred'])));
    $branch_rep_cred_existSQL .= "SELECT * FROM branch_unload_shipment WHERE UPPER(manifest_no)='$branch_rep_cred' ";
    $branch_rep_cred_existSQL .= "OR UPPER(lorry_no)='$branch_rep_cred' OR UPPER(despatch_to)='$branch_rep_cred'";
    $branch_rep_cred_noexistCount = connect_db()->countEntries($branch_rep_cred_existSQL);
    if ($branch_rep_cred_noexistCount > 0) {
        $branch_rep_credSQL .= "SELECT * FROM branch_unload_shipment WHERE UPPER(manifest_no)='$branch_rep_cred' ";
        $branch_rep_credSQL .= "OR UPPER(lorry_no)='$branch_rep_cred' OR UPPER(despatch_to)='$branch_rep_cred'";
        $branch_rep_fetch = json_decode(ret_json_str($branch_rep_credSQL));
        $records = "";
        $records .= "<div id='printableArea'>";
        $records .= get_address();
        $records .= "<br /><table class='table' style='width:100%; text-align='left'>";
        $records .= "<thead>";
        foreach ($branch_rep_fetch as $branch_rep_val) {
            $records .= "<tr>";
            $records .= "<th>MANIFEST NO. : $branch_rep_val->manifest_no</th><th>DESPATCH DATE : $branch_rep_val->challan_date</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th>DESPATCH FROM : $branch_rep_val->despatch_from</th><th>DESPATCH TO : $branch_rep_val->despatch_to</th>";
            $records .= "</tr>";
            $records .= "<tr>";
            $records .= "<th>LORRY NO. : $branch_rep_val->lorry_no</th>";
            $records .= "</tr>";
        }
        $records .= "</thead>";
        $records .= "</table><br /><br />";
        $records .= "<table class='table' border='1' cellspacing='0' cellpadding='10px' style='width:100%; text-align='left' font-size:12px;>";
        $records .= "<thead>";
        $records .= "<tr>";
        $records .= "<th>BILTY NO</th><th>BOOKING CODE</th><th>CONTENTS</th><th>TOTAL NO. OF PACKAGES</th><th>WEIGHT (in KG)</th>";
        $records .= "</tr>";
        $records .= "</thead>";
        $branchbilty_noSQL .= "SELECT a.bilty_no, a.booking_code, c.contents_desc contents, a.packet_quantity, a.packet_received, a.weight FROM branch_despatch a INNER JOIN ";
        $branchbilty_noSQL .= "branch_unload_shipment b on a.branch_unload_id=b.id INNER JOIN mas_contents c ON a.content_id=c.id ";
        $branchbilty_noSQL .= "WHERE UPPER(b.manifest_no)='$branch_rep_cred' OR UPPER(b.lorry_no)='$branch_rep_cred' OR UPPER(b.despatch_from)='$branch_rep_cred'";
        $branchbilty_no_fetch = json_decode(ret_json_str($branchbilty_noSQL));
        $records .= "<tbody>";

        $total_no_pck = 0;
        $pck_recvd = 0;
        $weight_packet = 0;
        foreach ($branchbilty_no_fetch as $branchbilty_no_val) {

            if ($branchbilty_no_val->packet_quantity == $branchbilty_no_val->packet_received) {
                $pck_recvd += $branchbilty_no_val->packet_received;
            } else {
                $total_no_pck += $branchbilty_no_val->packet_quantity;
                $pck_recvd += $branchbilty_no_val->packet_received;
            }

            $weight_packet += $branchbilty_no_val->weight;

            $packet_quant = $branchbilty_no_val->packet_quantity;
            $packet_rec = $branchbilty_no_val->packet_received;

            if ($packet_rec == $packet_quant) {
                $t_packet = $packet_quant;
            } else {
                $t_packet = $packet_quant . "/" . $packet_rec;
            }
            $records .= "<tr>";
            $records .= "<td>$branchbilty_no_val->bilty_no</td><td>$branchbilty_no_val->booking_code</td><td>$branchbilty_no_val->contents</td>";
            $records .= "<td align='right'>$t_packet</td><td align='right'>$branchbilty_no_val->weight</td>";
            $records .= "</tr>";
        }
        if ($pck_recvd == $total_no_pck) {
            $s_packet = $total_no_pck;
        } else {
            //$s_packet = $total_no_pck . "/" . $pck_recvd;
            $s_packet =  $pck_recvd;
        }
        $records .= "<tr style='font-weight:bolder;'>";
        $records .= "<td colspan='3'>Grand Total </td>";
        $records .= "<td align='right'>$s_packet</td><td align='right'>$weight_packet</td>";
        $records .= "</tr>";
        $records .= "<tr>";
        $records .= "<td colspan='3' valign='middle'>LOADED BY<br/><br/> SIGNATURE :  </td>";
        $records .= "<td colspan='3' valign='top'><center>FOR AMARJYOTI ROADLINK</center> <br/><br/> DATE:<br/>TIME: ";
        $records .= "<span style='float:right;'>SIGNATURE </span></td>";
        $records .= "</tr>";
        $records .= "</tbody>";

        $records .= "</table>";
        $records .= "</div>";

        $response['error'] = false;
        $response['message'] = "Success";
        $response['data'] = $records;
    } else {
        $response['error'] = true;
        $response['message'] = "Failed";
        $response['data'] = "No records found";
    }

    echo json_encode($response);
}
/* * *********************************** BRANCH REPORT ENDS ************************************ */

if (isset($_REQUEST['dest_code'])) {
    $dest_code = $_REQUEST['destination_code'];
    if ($dest_code == "") {
        $pend_gp_clase = "";
        $get_dest_code = "all";
    } else {
        $pend_gp_clase = "AND a.destination='$dest_code'";
        $get_dest_code = $dest_code;
    }
    $local_gatepass_pendingSQL = "";
    $local_gatepass_pendingSQL .= "SELECT * FROM despatch a LEFT JOIN gatepass b ON a.id=b.despatch_id ";
    $local_gatepass_pendingSQL .= "WHERE a.payment_status='C' $pend_gp_clase  AND b.gatepass_id IS NULL";
    $local_gatepass_pending = connect_db()->countEntries($local_gatepass_pendingSQL);
    if ($local_gatepass_pending == 0) {
        $pending_gp_link = "#";
        $count = $local_gatepass_pending;
    } else {
        $pending_gp_link = "gatepass_pending.php?destination_code=$get_dest_code";
        $count = $local_gatepass_pending;
    }
    $response['error'] = false;
    $response['message'] = "Success";
    $response['data'] = $count;
    $response['link'] = $pending_gp_link;
    echo json_encode($response);
}


if (isset($_REQUEST['ddr_gp'])) {
    $gen_month = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['gen_month'])));

    $fbook_month = date('Y-m-d', strtotime($gen_month));
    $mnthExists = count_gp_ddr($gen_month);
    if ($mnthExists == 0) {
        $getenndnoSQL = "SELECT * FROM ddr_generation_gp WHERE gen_month = ('$fbook_month' - INTERVAL 1 MONTH)";
        $fetch_endno = json_decode(ret_json_str($getenndnoSQL));
        foreach ($fetch_endno as $fetch_endnoVal) {
            $getno = ($fetch_endnoVal->end_no) + 1;
        }
        $getEndno = $getno == "" ? "1" : $getno;
    } else {
        $getenndnoSQL = "SELECT * FROM ddr_generation_gp WHERE gen_month = $fbook_month";
        $fetch_endno = json_decode(ret_json_str($getenndnoSQL));
        foreach ($fetch_endno as $fetch_endnoVal) {
            $getEndno = $fetch_endnoVal->start_no;
        }
    }
    $response['error'] = false;
    $response['message'] = "Success";
    $response['data'] = $getEndno;
    echo json_encode($response);
}

if (isset($_REQUEST['ddr_pb'])) {
    $gen_month = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['gen_month'])));

    $fbook_month = date('Y-m-d', strtotime($gen_month));
    $mnthExists = count_gp_ddr($gen_month);
    if ($mnthExists == 0) {
        $getenndnoSQL = "SELECT * FROM ddr_generation_pb WHERE gen_month = ('$fbook_month' - INTERVAL 1 MONTH)";
        $fetch_endno = json_decode(ret_json_str($getenndnoSQL));
        foreach ($fetch_endno as $fetch_endnoVal) {
            $getno = ($fetch_endnoVal->end_no) + 1;
        }
        $getEndno = $getno == "" ? "1" : $getno;
    } else {
        $getenndnoSQL = "SELECT * FROM ddr_generation_pb WHERE gen_month = $fbook_month";
        $fetch_endno = json_decode(ret_json_str($getenndnoSQL));
        foreach ($fetch_endno as $fetch_endnoVal) {
            $getEndno = $fetch_endnoVal->start_no;
        }
    }
    $response['error'] = false;
    $response['message'] = "Success";
    $response['data'] = $getEndno;
    echo json_encode($response);
}











/* * *********************************** MONTHLY REPORT GATEPASS STARTS ************************************ */

if (isset($_REQUEST['local_date_report'])) {
    $no_pack = 0;
    $sub_no_pack = 0;
    $no_pack_received = 0;
    $sub_no_pack_received = 0;
    $wght = 0;
    $sub_wght = 0;
    $sum_topay = 0;
    $sub_sum_topay = 0;
    $counter = 0;
    $total_count = 0;

    $page_no = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['ddr_no']))) - 1;
    $fbook_month = date("Y-m-d", strtotime(mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['fdate'])))));
    $tbook_month = date("Y-m-d", strtotime(mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['tdate'])))));
    $type = mysqli_real_escape_string(connect_db()->getConnection(), trim(strtoupper($_POST['type'])));
    if ($type == "P") {
        $book_month_existSQL = "SELECT * FROM despatch WHERE booking_date BETWEEN '$fbook_month' AND '$tbook_month' AND payment_status='P'";
        $book_monthexistCount = connect_db()->countEntries($book_month_existSQL);
        if ($book_monthexistCount > 0) {
            $book_monthSQL .= "SELECT a.bilty_no, a.booking_date, a.booking_code, c.private_mark, a.packet_quantity, a.weight, d.contents_desc contents, ";
            $book_monthSQL .= "a.payment_status, a.pay_cod_amt, a.packet_received FROM despatch a INNER JOIN mas_private_mark c ON a.private_mark_id=c.id INNER JOIN ";
            $book_monthSQL .= "mas_contents d ON a.content_id=d.id WHERE a.booking_date BETWEEN '$fbook_month' AND '$tbook_month' AND a.payment_status='P' ";
            $book_monthSQL .= "ORDER BY a.booking_date";
            $book_month_fetch = json_decode(ret_json_str($book_monthSQL));
            $records = "";
            $records .= "<div id='printableArea'>";
            $records .= "<table class='table table-bordered' border='0' cellspacing='0' cellpadding='10px' style='width:100%; text-align='left'>";
            $records .= "<thead><tr><th colspan='13'>" . get_address();
            $records .= "<center><b>Paid bilty report from " . date('d-m-Y', strtotime($fbook_month)) . " to " . date('d-m-Y', strtotime($tbook_month)) . "</center></b>";
            $records .= "</th></tr>";
            $records .= "<tr>";
            $records .= "<th>Sl. No.</th><th>G.R. No.</th><th>Booking date</th><th>From</th><th>Private Mark</th><th>Contents</th>";
            $records .= "<th>Total Packages</th><th>Weight (in KG)</th><th>Paid at booking office</th>";
            $records .= "</tr>";
            $records .= "</thead>";
            $records .= "<tbody>";
            foreach ($book_month_fetch as $book_month_val) {
                $counter++;
                $total_count++;
                $to_pay = 0;
                $to_pay = $book_month_val->pay_cod_amt;
                $no_pac = $book_month_val->packet_quantity;
                $no_pac_recvd = $book_month_val->packet_received;

                if ($no_pac == $no_pac_recvd) {
                    $no_pack_received += $no_pac_recvd;
                } else {
                    $no_pack += $no_pack;
                    $no_pack_received += $no_pac_recvd;
                }
                $wght += $book_month_val->weight;
                $sum_topay += $to_pay;
                if ($no_pac_recvd == $no_pac) {
                    $v_no_pac_recvd = $no_pac;
                } else {
                    $v_no_pac_recvd = $no_pac . "/" . $no_pac_recvd;
                }
                $records .= "<tr>";
                $records .= "<td>$counter</td><td>$book_month_val->bilty_no</td><td>" . date('d-m-Y', strtotime($book_month_val->booking_date)) . "</td><td>$book_month_val->booking_code</td>";
                $records .= "<td>$book_month_val->private_mark</td><td>$book_month_val->contents</td><td align='right'>$v_no_pac_recvd</td>";
                $records .= "<td align='right'>$book_month_val->weight</td><td align='right'>$to_pay</td>";
                $records .= "</tr>";
                if ($total_count < $book_monthexistCount) {
                    $sub_to_pay = $book_month_val->pay_cod_amt;
                    $sub_no_pack += $book_month_val->packet_quantity;
                    $sub_no_pack_recvd += $book_month_val->packet_received;
                    $sub_wght += $book_month_val->weight;
                    $sub_sum_topay += $sub_to_pay;
                    if ($sub_no_pack_recvd == 0) {
                        $v_sub_no_pack_recvd = $sub_no_pack;
                    } else {
                        $v_sub_no_pack_recvd = $sub_no_pack . "/" . $sub_no_pack_recvd;
                    }
                    if (($counter == 25) || ($counter == 0)) {
                        $page_no++;
                        $records .= "<tr style='font-weight:bold;'>";
                        $records .= "<td colspan='6'>SUB TOTAL<br/><span style='float:right;padding-top:5px;'>DDR$page_no</span></td>";
                        $records .= "<td align='right'>$v_sub_no_pack_recvd</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                        $records .= "</tr>";
                        $counter = 0;
                        $sub_no_pack = 0;
                        $sub_no_pack_recvd = 0;
                        $sub_wght = 0;
                        $sub_sum_topay = 0;
                    }
                } else {
                    $page_no++;
                    $sub_to_pay = $book_month_val->pay_cod_amt;
                    $sub_no_pack += $book_month_val->packet_quantity;
                    $sub_no_pack_recvd += $book_month_val->packet_received;
                    $sub_wght += $book_month_val->weight;
                    $sub_sum_topay += $sub_to_pay;
                    if ($sub_no_pack_recvd == $sub_no_pack) {
                        $v_sub_no_pack_recvd = $sub_no_pack;
                    } else {
                        $v_sub_no_pack_recvd = $sub_no_pack . "/" . $sub_no_pack_recvd;
                    }
                    $records .= "<tr style='font-weight:bold;'>";
                    $records .= "<td colspan='6'>SUB TOTAL</td>";
                    $records .= "<td align='right'>$v_sub_no_pack_recvd</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                    $records .= "</tr>";
                    $sub_no_pack = 0;
                    $sub_no_pack_recvd = 0;
                    $sub_wght = 0;
                    $sub_sum_topay = 0;
                    $chk = 1;
                }
            }
            if ($no_pack_recvd == $no_pack) {
                $v_no_pack_recvd = $no_pack;
            } else {
                $v_no_pack_recvd = $no_pack . "/" . $no_pack_recvd;
            }
            $records .= "<tr style='font-weight:bold;'>";
            $records .= "<td colspan='6'>GRAND TOTAL</td>";
            $records .= "<td align='right'>$v_no_pack_recvd</td><td align='right'>$wght</td><td align='right'>" . str_replace(",", "", number_format($sum_topay, 2)) . "</td>";
            $records .= "</tr>";
            if ($chk == 1) {
                $records .= "<tr>";
                $records .= "<th colspan='14' style='border:0px;'>DDR$page_no<th>";
                $records .= "</tr>";
            }
            $records .= "</tbody>";
            $records .= "</table>";
            $records .= "</div>";

            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = $records;
        } else {
            $response['error'] = true;
            $response['message'] = "Failed";
            $response['data'] = "No records found";
        }
    }
    if ($type == "C") {
        $book_month_existSQL = "SELECT * FROM gatepass WHERE gatepass_date BETWEEN '$fbook_month' AND '$tbook_month'";
        $book_monthexistCount = connect_db()->countEntries($book_month_existSQL);
        if ($book_monthexistCount > 0) {
            $book_monthSQL .= "SELECT b.gatepass_id gatepass_no, a.bilty_no, a.booking_date, a.booking_code, c.private_mark, a.packet_quantity, ";
            $book_monthSQL .= "a.packet_received, a.weight, d.contents_desc contents, a.payment_status, a.pay_cod_amt, b.gatepass_date, ";
            $book_monthSQL .= "COALESCE(b.cgst,'0.00','') cgst, COALESCE(b.sgst,'0.00','') sgst, b.received_amount FROM despatch a INNER JOIN ";
            $book_monthSQL .= "gatepass b ON a.id=b.despatch_id INNER JOIN mas_private_mark c ON a.private_mark_id=c.id INNER JOIN mas_contents d ";
            $book_monthSQL .= "ON a.content_id=d.id WHERE b.gatepass_date BETWEEN '$fbook_month' AND '$tbook_month' ORDER BY b.gatepass_id";
            $book_month_fetch = json_decode(ret_json_str($book_monthSQL));
            $records = "";
            $records .= "<div id='printableArea'>";
            $records .= "<table class='table table-bordered' cellpadding='8' cellspacing='0' style='width:100%; padding-right:5px;'>";
            $records .= "<thead><tr><th colspan='14'>" . get_address();
            $records .= "<center><b>Monthly report from " . date('d-m-Y', strtotime($fbook_month)) . " to " . date('d-m-Y', strtotime($tbook_month)) . "</center></b>";
            $records .= "</th></tr>";
            $records .= "<tr>";
            $records .= "<th>M.R. No. </th><th>G.R. No.</th><th>Gatepass date</th><th>Booking date</th><th>From</th><th>Private Mark</th><th>Contents</th>";
            $records .= "<th>Total Packages</th><th>Weight (in KG)</th><th>Freight to pay</th><th>Received freight</th><th>Service tax</th>";
            $records .= "<th>Total amount</th><th>Rebate</th>";
            $records .= "</tr>";
            $records .= "</thead>";
            $records .= "<tbody>";
            foreach ($book_month_fetch as $book_month_val) {
                $counter++;
                $total_count++;
                $to_pay = 0;
                $total_amount = 0;
                $sub_total_amount = 0;
                $service_tax = 0;
                $sub_service_tax = 0;
                $received_amount = 0;
                $sub_received_amount = 0;
                $discount = 0;
                $sub_discount = 0;
                $to_pay = $book_month_val->pay_cod_amt;
                $cgst_p = str_replace(",", "", number_format($book_month_val->cgst, 2));
                $sgst_p = str_replace(",", "", number_format($book_month_val->sgst, 2));
                $received_amount = str_replace(",", "", number_format($book_month_val->received_amount, 2));
                $cgst = str_replace(",", "", number_format(($to_pay * $cgst_p) / 100, 2));
                $sgst = str_replace(",", "", number_format(($to_pay * $sgst_p) / 100, 2));
                $service_tax = str_replace(",", "", number_format(($cgst + $sgst), 2));
                $total_amount = str_replace(",", "", number_format($received_amount + $service_tax, 2));
                $discount = str_replace(",", "", number_format($to_pay - $received_amount, 2));
                $total_amount = str_replace(",", "", number_format($received_amount + $service_tax, 2));
                $discount = str_replace(",", "", number_format($to_pay - $received_amount, 2));

                if ($book_month_val->packet_quantity == $book_month_val->packet_received) {
                    $no_pack_received += $book_month_val->packet_received;
                } else {
                    $no_pack += $book_month_val->packet_quantity;
                    $no_pack_received += $book_month_val->packet_received;
                }

                $wght += $book_month_val->weight;
                $sum_topay += $to_pay;
                $sum_total_amount += $total_amount;
                $sum_service_tax += $service_tax;
                $sum_discount += $discount;
                $sum_received_amount += $received_amount;

                $pac_q = $book_month_val->packet_quantity;
                $pac_recvd = $book_month_val->packet_received;
                if ($pac_recvd == $pac_q) {
                    $v_pack_quan = $pac_q;
                } else {
                    $v_pack_quan = $pac_q . "/" . $pac_recvd;
                }

                $records .= "<tr>";
                $records .= "<td>$book_month_val->gatepass_no</td><td>$book_month_val->bilty_no</td><td>" . date('d-m-Y', strtotime($book_month_val->gatepass_date)) . "</td><td>" . date('d-m-Y', strtotime($book_month_val->booking_date)) . "</td>";
                $records .= "<td>$book_month_val->booking_code</td><td>$book_month_val->private_mark</td><td>$book_month_val->contents</td><td align='right'>$v_pack_quan</td>";
                $records .= "<td align='right'>$book_month_val->weight</td><td align='right'>$to_pay</td><td align='right'>$received_amount</td><td align='right'>$service_tax</td><td align='right'>$total_amount</td><td align='right'>$discount</td>";
                $records .= "</tr>";
                if ($total_count < $book_monthexistCount) {
                    if ($book_month_val->packet_quantity == $book_month_val->packet_received) {
                        $sub_no_pack_received += $book_month_val->packet_received;
                    } else {
                        $sub_no_pack += $book_month_val->packet_quantity;
                        $sub_no_pack_received += $book_month_val->packet_received;
                    }

                    $sub_wght += $book_month_val->weight;
                    $sub_topay = $book_month_val->pay_cod_amt;
                    $sub_sum_topay += $sub_topay;
                    $sub_received_amount = str_replace(",", "", number_format($book_month_val->received_amount, 2));
                    $sub_sum_received_amount += $sub_received_amount;
                    $sub_cgst_p = str_replace(",", "", number_format($book_month_val->cgst, 2));
                    $sub_sgst_p = str_replace(",", "", number_format($book_month_val->sgst, 2));
                    $sub_cgst = str_replace(",", "", number_format(($sub_topay * $sub_cgst_p) / 100, 2));
                    $sub_sgst = str_replace(",", "", number_format(($sub_topay * $sub_sgst_p) / 100, 2));
                    $sub_service_tax = str_replace(",", "", number_format(($sub_cgst + $sub_sgst), 2));
                    $sub_sum_service_tax += $sub_service_tax;
                    $sub_total_amount = str_replace(",", "", number_format($sub_received_amount + $sub_service_tax, 2));
                    $sub_discount = str_replace(",", "", number_format($sub_topay - $sub_received_amount, 2));
                    $sub_sum_discount += $sub_discount;
                    $sub_sum_total_amount += $sub_total_amount;

                    if ($sub_no_pack_received == $sub_no_pack_received) {
                        $v_sub_no_pack_received = $sub_no_pack;
                    } else {
                        $v_sub_no_pack_received = $sub_no_pack . "/" . $sub_no_pack_received;
                    }
                    if (($counter == 25) || ($counter == 0)) {
                        $page_no++;
                        $records .= "<tr style='font-weight:bold;'>";
                        $records .= "<td colspan='7'>SUB TOTAL<br/><span style='float:right;padding-top:5px;'>DDR$page_no</span></td>";
                        $records .= "<td align='right'>$v_sub_no_pack_received</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                        $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_received_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_service_tax, 2)) . "</td>";
                        $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_total_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_discount, 2)) . "</td>";
                        $records .= "</tr>";
                        $counter = 0;
                        $sub_no_pack = 0;
                        $sub_no_pack_received = 0;
                        $sub_wght = 0;
                        $sub_sum_topay = 0;
                        $sub_sum_received_amount = 0;
                        $sub_sum_service_tax = 0;
                        $sub_sum_discount = 0;
                        $sub_sum_total_amount = 0;
                    }
                } else {
                    $page_no++;
                    if ($book_month_val->packet_quantity == $book_month_val->packet_received) {
                        $sub_no_pack_received += $book_month_val->packet_received;
                    } else {
                        $sub_no_pack += $book_month_val->packet_quantity;
                        $sub_no_pack_received += $book_month_val->packet_received;
                    }
                    $sub_wght += $book_month_val->weight;
                    $sub_topay = $book_month_val->pay_cod_amt;
                    $sub_sum_topay += $sub_topay;
                    $sub_received_amount = str_replace(",", "", number_format($book_month_val->received_amount, 2));
                    $sub_sum_received_amount += $sub_received_amount;
                    $sub_cgst_p = str_replace(",", "", number_format($book_month_val->cgst, 2));
                    $sub_sgst_p = str_replace(",", "", number_format($book_month_val->sgst, 2));
                    $sub_cgst = str_replace(",", "", number_format(($sub_topay * $sub_cgst_p) / 100, 2));
                    $sub_sgst = str_replace(",", "", number_format(($sub_topay * $sub_sgst_p) / 100, 2));
                    $sub_service_tax = str_replace(",", "", number_format(($sub_cgst + $sub_sgst), 2));
                    $sub_sum_service_tax += $sub_service_tax;
                    $sub_total_amount = str_replace(",", "", number_format($sub_received_amount + $sub_service_tax, 2));
                    $sub_discount = str_replace(",", "", number_format($sub_topay - $sub_received_amount, 2));
                    $sub_sum_discount += $sub_discount;
                    $sub_sum_total_amount += $sub_total_amount;
                    if ($sub_no_pack_received == $sub_no_pack) {
                        $v_sub_no_pack_received = $sub_no_pack;
                    } else {
                        $v_sub_no_pack_received = $sub_no_pack . "/" . $sub_no_pack_received;
                    }
                    $records .= "<tr style='font-weight:bold;'>";
                    $records .= "<td colspan='7'>SUB TOTAL<br/></td>";
                    $records .= "<td align='right'>$v_sub_no_pack_received</td><td align='right'>$sub_wght</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_topay, 2)) . "</td>";
                    $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_received_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_service_tax, 2)) . "</td>";
                    $records .= "<td align='right'>" . str_replace(",", "", number_format($sub_sum_total_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sub_sum_discount, 2)) . "</td>";
                    $records .= "</tr>";
                    $sub_no_pack = 0;
                    $sub_no_pack_received = 0;
                    $sub_wght = 0;
                    $sub_sum_topay = 0;
                    $sub_sum_received_amount = 0;
                    $sub_sum_service_tax = 0;
                    $sub_sum_discount = 0;
                    $sub_sum_total_amount = 0;
                    $chk = 1;
                }
            }
            if ($no_pack_received == $no_pack) {
                $vi_no_pack_received = $no_pack;
            } else {
                $vi_no_pack_received = $no_pack . "/" . $no_pack_received;
            }
            $records .= "<tr style='font-weight:bold;'>";
            $records .= "<td colspan='7'>GRAND TOTAL</td>";
            $records .= "<td align='right'>$vi_no_pack_received</td><td align='right'>$wght</td><td align='right'>" . str_replace(",", "", number_format($sum_topay, 2)) . "</td>";
            $records .= "<td align='right'>" . str_replace(",", "", number_format($sum_received_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sum_service_tax, 2)) . "</td>";
            $records .= "<td align='right'>" . str_replace(",", "", number_format($sum_total_amount, 2)) . "</td><td align='right'>" . str_replace(",", "", number_format($sum_discount, 2)) . "</td>";
            $records .= "</tr>";
            if ($chk == 1) {
                $records .= "<tr>";
                $records .= "<th colspan='14' style='border:0px;'>DDR$page_no<th>";
                $records .= "</tr>";
            }
            $records .= "</tbody>";
            $records .= "</table>";
            $records .= "</div>";
            $response['error'] = false;
            $response['message'] = "Success";
            $response['data'] = $records;
        } else {
            $response['error'] = true;
            $response['message'] = "Failed";
            $response['data'] = "No records found";
        }
    }


    echo json_encode($response);
}
/* * *********************************** MONTHLY REPORT GATEPASS ENDS ************************************ */
?>
