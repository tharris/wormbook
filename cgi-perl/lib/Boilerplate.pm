# -*- Mode: perl -*-

package Boilerplate;
use strict 'vars';

use CGI qw(:standard *table *TR *td center);
use CGI::Carp;
use Carp 'croak','cluck';

my @cells = (qw|home about author sponsors announce feedback atlas wormbase|);
my %cells2urls   = (
		    home   => { name      => '<font color="#FFF5FF">Home</font>',
				url       => "/"},
		    about => { name   => '<font color="#FFF5FF">About WormBook</font>',
			          url      => "/about.html",
			   },
		    author =>    { name       => '<font color="#FFF5FF">Author Instructions</font>',
				      url        => "/authorinfo.html"
				      },
		    sponsors =>  { name        => '<font color="#FFF5FF">Sponsors</font>',
				      url         => "/sponsors.html",
			       },
		    announce => { name    => '<font color="#FFF5FF">e-Alerts</font>',
                                  url => "/announce.html",
                              },
                    feedback => { name     => '<font color="#FFF5FF">Feedback</font>',
                                    url      => "/db/misc/feedback"
                                    },

		    wormbase =>      { name       => '<font color="#FFF5FF">WormBase</font>',
				          url        => "http://www.wormbase.org",
				   },
		    atlas   =>    { name       => '<font color="#FFF5FF">WormAtlas</font>',
				       url        => "http://www.wormatlas.org",
				},

		    );


sub new {
    my $this = bless {},shift;
    return $this;
}

sub banner {
    my $self = shift;
    my $self_url = url(-relative=>1);
    my $html = div({-id=>"fotocredit"},  a({-href=>"/"},  img({-src=>'/images/header_760x96.png',alt=>'WormBook Header Image',border=>"0"}), span('Embryo series courtesy of Einhard Schierenberg')  )  );

#    my $html = a({-href=>"/"},  img({-src=>'/images/header_760x96.png',alt=>'WormBook Header Image',border=>"0"});

# old_style_banner  2009 06 04
#     my $table = qq(<table id="navbar" border="0" cellpadding="0" cellspacing="0" width="760px"><tr>\n);
#     foreach my $cell (@cells) {
# 	my $name = $cells2urls{$cell}->{name};
# 	my $url  = $cells2urls{$cell}->{url};
# 
# 	(my $check_url = $url) =~ s/\?.*$//;
# 
# 	my $active = $self_url ? $check_url =~ /$self_url$/ : $check_url eq '/';
# 	my ($cell_color,$cell_css);
# 
# 	if ($name =~ /home/i) {
# 	    my $abs = url(-absolute=>1);
# 	    $active++ if ($abs eq '/' || $abs eq '/index.html'); 
# 	}
# 	if ($active) {
# 	    $cell_color = '#550055';
# 	    $cell_css = 'bactive';
# 	} else {
# 	    $cell_color = '#9932cc';
# 	    $cell_css = 'binactive';
# 	}
# 	
# 	$table .= qq{<td bgcolor="$cell_color" align="center" nowrap="nowrap">
# 			 <a href="$url" class="$cell_css">$name</a></td>\n};
#     }
#     
#     $table .= end_TR . end_table;
#     $html .= $table;

# Daniel's dynamic menu, trying to insert it here.
    $html .= <<"EndOfText";
    <link rel="stylesheet" type="text/css" href="/css/wb_menu.css">
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
EndOfText
#   $html .= "<p><br/></p>\n";
#   $html .= "<p><br/></p>\n";


# test 2007 08 02
#     $html .= "<A HREF=\"www.google.com\">A Link to Google</A><BR>\n";

    $html.=qq(<div id="searchcheck" >
	      <form action="/db/misc/search.cgi" method="post">
	      <input type="checkbox" name="search_html" checked="checked" />&nbsp;HTML&nbsp;
	      <input type="checkbox" name="search_preprints" checked="checked" />&nbsp;Preprints
	      <input type="checkbox" name="search_pdf" />&nbsp;PDF
	      <input type="text" name="query" size="15" />
	      <input value="Search" type="submit" name="search" />
	      </form></div>\n);

    return $html;
}

sub footer {
    my $self = shift;
    my $html = <<END;

<script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
    var pageTracker = _gat._getTracker("UA-9809328-1");
    pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
END

# Text below originally included before </body>
# <div id="footer">
#   <p><a href="/db/misc/copyright_gfdl">&copy; 2005 WormBook</a>, except where otherwise noted.</p>
# </div>

return $html;
}

1;
