GuideStar Client
================

This project provides a client for the GuideStar API. Requires a paid GuideStar account.

Testing
-------

For simple unit tests, do this:
 
# ./phpunit

This will *not* query GuideStar, but will mock GuideStar's responeses using the data 
in tests/files/ instead. To query against the real GuideStar database, do this first:

# cp phpunit-integration.xml.dist phpunit-integration.xml
# nano phpunit-integration.xml

And fill in your GuideStar API key(s) into the environment variables it references. Then
run the tests like so:

# ./phpunit -c phpunit-integration.xml

Have fun!
