# php-codfish
##Purpose##
This repository supports a library for handling large datasets.
It is an experimental library, just exploring different ways
of dealing with this problem.

Of primary consideration was to explore PHP references in a manner
to produce 'linked lists', which are more common in c/c++.

##Inspiration##
The inspiration for this is a programming problem I encountered
for an interview.  It is known as the 'longest film' title problem.

In this problem, a file composed of 1 or more records, where each
record is found on one line of the file.  Each record corresponds
to a movie.

One or more fields in each record has a movie title.  The problem
is to produce the largest concatenation of a number of movie titles
to find which is the largest that can be produced.  Trivial initial
and ending words are discarded when forming the longest title.

##Why Codfish##
I enjoy catching and eat Codfish.  In prior centuries, the sheer
multitude of this fish in the north Atlantic, made me think of
large datasets.

##Status##
This code is in draft format but its coming along.  As it continues
I will attempt to keep this updated, and try to present candid
opinion of its status.  Since its represented on github and packagist,
all are welcome to check it out!  A documentation folder will be
added so anyone wanted to use this can get good guidance without
reverse engineering.
