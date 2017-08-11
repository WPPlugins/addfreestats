<?php
/*
  Plugin Name: AFS Analytics
  Plugin URI: https://www.afsanalytics.com/
  Description: AFS Analytics offers one of the best real-time website analytics tool using the latest technologies. Easy to use! Easy to install
  Version: 3.18
  Author: AFS Analytics
  Author URI: https://www.afsanalytics.com/
  Text Domain: afs
  Domain Path: /languages
 */

class AddFreeStats_Plugin {

    var $version = "3.18";

    function init()
    {
         load_plugin_textdomain( 'afs', FALSE,  dirname( plugin_basename( __FILE__ ) ) . '/languages' );
 
    }
    
    
    function admin_menu() {

        add_submenu_page('options-general.php', __('AFS Analytics Plugin','afs'), __('AFS Analytics Settings','afs'), 'manage_options', __FILE__, array($this, 'plugin_menu'));
        add_menu_page('AFS Analytics', 'AFS Analytics', 'manage_options',  "afsanalytics", array($this, 'redirect_afs'), 'dashicons-chart-bar', '2.68');
        
        add_submenu_page( 'afsanalytics', __('Right now','afs'), __('Right now','afs'), 'manage_options','afsanalytics_rightnow',array($this, 'afs_rightnow'));
        add_submenu_page( 'afsanalytics', __('Plugin settings','afs'), __('Plugin settings','afs'), 'manage_options','afsanalytics_settings',array($this, 'plugin_menu'));
        add_submenu_page( 'afsanalytics', __('Manage Access keys','afs'), __('Manage Access keys','afs'), 'manage_options','afsanalytics_keys',array($this, 'afs_keys'));
        add_submenu_page( 'afsanalytics', __('Your account','afs'), __('Your account','afs'), 'manage_options','afsanalytics_profile',array($this, 'afs_profile'));
        add_submenu_page( 'afsanalytics', __('Manage Website(s)','afs'), __('Manage Website(s)','afs'), 'manage_options','afsanalytics_options',array($this, 'afs_options'));
        add_submenu_page( 'afsanalytics', __('Forgotten password','afs'), __('Forgotten password','afs'), 'manage_options','afsanalytics_password',array($this, 'afs_password'));
        add_submenu_page( 'afsanalytics', __('Upgrade to Premium','afs'), __('Upgrade to Premium','afs'), 'manage_options','afsanalytics_upgrade',array($this, 'afs_upgrade'));
        add_submenu_page( 'afsanalytics', __('Online Help','afs'), __('Online Help','afs'), 'manage_options','afsanalytics_help',array($this, 'afs_help'));
        add_submenu_page( 'afsanalytics', __('Contact Us','afs'), __('Contact Us','afs'), 'manage_options','afsanalytics_contact',array($this, 'afs_contact'));
            
        
    }

    function wp_footer() {
        //echo stripcslashes(get_option('afs_code'));

        $afs_account = stripcslashes(get_option('afs_account'));
        $afs_server = "";
        if ($afs_account > 99999)
            $afs_server = '1';
        if ($afs_account > 199999)
            $afs_server = '2';
        if ($afs_account > 299999)
            $afs_server = '3';
        if ($afs_account > 399999)
            $afs_server = '4';
        if ($afs_account > 499999)
            $afs_server = '5';
        if ($afs_account > 599999)
            $afs_server = '6';
        if ($afs_account > 699999)
            $afs_server = '7';
        if ($afs_account > 799999)
            $afs_server = '8';
        if ($afs_account > 899999)
            $afs_server = '9';
        if ($afs_account > 999999)
            $afs_server = '10';


        global $post;
$postID = get_the_ID();
       
        $trackerflag=0;           


        if (!isset($trackername))
        {
            $flagid=0;
            if (is_home()) 
            {
            $trackername = get_bloginfo('name');
            $trackerflag=1;
            }
            
            else
            {
                  if (is_attachment ($postID)==false && is_page ($postID)==false && is_single ($postID)==false) 
                  {    
                       $trackerflag=0;
                        
                  }
                  else
                  {
                     
                      if (isset($post->ID)) {
                         $postID = $post->ID;
                         $trackername = get_post_meta($postID, "afstrackername", true);
                         if (empty($trackername)) $trackername = $post->post_title;}
                         $trackerflag=1;
                  }
             }
                       
        }
        
        
        if (empty($trackername)) $trackerflag=0;
          
        if ( $trackerflag==1)
        {
            $trackername = stripslashes($trackername);
            if (strpos($trackername, '|') !== FALSE) $trackername = strstr($trackername, '|');
        }
        $trackername = addslashes($trackername);
        $trackername = trim($trackername);
        
        $autotrack_all= intval(get_option('afs_autotrack_all'));
        $autotrack_outbound= intval(get_option('afs_autotrack_outbound'));
        $autotrack_inside= intval(get_option('afs_autotrack_inside'));
        $autotrack_download= intval(get_option('afs_autotrack_download'));
        $autotrack_video= intval(get_option('afs_autotrack_video'));
        $autotrack_iframe= intval(get_option('afs_autotrack_iframe'));
        
        
$afs_code ="<!-- AFS Analytics V7- WordPress Plugin 3.14 -->\n";
$afs_code .="<script type=\"text/javascript\">(function(i,s,o,g,r,a,m){i['AfsAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//code.afsanalytics.com/js/analytics.js','aa');\n";
$afs_code .="aa(\"create\", \"$afs_account\",\"auto\");\n";
if ($trackerflag==1) $afs_code .="aa(\"set\",\"title\",\"$trackername\");\n";

if ($autotrack_all==0) $afs_code .="aa(\"set\", \"autotrack\", \"off\");\n";
if ($autotrack_all==1) $afs_code .="aa(\"set\", \"autotrack\", \"dataset\");\n";
if ($autotrack_all==2) $afs_code .="aa(\"set\", \"autotrack\", \"on\");\n";
if ($autotrack_outbound != $autotrack_all)
{
    if ($autotrack_outbound==0) $afs_code .="aa(\"set\", \"autotrack.outboundclick\", \"off\");\n";
    if ($autotrack_outbound==1) $afs_code .="aa(\"set\", \"autotrack.outboundclick\", \"dataset\");\n";
    if ($autotrack_outbound==2) $afs_code .="aa(\"set\", \"autotrack.outboundclick\", \"on\");\n";
}
if ($autotrack_inside != $autotrack_all)
{
    if ($autotrack_inside==0) $afs_code .="aa(\"set\", \"autotrack.insideclick\", \"off\");\n";
    if ($autotrack_inside==1) $afs_code .="aa(\"set\", \"autotrack.insideclick\", \"dataset\");\n";
    if ($autotrack_inside==2) $afs_code .="aa(\"set\", \"autotrack.insideclick\", \"on\");\n";
}

if ($autotrack_download != $autotrack_all)
{
    if ($autotrack_download==0) $afs_code .="aa(\"set\", \"autotrack.download\", \"off\");\n";
    if ($autotrack_download==1) $afs_code .="aa(\"set\", \"autotrack.download\", \"dataset\");\n";
    if ($autotrack_download==2) $afs_code .="aa(\"set\", \"autotrack.download\", \"on\");\n";
}

if ($autotrack_video != $autotrack_all)
{
    if ($autotrack_video==0) $afs_code .="aa(\"set\", \"autotrack.video\", \"off\");\n";
    if ($autotrack_video==1) $afs_code .="aa(\"set\", \"autotrack.video\", \"dataset\");\n";
    if ($autotrack_video==2) $afs_code .="aa(\"set\", \"autotrack.video\", \"on\");\n";
}


if ($autotrack_iframe != $autotrack_all)
{
    if ($autotrack_iframe==0) $afs_code .="aa(\"set\", \"autotrack.iframe\", \"off\");\n";
    if ($autotrack_iframe==1) $afs_code .="aa(\"set\", \"autotrack.iframe\", \"dataset\");\n";
    if ($autotrack_iframe==2) $afs_code .="aa(\"set\", \"autotrack.iframe\", \"on\");\n";
}



$afs_code .="aa(\"send\", \"pageview\");\n";
$afs_code .="</script>\n";
$afs_code .="<!-- End AFS Analytics -->\n";



        

        print $afs_code;
    }

    function account_ok($account) {

           
        if (empty($account) || intval($account)==0) {
        print "<div style='text-align:center'>";
        print "<p><b>";
        _e('You have to define the plugin settings!','afs');
        print "</b></p>";
        print "</div>"; 
        print "\n<script type='text/javascript'>\n";
	print "window.location.href='admin.php?page=afsanalytics_settings';\n";
	print "</script>\n";
        return(-1);
        } 
      return(0);
    }
        
      
    function redirect_afs() {
        $account = get_option('afs_account');
        if ($this->account_ok($account)==-1) return;
        $accesskey= get_option('afs_accesskey');
        $faccess=0;
               
        print "<div style='text-align:center'>";
        print "<p><b>";
        _e('Please be patient, AFS Analytics dashboard is loading ...','afs');
        print "</b></p>";
        print "</div>";
     
        print "<p><div style='text-align:center'>";
        
        if (empty($accesskey)==true || $accesskey=="none" || $accesskey=="NULL" || $accesskey=="null" || $accesskey=="NONE") 
        {
        print "<a href='https://www.afsanalytics.com/dashboard.php?usr=$account' target='_blank'>AFS Analytics dashboard</a>";
        }
        else 
        {
            print "<a href='https://www.afsanalytics.com/dashboard.php?accesskey=$accesskey' target='_blank'>AFS Analytics dashboard</a>";
            $faccess=1;
            
        }
        print "</p></div>";
        print "\n<script type='text/javascript'>\n";
        if ($faccess==0)
        {
        print "var usr=\"" . $account . "\";\n";
        print "window.location.href='https://www.afsanalytics.com/dashboard.php?usr='+usr;\n";
        }
        else {
        print "var accesskey=\"" .  $accesskey . "\";\n";
        print "window.location.href='https://www.afsanalytics.com/dashboard.php?accesskey='+accesskey;\n";    
            
        }
        print "</script>\n";
    }

    
     function afs_rightnow() {
        $account = get_option('afs_account');
        if ($this->account_ok($account)==-1) return;
        $accesskey= get_option('afs_accesskey');
        $faccess=0;
               
        print "<div style='text-align:center'>";
        print "<p><b>";
        _e('Please be patient, Right now dashboard is loading ...','afs');
        print "</b></p>";
        print "</div>";
     
        print "<p><div style='text-align:center'>";
        
        if (empty($accesskey)==true || $accesskey=="none" || $accesskey=="NULL" || $accesskey=="null" || $accesskey=="NONE") 
        {
        print "<a href='https://www.afsanalytics.com/rightnow.php?usr=$account' target='_blank'>Right Now</a>";
        }
        else 
        {
            print "<a href='https://www.afsanalytics.com/rightnow.php?accesskey=$accesskey' target='_blank'>Right Now</a>";
            $faccess=1;
            
        }
        print "</p></div>";
        print "\n<script type='text/javascript'>\n";
        if ($faccess==0)
        {
        print "var usr=\"" . $account . "\";\n";
        print "window.location.href='https://www.afsanalytics.com/rightnow.php?usr='+usr;\n";
        }
        else {
        print "var accesskey=\"" .  $accesskey . "\";\n";
        print "window.location.href='https://www.afsanalytics.com/rightnow.php?accesskey='+accesskey;\n";    
            
        }
        print "</script>\n";
    }
    
    function afs_go($url)
    {
        print "<div style='text-align:center'>";
        print "<p><b>";
        _e('Please be patient, AFS Analytics is loading ...','afs');
        print "</b></p>";
        print "</div>";
        print "\n<script type='text/javascript'>\n";
        print "window.location.href='$url';\n";    
        print "</script>\n";
    }
    
    function afs_keys() {
        
        $this->afs_go("https://www.afsanalytics.com/accesskeys.php");
    }
         
    function afs_profile() {
                
         $this->afs_go("https://www.afsanalytics.com/edprofile.php");
         }
    
     function afs_options() {
         $this->afs_go("https://www.afsanalytics.com/edaccounts.php");               
          }
    
     function afs_password() {
           $this->afs_go("https://www.afsanalytics.com?lostpass=1");                      
          }
    
    function afs_upgrade() {
          $this->afs_go("https://www.afsanalytics.com/pricing.php");     
               
    }
    
    function afs_help() {
          $this->afs_go("https://www.afsanalytics.com/articles/web-statistics-reports/");     
               
    }
      
     function afs_contact() {
          $this->afs_go("https://www.afsanalytics.com/contact.html");     
               
    }
    
    
    function add_trackerfield() {

        global $post;
        $postID = get_the_ID();
        if ($postID!=false)
        {
        $trackername = stripslashes(get_post_meta($postID, "afstrackername", true));
        print "<div>";
        print "<b>";
        _e('AFS Analytics tracker name','afs'); 
        //print ":&nbsp;&nbsp;$postID</b>";
        print ":&nbsp</b>";
        print "<input type=\"text\" name=\"afstrackername\" id=\"afstrackername\" size=40 placeholder=\"";
        _e('tracker name (optional)','afs');
        print "\" value=\"$trackername\"/>";
        print "</div>";
        }
    }

    function save_trackerfield() {
        global $post;
        $postID=get_the_ID();

        if ($postID!=false) {
                      
            if (isset($_POST['afstrackername']))
                $tracker = addslashes($_POST['afstrackername']);
            else
                $tracker = addslashes($_POST['post_title']);

           if (empty($tracker)) $tracker = $post->post_title;
            
            if (!empty($tracker)) {
                if (!add_post_meta($postID, 'afstrackername', $tracker, true)) {
                    update_post_meta($postID, 'afstrackername', $tracker);
                }
            }
        }
    }

    function plugin_menu() {
        $message = null;
        $message_updated = __("Data Saved!","afs");
        $message_empty = __("Error: AFS website ID number must be a 8 digits! ","afs");
        // update options

        if (!empty($_POST)) 
	{
            
		if ($_POST['afs_account']) 
                {
                
                    $accountstr=$_POST['afs_account'];
                    $accountstr=trim($accountstr);

                    if (strcasecmp($accountstr,"NULL")==0) update_option('afs_account',"");
                    else
                    {
                    $num=intval($accountstr);
                        if ($num==0) $message =  $message_empty;  
                        else
                         {
                            $accountstr=sprintf("%08d",$num);
                            update_option('afs_account',$accountstr);
                            $message = $message_updated;
                         }
                    } 
                }
		 
		if ($_POST['afs_accesskey']) 
               {
                   $accesskey=$_POST['afs_accesskey'];
                   $accesskey=trim($accesskey);
                   if (strcasecmp($accountstr,"NULL")==0) update_option('afs_accesskey',"");
                   else update_option('afs_accesskey', $accesskey);
               }
                
             
               
                if (isset($_POST['autotrack_all'])) update_option('afs_autotrack_all',$_POST['autotrack_all']);
                if (isset($_POST['autotrack_outbound'])) update_option('afs_autotrack_outbound',$_POST['autotrack_outbound']);
                if (isset($_POST['autotrack_inside'])) update_option('afs_autotrack_inside',$_POST['autotrack_inside']);
                if (isset($_POST['autotrack_download'])) update_option('afs_autotrack_download',$_POST['autotrack_download']);
                if (isset($_POST['autotrack_video'])) update_option('afs_autotrack_video',$_POST['autotrack_video']);
                if (isset($_POST['autotrack_iframe'])) update_option('afs_autotrack_iframe',$_POST['autotrack_iframe']);
               

		wp_cache_flush();
                       
        }   
        
        /*
        else
        {
        $message =  $message_empty;
        //update_option('afs_account', "");
        wp_cache_flush();
        }
       */
        
        
        
        ?>

        <?php if ($message) : ?>
            <div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
        <?php endif; ?>
        <div id="dropmessage" class="updated" style="display:none;"></div>
        
        <script type="text/javascript">
        function register()
        {
        <?php
        $sitename = get_bloginfo('name');
        $siteurl = get_bloginfo('url');
        $sitedes = get_bloginfo('description');
        $sitelang = get_bloginfo('language');
        $siteemail=get_bloginfo('admin_email');
        
        print "var sitename='$sitename';\n";
        print "var siteurl='$siteurl';\n";
        print "var sitedes= '$sitedes';\n";
        print "var siteemail='$siteemail';\n";
        print "var sitelang='$sitelang';\n";
        
        print "var gourl='https://www.afsanalytics.com/wpsignup.php?';\n";
        print "gourl+='&sitename='+encodeURIComponent(sitename);\n";
        print "gourl+='&siteurl='+encodeURIComponent(siteurl);\n";
        print "gourl+='&siteemail='+encodeURIComponent(siteemail);\n";
        print "gourl+='&sitelang='+encodeURIComponent(sitelang);\n";
        print "gourl+='&sitedes='+encodeURIComponent(sitedes);\n";
        ?>
        window.open(gourl,"AFS Analytics","width=450, height=500,toolbar=no, scrollbars=no, resizable=no, top=10,left=10");
        } 
        
        function SetAutotrack()
        {
        
	var all=document.getElementById('autotrack_all').value;
        document.getElementById('autotrack_outbound').value=all;
        document.getElementById('autotrack_inside').value=all;
        document.getElementById('autotrack_download').value=all;
        document.getElementById('autotrack_video').value=all;
        document.getElementById('autotrack_iframe').value=all;  
       }
        
        function SetAutotrackSub()
        {
        var a=document.getElementById('autotrack_outbound').value;
	var b=document.getElementById('autotrack_inside').value;
        var c=document.getElementById('autotrack_download').value;
        var d=document.getElementById('autotrack_video').value;
        var e=document.getElementById('autotrack_iframe').value;  
        if (parseInt(a)==1 || parseInt(b)==1 ||  parseInt(c)==1 || parseInt(d)==1 || parseInt(e)==1) document.getElementById('autotrack_all').value="1";
        if (parseInt(a)==2 || parseInt(b)==2 ||  parseInt(c)==2 || parseInt(d)==2 || parseInt(e)==2) document.getElementById('autotrack_all').value="2";
        }
         
        
        
        </script>
	
	<div class="wrap" style="width:600px; border: 1px solid #ddd;margin: 10px auto;padding: 15px">
	 <div style="text-align:center">
        <?php
        $plugdir = plugins_url();
        print "<a href='https://www.afsanalytics.com' target='_blank'><img src='$plugdir/addfreestats/logo.png'></a>\n";
        ?>
                <br>
                <h3>
       <?php _e('How to install AFS Analytics?','afs');?> 
                
                </h3>
            </div>
            <div style="text-align:left; padding-left:20px">
<?php 
                 _e('1 - New Website?','afs');  
                 print " <a href='javascript:register()'> ";
                 _e('Click here','afs'); 
                 print " </a> ";
                 _e('to get a Website ID','afs');  
                 print "<br>";
                 _e('2 - Type your Website ID into the Website ID field','afs');
                 print ".<br>";
                 _e("3 - Click on 'Update' button","afs");
                 print ".<br>";
                 _e('4 - AFS Analytics code will be inserted into the header','afs');
                 print ".<br>";                                  
                 
                 
               ?>
                
            </div>
       
            <div style="text-align:center">
                <h3>AFS Analytics Settings</h3>
            </div>
            <div style="text-align:center; padding-left:20px">
                <form name="dofollow" action="" method="post">
                    <table>
                        <tr>
                            <td scope="row" style="text-align:left; vertical-align:middle;"><?php _e('Website ID:','afs') ?></td>
                        <td><input type="text" size="30" placeholder="8 digits" id="afs_account" name="afs_account"  value="<?php echo stripcslashes(get_option('afs_account')); ?>"</td>
			<td><a onclick="javascript:document.getElementById('afs_account').value = 'NULL';" class="button button-secondary">Reset</a></td>
			</tr>

<tr>
                         <td scope="row" style="text-align:left; vertical-align:middle;">
			 <?php _e('<a href="https://www.afsanalytics.com/info/122/autotrack-automated-event-tracking.html" target="_blank">AutoTrack (general settings)</a>','afs');?> 
		         &nbsp;&nbsp;</td>
                         <td colspan="2" style="text-align:left; vertical-align:middle;">
                         <select onchange="SetAutotrack()" name="autotrack_all" id="autotrack_all"><?php
                         $autotrack_all= intval(get_option('afs_autotrack_all'));
                         if ($autotrack_all==0) print "<option value='0'selected>Off</option>";
                         else print "<option value='0'>Off</option>";
                         if ($autotrack_all==1) print "<option value='1' selected>Dataset</option>";
                         else print "<option value='1'>Dataset</option>";
                         if ($autotrack_all==2) print "<option value='2' selected>On</option>";
                         else print "<option value='2'>On</option>";?>
                         </select>
                         </td></tr>

                         <td scope="row" style="text-align:left; vertical-align:middle;">Outbound clicks tracking&nbsp;&nbsp;</td>
                         <td colspan="2" style="text-align:left; vertical-align:middle;">
                         <select onchange="SetAutotrackSub()" name="autotrack_outbound" id="autotrack_outbound"><?php
                         $autotrack_outbound= intval(get_option('afs_autotrack_outbound'));
                         if ($autotrack_outbound==0) print "<option value='0' selected>Off</option>";
                         else print "<option value='0'>Off</option>";
                         if ($autotrack_outbound==1) print "<option value='1' selected>Dataset</option>";
                         else print "<option value='1'>Dataset</option>";
                         if ($autotrack_outbound==2) print "<option value='2' selected>On</option>";
                         else print "<option value='2'>On</option>";?>
                         </select>
                         </td></tr>

                         <td scope="row" style="text-align:left; vertical-align:middle;">Inside clicks tracking&nbsp;&nbsp;</td>
                         <td colspan="2" style="text-align:left; vertical-align:middle;">
                         <select onchange="SetAutotrackSub()" name="autotrack_inside" id="autotrack_inside"><?php
                         $autotrack_inside= intval(get_option('afs_autotrack_inside'));
                         if ( $autotrack_inside==0) print "<option value='0' selected>Off</option>";
                         else print "<option value='0'>Off</option>";
                         if ( $autotrack_inside==1) print "<option value='1' selected>Dataset</option>";
                         else print "<option value='1'>Dataset</option>";
                         if ($autotrack_inside==2) print "<option value='2' selected>On</option>";
                         else print "<option value='2'>On</option>";?>
                         </select>
                         </td></tr>

                         <td scope="row" style="text-align:left; vertical-align:middle;">Download tracking&nbsp;&nbsp;</td>
                         <td colspan="2" style="text-align:left; vertical-align:middle;">
                         <select onchange="SetAutotrackSub()" name="autotrack_download" id="autotrack_download"><?php
                         $autotrack_download= intval(get_option('afs_autotrack_download'));
                         if ( $autotrack_download==0) print "<option value='0' selected>Off</option>";
                         else print "<option value='0'>Off</option>";
                         if ( $autotrack_download==1) print "<option value='1' selected>Dataset</option>";
                         else print "<option value='1'>Dataset</option>";
                         if ($autotrack_download==2) print "<option value='2' selected>On</option>";
                         else print "<option value='2'>On</option>";?>
                         </select>
                         </td></tr>
                     
                         <td scope="row" style="text-align:left; vertical-align:middle;">Video tracking&nbsp;&nbsp;</td>
                         <td colspan="2" style="text-align:left; vertical-align:middle;">
                         <select onchange="SetAutotrackSub()" name="autotrack_video" id="autotrack_video"><?php
                         $autotrack_video= intval(get_option('afs_autotrack_video'));
                         if ( $autotrack_video==0) print "<option value='0' selected>Off</option>";
                         else print "<option value='0'>Off</option>";
                         if ( $autotrack_video==1) print "<option value='1' selected>Dataset</option>";
                         else print "<option value='1'>Dataset</option>";
                         if ($autotrack_video==2) print "<option value='2' selected>On</option>";
                         else print "<option value='2'>On</option>";?>
                         </select>
                         </td></tr>
                    
                         <td scope="row" style="text-align:left; vertical-align:middle;">iframe tracking&nbsp;&nbsp;</td>
                         <td colspan="2" style="text-align:left; vertical-align:middle;">
                         <select onchange="SetAutotrackSub()" name="autotrack_iframe" id="autotrack_iframe"><?php
                         $autotrack_iframe= intval(get_option('afs_autotrack_iframe'));
                         if ( $autotrack_iframe==0) print "<option value='0' selected>Off</option>";
                         else print "<option value='0'>Off</option>";
                         if ( $autotrack_iframe==1) print "<option value='1' selected>Dataset</option>";
                         else print "<option value='1'>Dataset</option>";
                         if ($autotrack_iframe==2) print "<option value='2' selected>On</option>";
                         else print "<option value='2'>On</option>";?>
                         </select>
                         </td></tr>
              
                        <tr>
                        <td scope="row" style="text-align:left; vertical-align:middle;">
			<?php _e('<a href="https://www.afsanalytics.com/info/103/access-keys.html" target="_blank">Access Key(optional):</a>','afs');?>
			</td>
                        <td><input type="text" size="30" placeholder="Access key for automatic login" id="afs_accesskey" name="afs_accesskey"  value="<?php 						echo stripcslashes(get_option('afs_accesskey')); ?>"</td>
                        <td><a onclick="javascript:document.getElementById('afs_accesskey').value = 'NULL';" class="button button-secondary">Reset</a></td></tr>

                        
                    </table>
                    <div class="submit" style="text-align:center">
                        <input type="hidden" name="action" value="update" />
                        <input type="submit" name="Submit" class="button button-primary" style="cursor:pointer" value="<?php _e('Update','afs') ?>" />
                    </div>
                </form>


                <div style="text-align:left">
                    <p>
                       <?php 
                        
                       
                        _e('By default the tracker is invisible. You can select a','afs');
                        print " <a href='https://www.afsanalytics.com/info/33/change-the-afs-analytics-button-design.html' target='_blank'>";
                        _e('visible tracker','afs');
                        print ".</a> ";
                        _e('If you selected a visible tracker, you can specify exactly its location. You do this by adding this line:','afs'); 
                        print '<I>&ltdiv id="afsanalytics"&gt&lt/div&gt </I> '; 
                        _e('where you want it to show up.','afs'); 
                       ?>
                           </p>
                </div>


                <p>
<?php _e('<a title="Contact-us" href="https://www.afsanalytics.com/contact.html" target="_blank">Contact-us</a>','afs');?>
&nbsp;&nbsp;
<?php _e('<a title="AFS Analytics" href="https://www.afsanalytics.com" target="_blank">AFS Analytics</a>','afs');?>
&nbsp;&nbsp;
<?php _e('<a title="DataSense" href="https://www.datasense-analytics.com" target="_blank">DataSense</a>','afs');?>
                
                </p>
            </div>
        </div>
        <?php
    }

// plugin_menu
}

// Another_WordPress_Tracker_Plugin
$_awtp_plugin = new AddFreeStats_Plugin();
add_action('plugins_loaded', array($_awtp_plugin,'init'));
add_option("afs_account", null, '', 'yes');
add_option("afs_accesskey", 'none','', 'yes');
add_option("afs_autotrack_all", '2','', 'yes');
add_option("afs_autotrack_outbound", '2','', 'yes');
add_option("afs_autotrack_inside", '1','', 'yes');
add_option("afs_autotrack_download", '2','', 'yes');
add_option("afs_autotrack_video", '2','', 'yes');
add_option("afs_autotrack_iframe", '2','', 'yes');

//add_option("afs_code",null,'','yes');
add_action('admin_menu', array($_awtp_plugin, 'admin_menu'));
//add_action('wp_footer', array($_awtp_plugin, 'wp_footer'));
add_action('wp_head', array($_awtp_plugin, 'wp_footer'));
add_action('edit_form_after_title', array($_awtp_plugin, 'add_trackerfield'));
add_action('save_post', array($_awtp_plugin, 'save_trackerfield'));
?>
