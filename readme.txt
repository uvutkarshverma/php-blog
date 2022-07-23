Complete Blog Website in Html  Css Javacript for frontend and php amd mysql for backend .

This website have admin panel for login user to post the content on to the website .












This is Readme file for the website qnastop.com.
this file provide information about hoe to write post on qnastop.com 


TYoutube video == .yt
img == .imga
text-align center  == .align-c
give heading with p tag == .heading-p
<hr>
.message === for message 
.fail == for red color 
.success  ==  green color color
.btn-blue == for blur main button 
.m-auto  == for margin auto 


.htaccess for this 


Options +FollowSymlinks
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*)$ $1.php

# Return 404 if original request is .php
RewriteCond %{THE_REQUEST} "^[^ ]* .*?\.php[? ].*$"
RewriteRule .* - [L,R=404]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^([a-zA-Z0-9_-]+)$ post.php?id=$1 [QSA,L]