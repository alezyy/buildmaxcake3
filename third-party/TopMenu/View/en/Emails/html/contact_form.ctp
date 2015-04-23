<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<H1>User message from the topmenu's contact form:</H1>
<p><b>First Name:</b> <?php echo $first_name; ?></p>
<p><b>Last Name:</b> <?php echo $last_name; ?></p>
<p><b>eMail:</b> <?php echo $email; ?></p>
<p><b>Message:</b></p>
<p><?php echo $message; ?></p>

<?php
echo $this->element('email_footer_en');