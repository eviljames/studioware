<!-- Generates a file list and uses README or .README for footer and some vars in .config -->
<?php

$SHOWPARENTDIR="yes";
$SHOWMODTIME="yes";

if ( file_exists(".config") )
{
    include(".config");
}

chop ( $TITLE );
#if ( $TITLE == "" )
#{
#    $TITLE="&nbsp;";
#}

print "<head>\n";
print "<title>".$TITLE."</title>\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
print "<meta name=\"description\" content=\"Slackbuild Scripts\" />\n";
print "<link rel=\"stylesheet\" href=\"http://www.studioware.org/files/main.css\" />\n";
print "<link rel=\"stylesheet\" href=\"http://www.studioware.org/files/slackages.css\" />\n";
print "</head>\n";
print "<body>";
print "<div id=\"header\">";
print "<div id=\"header-left\">";
print "<img style=\"float: left; margin: 5px 5px 0px 5px;\" src=\"http://www.studioware.org/images/studioware_round_cropped2.gif\" />";
print "<h1>".$TITLE."</h1>\n";
print "</div>";
print "<img style=\"float: right; margin: 5px 15px 5px 0px;\" src=\"http://www.studioware.org/images/studioware_round_cropped2.gif\" />";
print "</div>";
print "<a style=\"color: #666; background-color: #eee; \" title=\"Home\" href=\"".$HOME."\">Home&nbsp;&nbsp;|&nbsp;</a>\n";

if($SHOWPARENTDIR == "yes")
{
        print "<a style=\"margin-left: 0px; color: #666; background-color: #eee;\" href=\"../\">Parent Directory</a><br /><br /><hr />";
}

$folder = "./";
$handle = opendir($folder);
$infofile = "";
$slackbuild = "";

if( file_exists("README") )
{
    $readme = file_get_contents("README");
    $br_text = str_replace("\n", "<br />", $readme) ;
    print "<p>$br_text</p>";
    print "<br /><hr /><p>";
    while ($file = readdir($handle))
    {
        if(strstr($file,'.info'))
        {
            $infofile = $file;
        }
        if(strstr($file,'.tar.gz'))
        {
            $slackbuild=$file;
        }
    }

    if ( $infofile != "")
    {
        $info = file_get_contents($infofile);
        $pass1 = explode("\n",$info);
        $pass2 = explode("=", $pass1[3]);
        $pass3 = explode("=", $pass1[5]);
        $pass4 = explode("=", $pass1[2]);
        $pass5 = explode("=", $pass1[4]);
        $pass6 = explode("=", $pass1[6]);
        $dl_name = basename (preg_replace("/\"/","", $pass2[1]));
        $dl_url = preg_replace("/\"/","", $pass2[1]);
        $md5 = preg_replace("/\"/","", $pass5[1]);
        $md564 = preg_replace("/\"/","", $pass6[1]);
        $dl_name64 = basename (preg_replace("/\"/","", $pass3[1]));
        $dl_url64 = preg_replace("/\"/","", $pass3[1]);
        $homepage = preg_replace("/\"/","", $pass4[1]);
        if ( $homepage != "" )
        {
            print "Homepage:&nbsp;&nbsp;&nbsp;&nbsp;<a href=$homepage>$homepage</a><br />";
        }
        if ( $dl_name != "" )
        {
            print "32 Bit Source:<a href=$dl_url>$dl_name</a>";
            print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;md5sum: " . $md5 . "<br />";
        }
        if ( $dl_name64 != "" )
        {
            print "64 Bit Source:\t<a href=$dl_url64>$dl_name64</a><br />";
            print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;md5sum: " . $md564 . "<br />";
        }
        if ( $slackbuild != "" )
        {
            print "SlackBuild:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=$slackbuild>$slackbuild</a><br />";
        }
    }
     print "</p><hr />";
}
 
print "<table width=\"100%\"><th width=\"25%\"><h2>File List</h2></th>\n";
print "<th width=\"15%\"></th>\n";
print "<th width=\"5%\"></th><th width=\"5%\"></th><th width=\"5%\"><br />&nbsp;</th></tr>\n";

rewinddir($handle);

while ($file = readdir($handle))
{
    if ( $file != $slackbuild && $file != ".htaccess" && $file != "index.php" && $file != "." && $file != ".README" && $file != ".config")
    {
        $files[] = $file;
    }
}

closedir($handle);

asort($files);

foreach ($files as $file  ) {

    if (is_dir($file) && $file != "..")
    {
        print "<tr><td width=\"100px\"><a href=$folder$file>$file/</a></td><td>directory</td><td></td><td></td</tr>";
    }
}

foreach ($files as $file  ) {

    if(!is_dir($file))
    {
        print "<tr><td width=\"35%\"><a href=$folder$file>$file</a></td><td align=\"right\">".filesize($file)."<td>Bytes</td>";
        if ($SHOWMODTIME="yes")
        {
            print "<td width=\"20%\" align=\"right\">".date ("F d Y H:i:s", filemtime($file))."</td";
        }
        print "</tr>";
    }
}

print "</table>";
print "<br />";
print "<hr />";
if( file_exists(".README") )
{
    $readme = file_get_contents(".README");
    $br_text = str_replace("\n", "<br />", $readme) ;
    print "<p>$br_text</p>";
    print "<hr />";
}

print "</body>";
print "</html>";
?>

