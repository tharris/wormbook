#!/usr/bin/perl -w

$|=1;     
use strict;
#use IO::Handle;
#use IPC::Open2;
use File::Basename;
use Getopt::Long;

my ($help,$links_dir,$xml_dir,$test);
GetOptions('help'        => \$help,
	   'links-dir=s' => \$links_dir,
	   'xml-dir=s'   => \$xml_dir,
	   'test'        => \$test,
    );


if ($help) {
    die <<END;
    
Usage: $0 [--links-dir directory] [--xml-dir directory]
    
         Mark up biological entities in docbook XML 
         with links to WormBase.
	 
	 Basic usage:
	 $0
	 ... or specifying the directories explicitly ...
	 $0 --links-dir current/ --xml-dir xml_in

       Options:
	 --links-dir  where to find object-to-uri mappings. Default: current/
	 --xml-dir    where to find docbook xml to markup.  Default: xml_in/
	 --test       run under test mode; do not delete or relocate files.
	 
END
;
}   
      


$links_dir ||= 'current';
$xml_dir   ||= 'xml_in';

process_xml($xml_dir);    


sub process_xml {
    my $dir = shift;    

    print "Marking up XML files with ulinks to WormBase.\n";

    my $links = fetch_links_from_directory();
    system("mkdir xml_out");
    my $date = `date +%Y-%m-%d`;
    chomp $date;

    if ($test) {
	print "\t* running in test mode. Copying in sample chapter...\n";
	system("cp t/sample_chapter/xml_docbook/WB* xml_in/.");
    }

    my @files = <$dir/*>;
    for my $filepath (@files){
	next unless $filepath =~ /.*\.xml/;
	my ($filename) = $filepath =~ /.*\/(.*)/;
	my ($stub) = $filename =~ /(.*)\.xml/;

	# Save only things before _text - there
	# are multiple files per chapter and we want
	# them to all end up in the same directory.
	$stub =~ s/_text.*//;

	my $output_dir = "xml_out/$date-$stub";
	system("mkdir -p $output_dir/original_docbook");  # We'll save the input files alongside output
	start_report($output_dir,$filename);

	open (IN,"$filepath") or die "Couldn't open $filepath: $!\n";    
	print "\t* processing $filename...\n";
	
	my $report = {};    
	print LOG "The following biological entities occur in $filename:\n";
	
	my $xml = get_sentences($filepath);
	
#    TJF commented 2 lines below per discussion with Eimear 24 May 2005
#    $xml =~ s/(\>)(\w)/$1 $2/g; # add white spaces around xml tagged words so
#    $xml =~ s/(\w)(\<)/$1 $2/g; # that word boundaries can be established
	# WOW!  This is insane!
	
	foreach my $class (sort { $a cmp $b } keys %$links) {
#	    for my $term (sort {length($b) <=> length($a)} keys %links){  # matches the longest terms first 
	    
            # matches the longest terms first
	    for my $term (sort {length($b) <=> length($a)} keys %{$links->{$class}}){
		
		my $pterm = $term;
#	    $pterm =~ s/([\.\':,\?\*\-]\)\()/\\$1/g;     # escape regex special chars
		$pterm =~ s/([\.\':,\?\*\-\)\(\[\]])/\\$1/g;     # escape regex special chars
		
#	    if ($term =~ /ynIs.*flp.*4/i) {
#		print STDERR "$term $pterm\n";
#	    }
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
		my $url = $links->{$class}->{$term};
#	    my $matches = scalar($xml =~ s%([\>\s\/\(\[\{\*]+?)(${pterm})(\<|\s|\/|\. |\,|\:|\;|\)|\]|\}|\*)+?%$1\<ulink url\=\"$links{$term}\" role\=\"_blank\"\>$2\<\/ulink\>$3%mg);
		my $matches = scalar($xml =~ s%([\>\s\/\(\[\{\*]+?)(${pterm})(\<|\s|\/|\. |\,|\:|\;|\)|\]|\}|\*)+?%$1\<ulink url\=\"$url\" role\=\"_blank\"\>$2\<\/ulink\>$3%mg);
		
		if (defined ($2)) {
		    $report->{$class}->{$2} = $matches;
		}
	    }
	}

	open (OUT, ">$output_dir/$filename") or die "Couldn't open xml_out/$filename for writing: $!";
	print OUT $xml;
	close OUT;
	
	my $total = 0;	
	foreach my $class (sort {$a cmp $b} keys %$report){
	    printf LOG "%10s \n",uc($class);
	    printf LOG "%15s %-15s \n",'entity','occurrences';
	    printf LOG "%15s %-15s \n",'------','-----------';
	    foreach my $entity (sort { $report->{$class}->{$a} <=> $report->{$class}->{$b} } 
				keys %{$report->{$class}}) {
		printf LOG "%15s %-15s \n",$entity,$report->{$class}->{$entity};
		$total += $report->{$class}->{$entity};
	    }
	}
	print LOG "\n\nA total of $total links were made for $filename\n\n";

	unless ($test) {  # let's not relocate files if running under testing mode.
	    system("mv $filepath $output_dir/original_docbook/.");
	}
    }

    print <<END;

    Done! 
	
    The DocBook XML with entities linked to WormBase:
      xml_out/*

    Reports for each file available at:
      xml_out/*/*report.log   

    Input file(s) has been relocated to:
      xml_out/*/original_docbook/

END
;

    close_report();
}




########################################
# Subroutines                          #
########################################
# Wow. This is inredibly inefficient.
# This does NOT take into account that object
# names are NOT globally unique at WormBase!
sub fetch_links_from_directory {
    print "\t* loading object-to-uri mappings from $links_dir/...\n";
    print "\t\t(this might use a LOT of memory!)\n";
    
    my $links = {};
    
    my @files = <$links_dir/*>;
    for my $filepath (@files){
	
	my ($filename) = $filepath =~ /.*\/(.*)/;
	my ($class)    = $filename =~ /(.*)\.txt/;
	
	if ($filepath =~ /\.gz$/) {
	    open(IN,"gunzip -c $filepath |") || die "can't open pipe to $filename";
	}
	else {
	    open(IN,$filepath) || die "can't open $filename";
	}
	while (my $line = <IN>) { 
	    chomp ($line);
	    my ($object,$link) = split("\t",$line);
#	    $links{$object} = $link;	    
	    $links->{$class}->{$object} = $link;
	}
    }
    print "\t\t... done!\n";
    close IN;
    return $links;
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
    my ($logdir,$filename) = @_;
    my $rundate = `date +%Y-%m-%d`; chomp $rundate;
    my $runtime = `date +%H:%M:%S`; chomp $runtime;

    my ($stub) = $filename =~ /(.*)\.xml/;
    
    open LOG,">$logdir/$stub.log" or die ("Could not create logfile\n");
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
