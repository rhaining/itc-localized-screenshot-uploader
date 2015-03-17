ITMSFOLDERNAME=./itms
ITMSSCREENSHOTSFOLDERNAME="$ITMSFOLDERNAME/screenshots"
PATH="$PATH:/Applications/Xcode.app/Contents/Applications/Application Loader.app/Contents/MacOS/itms/bin/"

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

if [ ! -f "$ITMSFOLDERNAME" ];
then
   echo "Directory $ITMSFOLDERNAME already exists. This might be expected but it might mean old assets lying around"
else
   echo "Making directory $ITMSFOLDERNAME for the itmsp package"
   mkdir $ITMSFOLDERNAME
fi

if [ ! -f "$ITMSSCREENSHOTSFOLDERNAME" ];
then
   echo "Directory $ITMSSCREENSHOTSFOLDERNAME already exists. This might be expected but it might mean old screenshots lying around"
else
   echo "Making directory $ITMSSCREENSHOTSFOLDERNAME for the screenshots"
   mkdir $ITMSSCREENSHOTSFOLDERNAME
fi
