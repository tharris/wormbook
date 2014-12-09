#!/usr/bin/perl

use strict;
use CGI qw(:standard);


use constant RECIPIENT => 'wormbook-help@wormbase.org';

# This page called with the parameters:
#      from    - sender's e-mail address
#      subject - subject of mail message
#      remark  - body of e-mail message

my $where_from   = param('referer') || referer();
if (param('return') && $where_from && $where_from !~ /\/feedback/ ) {
  print redirect($where_from);
  exit 0;
}

print header();
print start_html(-title=>'WormBook Feedback',-style=>{src=>'/css/bookworm.css'});
print qq(<div id="container">);   # open div="container"
banner();

if (param('submit') && send_mail($where_from)) {
    print_confirmation();
} else {
    print start_form;
    print_instructions();
    print_form($where_from);
    print end_form;
}

print qq(</div>);  # close div="container"
footer();
print end_html();



sub banner {
    print <<END;
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
                <title>WormBook</title>
		<meta name="http-equiv" content="pragma:no-cache" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" href="/css/bookworm.css" />
<script language="JavaScript" type="text/javascript" src="/js/highlightTerms.js"></script>

</head>
<body>       
<div id="container"> 


<div id="fotocredit"><a href="/"><img alt="WormBook Header Image" src="/images/header_760x96.png" border="0" /> <span>Embryo series courtesy of Einhard Schierenberg</span></a></div>    <link rel="stylesheet" type="text/css" href="/css/wb_menu.css">
    <script src='/js/wb_menu.js' language='javascript' type='text/javascript'></script>
    
<table id="abc" border="0" cellpadding="0" cellspacing="0" width="760px">
 <tr bgcolor="#9932cc">
   <td onmouseover="showmenu('wbhome')" onmouseout="hidemenu('wbhome')" width="100" align="center">
   <a class="menu" href="/index.html">Home</a><br />
   <table class="menu" id="wbhome">
   </table>
  </td>
  
  <td onmouseover="showmenu('tutorials')" onmouseout="hidemenu('tutorials')" width="70">
   <a class="menu" href="/about.html">About</a><br />
   <table class="menu" id="tutorials">
   </table>
  </td>
  
     <td onmouseover="showmenu('contactwb')" onmouseout="hidemenu('contactwb')" width="95"><img src='/images/arrow14x14_blue_r.gif' width=14 height=14 border=0 align=absmiddle>
   <a class="menu">Contact</a><br />
   <table class="menu" id="contactwb">
   <tr><td class="menu"><a class="submenu" href="http://www.wormbase.org/forums/index.php?board=31.0">Discuss WormBook</a></td></tr>
   <tr><td class="menu"><a class="submenu" href="/announce.html">Sign up for e-alerts</a></td></tr>
   <tr><td class="menu"><a class="submenu" href="/db/misc/feedback">Send feedback</a></td></tr>
   </table>
  </td>
  
      <td onmouseover="showmenu('citewb')" onmouseout="hidemenu('citewb')" width="125">
   <a class="menu" href="/citewb.html">Cite WormBook</a><br />
   <table class="menu" id="citewb">
   </table>
  </td>
  
    <td onmouseover="showmenu('authorinstructions')" onmouseout="hidemenu('authorinstructions')" width="95">
   <a class="menu" href="/authorinfo.html">for Authors</a><br />
   <table class="menu" id="authorinstructions">
   </table>
  </td>
  
      <td onmouseover="showmenu('downloads')" onmouseout="hidemenu('downloads')" width="115"><img src='/images/arrow14x14_blue_r.gif' width=14 height=14 border=0 align=absmiddle>
   <a class="menu">Downloads</a><br />
   <table class="menu" id="downloads">
   <tr><td class="menu"><a class="submenu" href="http://dev.wormbook.org/WormBook.zip">Download all chapters</a></td></tr>
   <tr><td class="menu"><a class="submenu" href="/endnote/references.txt">Import EndNote citations</a></td></tr>
   <tr><td class="menu"><a class="submenu" href="/endnote/references_refman.txt">Import RefMan citations</a></td></tr>
   </table>
  </td>
  
  <td onmouseover="showmenu('sponsors')" onmouseout="hidemenu('sponsors')" width="85">
   <a class="menu" href="/sponsors.html">Sponsors</a><br />
   <table class="menu" id="sponsors">
   </table>
  </td>
  
  <td onmouseover="showmenu('usefullinks')" onmouseout="hidemenu('usefullinks')" width="75"><img src='/images/arrow14x14_blue_r.gif' width=14 height=14 border=0 align=absmiddle>
   <a class="menu">Links</a><br />
   <table class="menu" id="usefullinks">
   <tr><td class="menu"><a class="submenu" href="http://www.wormbase.org">WormBase</a></td></tr>
   <tr><td class="menu"><a class="submenu" href="http://www.wormatlas.org/">WormAtlas</a></td></tr>
   <tr><td class="menu"><a class="submenu" href="http://www.textpresso.org/">Textpresso</a></td></tr>
   </table>
  </td>
 </tr>
</table>
<div id="searchcheck" >
        <form action="/db/misc/search.cgi" method="post">
	<input type="checkbox" name="search_html" checked="checked" />&nbsp;HTML&nbsp;
    <input type="checkbox" name="search_preprints" checked="checked" />&nbsp;Preprints
	<input type="checkbox" name="search_pdf" />&nbsp;PDF
	          <input type="text" name="query" size="15" />
		          <input value="Search" type="submit" name="search" />
			        </form>
</div>
END
;
}


sub footer {

    print <<END;
<div id="someright">

    <p><a href="http://creativecommons.org/licenses/by/2.5/" target="_blank"><img class="floatLeft" border="0" src="/images/somerights20.gif" align="middle" alt="Creative Commons License"/></a>&nbsp;All WormBook content, except where otherwise noted, is licensed under a <a href="http://creativecommons.org/licenses/by/2.5/" title="Creative Commons Attribution License" target="_blank">Creative Commons Attribution License.</a>
<br></br>General information about WormBook on this page is copyrighted under the <a href="/db/misc/copyright_gfdl">GNU Free Documentation License</a>.</p>
</div> <!--close someright tag -->
</div> <!--close content tag -->
</div> <!--close container tag -->

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
    var pageTracker = _gat._getTracker("UA-9809328-1");
    pageTracker._trackPageview();
} catch(err) {}</script>

END
;
}





sub print_instructions {
  print
	p({-class=>'small'},
	  "Use this form to send questions or comments to the maintainers of WormBook.");
}

sub print_form {
    my $where_from = shift;
    print
	table(
	      TR(th({-align=>'right'},"Your full name:"),
		 td({-align=>'left'},textfield(-name=>'full_name',-size=>40))),
	      
	      TR(th({-align=>'right'},"Your institution:"),
		 td({-align=>'left'},textfield(-name=>'institution',-size=>40))),

	      TR(th({-align=>'right'},"Your e-mail address:"),
		 td({-align=>'left'},textfield(-name=>'from',-size=>40))),

	      TR(th({-align=>'right'},"Subject:"),
		 td({-align=>'left'},textfield(-name=>'subject',
#					       -value=>$class && $name ?
#					       "Comments on $class $name ($db db)": '',
					       -size=>60))),

	      TR(th({-colspan=>2,-align=>'left'},'Comment or Correction:')),

	      TR(td({-colspan=>2},textarea(-name=>'remark',
					   -rows=>12,
					   -cols=>80,
#					   -wrap=>'virtual'
					   ))),
	      ),
#            hidden(-name=>'name',-value=>$name),
#	    hidden(-name=>'class',-value=>$class),
#	    hidden(-name=>'db',-value=>$db),
#	    hidden(-name=>'lab_name',-value=>"$lab_name"),
	    hidden(-name=>'referer',-value=>$where_from),br,
            submit(-name=>'return',-value=>'Cancel & Return',-class=>'error'),
            submit(-name=>'submit',-value=>'Submit Comments');
}

sub send_mail {
    my ($where_from) = @_;
#    my ($obj_name,$obj_class,$where_from) = @_;

#    my @addresses = map { $FEEDBACK_RECIPIENTS[$_] ? 
#			      $FEEDBACK_RECIPIENTS[$_]->[0]
#				  : () } param('recipients');
#    my @addresses = Configuration->Feedback_recipient;
    my $name = param('full_name');
    my $institution = param('institution');
    my $subject = param('subject');
    $where_from ||= '(unknown)';
    my @missing;
    push @missing,"Your e-mail address"     
      unless my $from = param('from');
    push @missing,"A properly formatted e-mail address"
	if $from && $from !~ /.+\@[\w.]+/;
    push @missing,"A comment or correction" 
	unless my $remark = param('remark');
    if (@missing) {
	print
	    p({-class=>'error'},
	      "Your submission could not be processed because",
	      "the following information was missing:"),
	    ol({-class=>'error'},
	       li(\@missing)),
	    p({-class=>'error'},
	      "Please fill in the missing fields and try again.");
	return;
    }


    my $error = <<END;
Unable to send mail.  Please try again later.  
If the problem persists, contact the site\'s webmaster.
END
    ;
    unless (open (MAIL,"|/usr/lib/sendmail -oi -t")) {
	AceError($error);
	return;
    }

#    my $to = join(', ',@RECIPIENTS);
    my $to = RECIPIENT;
    print MAIL <<END;
From: $from ($name via WormBook feedback page)
To: $to
Subject: $subject

Full name:   $name
Institution: $institution
Address:     $from

SUBMITTED FROM PAGE: $where_from

COMMENT TEXT:
$remark
END
    ;
    
    unless (close MAIL) {
#	AceError($error);
	return;
    }
    return 1;
}

sub print_confirmation {
    print 
	p("Thank you for taking the time to submit this information.",
	  "Please use the buttons below to submit more reports or to",
	  "return to WormBook.",
	  ),
	start_form,
	submit(-name=>'restart',-label=>'Submit Another Report'),
	hidden('referer'),
	submit(-name=>'return',-label=>'Return to WormBook'),
	end_form;
}
