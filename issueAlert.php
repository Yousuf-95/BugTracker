<?php
/* generateEmail() returns the HTML for issue alert emails with issue specific Details
 * @parameter - title, description & resolution of the issue
 *              auth_id:- specific to the admin being notified
 *              $isReminder:- 0-Generates email for a "new issue, 1-Generates email for "reminder alerts"
*/
function generateEmail($title, $description, $resolution, $auth_id, $isReminder)
{
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>New Issue Created on AIS KB</title>

<style>body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  .container {
    padding: 0 !important; width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
}
</style></head>
<body style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; margin: 0;" bgcolor="#f6f6f6">
<table class="body-wrap" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;" bgcolor="#f6f6f6">
	<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
		<td style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" valign="top"></td>
		<td class="container" width="600" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
			<div class="content" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
				<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
					<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
						<td class="alert alert-warning" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 16px; color: #fff; font-weight: 500; border-radius: 3px 3px 0 0; margin: 0; padding: 20px;" align="center" bgcolor="#FF9F00" valign="top">
							';
$message .= $isReminder == 1? 'Approve Pending Issue' : 'Review New Issue';
$message .= '</td>
					</tr>
					<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
						<td class="content-wrap" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 20px;" valign="top">
							<table width="100%" cellpadding="0" cellspacing="0" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">
										<a href="http://localhost/kb/review.php?auth_id='.$auth_id.'" class="btn-primary" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; background-color: #348eda; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Review Issue</a>
									</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">
										<strong style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">Issue Details:</strong>
									</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">
										<strong style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">Title</strong>
									</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">'.$title.'</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">
										<strong style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">Description</strong>
									</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">'.$description.'</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">
										<strong style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">Resolution</strong>
									</td>
								</tr>
								<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; padding: 0 0 20px;" valign="top">'.$resolution.'</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div class="footer" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
					<table width="100%" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
						<tr style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
							<td class="aligncenter content-block" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 12px; color: #999; margin: 0; padding: 0 0 20px;" align="center" valign="top">AIS Knowledge Base</td>
						</tr>
					</table>
				</div></div>
		</td>
		<td style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" valign="top"></td>
	</tr>
</table>

</body>
</html>
';
return $message;
}
?>
