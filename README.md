iTC Localized Screenshot Uploader
=================================

This script helps prepare localized screenshots for delivery to iTunes Connect via the Transporter. Screenshot generation, formatting, and uploading can be fully automated with these instructions.

***

#### Step 1
Download your app's metadata package from Apple. 

    PATH="$PATH:/Applications/Xcode.app/Contents/Applications/Application Loader.app/Contents/MacOS/itms/bin/"
    iTMSTransporter -m lookupMetadata -u [iTunes Connect user name] -p [iTunes Connect password] -vendor_id [App SKU] -destination ~/Desktop

This will save the .itmsp file to your desktop.

#### Step 2
Take screenshots & save them to `~/Desktop/screenshots` with the format like `cmn-Hans___ios4in___portrait___screen1.png`. The correct device names are `Mac`, `iOS-3.5-in`, `iOS-4-in` or `iOS-iPad` `ios35in`, `ios4in`, and `ipad`. The orientation part is optional. ((HELP: WHERE IS APPLE DOCUMENTATION ON LOCALES IN THIS FORMAT?))

Optional: write a UI script and automate generation of screenshots for all devices and localizations using https://github.com/jonathanpenn/ui-screen-shooter

#### Step 3
Run `php screenshots.php` – this will add the XML chunks you need and make a fresh copy of your `metadata.xml` in the screenshots folder. 

#### Step 4
If you right-click & select 'show package contents' on your itmsp file, you'll see all the pretty metadata in `metadata.xml`. Copy (and replace) all the stuff from the screenshots/ folder into this folder.

#### Step 5
Verify your upload:

    iTMSTransporter -m verify -u [iTunes Connect user name] -p [iTunes Connect password] -vendor_id [App SKU] -f ~/Desktop/*.itmsp
    
Error "software_screenshots cannot be edited in the current state" happens if your app is currently being reviewed.

#### Step 6
If things went well, execute your upload:

    iTMSTransporter -m upload -u [iTunes Connect user name] -p [iTunes Connect password] -vendor_id [App SKU] -f ~/Desktop/*.itmsp
    
***

## Pro Tips
You can modify Xcode schemes to automatically launch your app in a particular localization. I created a scheme for each language I have setup in iTunes Connect. To do this, duplicate your Debug scheme, edit it, and in the "Run" section under "Arguments", add your localization to "Arguments Passed on Launch" in this format: "-AppleLanguages (it)", where "it" is Italian, or whatever localization you want.

On top of that, I wanted localized users for my screenshots, so I pass an Environment Variable of "USER_ID", then grab that in my code & setup the user programmatically. You can get Environment Variables via:
[[NSProcessInfo processInfo] environment]

***

## Heads Up

There's a bug in the Transporter that removes newlines from any textual metadata, so I don't recommend using it for that purpose at this time.

For more info, check out the App Metadata Specs and the Transporter User Guide from https://itunesconnect.apple.com/WebObjects/iTunesConnect.woa/wo/2.0

***

## License
Released under the MIT license, see the LICENSE file.
