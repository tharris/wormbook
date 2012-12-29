#!/usr/bin/perl -w

############################################################
#
#    written by Igor Antoshechkin
#    igor.antoshechkin@caltech.edu
#    Dec. 2005
#
############################################################

use strict;
use Search::Indexer;
use Getopt::Std;
use Storable qw(store retrieve);

my %opts =(s => 'stopwords.txt');

getopts('d:f:i:s:l:e:pohr',\%opts);

my $program_name=$0=~/([^\/]+)$/ ? $1 : '';

if (! (defined $opts{d} or defined $opts{f}) or ! defined $opts{l} ) {
    $opts{h}=1;
}

if ($opts{h}) {
    print "usage: $program_name [options] -d directory_to_index -l lookup_table\n";
    print "       -h              help - print this message\n";
    print "       -i <dir>        index file directory; default current\n";
    print "       -d <dir>        directory to index;  either -f or -d is required\n";
    print "       -f <dir_list>   file containing list of directories to index; either -f or -d is required\n";
    print "       -l <lookup>     lookup table for file names; required\n";
    print "       -s <stopwords>  file containing words to exclude; default stopwords.txt\n";
    print "       -e <exclude>    file containing directories to exclude\n";
    print "       -p              index pdf files; default NO\n";
    print "       -o              overwrite previous database installation; default NO\n";
    print "       -r              index reference section of HTML files; default NO\n";
    exit(0);
}

my $pref='';
if($opts{i}) {
    $pref=$opts{i}."/";
}
if (-e $pref."ixw.bdb") {
    if ($opts{o}) {
	unlink $pref."ixw.bdb", $pref."ixp.bdb", $pref."ixd.bdb";
    }
    else {
	print "Index files already exist. They have to be removed first.\n";
	exit;
    }
}


my @exclude;
if ($opts{e}) {
    open (IN, "<$opts{e}") || die "cannot open $opts{e} : $!\n";
    while (<IN>) {
	chomp;
	next unless $_;
	push @exclude, $_;
    }
    close IN;
}

my $ix;
if ($opts{i}) {
    $ix = new Search::Indexer(dir => $opts{i}, writeMode => 1, stopwords => $opts{s});
}
else {
    $ix = new Search::Indexer(writeMode => 1, stopwords => $opts{s});
}

my @allfilestmp;
my @dirs;
if ($opts{d}) {
    @allfilestmp = `ls -R $opts{d}`;
}
else {
    open (IN, "<$opts{f}") || die "cannot open $opts{f} : $!\n";
    while (<IN>) {
	chomp;
	next unless $_;
	my @tmp = `ls -R $_`;
	push @dirs, $_;
	push @allfilestmp, @tmp;
    }
    close IN;
}

my $pathtmp;
my @allfiles=();
foreach (@allfilestmp) {
    chomp;
    next unless $_;
    if (/\:$/) {
	$pathtmp=$_;
	$pathtmp=~s/\://g;
	if (@exclude) {
	    foreach (@exclude) {
		if ($pathtmp=~/$_/) {
		    $pathtmp='';
		    last;
		}
	    }
	}
	next;
    }

    next unless $pathtmp;
    if ($opts{p}) {
	next unless  (/\.html$/i or /\.htm$/i or /\.pdf$/i);
    }
    else {
	next unless  (/\.html$/i or /\.htm$/i);
    }
    push @allfiles, "$pathtmp/$_";
}

foreach (@allfiles) {
    $_=~s/\/\//\//g;
}

if (!@allfiles) {
    print "no files found in $opts{d}\n" if $opts{d};
    print "no files found in ", join ("; ", @dirs), "\n" if $opts{f};
    exit;
}

print scalar @allfiles, " found in $opts{d}\n" if $opts{d};
print scalar @allfiles, " found in ", join ("; ", @dirs), "\n" if $opts{f};


my $i=0;
my $j=0;
my %file_hash=();
my %doc_hash=();
my %section_hash=();
my %title_hash=();
my %doi_hash=();
foreach my $f (sort {SortExt($a, $b)} @allfiles) {
    my $content;
    my $section='';
    my $filenameroot=$f=~/([^\/]+)\.[^\.]+$/ ? $1 : $f;
    my $filename=$f=~/([^\/]+$)/ ? $1 : $f;
    $content=$filename;    #include filename in content
    if ($f=~/\.html$/i or $f=~/\.htm$/i) {
	open (FILE, "<$f") || die "cannot open $f : $!\n";
	my $doi='';
	while (<FILE>) {
	    if (/doi\/(.+\/wormbook[\.\d]+)/) {
		$doi=$1;
		last;
	    }
	}
	seek(FILE, 0, 0);
	$content.=" $doi ";
	my $tmp_f=$f;
	my $title=$f;
	my $intitle=0;
	while (<FILE>) {
	    chomp;
	    next unless $_;
	    if (/<title.*>(.*)<\/title>/) {
		$title=$1;
	    }
	    elsif (/<title.*>(.*)/) {
		$title=$1;
		$intitle=1;
	    }
	    elsif ($intitle) {
		if (/(.*)<\/title>/) {
		    $title.=" ".$1;
		    $intitle=0;
		}
		else {
		    $title.=" ".$_;
		}
	    }
	    if (/<h2.*<a\s+name=\"(.*)\"><\/a>(.*)/) {
#		print "$_\n";
		my $tmp=$1;
		my $prev_section=$section;
		my $skip_section=0;
		unless ($opts{r}) {
		    if ($prev_section && ($prev_section=~/references/i || $prev_section=~/bibliography/i)) {
			$skip_section=1;
		    }
		}
		unless ($skip_section) {
		    if ($section) {
			$section_hash{$i}{title}=$title;
			$section_hash{$i}{section}=$section;
		    }
		    else {
			$section_hash{$i}{title}=$title;
			$section_hash{$i}{section}='';
		    }
		}
#		print "$section_hash{$i}\n";
		$section=$2;
		$section=~s/&nbsp;/ /gs;
#		print "$section\n";
		unless ($skip_section) {
		    $content=~s/<.*?>/ /gs;
		    $content=~s/\t/ /g;
		    $content=~s/\s{2,}/ /g;
		    $ix->add($i, $content);
		    $file_hash{$i}=$tmp_f;
		    $doc_hash{$i}=$content;
		    $i++;
		}
		$tmp_f=$f."#".$tmp;
#		print "$tmp_f\n";
		$content="$doi ";
	    }
	    $content.=$_." ";
	}
	close FILE;
	my $prev_section=$section;
	my $skip_section=0;
	unless ($opts{r}) {
	    if ($prev_section && ($prev_section=~/references/i || $prev_section=~/bibliography/i)) {
		$skip_section=1;
	    }
	}
	unless ($skip_section) {
	    $content=~s/<.*?>/ /gs;
	    $content=~s/\t/ /g;
	    $content=~s/\s{2,}/ /g;
	    $ix->add($i, $content);
	    $file_hash{$i}=$tmp_f;
	    $doc_hash{$i}=$content;
	    if ($section) {
		$section_hash{$i}{title}=$title;
		$section_hash{$i}{section}=$section;
	    }
	    else {
		$section_hash{$i}{title}=$title;
		$section_hash{$i}{section}='';
	    }
	    $i++;
	}
	$title_hash{$filenameroot}=$title;
	$doi_hash{$filenameroot}=$doi;
	
    }
    elsif ($f=~/\.pdf$/i) {
	print "converting to text: $f\n";
	if ($doi_hash{$filenameroot}) {
	    $content.=" $doi_hash{$filenameroot} ";
	}
	$content.=`ps2ascii $f 2>&-`;  # 2>&- close std error output - do not print ps2ascii errors
	$content=~s/\//g;   # gets rid of a non-printable character generated by ps2ascii after page numbers
	$ix->add($i, $content);
	$file_hash{$i}=$f;
	$doc_hash{$i}=$content;
	my $title=$f=~/([^\/]+$)/ ? $1 : $f;
        if ($title_hash{$filenameroot}) {
	    $title=$title_hash{$filenameroot};
	}
	$section_hash{$i}{title}=$title;
	$section_hash{$i}{section}='';
	$i++;
    }
    else {
	next;
    }
    $j++;

    if ($j % 100 == 0) {
	print "$j files processed\n";
    }
}

my $tmpout=$pref.$opts{l}."\.name";
store \%file_hash, $tmpout || die "cannot store file_hash in $tmpout : $!\n";
$tmpout=$pref.$opts{l}."\.content";
store \%doc_hash, $tmpout || die "cannot store dos_hash in $tmpout : $!\n";
$tmpout=$pref.$opts{l}."\.sections";
store \%section_hash, $tmpout || die "cannot store section_hash in $tmpout : $!\n";
print "$j files indexed\n";
print "$i sections generated\n";


sub SortExt {
    my $a=shift;
    my $b=shift;
    my $aext=$a=~/([^\.]+$)/ ? $1 : $a;
    my $bext=$b=~/([^\.]+$)/ ? $1 : $b;
    return $aext cmp $bext;
}		   
		   
		   
		       
		       
		       
