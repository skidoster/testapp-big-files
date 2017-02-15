TASK:

1: We need a PHP script to be executed on the command line, that will read text from a file and use a MySQL database to record all distinct unique words in the text given.

An example use of the program could be:
-------------------------------------
$ php wordcount.php big.txt
-------------------------------------

You must supply the PHP script and the SQL statements for creating the database schema.

2: The PHP script must print the number of distinct unique words that have been recorded in the database, when it is done processing the file.

So, given a file with the short text "a horse and a dog", the following could be an example of an invocation of the program and its
output:
-------------------------------------
$ php wordcount.php small.txt
Distinct unique words: 4
-------------------------------------

3: Now add a "watchlist" table to the database. This table will hold words which are of special interest to us.  Assuming that we have filled in a small number of words in this table, we now want the PHP script to print which words from the "watchlist" also exist in the total list of distinct unique words.

Assuming our "watchlist" contains the words "horse", "zebra", "dog"
and "elephant", an example session with the program could look like:
-------------------------------------
$ php wordcount.php small.txt
Distinct unique words: 4
Watchlist words:
horse
dog
-------------------------------------


Notes for the assignment:

# We just need the final PHP program and database schema from section
  3 above. No need to submit solutions from sections 1 and 2.

# Assume that very large texts will be processed, possibly in many
  languages. Therefore, efficient handling of a very large number of
  distinct unique words will be important. It is not acceptable to
  store the full texts in the database.

# The watchlist will be small in comparison - assume that it will
  contain tens or hundreds of words.

# You may choose to ignore character case, or not ignore it. It is not
  important for the assignment.

# You are free to define the database schema any way you please - the
  only concern is the efficient processing of large texts.
