#!/usr/bin/perl -w

use strict;
use Getopt::Long;
use Ace;
use IO::Handle;
use IPC::Open2;
use HTTP::Request;
use LWP::UserAgent;
use File::Basename;

my ($def_file,$locus_url,$wormbase_aceserver,$link_directory,@input_files,$help);

GetOptions ("def_file=s"       => \$def_file,    
	    "locus_url=s"      => \$locus_url, 
	    "wormbase_aceserver=s"   => \$wormbase_aceserver,
	    "link_directory=s" => \$link_directory,
	    "input_files=s"    => \@input_files,
	    "help"             => \$help,
    );

@input_files = split(/,/,join(',',@input_files));


if ($help) {
    die <<USAGE;

Markup docbook html chapters. This script can be called in two ways, one using WormBase to define
links, the other using a local directory with link definitions.

1. Generate links via WormBase:

   $0 --def_file [WormBase link definitions file] \
      --locus_url [link to locus_all.txt at Sanger] \
      --wormbase_aceserver [WormBase AceServer eg mining.wormbase.org] \
      --input_files [file1.html,file2.html]

2. Generate links from a directory

   $0 --link_directory [path to link directory] \
      --input_files [file1.html,file2.html]

USAGE;

}

$|=1;     




    



  #####################################
  # Declare globals   OMG
  #####################################

my ($db) = "";
my $j=0;
my $version = "";
my %links;

# Fetch links from a directory
if ($link_directory) {
    %links = fetch_links_from_directory($link_directory);

# Fetch links from WormBase
} elsif ($def_file) {
    my %templates = read_definitions_file();
    %links = fetch_links_from_wormbase(\%templates);
}





# Mark up links in .html files

my @xml = @input_files;

# start log file

my $rundate = `date +%m-%d-%y`; chomp $rundate;
my $runtime = `date +%H:%M:%S`; chomp $runtime;

my $logfile = "data_report.$rundate.$$";
system ("/bin/touch $logfile");
open (LOG,">>$logfile") or die ("Could not create logfile\n");
LOG->autoflush();
open (STDOUT,">>$logfile");
STDOUT->autoflush();
open (STDERR,">>$logfile"); 
STDERR->autoflush();

print "############################################\n";
print "# LOG FILE\n";
print "#\n";     
print "# -- run details    : $rundate $runtime\n";
print "#\n";
print "############################################\n";

# match links

for (@xml){

    my %Report = ();

    print "The following biological entities occur in $_:\n";

    my $xml = get_sentences($_);

#    TJF commented 2 lines below per discussion with Eimear 24 May 2005
#    $xml =~ s/(\>)(\w)/$1 $2/g; # add white spaces around xml tagged words so
#    $xml =~ s/(\w)(\<)/$1 $2/g; # that word boundaries can be established

    for my $term (sort {length($b) <=> length($a)} keys % Links){  # matches the longest terms first 
	
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

print "############################################\n";
print "# END REPORT\n";
print "#\n";
print "# -- time ended     : $endtime\n";
print "#\n";
print "############################################\n";

close STDERR;
close STDOUT;
close LOG;




########################################
# Subroutines                          #
########################################


sub fetch_links_from_directory {
    my $link_directory = shift;

    my @files = <$link_directory/*>;
    my %links;
    
    print "Fetching links from $link_directory...\n";
    
    for my $path (@files){
	my $object = basename($path, '');
	my $link = join (" ", get_contents("$path"));
	$links{$object} = $link;
    }
    print " done\n";   
    return %links;
}

sub fetch_links_from_wormbase {
    my ($templates) = @_;    
    my %objects = read_acedb_objects($templates);
    my %locus   = read_current_locus_names();
    my (%links) = make_wormbase_links(\%objects,\%locus, $templates);
    return %links;
}

sub read_definitions_file {    
    my %definitions;

    print "\n";
    print "SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS\n";
    print "Reading in URL templates ...";
    open TMP, "<$def_file"
	or die "Can't open $def_file: $!";
    while (<TMP>){
	chomp;
	next if /^\/\//; # get rid of comment lines
	my ($class, $template, $rules) = split/\t+/, $_;
	$definitions{$class} = [ ($template, $rules) ];
    }
    close TMP
	or die "Can't close $template: $!";
    print "done\n\n";
    return %definitions;
}


sub read_acedb_objects {
    my ($templates) = @_;
    
    print "Opening Wormbase connection ....";

    my $db = Ace->connect(-host=>$wormbase_aceserver,-port=>2005) || die "Connection failure: ",Ace->error;
    
    print "done\n";
    
    my %objects=();
    
    # get ws version - cruft - this is a global
    my %status = $db->status;
    $version = $status{database}{version};

    system(`mkdir $version`) unless (-d $version);  # make directory of version number
    
    for (sort keys %$templates){
	next if /Locus/;     # skips Locus
	next if /Protein/;   # skips Protein
	my @objects = ();
	my $count = $db->count($_ => '*');
	print "\nThere are $count terms in the $_ data class.\n";
	print "Downloading now .......";
	@objects = $db->fetch($_);
	$objects{$_} = [ @objects ];
	print "done\n";
    }
    return (%objects);
}

sub read_current_locus_names {
    my $locus=();
    
    my $page = get_web_page($locus_url);
    my $cgc_gene_pattern = "[a-z]{3,4}-[0-9]{1,}\.?[0-9]{1,}?";

    my @tmp = split /\n/, $page;    #splits by line
    foreach (@tmp){
	my @line = split /,/, $_;                #splits by comma

	my $cgcgenename = $line[0];              #gets cgc locus name
	my $wbgene = $line[1];                   #gets WBGene name
	$Locus{$cgcgenename} = $wbgene;          #pushes into a hash (%Locus)
	my $syn_list = $line[-2];                #grabs any synonyms 
	my @syn = split / /, $syn_list;          
	for (@syn){
	    $locus{$_} = $wbgene if $_ =~ /^$cgc_gene_pattern$/;
	    } #pushes into %Locus
    }
    my $count = scalar(keys %locus);
    print "There are $count terms in the Locus class.\n\n";
    return %locus;                               #returns hash
}




sub make_worbase_links {
    my ($objects, $locus, $templates) = @_;

    my %links=();
    
    print "Making links now .....";
    for (keys %$locus){
	my ($o, $u) = "";
	
	($o, $u) = make_url($$locus{$_}, $$templates{Locus}[0], $$templates{Locus}[1], $version);
	next unless (defined ($o) && defined ($u));
	$links{$o}=$u;

	($o, $u) = make_url($_, $$templates{Locus}[0], $$templates{Locus}[1], $version);
	next unless (defined ($o) && defined ($u));
	$links{$o}=$u;

	tr/a-z/A-Z/ for $_; # convert to uppercase for protein names

	($o, $u) = make_url($_, $$templates{Protein}[0], $$templates{Protein}[1], $version);
	next unless (defined ($o) && defined ($u));
	$links{$o}=$u;

   }

    my $count = scalar(keys %$objects);
    for (keys %$objects){
	for my $i ( 0 .. $#{ $$Objects{$_} }){
	    $$objects{$_}[$i] =~ s/\///g;     # gets rid of forwardslashes
	    $$objects{$_}[$i] =~ s/\'//g;     # gets rid of primes
	    my ($o, $u) = "";
	    ($o, $u) = make_url($$objects{$_}[$i], $$templates{$_}[0], $$templates{$_}[1]);
	    next unless (defined ($o) && defined ($u));
	    $links{$o}=$u;
	}
   }

    print "done\n";
    print "There are $j total links\n";
    print "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF\n";

    return %links;
}

sub make_url{
    my ($object, $url, $rule) = @_;
    return unless $object =~ /$rule/;
    $j++;
    $url =~ s/SUB/$object/g;
    my $o = $object; my $u = $url;
    open OUT, ">$version/$object"  
	or die "Cannot open $version/$object : $!";	
    print OUT "$url\n"; 
    close (OUT) 
	or die " Cannot close $version/$object : $!";
    
    return($o, $u);
}


sub get_contents {
    my $filename = shift;
    my @return = ();
    open (IN,"$filename");
    while (my $line = <IN>) { 
	chomp ($line);
	push @return, $line;
    }
    close (IN);
    return @return;  
}

sub get_web_page{
    my $u = shift;
    
    my $ua = LWP::UserAgent->new(timeout => 30); #instantiates a new user agent
    my $request = HTTP::Request->new(GET => $u); #grabs url
    my $response = $ua->request($request);       #checks url, dies if not valid.
    die "Error while getting ", $response->request->uri," -- ", $response->status_line, "\nAborting" unless $response-> is_success;
    
    my $page = $response->content;    #splits by line
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
