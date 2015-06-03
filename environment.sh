if [ -f "environment-local.sh" ];
then
	echo "Using local environment variables in environment-local"
	. environment-local.sh
fi

ITMSFOLDERNAME=./itms
ITMSSCREENSHOTSFOLDERRAWNAME="$ITMSFOLDERNAME/screenshots-raw"

PATH="$PATH:/Applications/Xcode.app/Contents/Applications/Application Loader.app/Contents/itms/bin/"

if [ -z "$ITMSUSER" ];
then
	read -p "Username:" ITMSUSER
fi

if [ -z "$ITMSPASS" ];
then
	read -s -p "Password:" ITMSPASS
	echo ""
fi

if [ -z "$ITMSSKU" ];
then
	read -p "SKU:" ITMSSKU
fi

if [ -d "$ITMSFOLDERNAME" ];
then
   echo "Directory $ITMSFOLDERNAME already exists. This might be expected but it might mean old assets lying around"
else
   echo "Making directory $ITMSFOLDERNAME for the itmsp package"
   mkdir $ITMSFOLDERNAME
fi

if [ -d "$ITMSSCREENSHOTSFOLDERRAWNAME" ];
then
   echo "Directory $ITMSSCREENSHOTSFOLDERRAWNAME already exists. This might be expected but it might mean old screenshots lying around"
else
   echo "Making directory $ITMSSCREENSHOTSFOLDERRAWNAME for the screenshots"
   mkdir $ITMSSCREENSHOTSFOLDERRAWNAME
fi
