<?
// *** Notification Bar - to appear at top of screen
//  
$notificationContent = "";
// 
// ** Notification Bar for login **
// 
// Checks to see if session is already started.
if(isset($_SESSION['view'])) {
    // Session cookie is already set, do not show welcome message.
    $_SESSION['view']=$_SESSION['view']+1;
} else {
    // Set to display welcome notification
    $notificationContent = 'login';
    $_SESSION['view']=1;
}
//
// ** Scripts for creating and controlling notification display **
//
if ($notificationContent == 'login') {
// Begin notification code for welcome login
?>
  <script type="text/javascript">
    // Checks browser and creates note.
    if(false){
      // Warning that browser is not compatible. Suggests upgrade.
      var browserMsg = '<?php echo $browserMsgTxt[$lang][1] ?> ' + BrowserDetect.browser + ' ' + BrowserDetect.version + '. <?php echo $browserMsgTxt[$lang][3] ?>';
    } else {
      // Generic welcome message displayed compatible users.
      var browserMsg = '<?php echo $browserMsgTxt[$lang][0] . ' ' . $user; ?>.';
    }
    // Ext function to show/hide notification
    Ext.onReady(function() {
      Ext.get('notification-bar').addClass('notification-note');
      Ext.get('notification-pull').addClass('notification-note');
      setTimeout(showNotificationOverlay,100);
      if(false){
        hideTimer = setTimeout( noShowNotificationOverlay,7000);
      } else {
        hideTimer = setTimeout( noShowNotificationOverlay,4000);
      }
    });
  </script>
<?
  // End notification code for welcome login
} else {
  // 
  // ** Begin notification for saving forms **
  // This is the primary use of the notification function
  /* POST['errorSave'] used by patienttabs
   * GET['mode'] used by config
   * Set the text on the page level.
   * TODO: See what other forms could use this and better abstract 
   * so it's not particular to these two types of forms.
   * 
   */
  if(isset($_POST['errorSave']) || isset($_GET['mode'])) {
    if(isset($_POST['errorSave'])) {
      $errorSave = $_POST['errorSave'];
    } else {
      $errorSave = $_GET['mode'];
    }
    if ($errorSave == '0' || $errorSave == 'save') {
      $notificationType = 'success';
      $notificationDefer = 3000;
    } elseif ($errorSave == '1') {
      $notificationType = 'failure';
      $notificationDefer = 7000;
    } else {
      $notificationType = 'note';
      $notificationDefer = 7000;
    }
  ?>
  <script type="text/javascript">
    // Ext function to show/hide notification
    Ext.onReady(function() {
      Ext.get('notification-bar').addClass('notification-<? echo $notificationType ?>');
      Ext.get('notification-pull').addClass('notification-<? echo $notificationType ?>');
      setTimeout(showNotificationOverlay,100);
      hideTimer = setTimeout( noShowNotificationOverlay,<? echo $notificationDefer ?>);
    });
  </script>
  <?php
  }
}
// End notification for saving forms
//
// ** Begin building Notification Bar **
?>
<div id="notification-bar">
  <a id="notification-push-button"><div class="original-icon-sprites original-icon-arrow-up"></div></a>
  <a id="notification-close">x</a>
  <?php
  if ($notificationContent == 'login') {
  // Notification used for login. notication-text hidden div is needed in case
  // someone logs in on a page that has its own notification message.
  ?>
    <div id="notification-text-login" class="notification-div">
    <script>
      document.write(browserMsg);
    </script>
    </div>
    <div id="notification-text" class="notification-div" style="display:none"></div>
  <?php
  } else {
  // Notification text created here via javascript create.child
  // which is set on each page you want to use notification
  ?>
    <div id="notification-text"></div>
  <?php
  }
  ?>
</div>
<a id="notification-pull-button"><div id="notification-pull"><div class="original-icon-sprites original-icon-arrow-down"></div></div></a>
<?php
// End building Notification Bar
// 
// Methods from animating notification
?>
<script type="text/javascript">
var showNotificationOverlay = function () {
  Ext.get('notification-bar').slideIn('t', {duration:0.5, easing:'easeOut'});
  Ext.get('notification-push-button').fadeIn('t', {duration:0.5, easing:'easeOut'});
}
var noShowNotificationOverlay = function () {
  Ext.get('notification-bar').slideOut('t', {duration:0.5, easing:'easeOut'});
  Ext.get('notification-push-button').setDisplayed(false);
  Ext.get('notification-pull').fadeIn('t', {duration:0.5, easing:'easeOut'});
}
Ext.get('notification-close').on('click', function(){
  var hideNotification = Ext.get('notification-bar');
  hideNotification.setDisplayed(false); // Does not animate the hide
  Ext.get('notification-pull').setDisplayed(false); // Does not animate the hide
})
Ext.get('notification-pull-button').on('click', function(){
  Ext.get('notification-bar').slideIn('t', {duration:0.5, easing:'easeOut'});
  Ext.get('notification-push-button').fadeIn('t', {duration:0.5, easing:'easeOut'});
  Ext.get('notification-pull').setDisplayed(false);

})
$("#notification-push-button").click(function() {
  noShowNotificationOverlay();
  clearTimeout(hideTimer);
});
</script>