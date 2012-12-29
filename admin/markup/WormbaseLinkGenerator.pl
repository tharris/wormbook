#!/usr/bin/perl -w

use strict;
use Getopt::Long;
use Ace;
use IO::Handle;
use IPC::Open2;
use HTTP::Request;
use LWP::UserAgent;
use File::Basename;

my ($def_file,$locus_names,$wormbase_url,$link_directory,@input_files,$help);

GetOptions ("def_file=s"       => \$def_file,    
	    "locus_names=s"     => \$locus_names, 
	    "wormbase_url=s"   => \$wormbase_url,
	    "link_directory=s" => \$link_directory,
	    "input_files=s"    => \@input_files,
	    "help"             => \$help,
    );

@input_files = split(/,/,join(',',@input_files));


if ($help) {
    die <<USAGE;

Markup docbook html chapters. This script can be called in two fashions.


1. Generate links from WormBase:

   $0 --def_file [WormBase link definitions file] --locus_names [link to locus names at Sanger] \
      --wormbase_url [WormBase URL] --input_files [file1.html,file2.html]

2. Generate links from a directory

   $0 --link_directory [path to link directory] --input_files [file1.html,file2.html]

USAGE;

}

$|=1;     




    



  #####################################
  # Declare globals                    #
  #####################################

my ($db) = "";
my %links = ();
my $j=0;
my $version = "";

  #####################################
  # Main                              #
  #####################################

# Generate links from wormbase     
#           or                                 
# Grab links from directory                


if ($link_directory) {
    %links


if (@ARGV == 2){
    
    my $links = $ARGV[0]; # directory
    
    %Links = &grabLinksFromDirectory($links);
    
}

if(@ARGV == 4){
    
    my $defs = $ARGV[0]; # def file
    my $locus_url = $ARGV[1]; # url to locus_all.txt file at sanger
    my $links = $ARGV[2]; # ace server

    my %Templates = &readDefs($defs);  
    %Links = &grabLinksFromWormbase($links, $locus_url, \%Templates);

}

if ((@ARGV < 2) || (@ARGV == 3) || (@ARGV > 4))
{
    die "$USAGE\n";
}

# Mark up links in .html files

my @xml = pop(@ARGV);

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

    my $xml = &GetSentences($_);

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
	my $matches = scalar($xml =~ s%([\>\s\/\(\[\{\*]+?)(${pterm})(\<|\s|\/|\. |\,|\:|\;|\)|\]|\}|\*)+?%$1\<ulink url\=\"$Links{$term}\" role\=\"_blank\"\>$2\<\/ulink\>$3%mg);
	
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

exit(0);

  ########################################
  # Subroutines                          #
  ########################################


sub grabLinksFromDirectory{
    my ($u) = @_;

    my @files = <$u/*>;
    my %Links=();

    print "Grabbing links from $u ...";
    
    for my $path (@files){
	my $object = basename($path, '');
	my $link = join (" ", GetContents("$path"));
	$Links{$object} = $link;
    }
    print " done\n";

    return %Links;
}

sub grabLinksFromWormbase{
    my ($links, $locus_url, $Templates) = @_;
    
    
    my (%Objects) = &readAceObjects($links,$Templates);
    my (%Locus) = &readCurrentLocus($locus_url);

    my (%Links) = &makeWBLinks(\%Objects,\%Locus, $Templates);
    return %Links;
}

sub readDefs{
    my $template = shift;

    my %Templates=();

    print "\n";
    print "SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS\n";
    print "Reading in URL templates ...";
    open TMP, "<$template"
	or die "Can't open $template: $!";
    while (<TMP>){
	chomp;
	next if /^\/\//; # get rid of comment lines
	my ($class, $template, $rules) = split/\t+/, $_;
	$Templates{$class} = [ ($template, $rules) ];
    }
    close TMP
	or die "Can't close $template: $!";
    print "done\n\n";
    return %Templates;
}


sub readAceObjects{
    my ($links, $Templates) = @_;

    print "Opening Wormbase connection ....";

    my $db = Ace->connect(-host=>$links,-port=>2005) || die "Connection failure: ",Ace->error;

    print "done\n";
    
    my %Objects=();

    # get ws version
    my %status = $db->status;
    $version = $status{database}{version};

    system(`mkdir $version`) unless (-d $version);  # make directory of version number

    for (sort keys %$Templates){
	next if /Locus/;     #skips Locus
	next if /Protein/;   #skips Protein
	my @objects = ();
	my $count = $db->count($_ => '*');
	print "\nThere are $count terms in the $_ data class.\n";
	print "Downloading now .......";
	@objects = $db->fetch($_);
	$Objects{$_} = [ @objects ];
	print "done\n";
    }
    return (%Objects);
}

sub readCurrentLocus{
    my $u = shift;

    my %Locus=();

    my $page = &getWebPage($u);
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
	    $Locus{$_} = $wbgene if $_ =~ /^$cgc_gene_pattern$/;
	    } #pushes into %Locus
    }
    my $count = scalar(keys %Locus);
    print "There are $count terms in the Locus class.\n\n";
    return %Locus;                               #returns hash
}

sub makeWBLinks{
    my ($Objects, $Locus, $Templates) = @_;

    my %Links=();

    print "Making links now .....";
    for (keys %$Locus){
	my ($o, $u) = "";

	($o, $u) = &makeURL($$Locus{$_}, $$Templates{Locus}[0], $$Templates{Locus}[1], $version);
	next unless (defined ($o) && defined ($u));
	$Links{$o}=$u;

	($o, $u) = &makeURL($_, $$Templates{Locus}[0], $$Templates{Locus}[1], $version);
	next unless (defined ($o) && defined ($u));
	$Links{$o}=$u;

	tr/a-z/A-Z/ for $_; # convert to uppercase for protein names

	($o, $u) = &makeURL($_, $$Templates{Protein}[0], $$Templates{Protein}[1], $version);
	next unless (defined ($o) && defined ($u));
	$Links{$o}=$u;

   }

    my $count = scalar(keys %$Objects);
    for (keys %$Objects){
	for my $i ( 0 .. $#{ $$Objects{$_} }){
	    $$Objects{$_}[$i] =~ s/\///g;     # gets rid of forwardslashes
	    $$Objects{$_}[$i] =~ s/\'//g;     # gets rid of primes
	    my ($o, $u) = "";
	    ($o, $u) = &makeURL($$Objects{$_}[$i], $$Templates{$_}[0], $$Templates{$_}[1]);
	    next unless (defined ($o) && defined ($u));
	    $Links{$o}=$u;
	}
   }

    print "done\n";
    print "There are $j total links\n";
    print "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF\n";

    return %Links;
}

sub makeURL{
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


sub GetContents {
    
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

sub getWebPage{
    my $u = shift;
    
    my $ua = LWP::UserAgent->new(timeout => 30); #instantiates a new user agent
    my $request = HTTP::Request->new(GET => $u); #grabs url
    my $response = $ua->request($request);       #checks url, dies if not valid.
    die "Error while getting ", $response->request->uri," -- ", $response->status_line, "\nAborting" unless $response-> is_success;
    
    my $page = $response->content;    #splits by line
    return $page;
}

sub GetSentences {

    my $xmlfile = shift;


    open (XML, "<$xmlfile") or die "Can't open xml file $xmlfile.";
    undef $/; 				# read the whole thing
    my $xml = <XML>;
    close (XML);
    $/ = "\n";

    return $xml;
}
