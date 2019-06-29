<?php
echo 'NEWLINE'."\n";
$line1 = "tt0000001	short	Carmencita	Carmencita	0	1894	\N	1	Documentary,Short";
$line1Pieces = explode("\t", $line1);
foreach ($line1Pieces as $piece)
{
	echo 'piece is:'.$piece."\n";
}

echo 'NEWLINE'."\n";
$line2 = "tt0000002	short	Le clown et ses chiens	Le clown et ses chiens	0	1892	\N	5	Animation,Short";

$line2Pieces = explode("\t", $line2);
foreach ($line2Pieces as $piece)
{
	echo 'piece is:'.$piece."\n";
}
?>

