itc-localized-screenshot-uploader
=================================

This script helps prepare localized screenshots for delivery to iTunes Connect via the Transporter.

It does *not* take screenshots for you. It is somewhat involved, but ultimately if you have localized screenshots for lots of languages, it should save you time/pain.

Step 1
Take screenshots & place into a folder structure of language/device/position.png (where device is ipad, iphone4, or iphone5). E.g., english/ipad/1.png. Put them all in a directory on your desktop called 'screenshots' (or, update the php script to reflect wherever you want the dir to be).

Step 2
Run screenshots.php – you may need to alter input or output directories.  This will move all your screenshots into ~/Desktop/screenshots_for_upload/, as well as output XML for your metadata.

Step 3
Now you need to grab your metadata package from Apple.  First, grab your package:
$ iTMSTransporter -m lookupMetadata -u [iTunes Connect user
name] -p [iTunes Connect password] -vendor_id [App SKU] -
destination [destination path for App Store Package]

This will download a *.itmsp package for you. If you right-click & select 'show package contents', you'll see 'metadata.xml'. Edit this, and insert your screenshot XML in the corresponding language section.

To clear things up, I like to delete the old version xml chunk in here before uploading. 

Copy your screenshots from ~/Desktop/screenshots_for_upload/ to the package. 

Step 4
Verify your package:
$ iTMSTransporter -m verify -f [path to App Store Package] -u
[iTunes Connect user name] -p [iTunes Connect password]

Step 5
Assuming things went well, upload your package:
$ iTMSTransporter -m upload -f [path to App Store Package] -u
[iTunes Connect user name] -p [iTunes Connect password]


For more info, check out the App Metadata Specs and the Transporter User Guide from https://itunesconnect.apple.com/WebObjects/iTunesConnect.woa/wo/2.0


Pro Tips
You can modify Xcode schemes to automatically launch your app in a particular localization. I created a scheme for each language I have setup in iTunes Connect. To do this, duplicate your Debug scheme, edit it, and in the "Run" section under "Arguments", add your localization to "Arguments Passed on Launch" in this format: "-AppleLanguages (it)", where "it" is Italian, or whatever localization you want.

On top of that, I wanted localized users for my screenshots, so I pass an Environment Variable of "USER_ID", then grab that in my code & setup the user programmatically. You can get Environment Variables via:
[[NSProcessInfo processInfo] environment]


Heads Up
There's a bug in the Transporter that removes newlines from any textual metadata, so I don't recommend using it for that purpose at this time.


Notes
I've only run this myself, so I'm sure there are tons of cases I haven't accounted for.


License
The MIT License (MIT)
Copyright (c) 2013 News.me, Inc.
 
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
