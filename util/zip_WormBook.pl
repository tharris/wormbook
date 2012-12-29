#!/usr/local/bin/perl -w


=head1 NAME

zip_WormBook.pl - a script to create/update the WormBook zip archive

=cut

use strict;
use warnings;
use File::Basename;
use File::Copy;
use File::Find;
use File::Path;
use Time::localtime;
use Mail::Mailer;
use Cwd ();

my $start_time = time();
my $start_cputime = times();
my $cwd = Cwd::cwd();

# for the convenience of &wanted calls, including -eval statements:
use vars qw/*name *dir *prune/;
*name   = *File::Find::name;
*dir    = *File::Find::dir;
*prune  = *File::Find::prune;

sub wanted;
sub doexec ($@);

# Calculate a timestamp, used for naming the archive.
my $date = `date +%Y-%m-%d`;
chomp $date;
my $home       = '/home/tharris70';
my $doc_root   = "$home/domains/www.wormbook.org/html";
my $zip_target = "$doc_root/zip_archive/WormBook_$date";

# Create the zip target that will contain mirrored files.
mkdir $zip_target,            0755 or warn "Cannot make $zip_target: $!";
mkdir "$zip_target/chapters", 0755 or warn "Cannot make $zip_target/chapters: $!";

my $oldfile = "$doc_root/toc_complete.html";
my $newfile = "$zip_target/README.html";
copy($oldfile, $newfile) or die "File ($oldfile) can not be copied to $newfile";

undef $/;   # slurps whole file at once
open (README, "<", $newfile) or die "Can't open $newfile for reading: $!";

my $readme = <README>;

#  remove html entries
$readme =~ s#\s*?<a class=\"avail\".+?>html</a>##gi;

#  make url relative to current directory and remove chapter directory names
$readme =~ s#\"\/chapters.*\/(\w+)\.pdf\"#\"$1\.pdf\"#gi;
$readme =~ s#(<a\s+class=\"(avail|preprint)\"\s+href=\")#$1chapters\/#ig;

# remove all commenting
$readme =~ s/<!--.*?-->//sg;

# remove extra garbage
my $junk = '<link rel="shortcut icon" href="favicon.ico" />'.
            '\s*'.
            '<script language="JavaScript"  src="/js/highlightTerms.js"></script>'.
            '\s*'.
            '<script type="text/javascript" src="../js/pde.js"></script>';

$readme =~ s/$junk//gi;

my $readme_info = <<HERE;
      <h2>WormBook Table of Contents</h2>
      <h4>Archive date (year_month_day): $date</h4>
      <h4>Contact: Daniel Wang &lt;qwang\@its.caltech.edu&gt;, WormBase, Caltech under Professor Paul Steinberg</h4>
HERE

$readme =~ s/<body.*?>/<body>\n$readme_info\n/;

my $readme_css = <<HERE;
         <style type="text/css">
         <!--
              p a    {color:  rgb(162, 72, 163); font-size: 1.1em }
              body {font-family:  sans-serif; line-height: 1.2 }
         -->
         </style>
HERE

$readme =~ s/<\/head>/$readme_css\n<\/head>\n/;

# remove <div> tags
$readme =~ s/<\/div>//g;
$readme =~ s/<div.*?>//g;

# clean up spacing  ?: clusters w/o capturing                                                                                            
$readme =~ s/\n(?:\s*?\n)+/\n\n/g;

open (README, ">", $newfile) or die "Can't open $newfile for writing: $!";
print README $readme or die "Can't print to $newfile: $!";
print "***\n\nREADME file completed\n\n";

# Traverse desired filesystems  & copy pdf's to zip directory
File::Find::find({wanted => \&wanted}, "$doc_root/chapters/");
print "***\n\npdf files moved\n\n";

# Make zip file : zip -r WormBook WormBook [1st arg - archive name, 2nd arg - dir name]
chdir "$doc_root/zip_archive" or die "Can't cd to $doc_root/zip_archive: $!";
my $zipoutput = `zip -r WormBook_$date WormBook_$date`;

if ( -l "$doc_root/WormBook.zip") {
    unlink "$doc_root/WormBook.zip" or die "Can't remove pre-existing symlink: $!";
}

symlink ( "zip_archive/WormBook_$date\.zip", "$doc_root/WormBook.zip" )
    or die "Can't symlink to new zip file: $!";
print "***\n\nnew symlink created\n\n";

# Delete temporary directory 
my $files_removed = rmtree("$doc_root/zip_archive/WormBook_$date");
print "***\n\nNumber of files deleted : $files_removed\n\n";

send_email($zipoutput);


# display run time
my $end_time = time();
my $end_cputime = times();

if ($end_time - $start_time > 1) {
    print "Script runtime : ", ($end_time - $start_time), " seconds\n\n";
    printf "Script took %.2f CPU seconds of user time\n\n\n", $end_cputime - $start_cputime;
}

exit;


sub wanted {
    /^.*\.pdf\z/s &&
	doexec(0, 'cp','{}',"$zip_target/chapters/");
}


sub doexec ($@) {
    my $ok = shift;
    my @command = @_; # copy so we don't try to s/// aliases to constants
    for my $word (@command)
    { $word =~ s#{}#$name#g }
    if ($ok) {
	my $old = select(STDOUT);
	$| = 1;
	print "@command";
	select($old);
	return 0 unless <STDIN> =~ /^y/;
    }
    chdir $cwd; #sigh
    system @command;
    chdir $File::Find::dir;
    return !$?;
}


sub send_email {
    my $zipoutput = shift;
    my $mailer = Mail::Mailer->new;
    $mailer->open({ From    => 'WormBook Admin <wormbook-help@wormbase.org>',
		    To      => 'WormBook Admin <wormbook-help@wormbase.org>',
		    Subject => 'WormBook zip file updated',
		  })
	or die "Can't open: $!\n";
    print $mailer $zipoutput;
    $mailer->close();
    
    print "***\n\nemail sent to wormbook-help\n\n";
}







