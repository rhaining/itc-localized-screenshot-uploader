. environment.sh

echo "Uploading..."

iTMSTransporter -m upload -u $ITMSUSER -p $ITMSPASS -vendor_id $ITMSSKU -f "$ITMSFOLDERNAME/$ITMSSKU.itmsp"

echo "Done!"
