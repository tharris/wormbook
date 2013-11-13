#!/usr/bin/perl -w

$|=1;     
use strict;
#use IO::Handle;
#use IPC::Open2;
use File::Basename;
use Getopt::Long;

my ($help,$links_dir,$xml_dir);
GetOptions('help'        => \$help,
	   'links-dir=s' => \$links_dir,
	   'xml-dir=s'   => \$xml_dir,
    );


if ($help) {
    die <<END;
    
Usage: $0 [--links-dir directory] [--xml-dir directory]
    
         Mark up biological entities in docbook XML with links to WormBase.
	 
	 Basic usage:
	 $0 

       Options:
	 --links-dir  where to find object-to-uri mappings. Default: current/
	 --xml-dir    where to find docbook xml to markup.  Default: xml_in/
	 
END
;
}   
      


$links_dir ||= 'current';
$xml_dir   ||= 'xml_in';

process_xml($xml_dir);    


sub process_xml {
    my $dir = shift;    

    print "Marking up XML files with ulinks to WormBase...\n";

    my %links = fetch_links_from_directory();
    
    system("mkdir xml_out");
    my $date = `date +%Y-%d-%m`;
    chomp $date;

    system("mkdir xml-processed-$date");

    start_report();

    my @files = <$dir/*>;
    for my $filename (@files){
	open (IN,"$filename") or die "Couldn't open $filename: $!\n";    
	print "\tprocessing $filename...\n";
	
	my %Report = ();    
	print LOG "The following biological entities occur in $filename:\n";
	
	my $xml = get_sentences($filename);
	
#    TJF commented 2 lines below per discussion with Eimear 24 May 2005
#    $xml =~ s/(\>)(\w)/$1 $2/g; # add white spaces around xml tagged words so
#    $xml =~ s/(\w)(\<)/$1 $2/g; # that word boundaries can be established
	# WOW!  This is insane!
	for my $term (sort {length($b) <=> length($a)} keys %links){  # matches the longest terms first 
	    
	    my $pterm = $term;
	    $pterm =~ s/([\.\':,\?\*])/\\$1/g;     # escape regex special chars
	    
	    next unless $xml =~ /${pterm}/;
	    
	    # match the preceeding character to the term
	    # match the term
	    # match the follow character to the term (note: only match a period if followed by a space)
	    # print the preceeding character to the term
	    # print the ulink tag containing the url for the term
	    # print the term
	    # print the closing ulink tag
	    # print the following character for the term
	    # repeat for all instances of the term
	    my $matches = scalar($xml =~ s%([\>\s\/\(\[\{\*]+?)(${pterm})(\<|\s|\/|\. |\,|\:|\;|\)|\]|\}|\*)+?%$1\<ulink url\=\"$links{$term}\" role\=\"_blank\"\>$2\<\/ulink\>$3%mg);
	    
	    $Report{$2} = $matches if defined ($2);
	}


	my ($basename) = $filename =~ /.*\/(.*)/;
	open (OUT, ">xml_out/$basename") or die "Coulnd't open xml_out/$basename for writing: $!";
	print OUT $xml;
	close OUT;
	
	my $total = 0;
	
	for (sort {$a cmp $b} keys % Report){
	    print LOG "\t\t".$_." occurred ".$Report{$_}." times\n";
	    $total += $Report{$_};
	}
	print LOG "\n\nA total of $total links were made for $filename\n\n";

	unless ($dir eq 't') {  # let's not relocate files if running under testing mode.
	    system("mv $filename xml-processed-$date/.");
	}
    }

    print "Done! You can find marked up files in xml_out/ and reports in reports/\n\n";

    close_report();
}




########################################
# Subroutines                          #
########################################
# Wow. This is inredibly inefficient.
# This does NOT take into account that object
# names are NOT globally unique at WormBase!
sub fetch_links_from_directory {
    print "\tloading object-to-uri mappings from $links_dir...\n";
    print "\tthis might use a LOT of memory...\n";
    
    my %links;
    
    my @files = <$links_dir/*>;
    for my $filename (@files){
	
	if ($filename =~ /\.gz$/) {
	    open(IN,"gunzip -c $filename |") || die "can't open pipe to $filename";
	}
	else {
	    open(IN,$filename) || die "can't open $filename";
	}
	while (my $line = <IN>) { 
	    chomp ($line);
	    my ($object,$link) = split("\t",$line);
	    $links{$object} = $link;
	}
    }
    print "\t\t... done!\n";
    close IN;
    return %links;
}

sub get_sentences {    
    my $xmlfile = shift;
    
    open (XML, "<$xmlfile") or die "Can't open xml file $xmlfile.";
    undef $/; 				# read the whole thing
    my $xml = <XML>;
    close (XML);
    $/ = "\n";
    return $xml;
}


sub start_report {
    my $rundate = `date +%Y-%m-%d`; chomp $rundate;
    my $runtime = `date +%H:%M:%S`; chomp $runtime;
    
    my $logfile = "reports/$rundate.$$";
    open LOG,">$logfile" or die ("Could not create logfile\n");
    print LOG <<END;
############################################
# LOG FILE
#
# -- run details    : $rundate $runtime
#
############################################
END
;

}


sub close_report {
    
# end log file
    
    my $endtime = `date +%H:%M:%S`; chomp $endtime;

print LOG <<END
############################################
# END REPORT
#
# -- time ended     : $endtime
#
############################################
END
;
    exit(0);
}
