#!/usr/bin/perl -w

############################################################
#
#    written by Igor Antoshechkin
#    igor.antoshechkin@caltech.edu
#    Dec. 2005
#
############################################################

use strict;
# Brittle: will break with new versions of Perl
#use lib qw( /home/tharris70/perl5/lib/perl/5.10 /home/tharris70/perl5/lib/perl/5.10.0 
#            /home/tharris70/perl5/share/perl/5.10 /home/tharris70/perl5/share/perl/5.10.0
#            /home/tharris70/perl5/local/share/perl/5.10.0 
#            /home/tharris70/perl5/local/lib/perl/5.10.0 );
use Search::Indexer;
use Storable qw(store retrieve);
use CGI;
use CGI::Carp qw(fatalsToBrowser);


$|=1; #turn off output buffering

my $indexDir="/usr/local/wormbook/domains/www.wormbook.org/search_index";                    # directory in which index files are (ixw.bdb, ixp.bdb, ixd.bdb)
my $nameFile="/usr/local/wormbook/domains/www.wormbook.org/search_index/lookup.name";        # full name of lookup.name file
my $contentFile="/usr/local/wormbook/domains/www.wormbook.org/search_index/lookup.content";  # full name of lookup.content file
my $sectionFile="/usr/local/wormbook/domains/www.wormbook.org/search_index/lookup.sections"; # full name of lookup.sections file
my $htmlDir="/usr/local/wormbook/domains/www.wormbook.org/html/chapters/";                   # path to the root directory of the web page
my $htmlRoot="http://www.wormbook.org/chapters/";                   # URL that prefixes all pages (e.g. http://www.wormbook.org)
my $ctxtNumChars=60;                                                # number of characters to print around the match string
my $maxExcerpts=4;                                                  # max number of matched lines to print per matched document
my $preMatch="<b><font color=#933794>";                             # opening formatting tag for the match string
my $postMatch="</b></font>";                                        # closing formatting tag for the match string

my $q=new CGI;

if (! $ENV{QUERY_STRING} && $q->param("query") && ! $q->param("noQueryString")) {    # prints query params on the URL line (use with JavaScript-based highlighling of terms in other pages)
    my $self_url=$q->self_url;
    $self_url=~s/;search=Search//;
    print $q->redirect($self_url);
}

my $query=$q->param("query");
my $search=$q->param("search");
my $search_pdf=$q->param("search_pdf");
my $search_html=$q->param("search_html");
my $search_preprints=$q->param("search_preprints");
my $embedded=$q->param("embedded");
print $q->header();

#############################################################
#  
#     put your header html here (css, header, etc.)
#     e.g. print "<link rel=\"stylesheet\" href=\"http://elbrus.caltech.edu/~igor/wormbase.css\">";
#
#############################################################


unless ($embedded) {
    print $q->start_html(-title=>'WormBook Search',-style=>{src=>'/css/bookworm.css'});
    print qq(<div id="content">);
    banner();
}

my $ix = new Search::Indexer(dir => $indexDir, ctxtNumChars => $ctxtNumChars, maxExcerpts => $maxExcerpts, preMatch => $preMatch, postMatch => $postMatch);

my %file_hash=();
my %doc_hash=();
my %section_hash=();

my $ref = retrieve($nameFile) || die "cannot retrieve $nameFile : $!\n";
%file_hash=%$ref;
$ref = retrieve($contentFile) || die "cannot retrieve $contentFile : $!\n";
%doc_hash=%$ref;
$ref = retrieve($sectionFile) || die "cannot retrieve $sectionFile : $!\n";
%section_hash=%$ref;

$query = lc $query;
$query=~s/ and / AND /g;
$query=~s/ or / OR /g;
$query=~s/ not / NOT /g;

my $result = $ix->search($query);
my @docIds = sort {${$result->{scores}}{$b} <=> ${$result->{scores}}{$a}} keys %{$result->{scores}};  #sort by score, descending
my $killedWords = join ", ", @{$result->{killedWords}};

my %aggr_file_hash=();
foreach (@docIds) {
    my $tmp=$file_hash{$_}=~/(.*)\#.*/ ? $1 : $file_hash{$_};
    if (! $search_pdf) {
	next if $tmp=~/\.pdf$/i and !($tmp=~/preprints/i);
    }
    if (! $search_html) {
        next if $tmp=~/\.html$/i;
    }
    if (! $search_preprints) {
        next if $tmp=~/preprints/i;
    }
    $aggr_file_hash{$tmp}{score}+=${$result->{scores}}{$_};
    $aggr_file_hash{$tmp}{title}=$section_hash{$_}{title};
    push @{$aggr_file_hash{$tmp}{id}}, $_;
}

#print "<br><b><font color=blue>", scalar(@docIds), " sections in ", scalar keys %aggr_file_hash, " documents found </font></b><br>";
print "<br><b><font color=blue>", scalar keys %aggr_file_hash, " documents found </font></b>";
print "<font color=black><a href=\"/search.html\">(search tips)</a></font><br><br>";
print "<font color=black>Download all chapters : <a href=\"http://dev.WormBook.org/WormBook.zip\">WormBook.zip</a> (380 MB)</font><br>";
print "<br>Word(s) <font color=red>$killedWords</font> were ignored during the search<br>" if $killedWords;
print "<br><hr width=100%>";

foreach my $doc (sort {$aggr_file_hash{$b}{score} <=>  $aggr_file_hash{$a}{score}}keys %aggr_file_hash) {
    my $tmp_title=$aggr_file_hash{$doc}{title};
    $tmp_title=~s/$htmlDir/$htmlRoot/g;
    my $filetype=$file_hash{${$aggr_file_hash{$doc}{id}}[0]};
    if ($filetype=~/preprints/i) {
	$tmp_title.=" [preprint PDF]";
    }
    elsif ($filetype=~/pdf/i) {
	$tmp_title.=" [PDF]";
    }
    else {
	$tmp_title.=" [HTML]";
    }
    print "<br><b><font color=black>$tmp_title</font></b><br>";
    print "<dd>";
    foreach my $id (sort {$a <=> $b} @{$aggr_file_hash{$doc}{id}}) {
	my $score = $result->{scores}{$id};
	my $excerpts = join "<br><br>", @{$ix->excerpts($doc_hash{$id}, $result->{regex})};
	my $tmpurl=$file_hash{$id};
	$tmpurl =~ s|/usr/local/bookworm/html||g;
	my $tmpname="$section_hash{$id}{title}";
	$tmpname.=": $section_hash{$id}{section}" if $section_hash{$id}{section};
	$tmpurl=~s/$htmlDir/$htmlRoot/g;
	$tmpname=~s/$htmlDir/$htmlRoot/g;
	print "<font style=\"line-height: 1.5\">";
	print "<a href=$tmpurl>$tmpname</a><br>";
	print "$excerpts<br><br>";
	print "</font>";
    }
    print "</dd>";
}

#############################################################
#  
#     put your footer html here 
#
#############################################################
unless ($embedded) {
    print qq(</div>);
    footer();
}





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
<div id="content"> 


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
