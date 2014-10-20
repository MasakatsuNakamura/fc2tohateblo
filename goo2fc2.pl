#!c:/perl/bin/perl.exe
die if ($#ARGV < 0);
$filename = $ARGV[0];
open(FILE, "$filename") || die;

while (<FILE>) {
	chop;
	if ($_ eq "--------") {
		print "\n\n$_\n";
		next;
	} elsif ($_ eq "-----") {
		next;
	} elsif (/^BODY:/) {
		print "-----\nBODY:\n";
		while (<FILE>) {
			chop;
			if ($_ eq "<img src=\"\"><br>") {
				next;
			} elsif ($_ eq "-----") {
				print "\n-----\nEXTENDED BODY:\n\n-----\nEXCERPT:\n\n-----\nKEYWORDS:\n\n-----\n";
				last;
			} else {
				print "$_\n";
			}
		}
	} elsif (/^COMMENT:/) {
		print "COMMENT:\n";
		$author = <FILE>;
		chop ($author);
		$url = <FILE>;
		chop ($url);
		$date = <FILE>;
		chop ($date);
		$title = <FILE>;
		chop ($title);
		$title =~ s/<br>$//;
		print "$author\n";
		print "$url\n";
		print "$date\n";
		print "TITLE: $title\n";
		print "PASS: *\n";
		while (<FILE>) {
			chop;
			s/<[^>]*>//g;
			if ($_ eq "-----") {
				print "\n$_\n";
				last;
			} else {
				print "$_\n";
			}
		}
		next;
	} else {
		print "$_\n";
	}
}
