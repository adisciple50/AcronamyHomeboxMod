<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 15/08/14
 * Time: 15:01
 */

/**
 *javescript:
 *ShrunkBoxes = list
 * foreach PortletShrinkCheckbox:
 *    if portletShrinkCheckbox = filled/true:
 *        Shrunkboxes.append(getElementId)
 *return ShrunkBoxes
 */
?>
    <!--loads user check boxes.-->
<?php $bs = $user->data->BoxSettings; print "<span class='CheckedBoxesList'>" . $bs . "</span>"; ?>
    <!-- function to save filledCheckboxData: -->
<?php
// the below function is redeclared twice. - heres the workaround...
if (!function_exists('saveBlockSizes')) {
    // ... proceed to declare your function
    function saveBlockSizes($BoxSettings){
// Make sure you are working with the fully loaded user object.
        $account = $user->uid;
        $edit['data']['BoxSettings'] = $BoxSettings;
        user_save($account, $edit);
    }
}
/** method 2 */
/** 1. create the database if it doesnt exist */
<?php
if(!db_table_exists('BoxSettings'))
{$table = array('uid' => '','CheckedBoxes' => '',);}
db_create_table('Boxsettings', $table);
?>
    /** 2. print users seetings to string */
<?php
$result = db_select('BoxSettings', 'n')->fields('CheckedBoxes')->condition('uid', $users->uid,'=')->execute()->fetchAssoc();
print "<span class='CheckedBoxesList'>" . $result[0] . $result[1] . "</span>"
?>
    /** 3. recieve post from page, and update user settings */
<?php
function updateBoxSettings(){
    $result = db_select('BoxSettings', 'n')->fields('CheckedBoxes')->condition('uid', $user->uid,'=')->execute()->fetchAssoc();
    $userID = $user->uid;
    if($result){
        db_update('BoxSettings')->fields(array('CheckedBoxes' => $_POST,))->condition('uid',$user->uid, '=')->execute();
    }
    else{
        db_insert('BoxSettings')->fields(array('uid' => $userID ,'CheckedBoxes' => $_POST,))->execute();
    }
}
