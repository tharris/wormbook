This is the official WormBook gihub repository.

Omitted directories.

Please note that the following directories are NOT included
under version control due to their size.

  html/wbg/
  html/WBG/
  html/pdf/
  html/chapters/
  html/downloads/
  html/access_statistics/
  html/wli/
  html/zip_archive/mkdir wordpress-x.x.x


Upgrading WordPress

Because we have customized WordPress to use it for the WBG,
special care must be taken when upgrading. Here's a (partial) summary
of command line tasks when upgrading to a new version of WordPress.

  cd wordpress-x.x.x
  cp -r ../wordpress/i .
  cp -r ../wordpress/archives .
  cp -r ../wordpress/avery .
  cp -r ../wordpress/pdf .
  cp -r ../wordpress/uploads .
  cp -r ../wordpress/volumes .
