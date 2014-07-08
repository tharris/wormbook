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
use FindBin qw/$Bin/;

my ($help,$wormbase,$defs_file);
GetOptions('help=s'      => \$help,	   	   
	   'wormbase=s'  => \$wormbase,
    );


if ($help) {
    die <<END;
    
Usage: $0 [--links-from wormbase-server||directory] [--defs-file FILE]
    
      Generate entity-to-URI mapping files from WormBase.

	     From a local acedb (preferred)
 	        $0

	     From a remote acedb (not recommended or supported!)
   	        $0 --links-from aceserver.cshl.org

		
      Options
           --help       display this help message
	   --wormbase   [localhost || URI].                  Default: localhost.
	   --defs-file  the object-to-URI definitions file.  Default: wormbase_link_specifications.def

END
;
}   
      
$wormbase   ||= 'localhost';
$defs_file  ||= 'wormbase_link_specification.def';

generate_wormbase_links_from_acedb();


sub generate_wormbase_links_from_acedb {

    print "Fetching objects from remote server...\n";
    my $templates = read_link_definitions_file();  

    print "\topening remote connection ...\n";
    my $db = Ace->connect(-host=>$wormbase,-port=>2005) || die "Connection failure: " . Ace->error;
    
    my %status  = $db->status;
    my $version = $status{database}{version};
    
    if (-d $version) {
	warn "$version/ already exists! We might be rewriting pre-existing files...\n";
    } else {
	system(`mkdir -p $version`);
    }
    
    foreach my $class (sort keys %$templates){
#	next unless $class eq 'Protein';

	print "\t\tfetching $class...\n";	
	print "\t\t\tgenerating links for $class ...\n";
	
	open OUT, ">>$version/$class.txt" or die "Cannot open $version/$class.txt : $!"; 	    

	if ($class =~ /cds|clone|strain|transgene|variation/i) {
            # The following require special handling: cell, gene, phenotype, protein
	    my $dump_file = dump_objects_via_tace($class,$version);
	    
	    open IN,"<$dump_file";
	    $/ = "\n\n";
	    while (<IN>) {
		my ($object) = $_ =~ /$class : "(.*)"/;
		my ($public_name) = $_ =~ /Public_name\s*"(.*)"/;
		$public_name ||= $object;
		my ($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$public_name); 
		record($o,$u);
	    }
	} else {
	    
	    my $i = $db->fetch_many($class => '*');
	    my $c;
#	    my $this_start = 0;
	    while (my $object = $i->next) {
		$c++;
		$object =~ s/\///g;     # gets rid of forwardslashes
		$object =~ s/\'//g;     # gets rid of primes
		my ($o, $u) = "";

#		if ($object eq 'CN:CN13393') {
#		    $this_start++;
#		}
#		next if $this_start == 0;

		
#		if ($class eq 'Transgene') {
#		    my $public_name = $object->Public_name || $object;
#		    ($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$public_name);	    
#		    next unless (defined ($o) && defined ($u));
#		    record($o,$u);
#		} elsif ($class eq 'Gene') {
		if ($class eq 'Gene') {
		    my %seen;
		    my @synonyms = $object->Other_name;
		    push @synonyms,$object->Public_name;
		    my @unique   = grep { ! $seen{$_}++ } @synonyms;
		    foreach (@unique) {
			($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$_);
			next unless (defined ($o) && defined ($u));
			record($o,$u);
		    }
		    
#		    my $public_name = $object->Public_name || $object;
#		    ($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$public_name);	    
#		    next unless (defined ($o) && defined ($u));
#		    record($o,$u);
		} elsif ($class eq 'Phenotype') {
		    my @synonyms   = $object->Synonym;
		    push @synonyms,$object->Primary_name; 
		    foreach (@synonyms) {
			($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],$class,$_);
			next unless (defined ($o) && defined ($u));
			record($o,$u);
		    }
		} elsif ($class eq 'Protein') {
		    # Instead of using all protein IDs, we will
		    # create a fake look up table based on CGC names.
		    # The Gene_name tag in the ?Protein class is now more like a brief ID, basically useless.
		    my $cgc_name = eval { $object->Corresponding_CDS->Gene->CGC_name };
		    if ($cgc_name) {
			my $new_case = uc($cgc_name);
			($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1],'Protein',$new_case);
			next unless (defined ($o) && defined ($u));
			record($o,$u);
		    }
		    
		} else {
		    ($o, $u) = makeURL($object,$templates->{$class}[0], $templates->{$class}[1]);
		    next unless (defined ($o) && defined ($u));
		    record($o,$u);
		}
	    }	    
	}
	close OUT or die " Cannot close $version/$class.txt : $!";
    }
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


sub record {
    my ($o,$u) = @_;
#    $links{$o} = $u;    
    print OUT "$o\t$u\n";     
}

sub makeURL{
    my ($object,$url,$rule,$class,$public_name) = @_;
    
    # Use public names as the target for markup, but stable WB* IDs in the URI.
    my $o;
#    if ($class && ($class eq 'Variation' 
#		   || $class eq 'Transgene'
#		   || $class eq 'Phenotype'
#		   || $class eq 'Gene'
#		   || $class eq 'Protein'
#	)) { 
	$o = $public_name ? $public_name : $object;
#    } else {
#	return unless $object =~ /$rule/;
#	$o = $object;
#    }
    $url =~ s/SUB/$object/g;
    return ($o,$url);
}

sub dump_objects_via_tace {
    my ($class,$version) = @_;        
    my $tmp_dir = "$Bin/ace_dumps";
    system(`mkdir -p $tmp_dir`);

    my $dump_file = "$tmp_dir/dump_${class}_from_ace.script";
    unless (-e $dump_file) {
	print "\t\tdumping the $class class\n\n";
	open TEMP,">$tmp_dir/dump_${class}_from_ace.script";
	print TEMP <<END;
//tace script to dump database
Find $class
Write $tmp_dir/$class.ace
END
;

	system("/usr/local/wormbase/acedb/bin/tace /usr/local/wormbase/acedb/wormbase_$version < $tmp_dir/dump_${class}_from_ace.script");
	close TEMP;
    }
    return "$tmp_dir/$class.ace";
}
