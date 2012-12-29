<?php
/*  Copyright 2006 Vincent Prat  (email : vpratfr@yahoo.fr)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
?>

<?php
	if (	!current_user_can(MAILUSERS_EMAIL_SINGLE_USER_CAP)
		|| 	!current_user_can(MAILUSERS_EMAIL_MULTIPLE_USERS_CAP)) {
		wp_die(__("You are not allowed to send emails to users.", MAILUSERS_I18N_DOMAIN));
	}

	get_currentuserinfo();
	$from_name = $user_identity;
	$from_address = $user_email;

	// Send the email if it has been requested
	if($_POST['send']=="true") {
	    // Analyse form input, check for blank fields
	    if ( !isset( $_POST['mail_format'] ) || trim($_POST['mail_format'])=='' ) {
		    $err_msg = $err_msg . __('You must specify the mail format.', MAILUSERS_I18N_DOMAIN) . '<br/>';
	    } else {
		    $mail_format = $_POST['mail_format'];
	    }

	    if ( !isset($_POST['send_users']) || !is_array($_POST['send_users']) || empty($_POST['send_users']) ) {
		    $err_msg = $err_msg . __('You must enter at least a recipient.', MAILUSERS_I18N_DOMAIN) . '<br/>';
	    } else {
		    $send_users = $_POST['send_users'];
	    }

	    if ( !isset( $_POST['subject'] ) || trim($_POST['subject'])=='' ) {
		    $err_msg = $err_msg . __('You must enter a subject.', MAILUSERS_I18N_DOMAIN) . '<br/>';
	    } else {
		    $subject = $_POST['subject'];
	    }

	    if ( !isset( $_POST['mailContent'] ) || trim($_POST['mailContent'])=='' ) {
		    $err_msg = $err_msg . __('You must enter some content.', MAILUSERS_I18N_DOMAIN) . '<br/>';
	    } else {
		    $mail_content = $_POST['mailContent'];
	    }

	    // If no error, we send the mail
	    if ( $err_msg=='' ) {
			// Fetch users
			// --
			$recipients = mailusers_get_recipients_from_ids($send_users, $user_ID);

			if (empty($recipients)) {
				$err_msg = $err_msg . _e('No recipients were found.', MAILUSERS_I18N_DOMAIN) . '<br/>';
			} else {
				$num_sent = mailusers_send_mail($recipients, $subject, $mail_content, $mail_format, $from_name, $from_address);
				if (false === $num_sent) {
					$err_msg = $err_msg . _e('There was a problem trying to send email to users.', MAILUSERS_I18N_DOMAIN) . '<br/>';
				} else if (0 === $num_sent) {
					$err_msg = $err_msg .  _e('No email has been sent to other users. This may be because no valid email addresses were found.', MAILUSERS_I18N_DOMAIN) . '<br/>';
				} else if ($num_sent > 0 && $num_sent == count($recipients)){
		?>
			    <div class="wrap">
				<div class="updated">
					<p><?php echo sprintf(__("Notification sent to %s user(s).", MAILUSERS_I18N_DOMAIN), $num_sent); ?></p>
				</div>
			    </div>
		<?php
				} else if ($num_sent > count($recipients)) {
					$err_msg = $err_msg .  _e('WARNING: More email has been sent than the number of recipients found.', MAILUSERS_I18N_DOMAIN) . '<br/>';
				} else {
					?>
			    <div class="wrap">
				<div class="updated">
				    <p class="updated">Email has been sent to <?php echo $num_sent; ?> users, but <?php echo count($recipients);?> recipients were originally found. Perhaps some users don't have valid email addresses?
				    </p>
				</div>
			    </div>
		<?php
				}
			}
	    }
	}

	if (!isset($send_users)) {
		$send_users = array();
	}

	if (!isset($mail_format)) {
		$mail_format = mailusers_get_default_mail_format();
	}

	if (!isset($subject)) {
		$subject = '';
	}

	if (!isset($mail_content)) {
		$mail_content = '';
	}
?>

<div class="wrap">
	<h2><?php _e('Write an email to individual users', MAILUSERS_I18N_DOMAIN); ?></h2>

	<?php 	if (isset($err_msg) && $err_msg!='') { ?>
			<p class="error"><?php echo $err_msg; ?></p>
			<p><?php _e('Please correct the errors displayed above and try again.', MAILUSERS_I18N_DOMAIN); ?></p>
	<?php	} ?>

	<form name="SendEmail" action="admin.php?page=email-users/email_users_user_mail_form.php" method="post">
		<input type="hidden" name="send" value="true" />
		<input type="hidden" name="fromName" value="<?php echo $from_name;?>" />
		<input type="hidden" name="fromAddress" value="<?php echo $from_address;?>" />

		<table class="form-table" width="100%" cellspacing="2" cellpadding="5">
		<tr>
			<th scope="row" valign="top"><?php _e('Mail format', MAILUSERS_I18N_DOMAIN); ?></th>
			<td><select name="mail_format" style="width: 158px;">
				<option value="html" <?php if ($mail_format=='html') echo 'selected="selected"'; ?>><?php _e('HTML', MAILUSERS_I18N_DOMAIN); ?></option>
				<option value="plaintext" <?php if ($mail_format=='plaintext') echo 'selected="selected"'; ?>><?php _e('Plain text', MAILUSERS_I18N_DOMAIN); ?></option>
			</select></td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label><?php _e('Sender', MAILUSERS_I18N_DOMAIN); ?></label></th>
			<td><?php echo $from_name;?> &lt;<?php echo $from_address;?>&gt;</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="send_users"><?php _e('Recipients', MAILUSERS_I18N_DOMAIN); ?>
			<br/><br/>
			<small><?php
				if (!current_user_can(MAILUSERS_EMAIL_MULTIPLE_USERS_CAP))
					_e('You are only allowed to select one user at a time.', MAILUSERS_I18N_DOMAIN);
				else
					_e('You can select multiple users by pressing the CTRL key.', MAILUSERS_I18N_DOMAIN);
				?>
			</small></label></th>
			<td>
				<select id="send_users" name="send_users[]" size="8" style="width: 654px; height: 250px;" <?php if (current_user_can(MAILUSERS_EMAIL_MULTIPLE_USERS_CAP)) echo 'multiple="multiple"'; ?> >
				<?php
					$users = mailusers_get_users($user_ID);
					foreach ($users as $user) {
				?>
					<option value="<?php echo $user->id; ?>" <?php
						echo (in_array($user->id, $send_users) ? ' selected="yes"' : '');?>>
						<?php echo __('User', MAILUSERS_I18N_DOMAIN) . ' - ' . $user->display_name; ?>
					</option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="subject"><?php _e('Subject', MAILUSERS_I18N_DOMAIN); ?></label></th>
			<td><input type="text" id="subject" name="subject" value="<?php echo format_to_edit($subject);?>" style="width: 647px;" /></td>
		</tr>
		<tr>
			<th scope="row" valign="top"><label for="mailContent"><?php _e('Message', MAILUSERS_I18N_DOMAIN); ?></label></th>
			<td><textarea rows="10" cols="80" name="mailContent" id="mailContent" style="width: 647px;"><?php echo stripslashes($mail_content);?></textarea>
			</td>
		</tr>
		</table>

		<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Send Email', MAILUSERS_I18N_DOMAIN); ?> &raquo;" />
		</p>
	</form>
</div>
