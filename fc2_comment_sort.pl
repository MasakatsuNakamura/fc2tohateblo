#!C:/perl/bin/perl.exe

die if ($#ARGV < 0);
open (FILE, "$ARGV[0]") || die;

$incomment = 0;
$buffer = "";
%buffer = ();

while ($line = <FILE>) {
	if ($line =~ /^(COMMENT:|PING:)/) {
		$buffer{$date} = $buffer;
		$buffer = "";
		$incomment = 1;
	} elsif ($line =~ /^--------/) {
		$buffer{$date} = $buffer;
		$buffer = "";
		foreach(sort { (substr($a, 6, 4) . "/" . substr($a, 0, 5) . substr($a, 11, 8)) cmp (substr($b, 6, 4) . "/" . substr($b, 0, 5) . substr($b, 11, 8))} keys %buffer){
		    print $buffer{$_};
		}
		%buffer = ();
		$incomment = 0;
	}
	if ($incomment == 1) {
		$buffer .= $line;
		if ($line =~ /^DATE: /) {
			($date) = ($line =~ /^DATE: (.*)$/);
		}
	} else {
		print $line;
	}
}
