#!/usr/bin/perl -w

$|=1;     
use Ace; 
use strict;
use IO::Handle;
use IPC::Open2;
use HTTP::Request;
use LWP::UserAgent;
use File::Basename;
use Getopt::Long;

my ($help,$links_from,$defs_file,$xml);
GetOptions('help=s'        => \$help,	   	   
	   'links-from=s'  => \$links_from,
	   'defs-file=s'   => \$defs_file,
	   'xml-files=s'   => \$xml,      # current var name
    );


if ($help) {
    die <<END;
    
Usage: $0 [--links-from wormbase-server||directory] [--defs-file FILE]
    
         SAMPLE USAGE: local acedb with all defaults
	    $0 --links-from localhost

	 SAMPLE USAGE: remote files
   	    $0 --links-from aceserver.cshl.org \
	    --defs-file WormbaseLinks.def \
            --xml-files wnt_signal.html

         SAMPLE USAGE: local files
         $0 --links-from /home/tharris/wormbook/wormbase-links-WS240/ \
	    --defs-file WormbaseLinks.def \
            --xml-files wnt_signal.html
END
;
}   
      



$links_from ||= 'mining.wormbase.org';
$defs_file  ||= 'WormbaseLinks.def';
$xml        ||= 't/wntsignaling.html';

my $j=0;
my $version = "";
my %links = ();

# Are we working with local files or do we need
# to fetch them?
if ($links_from =~ /\w*\.\w*\.\w{3}/ || $links_from =~ /localhost/) {
    
    generate_wormbase_links_from_acedb();
    
# Otherwise, from a directory.
} else {   
    fetch_links_from_directory();
}
    

my @xml = split(/,/,$xml);
    

my $rundate = `date +%Y-%m-%d`; chomp $rundate;
my $runtime = `date +%H:%M:%S`; chomp $runtime;

my $logfile = "reports/$rundate.$$";
system ("/bin/touch $logfile");
open (LOG,">>$logfile") or die ("Could not create logfile\n");
LOG->autoflush();
open (STDOUT,">>$logfile");
STDOUT->autoflush();
open (STDERR,">>$logfile"); 
STDERR->autoflush();

print <<END;
############################################
# LOG FILE
#
# -- run details    : $rundate $runtime
#
############################################
END
;

for (@xml){
    
    my %Report = ();
    
    print "The following biological entities occur in $_:\n";
    
    my $xml = get_sentences($_);
    
#    TJF commented 2 lines below per discussion with Eimear 24 May 2005
#    $xml =~ s/(\>)(\w)/$1 $2/g; # add white spaces around xml tagged words so
#    $xml =~ s/(\w)(\<)/$1 $2/g; # that word boundaries can be established
    
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
    
    open (OUT, ">ulinked_$_");
    print OUT $xml;
    close (OUT);
    
    my $total = 0;
    
    for (sort {$a cmp $b} keys % Report){
	print "\t\t".$_." occurred ".$Report{$_}." times\n";
	$total += $Report{$_};
    }
    print "\n\nA total of $total links were made for $_\n\n";
}

# end log file

my $endtime = `date +%H:%M:%S`; chomp $endtime;

print <<END
############################################
# END REPORT
#
# -- time ended     : $endtime
#
############################################
END
;

close STDERR;
close STDOUT;
close LOG;

exit(0);



########################################
# Subroutines                          #
########################################
# Wow. This is inredibly inefficient.
sub fetch_links_from_directory {

    my @files = <$links_from/*>;
    
    print "Grabbing links from $links_from ...\n";
    
    for my $path (@files){
	my $object = basename($path, '');
	my $link = join (" ", get_file_contents("$path"));
	$links{$object} = $link;
    }
    print "\t... done!\n";
}


sub read_link_definitions_file {   
    my %templates;
    
    print "\tparsing the link definitions file $defs_file...\n";
    open TMP, "<$defs_file" or die "Can't open $defs_file: $!";
    while (<TMP>){
	chomp;
	next if /^\/\//; # get rid of comment lines
	my ($class, $template, $rules) = split/\t+/, $_;
	$templates{$class} = [ ($template, $rules) ];
    }
    close TMP or die "Can't close $defs_file: $!";
    return \%templates;
}




# OBSOLETE

=pod

sub read_locus_file{
    print "\tparsing locus file ...\n";
    my %locus;
    my @tmp;
    if ($locus_from =~ /http/) {
	my $page = get_web_page($locus_from);
	my @tmp = split /\n/, $page;    #splits by line
    } else {
	# Otherwise, it's a local file.
	open IN,$locus_from or die "Could not open the locus file $locus_from...\n";
	while (<IN>) {
	    push @tmp,$_;
	}   
    }
    
    
    my $cgc_gene_pattern = "[a-z]{3,4}-[0-9]{1,}\.?[0-9]{1,}?";
    foreach (@tmp){
	my @line = split /,/, $_;                #splits by comma

	my $cgcgenename = $line[0];              #gets cgc locus name
	my $wbgene = $line[1];                   #gets WBGene name
	$locus{$cgcgenename} = $wbgene;          #pushes into a hash (%Locus)
	my $syn_list = $line[-2];                #grabs any synonyms 
	my @syn = split / /, $syn_list;          
	for (@syn){
	    $locus{$_} = $wbgene if $_ =~ /^$cgc_gene_pattern$/;
	} #pushes into %Locus
    }
    my $count = scalar(keys %locus);
    return \%locus;
}

=cut

sub generate_wormbase_links_from_acedb {

    print "Fetching objects from remote server...\n";
    my $templates = read_link_definitions_file();  

    print "\topening remote connection ...\n";
    my $db = Ace->connect(-host=>$links_from,-port=>2005) || die "Connection failure: " . Ace->error;
      
    my %status = $db->status;
    $version   = $status{database}{version};
    
    if (-d $version) {
#	die "$version/ already exists! We might be rewriting pre-existing files...\n";
    } else {
#	system(`mkdir -p $version`);
    }

    foreach my $class (sort keys %$templates){
	next unless $class eq 'Variation';

	my $count = $db->count($class => '*');
	print "\t\tfetching $class...\n";
	print "\t\t\tfound $count terms in the $class class.\n";
	print "\t\t\tgenerating links for $class ...\n";

	open OUT, ">$version/$class.txt" or die "Cannot open $version/$class.txt : $!";	
	
	my $i = $db->fetch_many($class => '*');
	my $c;
	while (my $object = $i->next) {
	    $c++;
	    $object =~ s/\///g;     # gets rid of forwardslashes
	    $object =~ s/\'//g;     # gets rid of primes
	    my ($o, $u) = "";
	    
	    if ($class eq 'Variation' 
		|| $class eq 'Transgene'
		) {
		my $public_name = $object->Public_name || $object;
		($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$public_name);	    
		next unless (defined ($o) && defined ($u));
		record($o,$u);
	    } elsif ($class eq 'Gene') {
		my @synonyms   = $object->Other_name;
		push @synonyms,$object->Public_name;
		# We will NOT markup Transcripts
		foreach (@synonyms) {
		    ($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$_);
		    next unless (defined ($o) && defined ($u));
		    record($o,$u);
		}
		
		my $public_name = $object->Public_name || $object;
		($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$public_name);	    
		next unless (defined ($o) && defined ($u));
		record($o,$u);
	    } elsif ($class eq 'Phenotype') {
		my @synonyms   = $object->Synonym;
		push @synonyms,$object->Primary_name; 
		foreach (@synonyms) {
		    ($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$_);
		    next unless (defined ($o) && defined ($u));
		    record($o,$u);
		}
	    } else {
		($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1]);
		next unless (defined ($o) && defined ($u));
		record($o,$u);
	    }
	}
	
	close OUT or die " Cannot close $version/$class.txt : $!";       
    }
}    

sub record {
    my ($o,$u) = @_;
    $links{$o}=$u;
    print OUT "$o\t$u\n";     
}

sub makeURL{
    my ($object,$url,$rule,$class,$public_name) = @_;
    $j++;
    
    my $o;
    # use WbVar names for Variations.
    if ($class && ($class eq 'Variation' 
		   || $class eq 'Transgene'
		   || $class eq 'Phenotype'
		   || $class eq 'Gene',
	)) { 
	if ($public_name =~ /$rule/ ) {
	    $o = $public_name;
	} elsif ($object =~ /$rule/) {
	    $o = $object;
	}
	return unless $o;
    } else {
	return unless $object =~ /$rule/;
	$o = $object;
    }
    $url =~ s/SUB/$object/g;
    return ($o,$url);
}

    

    



sub get_file_contents {
    my $filename = shift;
    open (IN,"$filename");
    while (my $line = <IN>) { 
	chomp ($line);
	my ($object,$link) = split("\t",$line);
	$links{$object} = $link;
    }
    close (IN);
}

sub get_web_page{
    my $url      = shift;    
    my $ua       = LWP::UserAgent->new(timeout => 30); #instantiates a new user agent
    my $request  = HTTP::Request->new(GET => $url); #grabs url
    my $response = $ua->request($request);       #checks url, dies if not valid.
    die "Error while getting ", $response->request->uri," -- ", $response->status_line, "\nAborting" unless $response-> is_success;
    
    my $page = $response->content;
    return $page;
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
