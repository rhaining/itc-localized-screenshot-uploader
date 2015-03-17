. environment.sh

echo "Ensuring screenshots are in place..."

cp -v -f "$ITMSSCREENSHOTSFOLDERNAME"/*.png "$ITMSFOLDERNAME/$ITMSSKU.itmsp/"

echo "Verifying..."

iTMSTransporter -m verify -u $ITMSUSER -p $ITMSPASS -vendor_id $ITMSSKU -f "$ITMSFOLDERNAME/$ITMSSKU.itmsp"
