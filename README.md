# Simple PHP URL Shortener Script

Set up your own url _shortening_ service like [AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA][1].

## Installation

Upload the files to your web directory. Import the sql file and update the database configuration information accordingly.

For **Apache**:

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?q=$1 [QSA,L]

For **Nginx**:

    server {
        location / {
            rewrite ^/(.*)$ /index.php?q=$1;
        }
    }

That's pretty much it. Have fun.

As discussed on [Hacker News][2] and [MetaFilter][3].

[1]: http://aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.com/
[2]: https://news.ycombinator.com/item?id=19511735
[3]: https://www.metafilter.com/180140/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
